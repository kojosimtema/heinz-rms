<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class PropertyOwnerFix implements ShouldQueue
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
        // \App\Property::latest()->chunk(1000, function ($properties) {
        //   \App\Processing::create(['total' => \App\Property::latest()->count(), 'count' => 0, 'percentage' => 0]);
        //   foreach ($properties as $key => $property) {
        //     $owner = \App\PropertyOwner::create([
        //       'name' => $property->property_owner,
        //       'owner_id' => env('ASSEMBLY_CODE')[0].$property->property_owner[0].sprintf('%03d', $key)
        //     ]);
        //     if($owner) {
        //       $property->property_owner = $owner->owner_id;
        //       $property->update();
        //     }
        //     $process = \App\Processing::first();
        //     if($process->count == 0) {
        //       $process->count == $process->count += 1;
        //     } else {
        //       $process->count == $process->count += 1;
        //     }
        //     $process->percentage = (int)(($process->count / $process->total) * 100);
        //     $process->save();
        //   }
        // });
        \App\Property::latest()->chunk(1000, function ($properties) {
          \App\Processing::create(['total' => \App\Property::latest()->count(), 'count' => 0, 'percentage' => 0]);
          foreach ($properties as $key => $property) {
            $owner = \App\PropertyOwner::create([
              'name' => $property->property_owner,
              'owner_id' => env('ASSEMBLY_CODE')[0].$property->property_owner[0].sprintf('%03d', $key)
            ]);
            if($owner) {
              $property->property_owner = $owner->owner_id;
              $property->update();
            }
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
