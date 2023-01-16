@extends('layouts.backend.heinz')

@section('links')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<div class="content">
    <div class="container">
        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-8">
                      <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Account List (<?php echo count($bills); ?>) - <span style="color:#3f69b5;">FILTERED BY <?php echo $tag ?: ''; ?> </span> </h3>
                    </div>
                </div>
                <div id="mainContent" class="row">
                    <div class="col-md-9">
                      @if ($errors->has('account_box'))
                          <small class="invalid-feedback">
                              <strong style="color:red;">{{ $errors->first('account_box') }}</strong>
                          </small>
                      @endif
                      <form class="" action="{{route('lgt.property.sms')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="p">
                        <section style="max-height: 500px;overflow: auto;">
                          <table class="table table-striped table-bordered dt-responsive fixed">
                              <thead style="font-size: 12px;">
                                  <tr role="row">
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">
                                        <input type="checkbox" onclick="toggle(this);" name="allBox" value="all">
                                      </th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Account No</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending"style="width: 45px;">Type</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Rate PA</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Current Amt</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Arrears</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Balance</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Total Pmt</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 65px;">Year</th>
                                  </tr>
                              </thead>
                              <tbody style="font-size: 11px;">
                                  @foreach($bills as $bill)
                                  <tr role="row" class="odd">
                                      <td class="sorting_1" tabindex="0">
                                        <input type="checkbox" class="hdr" name="account_box[]" value="<?php echo $bill->account_no.'#'.$bill->year.'#'.$bill->bill_type; ?>">
                                      </td>
                                      <td class="sorting_1" tabindex="0"><a href="#"><?php echo $bill->account_no; ?></a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#"><?php echo $bill->bill_type; ?></a></td>
                                      <td class="sorting_1 text-number" tabindex="0"><a href="#"><?php echo $bill->rate_pa; ?></a></td>
                                      <td class="sorting_1 text-number" tabindex="0"><a href="#"><?php echo $bill->current_amount; ?></a></td>
                                      <td class="sorting_1 text-number" tabindex="0"><a href="#"><?php echo $bill->arrears; ?></a></td>
                                      <td class="sorting_1 text-number" tabindex="0"><a href="#"><?php echo $bill->account_balance; ?></a></td>
                                      <td class="sorting_1 text-number" tabindex="0"><a href="#"><?php echo $bill->total_paid; ?></a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#"><?php echo $bill->year; ?></a></td>

                                  </tr>

                                  @endforeach

                              </tbody>
                          </table>
                        </section>
                        <section class="row" style="margin-top:20px;">
                          <!-- skldk;flks;dlfks;d -->
                        </section>
                      </form>
                    </div>
                    <div class="col-md-3">
                      <h4 class="fp">Filter Parameters</h4>
                      <hr style="margin-top: 10px;margin-bottom: 5px;">
                      <form class="filterbox" action="{{route('lgt.property.bills.bulk.query')}}" method="get">
                        @csrf
                        <div class="form-group">
                          <label for="">Zonal</label>
                          <?php $zonals = App\Models\Location\Zonal::orderBy('description', 'asc')->get(); ?>
                          <select disabled class="form-control" name="">
                            <option value="">SELECT</option>
                            <?php foreach ($zonals as $key => $zonal): ?>
                              <option value="<?php echo $zonal->code; ?>"><?php echo $zonal->description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Electoral</label>
                          <?php $electorals = App\Models\Location\Electoral::orderBy('description', 'asc')->get(); ?>
                          <select class="form-control" name="electoral_id">
                            <option value="">SELECT</option>
                            <?php foreach ($electorals as $key => $electoral): ?>
                              <option value="<?php echo $electoral->code; ?>"><?php echo $electoral->description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Town Area</label>
                          <?php $tas = App\Models\Location\Ta::orderBy('description', 'asc')->get(); ?>
                          <select disabled class="form-control" name="">
                            <option value="">SELECT</option>
                            <?php foreach ($tas as $key => $ta): ?>
                              <option value="<?php echo $ta->code; ?>"><?php echo $ta->description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Community</label>
                          <?php $communities = App\Models\Location\Community::orderBy('description', 'asc')->get(); ?>
                          <select disabled class="form-control" name="">
                            <option value="">SELECT</option>
                            <?php foreach ($communities as $key => $community): ?>
                              <option value="<?php echo $community->code; ?>"><?php echo $community->description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Bill Type</label>
                          <select class="form-control" name="bill_type" required>
                              <!-- <option value="p">Property</option> -->
                              <option value="b">Business</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Bill year</label>
                          <select class="form-control" name="year" required>
                            <?php
                              for ($i=date('Y'); $i>2017; $i--) {?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                              <?php }?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Category</label>
                          <?php $categories = App\PropertyCategory::orderBy('description', 'asc')->get(); ?>
                          <select class="form-control" name="category">
                            <option value="">SELECT</option>
                            <?php foreach ($categories as $key => $category): ?>
                              <option value="<?php echo $category->code; ?>"><?php echo $category->description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Account No</label>
                          <input style="width:100%;height:30px;" type="text" class="form-control" name="account_no" value="">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-sm">Filter Query</button>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-12" style="background: #f1efec;padding-top: 5px;margin-top: 15px;padding-left: 15px;border: 1px solid #ccc;min-height: 90px;">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="checkbox" id="zeroRated" class="form-control" value="">
                          <label for="">Do not print bills with Zero(0) Rate Imposed</label>
                        </div> <br>
                        <div class="form-group">
                          <input type="checkbox" id="onlyCurrent" class="form-control" value="">
                          <label for="">Print only current fees</label>
                        </div>
                      </div>
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
                </div>



                <div class="row" id="loadingCarf" style="display:block;">
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
                        <h2 style="text-align: center; font-size: 20px; margin-top: -10px; margin-bottom: 0px; font-weight: 500; text-transform: capitalize;; color: black;">
                            @if ($setting->bill_date)
                            <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; right: 175px; text-transform: capitalize;">Bill date:
                              <span id="">&nbsp;&nbsp;&nbsp;<?= \Carbon\Carbon::parse($setting->bill_date)->toFormattedDateString();?></span>
                            </span>
                            @endif
                            <span style="position: relative; right:30px;">
                                Business Operating Permit <span id="lost3" style="display: none;">(Provisional)</span>
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
                              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Zone:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_zonal">NO NAME</span></p>
                            </article>
                            <article style="width:100%; display:flex;">
                              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_electoral">NO NAME</span></p>
                            </article>
                            {{-- <article style="width:100%; display:flex;">
                              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_tas">NO NAME</span></p>
                            </article> --}}
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
                              <span id="lost1">
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
                              </span>
                              <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Current Fee:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_current">GHc 225.00</span> &nbsp;&nbsp;</p>
                              </article>
                              <span id="lost2">
                                <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;padding-top: 5px; border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 5px; background: antiquewhite;">
                                  <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Total Amount Due Fee:</p>
                                  <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;"><span id="r_ac_total">GHc 225.00</span> &nbsp;&nbsp;</p>
                                </article>
                              </span>
                            </div>
                            <span id="lost4" style="display: none">
                                <article style="width:100%; display:flex; justify-content: space-between; margin-top: 10px;padding-top: 5px; margin-bottom: 5px;">
                                  <p style="color: black;margin-bottom: 0px;width: 100%;font-size: 13px; font-weight: 600; text-transform:uppercase;">
                                    this is a Provisional bill for the year, because it does not include arrears. all arrears before 31st Dec. of last Year
                                    will be sent later. For any enquiries, please contact the assembly's revenue office.
                                  </p>
                                </article>
                            </span>
                          </div>
                        </div>
                        <div style="background-color:white; width: 100%; font-size: 11px; color: black; margin-top:5px;">
                          <p>{{$setting->enforce_law_text}}</p>
                          <h4 style="color: black; text-transform: uppercase; font-weight: 600; text-align: center; margin-top: -3px; font-size: 22px;">payment should be made with the bill</h4>
                          <h5 style="text-align: center; text-transform: uppercase; font-weight: 600; margin-top: -4px; color: black; font-size: 16px; letter-spacing: 2px;">pay your bills promptly and help keep the city clean</h5>
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

    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="/js/select2.js"></script>
<script type="text/javascript">
function toggle(source) {
  var checkboxes = document.querySelectorAll('input[type="checkbox"].hdr');
  for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i] != source)
          checkboxes[i].checked = source.checked;
  }
}
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
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
  var printingSet = [];
  var globalYear;
  var globalType;
  $('#isp').on('click', function() {
    var billsArray = [];
    var billYear;
    var type;
    var checkboxes = document.querySelectorAll('input[type="checkbox"].hdr');
    document.getElementById('loadingCarf').style.display = "block"
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked){
        billsArray.push((checkboxes[i].value).split('#')[0]);
        billYear = (checkboxes[i].value).split('#')[1];
        type = (checkboxes[i].value).split('#')[2];
        globalType = (checkboxes[i].value).split('#')[2];
        globalYear = (checkboxes[i].value).split('#')[1];
      }

    }

    console.log('bill Array:  ' + billsArray);

    var requestParams = {
      account: billsArray,
      year: billYear
    }

    axios.post(`/api/get/bulkbill/set/${type.toLowerCase()}`, requestParams)
          .then(response => {printingSet = response.data.data; timerReplace()})
          .catch(error => console.error(error));
  });
  $('#repPrintBtn').on('click', function(){
      document.getElementById('repPrint').style.display = "block"
      document.getElementById('repPrint2').style.display = "block"
  });
    // $("#isp").click(function () {
    //   issuePrint()
    //   captureArraySet()
    //
    // });

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

      axios.post(`/api/get/bill/set/${globalType}`, { params: requestParams })
            .then(response => {printingSet = response.data.data; timerReplace()})
            .catch(error => console.error(error));




    }

    function replaceBill(mode) {
        // array[i]

        // console.log(parseInt(document.getElementById('tt2').innerHTML));
        // console.log(parseInt(document.getElementById('tt1').innerHTML));
        console.log('Modes Bills:  ' + mode);
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
        var onlyCurrentBox = document.querySelector('#onlyCurrent').checked;
        console.log('.................')
        console.log(parentParse)
        // console.table(currentBill)
        // console.log();

        document.getElementById('r_acc_no').innerHTML = parentParse.business_no
        document.getElementById('r_acc_bname').innerHTML = parentParse.business_name
        document.getElementById('r_acc_address').innerHTML = parentParse.address
        document.getElementById('r_acc_snumber').innerHTML =  parentParse.store_number ? parentParse.store_number : ''
        document.getElementById('r_acc_name').innerHTML = parentParse.owner ? parentParse.owner.name : 'NA'
        document.getElementById('r_acc_phone').innerHTML = parentParse.phone ? parentParse.phone : 'NA'
        document.getElementById('r_ac_type').innerHTML = parentParse.type.description
        document.getElementById('r_ac_category').innerHTML = parentParse.category.description
        document.getElementById('r_ac_imposed').innerHTML = currentBill.rate_pa ? `${formatDollar(parseFloat(currentBill.rate_pa))} ` : `${formatDollar(parseFloat(0.0))} `
        document.getElementById('r_ac_zonal').innerHTML = parentParse.zonal ? parentParse.zonal.description : 'NO NAME'
        document.getElementById('r_ac_electoral').innerHTML = parentParse.electoral ? parentParse.electoral.description : 'NO NAME'
        document.getElementById('r_ac_com').innerHTML = parentParse.communities ? parentParse.communities.description : 'NO NAME'
        // document.getElementById('r_ac_tas').innerHTML = parentParse.tas ? parentParse.tas.description : "NO NAME"
        document.getElementById('r_ac_street').innerHTML = parentParse.street ? parentParse.street.description : "NO NAME"
        document.getElementById('r_ac_pyear').innerHTML = currentBill.p_year_bill ? `${formatDollar(parseFloat(formatAmount(currentBill.p_year_bill)) + parseFloat(formatAmount(currentBill.adjust_arrears ?currentBill.adjust_arrears: 0.0)))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_amountpaid').innerHTML = currentBill.p_year_total_paid ? `${formatDollar(parseFloat(currentBill.p_year_total_paid))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_arrears').innerHTML = currentBill.arrears ? `${formatDollar(parseFloat(formatAmount(currentBill.original_arrears)) + parseFloat(formatAmount(currentBill.adjust_arrears ?currentBill.adjust_arrears: 0.0))) } ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_current').innerHTML = currentBill.current_amount ? `${formatDollar(parseFloat(currentBill.current_amount))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_total').innerHTML = currentBill.account_balance ? `${formatDollar(parseFloat(currentBill.account_balance))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_year').innerHTML = currentBill.year



        // if((parentParse.address == '' || parentParse.address == null) && (parentParse.house_no == '' || parentParse.house_no == null)){
        //   document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
        //   return true;
        // }

        if(onlyCurrentBox) {
            console.log('checked.......current')
            document.getElementById('lost1').style.display = "none";
            document.getElementById('lost2').style.display = "none";
            document.getElementById('lost3').style.display = "inline";
            document.getElementById('lost4').style.display = "inline";
        }else{
            document.getElementById('lost3').style.display = "none";
            document.getElementById('lost4').style.display = "none";
        }

        if(zeroRatedBox){
          if(parseFloat(currentBill.account_balance) == parseFloat(0) || parseFloat(currentBill.account_balance) == parseFloat(0.0)){
            console.log('zero');
            document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
            return true;
          }else{
            startPrinting()
            ajaxPrintStatus(parentParse.property_no)
          }
        }else{
          startPrinting()
          ajaxPrintStatus(parentParse.property_no)
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

      // console.log(printingSet);
      // return false

      let modes = printingSet;
      console.log('Modes:  ' + modes);
      if (modes === undefined || modes.length == 0) {
          console.log('empty bills')
          alert('No bills found')
          document.getElementById('loadingCarf').style.display = "none"
          return false
      }
      document.getElementById('mainContent').style.display = "none"
      document.getElementById('cardcont').style.display = "block"
      let interval = 10000; //one second
      document.getElementById('tt2').innerHTML = printingSet.length


      modes.forEach((mode, index) => {
        setTimeout(() => {
          replaceBill(mode)
          // console.log(mode.property_no)
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
        year: globalYear,
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
