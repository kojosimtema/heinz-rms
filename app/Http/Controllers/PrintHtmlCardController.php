<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//*********************************
// IMPORTANT NOTE
// ==============
// If your website requires user authentication, then
// THIS FILE MUST be set to ALLOW ANONYMOUS access!!!
//
//*********************************

//Includes WebClientPrint classes
// include_once(app_path() . '\WebClientPrint\WebClientPrint.php');
use App\WebClientPrint\WebClientPrint;
use App\WebClientPrint\Utils;
use App\WebClientPrint\DefaultPrinter;
use App\WebClientPrint\InstalledPrinter;
use App\WebClientPrint\PrintFile;
use App\WebClientPrint\ClientPrintJob;

use Session;

class PrintHtmlCardController extends Controller
{
    public function index(){

        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        return view('console.prints.printHtmlCard', ['wcpScript' => $wcpScript]);
    }

    public function printFile(Request $request){

       if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {

            $useDefaultPrinter = ($request->input('useDefaultPrinter') === 'checked');
            $printerName = urldecode($request->input('printerName'));

            // $filePath = $request->input('imageFileName');
            $filePath = public_path('images/kbills/'). $request->input('imageFileName');

            //create a temp file name for our image file...

            //Because we know the Card size is 3.125in x 4.17in, we can specify
            //it through a special format in the file name (see http://goo.gl/upaazT) so the
            //printing output size is honored; otherwise the output will be sized to Page Width & Height
            //specified by the printer driver default setting
            $fileName = uniqid() . '.png';


            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //Create a PrintFile object with the PNG file
            $cpj->printFile = new PrintFile($filePath, $fileName, null);
            if ($useDefaultPrinter || $printerName === 'null'){
                $cpj->clientPrinter = new DefaultPrinter();
            }else{
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }

            //Send ClientPrintJob back to the client
            return response($cpj->sendToClient())
                        ->header('Content-Type', 'application/octet-stream');


        }
    }

}
