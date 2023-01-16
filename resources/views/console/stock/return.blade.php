@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('stock.return')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name of collector</label>
                                        <select class="form-control" v-model="from_id"  @blur=""  name="collector_id" id="">
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row fixed-issue-container">
                                <div class="col-md-4" v-for="stock in stocks">
                                    <div class="form-group">
                                        <label :for="stock.id">[GCR] start serial[ <span>@{{stock.min_serial}}</span> ] & End serial[ <span>@{{stock.max_serial}}</span> ]</label>
                                        <input type="checkbox" :value="stock.id" :id="stock.id" name="stock_id[]">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Number Used</label>
                                        <input type="number" name="quantity" id="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Number Cancelled</label>
                                        <input type="number" name="quantity" id="" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="form-control btn btn-primary">save Entry</button>
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