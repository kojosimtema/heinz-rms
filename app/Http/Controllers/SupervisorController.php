<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Supervisor;

class SupervisorController extends Controller
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
        $supervisors = Supervisor::latest()->paginate(20);
        return view('console.supervisor.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('console.supervisor.create');
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
        $res = Supervisor::create($data);
        if($res) {
          $supervisors = Supervisor::latest()->count();
          $res->supervisor_id = strtoupper(env('ASSEMBLY_CODE')[0].$res->name[0].sprintf('%03d', $supervisors));
          $res->save();
        }
        if($request->password):
          $user = \App\User::where('user_id', $res->supervisor_id)->first();
          if($user):
            $user->password = Hash::make($request->password);
            $user->update();
          else:
            \App\User::create(['name' => $res->name, 'user_id' => $res->supervisor_id, 'email' => $res->email, 'password' => Hash::make($request->password)]);
          endif;
        endif;
        return redirect()->route('supervisors.create');
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
      $supervisor = Supervisor::where('supervisor_id', $id)->first();
      return view('console.supervisor.edit', compact('supervisor'));
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
      $supervisor = Supervisor::where('supervisor_id', $id)->first();
      // dd($request->all());
      $data = $request->validate(['name' => 'required', 'email' => 'required']);

      $res = $supervisor->update($data);

      if($request->password):
        $user = \App\User::where('user_id', $supervisor->supervisor_id)->first();
        if($user):
          // dd('pp');
          $user->password = Hash::make($request->password);
          $user->update();
        else:
          // dd($supervisor->supervisor_id);
          $i = \App\User::create(['name' => $supervisor->name, 'user_id' => $supervisor->supervisor_id, 'email' => $supervisor->email, 'password' => Hash::make($request->password)]);
          // dd($i);
        endif;
      endif;
      return view('console.supervisor.edit', compact('supervisor'));
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
