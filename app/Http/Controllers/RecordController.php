<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Bill;
use App\Setting;
use App\Payment;
use Carbon\Carbon;

class RecordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getBills()
    {

        $bills = Bill::with('property')->orderBy('account_no', 'asc')->get();
        // dd($type);
        // dd($property);
        // if($year = request('year')):
        //     $properties->whereYear('created_at', $year)->get();
        //     dd($properties);
        // endif;
        // $properties->get();
        // dd($bills);
        return view('console.property.records.bills', compact('bills'));
    }
    public function getPaymentsProperty()
    {
        // $bills = \App\Bill::latest()->get();
        return view('console.property.payments.payment');
    }
    public function getpaymentsBusiness()
    {
        // $bills = \App\Bill::latest()->get();
        return view('console.business.payments.payment');
    }
    public function savePaymentProperty(Request $request)
    {
      // dd($request->all());
        $payment = $request->validate([
            'account_no' => 'required',
            'collector_id' => 'required',
            'cashier_id' => '',
            'amount_paid' => 'required',
            'payment_mode' => 'required',
            'gcr_number' => 'required',
            'payment_date' => 'required',
            'cprn' => '',
        ]);

        $collector = \App\Collector::where('id', $payment['collector_id'])->first();
        unset($payment[1]);
        if($request->cashier_id):
          $cashier = \App\Cashier::where('id', $payment['cashier_id'])->first();
          unset($payment[2]);
          $payment = array_merge($payment, ['cashier_id' => $cashier->cashier_id]);
        endif;
        // $payment = array_merge($payment, ['payment_year' => Carbon::now()->year,
        //     'payment_type' => 'P', 'account_no' => 'empty',
        //     'amount_paid' => floatval($payment['amount_paid']),
        //     'collector_id' => $collector->collector_id
        // ]);

        // dd($payment);

        $dateArray = explode('-', $payment['payment_date']);
        $payment = array_merge($payment, ['payment_year' => current($dateArray), 'collector_id' => $collector->collector_id, 'data_type' => 'P']);
        // unset($info['date']);
        if($this->recalculateGCR($payment['gcr_number'], $payment['collector_id'])):
            if($this->recalculateBill($payment['account_no'], $payment['amount_paid'])):
              $paymentR = Payment::create($payment);
              // if($paymentR) {
              //   $account = (strtoupper($paymentR->data_type) == strtoupper('p'))
              //               ? Property::with(['type', 'category', 'owner'])->where('property_no', $payment->account_no)->first()
              //               : Business::with(['type', 'category', 'owner'])->where('business_no', $payment->account_no)->first();
              //   // dd($account->owner);
              //   if ($account->owner && $account->owner->phone) {
              //     $mobile = $account->owner->phone;
              //     if($mobile[0] == '0') $mobile = ltrim($mobile, '0');
              //     $mobile = '233' . $mobile;
              //     // $mobile = '233248160008';
              //     $bill = Bill::where('account_no', $payment->account_no)->first();
              //     $message = 'Dear ' . $account->owner ? $account->owner->name : 'sir/madma' . ' of PROPERTY ACC: '. $payment->account_no . '. You have been credited with a payment amount of GHc' .$payment->amount_paid . ' with a GCR No '. $payment->gcr_number . ' and your current balance is GHc ' . $bill->current_amount . '.Thanks';
              //     $smsRes = Setup::sendSms($mobile, $message);
              //     // dd($smsRes, 'o');
              //     if ($smsRes == 'good') {
              //       return response()->json(['status' => 'success', 'data' => 'Saved and SMS sent', 'payment' => $payment, 'account' => $bill, 'owner' => $account->owner ? $account->owner->name : 'no owner name found']);
              //     }else{
              //       return response()->json(['status' => 'success', 'data' => 'Saved..Sending message error']);
              //     }
              //   }else {
              //     return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
              //   }
              //
              // }
            endif;

        endif;

        return redirect()->route('property.payments.payment');
    }

    public function savePaymentBusiness(Request $request)
    {
      // dd($request->all());
        $payment = $request->validate([
            'account_no' => 'required',
            'collector_id' => 'required',
            'cashier_id' => '',
            'amount_paid' => 'required',
            'payment_mode' => 'required',
            'gcr_number' => 'required',
            'payment_date' => 'required',
            'cprn' => '',
        ]);

        $collector = \App\Collector::where('id', $payment['collector_id'])->first();
        unset($payment[1]);
        if($request->cashier_id):
          $cashier = \App\Cashier::where('id', $payment['cashier_id'])->first();
          unset($payment[2]);
          $payment = array_merge($payment, ['cashier_id' => $cashier->cashier_id]);
        endif;
        // $payment = array_merge($payment, ['payment_year' => Carbon::now()->year,
        //     'payment_type' => 'P', 'account_no' => 'empty',
        //     'amount_paid' => floatval($payment['amount_paid']),
        //     'collector_id' => $collector->collector_id
        // ]);

        // dd($payment);

        $dateArray = explode('-', $payment['payment_date']);
        $payment = array_merge($payment, ['payment_year' => current($dateArray), 'collector_id' => $collector->collector_id, 'data_type' => 'B']);
        // unset($info['date']);
        if($this->recalculateGCR($payment['gcr_number'], $payment['collector_id'])):
            if($this->recalculateBill($payment['account_no'], $payment['amount_paid'])):
              $paymentR = Payment::create($payment);
              // if($paymentR) {
              //   $account = (strtoupper($paymentR->data_type) == strtoupper('p'))
              //               ? Property::with(['type', 'category', 'owner'])->where('property_no', $payment->account_no)->first()
              //               : Business::with(['type', 'category', 'owner'])->where('business_no', $payment->account_no)->first();
              //   // dd($account->owner);
              //   if ($account->owner && $account->owner->phone) {
              //     $mobile = $account->owner->phone;
              //     if($mobile[0] == '0') $mobile = ltrim($mobile, '0');
              //     $mobile = '233' . $mobile;
              //     // $mobile = '233248160008';
              //     $bill = Bill::where('account_no', $payment->account_no)->first();
              //     $message = 'Dear ' . $account->owner ? $account->owner->name : 'sir/madma' . ' of PROPERTY ACC: '. $payment->account_no . '. You have been credited with a payment amount of GHc' .$payment->amount_paid . ' with a GCR No '. $payment->gcr_number . ' and your current balance is GHc ' . $bill->current_amount . '.Thanks';
              //     $smsRes = Setup::sendSms($mobile, $message);
              //     // dd($smsRes, 'o');
              //     if ($smsRes == 'good') {
              //       return response()->json(['status' => 'success', 'data' => 'Saved and SMS sent', 'payment' => $payment, 'account' => $bill, 'owner' => $account->owner ? $account->owner->name : 'no owner name found']);
              //     }else{
              //       return response()->json(['status' => 'success', 'data' => 'Saved..Sending message error']);
              //     }
              //   }else {
              //     return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
              //   }
              //
              // }
            endif;

        endif;

        return redirect()->route('business.payments.payment');
    }

    protected function recalculateBill($account, $amount)
    {
      $max = Bill::where('account_no', $account)->max('year');
      $bill = Bill::where('account_no', $account)->where('year', $max)->first();
      // $bill = Bill::where('account_no', $account)->first();
      $totalPayment = floatval($bill->total_paid) + floatval($amount);
      $checkBal = floatval($bill->account_balance) - floatval($amount);
      $balance = $checkBal == floatval(0) ? floatval(0): $checkBal;
      $bill->update(['account_balance' => $balance, 'total_paid' => $totalPayment]);
      return true;
    }

    protected function recalculateGCR($gcr, $collector)
    {
      // dd($gcr, $collector);
      $data = \App\EnumGcr::where('id_collector', $collector)->where('gcr_number', $gcr)->first();
      // dd($data);
      $data->update(['is_used' => 1]);
      return true;
    }

    public function previewBill($query)
    {
        $bill = Bill::with('property')->where('id', $query)->first();
        $setting = Setting::latest()->first();
        // dd($bill);
        $print_data = [
            'account_no' => $bill->account_no, 'name' => $bill->property->owner->name,
            'address' => $bill->property->address, 'property_type' => $bill->property->type->description,
            'property_category' => $bill->property->category->description, 'rateable_value' => $bill->rateable_value,
            'rate_imposed' => $bill->rate_pa, 'bill_year' => $bill->year, 'sub_metro' => $bill->property->zonal->description, 'tas' => $bill->property->tas->description,
            'electoral' => $bill->property->electoral->description, 'street' => 'unknown', 'previous_year' => 0.0, 'amount_paid' => 0.0, 'arrears' => $bill->arrears,
            'current_fees' => $bill->current_amount, 'total_amount' => $bill->total_payment
        ];
        // dd($print_data);
        // dd($bill->property->owner->name);
        return view('console.property.records.preview-bills', compact('print_data', 'setting'));
    }

}
