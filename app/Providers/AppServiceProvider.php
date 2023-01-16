<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;

use App\Event\BillWasGenerated;

use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Queue::before(function ( JobProcessing $event ) {
        Log::info('Job ready: ' . $event->job->resolveName());
        Log::info('Job startet: ' . $event->job->resolveName());
     });

      Queue::after(function (JobProcessed $event) {
        // echo '<script language="javascript">';
        // echo 'alert("Process completed")';
        // echo '</script>';
          // $bills = \App\Bill::with('property')->where('bill_type', 'p')->where('year', date("Y"))->orderBy('account_no', 'asc')->get();
          // dd($bills->count());
          // echo '<script language="javascript">';
          // echo 'console.log('.$event.')';
          // echo 'alert('.$event.')';
          // echo '</script>';
      });

      Queue::failing(function (JobFailed $event ) {
          Log::error('Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
