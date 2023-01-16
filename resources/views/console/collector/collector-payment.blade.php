@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="row collector-cards">
          @foreach($collectors as $collector)
            <div class="col-md-6 col-lg-4">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <div class="row text-left">
                      <div class="col-md-3">
                        <img src="/backend/images/users/boy.png" alt="user-img" class="img-circle"> </a>
                      </div>
                      <div class="col-md-9">
                        <h4 id="name"><?php echo $collector->name; ?></h4>
                      </div>
                    </div>

                    <h4 class="data-title">Data Collection (current)</h4>
                    <p>Property -
                      <span><?php echo \App\Property::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0)->count(); ?></span>
                    </p>
                    <p>Business -
                      <span><?php echo \App\Business::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0)->count(); ?></span>
                    </p>

                    <h4 class="data-title">Personal Info</h4>
                    <p>Email - <?php echo $collector->email?: 'NA'; ?></p>
                    <p>Username - <?php echo $collector->username ?: 'NA'; ?></p>
                    <div class="clearfix"></div>

                    <div class="row collector-pay-btn">
                      <a href="{{route('collectors.payment.pay', $collector->collector_id)}}" class="btn btn-xs">Pay Collector</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="row">
          {{$collectors->links()}}
        </div>
    </div>
</div>
@endsection
