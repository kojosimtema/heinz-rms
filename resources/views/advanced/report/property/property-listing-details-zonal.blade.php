@extends('layouts.backend.heinz')

@section('links')
<link rel="stylesheet" type="text/css" href="/advanced/2/datables.min.css">

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
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
      <h4 style="text-align: center; font-size: 14px; color: black; font-weight: 600;">Property Listing Grouped by <?= ucwords($info); ?> <?= ucwords($location); ?> for <?= ucwords($year); ?></h4>
    </div>
    <table id="fBill2" class="display" cellspacing="0" width="100%" style="table-layout: fixed;">
        <thead>
            <tr>
              <th style="width:5%;"></th>
              <!-- <th style="font-size: 10px;color: black;">Electoral Area</th> -->
              <th style="font-size: 10px;color: black;width: 10%;">Account No</th>
              <th style="font-size: 10px;color: black;">Owner Name</th>
              <th style="font-size: 10px;color: black;">Property Address</th>
              <th style="font-size: 10px;color: black;width:10%;">Property cat</th>
              <th style="font-size: 10px;color: black;">Electoral Area</th>
              <th style="font-size: 10px;color: black;">Arrears</th>
              <th style="font-size: 10px;color: black;">Current Bill</th>
              <th style="font-size: 10px;color: black;">Total Bill</th>
              <th style="font-size: 10px;color: black;">Total Payment</th>
              <th style="font-size: 10px;color: black;">Outstanding Arrears</th>
            </tr>
        </thead>
        @if(count($bills) > 0)
        <tbody>
          <div class="tableInner">
            <tr class="odd2 heyy" style="background: #f5f5dc;">
                <td><a href="{{ URL::previous() }}"><img src="/advanced/1/minus-sign.png"></a></td>
                <td colspan="3"><a style="color:brown; font-weight: 600;" href="{{ URL::previous() }}"><?= $info; ?>&nbsp; [<?= $totalBill; ?>]</a></td>
                <td></td>
                <td></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('arrears'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('current_amount'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($zonal->bills->sum('arrears') + $zonal->bills->sum('current_amount')), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('total_paid'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($zonal->bills->sum('arrears') + $zonal->bills->sum('current_amount')) - $zonal->bills->sum('total_paid'), true); ?></td>

            </tr>
          </div>
        </tbody>
        <tbody>
          @foreach($bills as $key => $bill)
            <tr class="odd2 heyy">
                <td><?= $key+1; ?></td>
                <td><?= $bill->account_no; ?></td>
                <td class="text-number" style="font-size: 11px;"><?= $bill->property ? ($bill->property->owner ? $bill->property->owner->name: 'NA'): 'NA'; ?></td>
                <td class="text-number" style="font-size: 11px;"><?= $bill->property ? ($bill->property->address ?: 'NA'): 'NA'; ?></td>
                <td class="text-number" style="font-size: 11px;"><?= $bill->property ? ($bill->property->category ? $bill->property->category->description: 'NA'): 'NA'; ?></td>
                <td class="text-number" style="font-size: 11px;"><?= $bill->property ? ($bill->property->electoral ? $bill->property->electoral->description: 'NA'): 'NA';  ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($bill->arrears, true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($bill->current_amount, true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($bill->arrears + $bill->current_amount), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($bill->total_paid, true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($bill->arrears + $bill->current_amount) - $bill->total_paid, true); ?></td>

            </tr>
          @endforeach
        </tbody>

        <?php if ($bills->currentPage() == $bills->lastPage()): ?>
        <tbody>
          <div class="tableInner">
            <tr class="odd2 heyy gtotal">
                <td colspan="7" style="font-size: 18px;">GRAND TOTAL</td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('arrears'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('current_amount'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($zonal->bills->sum('arrears') + $zonal->bills->sum('current_amount')), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney($zonal->bills->sum('total_paid'), true); ?></td>
                <td class="text-number"><?= \App\Repositories\ExpoFunction::formatMoney(($zonal->bills->sum('arrears') + $zonal->bills->sum('current_amount')) - $zonal->bills->sum('total_paid'), true); ?></td>

            </tr>
          </div>
        </tbody>

        <?php endif; ?>

        @endif

    </table>

  </div>

  @if(count($bills) > 0)
  {{$bills->links()}}
  @endif

  <p class="lead"><button id="json" class="btn btn-primary">TO JSON</button> <button id="csv" class="btn btn-info">TO CSV</button>  <button id="pdf" class="btn btn-danger">TO PDF</button></p>

  <div class="row">
    <div class="col-md-6">
      <button type="button" onclick="javascript:showRsp()" id="repPrintBtn" class="btn btn-xs" style="background: black; color: white;">Print Report</button>
      <a href="{{route('property.export.excel', [$year, $code, 'zonals'])}}">Export to excel</a>
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
<!-- DELETE LATER -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>

<script src="/advanced/2/xxx.js" charset="utf-8"></script>

<script>
  $('#json').on('click',function(){
    $("#fBill2").tableHTMLExport({type:'json',filename:'sample.json'});
  })
  $('#csv').on('click',function(){
    $("#fBill2").tableHTMLExport({type:'csv',filename:'sample.csv'});
  })
  $('#pdf').on('click',function(){
    $("#fBill2").tableHTMLExport({type:'pdf',filename:'sample.pdf'});
  })
  </script>

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

    // window.setInterval(function(){
    //   checkLinkAvailable();
    // }, 2000);

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
