<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cashier;
use DB;
use App\Payment;

class CashierController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = DB::table('payments')->where('is_verfied', 0)->orderBy('id');
        // $payments = DB::table('payments')->WhereNull('collector_name')->where('is_verfied', 0)->orderBy('id')->paginate(100);
        $sumTotal = floatval($payments->sum('amount_paid'));
        $payments = $payments->latest()->paginate(100);
        return view('console.cashier.index', compact('payments', 'sumTotal'));
    }

    public function filterForm(Request $request)
    {
        // dd($request->all());
        $query = $request->input('filter');
        if (!$query || $query == '') :
            return redirect()->route('cashiers.index');
        endif;

        $payments = Payment::query();
        if ($request->sortby == 'name') {
            $payments = $payments->where('collector_name', 'LIKE', "%{$query}%")->where('is_verfied', 0);
        } else {
            $payments = $payments->where('gcr_number', 'LIKE', "%{$query}%")->where('is_verfied', 0);
        }
        $sumTotal = floatval($payments->sum('amount_paid'));
        $payments = $payments->latest()->paginate(100);
        return view('console.cashier.index', compact('payments', 'sumTotal'));
    }

    public function checkoutPayment(Request $request)
    {
        foreach ($request->gcrs as $gcr) {
            $payment = Payment::where('gcr_number', $gcr)->first();
            $payment->cprn = $request->gcr_number;
            $payment->cashier_id = $request->cashier;
            $payment->is_verfied = 1;
            $payment->save();
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('console.cashier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required', 'email' => 'required']);
        $res = Cashier::create($data);
        if ($res) {
            $cashiers = Cashier::latest()->count();
            $res->cashier_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $cashiers));
            $res->save();
        }
        return redirect()->route('cashiers.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}