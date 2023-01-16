@extends('layouts.backend.heinz')

@section('content')
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



                  </form>
                </div>

            </div>

        </div>


        <div class="row" style="display:block;">
          <div class="row">
            <div class="col-md-4">
              <input style="width:auto;" type="radio" id="check1" @click="toggleCheck()" name="sortType" value="noFilter" checked> <label for="">No Filtering</label>
            </div>
            <div class="col-md-4">
              <input style="width:auto;" type="radio" id="check2" @click="toggleCheck()" name="sortType" value="filter"> <label for="">Filter Report</label>
            </div>
          </div>
        </div>

        <div class="row" style="display:block;">
          <h1>hello</h1>
        </div>

        <div class="row" style="display:block;">
          <h1>hello</h1>
        </div>
    </div>
</div>






@endsection
@section('scripts')

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
          axios.get('/api/get/bill/count/p', { params: requestParams })
                .then(response => {document.querySelector("input[name=billNumbers]").value = response.data.data; this.gif=false})
                .catch(error => console.error(error));
        }
      },
      created() {
        this.toggleCheck()
      }


    });
</script>


@endsection
