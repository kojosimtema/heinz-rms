@extends('layouts.reports')

@section('styles')
<!-- DataTables -->
<link href="/backend/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="/backend/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row main-container2">

  <div class="row advanced-search">
    <form class="form-horizontal" action="" method="post">
      @csrf
      <select class="" name="properties">
        <option value="">All Properties</option>
      </select>
      with property type
      <select class="" name="property_type" v-model="typ" @blur="getCategories(typ)">
        <option selected value="">All</option>
        <template v-for="data in properties_types">
          <option :value="data.code">[@{{data.code}}] @{{data.description}}</option>
        </template>
      </select>
      and under Category
      <select class="" name="property_category">
        <option selected value="">All</option>
        <template v-for="data in properties_categories">
          <option :value="data.code">[@{{data.code}}] @{{data.description}}</option>
        </template>
      </select>
      <br>
      belonging to owner
      <select class="" name="property_owner">
        <option selected value="">All</option>
        <template v-for="data in properties_owners">
          <option :value="data.id">@{{data.firstname}} @{{data.lastname}}</option>
        </template>
      </select>
      starting
      <input type="date" name="starting" value="">
      and ending
      <input type="date" name="ending" value="">
      collected by
      <select class="" name="collector">
        <option selected value="">All</option>
        <template v-for="data in collectors">
          <option :value="data.email">@{{data.name}}</option>
        </template>
      </select>
      <button type="submit">filter search</button>
    </form>
  </div>

  <div id="datatable-buttons_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
    <div class="row">
        <div class="col-sm-12">
            <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-buttons_info" style="width: 100%;">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 179px;">Property No</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 294px;">Property Type</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 132px;">Property Category</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 63px;">Property Owner</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 125px;">Collector</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach ($properties as $property)
                    <tr role="row" class="odd">
                        <td class="sorting_1">{{$property->property_no}}</td>
                        @if(isset($property->type->description))
                          <td>{{$property->type->description}}</td>
                        @else
                          <td>unavailable</td>
                        @endif

                        @if(isset($property->category->description))
                          <td>{{$property->category->description}}</td>
                        @else
                          <td>unavailable</td>
                        @endif

                        @if(isset($property->owner->firstname))
                          <td>{{$property->owner->firstname}} {{$property->owner->lastname}}</td>
                        @else
                          <td>none</td>
                        @endif
                        <td>{{$property->client}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>

  </div>
</div>



@endsection

@section('script_tags')
<script src="/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/backend/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="/backend/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="/backend/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="/backend/plugins/datatables/jszip.min.js"></script>
<script src="/backend/plugins/datatables/pdfmake.min.js"></script>
<script src="/backend/plugins/datatables/vfs_fonts.js"></script>
<script src="/backend/plugins/datatables/buttons.html5.min.js"></script>
<script src="/backend/plugins/datatables/buttons.print.min.js"></script>
<script src="/backend/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="/backend/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/backend/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="/backend/pages/datatables.init.js"></script>
@endsection
@section('scripts')
<!-- Required datatable js -->

<script>
  var app = new Vue({
      el: '#marvalinks',
      data: {
        properties_types: '',
        typ: '',
        properties_categories: '',
        properties_owners: '',
        collectors: ''
      },
      methods: {
        getCategories(id) {
          if(id != 'all') {
            axios.get(`/api/v1/console/get_categories_property/${id}`)
                .then(response => this.properties_categories = response.data.props)
                .catch(error => console.error(error));
          }


        }

      },
      created(){
        axios.get('/api/v1/console/get_property_types/')
            .then(response => this.properties_types = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_property_owners/')
          .then(response => this.properties_owners = response.data.data)
          .catch(error => console.error(error));
        axios.get('/api/v1/console/get_collectors/')
          .then(response => this.collectors = response.data.data)
          .catch(error => console.error(error));
      }




  });
</script>
@endsection
