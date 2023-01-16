@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">
        <?php //dd(count($business->bills) ? 'yes' : 'no'); ?>

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">

                            <div class="row">
                                <a href="{{route('business.edit', $business->business_no)}}" class="btn btn-danger pull-right">Edit</a>
                            </div>

                            <h4 class="form-desc">Business Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business No</label>
                                        <input type="text" disabled="true" value="{{$business->business_no}}" name="business_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business_name</label>
                                        <input type="text" disabled="true" value="{{$business->business_name}}" name="business_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Business Owner</label>
                                      <input disabled="true" type="text" value="<?= $business->owner ? $business->owner->name : $business->business_owner; ?>" name="use_code" class="form-control">
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business Type</label>
                                        <select class="form-control" disabled>
                                            <option selected="true" >
                                              <?= $business->type ? $business->type->description : $business->business_type; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Business Category</label>
                                        <select class="form-control" disabled>
                                            <option selected="true" >
                                              <?= $business->category ? $business->category->description : $business->business_category; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fee Fixing Rate</label>
                                        <input disabled="true" type="text" value="{{count($business->bills) ? $business->bills[0]->rate_pa: 'NA'}}" name="assessment_date" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Tin No</label>
                                      <input disabled="true" type="text" value="{{$business->tin_number}}" name="tin_number" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">VAT No</label>
                                      <input disabled="true" type="text" value="{{$business->vat_no}}" name="vat_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input disabled="true" type="email" value="{{$business->email}}" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Phone</label>
                                      <input disabled="true" type="text" value="<?= $business->owner ? $business->owner->phone : 'NA'; ?>" name="phone" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Address</label>
                                      <input disabled="true" type="text" value="{{$business->address}}" name="address" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Employee No</label>
                                        <input disabled="true" type="text" value="{{$business->employee_no}}" name="employee_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Male Employee No</label>
                                      <input disabled="true" type="text" value="{{$business->male_employed}}" name="male_employed" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Female Employee No</label>
                                      <input disabled="true" type="text" value="{{$business->female_employed}}" name="female_employed" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Store No</label>
                                      <input disabled="true" type="text" value="{{$business->store_number}}" name="store_number" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Property No</label>
                                      <input disabled="true" type="text" value="{{$business->property_no}}" name="property_no" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Collector</label>
                                      <input disabled="true" type="text" name="occupancy" value="{{$business->client}}" class="form-control">
                                  </div>
                              </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Longitude</label>
                                        <input disabled="true" type="text" value="{{$business->loc_longitude}}" name="loc_longitude" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Latitude</label>
                                      <input disabled="true" type="text" value="{{$business->loc_latitude}}" name="loc_latitude" class="form-control">
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox={{$business->loc_longitude}},{{$business->loc_latitude}},{{$business->loc_longitude}},{{$business->loc_latitude}}&amp;layer=mapnik&amp;marker={{$business->loc_latitude}}%2C{{$business->loc_longitude}}" style="border: 1px solid black"></iframe><br /><small><a target="_blank" href="http://www.openstreetmap.org/?lat={{$business->loc_latitude}}&amp;lon={{$business->loc_longitude}}&amp;zoom=15&amp;layers=M&amp;marker={{$business->loc_latitude}}%2C{{$business->loc_longitude}}">View Larger Map</a></small>
                              </div>
                              <div class="col-md-6">
                                @if($business->image)
                                  <img style="width: 100%; height: 250px; object-fit: cover;" src="{{$business->image}}" alt="">
                                @else
                                  <h4 style="color: brown; text-align: center;">No image found</h4>
                                @endif
                              </div>
                            </div>

                            <h4 class="form-desc">Business Location</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sub Metro</label>
                                        <input disabled="true" type="text" value="<?= $business->zonal ? $business->zonal->description : $business->zonal_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Town Area Council</label>
                                        <input disabled="true" type="text" value="<?= $business->tas ? $business->tas->description : $business->tas_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Electoral Area</label>
                                        <input disabled="true" type="text" value="<?= $business->electoral ? $business->electoral->description : $business->electoral_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Community</label>
                                        <input disabled="true" type="text" name="occupancy" value="<?= $business->community ? $business->community->description : $business->community_id ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Unit</label>
                                        <input disabled="true" type="text" name="occupancy" value="-" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Street</label>
                                        <input disabled="true" type="text" value="<?= $business->street ? $business->street->description : $business->street_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valuation List No</label>
                                        <input disabled="true" type="text" value="{{$business->valuation_no}}" name="valuation_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Block No</label>
                                        <input disabled="true" type="text" value="{{$business->block_no}}" name="block_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">House No</label>
                                        <input disabled="true" type="text" value="{{$business->house_no}}" name="house_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Financial</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Rateable Value</label>
                                        <input disabled="true" type="text" value="{{$business->rateable_value}}" name="rateable_value" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment No</label>
                                        <input disabled="true" type="text" value="{{$business->assessment_no}}" name="assessment_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment Date</label>
                                        <input disabled="true" type="date" name="assessment_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Bill Year</label>
                                        <input disabled="true" type="text" value="{{count($business->bills) ? $business->bills[0]->year : 'NA'}}" name="assessment_date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Arrears</label>
                                        <input disabled="true" type="text" value="GHc {{count($business->bills) ? number_format($business->bills[0]->arrears, 2) : 'NA'}}" name="assessment_date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Account Balance</label>
                                        <input disabled="true" type="text" value="GHc {{count($business->bills) ? number_format($business->bills[0]->account_balance, 2) : 'NA'}}" name="assessment_date" class="form-control">
                                    </div>
                                </div>
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
          business_type_name: '',
          business_cat_name: '',
          business_owner_name:''
      },
      methods: {
        calcEndSerial(){
            this.end_serial = parseInt(this.start_serial) + 99
        },
      },
      created() {
        var p_type_name = {!! json_encode($business->business_type) !!}
        var p_cat_name = {!! json_encode($business->business_category) !!}
        var p_owner_name = {!! json_encode($business->business_owner) !!}


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
        axios.get(`/api/v1/console/get_business_type_name/${p_type_name}`)
            .then(response => this.business_type_name = response.data.data)
            .catch(error => console.error(error));
        axios.get(`/api/v1/console/get_business_cat_name/${p_cat_name}`)
            .then(response => this.business_cat_name = response.data.data)
            .catch(error => console.error(error));
        axios.get(`/api/v1/console/get_business_owner_name/${p_owner_name}`)
            .then(response => this.business_owner_name = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
