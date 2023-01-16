<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Payment;
use Illuminate\Http\Request;

use App\WebClientPrint\WebClientPrint;
use App\WebClientPrint\Utils;
use App\WebClientPrint\DefaultPrinter;
use App\WebClientPrint\InstalledPrinter;
use App\WebClientPrint\PrintFile;
use App\WebClientPrint\ClientPrintJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return view('console.reports.statements.index');
    }

    public function paymentsIndex(Request $request)
    {
        return view('console.reports.statements.payments');
    }

    public function preview(Request $request)
    {
        // dd($request->all());
        $from = date($request->startdate);
        $to = date($request->enddate);

        // dd($from, $to);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        $bills = Bill::with(['paymt' => function ($query) use ($from, $to) {
            $query->whereBetween('payment_year', [$from, $to])->orderBy('payment_year', 'asc');
        }])->where('account_no', $request->account)->whereBetween('year', [$from, $to])->orderBy('year', 'asc')->get();
        // dd($bills);
        $openBalance = Bill::where('account_no', $request->account)->where('year', ($bills->min('year') - 1))->first();
        // dd($openBalance);
        $openBalance = $openBalance ? $openBalance->account_balance : '0.00';
        // dd($openBalance);
        $message = "Account Statement for    " . \Carbon\Carbon::parse($from)->toFormattedDateString() . "   to     " . \Carbon\Carbon::parse($to)->toFormattedDateString();
        return view('console.reports.statements.preview', compact('wcpScript', 'bills', 'message', 'openBalance'));
    }

    public function paymentsPreview(Request $request)
    {
        // dd($request->all());
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        $message = "";
        // $payments = Payment::query();
        if ($request->mode == 'date') :
            $from = date($request->startdate);
            $to = date($request->enddate);
            if (!$from || !$to) {
                return back();
            }
            $payments = Payment::whereNotNull('cprn')
                ->orderBy('cprn', 'desc')->whereBetween('payment_date', [$from, $to]);
            $message = "Payments for dates between " . $from . " and " . $to;
        // $payments = ;
        // dd($payments);
        else :
            // 19551256 ->whereBetween('votes', [1, 100])
            $payments = Payment::whereNotNull('cprn')
                ->orderBy('cprn', 'desc')->whereBetween('cprn', [$request->gcrfrom, $request->gcrto]);
            $message = "Payments for GCR between " . $request->gcrfrom . " and " . $request->gcrto;
        endif;
        $payments = $payments->paginate(500);
        // dd($payments);
        return view('console.reports.statements.payment-preview', compact('wcpScript', 'payments', 'message'));
    }
}