@extends('layouts.backend.heinz')

@section('content')

<?php
    session_start();
    use App\WebClientPrint\WebClientPrint;
?>

<div id="card" style="width: 1000px; height: 100%; padding-top: 50px; padding-bottom: 20px; border-radius: 0px; background-color:white; margin-top: 100px; margin-bottom: 50px;">
    <div style="width: 804px; background-color:white; margin:auto;">
      <div style="background-color:white; width:800px; display: flex; flex-direction: row;">
        <img src="<?= $setting->logo; ?>" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
        <div style="width: 640px; border: 2px solid black; height: 100%; margin: auto;">
          <h3 style="text-align: center; font-size: 25px; font-weight: 600; color: black; text-transform: uppercase;"><?= env('ASSEMBLY_SMS_NAME'); ?></h3>
        </div>
        <img src="/images/assemblies/ghanacoatofarms.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
      </div>
      <h2 style="text-align: center; font-size: 26px; margin-top: 0px; margin-bottom: 0px; font-weight: 500; text-transform: uppercase; color: black;">
        <?= strtoupper($bill->bill_type) == strtoupper("p") ? "Property Rate" : "Business Rate"; ?>
      </h2>
      <hr style="margin-top: 0px; margin-bottom: 20px; width: 65%; border-top: 2px solid black;">
      <div style="background-color: white; width:800px; display: flex;">
        <div style="background-color: white; width: 400px;">
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Account No:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<?= $bill->account_no; ?></p>
          </article>
          <article style="width:100%; display:flex; height: 96px; padding-top: 20px;">
            <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 18px; font-weight: 600;">
              <?php
                if($bill->property):
                  echo $bill->property->owner ? $bill->property->owner->name : strtoupper("no name");
                elseif($bill->business):
                    echo $bill->business->owner ? $bill->business->owner->name : strtoupper("no name");
                endif;

              ?>
            </p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Property Type:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->type ? $bill->property->type->description : strtoupper("unknown");
                elseif($bill->business):
                    echo $bill->business->type ? $bill->business->type->description : strtoupper("unknown");
                endif;

              ?>
            </p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Property Cat:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->category ? $bill->property->category->description : strtoupper("unknown");
                elseif($bill->business):
                    echo $bill->business->category ? $bill->business->category->description : strtoupper("unknown");
                endif;

              ?>
            </p>
          </article>

          <div style="background-color:white; width:80%; border:2px solid black; margin-top: 15px; padding-left: 10px; padding-bottom: 10px;">
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Rateable value:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">GHc <?= \App\Repositories\ExpoFunction::formatMoney($bill->rateable_value, true); ?>&nbsp;&nbsp;</p>
            </article>
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 15px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Rate Imposed:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><?= $bill->rate_imposed == 'NULL' ? 'NA' : $bill->rate_imposed; ?>&nbsp;&nbsp;</p>
            </article>
          </div>
          <div style="background-color:white; display:block; width: 100%;">
            <div style="background-color:white; display:flex; padding-top: 30px;">
              <h4 style="font-size: 15px; font-weight: 600; color:black;">Stamp:&nbsp;&nbsp;&nbsp;</h4>
              <img src="<?= $setting->signature; ?>" style="width: 180px; height: 40px; object-fit: contain;">
            </div>
            <hr style="margin-top: 2px; margin-bottom: 2px; border-top: 2px dashed black; width: 80%; margin-left: inherit;">
            <p style="text-transform: uppercase; font-size: 10px; width: 80%; color:black; text-align: center; font-weight:500;"><?= $setting->authority_person; ?></p>
          </div>
        </div>
        <div style="background-color: white; width: 400px;">
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Zones:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->zonal ? $bill->property->zonal->description : strtoupper("no zonal");
                elseif($bill->business):
                    echo $bill->business->zonal ? $bill->business->zonal->description : strtoupper("no electoral");
                endif;

              ?>
            </p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->electoral ? $bill->property->electoral->description : strtoupper("no electoral");
                elseif($bill->business):
                    echo $bill->business->electoral ? $bill->business->electoral->description : strtoupper("no electoral");
                endif;

              ?>
            </p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->tas ? $bill->property->tas->description : strtoupper("no town area");
                elseif($bill->business):
                    echo $bill->business->tas ? $bill->business->tas->description : strtoupper("no town area");
                endif;

              ?>
            </p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php
                if($bill->property):
                  echo $bill->property->street ? $bill->property->street->description : strtoupper("no street");
                elseif($bill->business):
                    echo $bill->business->street ? $bill->business->street->description : strtoupper("no street");
                endif;

              ?>
            </p>
          </article>
          <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 10px; margin-bottom:0px;">
            All bills must be settled on or before &nbsp;<?= \Carbon\Carbon::parse($setting->paymet_date)->toFormattedDateString();?>
          </p>
          <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 10px;">
            For enquires contact the <?= $setting->organization_type; ?> Cordinating Director on the ff Nos. <?= $setting->contact_info_text; ?>
          </p>
          <div style="background-color:white; width:100%; border:2px solid black; margin-top: 15px; padding-left: 10px; padding-bottom: 20px;">
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Previous Year Bill:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">
                <?php
                  if($lastyear):
                    echo "GHc " . \App\Repositories\ExpoFunction::formatMoney($lastyear->current_amount, true);
                  else:
                    echo "NONE";
                  endif;
                ?>&nbsp;&nbsp;
              </p>
            </article>
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Amount Paid(Last Yr):</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">
                <?php
                  if($lastyear):
                    echo "GHc " . \App\Repositories\ExpoFunction::formatMoney($lastyear->total_paid, true);
                  else:
                    echo "NONE";
                  endif;
                ?>&nbsp;&nbsp;
              </p>
            </article>
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Arrears:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">
                <?= \App\Repositories\ExpoFunction::formatMoney($bill->arrears, true); ?>&nbsp;&nbsp;</p>
            </article>
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Current Fee:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">GHc
                <?= \App\Repositories\ExpoFunction::formatMoney($bill->current_amount, true); ?>&nbsp;&nbsp;</p>
            </article>
            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 30px;padding-top: 5px; border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 5px; background: antiquewhite;">
              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Total Amount Due Fee:</p>
              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">GHc
                <?= \App\Repositories\ExpoFunction::formatMoney($bill->account_balance, true); ?>&nbsp;&nbsp;</p>
            </article>
          </div>
        </div>
      </div>
      <div style="background-color:white; width: 100%; font-size: 11px; color: black; margin-top:20px;">
        <p><?= $setting->enforce_law_text; ?></p>
        <h4 style="color: black; text-transform: uppercase; font-weight: 600; text-align: center; margin-top: 13px; font-size: 22px;">payment should be made with the bill</h4>
        <h5 style="text-align: center; text-transform: uppercase; font-weight: 600; color: black; font-size: 16px; letter-spacing: 2px;">pay your bills promptly and help the city clean</h5>
        <hr style="border-top: 2px dashed black;">
      </div>

    </div>
</div>



<div class="row"  style="width: 84%; margin: auto;">

  <div id="loadPrinters">
    Click to load and select one of the installed printers!
    <br />
    <button type="button" class="btn btn-danger" onclick="javascript:jsWebClientPrint.getPrinters();">Load installed printers...</button>
  </div>
  <div id="installedPrinters" style="visibility:hidden">
      <label for="installedPrinterName">Select an installed Printer:</label>
      <select name="installedPrinterName" class="form-control" style="width: 50%;" id="installedPrinterName"></select>
  </div>
  <div class="row" id="printDevice">
    <button type="button" class="btn btn-success" id="printBtn">Issue Print Command</button>
  </div>
</div>

<div style="margin-top:150px;"></div>



<script type="text/javascript">
    var wcppGetPrintersTimeout_ms = 10000; //10 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

    function wcpGetPrintersOnSuccess() {
        // Display client installed printers
        if (arguments[0].length > 0) {
            var p = arguments[0].split("|");
            var options = '';
            for (var i = 0; i < p.length; i++) {
                options += '<option>' + p[i] + '</option>';
            }
            $('#installedPrinters').css('visibility', 'visible');
            $('#installedPrinterName').html(options);
            $('#installedPrinterName').focus();
            $('#loadPrinters').hide();
        } else {
            alert("No printers are installed in your system.");
        }
    }
    function wcpGetPrintersOnFailure() {
        // Do something if printers cannot be got from the client
        alert("No printers are installed in your system.");
    }
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>

    <?php
    //Get Absolute URL of this page
    $currentAbsoluteURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentAbsoluteURL .= $_SERVER["SERVER_NAME"];
    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentAbsoluteURL .= ":".$_SERVER["SERVER_PORT"];
    }
    $currentAbsoluteURL .= $_SERVER["REQUEST_URI"];

    //WebClientPrinController.php is at the same page level as WebClientPrint.php
    $webClientPrintControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/WebClientPrintController.php';

    //PrintHtmlCardController.php is at the same page level as WebClientPrint.php
    $printHtmlCardControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/PrintHtmlCardController.php';

    //Specify the ABSOLUTE URL to the WebClientPrintController.php and to the file that will create the ClientPrintJob object
    echo WebClientPrint::createScript($webClientPrintControllerAbsoluteURL, $printHtmlCardControllerAbsoluteURL, session_id());
    ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>



<script>
$(document).ready(function(){
    $("#printBtn").click(function () {

      html2canvas($('#card'), {
        onrendered: function(canvas)
        {
          var b64Prefix = "data:image/png;base64,";
          var imgBase64DataUri = canvas.toDataURL("image/jpg");
          var imgBase64Content = imgBase64DataUri.substring(b64Prefix.length, imgBase64DataUri.length);

          //2. save image base64 content to server-side Application Cache
          $.ajax({
              type: "POST",
              url: "/api/StoreImageFileController",
              data: { base64ImageContent : imgBase64DataUri},
              success: function (imgFileName) {
                  //alert("The image file: " + imgFileName + " was created at server side. Continue printing it...");

                  //2. Print the stored image file specifying the created file name
                  jsWebClientPrint.print('useDefaultPrinter=' + $('#useDefaultPrinter').attr('checked') + '&printerName=' + $('#installedPrinterName').val() + '&imageFileName=' + imgFileName);
              }
          });
        }
       });

    });
});
</script>

@endsection

@section('scripts')

{!!

// Register the WebClientPrint script code
// The $wcpScript was generated by PrintHtmlCardController@index

$wcpScript;

!!}

@endsection
