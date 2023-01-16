@extends('layouts.backend.heinz')

@section('content')
<?php
    session_start();
    use App\WebClientPrint\WebClientPrint;
?>

<div class="content">
    <div class="container">

        <div id="mainContent" class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                  <form class="heiz-dashboard-forms" style="width:80%;margin:auto;">
                    <div class="row">
                      <div class="col-md-4">
                        <input style="width:auto;" type="radio" id="check1" @click="toggleCheck()" name="sortType" value="noFilter" checked> <label for="">No Filtering</label>
                      </div>
                      <div class="col-md-4">
                        <input style="width:auto;" type="radio" id="check2" @click="toggleCheck()" name="sortType" value="filter"> <label for="">Filter Report</label>
                      </div>
                    </div>

                    <hr style="margin-top: 20; margin-bottom: 10px;">
                    <h4 class="form-desc">Filter By Location</h4>
                    <hr style="margin-top: 0; margin-bottom: 10px;">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Sub Metro</label>
                                <select :disabled="disableFilter" class="form-control" style="display: block; width: 200px; height: 26px;" name="zonal">
                                  <option value="">None</option>
                                  <?php
                                    $subs = \App\Models\Location\Zonal::orderBy('code', 'asc')->get();
                                    foreach ($subs as $sub) {?>
                                      <option value="<?= $sub->code; ?>"><?= $sub->description; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Electoral Area</label>
                                <select :disabled="disableFilter" class="form-control" style="display: block; width: 200px; height: 26px;" name="electoral">
                                  <option value="">None</option>
                                  <?php
                                    $elts = \App\Models\Location\Electoral::orderBy('code', 'asc')->get();
                                    foreach ($elts as $data) {?>
                                      <option value="<?= $data->code; ?>"><?= $data->description; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Town Area Council</label>
                                <select :disabled="disableFilter" class="form-control" style="display: block; width: 200px; height: 26px;" name="tas">
                                  <option value="">None</option>
                                  <?php
                                    $tas = \App\Models\Location\Ta::orderBy('code', 'asc')->get();
                                    foreach ($tas as $data) {?>
                                      <option value="<?= $data->code; ?>"><?= $data->description; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="padding-top: 20px;">
                                <label for="">Community</label>
                                <select :disabled="disableFilter" class="form-control" style="display: block; width: 200px; height: 26px;" name="community">
                                  <option value="">None</option>
                                  <?php
                                    $cmts = \App\Models\Location\Community::orderBy('code', 'asc')->get();
                                    foreach ($cmts as $data) {?>
                                      <option value="<?= $data->code; ?>"><?= $data->description; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="padding-top: 20px;">
                                <label for="">Street</label>
                                <select :disabled="disableFilter" class="form-control" style="display: block; width: 200px; height: 26px;" name="street">
                                  <option value="">None</option>
                                  <?php
                                    $sts = \App\Models\Location\Street::orderBy('code', 'asc')->get();
                                    foreach ($sts as $data) {?>
                                      <option value="<?= $data->code; ?>"><?= $data->description; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr style="margin-top: 20; margin-bottom: 10px;">
                    <h4 class="form-desc">Bill Info</h4>
                    <hr style="margin-top: 0; margin-bottom: 10px;">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Bill Year</label>
                                <select class="form-control" style="display: block; width: 200px; height: 26px;" name="year">
                                  <?php
                                    for ($i=date('Y'); $i>2009; $i--) {?>
                                      <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Number of Bills </label>
                                <input type="text" disabled="true" style="height: 26px;" class="form-control" name="billNumbers" value="">
                                <img src="/backend/images/25.gif" alt="" style="width: 19px;margin-right: 4px;" v-if="gif">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                              <button type="button" @click.prevent="getBillCount()" class="form-control btn btn-danger btn-xs" style="font-size: 14px;width: 120px;margin-top: 25px; height: 26px; padding-top: 2px;">Get Count</button>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="checkbox" id="zeroRated" class="form-control" value="">
                            <label for="">Do not print bills with Zero(0) Rate Imposed</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <button type="button" id="repPrintBtn" class="btn btn-xs" style="background: black; color: white;">Print Report</button>
                        </div>
                        <div class="col-md-6">
                          <div class="row"  style="width: 84%; margin: auto;">

                            <div id="repPrint" class="col-md-6" style="display:none;">
                              <div id="loadPrinters">
                                <button type="button" class="btn btn-xs btn-danger" onclick="javascript:jsWebClientPrint.getPrinters();">Load installed printers...</button>
                              </div>
                              <div id="installedPrinters" style="visibility:hidden">

                                  <select name="installedPrinterName" class="form-control" style="width: 100%; height: 30px; font-size: 10px;" id="installedPrinterName"></select>
                              </div>
                            </div>
                            <div class="col-md-6" id="repPrint2" style="display:none;">
                              <div id="printDevice">
                                <button type="button" class="btn btn-xs btn-success" id="isp">Issue Print Command</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="row">
                        <div class="col-md-4">
                          <button id="isp" type="button" class="form-control btn btn-primary btn-xs" style="font-size: 14px;width: 120px;margin-top: 25px;">Print bills</button>
                        </div>
                      </div> -->



                  </form>
                </div>

            </div>

        </div>

        <div class="row" id="loadingCarf" style="display:none;">
          <div class="col-md-6">
            <h4><img src="/backend/images/25.gif" alt="" style="width: 19px;margin-right: 4px;">Loading... <span id="tt1" style="color:red;">0</span> / <span id="tt2"></span> </h4>
          </div>
          <div class="col-md-6">
            <h4>Zero Imposed Bills: <span id="tt3" style="color: red;">0</span> </h4>
          </div>
        </div>

        <div id="cardcont" style="display:block;">
          <div id="card" style="width: 1000px; height: 100%; padding-top: 27px; padding-bottom: 20px; border-radius: 0px; background-color:white; margin-top: 40px; margin-bottom: 50px;">
              <div style="width: 870px; background-color:white; margin:auto;">
                <div style="background-color:white; width:800px; display: flex; flex-direction: row;">
                  <img src="{{$setting->logo}}" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                  <div style="width: 640px; border: 2px solid black; height: 100%; margin: auto;">
                    <h3 style="text-align: center; font-size: 25px; font-weight: 600; color: black; text-transform: uppercase;"><?= env('ASSEMBLY_SMS_NAME'); ?></h3>
                  </div>
                  <img src="/images/assemblies/ghanacoatofarms.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                </div>
                {{-- <h2 style="text-align: center; font-size: 20px; margin-top: -10px; margin-bottom: 0px; font-weight: 500; text-transform: capitalize;; color: black;">
                  <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; right: 175px; text-transform: capitalize;">Account No:
                    <span id="r_acc_no">&nbsp;&nbsp;&nbsp;AAS4444</span>
                  </span>
                  Business Operating Permit
                  <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; left: 100px; text-transform: capitalize;">Bill year:
                    <span id="r_ac_year" style="position: relative; left: 14px;">2019</span>
                  </span>
                </h2> --}}
                <h2 style="text-align: center; font-size: 20px; margin-top: -10px; margin-bottom: 0px; font-weight: 500; text-transform: capitalize;; color: black;">
                    @if ($setting->bill_date)
                    <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; right: 175px; text-transform: capitalize;">Bill date:
                        <span id="">&nbsp;&nbsp;&nbsp;<?= \Carbon\Carbon::parse($setting->bill_date)->toFormattedDateString();?></span>
                    </span>
                    @endif
                    <span style="position: relative; right:30px;">
                        Business Operating Permit
                    </span>
                    <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; left: 100px; text-transform: capitalize;">Bill year:
                    <span id="r_ac_year" style="position: relative; left: 14px;">2019</span>
                    </span>
                </h2>
                <hr style="margin-top: 0px; margin-bottom: 20px; width: 65%; border-top: 2px solid black;">
                <div style="background-color: white; width:870px; display: flex;">
                  <div style="background-color: white; width: 466px;">
                    <article style="width:100%; display:flex;">
                        <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Acount Number:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_no">AAS4444</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Store Number:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_snumber">ER56</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Business Name:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_bname">Marvalinks Technologies</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Address:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_address">Accra</span></p>
                    </article>
                    <article style="width: 100%; display: flex; height: 50px; padding-top: 0px; margin-top: -10px;">
                      <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 18px; font-weight: 600;"><span id="r_acc_name">MT. CALVSRY SCH.</span></p>
                    </article>
                    <article style="width: 100%; display: flex; height: 31px; padding-top: 0px;margin-top:-26px;">
                      <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 14px; font-weight: 600;"><span id="r_acc_phone">0248160008</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Business Type:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_type">COMMERCIAL Business RATE</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Business Cat:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_category">PRIVATE SCHOOL</span></p>
                    </article>

                    <div style="background-color:white; width:80%; border:2px solid black; margin-top: 15px; padding-left: 10px; padding-bottom: 10px;">
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 15px;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Rate Imposed:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_imposed">GHc 84.00</span> &nbsp;&nbsp;</p>
                      </article>
                    </div>
                    <div style="background-color:white; display:block; width: 100%;">
                      <div style="background-color:white; display:flex; padding-top: 5px;">
                        <h4 style="font-size: 15px; font-weight: 600; color:black;">Stamp:&nbsp;&nbsp;&nbsp;</h4>
                        @if($setting->signature)
                        <img src="{{$setting->signature}}" style="width: 180px; height: 40px; object-fit: contain;">
                        @endif
                      </div>
                      <hr style="margin-top: 2px; margin-bottom: 2px; border-top: 2px dashed black; width: 80%; margin-left: inherit;">
                      <p style="text-transform: uppercase; font-size: 10px; width: 80%; color:black; text-align: center; font-weight:500;">{{$setting->authority_person}}</p>
                    </div>
                  </div>
                  <div style="background-color: white; width: 430px;">
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_electoral">NO NAME</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_tas">NO NAME</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Community:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_com">NO NAME</span></p>
                    </article>
                    <article style="width:100%; display:flex;">
                      <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p>
                      <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_street">NO NAME</span></p>
                    </article>
                    <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 0px; margin-bottom:0px;">All bills must be settled on or before &nbsp;<?= \Carbon\Carbon::parse($setting->paymet_date)->toFormattedDateString();?></p>
                    <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 0px;">For enquires contact the <?= $setting->organization_type; ?> finance office on the ff Nos. <?= $setting->contact_info_text; ?></p>
                    <div style="background-color:white; width:100%; border:2px solid black; margin-top: -10px; padding-left: 10px; padding-bottom: 2px;">
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Previous Year Bill:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_pyear">GHc 0.00</span> &nbsp;&nbsp;</p>
                      </article>
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Amount Paid(Last Yr):</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_amountpaid">GHc 0.00</span> &nbsp;&nbsp;</p>
                      </article>
                      <hr style="width: 61%; display: flex; justify-content: space-between; border-top: 2px dashed rgb(0, 0, 0); padding-top: 6px; margin-top: 10px; margin-bottom: 0px; float: right;">
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Arrears:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_arrears">GHc 0.00</span> &nbsp;&nbsp;</p>
                      </article>
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Current Fee:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_current">GHc 225.00</span> &nbsp;&nbsp;</p>
                      </article>
                      <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;padding-top: 5px; border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 5px; background: antiquewhite;">
                        <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Total Amount Due Fee:</p>
                        <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;"><span id="r_ac_total">GHc 225.00</span> &nbsp;&nbsp;</p>
                      </article>
                    </div>
                  </div>
                </div>
                <div style="background-color:white; width: 100%; font-size: 11px; color: black; margin-top:5px;">
                  <p>{{$setting->enforce_law_text}}</p>
                  <h4 style="color: black; text-transform: uppercase; font-weight: 600; text-align: center; margin-top: -3px; font-size: 22px;">payment should be made with the bill</h4>
                  <h5 style="text-align: center; text-transform: uppercase; font-weight: 600; margin-top: -4px; color: black; font-size: 16px; letter-spacing: 2px;">pay your bills promptly and help the city clean</h5>
                  <hr style="border-top: 2px dashed black;">
                </div>

              </div>
          </div>

          <!-- <div class="row"  style="width: 84%; margin: auto;">

            <div id="loadPrinters">
              Click to load and select one of the installed printers!
              <br />
              <button type="button" class="btn btn-danger" onclick="javascript:jsWebClientPrint.getPrinters();">Load installed printers...</button>
            </div>
            <div id="installedPrinters" style="visibility:hidden">
                <label for="installedPrinterName">Select an installed Printer:</label>
                <select name="installedPrinterName" class="form-control" style="width: 50%;" id="installedPrinterName"></select>
            </div>
            <div class="row" id="printDevice">
              <button type="button" class="btn btn-success" id="printBtn">Issue Print Command</button>
            </div>
          </div> -->

        </div>
    </div>
</div>






@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> -->
<script src="/js/html2canvas.js"></script>
{!! $wcpScript; !!}
<script type="text/javascript">
    var wcppGetPrintersTimeout_ms = 10000; //10 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

    function wcpGetPrintersOnSuccess() {
        // Display client installed printers
        if (arguments[0].length > 0) {
            var p = arguments[0].split("|");
            var options = '';
            for (var i = 0; i < p.length; i++) {
                options += '<option>' + p[i] + '</option>';
            }
            $('#installedPrinters').css('visibility', 'visible');
            $('#installedPrinterName').html(options);
            $('#installedPrinterName').focus();
            $('#loadPrinters').hide();
        } else {
            alert("No printers are installed in your system.");
        }
    }
    function wcpGetPrintersOnFailure() {
        // Do something if printers cannot be got from the client
        alert("No printers are installed in your system.");
    }
</script>
<script>
    var app = new Vue({
      el: '#heinz',
      data: {
        disableFilter: true,
        gif: false
      },
      methods: {
        toggleCheck() {
          var sortType = document.querySelector("input[name=sortType]:checked").value
          this.disableFilter =  (sortType == "noFilter") ? true : false;
        },
        getBillCount() {
          if (this.disableFilter == true) {
            var requestParams = {
              year: document.querySelector("select[name=year]").value,
              isFilter: false
            }
          }else{
            this.gif = true
            var requestParams = {
              year: document.querySelector("select[name=year]").value,
              zonal: document.querySelector("select[name=zonal]").value,
              electoral: document.querySelector("select[name=electoral]").value,
              tas: document.querySelector("select[name=tas]").value,
              community: document.querySelector("select[name=community]").value,
              street: document.querySelector("select[name=street]").value,
              isFilter: true
            }
          }
          axios.get('/api/get/bill/count/b', { params: requestParams })
                .then(response => {document.querySelector("input[name=billNumbers]").value = response.data.data; this.gif=false})
                .catch(error => console.error(error));
        }
      },
      created() {
        this.toggleCheck()
      }


    });
</script>

<script type="text/javascript">
    var wcppGetPrintersTimeout_ms = 10000; //10 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

    function wcpGetPrintersOnSuccess() {
        // Display client installed printers
        if (arguments[0].length > 0) {
            var p = arguments[0].split("|");
            var options = '';
            for (var i = 0; i < p.length; i++) {
                options += '<option>' + p[i] + '</option>';
            }
            $('#installedPrinters').css('visibility', 'visible');
            $('#installedPrinterName').html(options);
            $('#installedPrinterName').focus();
            $('#loadPrinters').hide();
        } else {
            alert("No printers are installed in your system.");
        }
    }
    function wcpGetPrintersOnFailure() {
        // Do something if printers cannot be got from the client
        alert("No printers are installed in your system.");
    }
</script>
<script>
$(document).ready(function(){
  $('#repPrintBtn').on('click', function(){
      document.getElementById('repPrint').style.display = "block"
      document.getElementById('repPrint2').style.display = "block"
  });
    $("#isp").click(function () {
      // var checkboxes = document.querySelectorAll('input[type="sortType"]');
      issuePrint()
      captureArraySet()

    });

    var printingSet = [];

    function issuePrint() {

      document.getElementById('loadingCarf').style.display = "block"
    }

    function captureArraySet() {
      var filterBox1 = document.querySelector('#check1').checked;
      var filterBox2 = document.querySelector('#check2').checked;

      var requestParams = {};
      if(filterBox1){
        var requestParams = {
          year: document.querySelector("select[name=year]").value,
          isFilter: false
        }
      }
      if(filterBox2){
        var requestParams = {
          year: document.querySelector("select[name=year]").value,
          zonal: document.querySelector("select[name=zonal]").value,
          electoral: document.querySelector("select[name=electoral]").value,
          tas: document.querySelector("select[name=tas]").value,
          community: document.querySelector("select[name=community]").value,
          street: document.querySelector("select[name=street]").value,
          isFilter: true
        }
      }

      // console.log(printingSet);

      axios.get('/api/get/bill/set/b', { params: requestParams })
            .then(response => {printingSet = response.data.data; timerReplace()})
            .catch(error => console.error(error));




    }

    function replaceBill(mode) {
        // array[i]

        // console.log(parseInt(document.getElementById('tt2').innerHTML));
        // console.log(parseInt(document.getElementById('tt1').innerHTML));
        console.log(mode);
        // console.table(mode.bills);

        if (mode.bills === undefined || mode.bills.length == 0) {
            alert('No bills pending found')
            window.location.reload(true);
            document.getElementById('loadingCarf').style.display = "none"
            return false
        }

        document.getElementById('tt1').innerHTML = parseInt(document.getElementById('tt1').innerHTML) + 1
        // console.log(mode);
        var parentParse = mode;
        var currentBill = mode.bills[0];
        var zeroRatedBox = document.querySelector('#zeroRated').checked;
        // console.table(currentBill)
        // console.log();
        document.getElementById('r_acc_no').innerHTML = parentParse.business_no
        document.getElementById('r_acc_bname').innerHTML = parentParse.business_name
        document.getElementById('r_acc_address').innerHTML = parentParse.address
        document.getElementById('r_acc_snumber').innerHTML =  parentParse.property_no ? parentParse.property_no : ''
        document.getElementById('r_acc_name').innerHTML = parentParse.owner ? parentParse.owner.name : 'NA'
        document.getElementById('r_acc_phone').innerHTML = parentParse.phone ? parentParse.phone : 'NA'
        document.getElementById('r_ac_type').innerHTML = parentParse.type.description
        document.getElementById('r_ac_category').innerHTML = parentParse.category.description
        document.getElementById('r_ac_imposed').innerHTML = currentBill.rate_pa ? `${formatDollar(parseFloat(currentBill.rate_pa))} ` : `${formatDollar(parseFloat(0.0))} `
        // document.getElementById('r_ac_zonal').innerHTML = parentParse.zonal ? parentParse.zonal.description : 'NO NAME'
        document.getElementById('r_ac_electoral').innerHTML = parentParse.electoral ? parentParse.electoral.description : 'NO NAME'
        document.getElementById('r_ac_com').innerHTML = parentParse.communities ? parentParse.communities.description : 'NO NAME'
        document.getElementById('r_ac_tas').innerHTML = parentParse.tas ? parentParse.tas.description : "NO NAME"
        document.getElementById('r_ac_street').innerHTML = parentParse.street ? parentParse.street.description : "NO NAME"
        document.getElementById('r_ac_pyear').innerHTML = currentBill.p_year_bill ? `${formatDollar(parseFloat(formatAmount(currentBill.p_year_bill)) + parseFloat(formatAmount(currentBill.adjust_arrears)))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_amountpaid').innerHTML = currentBill.p_year_total_paid ? `${formatDollar(parseFloat(currentBill.p_year_total_paid))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_arrears').innerHTML = currentBill.arrears ? `${formatDollar(parseFloat(formatAmount(currentBill.original_arrears)) + parseFloat(formatAmount(currentBill.adjust_arrears))) } ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_current').innerHTML = currentBill.current_amount ? `${formatDollar(parseFloat(currentBill.current_amount))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_total').innerHTML = currentBill.account_balance ? `${formatDollar(parseFloat(currentBill.account_balance))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_year').innerHTML = currentBill.year



        if((parentParse.address == '' || parentParse.address == null) && (parentParse.property_no == '' || parentParse.property_no == null)){
          document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
          return true;
        }

        // if(parentParse.store_number == '' || parentParse.store_number == null){
        //   document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
        //   return true;
        // }
        if(zeroRatedBox){
          if(parseFloat(currentBill.account_balance) == parseFloat(0.0)){
            console.log('zero');
            document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
            return true;
          }else{
            startPrinting()
            ajaxPrintStatus(parentParse.business_no)
          }
        }else{
          startPrinting()
          ajaxPrintStatus(parentParse.business_no)
        }

    }

    function formatAmount(amount) {
      return (amount == "NaN" || amount == NaN) ? ~~NaN : amount
    }

    function formatDollar(num) {
      return "GHc " + num.toFixed(2)
      }
        // var p = num.toFixed(2).split(".");
        // return "GHc " + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        //     return  num=="-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
        // }, "") + "." + p[1];
    // }

    function reloadPage() {
      document.getElementById('loadingCarf').style.display = "none"
      document.getElementById('cardcont').style.display = "none"
      document.getElementById('mainContent').style.display = "block"
      alert('completed.')
      window.location.reload(true);

    }

    function timerReplace() {

      // console.log(zeroRatedBox);
      // return false

      let modes = printingSet;
      if (modes === undefined || modes.length == 0) {
          console.log('empty bills')
          alert('No bills found')
          document.getElementById('loadingCarf').style.display = "none"
          return false
      }
      document.getElementById('mainContent').style.display = "none"
      document.getElementById('cardcont').style.display = "block"
      let interval = 20000; //one second
      document.getElementById('tt2').innerHTML = printingSet.length


      modes.forEach((mode, index) => {
        setTimeout(() => {
          replaceBill(mode)
          // console.log(mode.business_no)
          if(parseInt(document.getElementById('tt2').innerHTML) === parseInt(document.getElementById('tt1').innerHTML)) {
            setTimeout(reloadPage, interval)
          }
        }, index * interval)
        // console.log('2');

        // if(parseInt(document.getElementById('tt2').innerHTML) == parseInt(document.getElementById('tt1').innerHTML)) {
        //   document.getElementById('loadingCarf').style.display = "none"
        //   document.getElementById('cardcont').style.display = "none"
        //   alert('completed.')
        //   return false
        // }
      })
      // console.log('3');



    }

    function ajaxPrintStatus(accountP) {
      var requestParams = {
        year: document.querySelector("select[name=year]").value,
        account: accountP
      }
      axios.get('/api/update/print/status', { params: requestParams })
            .then(response => console.log(response.data))
            .catch(error => console.error(error));
    }

    function startPrinting() {
      console.log('priniting');
      html2canvas(document.querySelector("#card")).then(canvas => {
        var b64Prefix = "data:image/png;base64,";
        var imgBase64DataUri = canvas.toDataURL("image/jpg");
        var imgBase64Content = imgBase64DataUri.substring(b64Prefix.length, imgBase64DataUri.length);

        //2. save image base64 content to server-side Application Cache
        $.ajax({
            type: "POST",
            url: "/api/StoreImageFileController",
            data: { base64ImageContent : imgBase64DataUri},
            success: function (imgFileName) {
                //alert("The image file: " + imgFileName + " was created at server side. Continue printing it...");

                //2. Print the stored image file specifying the created file name
                jsWebClientPrint.print('useDefaultPrinter=' + $('#useDefaultPrinter').attr('checked') + '&printerName=' + $('#installedPrinterName').val() + '&imageFileName=' + imgFileName);
            }
        });
      });
    }

    $("#printBtn").click(function () {
      console.table(printingSet)
      html2canvas($('#card'), {
        scale: 2,
        onrendered: function(canvas)
        {
          var b64Prefix = "data:image/png;base64,";
          var imgBase64DataUri = canvas.toDataURL("image/jpg");
          var imgBase64Content = imgBase64DataUri.substring(b64Prefix.length, imgBase64DataUri.length);

          //2. save image base64 content to server-side Application Cache
          $.ajax({
              type: "POST",
              url: "/api/StoreImageFileController",
              data: { base64ImageContent : imgBase64DataUri},
              success: function (imgFileName) {
                  //alert("The image file: " + imgFileName + " was created at server side. Continue printing it...");

                  //2. Print the stored image file specifying the created file name
                  jsWebClientPrint.print('useDefaultPrinter=' + $('#useDefaultPrinter').attr('checked') + '&printerName=' + $('#installedPrinterName').val() + '&imageFileName=' + imgFileName);
              }
          });
        }
       });

    });
});
</script>
@endsection
