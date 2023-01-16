@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-4">
                        <!-- List available zonals -->
                        <h4 class="form-desc">Listings</h4>
                        <hr>
                        <div class="row table-fixed-height">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 45px;">Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="data in types">
                                        <td><a href="#" @click.prevent="fetchTypesData(data.id)">@{{data.code}}</a></td>
                                        <td><a href="#" @click.prevent="fetchTypesData(data.id)">@{{data.description}}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form class="form-horizontal heiz-dashboard-forms form-fix-width" role="form" action="{{route('business.types')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="" autocomplete="off">
                            @csrf

                            <h4 class="form-desc">Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" name="code" v-model="type.code" class="form-control" value="" placeholder="Type Code" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <input type="text" name="description" v-model="type.description" class="form-control" value="" placeholder="Code Description" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Budget Code</label>
                                        <input type="text" name="budget_code" class="form-control" v-model="type.budget_code" value="" placeholder="Budget Code" parsley-trigger="change" maxlength="50">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button v-if="update_btn" @click.prevent="updateData()" type="submit" class="form-control btn btn-danger">Update Entry</button>
                                <button v-else type="submit" class="form-control btn btn-primary">Save Entry</button>
                                <a v-if="update_btn" href="#" class="pull-right" @click.prevent="clearData()" style="font-size: 11px; text-decoration: underline;">Clear entry ?</a>
                                <!-- <a v-if="update_btn" href="#" class="pull-left" @click.prevent="deleteData()" style="font-size: 11px; text-decoration: underline;">Delet entry ?</a> -->
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
          types: [],
          type: '',
          update_btn: false,
          save_btn: true
      },
      methods: {
        fetchTypesData(id){
            this.update_btn = true;
            axios.get(`/api/v1/console/get_business_type/${id}`)
                .then(response => this.type = response.data.data)
                .catch(error => console.error(error));
        },
        updateData(){
            var data = this.type;
            // var url = `/api/v1/console/update_property_owner/${ownerData.id}`;
            console.log(data)
            axios.put(`/api/re_update_business_type/${data.id}`, data)
                .then(response => {this.type = response.data.data; location.reload();})
                .catch(error => console.error(error));
        },
        deleteData(){
            var data = this.type;
            // var url = `/api/v1/console/update_property_owner/${ownerData.id}`;
            console.log(data)
            axios.delete(`/api/re_delete_business_type/${data.id}`)
                .then(response => location.reload())
                .catch(error => console.error(error));
        },
        clearData(){
            window.location.reload()
        }
      },
      created() {
        axios.get('/api/v1/console/get_business_types/')
            .then(response => this.types = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
