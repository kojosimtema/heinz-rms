<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reports\ReportListing as Report;

use App\Models\Location\Zonal;
use App\Models\Location\Electoral;
use App\Models\Location\Community;

use App\Reports\ElectoralPropertyReport;
use App\Reports\ElectoralBusinessReport;

use App\Reports\ZonalPropertyReport;
// use App\Reports\ElectoralBusinessReport;

use App\Reports\CommunityPropertyReport;
use App\Reports\CommunityBusinessReport;

use App\Reports\PropertyTypeReport;
use App\Reports\PropertyCategoryReport;

use App\Reports\PropertyReport;
use App\Reports\BusinessReport;

use App\Reports\BusinessTypeReport;
use App\Reports\BusinessCategoryReport;

use App\Property;
use App\Bill;
use App\PropertyCategory;
use App\PropertyType;
use App\BusinessCategory;
use App\BusinessType;

use DB;
use URL;
use File;
use Response;

use Illuminate\Support\Facades\Storage;
use Excel;
use App\Exports\NorminalRowExportProperty;

use App\WebClientPrint\WebClientPrint;
use App\WebClientPrint\Utils;
use App\WebClientPrint\DefaultPrinter;
use App\WebClientPrint\InstalledPrinter;
use App\WebClientPrint\PrintFile;
use App\WebClientPrint\ClientPrintJob;

use Session;
use Cloudder;

// use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Jobs\PreparePropertyExport;
use App\Jobs\PrepareBusinessExport;
use App\Jobs\BusinessDefaulterExport;
use App\Jobs\PropertyDefaulterExport;

use App\Exports\NorminalRowExportBusiness;

use App\Exports\DefaultersRowExportBusiness;

class AdvancedReportController extends Controller
{


    public function __construct(
        Request $request,
        Zonal $zonal,
        PropertyReport $property,
        ElectoralPropertyReport $electoralProperty,
        ElectoralBusinessReport $electoralBusiness,
        Bill $bill,
        BusinessReport $business,
        ZonalPropertyReport $zonalProperty,
        CommunityPropertyReport $communityProperty,
        CommunityBusinessReport $communityBusiness,
        BusinessTypeReport $businessType,
        BusinessCategoryReport $businessCategory,
        PropertyTypeReport $propertyType,
        PropertyCategoryReport $propertyCategory
    ) {
        $this->zonal = $zonal;
        $this->property = $property;
        $this->electoralProperty = $electoralProperty;
        $this->electoralBusiness = $electoralBusiness;
        $this->zonalProperty = $zonalProperty;
        $this->communityProperty = $communityProperty;
        $this->communityBusiness = $communityBusiness;
        $this->businessType = $businessType;
        $this->businessCategory = $businessCategory;
        $this->propertyType = $propertyType;
        $this->propertyCategory = $propertyCategory;
        $this->bill = $bill;
        $this->request = $request;
        $this->business = $business;

        $this->middleware('auth');
    }


    public function test()
    {
        // dd('ok');
        // return $request->all();
        // $electoral = $this->electoral->with(['properties'])->get()->groupBy('description');
        // $electoral = $this->electoral->with(['properties','properties.bills'])->paginate(2)->groupBy('description');
        // $test = $this->property->get();
        $test = DB::table('properties')->get();
        // $zonal = $this->zonal->with('electorals')->first();
        // dd($electoral);

        // return $electoral;
        return ['result' => $test];
    }

    public function propertyListingSearch()
    {
        return view('advanced.report.property.search-board');
    }

    public function propertyListing(Request $request)
    {

        // dd($request->all());
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        if ($request->loc != "a") return $this->propertySearchListingDetails($request->all());

        $location = $request['location'];
        $year = $request['year'];

        switch ($location) {
            case 'electoral':
                $electorals = $this->electoralProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'));
                }])->paginate(50)->appends(request()->query());
                $elects = $this->electoralProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->get();
                return view('advanced.report.property.property-listing', compact('electorals', 'location', 'year', 'wcpScript'));
                break;
            case 'zonal':
                $zonals = $this->zonalProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'));
                }])->paginate(50)->appends(request()->query());
                $elects = $this->zonalProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->get();
                return view('advanced.report.property.property-listing-zonal', compact('zonals', 'location', 'year', 'wcpScript'));
                break;
            case 'type':
                $zonals = $this->propertyType->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'));
                }])->paginate(50)->appends(request()->query());
                $elects = $this->propertyType->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->get();
                return view('advanced.report.property.property-listing-type', compact('zonals', 'location', 'year', 'wcpScript'));
                break;
            case 'category':
                $zonals = $this->propertyCategory->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'));
                }])->paginate(50)->appends(request()->query());
                $elects = $this->propertyCategory->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->get();
                return view('advanced.report.property.property-listing-category', compact('zonals', 'location', 'year', 'wcpScript'));
                break;
            case 'community':
                $communities = $this->communityProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'));
                }])->paginate(50)->appends(request()->query());
                $elects = $this->communityProperty->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->get();

                return view('advanced.report.property.property-listing-community', compact('communities', 'location', 'year', 'wcpScript'));
                break;

            default:
                return redirect()->back;
                break;
        }

        // return ['result'=>$elects->bills];



    }

    public function propertySearchListingDetails($data)
    {
        // dd($data);

        $location = '';
        $year = '';
        $loc = '';
        if (array_key_exists('location', $data)) {
            // dd('o');
            $location = $data['location'] ?: '';
            $url = url('/') . '/console/advanced/report/property/' . $data['location'] . '/' . $data['loc'] . '/' . $data['year'] . '/';
        } else {
            $parts = parse_url(URL::previous());
            parse_str($parts['query'], $query);
            $url = url('/') . '/console/advanced/report/property/' . $query['location'] . '/' . $query['loc'] . '/' . $query['year'] . '/';
            // dd($url);
        }
        if (array_key_exists('year', $data)) {
            $year = $data['year'] ?: '';
        }
        if (array_key_exists('loc', $data)) {
            $loc = $data['loc'] ?: '';
        }

        // dd($loc);

        // $electoral = $this->electoralProperty->where('code', $loc)->get();
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        switch ($location) {
            case 'electoral':
                $electoral = $this->electoralProperty->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();
                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                $code = $loc;
                // dd($electoral->bills->count());

                // return ['result'=>$bills];
                return view('advanced.report.property.property-listing-details', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'electoral', 'code'));
                break;
            case 'zonal':
                $zonal = $this->zonalProperty->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();
                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                $code = $loc;
                return view('advanced.report.property.property-listing-details-zonal', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'zonal', 'code'));
                break;
            case 'community':
                $community = $this->communityProperty->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();
                $bills = $community ? $this->paginate($community->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
                $info = $community ? $community->description : '';
                $totalBill = $community ? $community->bills->count() : '';
                $code = $loc;
                return view('advanced.report.property.property-listing-details-community', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'community', 'code'));
                break;
            case 'type':
                // dd('type');
                $zonal = $this->propertyType->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();
                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                $code = $loc;
                return view('advanced.report.property.property-listing-details-zonal', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'zonal', 'code'));
                break;
            case 'category':
                // dd('type');
                $zonal = $this->propertyCategory->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();
                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                $code = $loc;
                return view('advanced.report.property.property-listing-details-category', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'zonal', 'code'));
                break;

            default:
                return redirect()->back;
                break;
        }
    }





    public function propertyListingDetails(Request $request, $location, $code, $year)
    {
        // dd($location, $code, $year);

        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        switch ($location) {
            case 'electoral':
                $electoral = $this->electoralProperty->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                // return ['result'=> $bills->currentPage()];
                // dd($year, $location, $code, $info);
                return view('advanced.report.property.property-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;
            case 'zonal':
                $zonal = $this->zonalProperty->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                // return ['result'=> $bills->currentPage()];
                // dd($year, $location, $code, $info);
                return view('advanced.report.property.property-listing-details-zonal', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'zonal', 'code'));
                break;
            case 'type':
                $zonal = $this->propertyType->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                // return ['result'=> $bills->currentPage()];
                // dd($year, $location, $code, $info);
                return view('advanced.report.property.property-listing-details-type', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'zonal', 'code'));
                break;
            case 'category':
                $zonal = $this->propertyCategory->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $zonal ? $this->paginate($zonal->bills, $perPage = 30, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $zonal ? $zonal->description : '';
                $totalBill = $zonal ? $zonal->bills->count() : '';
                // return ['result'=> $bills->currentPage()];
                // dd($year, $location, $code, $info);
                return view('advanced.report.property.property-listing-details-category', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'zonal', 'code'));
                break;
            case 'community':
                $community = $this->communityProperty->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $community ? $this->paginate($community->bills, $perPage = 30, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $community ? $community->description : '';
                $totalBill = $community ? $community->bills->count() : '';
                // return ['result'=> $bills->currentPage()];
                // dd($year, $location, $code, $info);
                return view('advanced.report.property.property-listing-details-community', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'community', 'code'));
                break;

            default:
                return redirect()->back;
                break;
        }
    }

    public function apiPropertyListing()
    {
        $data = \App\Bill::with(['property'])->limit('4')->get()->groupBy('electoral_name');
        // $data = \App\Bill::with(['property'])->limit('4')->get()->sortBy('property.electoral.description');
        return response()->json(['data' => $data]);
    }

    // public function paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = [])
    // {

    //   $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
    //   $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
    //   $lap = new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    //   if ($baseUrl) {
    //         $lap->setPath($baseUrl);
    //     }

    //     return $lap;
    // }


    public function exportProperty(Request $request, $year, $electoral, $type = 'electorals')
    {
        switch ($type) {
            case 'electorals':
                $elct = Electoral::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                if(isset($request->amount) && $request->amount != null) {
                    PropertyDefaulterExport::dispatch($year, $electoral, $name, $type, $request->amount, $request->operator);
                }else{
                    PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                }
                break;
            case 'electoral':
                $elct = Electoral::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                if(isset($request->amount) && $request->amount != null) {
                    PropertyDefaulterExport::dispatch($year, $electoral, $name, $type, $request->amount, $request->operator);
                }else{
                    PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                }
                break;
            case 'communities':
                $elct = Community::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'zonals':
                $elct = Zonal::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'category':
                $elct = PropertyCategory::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'type':
                $elct = PropertyType::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-property-norminal-row-' . $year) . '.xlsx';
                PreparePropertyExport::dispatch($year, $electoral, $name, $type);
                break;

            default:
                // code...
                break;
        }

        return redirect()->back();
    }

    public function exportBusiness(Request $request, $year, $electoral, $type = 'electorals')
    {
        // $elct = Electoral::where('code', $electoral)->first();
        // $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
        // PrepareBusinessExport::dispatch($year, $electoral, $name);

        // dd($year, $electoral, $type, $request->all());

        switch ($type) {
            case 'electoral':
                $elct = Electoral::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
                if(isset($request->amount) && $request->amount != null) {
                    BusinessDefaulterExport::dispatch($year, $electoral, $name, $type, $request->amount, $request->operator);
                }else{
                    PrepareBusinessExport::dispatch($year, $electoral, $name, $type);
                }
                break;
            case 'community':
                $elct = Community::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
                PrepareBusinessExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'zonal':
                $elct = Zonal::where('code', $electoral)->first();
                $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
                PrepareBusinessExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'category':
                $elct = BusinessCategory::where('code', $electoral)->first();
                // $export = new NorminalRowExportBusiness(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
                PrepareBusinessExport::dispatch($year, $electoral, $name, $type);
                break;
            case 'type':
                $elct = BusinessType::where('code', $electoral)->first();
                // $export = new NorminalRowExportProperty(2019, '1401');
                $name = strtoupper(str_slug($elct->description) . '-business-norminal-row-' . $year) . '.xlsx';
                PrepareBusinessExport::dispatch($year, $electoral, $name, $type);
                break;

            default:
                // code...
                break;
        }

        return redirect()->back();
    }

    public function downloadLink()
    {
        $data = \App\TemporalFiles::first();
        $data->available = 0;
        $data->save();
        // dd($data);
        $page = File::put('images/kbills/' . $data->filename, $data->file);
        return Response::download(public_path('images/kbills/' . $data->filename));
    }

    public function checkLinkAvailable()
    {
        $response;
        $data = \App\TemporalFiles::first();
        if ($data) {
            if ($data->available == 1) {
                $response = 'success';
            } else {
                $response = 'failed';
            }
        } else {
            $response = 'none';
        }

        return response()->json(['status' => $response]);
    }







    /** Business Listings */

    public function businessListingSearch()
    {
        return view('advanced.report.business.search-board');
    }



    public function businessListing(Request $request)
    {

        // dd($request->all());

        if ($request->loc != "a") return $this->businessSearchListingDetails($request->all());

        $location = $request['location'];
        $year = $request['year'];


        // return ['result'=>$electorals];
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        switch ($location) {
            case 'electoral':
                $electorals = $this->electoralBusiness->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->paginate(10)->appends(request()->query());
                return view('advanced.report.business.business-listing', compact('electorals', 'location', 'year', 'wcpScript'));
            case 'zonal':
                $electorals = $this->zonalProperty->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->paginate(10)->appends(request()->query());
                return view('advanced.report.business.business-zonal-listing', compact('electorals', 'location', 'year', 'wcpScript'));
            case 'type':
                $electorals = $this->businessType->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->paginate(10)->appends(request()->query());
                return view('advanced.report.business.business-type-listing', compact('electorals', 'location', 'year', 'wcpScript'));
            case 'category':
                $electorals = $this->businessCategory->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->paginate(10)->appends(request()->query());
                return view('advanced.report.business.business-category-listing', compact('electorals', 'location', 'year', 'wcpScript'));
            case 'community':
                // dd('ok');
                $communities = $this->communityBusiness->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->paginate(10)->appends(request()->query());

                return view('advanced.report.business.business-listing-communities', compact('communities', 'location', 'year', 'wcpScript'));

                break;

            default:
                return redirect()->back;
                break;
        }

        return false;
    }

    public function businessSearchListingDetails($data)
    {
        // dd($data);

        $location = '';
        $year = '';
        $loc = '';
        if (array_key_exists('location', $data)) {
            $location = $data['location'] ?: '';
            $url = url('/') . '/console/advanced/report/business/' . $data['location'] . '/' . $data['loc'] . '/' . $data['year'] . '/';
        } else {
            $parts = parse_url(URL::previous());
            parse_str($parts['query'], $query);
            $url = url('/') . '/console/advanced/report/business/' . $query['location'] . '/' . $query['loc'] . '/' . $query['year'] . '/';
            // dd($url);
        }
        if (array_key_exists('year', $data)) {
            $year = $data['year'] ?: '';
        }
        if (array_key_exists('loc', $data)) {
            $loc = $data['loc'] ?: '';
        }

        // dd($loc, $location);

        // $electoral = $this->electoralProperty->where('code', $loc)->get();
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        if($location == 'electoral') {
            $electoral = $this->electoralBusiness->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
            }])->first();
            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            $code = $loc;
        }

        if($location == 'zonal') {
            $electoral = $this->zonalProperty->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
            }])->first();
            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            $code = $loc;
        }
        if($location == 'community') {
            $electoral = $this->communityBusiness->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
            }])->first();
            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            $code = $loc;
        }


        if($location == 'type') {
            $electoral = $this->businessType->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
            }])->first();
            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            $code = $loc;
        }

        if($location == 'category') {
            $electoral = $this->businessCategory->where('code', $loc)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
            }])->first();
            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 30, $page = null, $baseUrl = $url, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            $code = $loc;
        }
        // dd($electoral->bills->count());

        // return ['result'=>$bills];
        return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'wcpScript', 'info', 'totalBill', 'electoral', 'code'));
    }





    public function businessListingDetails(Request $request, $location, $code, $year)
    {
        // dd($location);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());


        switch ($location) {
            case 'electoral':
                $electoral = $this->electoralBusiness->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;
            case 'type':
                $electoral = $this->businessType->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;
            case 'category':
                $electoral = $this->businessCategory->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;
            case 'zonal':
                $electoral = $this->zonalProperty->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;
            case 'community':
                $electoral = $this->communityBusiness->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                    $q->where('year', $year);
                })->with(['bills' => function ($query) use ($year) {
                    $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
                }])->first();

                $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = null, $baseUrl = $request->url() . '/', $options = []) : [];
                $info = $electoral ? $electoral->description : '';
                $totalBill = $electoral ? $electoral->bills->count() : '';
                // dd($bills);
                return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
                break;

            default:
                return redirect()->back;
                break;
        }

        return view('advanced.report.business.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code'));
    }

    public function apiBusinessListing()
    {
        $data = \App\Bill::with(['business'])->limit('4')->get()->groupBy('electoral_name');
        // $data = \App\Bill::with(['property'])->limit('4')->get()->sortBy('property.electoral.description');
        return response()->json(['data' => $data]);
    }







    /** Feefixing Listings */

    public function feefixingListingSearch()
    {
        return view('advanced.report.feefixing.search');
    }

    public function feefixingListing(Request $request)
    {
        $year = $request->year;
        $account = $request->account;
        $fnx = false;
        if ($account == 'property') :
            if ($year == date('Y')) :

                $feefixing = \App\PropertyType::with('categories')->orderBy('code', 'asc')->get();
            else :
                $fnx = true;
                $feefixing = \App\PropertyType::with(['fixcategories' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])->orderBy('code', 'asc')->get();
            endif;
            return view('advanced.report.feefixing.listing', compact('feefixing', 'year', 'account', 'fnx'));
        endif;
        if ($account == 'business') :
            if ($year == date('Y')) :
                $feefixing = \App\BusinessType::with('categories')->orderBy('code', 'asc')->get();
            else :
                $fnx = true;
                $feefixing = \App\BusinessType::with(['fixcategories' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])->orderBy('code', 'asc')->get();
            endif;

            return view('advanced.report.feefixing.listing', compact('feefixing', 'year', 'account', 'fnx'));
        endif;

        return redirect()->back();
    }

    public function paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = [])
    {

        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        $lap = new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }

    public function defaultersReport()
    {
        return view('advanced.report.defaulters.index');
    }

    public function defaultersReportPost(Request $request)
    {
        // $this->propertyDefaulters($request->all());

        // dd($request->all());

        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        // dd($request['bill_year']);
        $year = $request->bill_year;
        $operator = $request->operator;
        $amount = $request->amount;

        if ($request->account_type == 'p') {
            $zonals = $this->electoralProperty->with(['bills' => function ($query) use ($year, $operator, $amount) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->where('account_balance', "{$operator}", $amount);
            }])->paginate(50);
            $location = 'defaulters';
            return view('advanced.report.defaulters.defaulter-list-property', compact('operator', 'zonals', 'location', 'year', 'wcpScript', 'amount'));
        }
        if ($request->account_type == 'b') {
            $electorals = $this->electoralBusiness->whereHas('bills')->with(['bills' => function ($query) use ($year, $operator, $amount) {
                $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->where('account_balance', "{$operator}", $amount);
            }])->paginate(50);
            $location = 'defaulters';
            return view('advanced.report.defaulters.defaulter-list-business', compact('operator', 'electorals', 'location', 'year', 'wcpScript', 'amount'));
        }

        return back();
    }

    public function defaultersReportPostDetails(Request $request)
    {
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        $year = $request->year;
        $operator = $request->operator;
        $amount = $request->amount;
       $code = $request->code;
       $location = 'electoral';
       $type = $request->type;
       $pg = $request->page ? intval($request->page) : 1;

    //    http://127.0.0.1:8000/console/reports/adv/defaulters/details?type=business&code=KY001&operator=%3E&location=electoral&year=2020&amount=50&page=2

    //    http://127.0.0.1:8000/console/reports/adv/defaulters/details?type=property&code=KY001&operator=%3E&location=defaulters&year=2020&amount=50

       if($type == 'property') {
           $electoral = $this->electoralProperty->where('code', $code)->whereHas('bills', function ($q) use ($year) {
               $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year, $amount, $operator) {
                $query->with('properties')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->where('account_balance', "{$operator}", $amount)->orderBy('account_no', 'asc');
            }])->first();

            $route = route('report.defaulters.details', ['type' => 'property', 'code' => $electoral->code, 'operator' => $operator, 'location' => $location, 'year' => $year, 'amount' => $amount]);

            // dd(count($electoral->bills));

            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = $pg, $baseUrl = $route , $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            return view('advanced.report.defaulters.property-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code', 'amount', 'operator'));
        }

        if($type == 'business') {
            $electoral = $this->electoralBusiness->where('code', $code)->whereHas('bills', function ($q) use ($year) {
                $q->where('year', $year);
            })->with(['bills' => function ($query) use ($year, $amount, $operator) {
                $query->with('businesses')->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->where('account_balance', "{$operator}", $amount)->orderBy('account_no', 'asc');
            }])->first();

            $route = route('report.defaulters.details', ['type' => 'business', 'code' => $electoral->code, 'operator' => $operator, 'location' => $location, 'year' => $year, 'amount' => $amount]);

            $bills = $electoral ? $this->paginate($electoral->bills, $perPage = 20, $page = $pg, $baseUrl = $route, $options = []) : [];
            $info = $electoral ? $electoral->description : '';
            $totalBill = $electoral ? $electoral->bills->count() : '';
            return view('advanced.report.defaulters.business-listing-details', compact('bills', 'year', 'location', 'info', 'wcpScript', 'totalBill', 'electoral', 'code', 'amount', 'operator'));
        }

        return back();
    }

    public function propertyDefaulters($request)
    {
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        // dd($request['bill_year']);
        $year = $request['bill_year'];
        $operator = $request['operator'];
        $amount = $request['amount'];

        $electorals = $this->electoralProperty->with(['bills' => function ($query) use ($year, $operator, $amount) {
            $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->where('arrears', "{{$operator}}", $amount);
        }])->paginate(50);
        // dd($electorals);
        // $elects = $this->electoralProperty->with(['bills'=>function($query) use ($year) {
        //    $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('p'))->orderBy('account_no', 'asc');
        // }])->get();
        // return ['result' => $electorals];
        // $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        $location = 'electoral';
        return view('advanced.report.defaulters.defaulter-list-property', compact('operator', 'electorals', 'location', 'year', 'wcpScript', 'amount'));
    }
}
