<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class FloatCleanBills implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Processing::truncate();

        \App\Bill::orderBy('id')->whereBetween('year', [2007, 2015])->chunk(500, function ($bills) {
          \App\Processing::create(['total' => \App\Bill::latest()->count(), 'count' => 0, 'percentage' => 0]);
          foreach ($bills as $key => $bill):

            $bill->accumulated_arrears = floatval($bill->accumulated_arrears);
            $bill->accumulated_total_paid = floatval($bill->accumulated_total_paid);
            $bill->accumulated_adjust_arrears = floatval($bill->accumulated_adjust_arrears);
            $bill->accumulated_current_amount = floatval($bill->accumulated_current_amount);
            $bill->accumulated_account_balance = floatval($bill->accumulated_account_balance);

            $bill->save();

            $process = \App\Processing::first();
            if($process->count == 0) {
              $process->count == $process->count += 1;
            } else {
              $process->count == $process->count += 1;
            }
            $process->percentage = (int)(($process->count / $process->total) * 100);
            $process->save();

          endforeach;
        });
    }
}
