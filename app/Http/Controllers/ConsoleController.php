<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jobs\CleanBillsTable;
use App\Jobs\FloatCleanBills;
use App\Jobs\SetBillLocation;
use App\Jobs\ReplaceAccountBalance;
use App\Jobs\PropertyOwnerFix;

class ConsoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect()->route('console.dashboard');
    }

    public function dashboard()
    {
        // return view('console.prints.index');
        return view('console.console');
    }
    public function back()
    {
        return redirect()->back();
    }

    public function construction2()
    {



      // SetBillLocation::dispatch();
      FloatCleanBills::dispatch();
      // dd('p');
      return redirect()->route('processing');
        // return view('console.construction');
    }
    public function construction()
    {

      // $account = \App\Bill::orderBy('account_no', 'desc')->limit(10)->get();
      // dd($account);
      // $totalPaid = \App\Payment::where('account_no', 'MA13017034')->where('payment_year', '2018')->sum('amount_paid');
      // dd($totalPaid);

      // ReplaceAccountBalance::dispatch();
      // FloatCleanBills::dispatch();
      // dd('p');
      // return redirect()->route('processing');
        return view('console.construction');
    }
    public function construction3()
    {



      SetBillLocation::dispatch();
      // FloatCleanBills::dispatch();
      // dd('p');
      return redirect()->route('processing');
        // return view('console.construction');
    }

    public function construction4()
    {
      $bns = DB::table('abusua_tag')->orderBy('business_no', 'asc')->get();
      foreach ($bns as $bn) {
        if($bn->store_number == '' || $bn->store_number == null) continue;
        $business = \App\Business::where('business_no', $bn->business_no)->first();
        $business->store_number = $bn->store_number;
        $business->update();
      }
      dd('all done');
    }
    public function construction5()
    {
      $bns = \App\BusinessCategory::latest()->get();
      foreach ($bns as $bn) {
        if($bn->rate_pa == '' || $bn->rate_pa == null){
          $bn->rate_pa = $bn->min_charge;
          $bn->update();
        }

      }
      dd('all done');
    }

    public function construction6()
    {
      PropertyOwnerFix::dispatch();
      return redirect()->route('processing');
    }
}
