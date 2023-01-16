<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class BillFix implements ShouldQueue
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
        $year = 2022;
        $newYear = $year - 1;
        
        $first_year = \App\Bill::where('account_no',  'bb-zc605289')->where('year', $year)->first();
       $second_year = \App\Bill::where('account_no',  'bb-zc605289')->where('year', $newYear)->first();

       $second_year->total_paid = $first_year->p_year_total_paid;
       $second_year->save();

       $second_year->account_balance = floatval($second_year->arrears + $second_year->rate_imposed) - floatval($second_year->total_paid);
       $second_year->save();

       $first_year->arrears = $second_year->account_balance;
       $first_year->original_arrears = $second_year->account_balance;
       $first_year->save();

       $first_year->account_balance = floatval($first_year->arrears + $first_year->rate_imposed) - floatval($first_year->total_paid);
       $first_year->save();
    }
}
