@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Business Enquiry</h3>
                    </div>
                    <div class="col-sm-6">
                      <form class="" action="{{route('business.filter.column')}}" method="get">
                        @csrf
                        <div id="datatable-responsive_filter" class="dataTables_filter">
                            <div class="row">
                              <div class="col-md-1">
                                <h6>Search By: </h6>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <select class="form-control" name="column">
                                    <option value="business_no">Business Number</option>
                                    <option value="business_type">Business Type</option>
                                    <option value="business_name">Business Name</option>
                                    <option value="business_category">Business Category</option>
                                    <option value="business_owner">Business Owner</option>
                                    <option value="zonal_id">Zonal</option>
                                    <option value="electoral_id">Electoral</option>
                                    <option value="store_number">Store Number</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <input type="text" name="query" class="form-control" value="" placeholder="enter your search parameters here">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <button type="submit" class="form-control">Search</button>
                              </div>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-bordered dt-responsive fixed">
                            <thead style="font-size: 12px;">
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Business No</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Business Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">B. Type</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">B. Category</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Store No</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">B. Owner</th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending">Zonal</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 11px;">
                                @foreach($businesses as $business)
                                <tr role="row" class="odd">
                                    <td class="sorting_1" tabindex="0"><a href="{{route('business.show', $business->business_no)}}">{{$business->business_no}}</a></td>
                                    <td class="sorting_1" tabindex="0"><a href="{{route('business.show', $business->business_no)}}">{{$business->business_name}}</a></td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="{{route('business.show', $business->business_no)}}">
                                        @if($business->type)
                                        {{$business->type->description}}
                                        @else
                                        {{$business->business_type}}
                                        @endif
                                      </a>
                                    </td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="{{route('business.show', $business->business_no)}}">
                                        @if($business->category)
                                        {{$business->category->description}}
                                        @else
                                        {{$business->business_category}}
                                        @endif
                                      </a>
                                    </td>
                                    <td class="sorting_1" tabindex="0"><a href="">{{$business->store_number}}</a></td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="{{route('business.show', $business->business_no)}}">
                                        @if($business->owner)
                                        {{$business->owner->name}}
                                        @else
                                        {{$business->business_owner}}
                                        @endif
                                      </a>
                                    </td>
                                    <td class="sorting_1" tabindex="0">
                                      <a href="{{route('business.show', $business->business_no)}}">
                                        @if($business->zonal)
                                        {{$business->zonal->description}}
                                        @else
                                        {{$business->zonal_id}}
                                        @endif
                                      </a>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                      {{$businesses->links()}}
                  </div>
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
          name: ''
      },
      methods: {
          getname (id) {
              var results = '';
            axios.get(`/api/v1/console/get_business_owner/${id}`)
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

        axios.get('/api/v1/console/get_properties_d/')
            .then(response => this.properties = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
