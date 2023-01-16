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
                              <option value="p">Property</option>
                              <!-- <option value="b">Business</option> -->
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
                      <div class="col-md-3">
                        <div class="form-group">
                          <select id="tselect" disabled class="form-control" onchange="toggleView();" style=" width: 100%;height: 30px;position: relative;top: 6px;">
                            <option value="bills">Bills</option>
                            <option value="demand">Demand Notice</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="checkbox" id="zeroRated" class="form-control" value="">
                          <label for="">Do not print bills with Zero(0) Rate Imposed</label>
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



                <div class="row" id="loadingCarf" style="display:none;">
                  <div class="col-md-6">
                    <h4><img src="/backend/images/25.gif" alt="" style="width: 19px;margin-right: 4px;">Loading... <span id="tt1" style="color:red;">0</span> / <span id="tt2"></span> </h4>
                  </div>
                  <div class="col-md-6">
                    <h4>Zero Imposed Bills: <span id="tt3" style="color: red;">0</span> </h4>
                  </div>
                </div>

                <div id="cardcont" style="display:block;">
                  <article id="bill2">
                    <div id="card" style="width: 1000px; height: 100%; padding-top: 30px; padding-bottom: 20px; border-radius: 0px; background-color:white; margin-top: 60px; margin-bottom: 50px;">
                      <div style="display:flex;">
                        <div style="width:250px;border-right: 2px dashed #000;height: 100%;">
                          <div style="text-align: center;">
                            <img src="{{$setting->logo}}" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                          </div>
                          <h3 style="text-align: center; font-size: 15px; font-weight: 600; color: black; text-transform: uppercase;"><?= env('ASSEMBLY_SMS_NAME'); ?></h3>
                          <p style="text-align: center; font-size: 13px; font-style: italic; font-weight: 200; color: black; text-transform: capitalize;position:relative;top:-10px;">Counterfoil</p>
                          <article style="width:100%; display:flex;">
                            <p style="color: black;margin-bottom: 0px;width: 38%;font-size: 13px; font-weight: 600;">Account No:</p>
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_no_2">AAS4444</span></p>
                          </article>
                          <article style="width:100%; display:flex; height: 55px; padding-top: 0px;">
                            <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 18px; font-weight: 600;"><span id="r_acc_name_2">MT. CALVSRY SCH.</span></p>
                          </article>
                          <article style="width: 100%; display: flex; height: 45px; padding-top: 0px;margin-top:-26px;">
                            <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 14px; font-weight: 300;"><span id="r_acc_phone_2">0248160008</span></p>
                          </article>
                          <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;position: relative;top: -11px;"><span id="r_acc_address_2">Konongo</span></p>
                          <article style="width:100%; display:flex;margin-top:10px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Property Type:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_type_2">COMMERCIAL PROPERTY RATE</span></p>
                          </article>
                          <article style="width:100%; display:flex;margin-top:4px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Property Cat:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_category_2">PRIVATE SCHOOL</span></p>
                          </article>
                          <article style="width:100%; display:flex;margin-top: 5px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;"><?php echo strtolower($setting->organization_type) == strtolower('metro') ? 'Sub Metro' : 'Zones'; ?>:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_zonal_2">NO NAME</span></p>
                          </article>
                          <article style="width:100%; display:flex;margin-top: 0px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_electoral_2">NO NAME</span></p>
                          </article>
                          <article style="width:100%; display:flex;margin-top: 0px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_tas_2">NO NAME</span></p>
                          </article>
                          <article style="width:100%; display:flex;margin-top: 0px;">
                            <!-- <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p> -->
                            <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_street_2">NO NAME</span></p>
                          </article>
                          <div style="background-color:white; width:80%; border:2px solid black; margin-top: 20px; padding-left: 10px; padding-bottom: 10px;">
                            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                              <p style="color: black;margin-bottom: 0px;width: 55%;font-size: 12px; font-weight: 600;">Rateable value:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 11px; font-weight: 300;"><span id="r_ac_rateable_2">GHc 37,500.00</span>&nbsp;&nbsp;</p>
                            </article>
                            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 15px;">
                              <p style="color: black;margin-bottom: 0px;width: 55%;font-size: 12px; font-weight: 600;">Rate Imposed:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 11px; font-weight: 300;"><span id="r_ac_imposed_2">0.006</span> &nbsp;&nbsp;</p>
                            </article>
                          </div>
                          <div style="background-color:white; width:100%; border:2px solid black; margin-top: 1px; padding-left: 10px; padding-bottom: 3px;">
                            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 12px; font-weight: 600;">Arrears:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 12px; font-weight: 300;"><span id="r_ac_arrears_2">GHc 0.00</span> &nbsp;&nbsp;</p>
                            </article>
                            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                              <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 12px; font-weight: 600;">Current Fee:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 12px; font-weight: 300;"><span id="r_ac_current_2">GHc 225.00</span> &nbsp;&nbsp;</p>
                            </article>
                            <article style="width:100%; display:flex; justify-content: space-between; margin-top: 10px;padding-top: 5px; border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 5px; background: antiquewhite;">
                              <p style="color: black;margin-bottom: 0px;width: 60%;font-size: 12px; font-weight: 600;">Total Amount Due Fee:</p>
                              <p style="color: black;margin-bottom: 0px;font-size: 12px; font-weight: 600;"><span id="r_ac_total_2">GHc 225.00</span> &nbsp;&nbsp;</p>
                            </article>
                          </div>
                          <!-- <div style="height:60px;"></div> -->
                        </div>
                        <!-- END OF LEFT -->
                        <div style="width: 725px; background-color:white; margin-left:auto;">
                          <div style="background-color:white; width:680px; display: flex; flex-direction: row;">
                            <img src="{{$setting->logo}}" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                            <div style="width: 640px; border: 2px solid black; height: 100%; margin: auto;">
                              <h3 style="text-align: center; font-size: 25px; font-weight: 600; color: black; text-transform: uppercase;"><?= env('ASSEMBLY_SMS_NAME'); ?></h3>
                            </div>
                            <img src="/images/assemblies/ghanacoatofarms.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                          </div>
                          <h2 style="text-align: center; font-size: 26px; margin-top: 0px; margin-bottom: 0px; font-weight: 500; text-transform: uppercase; color: black;">Property Rate
                            <span style="color: black; margin-bottom: 0px; width: 40%; font-size: 13px; font-weight: 800; position: relative; left: 100px; text-transform: capitalize;">Bill year:
                              <span id="r_ac_year" style="position: relative; left: 14px;">2019</span>
                            </span>
                          </h2>
                          <hr style="margin-top: 0px; margin-bottom: 20px; width: 65%; border-top: 2px solid black;">
                          <div style="background-color: white; width:725px; display: flex;">
                            <div style="background-color: white; width: 290px;">
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Account No:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_no">AAS4444</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">House No:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_hsno">DDL4/RL</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Address:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;<span id="r_acc_address">Konongo</span></p>
                              </article>
                              <article style="width:100%; display:flex; height: 55px; padding-top: 0px;">
                                <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 18px; font-weight: 600;"><span id="r_acc_name">MT. CALVSRY SCH.</span></p>
                              </article>
                              <article style="width: 100%; display: flex; height: 45px; padding-top: 0px;margin-top:-26px;">
                                <p style="color: black;margin-bottom: 10px;margin-top: 10px;font-size: 14px; font-weight: 600;"><span id="r_acc_phone">0248160008</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <!-- <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Property Type:</p> -->
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">&nbsp;&nbsp;&nbsp;<span id="r_ac_type">COMMERCIAL PROPERTY RATE</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <!-- <p style="color: black;margin-bottom: 0px;width: 28%;font-size: 13px; font-weight: 600;">Property Cat:</p> -->
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;">&nbsp;&nbsp;&nbsp;<span id="r_ac_category">PRIVATE SCHOOL</span></p>
                              </article>

                              <div style="background-color:white; width:90%; border:2px solid black; margin-top: 10px; padding-left: 10px; padding-bottom: 10px;">
                                <article style="width:100%; display:flex; justify-content: space-between; margin-top: 5px;">
                                  <p style="color: black;margin-bottom: 0px;width: 45%;font-size: 13px; font-weight: 600;">Rateable value:</p>
                                  <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_rateable">GHc 37,565700.00</span>&nbsp;&nbsp;</p>
                                </article>
                                <article style="width:100%; display:flex; justify-content: space-between; margin-top: 15px;">
                                  <p style="color: black;margin-bottom: 0px;width: 55%;font-size: 13px; font-weight: 600;">Rate Imposed:</p>
                                  <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 300;"><span id="r_ac_imposed">0.006</span> &nbsp;&nbsp;</p>
                                </article>
                              </div>
                              <div style="background-color:white; display:block; width: 100%;">
                                <div style="background-color:white; display:flex; padding-top: 10px;">
                                  <h4 style="font-size: 15px; font-weight: 600; color:black;">Stamp:&nbsp;&nbsp;&nbsp;</h4>
                                  <img src="{{$setting->signature}}" style="width: 180px; height: 70px; object-fit: contain;">
                                </div>
                                <hr style="margin-top: 2px; margin-bottom: 2px; border-top: 2px dashed black; width: 80%; margin-left: inherit;">
                                <p style="text-transform: uppercase; font-size: 10px; width: 80%; color:black; text-align: center; font-weight:500;">{{$setting->authority_person}}</p>
                              </div>
                            </div>
                            <div style="background-color: white; width: 400px;">
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;"><?php echo strtolower($setting->organization_type) == strtolower('metro') ? 'Sub Metro' : 'Zones'; ?>:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_zonal">NO NAME</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_electoral">NO NAME</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_tas">NO NAME</span></p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_street">NO NAME</span></p>
                              </article>
                              <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 10px; margin-bottom:0px;">All bills must be settled on or before &nbsp;<?= \Carbon\Carbon::parse($setting->paymet_date)->toFormattedDateString();?></p>
                              <p style="font-size: 13px; font-weight: 600; color: black; margin-top: 10px;">For enquires contact the <?= $setting->organization_type; ?> finance office on the ff Nos. <?= $setting->contact_info_text; ?></p>
                              <div style="background-color:white; width:100%; border:2px solid black; margin-top: 10px; padding-left: 10px; padding-bottom: 3px;">
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
                                <article style="width:100%; display:flex; justify-content: space-between; margin-top: 10px;padding-top: 5px; border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 5px; background: antiquewhite;">
                                  <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Total Amount Due Fee:</p>
                                  <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;"><span id="r_ac_total">GHc 225.00</span> &nbsp;&nbsp;</p>
                                </article>
                              </div>
                            </div>
                          </div>
                          <div style="background-color:white; width: 100%; font-size: 11px; color: black; margin-top:0px;">
                            <p>{{$setting->enforce_law_text}}</p>
                            <h4 style="color: black; text-transform: uppercase; font-weight: 600; text-align: center; margin-top: -3px; font-size: 22px;">payment should be made with the bill</h4>
                            <h5 style="text-align: center; text-transform: uppercase; font-weight: 600; color: black; font-size: 16px; margin-top: -5px; letter-spacing: 2px;">pay your bills promptly and help the city clean</h5>
                            <hr style="border-top: 2px dashed black;">
                          </div>

                        </div>
                      </div>
                  </div>
                  </article>
                  <article id="demand2">
                    <div id="card" style="width: 1000px; height: 100%; padding-top: 50px; padding-bottom: 20px; border-radius: 0px; background-color:white; margin-top: 100px; margin-bottom: 50px;">
                        <div style="width: 804px; background-color:white; margin:auto; border: 2px solid #000;">
                          <div style="background-color:white; width:800px; display: flex; flex-direction: row;">
                            <img src="{{$setting->logo}}" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                            <div style="width: 640px;">
                              <h3 style="text-align: center; font-size: 25px; font-weight: 600; color: black; text-transform: uppercase;"><?= env('ASSEMBLY_SMS_NAME'); ?></h3>
                              <hr style="margin-top: 0px; margin-bottom: 0px; width: 90%; border-top: 2px solid black;">
                              <h2 style="text-align: center; font-size: 26px; font-weight: 500; text-transform: uppercase; color: black;">Property Rate Demand Notice</h2>
                            </div>
                            <img src="/images/assemblies/ghanacoatofarms.jpg" style="width: 80px; height: 80px; object-fit: contain; margin: auto;">
                          </div>
                          <hr style="margin-top: 0px; margin-bottom: 5px; border-top: 1px solid #eee;">
                          <div style="background-color: white; width:800px; display: flex;">
                            <div style="background-color: white; width: 400px;">
                              <ul style="list-style: none; padding-left: 5px;">
                                <li style="color: black;font-size: 13px; font-weight: 600;">Account No.: &nbsp;&nbsp;&nbsp;&nbsp;<span id="r_acc_no_3">P-N1006173</span></li>
                                <li style="color: black;font-size: 18px; font-weight: 600;"><span id="r_acc_name_3">PATRICIAL BAAFI</span> </li>
                                <li style="color: black;font-size: 13px; font-weight: 600;"><span id="r_acc_hsno_3">OP/019-001 &</span> </li>
                                <li style="color: black;font-size: 13px; font-weight: 600;"><span id="r_acc_address_3">-HABITAB STREET</span> </li>
                              </ul>
                            </div>
                            <div style="background-color: white; width: 400px;">
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Zones:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_zonal_3">NEW TOWN ZONAL COUNCIL</span> </p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Electoral Area:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_electoral_3">TWUMASEN</span> </p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Town Area Council:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_tas_3">OBUASE</span> </p>
                              </article>
                              <article style="width:100%; display:flex;">
                                <p style="color: black;margin-bottom: 0px;width: 40%;font-size: 13px; font-weight: 600;">Street:</p>
                                <p style="color: black;margin-bottom: 0px;font-size: 13px; font-weight: 600;">&nbsp;&nbsp;&nbsp;&nbsp;<span id="r_ac_street_3">NO NAME</span> </p>
                              </article>
                            </div>
                          </div>
                        </div>
                        <div style="background-color:white; width: 900px; margin:auto;">
                          <h4 style="text-transform: uppercase; font-size: 25px; text-align: center; line-height: 28px; color: black;">
                            This demand notice is a warning informing you of your indebtedness to the assembly for non payment of your tax obligation of property
                            rate as as 31 august 2018. pursuant to section 137,141 adnd 156 of the local governance act 2016(act 936) and the bye laws of the
                            <?= strtolower(env('ASSEMBLY_SMS_NAME')); ?>, we trust you will hereby do payment to the assigned revenue office or collector in your area on or before <?= \Carbon\Carbon::parse($setting->paymet_date)->toFormattedDateString();?> to avoid legal actions or court prosecution.
                          </h4>
                        </div>
                        <div style="background-color:white; width: 804px; margin:auto; display:flex;">
                          <div style="background-color:white; display:block; width: 40%;">
                            <div style="background-color:white; display:flex; padding-top: 30px;">
                              <h4 style="font-size: 15px; font-weight: 600; color:black;">Stamp:&nbsp;&nbsp;&nbsp;</h4>
                              <img src="{{$setting->signature}}" style="width: 130px; height: 35px; object-fit: contain;">
                            </div>
                            <hr style="margin-top: 2px; margin-bottom: 2px; border-top: 2px dashed black; width: 80%; margin-left: inherit;">
                            <p style="text-transform: uppercase; font-size: 10px; color:black; text-align: center; font-weight:500;">{{$setting->authority_person}}r</p>
                          </div>
                          <div style="background-color:white; width: 60%; display:flex;">
                            <div style="background-color:white; width:40%;">
                              <ul style="list-style: none; padding-left: 2px; margin-bottom: 0px;">
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">Arrears</li>
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">Current Fee</li>
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; background-color: antiquewhite;">Current  Year Payment</li>
                                <li style="font-size: 16px; font-weight: 600; height: 25px; color: black; background-color: antiquewhite; margin-top: 3px; border-top: 1px solid #000; border-bottom: 1px solid #000;">Total Amount Due</li>
                              </ul>
                            </div>
                            <div style="background-color:white; width:60%; text-align: right;">
                              <ul style="list-style: none; padding-left: 2px; margin-bottom: 0px; width: 90%; margin-left: auto;">
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">GHc&nbsp;&nbsp;<span id="r_ac_arrears_3">150.00</span> </li>
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; ">GHc&nbsp;&nbsp;<span id="r_ac_current_3">100.00</span> </li>
                                <li style="font-size: 13px; font-weight: 500; height:25px; color: black; background-color: antiquewhite;">GHc&nbsp;&nbsp;0.00</li>
                                <li style="font-size: 16px; font-weight: 600; height: 25px; color: black; background-color: antiquewhite; margin-top: 3px; border-top: 1px solid #000; border-bottom: 1px solid #000;">GHc&nbsp;&nbsp;<span id="r_ac_total_3">250.00</span> </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                    </div>
                  </article>

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
function toggleView() {
  var view = document.getElementById('tselect');
  if (view.value == 'bills'){
    document.getElementById('bill2').style.display = "block";
    document.getElementById('demand2').style.display = "none";
  }else if(view.value == 'demand') {
    document.getElementById('demand2').style.display = "block";
    document.getElementById('bill2').style.display = "none";
  }else{
    document.getElementById('bill2').style.display = "none";
    document.getElementById('demand2').style.display = "none";
  }
}
function pageLoad(){
  document.getElementById('bill2').style.display = "block";
  document.getElementById('demand2').style.display = "none";
}
window.load = pageLoad();
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
        console.log(parentParse)
        // console.table(currentBill)
        // console.log();
        document.getElementById('r_acc_no').innerHTML = parentParse.property_no
        document.getElementById('r_acc_name_2').innerHTML = parentParse.owner ? parentParse.owner.name : ''
        document.getElementById('r_acc_no_2').innerHTML = parentParse.property_no
        document.getElementById('r_acc_name').innerHTML = parentParse.owner ? parentParse.owner.name : ''
        document.getElementById('r_acc_hsno').innerHTML = (parentParse.house_no && parentParse.house_no != 'NULL') ? parentParse.house_no : ''
        document.getElementById('r_acc_address').innerHTML = parentParse.address ? parentParse.address : ''
        document.getElementById('r_acc_phone').innerHTML = parentParse.owner ? ((parentParse.owner.phone && parentParse.owner.phone != 'Null') ? parentParse.owner.phone : '') : ''
        document.getElementById('r_acc_name_3').innerHTML = parentParse.owner ? parentParse.owner.name : ''
        document.getElementById('r_acc_hsno_3').innerHTML = (parentParse.house_no && parentParse.house_no != 'NULL') ? parentParse.house_no : ''
        document.getElementById('r_acc_address_3').innerHTML = parentParse.address ? parentParse.address : ''
        // document.getElementById('r_acc_phone_3').innerHTML = parentParse.owner ? ((parentParse.owner.phone && parentParse.owner.phone != 'Null') ? parentParse.owner.phone : '') : ''
        document.getElementById('r_ac_type').innerHTML = parentParse.type ? parentParse.type.description : 'NA'
        document.getElementById('r_ac_category').innerHTML = parentParse.category ? parentParse.category.description : 'NA'
        document.getElementById('r_ac_rateable').innerHTML = currentBill.rateable_value ? `${formatDollar(parseFloat(currentBill.rateable_value))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_imposed').innerHTML = currentBill.rate_imposed ? `${parseFloat(currentBill.rate_imposed)} ` : `${parseFloat(0.0)} `
        document.getElementById('r_ac_zonal').innerHTML = parentParse.zonal ? parentParse.zonal.description : 'NO NAME'
        document.getElementById('r_ac_electoral').innerHTML = parentParse.electoral ? parentParse.electoral.description : 'NO NAME'
        document.getElementById('r_ac_tas').innerHTML = parentParse.tas ? parentParse.tas.description : "NO NAME"
        document.getElementById('r_ac_street').innerHTML = parentParse.street ? parentParse.street.description : "NO NAME"
        document.getElementById('r_ac_zonal_3').innerHTML = parentParse.zonal ? parentParse.zonal.description : 'NO NAME'
        document.getElementById('r_ac_electoral_3').innerHTML = parentParse.electoral ? parentParse.electoral.description : 'NO NAME'
        document.getElementById('r_ac_tas_3').innerHTML = parentParse.tas ? parentParse.tas.description : "NO NAME"
        document.getElementById('r_ac_street_3').innerHTML = parentParse.street ? parentParse.street.description : "NO NAME"
        document.getElementById('r_acc_address_2').innerHTML = parentParse.address ? parentParse.address : ''
        document.getElementById('r_acc_phone_2').innerHTML = parentParse.owner ? ((parentParse.owner.phone && parentParse.owner.phone != 'Null') ? parentParse.owner.phone : '') : ''
        document.getElementById('r_ac_type_2').innerHTML = parentParse.type ? parentParse.type.description : 'NA'
        document.getElementById('r_ac_category_2').innerHTML = parentParse.category ? parentParse.category.description : 'NA'
        document.getElementById('r_ac_rateable_2').innerHTML = currentBill.rateable_value ? `${formatDollar(parseFloat(currentBill.rateable_value))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_imposed_2').innerHTML = currentBill.rate_imposed ? `${parseFloat(currentBill.rate_imposed)} ` : `${parseFloat(0.0)} `
        document.getElementById('r_ac_zonal_2').innerHTML = parentParse.zonal ? parentParse.zonal.description : 'NO NAME'
        document.getElementById('r_ac_electoral_2').innerHTML = parentParse.electoral ? parentParse.electoral.description : 'NO NAME'
        document.getElementById('r_ac_tas_2').innerHTML = parentParse.tas ? parentParse.tas.description : "NO NAME"
        document.getElementById('r_ac_street_2').innerHTML = parentParse.street ? parentParse.street.description : "NO NAME"
        document.getElementById('r_ac_pyear').innerHTML = currentBill.p_year_bill ? `${formatDollar(parseFloat(currentBill.p_year_bill) + parseFloat(currentBill.adjust_arrears))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_amountpaid').innerHTML = currentBill.p_year_total_paid ? `${formatDollar(parseFloat(currentBill.p_year_total_paid))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_arrears').innerHTML = currentBill.arrears ? `${formatDollar(parseFloat(currentBill.original_arrears))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_current').innerHTML = currentBill.current_amount ? `${formatDollar(parseFloat(currentBill.current_amount))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_total').innerHTML = currentBill.account_balance ? `${formatDollar(parseFloat(currentBill.account_balance))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_arrears_2').innerHTML = currentBill.arrears ? `${formatDollar(parseFloat(currentBill.arrears))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_current_2').innerHTML = currentBill.current_amount ? `${formatDollar(parseFloat(currentBill.current_amount))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_total_2').innerHTML = currentBill.account_balance ? `${formatDollar(parseFloat(currentBill.account_balance))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_arrears_3').innerHTML = currentBill.arrears ? `${formatDollar(parseFloat(currentBill.arrears))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_current_3').innerHTML = currentBill.current_amount ? `${formatDollar(parseFloat(currentBill.current_amount))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_total_3').innerHTML = currentBill.account_balance ? `${formatDollar(parseFloat(currentBill.account_balance))} ` : `${formatDollar(0.0)} `
        document.getElementById('r_ac_year').innerHTML = currentBill.year

        // if((parentParse.address == '' || parentParse.address == null) && (parentParse.house_no == '' || parentParse.house_no == null)){
        //   document.getElementById('tt3').innerHTML = parseInt(document.getElementById('tt3').innerHTML) + 1
        //   return true;
        // }

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
      var card = "#" + document.getElementById('tselect').value + "2"
      html2canvas(document.querySelector(card)).then(canvas => {
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
