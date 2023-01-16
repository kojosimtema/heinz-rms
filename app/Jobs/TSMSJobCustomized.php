<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\SetupController as Setup;

class TSMSJobCustomized implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      \App\Processing::truncate();

      if($this->request['type'] == 'p'):
        \App\Processing::create(['total' => count($this->request['account_box']), 'count' => 0, 'percentage' => 0]);
        foreach ($this->request['account_box'] as $key => $id) {
          $process = \App\Processing::first();
          if($process->count == 0) {
            $process->count == $process->count += 1;
          } else {
            $process->count == $process->count += 1;
          }

          $process->percentage = (int)(($process->count / $process->total) * 100);
          $process->save();


          $property = \App\Property::where('property_no', $id)->first();
          if(!$property) continue;
          if(count($property->bills) == 0) continue;
          $year = $property->bills->max('year');

          $account = \App\Property::with(['owner', 'bills' => function ($query) use ($year){
            $query->where('year', $year);
          }])->where('property_no', $id)->first();
          if(!$account) continue;
          if(!$account->owner) continue;
          $message = $this->request['message'];
          $phrase = array("#account", "#bill", "#arrears", "#owner");
          $phraseReplace   = array($account->property_no, $account->bills[0]->account_balance, $account->owner ? $account->owner->name : $account->owner_id);
          $newphrase = str_replace($phrase, $phraseReplace, $message);

          $number = $account->owner->phone;
          if(!$number) continue;
          if($number[0] == '0') $number = ltrim($number, '0');
          $number = substr($number, 0, 9);
          if($number == "NULL" || $number == "") continue;
          $number = '233' . $number;
          $smsRes = Setup::sendSms($number, $newphrase);
          if($smsRes == 'good'){
            \App\InstantSMS::create(['phone' => $number, 'sent' => 1, 'failed' => 0, 'message' => $newphrase]);
          }else{
            \App\InstantSMS::create(['phone' => $number, 'sent' => 0, 'failed' => 1, 'message' => $newphrase]);
          }



        }
      endif;

      if($this->request['type'] == 'b'):
        \App\Processing::create(['total' => count($this->request['account_box']), 'count' => 0, 'percentage' => 0]);
        foreach ($this->request['account_box'] as $key => $id) {
          $process = \App\Processing::first();
          if($process->count == 0) {
            $process->count == $process->count += 1;
          } else {
            $process->count == $process->count += 1;
          }

          $process->percentage = (int)(($process->count / $process->total) * 100);
          $process->save();


          $business = \App\Business::where('business_no', $id)->first();
          if(!$business) continue;
          if(count($business->bills) == 0) continue;
          $year = $business->bills->max('year');

          $account = \App\Business::with(['owner', 'bills' => function ($query) use ($year){
            $query->where('year', $year);
          }])->where('business_no', $id)->first();
          if(!$account) continue;
          if(!$account->owner) continue;
          $message = $this->request['message'];
          $phrase = array("#account", "#bill", "#arrears", "#owner");
          $phraseReplace   = array($account->business_no, $account->bills[0]->account_balance, $account->owner ? $account->owner->name : $account->owner_id);
          $newphrase = str_replace($phrase, $phraseReplace, $message);

          $number = $account->owner->phone;
          if(!$number) continue;
          if($number[0] == '0') $number = ltrim($number, '0');
          $number = substr($number, 0, 9);
          if($number == "NULL" || $number == "") continue;
          $number = '233' . $number;
          $smsRes = Setup::sendSms($number, $newphrase);
          if($smsRes == 'good'){
            \App\InstantSMS::create(['phone' => $number, 'sent' => 1, 'failed' => 0, 'message' => $newphrase]);
          }else{
            \App\InstantSMS::create(['phone' => $number, 'sent' => 0, 'failed' => 1, 'message' => $newphrase]);
          }



        }
      endif;
    }
}
