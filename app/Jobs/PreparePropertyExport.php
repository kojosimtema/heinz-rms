<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Excel;
use App\Exports\NorminalRowExportProperty;

use Illuminate\Support\Facades\Storage;
use File;
use Response;

class PreparePropertyExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $year;
    protected $electoral;
    protected $name;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($year, $electoral, $name, $type)
    {
      $this->year = $year;
      $this->electoral = $electoral;
      $this->name = $name;
      $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      ini_set('memory_limit','256M');
      \App\TemporalFiles::truncate();
      // \App\TemporalFiles::create(['file' => 'gt', 'filename' => $this->name]);
    //   (new NorminalRowExportProperty($this->year, $this->electoral, $this->type))->queue($this->name);
      $gt = Excel::raw(new NorminalRowExportProperty($this->year, $this->electoral, $this->type), \Maatwebsite\Excel\Excel::XLSX);
      \App\TemporalFiles::create(['file' => $gt, 'filename' => $this->name]);
      // $page = File::put(public_path('images/kbills/'.$this->name), $gt);

      // \App\TemporalFiles::create(['file_name' => $gt]);
      // return Response::download(public_path('images/kbills/'.$this->name));
    }
}
