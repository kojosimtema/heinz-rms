@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('business.store')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <h4 class="form-desc">Business Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business No</label>
                                        <input type="text" disabled="true" name="business_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business_name</label>
                                        <input type="text" name="business_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Industry</label>
                                        <input type="text" name="industry" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business Type</label>
                                        <select class="form-control" name="business_type" id="business_type" @blur="getFilteredCategories()">
                                          <option value="">-choose-</option>
                                            <template v-for="data in types">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business Category</label>
                                        <select class="form-control" name="business_category" id="">
                                          <option value="">-choose-</option>
                                            <template v-for="data in categories">
                                                <option :value="data.code">@{{data.description}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h4 class="form-desc">Business Owner</h4>

                            <div class="row">
                              <div class="col-md-4">
                                <label for="">Business Owner Name</label>
                                <input type="text" name="name" class="form-control">
                              </div>
                              <div class="col-md-4">
                                <label for="">Business Address</label>
                                <input type="text" name="address" class="form-control">
                              </div>
                              <div class="col-md-4">
                                <label for="">Business Owner Number</label>
                                <input type="text" name="phone" class="form-control">
                              </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Registration No</label>
                                        <input type="text" name="reg_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Tin No</label>
                                      <input type="text" name="tin_number" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">VAT No</label>
                                      <input type="text" name="vat_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Phone</label>
                                      <input type="text" name="phone" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Address</label>
                                      <input type="text" name="address" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Employee No</label>
                                        <input type="text" name="employee_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Male Employee No</label>
                                      <input type="text" name="male_employed" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Female Employee No</label>
                                      <input type="text" name="female_employed" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Longitude</label>
                                        <input type="text" name="loc_longitude" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Latitude</label>
                                      <input type="text" name="loc_latitude" class="form-control">
                                  </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Business Location</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sub Metro</label>
                                        <select class="form-control" name="zonal_id" id="">
                                          <option value="">-choose-</option>
                                            <?php $zonals = \App\Models\Location\Zonal::orderBy('description', 'asc')->get(); ?>
                                            <?php foreach ($zonals as $key => $zonal): ?>
                                              <option value="<?php echo $zonal->code; ?>"><?php echo $zonal->description; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Town Area Council</label>
                                        <select class="form-control" name="tas_id" id="">
                                          <option value="">-choose-</option>
                                            <?php $tas = \App\Models\Location\Ta::orderBy('description', 'asc')->get(); ?>
                                            <?php foreach ($tas as $key => $ta): ?>
                                              <option value="<?php echo $ta->code; ?>"><?php echo $ta->description; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Electoral Area</label>
                                        <select class="form-control" name="electoral_id" id="">
                                          <option value="">-choose-</option>
                                          <?php $electorals = \App\Models\Location\Electoral::orderBy('description', 'asc')->get(); ?>
                                          <?php foreach ($electorals as $key => $electoral): ?>
                                            <option value="<?php echo $electoral->code; ?>"><?php echo $electoral->description; ?></option>
                                          <?php endforeach; ?>
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
                                          <?php $communities = \App\Models\Location\Community::orderBy('description', 'asc')->get(); ?>
                                          <?php foreach ($communities as $key => $community): ?>
                                            <option value="<?php echo $community->code; ?>"><?php echo $community->description; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Unit</label>
                                        <select class="form-control" name="unit_id" id="">
                                          <option value="">-choose-</option>
                                            <option value="none">No unit</option>
                                            <?php $units = \App\Models\Location\Unit::orderBy('description', 'asc')->get(); ?>
                                            <?php foreach ($units as $key => $unit): ?>
                                              <option value="<?php echo $unit->code; ?>"><?php echo $unit->description; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Street</label>
                                        <select class="form-control" name="street_id" id="">
                                          <option value="">-choose-</option>
                                          <?php $streets = \App\Models\Location\Street::orderBy('description', 'asc')->get(); ?>
                                          <?php foreach ($streets as $key => $street): ?>
                                            <option value="<?php echo $street->code; ?>"><?php echo $street->description; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="">Property No</label>
                                    <input type="text" name="property_no" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="">Store No</label>
                                    <input type="text" name="store_number" class="form-control">
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
                                        <label for="">GPS Code</label>
                                        <input type="text" name="gps_code" class="form-control">
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
          pt: '',
          categories: [],
          types: [],
          zonals: [],
          electorals: [],
          communities: [],
          tas: [],
          streets: [],
          units: [],
          owners: [],
          business_type_name: '',
          business_cat_name: '',
          business_owner_name:'',
          business_zonal: ''
      },
      methods: {
        getFilteredCategories () {
          var pid = document.querySelector("#business_type").value
          console.log(pid);
          axios.get(`/api/v1/console/get_categories_business/${pid}`)
              .then(response => {console.table(response.data.cats), this.categories = response.data.cats})
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


        axios.get('/api/v1/console/get_business_categories/')
            .then(response => this.categories = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_business_types/')
            .then(response => this.types = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_business_owners/')
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
