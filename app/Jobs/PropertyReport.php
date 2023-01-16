<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PropertyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    protected $processJob;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $processJob)
    {
        $this->request = $request;
        $this->processJob = $processJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $todaysdate = date("Y-m-d");
      $firstdate = date(\App\Property::whereNotNull('created_at')->first()->created_at);

      $properties = \App\Property::with(['type', 'owner', 'category'])->latest();

      if($this->request['type'] != null):
        $properties->where('property_type', $this->request['type']);
      endif;
      if($this->request['category'] != null):
        $properties->where('property_category', $this->request['category']);
      endif;
      if($this->request['owner'] != null):
        $properties->where('property_owner', $this->request['owner']);
      endif;
      if($this->request['start_date'] != null):
        if ($this->request['end_date'] != null) {
          $properties->whereBetween('created_at', [$this->request['start_date'], $this->request['end_date']]);
        }else{
          $properties->whereBetween('created_at', [$this->request['start_date'], $todaysdate]);
        }
      elseif($this->request['end_date'] != null):
        if ($this->request['start_date'] != null) {
          $properties->whereBetween('created_at', [$this->request['start_date'], $this->request['end_date']]);
        }else{
          $properties->whereBetween('created_at', [$firstdate, $this->request['end_date']]);
        }
      endif;
      if($this->request['collector'] != null):
        $properties->where('client', $this->request['collector']);
      endif;

      $process = \App\ProcessedJob::where('job_id', $this->processJob)->first();
      // dd($this->processJob, $process);
      $process->update(['total' => $properties->count(), 'is_completed' => 1, 'percentage' => 100]);

      $csvExporter = new \Laracsv\Export();
      $csvExporter->build($properties->get(), ['property_no', 'property_type'])->download();
    }
}
