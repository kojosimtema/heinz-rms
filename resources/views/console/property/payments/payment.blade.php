@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">



        <div class="col-sm-12">
            <div class="card-box">
              <div class="row">
                  <div class="col-sm-6">
                    <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Property Payment</h3>
                  </div>
                  <div class="col-sm-6"></div>
              </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="{{route('property.payments.payment')}}" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Account No</label>
                                        <input type="text" class="form-control" name="account_no" v-model="account_no" @keyup="filteredList()" id="account_no" placeholder="Your account no">
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="box-shadow: 1px 1px 8px #ccc; width: 97%; padding: 15px;" v-if="showFilter">
                              <div class="data-table card filter-table" v-if="showFilter">
                                <table>
                                  <tbody>
                                    <template v-for="data in filterList" v-if="account_no.length > 4">
                                      <tr>
                                        <td class="label-cell">
                                          <a href="#" @click.prevent="updateSearchField(data.property_no)"><span style="color:red;" v-text="data.property_no"></span>&nbsp; - @{{data.owner.name}}</a>
                                        </td>
                                      </tr>
                                    </template>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <h4 class="form-desc">Account Details</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Account No</label>
                                        <input type="text" id="acc_no" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Account Owner</label>
                                        <input type="text" id="acc_owner" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Zonal</label>
                                        <input type="text" id="acc_zonal" disabled class="form-control">
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Bill Details</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Arrears</label>
                                        <input type="text" id="payment_arrears" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Current Amount</label>
                                        <input type="text" v-if="bill.account_balance == 0.0" :value="f_message" disabled class="form-control">
                                        <input type="text" id="payment_current_amount" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Last bill year</label>
                                        <input type="text" id="payment_year" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Net Balance</label>
                                        <input type="text" disabled class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row amount-due">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label style="margin-top: 10px;" for="">Collector</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="collector_id" v-model="collector_id" id="" @blur="getCStocks(collector_id);" class="form-control" required>
                                                    <option value="">-choose-</option>
                                                    <template v-for="data in collectors">
                                                        <option :value="data.id">@{{data.name}}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label style="margin-top: 10px;" for="">Cashier</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="cashier_id" id="" class="form-control">
                                                    <option value="">-choose cashier-</option>
                                                    <template v-for="data in cashiers">
                                                        <option :value="data.id">@{{data.name}}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-desc">Payment Details</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Amount Paid</label>
                                        <input type="text" name="amount_paid" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">GCR No</label>
                                        <select name="gcr_number" id="" class="form-control" required>
                                            <template v-for="data in gcrs">
                                                <option :value="data.gcr_number">@{{data.gcr_number}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Payment Mode</label>
                                        <select name="payment_mode" id="" class="form-control" required>
                                            <option value="">-select-</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Date Paid</label>
                                        <input type="date" v-model="date" name="payment_date" id="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Collectors Payment Receipt No</label>
                                        <input type="text" name="cprn" id="" class="form-control" required>
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
        f_message: 'Full Payment',
        pno: '',
        properties: [],
        bill: [],
        owner: [],
        collectors: [],
        collector_id: '',
        cashiers: [],
        date: new Date().toJSON().slice(0,10),
        gcrs: [],
        filterList: '',
        account_no: '',
        showFilter: false
      },
      methods: {
          getPBills(query){
            axios.get(`/api/v1/console/get_account_bills/${query}`)
                 .then(response => {this.popDataSet(response)})
                 .catch(error => console.error(error));
          },
          getCStocks(query){
            axios.get(`/api/v1/console/get_collectors_stock/${query}`)
                 .then(response => {console.log(response.data), this.gcrs = response.data.data})
                 .catch(error => console.error(error));
          },
          filteredList () {
            if(this.account_no.length > 4){
              this.showFilter = true
              axios.get(`/api/v1/console/filter_bill_by_ac/${this.account_no.toUpperCase()}/p`)
              .then(response => {this.filterList = response.data.data})
              .catch(error => {console.error(error)});
            }

          },
          updateSearchField (req) {
            this.account_no = req
            this.showFilter = false
            this.getPBills(req)
          },
          popDataSet(response) {
            // console.log(response.data.data)
            document.getElementById('payment_arrears').value = response.data.data.arrears
            document.getElementById('payment_current_amount').value = response.data.data.account_balance
            document.getElementById('payment_year').value = response.data.data.year
            document.getElementById('acc_no').value = response.data.data.account_no
            document.getElementById('acc_owner').value = response.data.owner.name
            document.getElementById('acc_zonal').value = response.data.zonal.description
            // this.bill = response.data.bill
            // this.owner = response.data.owner
          }
      },
      created(){

        axios.get('/api/v1/console/get_collectors')
            .then(response => this.collectors = response.data.data)
            .catch(error => console.error(error));
        axios.get('/api/v1/console/get_cashiers')
            .then(response => this.cashiers = response.data.data)
            .catch(error => console.error(error));
      }


    });
</script>
@endsection
