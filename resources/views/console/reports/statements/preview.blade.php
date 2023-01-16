@extends('layouts.backend.heinz')

@section('links')
<link rel="stylesheet" type="text/css" href="/advanced/2/datables.min.css">
@endsection

@section('content')
<?php
    session_start();
    use App\WebClientPrint\WebClientPrint;
?>

<div class="content">

  <div id="card">
    <div class="row" style="border-bottom: 2px solid black;">
      <h1 style="font-weight: 600; text-align: center; text-transform: uppercase; color: black; font-size: 28px;"><?= env('ASSEMBLY_SMS_NAME'); ?></h1>
    </div>
    <div class="row" style="border-bottom: 2px solid black;">
      <h4 style="text-align: center; font-size: 14px; color: black; font-weight: 600;">{{$message}}</h4>
    </div>
    @if (count($bills) > 0)
    <div class="row">
        <ul style="list-style-type: none;margin-top: 7px;"">
            <li style="border-bottom: 1px solid #000;margin-bottom: 7px;">
                <span style="color:black; font-weight:700;">Account Number:</span>&nbsp;&nbsp; {{$bills[0]->account_no}}
            </li>
            @if ($bills[0]->business)
            <li style="border-bottom: 1px solid #000;margin-bottom: 7px;">
                <span style="color:black; font-weight:700;">Business Address:</span>&nbsp;&nbsp; {{$bills[0]->business ? $bills[0]->business->address : '-'}}
            </li>
            <li style="border-bottom: 1px solid #000;margin-bottom: 7px;">
                <span style="color:black; font-weight:700;">Business Owner:</span>&nbsp;&nbsp; {{$bills[0]->business ? $bills[0]->business->owner->name : '-'}}
            </li>
            @endif
            @if ($bills[0]->property)
            <li style="border-bottom: 1px solid #000;margin-bottom: 7px;">
                <span style="color:black; font-weight:700;">Property Address:</span>&nbsp;&nbsp; {{$bills[0]->property ? $bills[0]->property->house_no : '-'}}
            </li>
            <li style="border-bottom: 1px solid #000;margin-bottom: 7px;">
                <span style="color:black; font-weight:700;">Property Owner:</span>&nbsp;&nbsp; {{$bills[0]->property ? $bills[0]->property->owner->name : '-'}}
            </li>
            @endif

        </ul>
    </div>
    @endif
  <table id="fBill1" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
            <th style="font-size: 11px;color: black;">Year</th>
            <th style="font-size: 11px;color: black;">Date</th>
            <th style="font-size: 11px;color: black;">Item</th>
            <th style="font-size: 11px;color: black;">CR</th>
            <th style="font-size: 11px;color: black;">DR</th>
            <th style="font-size: 11px;color: black;">Total</th>
          </tr>
      </thead>
      <tbody>
          @if (count($bills) > 0)
            <tr>
                    <td colspan="3"></td>
                    <td colspan="3">Opening Balance = GHC {{number_format($openBalance, 2)}}</td>
                </tr>
              @foreach ($bills as $bill)
                <tr>
                    <td colspan="6">{{$bill->year}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>{{\Carbon\Carbon::parse($bill->bill_date)->toFormattedDateString()}}</td>
                    <td>Bill invoice</td>
                    <td>0.00</td>
                    <td>{{number_format($bill->current_amount, 2)}}</td>
                    <td>{{number_format((($bill->current_amount + $bill->arrears)), 2)}}</td>
                </tr>
                @foreach ($bill->paymt as $paymt)
                @if ($paymt->payment_year == $bill->year)
                    <tr>
                        <td></td>
                        <td>{{\Carbon\Carbon::parse($bill->bill_date)->toFormattedDateString()}}</td>
                        <td>Payment</td>
                        <td>{{number_format($paymt->amount_paid, 2)}}</td>
                        <td>0.00</td>
                        <td>{{number_format((($bill->current_amount + $bill->arrears) - $paymt->amount_paid), 2)}}</td>
                    </tr>
                @endif
                @endforeach
            @endforeach
          @else
          <tr>
              <td colspan="6">no data found</td>
          </tr>
          @endif


      </tbody>

  </table>

  </div>
  {{--  --}}

  <div class="row">
    <div class="col-md-6">
      <button type="button" id="repPrintBtn" class="btn btn-xs" style="background: black; color: white;">Print Report</button>
    </div>
    <div class="col-md-6">
      <div class="row"  style="width: 84%; margin: auto;">

        <div id="repPrint" class="col-md-6" style="display:none;">
          <div id="loadPrinters">
            <button type="button" class="btn btn-xs btn-danger" onclick="javascript:jsWebClientPrint.getPrinters();">Load installed printers...</button>
          </div>
          <div id="installedPrinters" style="visibility:hidden">

              <select name="installedPrinterName" class="form-control" style="width: 100%; height: 30px; font-size: 10px;" id="installedPrinterName"></select>
          </div>
        </div>
        <div class="col-md-6" id="repPrint2" style="display:none;">
          <div id="printDevice">
            <button type="button" class="btn btn-xs btn-success" id="printBtn">Issue Print Command</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')

<script src="/advanced/2/datables.min.js" charset="utf-8"></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script>

$(document).ready(function() {

    var table = $('#fBill1').DataTable({
        'responsive': true,
        'bPaginate': false,
        'searching': false,
        'paging': false,
        'info': false

    });

    // Add event listener for opening and closing details
    $('#fBill1 tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if(row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    // Handle click on "Expand All" button
    $('#btn-show-all-children').on('click', function(){
        // Enumerate all rows
        table.rows().every(function(){
            // If row has details collapsed
            if(!this.child.isShown()){
                // Open this row
                this.child(format(this.data())).show();
                $(this.node()).addClass('shown');
            }
        });
    });

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function(){
        // Enumerate all rows
        table.rows().every(function(){
            // If row has details expanded
            if(this.child.isShown()){
                // Collapse row details
                this.child.hide();
                $(this.node()).removeClass('shown');
            }
        });
    });
    $('#repPrintBtn').on('click', function(){
        document.getElementById('repPrint').style.display = "block"
        document.getElementById('repPrint2').style.display = "block"
    });

    document.querySelector('.back').style.display = "none";
});
</script>

{!! $wcpScript; !!}
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
