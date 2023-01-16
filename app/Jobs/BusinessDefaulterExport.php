<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Excel;
use App\Exports\DefaultersRowExportBusiness;

use Illuminate\Support\Facades\Storage;
use File;
use Response;


class BusinessDefaulterExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $year;
    protected $electoral;
    protected $name;
    protected $type;
    protected $amount;
    protected $operator;

    public function __construct($year, $electoral, $name, $type, $amount, $operator)
    {
      $this->year = $year;
      $this->electoral = $electoral;
      $this->name = $name;
      $this->type = $type;
      $this->amount = $amount;
      $this->operator = $operator;
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
    //   (new DefaultersRowExportBusiness($this->year, $this->electoral, $this->type, $this->amount, $this->operator))->queue($this->name);
      $gt = Excel::raw(new DefaultersRowExportBusiness($this->year, $this->electoral, $this->type, $this->amount, $this->operator), \Maatwebsite\Excel\Excel::XLSX);
      \App\TemporalFiles::create(['file' => $gt, 'filename' => $this->name]);
    }
}
