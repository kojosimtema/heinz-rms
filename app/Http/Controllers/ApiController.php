<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supervisor;
use App\Collector;
use App\Cashier;
use App\Stock;
use App\EnumGcr;
use DB;
use Image;
use Hash;
use Log;

use App\Models\Location\Zonal;
use App\Models\Location\Ta;
use App\Models\Location\Electoral;
use App\Models\Location\Community;
use App\Models\Location\Constituency;
use App\Models\Location\Unit;
use App\Models\Location\Street;

use App\Property;
use App\Business;
use App\PropertyType;
use App\PropertyCategory;
use App\PropertyOwner;
use App\Bill;
use App\Payment;
use App\Client;

use Cloudder;

use GuzzleHttp\Exception\GuzzleException;
use App\Http\Controllers\SetupController as Setup;

class ApiController extends Controller
{

    public function testSMS()
    {
        Setup::sendSms('233248160008', 'hello testing');
    }

    public function htk()
    {
        $bills = Bill::where('bill_type', 'p')->whereNull('property_type')->take(1000)->get();
        // dd($bills);
        if($bills->count() < 1) {
            die('scripts completed');
        }
        foreach ($bills as $bill ) {
            // $business = Business::where('business_no', $bill->account_no)->first();
            // if($business) {
            //     $bill->business_type = $business->business_type;
            //     $bill->business_category = $business->business_category;
            //     $bill->save();
            // }

            $property = Property::where('property_no', $bill->account_no)->first();
            if($property) {
                $bill->property_type = $property->property_type;
                $bill->property_category = $property->property_category;
                $bill->save();
            }
        }
        dd('done');
    }

    public function getFromData($query)
    {
        $data = [];
        $stock = [];
        if ($query === 'supervisor') :
            $data = Supervisor::latest()->get();
        endif;
        if ($query === 'stock') :
            $stock = Stock::where('status', 'free')->whereNotNull('accountant_id')->orderBy('min_serial', 'asc')->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data, 'stock' => $stock]);
    }

    public function getFromStock($query, $id = null)
    {
        $data = [];
        if ($query === 'supervisor') :
            $supervisor = Supervisor::where('id', $id)->first();
            $data = \App\Stock::where('supervisor_id', $supervisor->supervisor_id)->orderBy('min_serial', 'asc')->get();
        endif;
        if ($query === 'stock') :
            $data = \App\Stock::where('status', 'free')->orderBy('min_serial', 'asc')->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getToData($query)
    {
        $data = [];
        if ($query === 'cashier') :
            $data = Cashier::latest()->get();
        endif;
        if ($query === 'collector') :
            $data = Collector::latest()->get();
        endif;
        if ($query === 'supervisor') :
            $data = Supervisor::latest()->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function findGcr($query)
    {
        // is_used, is_damaged, is_missing, is_returned, colletor_name, in_stock
        $data = [];
        $gcr = EnumGcr::where('gcr_number', $query)->first();
        // dd($gcr);
        if (!$gcr) return response()->json(['status' => 'failed', 'data' => '']);
        if ($gcr->id_collector) {
            $collector = DB::table('collectors')->where('collector_id', $gcr->id_collector)->first();
            $data = array_merge($data, ['collector' => $collector->name]);
        }
        if ($gcr->id_cashier) {
            $collector = DB::table('cashiers')->where('cashier_id', $gcr->id_cashier)->first();
            $data = array_merge($data, ['collector' => $collector->name]);
        }
        $data = array_merge($data, ['is_used' => $gcr->is_used, 'in_stock' => !$gcr->is_used, 'is_damaged' => $gcr->is_damaged]);
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function findPaymentGcr($gcr)
    {
        // is_used, is_damaged, is_missing, is_returned, colletor_name, in_stock
        $data = [];
        $enumGcr = EnumGcr::where('gcr_number', $gcr)->first();
        if (!$enumGcr) return response()->json(['status' => 'failed', 'data' => '']);
        if ($enumGcr) $paymentGcr = Payment::where('gcr_number', $gcr)->first();
        if (!$paymentGcr) return response()->json(['status' => 'failed', 'data' => '']);
        if ($paymentGcr->collector_id) $collector = DB::table('collectors')->where('collector_id', $paymentGcr->collector_id)->first();
        // dd($paymentGcr);
        $account = (strtoupper($paymentGcr->data_type) == strtoupper('p'))
            ? Property::with(['type', 'category', 'owner'])->where('property_no', $paymentGcr->account_no)->first()
            : Business::with(['type', 'category', 'owner'])->where('business_no', $paymentGcr->account_no)->first();
        // dd($paymentGcr->account_no,$account);
        $data = array_merge($data, [
            'is_used' => ($enumGcr->is_used) ? true : false, 'in_stock' => !$enumGcr->is_used, 'is_damaged' => ($enumGcr->is_damaged) ? true : false, 'collector' => ($collector) ? $collector->name : 'no data',
            'payment_date' => \Carbon\Carbon::parse($paymentGcr->payment_date)->toFormattedDateString(), 'amount_paid' => floatval($paymentGcr->amount_paid), 'account_no' => $paymentGcr->account_no,
            'customer_name' => ($account->owner) ? $account->owner->name : 'no data correlation'
        ]);

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getCashierGCR($query)
    {
        $data = EnumGcr::where('id_cashier', $query)->where('is_used', 0)->orderBy('gcr_number', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getZonals()
    {
        $data = Zonal::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getTas()
    {
        $data = Ta::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getElectorals()
    {
        $data = Electoral::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCommunities()
    {
        $data = Community::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getUnits()
    {
        $data = Unit::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getStreets()
    {
        $data = Street::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getConstituencies()
    {
        $data = Constituency::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getProperties()
    {
        // $data = Property::with(['type', 'category', 'owner', 'tas'])->latest()->get();
        $data = Property::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertiesD()
    {
        // $data = Property::with(['type', 'category', 'owner', 'tas'])->latest()->get();
        $data = Property::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyTypes()
    {
        $data = PropertyType::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyTypeName($id)
    {
        $data = PropertyType::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getPropertyTypeName2($id)
    {
        $data = PropertyType::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getPropertyCatName($id)
    {
        $data = PropertyCategory::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getPropertyOwnerName($id)
    {
        $data = PropertyOwner::where('owner_id', $id)->first();
        // $d = array("firstname" => $data->firstname, "lastname" => $data->lastname);
        return response()->json(['status' => 'success', 'data' => $data->name]);
    }
    public function getPropertyZonal($id)
    {
        $data = Zonal::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getPropertyCategories()
    {
        $data = PropertyCategory::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyOwners()
    {
        // DB::table('property_owners')->orderBy('id')->chunk(20, function ($owners) {
        //     foreach ($owners as $owner) {
        //       var_dump($owner);
        //         return response()->json(['status' => 'success', 'data' => $owner]);
        //     }
        //   });
        $data = PropertyOwner::orderBy('code', 'asc')->get();
        // dd($data);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyOwnerData($id)
    {
        $data = PropertyOwner::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyTypeData($id)
    {
        $data = PropertyType::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getPropertyCategoryData($id)
    {
        $data = PropertyCategory::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function updatePropertyOwnerData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['firstname' => 'required', 'lastname' => 'required', 'phone' => '', 'address' => '']);
        $owner = PropertyOwner::where('id', $id)->first();
        $owner->update($data);
        return response()->json(['status' => 'success', 'data' => $owner]);
    }
    public function updatePropertyTypeData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['code' => 'required', 'description' => 'required', 'budget_code' => '']);
        $type = PropertyType::where('id', $id)->first();
        $type->update($data);
        return response()->json(['status' => 'success', 'data' => $type]);
    }
    public function updatePropertyCategoryData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['code' => 'required', 'description' => '', 'rate_pa' => '', 'min_charge' => '']);
        $category = PropertyCategory::where('code', 'LIKE', "%{$id}%")->first();
        $category->update($data);
        return response()->json(['status' => 'success', 'data' => $category]);
    }
    /** Delete */

    public function deletePropertyCategoryData($id)
    {
        // dd($id);
        $category = PropertyCategory::where('code', $id)->first();
        $category->delete();
        return response()->json(['status' => 'success', 'data' => 'deleted']);
    }
    public function deletePropertyTypeData($id)
    {
        // dd($id);
        $type = PropertyType::where('id', $id)->first();
        $type->delete();
        return response()->json(['status' => 'success', 'data' => 'deleted']);
    }

    public function getPropertyBills($query)
    {
        $property = Property::with('owner')->where('property_no', $query)->first();
        $owner = ($property) ? $property->owner : 'no owner found';
        $bill = Bill::where('account_no', $query)->first() ?: 'no data found';

        return response()->json(['status' => 'success', 'data' => $bill, 'owner' => $owner]);
    }
    public function getAccountBills($query)
    {
        $max = Bill::where('account_no', $query)->max('year');
        $bill = Bill::where('account_no', $query)->where('year', $max)->first();
        // dd($bill);
        if (!$bill) return response()->json(['status' => 'success', 'data' => 'false']);
        $owner;
        if (strtoupper($bill->bill_type) == strtoupper('p')) {
            $bill = Bill::with('property')->where('account_no', $query)->where('year', $max)->first();
            $own = $bill ? ($bill->property ?: 'NA') : 'NA';
            $owner = ($own == 'NA') ? 'NA' : $own->owner;
            $zonal = ($own == 'NA') ? 'NA' : $own->zonal;
        } else {
            $bill = Bill::with('business')->where('account_no', $query)->where('year', $max)->first();
            $own = $bill ? ($bill->business ?: 'NA') : 'NA';
            $owner = ($own == 'NA') ? 'NA' : $own->owner;
            $zonal = ($own == 'NA') ? 'NA' : $own->zonal;
        }



        // $bill = Bill::where('account_no', $query)->first() ?: 'no data found';
        // dd($owner);

        return response()->json(['status' => 'success', 'data' => $bill, 'owner' => $owner, 'zonal' => $zonal]);
    }
    public function getDesktopPropertyBills($query)
    {
        $bill = Bill::with('property')->where('id', $query)->first() ?: 'no data found';
        if ($bill) $property = Property::with('category')->where('property_no', $bill->account_no)->first() ?: 'no data found';
        // dd($bill);

        return response()->json(['status' => 'success', 'bill' => $bill, 'property' => $property]);
    }
    public function getAllPropertyBills()
    {
        $bills = Bill::latest()->get();
        // dd($bills);
        return response()->json(['status' => 'success', 'data' => $bills]);
    }
    public function filterBillByAc($query, $account = 'm')
    {
        if (strtoupper($account) == strtoupper('b')) :
            $bills = Business::with(['owner'])->where('business_no', 'LIKE', "%{$query}%")->get();
            return response()->json(['status' => 'success', 'data' => $bills]);
        endif;
        if (strtoupper($account) == strtoupper('p')) :
            $bills = Property::with(['owner'])->where('property_no', 'LIKE', "%{$query}%")->get();
            return response()->json(['status' => 'success', 'data' => $bills]);
        endif;
        $bills = Bill::where('account_no', 'LIKE', "%{$query}%")->get();
        return response()->json(['status' => 'success', 'data' => $bills]);
    }
    public function getCollectors()
    {
        $data = Collector::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCashiers()
    {
        $data = Cashier::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCollectorStock($query)
    {
        $collector = Collector::where('id', $query)->first();
        $data = EnumGcr::where('is_used', 0)->where('id_collector', $collector->collector_id)->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCollectorPaymentStatus($collector, $type)
    {
        $collector = \App\Collector::where('collector_id', $collector)->first();
        $data = (strtoupper($type) == strtoupper('p')) ? \App\Property::where('client', $collector->email)->where('paid_collector', 0)->count()
            : \App\Business::where('client', $collector->email)->where('paid_collector', 0)->count();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function postPayment(Request $request)
    {

        $info = $request->validate([
            'account_no' => 'required', 'amount_paid' => 'required', 'data_type' => 'required',
            'gcr_number' => 'required|unique:payments', 'payment_mode' => 'required', 'collector_id' => 'required',
            'cheque_no' => '', 'collector_name' => 'required', 'collector_email' => 'required', 'date' => 'required'
        ]);
        // dd($info);
        $collector = Collector::where('id', $info['collector_id'])->first();
        unset($info['collector_id']);
        $dateArray = explode('-', $info['date']);
        $info = array_merge($info, ['payment_date' => $info['date'], 'payment_year' => current($dateArray), 'collector_id' => $collector->collector_id]);
        unset($info['date']);
        if ($this->recalculateGCR($info['gcr_number'], $info['collector_id'])) :
            if ($this->recalculateBill($info['account_no'], $info['amount_paid'])) :
                $payment = Payment::create($info);
                if ($payment) {
                    $account = (strtoupper($payment->data_type) == strtoupper('p'))
                        ? Property::with(['type', 'category', 'owner'])->where('property_no', $payment->account_no)->first()
                        : Business::with(['type', 'category', 'owner'])->where('business_no', $payment->account_no)->first();
                    // dd($account->owner);
                    if ($account->owner && $account->owner->phone) {
                        $mobile = $account->owner->phone;
                        if ($mobile[0] == '0') $mobile = ltrim($mobile, '0');
                        $mobile = '233' . $mobile;
                        // $mobile = '233248160008';
                        $max = Bill::where('account_no', $payment->account_no)->max('year');
                        $bill = Bill::where('account_no', $payment->account_no)->where('year', $max)->first();
                        // $msg = 'Dear ' . ($account->owner ? $account->owner->name : 'sir/madma') . ' of ACC: '. $payment->account_no . '. You have been credited with a payment amount of GHc' .$payment->amount_paid . ' with a GCR No '. $payment->gcr_number . ' and your current balance is GHc ' . $bill->account_balance . '.Thank you for doing business with the assembly.';
                        $msg = 'Dear ' . ($account->owner ? $account->owner->name : 'sir/madma') . ' of ACC: ' . $payment->account_no . '. A payment of GHc ' . $payment->amount_paid . ' on GCR-' . $payment->gcr_number . ' on ' . date('Y-m-d') . ' has been received, your balance is GHc ' . $bill->account_balance;
                        $smsRes = Setup::sendSms($mobile, $msg);
                        // $msg = $payment->account_no.' trsting'.
                        // $smsRes = Setup::sendSms('233248160008', $msg);
                        // dd($smsRes, 'o');
                        // $smsRes = 'good';
                        if ($smsRes == 'good') {
                            return response()->json(['status' => 'success', 'data' => 'Saved and SMS sent', 'payment' => $payment, 'account' => $bill, 'owner' => $account->owner ? $account->owner->name : 'no owner name found', 'message' => $msg]);
                        } else {
                            return response()->json(['status' => 'success', 'data' => 'Saved..Sending message error']);
                        }
                    } else {
                        return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
                    }
                }
            endif;

        endif;
        return response()->json(['status' => 'success', 'data' => 'good']);
    }

    public function editPayment(Request $request)
    {

        $info = $request->validate([
            'amount_paid' => 'required',
            'gcr_number' => 'required', 'payment_mode' => 'required',
            'cheque_no' => '', 'date' => ''
        ]);
        if (!$info['date'] || $info['date'] == "") {
            unset($info['date']);
        } else {
            $dateArray = explode('-', $info['date']);
            $info = array_merge($info, ['payment_date' => $info['date'], 'payment_year' => current($dateArray)]);
            unset($info['date']);
        }
        $payment = \App\Payment::where('gcr_number', $request->gcr_number_old)->first();
        $payment2 = \App\Payment::where('gcr_number', $request->gcr_number_old)->first();
        $collector = Collector::where('collector_id', $payment->collector_id)->first();


        if ($this->recalculateGCR($info['gcr_number'], $collector->collector_id)) :
            if ($this->recalculateBill2($payment->account_no, $info['amount_paid'], $payment->amount_paid)) :
                $payment->update($info);
                $pmt = \App\Payment::where('gcr_number', $info['gcr_number'])->first();
                if ($payment2->gcr_number != $info['gcr_number']) {
                    $data = EnumGcr::where('id_collector', $collector->collector_id)->where('gcr_number', $payment2->gcr_number)->first();
                    $data->update(['is_used' => 0]);
                }
                $payment->update($info);
                if ($pmt) {
                    $account = (strtoupper($payment->data_type) == strtoupper('p'))
                        ? Property::with(['type', 'category', 'owner'])->where('property_no', $payment->account_no)->first()
                        : Business::with(['type', 'category', 'owner'])->where('business_no', $payment->account_no)->first();
                    // dd($account->owner);
                    if ($account->owner && $account->owner->phone) {
                        $mobile = $account->owner->phone;
                        if ($mobile[0] == '0') $mobile = ltrim($mobile, '0');
                        $mobile = '233' . $mobile;
                        // $mobile = '233248160008';
                        $max = Bill::where('account_no', $payment->account_no)->max('year');
                        $bill = Bill::where('account_no', $payment->account_no)->where('year', $max)->first();
                        // $msg = 'Dear ' . ($account->owner ? $account->owner->name : 'sir/madma') . ' of ACC: '. $payment->account_no . '. Your payment with amount of GHc' .$pmt->amount_paid . ' and GCR No '. $pmt->gcr_number . ' has been edited to the correct figures and your current balance is GHc ' . $bill->account_balance. '. Thank you for doing business with the assembly.';
                        $msg = 'Dear ' . ($account->owner ? $account->owner->name : 'sir/madma') . ' of ACC: ' . $payment->account_no . '.An amount of GHc ' . $pmt->amount_paid . ' with GCR No ' . $pmt->gcr_number . ' has been corrected against GCR No ' . $request->gcr_number_old . ' .Your outstanding balance is ' . $bill->account_balance;
                        $smsRes = Setup::sendSms($mobile, $msg);
                        // $msg = $payment->account_no.' trsting'.
                        // $smsRes = Setup::sendSms('233248160008', $msg);
                        // dd($smsRes, 'o');
                        // $smsRes = 'good';
                        if ($smsRes == 'good') {
                            return response()->json(['status' => 'success', 'data' => 'Saved and SMS sent', 'payment' => $pmt, 'account' => $bill, 'owner' => $account->owner ? $account->owner->name : 'no owner name found', 'message' => $msg]);
                        } else {
                            return response()->json(['status' => 'success', 'data' => 'Saved..Sending message error']);
                        }
                    } else {
                        return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
                    }
                }
            endif;
        endif;

        return response()->json(['status' => 'success', 'data' => 'good']);
    }

    public function returnPaymentBills(Request $request, $id, $clt)
    {
        $collector = Collector::where('id', $clt)->first();
        $payments = \App\Payment::where('account_no', $id)->where('collector_id', $collector->collector_id)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $payments]);
    }

    public function fetchPaymentBill(Request $request, $id)
    {
        $payment = \App\Payment::where('gcr_number', $id)->first();
        return response()->json(['status' => 'success', 'data' => $payment]);
    }



    protected function recalculateBill($account, $amount)
    {

        $max = Bill::where('account_no', $account)->max('year');
        $bill = Bill::where('account_no', $account)->where('year', $max)->first();
        // $bill = Bill::where('account_no', $account)->first();
        $totalPayment = floatval($bill->total_paid) + floatval($amount);
        $checkBal = floatval($bill->account_balance) - floatval($amount);
        $balance = $checkBal == floatval(0) ? floatval(0) : $checkBal;
        $bill->update(['account_balance' => $balance, 'total_paid' => $totalPayment]);
        return true;
    }

    protected function recalculateBill2($account, $amount, $old)
    {

        $max = Bill::where('account_no', $account)->max('year');
        $bill = Bill::where('account_no', $account)->where('year', $max)->first();
        // $bill = Bill::where('account_no', $account)->first();
        $totalPayment = (floatval($bill->total_paid) - floatval($old)) + floatval($amount);
        $checkBal = floatval($bill->account_balance) + floatval($old) - floatval($amount);
        $balance = $checkBal == floatval(0) ? floatval(0) : $checkBal;
        $bill->update(['account_balance' => $balance, 'total_paid' => $totalPayment]);
        return true;
    }

    protected function recalculateGCR($gcr, $collector)
    {
        // dd($gcr, $collector);
        $data = EnumGcr::where('id_collector', $collector)->where('gcr_number', $gcr)->first();
        $data->update(['is_used' => 1]);
        return true;
    }

    public function savePropertyFromMobile(Request $request)
    {
        // return response()->json(['status' => 'success', 'data' => 'okay...'], 201);
        // dd($request()->all());
        $props = $request->validate([
            'firstname' => 'required', 'lastname' => 'required',
            'phone' => '', 'address' => '', 'building_permit_no' => '',
            'serial_no' => '', 'property_type' => 'required',
            'property_category' => 'required', 'zonal_id' => '',
            'valuation_no' => '', 'house_no' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'image' => '', 'client' => '', 'electoral_id' => '', 'tas_id' => '', 'community_id' => ''
        ]);
        // return response()->json(['status' => 'success', 'data' => $props], 201);

        $owns = array(
            'name' => $request->firstname . ' ' . $request->lastname,
            'phone' => $request->phone,
            'address' => $request->address
        );
        $ownrs = array(
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'address' => $request->address
        );
        if ($request->image) :
            // $name = $request->image->getClientOriginalName();
            Cloudder::upload(request('image'), null);
            list($width, $height) = getimagesize($request->image);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $props = array_merge($props, ['image' => $image_url]);
        endif;
        $res = PropertyOwner::create($owns);
        if ($res) {
            $owners = PropertyOwner::latest()->count();
            $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $owners));
            $res->save();
        }
        unset($props['firstname'], $props['lastname'], $props['phone']);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        $props = array_merge($props, ['property_owner' => $res->owner_id]);
        $tkn = \App\TrackAccountNumber::first();
        $addedValue = $tkn->property + 1;
        $tkn->property = $addedValue;
        $tkn->save();

        if ($props['zonal_id'] == null || $props['zonal_id'] == "no zonal data" || $props['zonal_id'] == "") {
            $props = array_merge($props, ['property_no' => 'PR-' . env('ASSEMBLY_CODE') . sprintf('%05d', $addedValue)]);
        } else {
            $props = array_merge($props, ['property_no' => 'PR-' . strtoupper($props['zonal_id']) . sprintf('%05d', $addedValue)]);
        }

        // return response()->json(['status' => 'success', 'data' => $props], 201);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        $property = Property::create($props);
        if ($property) :
            $tkn = \App\TrackAccountNumber::first();
            $addedValue = $tkn->property + 1;
            $tkn->property = $addedValue;
            $tkn->save();

            $collectorPayment = $this->createCollectorPayment([
                'email' => $property->client,
                'account_no' => $property->property_no,
                'account_type' => strtoupper('p')
            ]);
            // $billingResponse = \App\Http\Controllers\BillingController::initPropertyBill($property, "2018", "2019");

            if ($property->owner && $property->owner->phone) {
                $mobile = $property->owner->phone;
                if ($mobile[0] == '0') $mobile = ltrim($mobile, '0');
                $mobile = '233' . $mobile;
                $message = 'Dear ' . $property->owner->name . ' of PROPERTY ACC No: ' . $property->property_no . ' has been successfully registered with ' . env('ASSEMBLY_SMS_FROM') . ' Assembly.';
                // if(env('contacts')):
                //   $message. = 'For any enquiry, please contact us.' . env('contacts'). '.';
                // endif;
                $smsRes = Setup::sendSms($mobile, $message);
                // dd($smsRes, 'o');
                if ($smsRes == 'good') {
                    return response()->json(['status' => 'success', 'message' => 'Saved and SMS sent', 'property' => $property, 'owner' => $ownrs], 201);
                } else {
                    return response()->json(['status' => 'success', 'message' => 'Saved and SMS sent', 'property' => $property, 'owner' => $ownrs], 201);
                }
            } else {
                return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
            }
        endif;
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        return response()->json(['status' => 'success', 'property' => $property, 'owner' => $ownrs], 201);
    }

    private function createCollectorPayment($data)
    {
        $collector = \App\Collector::where('email', $data['email'])->first();
        $data = array_merge($data, ['collector_id' => $collector->collector_id, 'name' => $collector->name, 'username' => $collector->username, 'paid' => 0]);
        $payment = \App\CollectorPayment::create($data);
        return true;
    }

    public function getPropertyFromMobile($prop)
    {
        $property = Property::where('property_no', $prop)->first();
        if (!$property) :
            return response()->json(['status' => 'success', 'property' => '', 'owner' => ''], 201);
        endif;
        $ownerName = PropertyOwner::where('owner_id', $property->property_owner)->first();
        $name = explode(" ", $ownerName->name);
        $owner = ["firstname" => $name[0], "lastname" => $name[1]];
        if (count($name) > 2) $owner = array_merge($owner, ["lastname" => $name[1] . " " . $name[2]]);

        return response()->json(['status' => 'success', 'property' => $property, 'owner' => $owner], 201);
    }

    public function getPropertiesFromMobile($email, $number = 5)
    {
        $property = Property::where('client', $email)->paginate($number);

        return response()->json(['status' => 'success', 'property' => $property], 201);
    }

    public function updatePropertyFromMobile(Request $request, $propertyID, $owner)
    {
        $property = Property::where('id', $propertyID)->first();

        if ($request->firstname || $request->lastname || $request->phone || $request->address) :
            $businessOwner = BusinessOwner::where('owner_id', $property->property_owner)->first();
            // dd($businessOwner);
            $propertyOwner->name = $request->firstname . " " . $request->lastname;
            $propertyOwner->phone = $request->phone;
            $propertyOwner->address = $request->address;
            $propertyOwner->update();
        endif;

        $property->house_no = $request->house_no;
        $property->valuation_no = $request->valuation_no;
        $property->building_permit_no = $request->building_permit_no;
        $property->update();

        return response()->json(['status' => 'success', 'property' => $property, 'owner' => $propertyOwner], 201);
    }

    public function createImageFromBase64($image)
    {
        $file_name = 'image_' . time() . '.png'; //generating unique file name;
        @list($type, $image) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);

        if ($file_data != "") { // storing image in storage/app/public Folder
            \Storage::disk('public')->put($file_name, base64_decode($file_data));
        }
        return $file_name;
    }

    public function checkMobileAuth(Request $request)
    {
        $res = '';
        $collector;
        $email = '';
        $uuid = '';
        $name = '';
        if (strpos($request->email, '.com') == true) {
            $collector = Collector::where('email', $request->email)->first();
        } else {
            $collector = Collector::where('username', $request->email)->first();
        }

        if (!$collector) return response()->json(['status' => 'success', 'data' => 'fraud'], 201);


        if ($collector && Hash::check($request->password, $collector->password)) {
            $res = 'verified';
            $email = $collector->email;
            $uuid = $collector->id;
            $name = $collector->name;
            $collector_id = $collector->collector_id;
        } else {
            $res = 'fraud';
        }

        return response()->json(['status' => 'success', 'data' => $res, 'email' => $email, 'uuid' => $uuid, 'name' => $name, 'collector_id' => $collector_id], 201);
    }

    public function getClients()
    {
        $client = Client::latest()->get();
        return response()->json(['status' => 'success', 'data' => $client], 201);
    }

    public function getPropertyTC($id)
    {
        $props = PropertyCategory::where('type_id', $id)->get();

        return response()->json(['status' => 'success', 'props' => $props], 201);
    }
    public function getTasLocation($id)
    {
        $props = Ta::where('zonal_id', $id)->get();

        return response()->json(['status' => 'success', 'props' => $props], 201);
    }
    public function getElectoralsLocation($id)
    {
        $props = Electoral::where('tas_id', $id)->get();

        return response()->json(['status' => 'success', 'props' => $props], 201);
    }
    public function getCommunitiesLocation($id)
    {
        $props = Community::where('electoral_id', $id)->get();

        return response()->json(['status' => 'success', 'props' => $props], 201);
    }

    public function checkProcessStatus()
    {
        $data = \App\Processing::first();
        return response()->json(['status' => 'success', 'data' => $data], 201);
    }

    public function getBilCount(Request $request, $account)
    {
        // dd($request->all());
        $year = $request->year;
        if (strtoupper($account) == strtoupper('p')) :

            if ($request->isFilter == "true") :

                if ($request->zonal) :
                    $addict = $request->zonal;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('zonal_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->electoral) :
                    $addict = $request->electoral;
                    $bills = \App\Property::where('electoral_id', $addict)->whereHas('bills', function ($q) use ($year) {
                        $q->where('year', $year)->where('printed', 0);
                    })->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('electoral_id', $addict)->where('year', $year)->where('printed', 0);
                    }])->count();

                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->tas) :
                    $addict = $request->tas;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('tas_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->community) :
                    $addict = $request->community;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('community_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->street) :
                    $addict = $request->street;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('street_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                endif;

                $bills = $bills->latest()->count();

                return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);


            else :
                $billCount = \App\Bill::where('year', $request->year)->latest()->count();
                return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($billCount, false)], 201);
            endif;

        endif;



        if (strtoupper($account) == strtoupper('b')) :

            if ($request->isFilter == "true") :

                if ($request->zonal) :
                    $addict = $request->zonal;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('zonal_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->electoral) :
                    $addict = $request->electoral;
                    $bills = \App\Business::where('electoral_id', $addict)->whereNotNull('property_no')->whereHas('bills', function ($q) use ($year) {
                        $q->where('year', $year)->where('printed', 0);
                    })->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('electoral_id', $addict)->where('year', $year)->where('printed', 0);
                    }])->count();

                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->tas) :
                    $addict = $request->tas;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('tas_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->community) :
                    $addict = $request->community;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('community_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                elseif ($request->street) :
                    $addict = $request->street;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('street_id', $addict)->where('year', $year);
                    }])->count();
                    return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);
                endif;

                $bills = $bills->latest()->count();

                return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($bills, false)], 201);


            else :
                $billCount = \App\Bill::where('year', $request->year)->latest()->count();
                return response()->json(['status' => 'success', 'data' => \App\Repositories\ExpoFunction::formatMoney($billCount, false)], 201);
            endif;

        endif;
        dd($request->isFilter);
    }
    public function getBilSet(Request $request, $account)
    {
        // dd($request->all());
        $year = $request->year;

        if (strtoupper($account) == strtoupper('p')) :

            if ($request->isFilter == "true") :

                if ($request->zonal) :
                    $addict = $request->zonal;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('zonal_id', $addict)->where('year', $year);
                    }])->orderBy('property_no', 'asc')->get();
                // $bills->where('zonal_id', $request->zonal);
                elseif ($request->electoral) :
                    $addict = $request->electoral;
                    // dd($addict);
                    $bills = \App\Property::where('electoral_id', $addict)->whereNotNull('property_no')->whereHas('bills', function ($q) use ($year) {
                        $q->where('year', $year)->where('printed', 0);
                    })->with(['owner', 'type', 'category', 'zonal', 'electoral', 'tas', 'street', 'bills' => function ($query) use ($year, $addict) {
                        $query->where('electoral_id', $addict)->where('year', $year)->where('printed', 0);
                    }])->orderBy('property_no', 'asc')->get();
                    return response()->json(['status' => 'success', 'data' => $bills], 201);
                elseif ($request->tas) :
                    $addict = $request->tas;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('tas_id', $addict)->where('year', $year);
                    }])->orderBy('property_no', 'asc')->get();
                elseif ($request->community) :
                    $addict = $request->community;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('community_id', $addict)->where('year', $year);
                    }])->orderBy('property_no', 'asc')->get();
                elseif ($request->street) :
                    $addict = $request->street;
                    $bills = \App\Property::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('street_id', $addict)->where('year', $year);
                    }])->orderBy('property_no', 'asc')->get();
                endif;

                // $bills = $bills->orderBy('property_no', 'asc')->get();

                return response()->json(['status' => 'success', 'data' => $bills], 201);


            else :
                $billCount = \App\Bill::where('year', $request->year)->orderBy('account_no', 'asc')->get();
                return response()->json(['status' => 'success', 'data' => $bills], 201);
            endif;

        endif;



        if (strtoupper($account) == strtoupper('b')) :

            if ($request->isFilter == "true") :

                if ($request->zonal) :
                    $addict = $request->zonal;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('zonal_id', $addict)->where('year', $year);
                    }])->orderBy('business_no', 'asc')->get();
                // $bills->where('zonal_id', $request->zonal);
                elseif ($request->electoral) :
                    $addict = $request->electoral;
                    // dd($addict);
                    $bills = \App\Business::where('electoral_id', $addict)->whereHas('bills', function ($q) use ($year) {
                        $q->where('year', $year)->where('printed', 0);
                    })->with(['owner', 'type', 'category', 'zonal', 'electoral', 'communities', 'tas', 'street', 'bills' => function ($query) use ($year, $addict) {
                        $query->where('electoral_id', $addict)->where('year', $year)->where('printed', 0);
                    }])->orderBy('business_no', 'asc')->get();
                    return response()->json(['status' => 'success', 'data' => $bills], 201);
                elseif ($request->tas) :
                    $addict = $request->tas;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('tas_id', $addict)->where('year', $year);
                    }])->orderBy('business_no', 'asc')->get();
                elseif ($request->community) :
                    $addict = $request->community;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('community_id', $addict)->where('year', $year);
                    }])->orderBy('business_no', 'asc')->get();
                elseif ($request->street) :
                    $addict = $request->street;
                    $bills = \App\Business::has('bills')->with(['bills' => function ($query) use ($year, $addict) {
                        $query->where('street_id', $addict)->where('year', $year);
                    }])->orderBy('business_no', 'asc')->get();
                endif;

                // $bills = $bills->orderBy('property_no', 'asc')->get();

                return response()->json(['status' => 'success', 'data' => $bills], 201);


            else :
                $billCount = \App\Bill::where('year', $request->year)->orderBy('account_no', 'asc')->get();
                return response()->json(['status' => 'success', 'data' => $bills], 201);
            endif;

        endif;

        dd($request->isFilter);
    }

    public function getBilSetBulk(Request $request, $accountType)
    {
        if (strtoupper($accountType) == strtoupper('p')) :
            // $bills = [];
            $year = $request->year;
            $bills = \App\Property::whereIn('property_no', $request->account)->has('bills')
                ->with(['owner', 'type', 'category', 'zonal', 'electoral', 'communities', 'tas', 'street', 'bills' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])->get();;
            return response()->json(['status' => 'success', 'data' => $bills], 201);
            // foreach ($request->account as $key => $account) {
            //   $year = $request->year;
            //   $bill = \App\Property::where('property_no', $account)->has('bills')
            //    ->with(['owner', 'type', 'category', 'zonal', 'electoral', 'communities', 'tas', 'street','bills' => function($query) use ($year){
            //     $query->where('year', $year);
            //   }])->first();
            //   // $bill = \App\Bill::where('account_no', $account)->where('year', $request->year)->first();
            //   if(!$bill) continue;
            //   array_push($bills, $bill);
            // }
            return response()->json(['status' => 'success', 'data' => $bills], 201);
        endif;
        if (strtoupper($accountType) == strtoupper('b')) :
            // $bills = [];
            $year = $request->year;
            $bills = \App\Business::whereIn('business_no', $request->account)->has('bills')
                ->with(['owner', 'type', 'category', 'zonal', 'electoral', 'communities', 'tas', 'street', 'bills' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])->get();;
            return response()->json(['status' => 'success', 'data' => $bills], 201);
            // foreach ($request->account as $key => $account) {
            //   $year = $request->year;
            //   $bill = \App\Property::where('property_no', $account)->has('bills')
            //    ->with(['owner', 'type', 'category', 'zonal', 'electoral', 'communities', 'tas', 'street','bills' => function($query) use ($year){
            //     $query->where('year', $year);
            //   }])->first();
            //   // $bill = \App\Bill::where('account_no', $account)->where('year', $request->year)->first();
            //   if(!$bill) continue;
            //   array_push($bills, $bill);
            // }
            return response()->json(['status' => 'success', 'data' => $bills], 201);
        endif;

        return response()->json(['status' => 'success', 'data' => $request->all()]);
    }


    public function updateBill(Request $request)
    {
        $bill = \App\Bill::with('property')->where('account_no', $request->account)->where('year', $request->year)->first();
        $bill->printed = 1;
        $bill->update();
        return response()->json(['status' => 'success']);
    }

    public function getLocationDataSet(Request $request, $streetCode)
    {
        $st = Street::where('code', $streetCode)->first();
        if ($st) :
            $unit = Unit::where('code', $st->unit_id)->first();
            $community = $unit ? Community::where('code', $unit->community_id)->first() : null;
            $electoral = $community ? Electoral::where('code', $community->electoral_id)->first() : null;
            $tas = $electoral ? Ta::where('code', $electoral->tas_id)->first() : null;
            $zonal = $tas ? Zonal::where('code', $tas->zonal_id)->first() : null;

            return response()->json([
                'status' => 'success',
                'zonal' => $zonal ? ['name' => $zonal->description, 'code' => $zonal->code] : '',
                'tas' => $tas ? ['name' => $tas->description, 'code' => $tas->code] : '',
                'electoral' => $electoral ? ['name' => $electoral->description, 'code' => $electoral->code] : '',
                'community' => $community ? ['name' => $community->description, 'code' => $community->code] : '',
                'unit' => $unit ? ['name' => $unit->description, 'code' => $unit->code] : '',
                'street' => $st ? ['name' => $st->description, 'code' => $st->code] : ''
            ], 201);
        else :
            return response()->json(['status' => 'failed', 'data' => ''], 201);
        endif;
    }

    public function getDetailsDataSet(Request $request, $categoryType)
    {
        $category = PropertyCategory::where('code', $streetCode)->first();
        if ($category) :
            $type = PropertyType::where('code', $category->type_id)->first();

            return response()->json([
                'status' => 'success',
                'category' => $category ? ['name' => $category->description, 'code' => $category->code] : '',
                'type' => $type ? ['name' => $type->description, 'code' => $type->code] : ''
            ], 201);
        else :
            return response()->json(['status' => 'failed', 'data' => ''], 201);
        endif;
    }
}
