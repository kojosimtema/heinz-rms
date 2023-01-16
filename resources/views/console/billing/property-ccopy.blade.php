@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
              <div class="row">
                <div class="col-sm-6">
                    <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Generate Bills Module</h3>
                </div>
              </div>
                <div class="row">
                    <div class="col-sm-8">
                        <form class="" action="{{route('account.bills')}}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">use fee fixing</label>
                                <select style="width: 100%;" class="form-control" name="feefixing">
                                  <?php
                                  for ($i=date('Y'); $i>2017; $i--) {?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                  <?php }?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">for year</label>
                                <select style="width: 100%;" class="form-control" name="year">
                                  <?php
                                  for ($i=date('Y'); $i>2017; $i--) {?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                  <?php }?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">for account</label>
                                <select style="width: 100%;" class="form-control" name="account">
                                  <option value="property">property</option>
                                  <option value="business">business</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <button type="submit" style="margin-top: 25px;" class="btn btn-danger">Generate account bills</button>
                              </div>
                            </div>
                          </div>
                        </form>
                    </div>

                    <div class="col-sm-6">

                    </div>

                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                      <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Bills LIST</h3>
                  </div>
                  <div class="col-sm-6">
                    <form class="" action="{{route('bills.filter.column')}}" method="get">
                      @csrf
                      <div id="datatable-responsive_filter" class="dataTables_filter">
                          <div class="row">
                            <div class="col-md-1">
                              <h6>Search By: </h6>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <select class="form-control" name="column">
                                  <option value="account_no">Account Number</option>
                                  <!-- <option value="owner_name">Account Owner</option> -->
                                  <!-- <option value="phone_number">Phone Number</option> -->
                                  <!-- <option value="account_type">Account Type</option> -->
                                  <!-- <option value="account_category">Account Category</option> -->
                                  <option value="year">Bill Year</option>

                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <input type="text" name="query" class="form-control" value="" placeholder="enter your search parameters here">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <button type="submit" class="form-control">Search</button>
                            </div>
                          </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="row">
                    <form class="" action="{{route('setups.property.bills.sms')}}" method="post">
                      @csrf
                      <div class="col-sm-12" style="height: 296px; overflow: auto;">
                          <table class="table table-striped table-bordered dt-responsive">
                              <thead style="font-size: 12px;">
                                  <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 91px;">Account no</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Type</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Category</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Owner</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Amount</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Arrears</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Bill year</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable-responsive" rowspan="1" colspan="1" aria-label="Table No: activate to sort column ascending" style="width: 229px;">Action</th>
                                  </tr>
                              </thead>
                              <tbody style="font-size: 12px;">
                                @foreach($bills as $bill)
                                <tr role="row" class="odd">

                                  <td class="sorting_1" tabindex="0"><a href="#">{{$bill->account_no}}</a></td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?php
                                        if($bill->property):
                                          echo $bill->property->type ? $bill->property->type->description : strtoupper("no relation");
                                        elseif($bill->business):
                                            echo $bill->business->type ? $bill->business->type->description : strtoupper("no relation");
                                        endif;

                                      ?>
                                    </a>
                                  </td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?php
                                        if($bill->property):
                                          echo $bill->property->category ? $bill->property->category->description : strtoupper("no relation");
                                        elseif($bill->business):
                                            echo $bill->business->category ? $bill->business->category->description : strtoupper("no relation");
                                        endif;

                                      ?>
                                    </a>
                                  </td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?php
                                        if($bill->property):
                                          echo $bill->property->owner ? $bill->property->owner->name : strtoupper("no relation");
                                        elseif($bill->business):
                                            echo $bill->business->owner ? $bill->business->owner->name : strtoupper("no relation");
                                        endif;

                                      ?>
                                    </a>
                                  </td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?= \App\Repositories\ExpoFunction::formatMoney($bill->current_amount, true); ?>
                                    </a>
                                  </td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?= \App\Repositories\ExpoFunction::formatMoney($bill->arrears, true); ?>
                                    </a>
                                  </td>
                                  <td class="sorting_1" tabindex="0">
                                    <a href="#">
                                      <?= $bill->year; ?>
                                    </a>
                                  </td>

                                  <td class="sorting_1" tabindex="0"><a href="{{route('init.bill.print', $bill->account_no)}}" class="btn btn-danger btn-xs">print</a></td>
                                </tr>
                                @endforeach

                              </tbody>


                          </table>

                      </div>

                      <div class="row">
                        {{$bills->links()}}
                      </div>



                    </form>
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
          properties: [],
          name: '',
          checkedNames: ''
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

        // axios.get('/api/v1/console/get_properties_d/')
        //     .then(response => this.properties = response.data.data)
        //     .catch(error => console.error(error));
      }


    });
</script>

<script type="text/javascript">
  function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
  }
</script>
@endsection
