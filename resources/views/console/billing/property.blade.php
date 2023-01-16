@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive">
            <div id="datatable-responsive_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
              <div class="row">
                <div class="col-sm-6">
                    <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Generate Bulk Bills Module</h3>
                </div>
              </div>
                <div class="row">
                    <div class="col-sm-8">
                        <form  autocomplete="false"class="" action="{{route('account.bills')}}" method="post">
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
                      <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Generate Single Bills Module</h3>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form autocomplete="false" class="" action="{{route('account.bills.single')}}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="">for account</label>
                                <select style="width: 100%;" class="form-control" v-model="aacnt" name="account">
                                  <option value="property">property</option>
                                  <option value="business">business</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">Account No</label>
                                  <input type="text" class="form-control" required name="account_no" v-model="account_no" @keyup="filteredList()" id="account_no" placeholder="Your account no">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <button type="submit" style="margin-top: 25px;" class="btn btn-primary">Generate account bills</button>
                              </div>
                            </div>
                            <div class="col-md-12" style="box-shadow: 1px 1px 8px #ccc; width: 97%; padding: 15px; width:50%;" v-if="showFilter">
                              <div class="data-table card filter-table" v-if="showFilter">
                                <table>
                                  <tbody>
                                    <template v-for="data in filterList" v-if="account_no.length > 3 && aacnt == 'property'">
                                       <tr>
                                            <td class="label-cell">
                                              <a href="#" @click.prevent="updateSearchField(data.property_no)"><span style="color:red;" v-text="data.property_no"></span>&nbsp; - @{{data.owner.name}}</a>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-for="data in filterList" v-if="account_no.length > 3 && aacnt == 'business'">
                                       <tr>
                                            <td class="label-cell">
                                              <a href="#" @click.prevent="updateSearchField(data.business_no)"><span style="color:red;" v-text="data.business_no"></span>&nbsp; - @{{data.owner.name}}</a>
                                            </td>
                                        </tr>
                                    </template>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-sm-6">
                      <h3 style="color: brown; font-size: 20px; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Generate Category Range Bills Module</h3>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form autocomplete="false" class="" action="{{route('account.bills.category')}}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                                <label for="">Category</label>
                                <?php $categories = App\PropertyCategory::orderBy('description', 'asc')->get(); ?>
                                <select required class="form-control" name="category" style="font-size:12px;width:100%;">
                                  <option value="">SELECT</option>
                                  <?php foreach ($categories as $key => $category): ?>
                                    <option value="<?php echo $category->code; ?>"><?php echo $category->description; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <button type="submit" style="margin-top: 25px;" class="btn btn-warning">Generate account bills</button>
                              </div>
                            </div>
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
        aacnt: '',
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
              var panel = '';
              switch (this.aacnt) {
                case 'business':
                  panel = 'b'
                  break;
                case 'property':
                  panel = 'p'
                  break;
              
                default:
                return false
                  break;
              }
              this.showFilter = true
              axios.get(`/api/v1/console/filter_bill_by_ac/${this.account_no.toUpperCase()}/${panel}`)
              .then(response => {this.filterList = response.data.data})
              .catch(error => {console.error(error)});
            }

          },
          updateSearchField (req) {
            this.account_no = req
            this.showFilter = false
          },
          popDataSet(response) {

          }
      },
      created(){

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
