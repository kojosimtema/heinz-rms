@extends('layouts.backend.heinz')

@section('content')

<div class="content">
  <div class="card search-card">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#menuZonal">| Filter By Date |</a></li>
      <li><a data-toggle="tab" href="#menuElectoral">| Filter By GCR |</a></li>
    </ul>
    <div class="tab-content" style="padding-top: 0px;">
      <div id="menuZonal" class="tab-pane fade in active">
        <h3 style="font-size: 19px; text-transform: uppercase;margin-left: 10px; margin-right: 10px;text-align:center;">Payment</h3>
        <hr style="border-top: 1px solid #ebeff2;margin-bottom: 10px;margin-top: 10px;width: 76%;">
        <form style="width: 100%" class="" action="{{route('statements.payment.preview')}}" method="get">
          @csrf
          <div class="row search-cont">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" name="startdate" required class="form-control" value="">
              </div>
            </div>
            <input type="hidden" name="mode" value="date">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" name="enddate" required class="form-control" value="">
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="form-control btn btn-xs">Preview</button>
            </div>
          </div>
        </form>
      </div>
      <div id="menuElectoral" class="tab-pane fade">
        <h3 style="font-size: 19px; text-transform: uppercase;margin-left: 10px; margin-right: 10px;text-align:center;">Payment</h3>
        <hr style="border-top: 1px solid #ebeff2;margin-bottom: 10px;margin-top: 10px;width: 76%;">
        <form style="width: 100%" class="" action="{{route('statements.payment.preview')}}" method="get">
          @csrf
          <input type="hidden" name="mode" value="gcr">
          <div class="row search-cont">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">GCR From</label>
                <input type="text" name="gcrfrom" required class="form-control" value="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">GCR To</label>
                <input type="gcrto" name="gcrto" required class="form-control" value="">
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="form-control btn btn-xs">Preview</button>
            </div>
          </div>
        </form>
      </div>

  </div>
</div>


@endsection

@section('scripts')


@endsection
