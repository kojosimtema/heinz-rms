<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use Hash;

class CollectorController extends Controller
{

    public function __construct()
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
        $collectors = Collector::latest()->paginate(20);
        return view('console.collector.index', compact('collectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('console.collector.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required', 'email' => '', 'password' => 'required', 'username' => '']);
        $data = array_merge($data, ['password' => Hash::make($request->password)]);
        $res = Collector::create($data);
        if($res) {
          $collectors = Collector::latest()->count();
          $res->collector_id = strtoupper(env('ASSEMBLY_CODE')[0].$res->name[0].sprintf('%03d', $collectors));
          $res->save();
        }
        return redirect()->route('collectors.create');
    }

    public function payment()
    {
      $collectors = Collector::latest()->paginate(9);
      return view('console.collector.collector-payment', compact('collectors'));
    }

    public function makePayment($id)
    {
      $collector = Collector::where('collector_id', $id)->first();
      return view('console.collector.make-payment', compact('collector'));
    }
    public function makePaymentPost(Request $request, $id)
    {
      $collector = Collector::where('collector_id', $id)->first();

      switch ($request->account) {
        case 'p':
          $prop = \App\Property::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0);
          if($request->quantity > $prop->count()):
            return redirect()->back()->with('error', 'Your payment quantity is greater than the available data!');
          endif;
          $properties = $prop->limit($request->quantity)->get();
          foreach ($properties  as $data) {
            $data->paid_collector = 1;
            $data->save();
          }

          break;
        case 'b':
          $prop = \App\Property::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0);
          if($request->quantity > $prop->count()):
            return redirect()->back()->with('error', 'Your payment quantity is greater than the available data!');
          endif;
          $properties = $prop->limit($request->quantity)->get();
          foreach ($properties  as $data) {
            $data->paid_collector = 1;
            $data->save();
          }

          break;

        default:
          return redirect()->back()->with('error', 'No account found!');
          break;
      }

      return redirect()->back()->with('sucess', 'Payment sucessfully completed!');


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
      $collector = Collector::where('collector_id', $id)->first();
      return view('console.collector.edit', compact('collector'));
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
      $collector = Collector::where('collector_id', $id)->first();
      // dd($request->all());
      $data = $request->validate(['name' => 'required', 'email' => 'required', 'username' => 'required']);
      if($request->password):
        $data = array_merge($data, ['password' => Hash::make($request->password)]);
      endif;
      $res = $collector->update($data);
      return view('console.collector.edit', compact('collector'));
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
