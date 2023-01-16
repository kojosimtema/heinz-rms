@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-6">
                        <!-- List available zonals -->
                        <h4 class="form-desc">Listings</h4>
                        <hr>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Street Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Capacity: activate to sort column ascending" style="width: 227px;">Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" class="odd" v-for="data in streets">
                                    <td>@{{data.description}}</td>
                                    <td>@{{data.code}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('location.streets')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="" autocomplete="off">
                            @csrf
                            
                            <h4 class="form-desc">Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" name="code" class="form-control" value="" placeholder="Street Code" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <input type="text" name="description" class="form-control" value="" placeholder="Code Description" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Units</label>
                                        <select class="form-control" name="unit_id" id="">
                                            <template v-for="data in units">
                                                <option :value="data.id">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <button type="submit" class="form-control btn btn-primary">Save Entry</button>
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
          unit_id: '',
          units: [],
          streets: []
      },
      created() {
        axios.get('/api/v1/console/get_units/')
            .then(response => this.units = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_streets/')
            .then(response => this.streets = response.data.data)
            .catch(error => console.error(error));
      }
        

    });
</script>
@endsection