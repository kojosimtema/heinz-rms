@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">
      <!-- setups.sms -->

        <div class="card-box table-responsive">
          <h3>Construct your custom sms</h3>
          <form class="form-horizontal" action="{{route('setups.sms')}}" method="post">
            @csrf
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Select account</label>
                <select class="form-control" name="account" style="width: 94%;">
                  <option value="all">all</option>
                  <option value="property">property</option>
                  <option value="business">business</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Select Zonal / SubMetro</label>
                <select class="form-control" name="zonal" style="width: 94%;">
                  <option value="">none</option>
                  <option value="all">all</option>
                  <?php
                    $zonals = \App\Models\Location\Zonal::orderBy('description', 'asc')->get();
                    foreach ($zonals as $zonal) { ?>
                      <option value="<?= $zonal->code; ?>"><?= $zonal->description; ?></option>
                      <?php
                    };
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Select Electoral</label>
                <select class="form-control" name="electoral" style="width: 94%;">
                  <option value="">none</option>
                  <option value="all">all</option>
                  <?php
                    $electorals = \App\Models\Location\Electoral::orderBy('description', 'asc')->get();
                    foreach ($electorals as $electoral) { ?>
                      <option value="<?= $electoral->code; ?>"><?= $electoral->description; ?></option>
                      <?php
                    };
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <textarea required name="message" class="form-control" style="width: 97%; height: 200px;"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <button type="submit" class="btn btn-primary">send sms</button>
              </div>
            </div>
          </form>
        </div>

    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
  function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
  }
</script>
@endsection
