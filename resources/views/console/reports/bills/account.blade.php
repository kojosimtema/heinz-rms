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
                  <form class="" action="{{route('report.bills.account')}}" method="post">
                    @csrf
                    <div class="col-sm-10">
                          <h3 style="color: #a52a2a;">Bills Report</h3>
                          <hr>
                          <div class="row">
                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">account type</label>
                                <select style="width: 100%;" class="form-control" name="account">
                                  <option value="">skip</option>
                                  <option value="property">property</option>
                                  <option value="business">business</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">bill year</label>
                                <select style="width: 185px;" class="form-control" name="year">
                                  <option value="">skip</option>
                                  <option value="2017">2017</option>
                                  <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 m-top-20">
                              <div class="form-group">
                                <label for="">bill date</label>
                                <input type="date" class="form-control" name="bill_date" value="" style="width:92%;">
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
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('account_no')" id="account_no">account no</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('rate_pa')" id="rate_pa">rate per annum</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('rateable_value')" id="rateable_value">rateable value</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('current_amount')" id="current_amount">current amount</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('arrears')" id="arrears">arrears</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('rate_imposed')" id="rate_imposed">rate impose</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('total_paid')" id="total_paid">total paid</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('bill_type')" id="bill_type">bill type</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('year')" id="year">bill year</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('account_balance')" id="account_balance">account balance</button>
                        <button type="button" class="form-control" @click.prevent="buttonDidTouch('bill_date')" id="bill_date">bill date</button>

                      </div>
                      <div class="row" style="display:none;">
                        <input type="text" id="account_no_in" value="">
                        <input type="text" id="rate_pa_in" value="">
                        <input type="text" id="rateable_value_in" value="">
                        <input type="text" id="current_amount_in" value="">
                        <input type="text" id="arrears_in" value="">
                        <input type="text" id="rate_imposed_in" value="">
                        <input type="text" id="total_paid_in" value="">
                        <input type="text" id="bill_type_in" value="">
                        <input type="text" id="year_in" value="">
                        <input type="text" id="account_balance_in" value="">
                        <input type="text" id="bill_date_in" value="">


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
