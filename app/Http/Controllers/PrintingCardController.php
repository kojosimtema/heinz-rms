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
use Cloudder;

class PrintingCardController extends Controller
{
    public function bills($account)
    {
        $bill = \App\Bill::with(['property', 'business'])->where('account_no', $account)->first();
        $lastyear = \App\Bill::where('account_no', $account)->where('year', $bill->year - 1)->first();
        $setting = \App\BillSetting::first();
        // dd($setting);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        return view('console.prints.bill-card', ['wcpScript' => $wcpScript, 'bill' => $bill, 'lastyear' => $lastyear, 'setting' => $setting]);
    }

    public function notice()
    {

        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        return view('console.prints.demand-notice-card', ['wcpScript' => $wcpScript]);
    }

    public function printFile(Request $request)
    {

        if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {

            $useDefaultPrinter = ($request->input('useDefaultPrinter') === 'checked');
            $printerName = urldecode($request->input('printerName'));

            // $filePath = $request->input('imageFileName');
            $filePath = public_path() . '/bills/images/' . $request->input('imageFileName');

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
            if ($useDefaultPrinter || $printerName === 'null') {
                $cpj->clientPrinter = new DefaultPrinter();
            } else {
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }

            //Send ClientPrintJob back to the client
            return response($cpj->sendToClient())
                ->header('Content-Type', 'application/octet-stream');
        }
    }

    public function formatBill()
    {
        $bill = \App\Bill::with(['property', 'business'])->first();
        $lastyear = \App\Bill::where('account_no', $bill->account_no)->where('year', $bill->year - 1)->first();
        $setting = \App\BillSetting::first();
        // dd($setting);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        return view('console.billing.bill-format', ['wcpScript' => $wcpScript, 'bill' => $bill, 'lastyear' => $lastyear, 'setting' => $setting]);
    }

    public function updateFormatBill(Request $request)
    {

        // dd($request->all());

        $setting = \App\BillSetting::first();
        if (!is_null($request->paymet_date)) :
            $setting->paymet_date = $request->paymet_date;
        endif;
        if (!is_null($request->contact_info_text)) :
            $setting->contact_info_text = $request->contact_info_text;
        endif;
        if (!is_null($request->authority_person)) :
            $setting->authority_person = $request->authority_person;
        endif;
        if (!is_null($request->organization_type)) :
            $setting->organization_type = $request->organization_type;
        endif;
        if (!is_null($request->enforce_law_text)) :
            $setting->enforce_law_text = $request->enforce_law_text;
        endif;
        if (!is_null($request->bill_date)) :
            $setting->bill_date = $request->bill_date;
        endif;

        if ($request->assembly_logo) :
            Cloudder::upload(request('assembly_logo'), null);
            list($width, $height) = getimagesize($request->assembly_logo);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $setting->logo = $image_url;
        endif;

        if ($request->assembly_signature) :
            Cloudder::upload(request('assembly_signature'), null);
            list($width, $height) = getimagesize($request->assembly_logo);
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
            $setting->signature = $image_url;
        endif;

        $setting->save();
        return redirect()->back();
    }

    public function printPropertyBills()
    {
        $setting = \App\BillSetting::first();
        // dd($setting);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        return view('console.billing.property.print-bills', ['wcpScript' => $wcpScript, 'setting' => $setting]);
    }
    public function printBusinessBills()
    {
        $setting = \App\BillSetting::first();
        // dd($setting);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());
        return view('console.billing.business.print-bills', ['wcpScript' => $wcpScript, 'setting' => $setting]);
    }
}