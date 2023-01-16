@extends('layouts.backend.heinz')

@section('content')

<div class="content">
  <div class="card search-card">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#menuProperty">Property</a></li>
      <li><a data-toggle="tab" href="#menuBusiness">Business</a></li>
    </ul>
    <div class="tab-content" style="padding-top: 0px;">
      <div id="menuProperty" class="tab-pane fade in active">
        <h3 style="font-size: 19px; text-transform: uppercase;margin-left: 10px; margin-right: 10px;text-align:center;">Property Fee Fixing Listings</h3>
        <hr style="border-top: 1px solid #ebeff2;margin-bottom: 10px;margin-top: 10px;width: 76%;">
        <form class="" action="{{route('advanced.report.feefixing')}}" method="get">
          @csrf
          <div class="row search-cont">

            <div class="col-md-12">
              <div class="form-group">
                <label for="">Enter Year</label>
                <select class="form-control" name="year" required>
                  <?php
                    for ($i=date('Y'); $i>2017; $i--) {?>
                      <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php }?>
                </select>
              </div>
            </div>
            <input type="hidden" name="account" value="property">
            <div class="col-md-12">
              <button type="submit" class="form-control btn btn-xs">Preview</button>
            </div>
          </div>
        </form>
      </div>
      <div id="menuBusiness" class="tab-pane fade in">
        <h3 style="font-size: 19px; text-transform: uppercase;margin-left: 10px; margin-right: 10px;text-align:center;">Business Fee Fixing Listings</h3>
        <hr style="border-top: 1px solid #ebeff2;margin-bottom: 10px;margin-top: 10px;width: 76%;">
        <form class="" action="{{route('advanced.report.feefixing')}}" method="get">
          @csrf
          <div class="row search-cont">

            <div class="col-md-12">
              <div class="form-group">
                <label for="">Enter Year</label>
                <select class="form-control" name="year" required>
                  <?php
                    for ($i=date('Y'); $i>2017; $i--) {?>
                      <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php }?>
                </select>
              </div>
            </div>
            <input type="hidden" name="account" value="business">
            <div class="col-md-12">
              <button type="submit" class="form-control btn btn-xs">Preview</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>


@endsection

@section('scripts')


@endsection
