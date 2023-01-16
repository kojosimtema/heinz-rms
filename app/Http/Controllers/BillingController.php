<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\PrepareBills;
use App\Jobs\PrepareBillByCategory;
use App\BillSetting as Setting;
use App\Jobs\BillFix;

use App\Http\Controllers\SetupController as Setup;

use App\WebClientPrint\WebClientPrint;
use App\WebClientPrint\Utils;
use App\WebClientPrint\DefaultPrinter;
use App\WebClientPrint\InstalledPrinter;
use App\WebClientPrint\PrintFile;
use App\WebClientPrint\ClientPrintJob;

use Session;
use Cloudder;


class BillingController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    public function fixingBill (){

        $year = 2022;
        $newYear = $year - 1;
       $bills = \App\Bill::where('year', $year)->where('p_year_total_paid', '>', 0)->where('yt', 0)->paginate(200);

       foreach ($bills as $key => $bill) {
            $first_year = \App\Bill::where('account_no',  $bill->account_no)->where('year', $year)->first();
            $second_year = \App\Bill::where('account_no',  $bill->account_no)->where('year', $newYear)->first();

            if($second_year):
                $second_year->total_paid = $first_year->p_year_total_paid;
                $second_year->save();

                $second_year->account_balance = floatval($second_year->arrears + $second_year->rate_imposed) - floatval($second_year->total_paid);
                $second_year->save();

                $first_year->arrears = $second_year->account_balance;
                $first_year->original_arrears = $second_year->account_balance;

                $first_year->save();

                $first_year->account_balance = floatval($first_year->arrears + $first_year->rate_imposed) - floatval($first_year->total_paid);
                $first_year->yt = 1;
                $first_year->save();
            endif;


       }

        dd("processing");
    }

    public function processing()
    {
        return view('console.billing.processing');
    }

    public function propertyBillPrepare()
    {
        return view('console.billing.property.prepare-bills');
    }
    public function propertyBillPrepareBulk()
    {
        $bills = [];
        $tag = '';
        $view = env('ASSEMBLY_CODE') == 'KKMA' ? 'console.billing.property.bulk-print' : 'console.billing.property.t';
        $setting = Setting::latest()->first();
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        return view($view, compact('bills', 'setting', 'wcpScript', 'tag'));
    }
    public function businessBillPrepareBulk()
    {
        $bills = [];
        $tag = '';
        $setting = Setting::latest()->first();
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        return view('console.billing.business.bulk-print', compact('bills', 'setting', 'wcpScript', 'tag'));
    }

    public function filterBillsQuery(Request $request, $query = null)
    {
        // dd($request->all());
        $setting = Setting::latest()->first();
        $tag = '';
        $view = $request->bill_type == 'p' ? ((env('ASSEMBLY_CODE') == 'KKMA') ? 'console.billing.property.bulk-print' : 'console.billing.property.t') : 'console.billing.business.bulk-print';
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        if ($request->account_no) :
            $tag = '';
            $bills = \App\Bill::where('account_no', $request->account_no)->where('bill_type', 'LIKE', "%{$request->bill_type}%")->where('year', $request->year)->get();

            return view($view, compact('bills', 'setting', 'wcpScript', 'tag'));
        endif;
        if ($request->electoral_id) :
            $tag = \App\Models\Location\Electoral::where('code', $request->electoral_id)->pluck('description');
            $bills = \App\Bill::where('electoral_id', $request->electoral_id)->where('bill_type', $request->bill_type)->where('year', $request->year)->orderBy('account_no', 'asc')->get();
            // dd($bills);
            return view($view, compact('bills', 'setting', 'wcpScript', 'tag'));
        endif;
        if ($request->community_id) :
            $tag = \App\Models\Location\Community::where('code', $request->community_id)->pluck('description');
            $bills = \App\Bill::where('community_id', $request->community_id)->where('bill_type', $request->bill_type)->where('year', $request->year)->orderBy('account_no', 'asc')->get();
            // dd($bills);
            return view($view, compact('bills', 'setting', 'wcpScript', 'tag'));
        endif;
        if ($request->category) :
            $tag = \App\PropertyCategory::where('code', $request->category)->pluck('description');
            if ($request->bill_type == 'p') {
                $properties = \App\Property::where('property_category', $request->category)->orderBy('property_no', 'asc')->pluck('property_no');
                // dd($properties);
                $bills = \App\Bill::whereIn('account_no', $properties)->where('year', $request->year)->orderBy('electoral_id', 'asc')->get();
            }
            if ($request->bill_type == 'b') {
                $businesses = \App\Business::where('business_category', $request->category)->orderBy('business_no', 'asc')->pluck('business_no');
                // dd($properties);
                $bills = \App\Bill::whereIn('account_no', $businesses)->where('year', $request->year)->orderBy('electoral_id', 'asc')->get();
            }

            // dd($tag,$properties,$bills);
            // $bills = \App\Bill::where('electoral_id', $request->electoral_id)->where('bill_type', $request->bill_type)->where('year', $request->year)->orderBy('account_no', 'asc')->get();
            // dd($bills);
            return view($view, compact('bills', 'setting', 'wcpScript', 'tag'));
        endif;
        return redirect()->back();
    }

    public function adjustArrearsP()
    {
        return view('console.billing.adjust-arrears-property');
    }
    public function adjustArrearsB()
    {
        return view('console.billing.adjust-arrears-business');
    }
    public function postAdjustArrears(Request $request)
    {
        $adjustedValue = (float) $request->adjust_arrears;
        $max = \App\Bill::where('account_no', $request->account_no)->max('year');
        $bill = \App\Bill::where('account_no', $request->account_no)->where('year', $max)->first();
        $adjustTable = \App\AdjustArrears::create([
            'account_no' => $request->account_no,
            'bill_year' => (string)(intval($bill->year) - 1),
            'amount' => $adjustedValue,
            'adjusted_by' => auth()->user()->name . '-' . auth()->user()->user_id,
            'bill_type' => $bill->bill_type,
            'date' => date("m-d-y")
        ]);
        if ($adjustTable) :
            $bill->adjust_arrears = (float)$bill->adjust_arrears + (float)$request->adjust_arrears;
            $bill->update();
        endif;
        return redirect()->back();
    }


    public function propertyBills()
    {
        $bills = session()->get('bills');
        // if(!$bills) $bills = \App\Bill::with(['property', 'business'])->where('bill_type', 'p')->where('year', date("Y"))->orderBy('account_no', 'asc')->paginate(50);
        if (!$bills) $bills = \App\Bill::with(['property', 'business'])->orderBy('account_no', 'asc')->paginate(50);
        // dd($bills);
        return view('console.billing.property', compact('bills'));
    }

    public function filterBillsByColumn(Request $request)
    {

        $query = '';
        $queryArray = [];
        $businesses = [];
        $array = null;
        $reqs = $request->validate(['column' => 'required', 'query' => '']);

        switch ($request->column) {
            case 'account_no':
                $query = $reqs['query'];
                break;
            case 'owner_name':
                $query = $reqs['query'];
                break;
            case 'phone_number':
                $queryArray = \App\PropertyOwner::where('phone', 'LIKE', "%{$reqs['query']}%")->pluck('code');
                break;
            case 'account_type':
                $query = $reqs['query'];
                break;
            case 'account_category':
                $query = $reqs['query'];
                break;
            case 'year':
                $query = $reqs['query'];
                break;

            default:
                $query = '';
                break;
        }



        $bills = \App\Bill::with(['property', 'business'])->where($request->column, 'LIKE', "%{$query}%")->paginate(50);

        return view('console.billing.property', compact('bills'));
    }


    public function postBills(Request $request)
    {
        // dump($request->all());
        PrepareBills::dispatch($request->all());
        // dd('p');
        return redirect()->route('processing');
    }

    public function postBillsPerUnit(Request $request)
    {
        // dd($request->all());
        if ($request->account_no == '' || $request->account_no == null) return redirect()->back()->with('Error', 'Account no can\'t be empty');
        $data = $request->validate(['account_no' => 'required']);
        if (strtolower($request->account) == strtolower('property')) :
            $property = \App\Property::where('property_no', $request->account_no)->first();
            if (!$property) return redirect()->back()->with('Error', 'Account not found!');
            $response = self::initPropertyBill($property, $request->feefixing, $request->year);
            if ($response) :
                return redirect()->back()->with('success', 'Bill successfully generated');
            else :
                return redirect()->back()->with('Error', 'Error in generating bill');
            endif;
        endif;
        if (strtolower($request->account) == strtolower('business')) :
            $business = \App\Business::where('business_no', $request->account_no)->first();
            if (!$business) return redirect()->back()->with('Error', 'Account not found!');
            $response = self::initBusinessBill($business, $request->feefixing, $request->year);
            if ($response) :
                return redirect()->back()->with('success', 'Bill successfully generated');
            else :
                return redirect()->back()->with('Error', 'Error in generating bill');
            endif;
        endif;
    }

    public function postBillsPerCategory(Request $request)
    {
        PrepareBillByCategory::dispatch($request->all());
        return redirect()->route('processing');
    }

    public static function initPropertyBill($property, $feefixing, $year)
    {
        // dd($property, $feefixing, $year);
        if ($feefixing === date("Y")) :
            $results = self::checkModelCategory($property, "property");
            if ($results) {
                $results = array_merge($results, [
                    'zonal_id' => $property->zonal_id ?: '', 'tas_id' => $property->tas_id ?: '',
                    'electoral_id' => $property->electoral_id ?: '', 'community_id' => $property->community_id ?: '',
                    'property_type' => $property->property_type ?:'', 'property_category' => $property->property_category ?:''
                ]);
                $billResults = self::prepareBill($property->property_no, "p", $year, $results);
            };
        else :
            //not current fee fixing
            $results = self::checkFeefixingModelCategory($property, "property", $feefixing);
            if ($results) {
                $results = array_merge($results, [
                    'zonal_id' => $property->zonal_id ?: '', 'tas_id' => $property->tas_id ?: '',
                    'electoral_id' => $property->electoral_id ?: '', 'community_id' => $property->community_id ?: '',
                    'property_type' => $property->property_type ?:'', 'property_category' => $property->property_category ?:''
                ]);
                $billResults = self::prepareBill($property->property_no, "p", $year, $results);
            };
        endif;

        return true;
    }

    public static function initBusinessBill($business, $feefixing, $year)
    {
        if ($feefixing === date("Y")) :
            $results = self::checkModelCategory($business, "business");
            if ($results) {
                $results = array_merge($results, [
                    'zonal_id' => $business->zonal_id ?: '', 'tas_id' => $business->tas_id ?: '',
                    'electoral_id' => $business->electoral_id ?: '', 'community_id' => $business->community_id ?: '',
                    'business_type' => $business->business_type ?:'', 'business_category' => $business->business_category ?:''
                ]);
                $billResults = self::prepareBill($business->business_no, "b", $year, $results);
            };
        else :
            //not current fee fixing
            $results = self::checkFeefixingModelCategory($business, "business", $feefixing);
            if ($results) {
                $results = array_merge($results, [
                    'zonal_id' => $business->zonal_id ?: '', 'tas_id' => $business->tas_id ?: '',
                    'electoral_id' => $business->electoral_id ?: '', 'community_id' => $business->community_id ?: '',
                    'business_type' => $business->business_type ?:'', 'business_category' => $business->business_category ?:''
                ]);
                $billResults = self::prepareBill($business->business_no, "b", $year, $results);
            };
        endif;

        return true;
    }

    public static function checkModelCategory($model, $type)
    {
        $params = [];
        $response;
        if (strtolower($type) == "property") :
            // dd($model);
            // dd($model->category);
            if (!$model->category) {
                $response = $model->property_no;
                $z = \App\PropertyCategory::where('code', 'LIKE', "%{$model->property_category}%")->first();
                if (!$z) return false;
                if (!floatval($z->min_charge)) return false;
                $params = array_merge($params, [
                    'min_charge' => floatval($z->min_charge),
                    'rate_pa' => floatval($z->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
            } else {
                $params = array_merge($params, [
                    'min_charge' => floatval($model->category->min_charge),
                    'rate_pa' => floatval($model->category->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
            }
        endif;

        if (strtolower($type) == "business") :
            if (!$model->category) {
                $response = $model->business_no;
                $z = \App\BusinessCategory::where('code', 'LIKE', "%{$model->business_category}%")->first();
                if (!$z) return false;
                $params = array_merge($params, [
                    'min_charge' => floatval($z->min_charge),
                    'rate_pa' => floatval($z->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
                if (!floatval($z->min_charge)) dd('ol');
                // dd($params);
            } else {
                $params = array_merge($params, [
                    'min_charge' => floatval($model->category->min_charge),
                    'rate_pa' => floatval($model->category->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
            }
        endif;

        return $params;
    }

    public static function checkFeefixingModelCategory($model, $type, $feefixing)
    {
        $params = [];
        $response;

        if (strtolower($type) == "property") :
            $category = \App\PropertyFeefixingCategory::where('code', $model->property_category)->where('year', $feefixing)->first();
            if (!$category) {
                $response = $model->property_no;
                $z = \App\PropertyFeefixingCategory::where('code', 'LIKE', "%{$model->property_category}%")->where('year', $feefixing)->first();
                if (!$z) return false;
                $params = array_merge($params, [
                    'min_charge' => floatval($z->min_charge),
                    'rate_pa' => floatval($z->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
                if (!$z->min_charge) dd('ol');
                // dd($params);
            } else {
                $params = array_merge($params, [
                    'min_charge' => floatval($category->min_charge),
                    'rate_pa' => floatval($category->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
            }
        endif;

        if (strtolower($type) == "business") :
            $category = \App\BusinessFeefixingCategory::where('code', $model->business_category)->where('year', $feefixing)->first();
            if (!$category) {
                $response = $model->property_no;
                $z = \App\PropertyFeefixingCategory::where('code', 'LIKE', "%{$model->business_category}%")->where('year', $feefixing)->first();
                if (!$z) return false;
                $params = array_merge($params, [
                    'min_charge' => floatval($z->min_charge),
                    'rate_pa' => floatval($z->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
                if (!$z->min_charge) dd('ol');
                // dd($params);
            } else {
                $params = array_merge($params, [
                    'min_charge' => floatval($category->min_charge),
                    'rate_pa' => floatval($category->rate_pa),
                    'rateable_value' => floatval($model->rateable_value)
                ]);
            }
        endif;

        return $params;
    }

    public static function prepareBill($account, $type, $year, $params)
    {

        $imposed = floatval($params['rate_pa']);
        $amount = floatval($params['rateable_value']) * $imposed;
        $ans = $amount > $params['min_charge'] ? $amount : $params['min_charge'];
        $previousBill = \App\Bill::where('account_no', $account)->where('year', (string)(intval($year) - 1))->first();
        $arrears = $previousBill ? floatval($previousBill->account_balance) : floatval(0);
        $totalPaid = \App\Payment::where('account_no', $account)->where('payment_year', $year)->sum('amount_paid');
        // $lastYearTotalPaid = \App\Payment::where('account_no', $account)->where('payment_year', (string)(intval($year) - 1))->sum('amount_paid');
        $lastYearTotalPaid = \App\Payment::where('account_no', $account)->where('payment_year', (string)(intval($year) - 1))->sum('amount_paid');
        $lastYearBill = $previousBill ? floatval($previousBill->rate_pa) : floatval(0);
        $lastYearArrears = $previousBill ? floatval($previousBill->arrears) : floatval(0);
        unset($params['rate_pa']);

        $bill = array_merge($params, [
            'account_no' => $account,
            'account_balance' => number_format(floatval(($ans + $arrears) - $totalPaid), 2, '.', ''), 'arrears' => $arrears, 'current_amount' => $ans,
            'bill_type' => $type, 'prepared_by' => 'admin', 'year' => $year, 'bill_date' => Carbon::now()->toDateString(), 'rate_imposed' => $imposed,
            'rate_pa' => number_format((float)$ans, 2, '.', ''), 'total_paid' => number_format((float)$totalPaid, 2, '.', ''), 'p_year_bill' => $previousBill ? ($lastYearBill + $lastYearArrears - floatval($previousBill->adjust_arrears)) : floatval(0),
            'p_year_total_paid' => $lastYearTotalPaid, 'printed' => 0, 'original_arrears' => $arrears
        ]);
        unset($bill['min_charge']);

        $billRes = \App\Bill::where('account_no', $account)->where('year', $year)->first();
        if ($billRes) :
            if ($billRes->adjust_arrears != null || $billRes->adjust_arrears != '') :
                unset($bill['account_balance']);
                $bill = array_merge($bill, [
                    'account_balance' => number_format(floatval(($ans + $arrears) - ($totalPaid + $billRes->adjust_arrears)), 2, '.', '')
                ]);
            endif;
            // $bill = array_merge($bill, ['arrears' => $arrears, 'account_balance' => $ans + $arrears]);
            $billRes->update($bill);
        else :
            $t = \App\Bill::create($bill);
        endif;

        return true;
    }
}
