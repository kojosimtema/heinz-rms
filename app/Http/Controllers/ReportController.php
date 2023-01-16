<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\Property;
use App\Business;
use App\Bill;

use App\Jobs\PropertyReport;
use League\Csv\Reader;
use League\Csv\Statement;

class ReportController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    /** Property */

    public function propertyAccountIndex()
    {
      return view('console.reports.property.account')->with('status', false);
    }

    public function propertyAccountIndexPost(Request $request)
    {
      $todaysdate = date("Y-m-d");
      $firstdate = Property::whereNotNull('created_at')->first() ? date(Property::whereNotNull('created_at')->first()->created_at) : date("Y-m-d");

      $properties = Property::with(['type', 'owner', 'category', 'tas', 'electoral', 'zonal'])->latest();

      if($request->has('type') && $request->input('type') != null):
        $properties->where('property_type', $request->input('type'));
      endif;
      if($request->has('category') && $request->input('category') != null):
        $properties->where('property_category', $request->input('category'));
      endif;
      if($request->has('owner') && $request->input('owner') != null):
        $properties->where('property_owner', $request->input('owner'));
      endif;
      if($request->has('start_date') && $request->input('start_date') != null):
        if ($request->has('end_date') && $request->input('end_date') != null) {
          $properties->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }else{
          $properties->whereBetween('created_at', [$request->input('start_date'), $todaysdate]);
        }
      elseif($request->has('end_date') && $request->input('end_date') != null):
        if ($request->has('start_date') && $request->input('start_date') != null) {
          $properties->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }else{
          $properties->whereBetween('created_at', [$firstdate, $request->input('end_date')]);
        }
      endif;
      if($request->has('collector') && $request->input('collector') != null):
        $properties->where('client', $request->input('collector'));
      endif;

      if ($properties->count() < 1) dd("no data found!");

      $processJob = \App\ProcessedJob::create([
        'total' => $properties->count(), 'count' => 0, 'percentage' => 100,
        'job_id' => (string) Str::uuid(), 'title' => 'processing property reports', 'is_completed' => 1
      ]);

      $csvExporter = new \Laracsv\Export();

      // if($request->has('fields')):
      //   $csvExporter->build($properties->get(), $request->input('fields'))
      //               ->download('propertyReport-'.$processJob->job_id.'.csv');
      // else:
      //   $csvExporter->build($properties->get(), [
      //     'property_no' => 'account number', 'type.description' => 'property type', 'category.description' => 'property category',
      //     'zonal.description' => 'zonal council', 'tas.description' => 'town area council', 'electoral.description' => 'electoral area',
      //     'owner.name' => 'property owner', 'owner.phone' => 'phone number', 'rateable_value' => 'rateable value', 'client' => 'collector email'
      //   ])->download('propertyReport-'.$processJob->job_id.'.csv');
      // endif;

      $csvExporter->build($properties->get(), [
        'property_no' => 'account number', 'type.description' => 'property type', 'category.description' => 'property category',
        'zonal.description' => 'zonal council', 'tas.description' => 'town area council', 'electoral.description' => 'electoral area',
        'owner.name' => 'property owner', 'owner.phone' => 'phone number', 'rateable_value' => 'rateable value', 'client' => 'collector email'
      ])->download('propertyReport-'.$processJob->job_id.'.csv');

      return redirect()->back()->with(['status'=> true, 'job' => $processJob->job_id]);
    }

    /** Business */

    public function businessAccountIndex()
    {
      return view('console.reports.business.account')->with('status', false);
    }

    public function businessAccountIndexPost(Request $request)
    {
      $todaysdate = date("Y-m-d");
      $firstdate = Business::whereNotNull('created_at')->first() ? date(Business::whereNotNull('created_at')->first()->created_at) : date("Y-m-d");

      $businesses = Business::with(['type', 'owner', 'category', 'tas', 'electoral', 'zonal'])->latest();

      if($request->has('type') && $request->input('type') != null):
        $businesses->where('business_type', $request->input('type'));
      endif;
      if($request->has('category') && $request->input('category') != null):
        $businesses->where('business_category', $request->input('category'));
      endif;
      if($request->has('owner') && $request->input('owner') != null):
        $businesses->where('business_owner', $request->input('owner'));
      endif;
      if($request->has('start_date') && $request->input('start_date') != null):
        if ($request->has('end_date') && $request->input('end_date') != null) {
          $businesses->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }else{
          $businesses->whereBetween('created_at', [$request->input('start_date'), $todaysdate]);
        }
      elseif($request->has('end_date') && $request->input('end_date') != null):
        if ($request->has('start_date') && $request->input('start_date') != null) {
          $businesses->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }else{
          $businesses->whereBetween('created_at', [$firstdate, $request->input('end_date')]);
        }
      endif;
      if($request->has('collector') && $request->input('collector') != null):
        $businesses->where('client', $request->input('collector'));
      endif;

      if ($businesses->count() < 1) dd("no data found!");

      $processJob = \App\ProcessedJob::create([
        'total' => $businesses->count(), 'count' => 0, 'percentage' => 100,
        'job_id' => (string) Str::uuid(), 'title' => 'processing business reports', 'is_completed' => 1
      ]);

      $csvExporter = new \Laracsv\Export();

      // if($request->has('fields')):
      //   $csvExporter->build($businesses->get(), $request->input('fields'))
      //               ->download('businessReport-'.$processJob->job_id.'.csv');
      // else:
      //   $csvExporter->build($businesses->get(), [
      //     'business_no', 'business_type', 'business_category', 'business_name', 'zonal_id', 'tas_id', 'electoral_id',
      //     'business_owner', 'rateable_value', 'client'
      //   ])->download('businessReport-'.$processJob->job_id.'.csv');
      // endif;

      $csvExporter->build($businesses->get(), [
        'business_no' => 'account number', 'type.description' => 'property type', 'category.description' => 'property category',
        'zonal.description' => 'zonal council', 'tas.description' => 'town area council', 'business' => 'business name',
        'electoral.description' => 'electoral area', 'owner.name' => 'business owner', 'owner.phone' => 'phone number',
        'rateable_value' => 'rateable value', 'client' => 'collector email'
      ])->download('businessReport-'.$processJob->job_id.'.csv');

      return redirect()->back()->with(['status'=> true, 'job' => $processJob->job_id]);
    }


    /** Bills */

    public function billsAccountIndex()
    {
      return view('console.reports.bills.account')->with('status', false);
    }

    public function billsAccountIndexPost(Request $request)
    {
      $todaysdate = date("Y-m-d");

      $bills = Bill::latest();

      if($request->has('account') && $request->input('account') != null):
        $bills->where('account_no', $request->input('account'));
      endif;
      if($request->has('year') && $request->input('year') != null):
        $bills->where('year', $request->input('year'));
      endif;
      if($request->has('bill_date') && $request->input('bill_date') != null):
        $bills->where('bill_date', $request->input('bill_date'));
      endif;

      if ($bills->count() < 1) dd("no data found!");

      $processJob = \App\ProcessedJob::create([
        'total' => $bills->count(), 'count' => 0, 'percentage' => 100,
        'job_id' => (string) Str::uuid(), 'title' => 'processing bills reports', 'is_completed' => 1
      ]);

      $csvExporter = new \Laracsv\Export();

      // if($request->has('fields')):
      //   $csvExporter->build($bills->get(), $request->input('fields'))
      //               ->download('billsReport-'.$processJob->job_id.'.csv');
      // else:
      //   $csvExporter->build($bills->get(), [
      //     'account_no', 'rate_pa', 'rateable_value', 'current_amount', 'arrears',
      //     'rate_imposed', 'total_paid', 'account_balance', 'bill_type', 'year', 'bill_date'
      //   ])->download('billsReport-'.$processJob->job_id.'.csv');
      // endif;

      $csvExporter->build($bills->get(), [
        'account_no' => 'account no', 'rate_pa' => 'rate pa', 'rateable_value' => 'rateable value', 'current_amount' => 'current amount', 'arrears' => 'arrears',
        'rate_imposed' => 'rate impose', 'total_paid' => 'total paid', 'account_balance' => 'account balance', 'bill_type' => 'bill type', 'year' => 'bill year ',
        'bill_date' => 'bill date'
      ])->download('billsReport-'.$processJob->job_id.'.csv');

      return redirect()->back()->with(['status'=> true, 'job' => $processJob->job_id]);
    }


    





}
