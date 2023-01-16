<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReplaceAccountBalance implements ShouldQueue
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

      \App\Payment::whereNotNull('created_at')->where('data_type', 'P')->chunk(1000, function ($payments) {
        \App\Processing::create(['total' => \App\Payment::whereNotNull('created_at')->where('data_type', 'P')->count(), 'count' => 0, 'percentage' => 0]);
        foreach ($payments as $key => $payment):
          $bill = \App\Bill::where('account_no', $payment->account_no)->where('year', '2018')->first();
          $cc = floatval($bill->current_amount) + floatval($bill->total_paid);
          $vv = floatval($bill->account_balance) - floatval($bill->total_paid);
          $bill->current_amount = number_format((float)$cc, 2, '.', '');
          $bill->account_balance = number_format((float)$vv, 2, '.', '');
          $bill->is_current = 1;

          $bill->update();

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
