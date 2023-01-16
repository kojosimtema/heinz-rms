@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="row heinz-dashboard-nav-cards">
          <div class="col-md-6 col-lg-4">
              <div class="widget-bg-color-icon card-box fadeInDown animated">
                  <div class="text-center">
                      <a href="{{route('business.index')}}">
                      <h3 class="text-white">Business</h3>
                      <button class="text-white">
                        <span style="font-size:20px;">Total</span><br>
                        <?php $business = \App\Business::latest()->get(); echo $business->count(); ?>
                      </button>
                      <div class="row c-stats">
                        <h5>Collector cash:
                          <span><?php
                            $count = 0.0;
                            $dataTypeAl = "b";
                            $datasAl = \App\Payment::where('data_type', 'LIKE', "%{$dataTypeAl}%")->where('payment_year', date('Y'));

                            echo "GHc". number_format($datasAl->where('is_verfied', 1)->sum('amount_paid'), 2);
                           ?></span>
                        </h5>

                        <h5 class="t-align-right">Cashier cash:
                          <span><?php
                            echo "GHc". number_format($datasAl->where('is_verfied', 0)->sum('amount_paid'), 2);
                            ?></span>
                        </h5>

                        <h5>Total revenue:
                          <span><?php
                            // $count = 0.0;
                            // $dataType = "b";
                            // $datas = \App\Payment::where('data_type', 'LIKE', "%{$dataType}%")->where('payment_year', date('Y'))->get();
                            // foreach ($datas as $data) {
                            //   $count += $data->amount_paid;
                            // }
                            // echo "GHc". \App\Repositories\ExpoFunction::formatMoney($count, true);
                            echo "GHc". number_format($datasAl->sum('amount_paid'), 2);
                           ?></span>
                        </h5>

                        <h5 class="t-align-right">Today stats:
                          <span><?php
                            $count = 0;
                            $datas = \App\Business::latest()->get();
                            foreach ($datas as $data) {
                              if ($data->created_at == "" || $data->created_at == NULL || $data->created_at == "NULL") continue;
                              if($data->created_at->toDateString() == \Carbon\Carbon::now()->toDateString()):
                                $count++;
                              endif;
                            }
                            echo $count;
                           ?></span>
                        </h5>

                        <h5>Today's revenue:
                          <span><?php
                            $count = 0.0;
                            $dataType = "b";
                            $datas = \App\Payment::where('data_type', 'LIKE', "%{$dataType}%")->where('payment_year', date('Y'))->get();
                            foreach ($datas as $data) {
                              if ($data->created_at == "" || $data->created_at == NULL || $data->created_at == "NULL") continue;
                              if($data->created_at->toDateString() == \Carbon\Carbon::now()->toDateString()):

                              endif;
                            }
                            echo "GHc".$count;
                           ?></span>
                        </h5>

                        <h5 class="t-align-right">Estimated revenue:
                          <span><?php
                            $dataType = "b";
                            $count = \App\Bill::where('bill_type', 'LIKE', "%{$dataType}%")->where('year', date('Y'))->sum('current_amount');

                            echo "GHc". \App\Repositories\ExpoFunction::formatMoney($count, true);
                           ?></span>
                        </h5>
                      </div>
                      </a>
                  </div>
                  <div class="clearfix"></div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <div class="text-center">
                        <a href="{{route('property.index')}}">
                        <h3 class="text-white">Property Rates</h3>
                        <button class="text-white">
                          <span style="font-size:20px;">Total</span><br>
                          <?php $property = \App\Property::latest()->get(); echo $property->count(); ?>
                        </button>
                        <div class="row c-stats">
                        <h5>Collector cash:
                          <span><?php
                            $count = 0.0;
                            $dataTypeAl = "p";
                            $datasAl = \App\Payment::where('data_type', 'LIKE', "%{$dataTypeAl}%")->where('payment_year', date('Y'));

                            echo "GHc". number_format($datasAl->where('is_verfied', 1)->sum('amount_paid'), 2);
                           ?></span>
                        </h5>

                        <h5 class="t-align-right">Cashier cash:
                          <span><?php
                            echo "GHc". number_format($datasAl->where('is_verfied', 0)->sum('amount_paid'), 2);
                            ?></span>
                        </h5>
                          <h5>Total revenue:
                            <span><?php
                                echo "GHc". number_format($datasAl->sum('amount_paid'), 2);
                             ?></span>
                          </h5>

                          <h5 class="t-align-right">Today stats:
                            <span><?php
                              $count = 0;
                              $datas = \App\Property::latest()->get();
                              foreach ($datas as $data) {
                                if ($data->created_at == "" || $data->created_at == NULL || $data->created_at == "NULL") continue;
                                if($data->created_at->toDateString() == \Carbon\Carbon::now()->toDateString()):
                                  $count++;
                                endif;
                              }
                              echo $count;
                             ?></span>
                          </h5>

                          <h5>Today's revenue:
                            <span><?php
                              $count = 0.0;
                              $dataType = "p";
                              $datas = \App\Payment::where('data_type', 'LIKE', "%{$dataType}%")->where('payment_year', date('Y'))->get();
                              foreach ($datas as $data) {
                                if ($data->created_at == "" || $data->created_at == NULL || $data->created_at == "NULL") continue;
                                if($data->created_at->toDateString() == \Carbon\Carbon::now()->toDateString()):

                                endif;
                              }
                              echo "GHc". \App\Repositories\ExpoFunction::formatMoney($count, true);
                             ?></span>
                          </h5>

                          <h5 class="t-align-right">Estimated revenue:
                            <span><?php
                              $dataType = "p";
                              $count = \App\Bill::where('bill_type', 'LIKE', "%{$dataType}%")->where('year', date('Y'))->sum('current_amount');

                              echo "GHc". \App\Repositories\ExpoFunction::formatMoney($count, true);
                             ?></span>
                          </h5>
                        </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <div class="text-center">
                        <a href="">
                        <h3 class="text-white">Building Permit</h3>
                        <button class="text-white">
                          <span style="font-size:20px;">Total</span><br>
                          NA
                        </button>
                        <div class="row c-stats">
                          <h5>Total revenue:
                            <span>NA</span>
                          </h5>

                          <h5 class="t-align-right">Today stats:
                            <span>NA</span>
                          </h5>

                          <h5>Today's revenue:
                            <span>NA</span>
                          </h5>
                        </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
