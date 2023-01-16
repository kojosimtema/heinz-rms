@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="datatable-responsive_length">
                          <label>Total Amount: GHc&nbsp;<span style="font-size: 20px; color: #a72a2a;"><?= \App\Repositories\ExpoFunction::formatMoney($sumTotal, true); ?></span></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <form class="" action="{{route('cashier.filter.payment')}}" method="get">
                        @csrf
                        <div id="datatable-responsive_filter" class="dataTables_filter">
                            <label>Search: <input type="radio" checked name="sortby" value="name"> name&nbsp;
                            <input type="radio" name="sortby" value="gcr"> gcr &nbsp;<input type="search" class="form-control input-sm" placeholder="" name="filter" aria-controls="datatable-responsive"></label>

                            <button type="submit">Search</button>
                        </div>
                      </form>

                    </div>
                </div>
                <div class="row">
                    <form class="" action="{{route('cashier.checkout.payment')}}" method="post">
                      @csrf
                      <div class="row">
                        <div class="col-sm-12" style="height: 296px; overflow: auto;">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 10px;"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Amount Paid</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">GCR Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Payment Mode</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Collector Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($payments as $payment)
                                  <tr role="row" class="odd">
                                      <td class="sorting_1" tabindex="0">
                                        <input type="checkbox" class="selectedPayment" name="payments[]" value="{{$payment->amount_paid}}">
                                        <input type="checkbox" class="" name="gcrs[]" value="{{$payment->gcr_number}}">
                                      </td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{$payment->account_no}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{$payment->amount_paid}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{$payment->gcr_number}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{$payment->payment_mode}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{$payment->collector_name ?: 'NA'}}</a></td>
                                      <td class="sorting_1" tabindex="0"><a href="#">{{ \Carbon\Carbon::parse($payment->payment_date)->toFormattedDateString() }}</a></td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                          {{$payments->links()}}
                        </div>
                      </div>
                      <div class="row" style="padding-top: 9px; padding-bottom: 7px; box-shadow: inset 0px 0px 3px #ccc;">
                        <div class="col-md-4">
                          <label for="">Cashier</label>
                          <select name="cashier" id="cash_name" @blur="getCashierGCR()" class="form-control" style="width: 95%;">
                            <option value="">select cashier</option>
                            <?php
                            $cashiers = \App\Cashier::latest()->get();
                            foreach ($cashiers as $cashier) { ?>
                              <option value="<?= $cashier->cashier_id; ?>"><?= $cashier->name; ?></option>
                            <?php }; ?>

                          </select>
                        </div>
                        <div class="col-md-2">
                          <label for="">GCR</label>
                          <select required name="gcr_number" class="form-control" style="width: 95%;">
                            <template v-for="data in cashier_gcr">
                              <option :value="data.gcr_number">@{{data.gcr_number}}</option>
                            </template>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label style="margin-top: 22px;">Selected Amount: GHc&nbsp;<span style="font-size: 20px; color: #a72a2a;" id="ffM"><?= \App\Repositories\ExpoFunction::formatMoney($sumTotal, true); ?></span></label>
                        </div>
                        <div class="col-md-3">
                          <button style="width: 85%; margin-top: 17px;" type="submit" class="btn btn-primary" name="button">save</button>
                        </div>
                      </div>

                    </form>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(".selectedPayment").click(function(){
            var favorite = [];
            $.each($("input[class='selectedPayment']:checked"), function(){
                favorite.push(parseInt($(this).val()));
            });
            var format = new Intl.NumberFormat()
            var sum = format.format(favorite.reduce(function(a, b) { return a + b; }, 0))
            document.getElementById("ffM").innerHTML = sum
            console.log(favorite);
            // alert("My favourite sports are: " + favorite.join(", "));
        });
    });
</script>
<script>
    var app = new Vue({
      el: '#heinz',
      data: {
          properties: [],
          name: '',
          cashier_gcr: []
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
          },
          getCashierGCR() {
            var query = document.getElementById("cash_name").value
            axios.get(`/api/v1/console/get/cashier/gcr/${query}`)
                 .then(response => this.cashier_gcr = response.data.data)
                 .catch(error => console.error(error));
          }
      },
      created() {

        // axios.get('/api/v1/console/get_properties_d/')
        //     .then(response => this.properties = response.data.data)
        //     .catch(error => console.error(error));
      }


    });
</script>
@endsection
