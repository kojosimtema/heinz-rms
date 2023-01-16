@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form action="#" class="form-horizontal heiz-dashboard-forms" @submit.prevent="find_gcr();" method="post">
                            @csrf
                            <div class="row gcr-search">
                                <div class="col-md-10">
                                    <label for="">GCR Number</label>
                                    <input type="search" v-model="query" name="query" class="form-control" id="">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary form-control">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal heiz-dashboard-forms" role="form" action="#" id="addTable" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Is Used</label>
                                        <input v-model="gcr.is_used" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Is Damaged</label>
                                        <input v-model="gcr.is_damaged" type="text" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Min GCR</label>
                                        <input v-model="gcr.min_serial" type="number" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Max GCR</label>
                                        <input v-model="gcr.max_serial" type="number" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">In Stock</label>
                                        <input v-model="gcr.in_stock" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Is Damaged</label>
                                        <input v-model="gcr.is_damaged" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Is Missing</label>
                                        <input v-model="gcr.is_missing" type="text" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Is Used</label>
                                        <input v-model="gcr.is_used" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Is Returned</label>
                                        <input v-model="gcr.is_returned" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Date Returned</label>
                                        <input type="date" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Supervisor/Collector</label>
                                        <input v-model="name" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Date Assigned</label>
                                        <input v-model="i_date" type="date" disabled>
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
          query: '',
          gcr: {},
          name: '',
          o_date: '',
          i_date: new Date(this.o_date)
      },
      methods: {
        find_gcr(){
            let query = this.query;
            axios.get(`/api/v1/console/find-gcr-enum/${query}`)
                 .then(response => {this.query = '', console.log(response.data)})
                 .catch(error => console.error(error));
        }
      }


    });
</script>
@endsection
