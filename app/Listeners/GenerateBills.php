<?php

namespace App\Listeners;

use App\Events\BillWasGenerated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateBills
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BillWasGenerated  $event
     * @return void
     */
    public function handle(BillWasGenerated $event)
    {
      echo '<script language="javascript">';
      echo 'alert("Bill task completed")';
      echo '</script>';
    }
}
