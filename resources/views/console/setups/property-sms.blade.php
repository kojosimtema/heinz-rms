@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">
        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                      <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Account List (<?php echo count($properties); ?>)</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                      @if ($errors->has('account_box'))
                          <small class="invalid-feedback">
                              <strong style="color:red;">{{ $errors->first('account_box') }}</strong>
                          </small>
                      @endif
                      <form class="" action="{{route('lgt.property.sms')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="p">
                        <section style="max-height: 365px;overflow: auto;">
                          <table class="table table-striped table-bordered dt-responsive fixed">
                              <thead style="font-size: 12px;">
                                  <tr role="row">
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">
                                        <input type="checkbox" onclick="toggle(this);" name="allBox" value="all">
                                      </th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Account No</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Owner</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Telephone</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Zonal</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Electoral</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Town Area</th>
                                      <th class="" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Community</th>
                                  </tr>
                              </thead>
                              <tbody style="font-size: 11px;">
                                  @foreach($properties as $property)
                                  <tr role="row" class="odd">
                                      <td class="sorting_1" tabindex="0">
                                        <input type="checkbox" name="account_box[]" value="<?php echo $property->property_no; ?>">
                                      </td>
                                      <td class="sorting_1" tabindex="0"><a href="{{route('property.show', $property->property_no)}}">{{$property->property_no}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">
                                        <?= $property->owner ? ($property->owner->name ?: 'NA') : $property->property_owner; ?>
                                      </a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">
                                        <?= $property->owner ? ($property->owner->phone ?: 'NA') : "NA"; ?>
                                      </a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">
                                        <?= $property->zonal ? ($property->zonal->description ?: 'NA') : $property->zonal_id; ?>
                                      </a></td>
                                      <td class="sorting_1" tabindex="0">
                                        <a href="#">
                                          <?= $property->electoral ? ($property->electoral->description ?: 'NA') : $property->electoral; ?>
                                        </a>
                                      </td>
                                      <td class="sorting_1" tabindex="0">
                                        <a href="#">
                                          <?= $property->tas ? ($property->tas->description ?: 'NA') : $property->tas; ?>
                                        </a>
                                      </td>
                                      <td class="sorting_1" tabindex="0">
                                        <a href="#">
                                          <?= $property->community ? ($property->community->description ?: 'NA') : $property->community; ?>
                                        </a>
                                      </td>

                                  </tr>

                                  @endforeach

                              </tbody>
                          </table>
                        </section>
                        <section class="row" style="margin-top:20px;">
                          <div class="form-group" style="width:100%;">
                            @if ($errors->has('message'))
                                <small class="invalid-feedback">
                                    <strong style="color:red;">{{ $errors->first('message') }}</strong>
                                </small>
                            @endif
                            <label for="">Customise your SMS</label>
                            <textarea name="message" class="form-control" style="width:100%;height: 140px;"></textarea>
                            <small style="color:#F44336;">
                              NB:&nbsp;available variables to use in customizing your sms: <code>#account</code> - account no, <code>#bill</code> - current bill,
                              <code>#arrears</code> - available arrears, <code>#owner</code> - account owner
                            </small>
                          </div>
                          <div class="form-group">
                            <button style="margin-top:30px;" type="submit" class="btn btn-sm btn-danger">Send SMS</button>
                          </div>
                        </section>
                      </form>
                    </div>
                    <div class="col-md-3">
                      <h4 class="fp">Filter Parameters</h4>
                      <hr style="margin-top: 10px;margin-bottom: 5px;">
                      <form class="filterbox" action="{{route('lgt.property.sms.query')}}" method="get">
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
                          <label for="">Account No</label>
                          <input style="width:100%;height:30px;" type="text" class="form-control" name="account_no" value="">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-sm">Filter Query</button>
                        </div>
                      </form>
                    </div>
                </div>

            </div>

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
