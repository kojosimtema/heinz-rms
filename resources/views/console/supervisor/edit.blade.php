@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box" style="width: 50%; margin:auto;">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('supervisors.update', $supervisor->supervisor_id)}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{$supervisor->name}}" placeholder="Supervisor Name" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{$supervisor->email}}" placeholder="Email Address" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="form-group">
                                  <label for="">Password</label>
                                  <input type="text" name="password" class="form-control" value="" placeholder="Update Password">
                              </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="form-control btn btn-danger">update Entry</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
