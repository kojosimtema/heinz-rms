<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{

  function __construct()
  {
      $this->middleware('auth');
  }

    public function index () {
      return view('console.clients.index');
    }

    public function store (Request $request) {
      $data = $request->validate(['name' => 'required', 'cloud_server' => 'required']);
      Client::create($data);
      return redirect()->back();
    }


}
