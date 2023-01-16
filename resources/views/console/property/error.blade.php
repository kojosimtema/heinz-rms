@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">
        <div class="card-box table-responsive">
          <h4 style="color: red; text-align: center;">The following properties had mis-matched categories</h4>
          @if($array)
          <div class="row">
            @foreach($array as $d)
            <div class="col-md-1">
              <div class="card">
                <h6>{{$d}}</h6>
              </div>
            </div>
            @endforeach
          </div>
          @endif


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

        axios.get('/api/v1/console/get_properties_d/')
            .then(response => this.properties = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
