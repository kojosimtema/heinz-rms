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
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Full Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" class="odd" v-for="data in owners">
                                    <td><a href="#" @click.prevent="fetchOwnersData(data.id)">@{{data.firstname}} @{{data.lastname}}</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('business.owners')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="" autocomplete="off">
                            @csrf

                            <h4 class="form-desc">Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Full Name</label>
                                        <input type="text" name="firstname" v-model="owner.firstname" class="form-control" value="" placeholder="Full Name" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="lastname" v-model="owner.lastname" class="form-control" value="" placeholder="Last Name" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" name="phone" v-model="owner.phone" class="form-control" value="" placeholder="Phone Number" parsley-trigger="change" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="address" v-model="owner.address" class="form-control" value="" placeholder="Address" parsley-trigger="change" maxlength="50">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button v-if="update_btn" @click.prevent="updateData()" type="submit" class="form-control btn btn-danger">Update Entry</button>
                                <button v-else type="submit" class="form-control btn btn-primary">Save Entry</button>
                                <a v-if="update_btn" href="#" class="pull-right" @click.prevent="clearData()" style="font-size: 11px; text-decoration: underline;">Clear entry ?</a>
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
          owners: [],
          owner: '',
          update_btn: false,
          save_btn: true
      },
      methods: {
        fetchOwnersData(id){
            this.update_btn = true;
            axios.get(`/api/v1/console/get_business_owner/${id}`)
                .then(response => this.owner = response.data.data)
                .catch(error => console.error(error));
        },
        updateData(){
            var ownerData = this.owner;
            // var url = `/api/v1/console/update_business_owner/${ownerData.id}`;
            // console.log(url)
            axios.put(`/api/re_update_business_owner/${ownerData.id}`, ownerData)
                .then(response => {this.owner = response.data.data; location.reload();})
                .catch(error => console.error(error));
        },
        clearData(){
            window.location.reload()
        }
      },
      mounted() {
        axios.get('/api/v1/console/get_business_owners/')
            .then(response => this.owners = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
