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
                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Capacity: activate to sort column ascending" style="width: 227px;">Email</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 186px;">Status</th>
                                    <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accountants as $accountant)  
                                <tr role="row" class="odd">
                                    <td class="sorting_1" tabindex="0">{{$accountant->id}}</td>
                                    <td>{{$accountant->name}}</td>
                                    <td>{{$accountant->email}}</td>
                                    <td>Active</td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-success waves-effect waves-light">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" onclick="$(this).confirmDelete('/delete-table/'+37)" class="btn btn-danger waves-effect waves-light">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="datatable-responsive_info" role="status" aria-live="polite">Showing 1 to 5 of 5 entries</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable-responsive_paginate">
                            <ul class="pagination">
                                <li class="paginate_button previous disabled" aria-controls="datatable-responsive" tabindex="0" id="datatable-responsive_previous">
                                    <a href="#">Previous</a>
                                </li>
                                <li class="paginate_button active" aria-controls="datatable-responsive" tabindex="0">
                                    <a href="#">1</a>
                                </li>
                                <li class="paginate_button next disabled" aria-controls="datatable-responsive" tabindex="0" id="datatable-responsive_next">
                                    <a href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection