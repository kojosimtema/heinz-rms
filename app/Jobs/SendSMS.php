<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\SetupController as Setup;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    // protected $message;

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
      // dd($this->request['message']);
      // \App\InstantSMS::truncate();
      \App\Processing::truncate();

      $phoneArray = [];
      if($this->request['account'] == "all"):
        if($this->request['zonal']):
          $properties = ($this->request['zonal'] == "all")
                        ? \App\Property::with(['owner'])->orderBy('property_no', 'asc')->get()
                        : \App\Property::with(['owner'])->where('zonal_id', $this->request['zonal'])->orderBy('property_no', 'asc')->get();
          foreach ($properties  as $property) {
            if($property->owner && $property->owner->phone){
              array_push($phoneArray, $property->owner->phone);
            }
          }

          $businesses = ($this->request['zonal'] == "all")
                        ? \App\Business::with(['owner'])->orderBy('business_no', 'asc')->get()
                        : \App\Business::with(['owner'])->where('zonal_id', $this->request['zonal'])->orderBy('business_no', 'asc')->get();
          foreach ($businesses  as $business) {
            if($business->owner && $business->owner->phone){
              array_push($phoneArray, $business->owner->phone);
            }
          }
        endif;

        // Electoral

        if($this->request['electoral']):
          $properties = ($this->request['electoral'] == "all")
                        ? \App\Property::with(['owner'])->orderBy('property_no', 'asc')->get()
                        : \App\Property::with(['owner'])->where('electoral_id', $this->request['electoral'])->orderBy('property_no', 'asc')->get();
          foreach ($properties  as $property) {
            if($property->owner && $property->owner->phone){
              array_push($phoneArray, $property->owner->phone);
            }
          }

          $businesses = ($this->request['electoral'] == "all")
                        ? \App\Business::with(['owner'])->orderBy('business_no', 'asc')->get()
                        : \App\Business::with(['owner'])->where('electoral_id', $this->request['electoral'])->orderBy('business_no', 'asc')->get();
          foreach ($businesses  as $business) {
            if($business->owner && $business->owner->phone){
              array_push($phoneArray, $business->owner->phone);
            }
          }
        endif;


      endif;

      \App\Processing::create(['total' => count($phoneArray), 'count' => 0, 'percentage' => 0]);
      foreach($phoneArray as $key => $number):
        if($number[0] == '0') $number = ltrim($number, '0');
        $number = substr($number, 0, 9);
        if($number == "NULL" || $number == "") continue;
        $number = '233' . $number;
        $smsRes = Setup::sendSms($number, $this->request['message']);
        if($smsRes == 'good'){
          \App\InstantSMS::create(['phone' => $number, 'sent' => 1, 'failed' => 0, 'message' => $this->request['message']]);
        }else{
          \App\InstantSMS::create(['phone' => $number, 'sent' => 0, 'failed' => 1, 'message' => $this->request['message']]);
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
