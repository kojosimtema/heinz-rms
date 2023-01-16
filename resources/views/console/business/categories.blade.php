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
                                    <tr role="row" class="odd" v-for="data in categories">
                                        <td><a href="#" @click.prevent="fetchCategoriesData(data.id)">@{{data.code}}</a></td>
                                        <td><a href="#" @click.prevent="fetchCategoriesData(data.id)">@{{data.description}}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form class="form-horizontal heiz-dashboard-forms form-fix-width" role="form" action="{{route('business.categories')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="" autocomplete="off">
                            @csrf

                            <h4 class="form-desc">Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" name="code" v-model="category.code" class="form-control" value="" placeholder="Category Code" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <input type="text" name="description" v-model="category.description" class="form-control" value="" placeholder="Code Description" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business Type</label>
                                        <select class="form-control" v-model="category.type_id" name="type_id" id="">
                                        <option v-if="update_btn" selected="true" disabled>@{{business_type_name}}</option>
                                            <template v-for="data in types">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Min Charge</label>
                                        <input type="text" v-model="category.min_charge" name="min_charge" placeholder="Min Charge" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fee fixing</label>
                                        <input type="text" v-model="category.rate_pa" name="rate_pa" placeholder="Rate PA" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button v-if="update_btn" @click.prevent="updateData()" type="submit" class="form-control btn btn-danger">Update Entry</button>
                                <button v-else type="submit" class="form-control btn btn-primary">Save Entry</button>
                                <a v-if="update_btn" href="#" class="pull-right" @click.prevent="clearData()" style="font-size: 11px; text-decoration: underline;">Clear entry ?</a>
                                <a v-if="update_btn" href="#" class="pull-left" @click.prevent="deleteData()" style="font-size: 11px; text-decoration: underline;">Delet entry ?</a>
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
          type_id: '',
          types: [],
          categories: [],
          category: '',
          update_btn: false,
          save_btn: true,
          business_type_name: ''
      },
      methods: {
        fetchCategoriesData(id){

            this.update_btn = true;
            axios.get(`/api/v1/console/get_business_category/${id}`)
                .then(response => this.checkResponse(response))
                .catch(error => console.error(error));

        },
        checkResponse(response){
            this.category = response.data.data
            // console.log(this.category)
            // console.log(this.category.type_id)
            axios.get(`/api/v1/console/get_business_type_name_2/${this.category.type_id}`)
            .then(response => {console.log(response.data.data), this.business_type_name = response.data.data})
        },
        updateData(){
            var data = this.category;
            // var url = `/api/v1/console/update_business_owner/${ownerData.id}`;
            console.log(data)
            axios.put(`/api/re_update_business_category/${data.id}`, data)
                .then(response => {this.category = response.data.data; location.reload();})
                .catch(error => console.error(error));
        },
        deleteData(){
            var data = this.category;
            // var url = `/api/v1/console/update_business_owner/${ownerData.id}`;
            console.log(data)
            axios.delete(`/api/re_delete_business_category/${data.id}`)
                .then(response => location.reload())
                .catch(error => console.error(error));
        },
        clearData(){
            window.location.reload()
        }
      },
      created() {
        axios.get('/api/v1/console/get_business_categories/')
            .then(response => this.categories = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_business_types/')
            .then(response => this.types = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
