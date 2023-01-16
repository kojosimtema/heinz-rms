@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="col-sm-12">
            <div class="card-box" style="min-height: 780px;">
                
                <div class="row preview-bills-container" id="printDiv">
                    <div class="row top-bill-page">
                        <div class="col-xs-3">
                            <img src="/images/assemblies/ghanacoatofarms.jpg" alt="">
                        </div>
                        <div class="col-xs-6 m-border"> <h3>{{$setting->assembly_name}}</h3> </div>
                        <div class="col-xs-3">
                            <img src="/images/assemblies/ghanacoatofarms.jpg" alt="">
                        </div>
                    </div>
                    <div class="row bill-type">
                        <h4>Property Rate</h4>
                    </div>
                    <div class="row bill-details">
                        <div class="col-xs-5">
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Account No.:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['account_no']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Full Name:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['name']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Address:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['address']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Property Type:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['property_type']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Property Cat:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['property_category']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row border-bill">
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Rateable Value:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['rateable_value']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Rate Imposed:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>{{$print_data['rate_imposed']}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-6">
                                    <p>Stamp:</p>
                                </div>
                                <div class="col-xs-6 bill-sign">
                                    <p><span>........................................................................</span></p>
                                    <p><span class="bill-sign-cap">Municipal Cordinating Director</span></p>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="col-xs-7">
                            <div class="row ac-bill">
                                <div class="col-xs-4">
                                    <p>Bill Year:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['bill_year']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-4">
                                    <p>Sub Metro:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['sub_metro']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-4">
                                    <p>Electorial Area:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['electoral']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-4">
                                    <p>Town Area Coun:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['tas']}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row ac-bill">
                                <div class="col-xs-4">
                                    <p>Street:</p>
                                </div>
                                <div class="col-xs-6">
                                    <p>
                                        <span>{{$print_data['street']}}</span>
                                    </p>
                                </div>
                            </div>
                            <p class="bill-b">All bills must be settled on or before <span>03-Jul-2013</span></p>
                            <p class="bill-b">For enquires contact the Metro cordinating Director on the ff Nos. <br> <span>02045555</span></p>
                            <div class="row border-bill2">
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Previous Year Bill:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['previous_year']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Amount Paid (Last Yr):</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['amount_paid']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Arrears:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['arrears']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Current Fee:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['current_fees']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row ac-bill">
                                    <div class="col-xs-6">
                                        <p>Total Amount Due:</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span>GHc {{$print_data['total_amount']}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn" @click="printPage()">Print</button>
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
        property: [],
        bill: [],
        sh_bill: false,
        property_id: '',
        showPage: false,
        showColor: false,
        background_color: ''
      },
      methods: {
          get_bill(query){
            //   console.log(query);
            axios.get(`/api/v1/console/get_property_bills/${query}`)
                 .then(response => {console.log(response.data), this.property = response.data.data, this.bill = response.data.bill, this.sh_bill = true, this.highlightColor(response.data.bill.id)})
                 .catch(error => console.error(error));
          },
          highlightColor(id = null){
              if (id) this.background_color = 'red';
              this.showColor = true;
          },
          printPage(){
              let printContents = document.getElementById('printDiv').innerHTML;
              let originalContents = document.body.innerHTML;
              document.body.innerHTML = printContents;
              window.print();
              document.body.innerHTML = originalContents;
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