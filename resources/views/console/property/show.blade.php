@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">

                            <div class="row">
                                <a href="{{route('property.edit', $property->property_no)}}" class="btn btn-danger pull-right">Edit</a>
                            </div>
                            <h4 class="form-desc">Property Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property No</label>
                                        <input type="text" disabled="true" value="{{$property->property_no}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Building Permit No</label>
                                        <input type="text" disabled="true" value="{{$property->building_permit_no}}" name="building_permit_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Division</label>
                                        <input type="text" disabled="true" value="{{$property->division}}" name="division" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Permit Issue Date</label>
                                        <input type="date" disabled="true" value="{{$property->permit_issue_date}}" name="permit_issue_date" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Serial No</label>
                                        <input type="text" disabled="true" value="{{$property->serial_no}}" name="serial_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Occupancy</label>
                                        <input disabled="true" type="text" name="occupancy" value="{{$property->occupancy}}" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property Type</label>
                                        <input disabled="true" type="text" value="<?= $property->type ? $property->type->description : $property->property_type ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property Category</label>
                                        <input disabled="true" type="text" value="<?= $property->category ? $property->category->description : $property->property_category ?>" name="use_code" class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Use Code</label>
                                        <input disabled="true" type="text" value="{{$property->use_code}}" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Telephone Number</label>
                                        <input disabled="true" type="text" name="occupancy" value="<?= $property->owner ? $property->owner->phone : 'NA' ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Property Owner</label>
                                        <input disabled="true" type="text" value="<?= $property->owner ? $property->owner->name : $property->property_owner ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Collector</label>
                                        <input disabled="true" type="text" name="occupancy" value="{{$property->client}}" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Longitude</label>
                                        <input disabled="true" type="text" value="{{$property->loc_longitude}}" name="loc_longitude" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Latitude</label>
                                      <input disabled="true" type="text" value="{{$property->loc_latitude}}" name="loc_latitude" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="">Address</label>
                                      <input disabled="true" type="text" value="{{$property->address}}" name="loc_latitude" class="form-control">
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox={{$property->loc_longitude}},{{$property->loc_latitude}},{{$property->loc_longitude}},{{$property->loc_latitude}}&amp;layer=mapnik&amp;marker={{$property->loc_latitude}}%2C{{$property->loc_longitude}}" style="border: 1px solid black"></iframe><br /><small><a target="_blank" href="http://www.openstreetmap.org/?lat={{$property->loc_latitude}}&amp;lon={{$property->loc_longitude}}&amp;zoom=15&amp;layers=M&amp;marker={{$property->loc_latitude}}%2C{{$property->loc_longitude}}">View Larger Map</a></small>
                              </div>
                              <div class="col-md-6">
                                @if($property->image)
                                  <img style="width: 100%; height: 250px; object-fit: cover;" src="{{$property->image}}" alt="">
                                @else
                                  <h4 style="color: brown; text-align: center;">No image found</h4>
                                @endif
                              </div>
                            </div>

                            <h4 class="form-desc">Property Location</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sub Metro</label>
                                        <input disabled="true" type="text" value="<?= $property->zonal ? $property->zonal->description : $property->zonal_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Town Area Council</label>
                                        <input disabled="true" type="text" value="<?= $property->tas ? $property->tas->description : $property->tas_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Electoral Area</label>
                                        <input disabled="true" type="text" value="<?= $property->electoral ? $property->electoral->description : $property->electoral_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Community</label>
                                        <input disabled="true" type="text" name="occupancy" value="-" class="form-control">
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
                                        <input disabled="true" type="text" value="<?= $property->street ? $property->street->description : $property->street_id ?>" name="use_code" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valuation List No</label>
                                        <input disabled="true" type="text" value="{{$property->valuation_no}}" name="valuation_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Block No</label>
                                        <input disabled="true" type="text" name="block_no" value="{{$property->block_no}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">House No</label>
                                        <input disabled="true" type="text" name="house_no" value="{{$property->house_no}}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Financial</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Rateable Value</label>
                                        <input disabled="true" type="text" name="rateable_value" value="{{$property->rateable_value}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment No</label>
                                        <input disabled="true" type="text" name="assessment_no" value="{{$property->assessment_no}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Assessment Date</label>
                                        <input disabled="true" type="date" name="assessment_date" value="{{$property->assessment_date}}" class="form-control">
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
          property_type_name: '',
          property_cat_name: '',
          property_owner_name:''
      },
      methods: {

      },
      created() {
        var p_type_name = {!! json_encode($property->property_type) !!}


        axios.get('/api/v1/console/get_property_categories/')
            .then(response => this.categories = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
