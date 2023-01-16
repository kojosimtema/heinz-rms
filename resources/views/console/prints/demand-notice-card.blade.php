@extends('layouts.backend.heinz')

@section('content')

<?php
    session_start();
    use App\WebClientPrint\WebClientPrint;
?>

<div id="card" style="width: 1000px; height: 100%; padding-top: 50px; padding-bottom: 20px; border-radius: 0px; background-color:white; margin-top: 100px; margin-bottom: 50px;">
    <div style="width: 804px; background-color:white; margin:auto; border: 2px solid #000;">
      <div style="background-color:white; width:800px; display: flex; flex-direction: row;">
        <img src="/images/assemblies/OFFINSOLOGO.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
        <div style="width: 640px;">
          <h3 style="text-align: center; font-size: 25px; font-weight: 600; color: black; text-transform: uppercase;">Offinso Municipal Assembly</h3>
          <hr style="margin-top: 0px; margin-bottom: 0px; width: 90%; border-top: 2px solid black;">
          <h2 style="text-align: center; font-size: 26px; font-weight: 500; text-transform: uppercase; color: black;">Property Rate Demand Notice</h2>
        </div>
        <img src="/images/assemblies/ghanacoatofarms.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
      </div>
      <hr style="margin-top: 0px; margin-bottom: 5px; border-top: 1px solid #eee;">
      <div style="background-color: white; width:800px; display: flex;">
        <div style="background-color: white; width: 400px;">
          <ul style="list-style: none; padding-left: 5px;">
            <li style="color: black;font-size: 13px; font-weight: 600;">Account No.: <span>&nbsp;&nbsp;&nbsp;&nbsp;P-N1006173</span></li>
            <li style="color: black;font-size: 18px; font-weight: 600;">PATRICIAL BAAFI</li>
            <li style="color: black;font-size: 13px; font-weight: 600;">OP/019-001 &</li>
            <li style="color: black;font-size: 13px; font-weight: 600;">-HABITAB STREET</li>
          </ul>
        </div>
        <div style="background-color: white; width: 400px;">
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Zones:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;NEW TOWN ZONAL COUNCIL</p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;TWUMASEN</p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;OBUASE</p>
          </article>
          <article style="width:100%; display:flex;">
            <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p>
            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;NO NAME</p>
          </article>
        </div>
      </div>
    </div>
    <div style="background-color:white; width: 900px; margin:auto;">
      <h4 style="text-transform: uppercase; font-size: 25px; text-align: center; line-height: 28px; color: black;">
        This demand notice is a warning informing you of your indebtedness to the assembly for non payment of your tax obligation of property
        rate as as 31 august 2018. pursuant to section 137,141 adnd 156 of the local governance act 2016(act 936) and the bye laws of the offinso
        municipal assembly, we trust you will hereby do payment to the assigned revenue office or collector in your area on or before 30th september
        2018 to avoid legal actions or court prosecution.
      </h4>
    </div>
    <div style="background-color:white; width: 804px; margin:auto; display:flex;">
      <div style="background-color:white; display:block; width: 40%;">
        <div style="background-color:white; display:flex; padding-top: 30px;">
          <h4 style="font-size: 15px; font-weight: 600; color:black;">Stamp:&nbsp;&nbsp;&nbsp;</h4>
          <img src="/images/assemblies/bdasign.jpg" style="width: 130px; height: 35px; object-fit: contain;">
        </div>
        <hr style="margin-top: 2px; margin-bottom: 2px; border-top: 2px dashed black; width: 80%; margin-left: inherit;">
        <p style="text-transform: uppercase; font-size: 10px; color:black; text-align: center; font-weight:500;">district finance officer</p>
      </div>
      <div style="background-color:white; width: 60%; display:flex;">
        <div style="background-color:white; width:40%;">
          <ul style="list-style: none; padding-left: 2px; margin-bottom: 0px;">
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">Arrears</li>
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">Current Fee</li>
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; background-color: antiquewhite;">Current  Year Payment</li>
            <li style="font-size: 16px; font-weight: 600; height: 25px; color: black; background-color: antiquewhite; margin-top: 3px; border-top: 1px solid #000; border-bottom: 1px solid #000;">Total Amount Due</li>
          </ul>
        </div>
        <div style="background-color:white; width:60%; text-align: right;">
          <ul style="list-style: none; padding-left: 2px; margin-bottom: 0px; width: 90%; margin-left: auto;">
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">GHc&nbsp;&nbsp;150.00</li>
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">GHc&nbsp;&nbsp;100.00</li>
            <li style="font-size: 13px; font-weight: 500; height:25px; color: black; background-color: antiquewhite;">GHc&nbsp;&nbsp;0.00</li>
            <li style="font-size: 16px; font-weight: 600; height: 25px; color: black; background-color: antiquewhite; margin-top: 3px; border-top: 1px solid #000; border-bottom: 1px solid #000;">GHc&nbsp;&nbsp;250.00</li>
          </ul>
        </div>
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
