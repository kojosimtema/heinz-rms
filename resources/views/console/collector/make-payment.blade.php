@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="row collector-pay">

            <div class="col-md-12 col-lg-12">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <form class="" action="{{route('collectors.payment.pay', $collector->collector_id)}}" method="post">
                      @csrf
                      <div class="row text-left">
                        @if (\Session::has('error'))
                            <small class="error">{!! \Session::get('error') !!}</small>
                        @elseif(\Session::has('success'))
                          <small class="success">{!! \Session::get('success') !!}</small>
                        @endif
                        <h3 id="name"><?php echo $collector->name; ?></h3>

                        <table>
                          <tr>
                            <td>Total Property</td>
                            <td><?php echo $prop = \App\Property::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0)->count(); ?></td>
                          </tr>
                          <tr>
                            <td>Total Business</td>
                            <td><?php echo $bus = \App\Business::where('client', '!=', '')->where('client', $collector->email)->where('paid_collector', 0)->count(); ?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td style="border-top: 2px dashed #ebeff2; border-bottom: 2px dashed #ebeff2;">
                              <?php echo $prop + $bus; ?>
                            </td>
                          </tr>
                        </table>

                        <div class="row" style="width: 100%; margin: auto; margin-top: 15px;">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" style="color: #36404a;font-size: 12px;">Choose data quantity to paid</label>
                              <input type="number" class="form-control" name="quantity" value="" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="" style="color: #36404a;font-size: 12px;">Select account to debit</label>
                            <select class="form-control" name="account" required>
                              <option value="p">Properties</option>
                              <option value="b">Business</option>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <a href="{{route('collectors.payment')}}" style="background: brown;" class="btn btn-xs form-control">&laquo; Back</a>
                          </div>
                          <div class="col-md-6">
                            <button type="submit" class="btn btn-xs form-control">Paid &raquo;</button>
                          </div>
                        </div>
                      </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
