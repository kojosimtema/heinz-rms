<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;

class CleanBillsTable implements ShouldQueue
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



      DB::table('properties')->orderBy('id')->chunk(500, function ($properties) {
        \App\Processing::create(['total' => \App\Property::latest()->count(), 'count' => 0, 'percentage' => 0]);
        foreach ($properties as $key => $property) {
          $bills = DB::table('bills')->where('account_no', $property->property_no)->whereBetween('year', [2007, 2015])->get();

          if($bills->count() > 0 ):

            $billArrayInsert = [
              'account_no' => $property->property_no, 'rate_pa' => $bills->where('year', $bills->max('year'))->first()->rate_pa,
              'rateable_value' => $bills->where('year', $bills->max('year'))->first()->rateable_value,
              'current_amount' => $bills->where('year', $bills->max('year'))->first()->current_amount,
              'arrears' => $bills->where('year', $bills->max('year'))->first()->arrears,
              'rate_imposed' => $bills->where('year', $bills->max('year'))->first()->rate_imposed,
              'total_paid' => $bills->where('year', $bills->max('year'))->first()->total_paid,
              'bill_type' => $bills->where('year', $bills->max('year'))->first()->bill_type,
              'year' => $bills->where('year', $bills->max('year'))->first()->year,
              'account_balance' => $bills->where('year', $bills->max('year'))->first()->account_balance,
              'bill_date' => $bills->where('year', $bills->max('year'))->first()->bill_date,
              'adjust_arrears' => $bills->where('year', $bills->max('year'))->first()->adjust_arrears,
              'prepared_by' => 'ADMINISTRATOR',
              'accumulated_current_amount' => $bills->sum('current_amount'),
              'accumulated_arrears' => $bills->sum('arrears'),
              'accumulated_account_balance' => $bills->sum('account_balance'),
              'accumulated_adjust_arrears' => $bills->sum('adjust_arrears'),
              'accumulated_total_paid' => $bills->sum('total_paid'),
            ];

            $isCreated = \App\Bill::create($billArrayInsert);
            if($isCreated):
              $delete = DB::table('bills')->whereIn('id', $bills->pluck('id'))->delete();
            endif;
          endif;

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
    }
}
