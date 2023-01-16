<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{

  function __construct()
  {
      $this->middleware('auth');
  }

    public function index()
    {
        return view('console.settings.index');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'assembly_name' => 'required',
            'assembly_image' => 'image:mimes:jpeg,jpg,bmp,png|max:2000',
            'assembly_signature' => 'image:mimes:jpeg,jpg,bmp,png|max:2000',
            'assembly_contact' => 'required',
            'assembly_message_btn' => 'required'
        ]);
        // if($request->assembly_image):
        //     $imageName1 = time().'.'.$request->assembly_image->getClientOriginalExtension();
        //     $request->assembly_image->move(public_path('images/asp'), $imageName1);
        // endif;
        // if($request->assembly_signature):
        //     $imageName2 = time().'.'.$request->assembly_signature->getClientOriginalExtension();
        //     $request->assembly_signature->move(public_path('images/asp'), $imageName2);
        // endif;
        $data = array_merge($data, ['user_id' => auth()->user()->id]);
        // dd($data);

        Setting::create($data);
    }
}
