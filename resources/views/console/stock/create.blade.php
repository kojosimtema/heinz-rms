@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('stock.store')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Stock Type</label>
                                        <select class="form-control" name="stock_type" id="">
                                            <option selected value="gcr">GCR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Voucher #</label>
                                        <input type="text" name="voucher" class="form-control" value="" placeholder="Voucher Number" parsley-trigger="change" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Start Serial #</label>
                                        <input type="number" name="min_serial" v-model="start_serial" placeholder="Start serial number" @blur="calcEndSerial();" class="form-control{{ $errors->has('min_serial') ? ' is-invalid' : '' }}" required>
                                        @if ($errors->has('min_serial'))
                                            <small class="invalid-feedback">
                                                <strong style="color: red;">{{ $errors->first('min_serial') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">End Serial #</label>
                                        <input type="number" name="max_serial" v-model="end_serial" placeholder="End serial number" disabled class="form-control" required>
                                        <input type="hidden" name="max_serial" v-model="end_serial" placeholder="End serial number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Quantity</label>
                                        <input type="number" name="quantity" disabled value="100" id="" class="form-control" required>
                                        <input type="hidden" name="quantity" value="100" id="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="date" v-model="date" name="date" id="" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="text-align:center;">
                                <button type="submit" style="width:50%; margin:auto;" class="form-control btn btn-primary">save stock</button>
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
          end_serial: '',
          date: new Date().toJSON().slice(0,10),
          start_serial: ''
      },
      methods: {
        calcEndSerial(){
            this.end_serial = parseInt(this.start_serial) + 99
        },
      }


    });
</script>
@endsection
