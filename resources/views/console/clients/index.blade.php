@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('clients.store')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Client Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Server URL</label>
                                        <input type="text" name="cloud_server" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <button type="submit" class="form-control btn btn-primary">Add Entry</button>
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
<script>

    var app = new Vue({
      el: '#heinz',
      data: {

      },
      methods: {

      },
      created() {

      }


    });
</script>
@endsection
