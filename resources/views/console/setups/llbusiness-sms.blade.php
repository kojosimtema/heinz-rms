@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="dataTables_length" id="datatable-responsive_length">
                            <div class="row">
                              <div class="col-md-6">
                                <a href="{{route('setups.sms')}}">Property</a>
                              </div>
                              <div class="col-md-6">
                                <a href="{{route('setups.sms.business')}}">Business</a>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                      <form class="" action="{{route('setups.sms.filter.zonal')}}" method="get">
                        @csrf
                        <div id="datatable-responsive_filter" class="dataTables_filter">
                            <label>Search:
                              <select required class="form-control input-sm" name="zonal" style="margin-rigt: 80px; width: 100%;">
                                <option selected value="">None</option>
                                <?php $zonals = \App\Models\Location\Zonal::orderBy('code', 'asc')->get(); ?>
                                @foreach($zonals as $zonal)
                                <option value="{{$zonal->code}}">{{$zonal->description}}</option>
                                @endforeach
                              </select>
                            </label>
                            <button type="submit" class="form-control btn-primary" style="height: 30px; padding-top: 4px;">Filter Zonal</button>
                        </div>
                      </form>

                    </div>
                </div>
                <div class="row">
                    <form class="" action="{{route('setups.sms')}}" method="post">
                      @csrf
                      <input type="hidden" name="type" value="property">
                      @if($zonal_id)
                      <input type="hidden" name="zonal_id" value="{{$zonal_id->code}}">
                      @endif
                      <div class="col-sm-12" style="height: 296px; overflow: auto;">
                          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                              <thead>
                                  <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 10px;">
                                        <input type="checkbox" onclick="toggle(this);" name="allAccount" value="1">
                                      </th>
                                      <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Account No</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Zonal</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Business Owner</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Telephone</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @if($businesses->count() < 1)
                                  <h3 style="color: red;">No business data!</h3>
                                @endif
                                @foreach($businesses as $business)
                                <tr role="row" class="odd">
                                    <td class="sorting_1" tabindex="0">
                                      <input type="checkbox" name="property[]" class="checkall" value="<?= $business->owner ? $business->owner->phone : ''; ?>">
                                    </td>
                                    <td class="sorting_1" tabindex="0"><a href="#">{{$business->business_no}}</a></td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="#">
                                        @if($business->zonal)
                                        {{$business->zonal->description}}
                                        @else
                                        {{$business->zonal_id}}
                                        @endif
                                      </a>
                                    </td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="#">
                                        @if($business->owner)
                                        {{$business->owner->name}}
                                        @else
                                        {{$business->business_no}}
                                        @endif
                                      </a>
                                    </td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="#">
                                        @if($business->owner)
                                        {{$business->owner->phone}}
                                        @else
                                          -
                                        @endif
                                      </a>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group" style="margin-top: 30px;">
                          <textarea style="resize: none;" required="true" name="message" class="form-control" rows="5" cols="120" value="" placeholder="Enter custom sms here..."></textarea>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label for="">Use Previous sms</label>
                        <select class="form-control" style="width: 100%;">
                          <option value="">NONE</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn btn-danger" name="button" style="border-radius: inherit;top: 12px;position: relative;">Send SMS to owners</button>
                      </div>
                    </form>
                </div>

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
          properties: [],
          name: '',
          checkedNames: ''
      },
      methods: {
          getname (id) {
              var results = '';
            axios.get(`/api/v1/console/get_property_owner/${1}`)
                .then(response => {
                    console.log(response.data.data);
                    results = response.data.data.firstname + ' ' + response.data.data.lastname;
                    this.name = results
                }).catch(error => console.error(error));
                console.log(this.name);
                return this.name;
          }
      },
      created() {

        // axios.get('/api/v1/console/get_properties_d/')
        //     .then(response => this.properties = response.data.data)
        //     .catch(error => console.error(error));
      }


    });
</script>

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
