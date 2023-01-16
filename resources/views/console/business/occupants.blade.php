@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('property.store')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Property No</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row occupants-container">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Name of Occupants</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Capacity: activate to sort column ascending" style="width: 227px;">Marital Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 186px;">Gender</th>
                                        <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Date/Year of Birth</th>
                                        <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Employment Category</th>
                                        <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Occupation</th>
                                        <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            </div>

                            <h4 class="form-desc">Details</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name of Occupant</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Employment Category</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Martial Status</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Occupation</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Occupation Status</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Date of Birth Type</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <button type="submit" class="form-control btn btn-primary">Add Entry</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    
    var app = new Vue({
      el: '#heinz',
      data: {
          end_serial: '',
          date: new Date().toJSON().slice(0,10),
          start_serial: ''
      },
      methods: {
        calcEndSerial(){
            this.end_serial = parseInt(this.start_serial) + 99
        },
      }
        

    });
</script>
@endsection