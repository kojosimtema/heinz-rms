<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

//Includes WebClientPrint classes
// $INCLUDE_ROOT = 'App';
// include_once($INCLUDE_ROOT . '\WebClientPrint\WebClientPrint.php');
// use Neodynamic\SDK\Web\WebClientPrint;
use App\WebClientPrint\WebClientPrint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $wcppScript = WebClientPrint::createWcppDetectionScript(action('WebClientPrintController@processRequest'), Session::getId());

        // return view('console.prints.index', ['wcppScript' => $wcppScript]);
        return redirect()->route('console.dashboard');
    }

    public function printHtmlCard(){
        return view('console.prints.printHtmlCard');
    }

    public function printersinfo(){
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('HomeController@printersinfo'), Session::getId());
        return view('console.prints.printersinfo', ['wcpScript' => $wcpScript]);
    }
    public function samples(){
        return view('console.prints.samples');
    }
}
