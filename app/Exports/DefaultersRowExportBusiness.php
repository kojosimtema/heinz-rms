<?php

namespace App\Exports;

use Illuminate\Support\Collection;;

use App\Reports\ElectoralBusinessReport;
use App\Reports\CommunityBusinessReport;
use App\Reports\ZonalBusinessReport;
use App\Reports\BusinessCategoryReport;
use App\Reports\BusinessTypeReport;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DefaultersRowExportBusiness implements FromCollection, ShouldAutoSize, ShouldQueue, WithEvents, WithHeadings, WithTitle, WithColumnFormatting
{
    use Exportable;

    protected $electoral;
    protected $year;
    protected $type;
    protected $amount;
    protected $operator;

    public function __construct(int $year, string $electoral, string $type, float $amount, string $operator)
    {
        $this->year = $year;
        $this->electoral = $electoral;
        $this->type = $type;
        $this->amount = $amount;
        $this->operator = $operator;
    }

    // public function collection()
    // {
    //   $response = \App\PropertyCategory::all();
    //   // dd($response);
    //   return $response;
    // }

    public function collection()
    {
        \App\Processing::truncate();
        $response = array();
        $footer = array();
        $year = $this->year;
        $type = $this->type;
        $amount = $this->amount;
        $operator = $this->operator;
        // $bills = ElectoralBusinessReport::where('code', $this->electoral)->whereHas('bills', function($q) use ($year) {
        //   $q->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'));
        // })->with(['bills' => function($query) use ($year) {
        //   $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('account_no', 'asc');
        // }])->first()->bills;

        $bills = ElectoralBusinessReport::where('code', $this->electoral)->whereHas('bills', function ($q) use ($year) {
            $q->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'));
        })->with(['bills' => function ($query) use ($year, $amount, $operator) {
            $query->where('year', $year)->where(strtoupper('bill_type'), strtoupper('b'))->where('account_balance', "{$operator}", $amount)->orderBy('account_no', 'asc');
        }])->first()->bills;

        \App\Processing::create(['total' => $bills->count(), 'count' => 0, 'percentage' => 0]);

        $sumArrears = 0.0;
        $sumCurrentBill = 0.0;
        $sumTotalBill = 0.0;
        $sumPayment = 0.0;
        $sumOutstanding = 0.0;

        foreach ($bills->chunk(1000) as $key => $chunk) {
          foreach ($chunk as $bill) {
            if(!$bill->business) continue;
            // if($bill->current_amount == '' || $bill->current_amount == 0) continue;
            // if($bill->account_balance == '' || $bill->account_balance == 0) continue;
            $newData = [
              $key + 1, $bill->account_no, $bill->business->business_name, $bill->business->electoral ? $bill->business->electoral->description : 'NA',
              $bill->business->owner ? $bill->business->owner->name : 'NO NAME', $bill->business->address, $bill->business->store_number,
              $bill->business->type ? $bill->business->type->description : 'NA',
              $bill->business->category ? $bill->business->category->description : 'NA', floatval($bill->rate_imposed),
              floatval($bill->business->rateable_value), floatval($bill->arrears),
              floatval($bill->current_amount), floatval($bill->arrears + $bill->current_amount), floatval($bill->total_paid),
              floatval(($bill->arrears + $bill->current_amount) - $bill->total_paid)
            ];
            $sumArrears = $sumArrears + floatval($bill->arrears);
            $sumCurrentBill = $sumCurrentBill + floatval($bill->current_amount);
            $sumTotalBill = $sumTotalBill + floatval($bill->arrears + $bill->current_amount);
            $sumPayment = $sumPayment + floatval($bill->total_paid);
            $sumOutstanding = $sumOutstanding + floatval(($bill->arrears + $bill->current_amount) - $bill->total_paid);
            array_push($response, $newData);
            // dd($response);
            $process = \App\Processing::first();
            if($process->count == 0) {
              $process->count == $process->count += 1;
            } else {
              $process->count == $process->count += 1;
            }
            $process->percentage = (int)(($process->count / $process->total) * 100);
            $process->save();
          }
        }
        $footer = [
          '', '', '', '', '', '', '', '', '', '', $sumArrears, $sumCurrentBill, $sumTotalBill,$sumPayment, $sumOutstanding
        ];
        array_push($response, $footer);
        // dd(collect($response), $footer);
        return collect($response);
    }

    public function headings(): array
    {
        return [
            '#',
            'ACCOUNT NO.',
            'BUSINESS NAME',
            'ELECTORAL',
            'OWNER NAME	',
            'BUSINESS ADDRESS',
            'STORE NUMBER',
            'BUSINESS TYPE.',
            'BUSINESS CAT.',
            'RATE IMPOSED',
            'RATEABLE VALUE',
            'ARREARS',
            'CURRENT BILL',
            'TOTAL BILL',
            'TOTAL PAYMENT',
            'OUTSTANDING ARREARS',
        ];
    }

    public function title(): string
    {
        return 'business listings';
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Patrick');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $cellRange = 'A1:M1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },
        ];
    }
}
