@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('stock.issue')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Issue From</label>
                                        <select class="form-control" v-model="issue_from" @blur="from_data(issue_from);" name="from_name" id="">
                                            <option selected value="stock">Stock</option>
                                            <option value="supervisor">Supervisor</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6" v-if="issue_from == 'supervisor'">
                                    <div class="form-group">
                                        <label for="">Name of <span v-text="issue_from"></span> </label>
                                        <select class="form-control" v-model="from_id"  @blur="from_stock(issue_from);" name="from_id" id="">
                                            <template v-for="data in froms">
                                              <option :value="data.id">@{{data.name}}</option>
                                            </template>
                                        </select>
                                        @if ($errors->has('from_name'))
                                            <small class="invalid-feedback">
                                                <strong style="color:red;">{{ $errors->first('from_name') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row fixed-issue-container">
                              @if (\Session::has('error'))
                                  <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{!! \Session::get('error') !!}</li>
                                        </ul>
                                    </div>
                                  </div>
                              @endif
                                <div class="col-md-1" v-for="stock in stocks" v-cloak>
                                    <div class="form-group">
                                        <label :for="stock.id" style="font-size:13px;"><span v-cloak>@{{stock.min_serial}}</span></label>
                                        <input type="checkbox" :value="stock.id" :id="stock.id" name="stock_id[]" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Issue To</label>
                                        <select class="form-control" v-model="issue_to" @blur="to_data(issue_to);" name="to_name" id="">
                                            <option value="supervisor" v-if="issue_from=='stock'">Supervisor</option>
                                            <option value="collector">Collector</option>
                                            <option value="cashier">Cashier</option>
                                        </select>
                                        @if ($errors->has('to_name'))
                                            <small class="invalid-feedback">
                                                <strong style="color:red;">{{ $errors->first('to_name') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="tos.length > 0">
                                    <div class="form-group">
                                        <label for="">Name of <span v-text="issue_to"></span> </label>
                                        <select class="form-control" v-model="to_id" name="to_id" id="">
                                          <template v-for="data in tos">
                                            <option :value="data.id">@{{data.name}}</option>
                                          </template>
                                        </select>
                                        @if ($errors->has('to_id'))
                                            <small class="invalid-feedback">
                                                <strong style="color:red;">{{ $errors->first('to_id') }}</strong>
                                            </small>
                                        @endif
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
                                <button type="submit" style="width:50%; margin:auto;" :disabled="stocks.length < 1" class="form-control btn btn-primary">Issue GCR</button>
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
        issue_from: '',
        issue_to: '',
        from_id: '',
        to_id: '',
        date: new Date().toJSON().slice(0,10),
        froms: [],
        tos: [],
        stocks: []
      },
      methods: {
        from_data(query){
            let link = `/api/v1/console/get_data_from/${query}`;
            axios.get(link)
                 .then(response => {this.froms = response.data.data, this.stocks = response.data.stock})
                 .catch(error => console.error(error));
        },
        from_stock(query){
            let id = this.from_id;
            let link = (query === 'supervisor') ? `/api/v1/console/get_stock_from/${query}/${id}` : `/api/v1/console/get_stock_from/${query}`;
            axios.get(link)
                .then(response => this.stocks = response.data.data)
                .catch(error => console.error(error));
        },
        to_data(query){
            let link = `/api/v1/console/get_data_to/${query}`;
            axios.get(link)
                 .then(response => this.tos = response.data.data)
                 .catch(error => console.error(error));
        }
      }


    });
</script>
@endsection
