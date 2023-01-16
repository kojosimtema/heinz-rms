@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                
                <div class="row" v-if="showPage == true">
                    <div class="col-md-12">
                        <div class="loading-box"></div>
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('property.records.bills')}}" id="addTable" method="get" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Bill Year</label>
                                        <select class="form-control" required="required" name="year" id="">
                                            <option value="">-select year-</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Bill Status</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" style="margin-top: 25px;" class="btn btn-primary form-control">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal heiz-dashboard-forms" role="form">

                            <div class="row occupants-container">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Acc/No</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Owner</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Capacity: activate to sort column ascending" style="width: 227px;">Property Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 186px;">Property Category</th>
                                        <th width="100px" class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 100px;">Town Area Council</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="data in properties">
                                        <tr role="row" :class="background_color" >
                                            <td class="sorting_1" tabindex="0">
                                                <a :href="data.id" @click.prevent="get_bill(data.id)">@{{data.id}}</a>
                                            </td>
                                            <td class="" v-if="data.owner">@{{data.owner.name}}</td>
                                            <td class="" v-if="data.type">@{{data.type.description}}</td>
                                            <td class="" v-if="data.category">@{{data.category.description}}</td>
                                            <td class="" v-if="data.tas">@{{data.tas.description}}</td>
                                        </tr>
                                    </template>

                                </tbody>
                            </table>
                            </div>

                            <h4 class="form-desc">Bill Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Property No</label>
                                        <input type="text" :value="bill.property_id" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rate Per Annum (GHc)</label>
                                        <input type="text" :value="bill.rate_pa" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rateable Value (GHc)</label>
                                        <input type="text" :value="bill.rateable_value" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rate Imposed</label>
                                        <input type="text" :value="bill.rate_imposed" disabled class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Current Amount</label>
                                        <input type="text" :value="bill.current_amount" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Arrears</label>
                                        <input type="text" :value="bill.arrears" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Total Payment</label>
                                        <input type="text" :value="bill.total_payment" disabled class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row amount-due" v-if="sh_bill">
                                <h4>Amount Due: <span>GHc @{{bill.current_amount}}</span></h4>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <a href="#" :disabled="!sh_bill" style="width: 90%;" class="btn btn-default form-control">Prepare Bill</a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <a :href="preview_href" :disabled="!sh_bill" style="width: 90%;" class="btn btn-default form-control">Print Bill</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <h4 v-else>Data Loading...</h4>
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
        property: [],
        bill: [],
        sh_bill: false,
        property_id: '',
        showPage: false,
        showColor: false,
        background_color: '',
        preview_href: ''
      },
      methods: {
          get_bill(query){
            //   console.log(query);
            axios.get(`/api/v1/console/get_property_bills/${query}`)
                 .then(response => {console.log(response.data), this.property = response.data.data, this.bill = response.data.bill, this.sh_bill = true, this.setRoute(), this.highlightColor(response.data.bill.id)})
                 .catch(error => console.error(error));
          },
          highlightColor(id = null){
              if (id) this.background_color = 'red';
              this.showColor = true;
          },
          setRoute(){
              this.preview_href = window.location.href + `/preview/${this.bill.id}`;
          }
      },
      created(){
        axios.get(`/api/v1/console/get_properties`)
            .then(response => {console.log(response.data), this.properties = response.data.data, this.showPage = true})
            .catch(error => console.error(error));
      }
        

    });
</script>
@endsection