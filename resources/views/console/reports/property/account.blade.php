@extends('layouts.backend.heinz')

@section('links')
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
@endsection

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                  <form class="" action="{{route('report.property.account')}}" method="post">
                    @csrf
                    <div class="col-sm-10">
                          <h3 style="color: #a52a2a;">Property Report</h3>
                          <hr>
                          <div class="row">
                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">account type</label>
                                <select style="width: 100%;" class="form-control" name="account">
                                  <option value="property">property</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">property type</label>
                                <select style="width: 100%;" class="form-control" name="type">
                                  <option value="">skip</option>
                                  <?php
                                    $types = \App\PropertyType::latest()->get();
                                    foreach ($types as $type) { ?>
                                      <option value="<?= $type->code; ?>"><?= $type->description; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">property category</label>
                                <select style="width: 100%;" class="form-control" name="category">
                                  <option value="">skip</option>
                                  <?php
                                    $categories = \App\PropertyCategory::latest()->get();
                                    foreach ($categories as $category) { ?>
                                      <option value="<?= $category->code; ?>"><?= $category->description; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">property owners</label>
                                <select style="width: 100%;" class="form-control" name="owner">
                                  <option value="">skip</option>
                                  <?php
                                    $owners = \App\PropertyOwner::latest()->get();
                                    foreach ($owners as $owner) { ?>
                                      <option value="<?= $owner->owner_id; ?>"><?= $owner->name; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">collector name</label>
                                <select style="width: 100%;" class="form-control" name="collector">
                                  <option value="">skip</option>
                                  <?php
                                    $collectors = \App\Collector::latest()->get();
                                    foreach ($collectors as $collector) { ?>
                                      <option value="<?= $collector->collector_id; ?>"><?= $collector->name; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">start date</label>
                                <input type="date" class="form-control" name="start_date" value="" style="width:92%;">
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">end date</label>
                                <input type="date" class="form-control" name="end_date" value="" style="width:92%;">
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <button type="submit" style="margin-top: 25px;" class="btn btn-danger">fetch results</button>
                              </div>
                            </div>
                          </div>

                    </div>

                    <div class="col-sm-10 m-top-20">
                      <label for="">selected fields (optional)</label>
                      <div class="row dragdrop">
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('property_no')" id="property_no">account no</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('property_type')" id="property_type">property type</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('property_category')" id="property_category">property category</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('property_owner')" id="property_owner">property owner</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('zonal_id')" id="zonal_id">zonal</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('electoral_id')" id="electoral_id">electoral</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('street_id')" id="street_id">street</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('tas_id')" id="tas_id">town area</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('rateable_value')" id="rateable_value">rateable value</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('address')" id="address">address</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('community_id')" id="community_id">community</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('image')" id="image">image</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('loc_longitude')" id="loc_longitude">longitude</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('loc_latitude')" id="loc_latitude">latitude</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('client')" id="client">client</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('created_at')" id="created_at">created date</button>

                      </div>
                      <div class="row" style="display:none;">
                        <input type="text" id="property_no_in" value="">
                        <input type="text" id="property_type_in" value="">
                        <input type="text" id="property_category_in" value="">
                        <input type="text" id="property_owner_in" value="">
                        <input type="text" id="zonal_id_in" value="">
                        <input type="text" id="electoral_id_in" value="">
                        <input type="text" id="tas_id_in" value="">
                        <input type="text" id="street_id_in" value="">
                        <input type="text" id="rateable_value_in" value="">
                        <input type="text" id="address_in" value="">
                        <input type="text" id="community_id_in" value="">
                        <input type="text" id="image_in" value="">
                        <input type="text" id="loc_longitude_in" value="">
                        <input type="text" id="loc_latitude_in" value="">
                        <input type="text" id="client_in" value="">
                        <input type="text" id="created_at_in" value="">

                      </div>
                    </div>
                  </form>
                </div>



                @if(\Session::has('status'))
                <div class="progress heinz-progress" width="20" id="hiddenSpinner">
                  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <h4 class="modal-title" id="myModalLabel"><p id="demo"></p>%</h4>
                  </div>
                </div>
                @endif


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

      },
      methods: {
          buttonDidTouch(id) {
            var element = document.getElementById(id);
            var inputElement = document.getElementById(`${id}_in`)
            if (inputElement.value == '') {
              inputElement.value = id
              inputElement.setAttribute("name", "fields[]");

              console.log(inputElement.value);
              element.style.borderColor = 'chocolate'
            }else{
              inputElement.value = ''
              inputElement.removeAttribute("name");
              console.log(inputElement.value);
              element.style.borderColor = 'gray'
            }
          }
      },
      mounted() {

      }


    });
</script>
@if(\Session::has('status'))
<script>
console.log({!! json_decode(session('status')) !!})
var myVar= setInterval(function(){ myTimer()},1);
var count = 0;
function myTimer() {
if(count < 100){
  $('.progress').css('width', count + "%");
  count += 0.05;
   document.getElementById("demo").innerHTML = Math.round(count) +"%";
   // code to do when loading
  }

  else if(count > 99){
      document.getElementById("hiddenSpinner").style.display = 'none';
  count = 0;


  }
}
</script>
@endif

@endsection
