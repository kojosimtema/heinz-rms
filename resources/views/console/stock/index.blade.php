@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="datatable-responsive_length">
                            <label>Show
                                <select name="datatable-responsive_length" aria-controls="datatable-responsive" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                entries
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="datatable-responsive_filter" class="dataTables_filter">
                            <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable-responsive"></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                            <thead>
                                <tr role="row">
                                    <!-- <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">#</th> -->
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Start Serial</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Capacity: activate to sort column ascending" style="width: 227px;">End Serial</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 186px;">Quantity</th>
                                    <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                <tr role="row" class="odd">
                                    <!-- <td class="sorting_1" tabindex="0">{{$stock->id}}</td> -->
                                    <td>{{$stock->min_serial}}</td>
                                    <td>{{$stock->max_serial}}</td>
                                    <td>{{$stock->quantity}}</td>
                                    <td>{{$stock->get_name_person()}}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="datatable-responsive_info" role="status" aria-live="polite">Total: <span style="color:red;">{{$count}}</span> </div>
                    </div>
                    <div class="col-sm-6">
                        {{$stocks->links()}}
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
