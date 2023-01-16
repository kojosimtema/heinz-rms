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

                            <h4 class="form-desc">Property Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property No</label>
                                        <input type="text" disabled="true" name="property_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Building Permit No</label>
                                        <input type="text" name="building_permit_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Division</label>
                                        <input type="text" name="division" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Permit Issue Date</label>
                                        <input type="date" name="permit_issue_date" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Serial No</label>
                                        <input type="text" name="serial_no" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property Type</label>
                                        <select class="form-control" name="property_type" id="property_type" required="required" @blur="getFilteredCategories()">
                                            <option value="">-choose-</option>
                                            <option value="none">No Property Type</option>
                                            <template v-for="data in types">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property Category</label>
                                        <select class="form-control" name="property_category" required="required" id="property_category">
                                            <option value="">-choose-</option>
                                            <option value="none">No Property Category</option>
                                            <template v-for="data in categories">
                                                <option :value="data.code">@{{data.description}} - @{{data.rate_pa}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Use Code</label>
                                        <input type="text" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Occupancy</label>
                                        <input type="text" name="occupancy" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <h4 class="form-desc">Property Owner</h4>

                            <div class="row">
                              <div class="col-md-4">
                                <label for="">Property Owner Name</label>
                                <input type="text" name="name" class="form-control">
                              </div>
                              <div class="col-md-4">
                                <label for="">Property Address</label>
                                <input type="text" name="address" class="form-control">
                              </div>
                              <div class="col-md-4">
                                <label for="">Property Owner Number</label>
                                <input type="text" name="phone" class="form-control">
                              </div>
                            </div>


                            <h4 class="form-desc">Property Location</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sub Metro</label>
                                        <select class="form-control" name="zonal_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No sub metro</option>
                                            <template v-for="data in zonals">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Town Area Council</label>
                                        <select class="form-control" name="tas_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No Town Area</option>
                                            <template v-for="data in tas">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Electoral Area</label>
                                        <select class="form-control" name="electoral_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No Electoral Area</option>
                                            <template v-for="data in electorals">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Community</label>
                                        <select class="form-control" name="community_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No community</option>
                                            <template v-for="data in communities">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Unit</label>
                                        <select class="form-control" name="unit_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No unit</option>
                                            <template v-for="data in units">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Street</label>
                                        <select class="form-control" name="street_id" id="">
                                            <option value="">-choose-</option>
                                            <option value="none">No street</option>
                                            <template v-for="data in streets">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valuation List No</label>
                                        <input type="text" name="valuation_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Block No</label>
                                        <input type="text" name="block_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">House No</label>
                                        <input type="text" name="house_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Financial</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Rateable Value</label>
                                        <input type="text" name="rateable_value" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment No</label>
                                        <input type="text" name="assessment_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment Date</label>
                                        <input type="date" name="assessment_date" class="form-control">
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
          date: new Date().toJSON().slice(0,10),
          categories: [],
          types: [],
          zonals: [],
          electorals: [],
          communities: [],
          tas: [],
          streets: [],
          units: [],
          owners: [],
          property_type_name: '',
          property_cat_name: '',
          property_owner_name:'',
          property_zonal: ''
      },
      methods: {
        calcEndSerial(){
            this.end_serial = parseInt(this.start_serial) + 99
        },
        getFilteredCategories () {
          var pid = document.querySelector("#property_type").value
          console.log(pid);
          axios.get(`/api/v1/console/get_categories_property/${pid}`)
              .then(response => {console.table(response.data.props), this.categories = response.data.props})
              .catch(error => console.error(error));
        },
        getFilteredTas () {
          var pid = document.querySelector("#zonal_id").value
          console.log(pid);
          axios.get(`/api/v1/console/get_tas_location/${pid}`)
              .then(response => {console.table(response.data.props), this.tas = response.data.props})
              .catch(error => console.error(error));
        },
        getFilteredElectorals () {
          var pid = document.querySelector("#tas_id").value
          console.log(pid);
          axios.get(`/api/v1/console/get_electorals_location/${pid}`)
              .then(response => {console.table(response.data.props), this.electorals = response.data.props})
              .catch(error => console.error(error));
        },
        getFilteredCommunities () {
          var pid = document.querySelector("#electoral_id").value
          console.log(pid);
          axios.get(`/api/v1/console/get_communities_location/${pid}`)
              .then(response => {console.table(response.data.props), this.communities = response.data.props})
              .catch(error => console.error(error));
        },
      },
      created() {
        axios.get('/api/v1/console/get_property_categories/')
            .then(response => this.categories = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_property_types/')
            .then(response => this.types = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_property_owners/')
            .then(response => this.owners = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_electorals/')
            .then(response => this.electorals = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_zonals/')
            .then(response => this.zonals = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_communities/')
            .then(response => this.communities = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_tas/')
            .then(response => this.tas = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_streets/')
            .then(response => this.streets = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_units/')
            .then(response => this.units = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
