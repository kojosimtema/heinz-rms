@extends('layouts.backend.heinz')

@section('content')

<div class="content">
  <div class="card search-card">
    <div class="tab-content" style="padding-top: 0px;">
      <div id="menuProperty" class="tab-pane fade in active">
        <h3 style="font-size: 19px; text-transform: uppercase;margin-left: 10px; margin-right: 10px;text-align:center;">Defaulters List</h3>
        <hr style="border-top: 1px solid #ebeff2;margin-bottom: 10px;margin-top: 10px;width: 76%;">
        <form class="" action="{{route('report.defaulters.get')}}" method="get">
          @csrf
          <div class="row search-cont">

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Defaulting Operator</label>
                <select class="form-control" name="operator" required>
                  <option value="<">less than</option>
                  <option value=">">greater than</option>
                  <option value="=">equals</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Defaulting Amount</label>
                <input type="number" name="amount" class="form-control" value="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">For Year</label>
                <select class="form-control" name="bill_year" required>
                  <?php
                    for ($i=date('Y'); $i>2017; $i--) {?>
                      <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php }?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">On Bill</label>
                <select required class="form-control" name="account_type">
                  <option value="p">Property</option>
                  <option value="b">Business</option>
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
    </div>

  </div>
</div>


@endsection

@section('scripts')


@endsection
