@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box" style="min-height: 780px;">
                
                <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('settings.store')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf

                    <h4 class="form-desc">Assembly Information</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Assembly Name</label>
                                <input type="text" name="assembly_name" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Assembly Image</label>
                                <input type="file" name="assembly_image" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Assembly Signature</label>
                                <input type="file" name="assembly_signature" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Assembly Contact</label>
                            <input type="text" name="assembly_contact" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <label for="">Receipt Message</label>
                            <textarea name="assembly_message_btn
                            " id="" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <button class="btn btn-info" type="submit">Submit Records</button>
                    </div>
                </form>
                
            </div>
        </div>

    </div>
</div>
@endsection