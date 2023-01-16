<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;

use App\Http\Controllers\BillingController as Billing;

class PrepareBills implements ShouldQueue
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

        if($this->request['account'] == "property"):

          \App\Property::latest()->chunk(1000, function ($properties) {
            if ($properties->count() == 0) dd('No properties data found!');
            \App\Processing::create(['total' => \App\Property::latest()->count(), 'count' => 0, 'percentage' => 0]);
              foreach ($properties as $property) {
                Billing::initPropertyBill($property, $this->request['feefixing'], $this->request['year']);
                $process = \App\Processing::first();
                if($process->count == 0) {
                  $process->count == $process->count += 1;
                } else {
                  $process->count == $process->count += 1;
                }
                $process->percentage = (int)(($process->count / $process->total) * 100);
                $process->save();
              }
          });
          return redirect()->route('processing');
        else:
          \App\Business::latest()->chunk(100, function ($businesses) {
            if ($businesses->count() == 0) dd('No business data found!');
            \App\Processing::create(['total' => \App\Business::latest()->count(), 'count' => 0, 'percentage' => 0]);
              foreach ($businesses as $business) {
                Billing::initBusinessBill($business, $this->request['feefixing'], $this->request['year']);
                $process = \App\Processing::first();
                if($process->count == 0) {
                  $process->count == $process->count += 1;
                } else {
                  $process->count == $process->count += 1;
                }
                $process->percentage = (int)(($process->count / $process->total) * 100);
                $process->save();
              }
          });
          return redirect()->route('processing');
        endif;
    }
}
