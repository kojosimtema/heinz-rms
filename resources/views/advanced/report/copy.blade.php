@extends('layouts.backend.heinz')

@section('links')
<link rel="stylesheet" type="text/css" href="/advanced/2/datables.min.css">
@endsection

@section('content')

<div class="content">
  <div class="row" style="border-bottom: 2px solid black;">
    <h1 style="font-weight: 600; text-align: center; text-transform: uppercase; color: black; font-size: 28px;">Suame Municipal Assembly</h1>
  </div>
  <div class="row" style="border-bottom: 2px solid black;">
    <h4 style="text-align: center; font-size: 14px; color: black; font-weight: 600;">Property Listing Grouped by Electoral Area for 2019</h4>
  </div>
  <!-- <table id="fBill1" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
				    <th style="font-size: 11px;color: black;"></th>
            <th style="font-size: 11px;color: black;">Electoral Area</th>
            <th style="font-size: 11px;color: black;">Account No</th>
            <th style="font-size: 11px;color: black;">Owner Name</th>
            <th style="font-size: 11px;color: black;">Property Address</th>
            <th style="font-size: 11px;color: black;">Property cat</th>
            <th style="font-size: 11px;color: black;">Arrears</th>
            <th style="font-size: 11px;color: black;">Current Bill</th>
            <th style="font-size: 11px;color: black;">Total Bill</th>
            <th style="font-size: 11px;color: black;">Total Payment</th>
            <th style="font-size: 11px;color: black;">Outstanding Arrears</th>
        </tr>
    </thead>
</table> -->
<table id="fBill1" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
          <th></th>
          <th style="font-size: 11px;color: black;">Electoral Area</th>
          <th style="font-size: 11px;color: black;">Account No</th>
          <th style="font-size: 11px;color: black;">Owner Name</th>
          <th style="font-size: 11px;color: black;">Property Address</th>
          <th style="font-size: 11px;color: black;">Property cat</th>
          <th style="font-size: 11px;color: black;">Arrears</th>
          <th style="font-size: 11px;color: black;">Current Bill</th>
          <th style="font-size: 11px;color: black;">Total Bill</th>
          <th style="font-size: 11px;color: black;">Total Payment</th>
          <th style="font-size: 11px;color: black;">Outstanding Arrears</th>
        </tr>
    </thead>
    <tbody>
      @foreach($listings as $electoral => $listing)
        <div class="tableInner">
          <tr class="odd2 heyy">
              <td></td>
              <td><?= $electoral ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
          </tr>
          <span class="bull">

            @foreach($listing as $data)
            <tr class="even2 bull">
              <td></td>
              <td></td>
              <td><?= $data->account_no; ?></td>
              <td>
                <?php
                  if($data->property):
                    echo $data->property->owner ? $data->property->owner->name : strtoupper("no name");
                  endif;
                ?>
              </td>
              <td>
                <?php
                  if($data->property):
                    echo $data->property->owner ? $data->property->owner->address : strtoupper("no address");
                  endif;
                ?>
              </td>
              <td>Tiger Nixon</td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
              <td>$320,800</td>
            </tr>
            @endforeach
          </span>
        </div>
        @endforeach
    </tbody>
</table>
</div>


@endsection

@section('scripts')

<script src="/advanced/2/datables.min.js" charset="utf-8"></script>

<script>
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellspacing="0" border="0" style="padding-left:20px;" width="100%">'+
        '<tr>'+
            '<td></td>'+

            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
        '</tr>'+
        '<tr>'+
            '<td></td>'+

            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
        '</tr>'+
        '<tr>'+
            '<td></td>'+

            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
        '</tr>'+
        '<tr>'+
            '<td></td>'+

            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
            '<td>Full name:</td>'+
        '</tr>'+
    '</table>';
}

$(document).ready(function() {

    var table = $('#fBill1').DataTable({
        "processing": true,
        "serverSide": true,
        'ajax': '/console/api/advanced/report/property',
        'columns': [
            {
                'className':      'details-control',
                'orderable':      false,
                'data':           null,
                'defaultContent': '<img src="/advanced/1/add-square-button.png">'
            },
            { 'data': 'property.electoral.code' },
            { 'data': '' },
            { 'data': '' },
            { 'data': '' },
            { 'data': '' },
            { 'data': 'salary' },
            { 'data': 'salary' },
            { 'data': 'salary' },
            { 'data': 'salary' },
            { 'data': 'salary' }
        ],
        'order': [[1, 'asc']]
    } );

    var table = $('#fBill1').DataTable({
        'responsive': true,
        'bLengthChange': false,
        'bFilter': false
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

    document.getElementById('fBill1_length').style.display = "none"
    document.getElementById('fBill1_filter').style.display = "none"
    document.querySelector('.back').style.display = "none"
});
</script>
@endsection
