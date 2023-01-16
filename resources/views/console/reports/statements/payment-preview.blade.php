@extends('layouts.backend.heinz')

@section('links')
<link rel="stylesheet" type="text/css" href="/advanced/2/datables.min.css">

@endsection

@section('bb')
<script>
    function handleOpen(id) {
        var a = document.getElementById(id);
        if(a.style.visibility == "visible") {
            a.style.visibility = "collapse";
        } else {
            a.style.visibility = "visible";
        }

    }
</script>
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
    <table id="fBill2" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th></th>
              <th style="font-size: 10px;color: black;">Cashier Receipt No</th>
              <th style="font-size: 10px;color: black;">Date Paid No</th>
              <th style="font-size: 10px;color: black;">GCRNr</th>
              <th style="font-size: 10px;color: black;">Account No</th>
              <th style="font-size: 10px;color: black;">Property/Business Type</th>
              <th style="font-size: 10px;color: black;">Amount Paid</th>
            </tr>
        </thead>
        <tbody>
          <div class="tableInner">
              @foreach ($payments->groupBy('cprn') as $key => $payment)
                <tr class="odd2 heyy" style="background: #f5f5dc;">
                    <td><a href="#" onclick="event.preventDefault();handleOpen(<?= $key; ?>);"><img src="/advanced/1/minus-sign.png"></a></td>
                    <td><a style="color:brown; font-weight: 600;" href="#" onclick="event.preventDefault();handleOpen(<?= $key; ?>);">{{$key}}</a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{number_format($payment->sum('amount_paid'), 2)}}</td>
                    <td></td>
                </tr>
                <tbody id="<?= $key; ?>" style="visibility: collapse;">
                    @foreach ($payment as $paymt)

                            <tr >
                            <td></td>
                            <td></td>
                            <td>{{\Carbon\Carbon::parse($paymt->payment_date)->toFormattedDateString()}}</td>
                            <td>{{$paymt->gcr_number}}</td>
                            <td>{{$paymt->account_no}}</td>
                            <td>{{$paymt->data_type == 'P' ? 'Property' : 'Business'}}</td>
                            <td>{{number_format($paymt->amount_paid, 2)}}</td>
                            </tr>

                    @endforeach
                    </tbody>


              @endforeach

          </div>
        </tbody>
    </table>
    {{$payments->links()}}

  </div>

  <div class="row">
    <div class="col-md-6">
      <button type="button" onclick="javascript:showRsp()" id="repPrintBtn" class="btn btn-xs" style="background: black; color: white;">Print Report</button>
      <a href="#">Export to excel</a>
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
            <button type="button" onclick="javascript:issuePrint()" class="btn btn-xs btn-success" id="printBtn">Issue Print Command</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="link">
    <span style="margin-left: 13px;display:none;"><img src="/backend/images/25.gif" alt="" style="width: 19px;margin-right: 4px;">Loading...</span>
    <a href="#" style="color: #d62424; margin-left: 13px; text-decoration: underline; font-size: 13px; display:none;">Click the here to download prepared excel file file..</a>
  </div>
</div>


@endsection

@section('scripts')

<script src="/advanced/2/datables.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script>

$(document).ready(function() {

    var table = $('#fBill2').DataTable({
        'responsive': true,
        'bPaginate': false,
        'searching': false,
        'paging': false,
        'info': false

    });

    // Add event listener for opening and closing details
    $('#fBill2 tbody').on('click', 'td.details-control', function(){
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

    document.querySelector('.back').style.display = "none";
});
</script>

{!! $wcpScript; !!}
<script type="text/javascript">
    var wcppGetPrintersTimeout_ms = 10000; //10 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

    function showRsp() {
      document.getElementById('repPrint').style.display = "block"
      document.getElementById('repPrint2').style.display = "block"
    }

    function issuePrint() {
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
    }

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

    function checkLinkAvailable() {
      axios.get('/api/v1/console/check/link/available')
            .then(response => relateLink(response.data.status))
            .catch(error => console.error(error));
    }

    function relateLink(data){
      if (data == 'failed') {
        document.querySelector('#link a').style.display = "none";
        return false
        document.querySelector('#link span').style.display = "block";

      }else if(data == 'none'){
        document.querySelector('#link a').style.display = "none";
        document.querySelector('#link span').style.display = "block";
      }else{
        document.querySelector('#link a').style.display = "block";
        document.querySelector('#link span').style.display = "none";
        document.querySelector('#link a').href = `{{ route('download.link') }}`;
        window.clearInterval(timer)
      }

    }

    var timer = function () {
      return window.setInterval(function() {
        checkLinkAvailable()
      }, 5000);
    }

    window.onload = timer();
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

@endsection
