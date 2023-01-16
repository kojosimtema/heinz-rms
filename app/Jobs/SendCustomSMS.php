<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\SetupController as Setup;

class SendCustomSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // protected $request;
    // protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->request = $request;
        // $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      // dd('ok');
      // \App\InstantSMS::truncate();
      \App\Processing::truncate();

      $bills = \App\Bill::with('property')->where('bill_type', 'p')->latest()->get();

      \App\Processing::create(['total' => $bills->count(), 'count' => 0, 'percentage' => 0]);

      // dd($phoneArray);
      foreach($bills as $bill):
        if(!$bill->property->owner || $bill->property->owner->phone == "") continue;
        $number = $bill->property->owner->phone;
        if($number[0] == '0') $number = ltrim($number, '0');
        $number = substr($number, 0, 9);
        if($number == "NULL" || $number == "") continue;
        $number = '233' . $number;
        $acc_type = ($bill->bill_type == 'p') ? 'property' : 'business';
        $message = "Dear ".$bill->property->owner->name." of ".$acc_type." number ".$bill->account_no." we hereby notify you of your ".$acc_type." Rate Bill for  Year ".$bill->year." is GHC ".$bill->current_amount." we will appreciate it if payment can be made to the Revenue Collector in your locality or at the Assembly revenue office. For any enquiries please contact the Revenue Head on 0549825660";
        // dump($number);
        $smsRes = Setup::sendSms($number, $message);
        if($smsRes == 'good'){
          \App\InstantSMS::create(['phone' => $number, 'sent' => 1, 'failed' => 0, 'message' => $message]);
        }else{
          \App\InstantSMS::create(['phone' => $number, 'sent' => 0, 'failed' => 1, 'message' => $message]);
        }
        $process = \App\Processing::first();
        if($process->count == 0) {
          $process->count == $process->count += 1;
        } else {
          $process->count == $process->count += 1;
        }
        $process->percentage = (int)(($process->count / $process->total) * 100);
        $process->save();
      endforeach;

    }
}
