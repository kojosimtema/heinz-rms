@extends('layouts.backend.heinz')

@section('links')
<link rel="stylesheet" type="text/css" href="/advanced/2/datables.min.css">
@endsection

@section('content')

<div  class="content">
  <div class="row" style="background: #36404a; padding: 14px; text-align: right;">
    <button type="button" onclick="printDiv('printableArea')" class="btn btn-xs btn-danger" style="font-size: 16px; margin-right: 10px;">Print Page</button>
  </div>
  <div id="printableArea">
    <div class="row">
      <h1 style="font-weight: 600; text-align: center; text-transform: uppercase; color: black; font-size: 28px;"><?= env('ASSEMBLY_SMS_NAME'); ?></h1>
      <h4 style="text-align: center; font-size: 14px; color: black; font-weight: 600;"><?php echo ucwords($account); ?> Fee fixing for <?php echo $year; ?></h4>
    </div>
    <table id="fBill1" class="display feefixing fixed" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th style="font-size: 11px;color: black;"><?php echo ucwords($account); ?> Type Code</th>
              <th style="font-size: 11px;color: black;">Category Code</th>
              <th style="font-size: 11px;color: black;">Category</th>
              <th style="font-size: 11px;color: black;">Rate PA</th>
              <th style="font-size: 11px;color: black;">Min Charge</th>
            </tr>
        </thead>
        <tbody>
          @foreach($feefixing as $type)
          <tr>
            <td rowspan="<?php echo $type->categories->count() + 1; ?>" style="font-weight: 600;"><?php echo $type->code; ?></td>
            <td colspan="2" style="font-weight: 600;text-align: center;"><?php echo $type->description; ?></td>
            <td></td>
            <td></td>
          </tr>
          @if ($fnx)
              @foreach($type->fixcategories as $category)
              <tr>
                <td><?php echo $category->code; ?></td>
                <td><?php echo $category->description; ?></td>
                <td><?php echo $category->rate_pa; ?></td>
                <td><?php echo $category->min_charge; ?></td>
              </tr>
              @endforeach
          @else
            @foreach($type->categories as $category)
              <tr>
                <td><?php echo $category->code; ?></td>
                <td><?php echo $category->description; ?></td>
                <td><?php echo $category->rate_pa; ?></td>
                <td><?php echo $category->min_charge; ?></td>
              </tr>
            @endforeach
          @endif
            
          @endforeach
        </tbody>

    </table>
  </div>
</div>



@endsection

@section('scripts')

<script src="/advanced/2/datables.min.js" charset="utf-8"></script>

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

    // // Handle click on "Collapse All" button
    // $('#btn-hide-all-children').on('click', function(){
    //     // Enumerate all rows
    //     table.rows().every(function(){
    //         // If row has details expanded
    //         if(this.child.isShown()){
    //             // Collapse row details
    //             this.child.hide();
    //             $(this.node()).removeClass('shown');
    //         }
    //     });
    // });

    document.querySelector('.back').style.display = "none";


});
</script>
@endsection
