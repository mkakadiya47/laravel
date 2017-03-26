@extends('user.layout.base')

@section('title', 'Ride Confirmation ')

@section('content')
<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.ride.ride_now')</h4>
            </div>
        </div>
        @include('common.notify')
        <div class="row no-margin">
            <div class="col-md-6">
                <form action="{{url('create/ride')}}" method="POST">
                {{ csrf_field() }}
                    <dl class="dl-horizontal left-right">
                        <dt>@lang('user.type')</dt>
                        <dd>{{$service->name}}</dd>
                        <dt>@lang('user.total_distance')</dt>
                        <dd>{{$fare->distance}} Kms</dd>
                        <dt>@lang('user.eta')</dt>
                        <dd>{{$fare->time}}</dd>
                        <dt>@lang('user.estimated_fare')</dt>
                        <dd>{{currency($fare->estimated_fare)}}</dd>
                        <hr>
                        @if(Auth::user()->wallet_balance > 0)

                        <input type="checkbox" name="use_wallet" value="1"><span style="padding-left: 15px;">@lang('user.use_wallet_balance')</span>
                        <br>
                        <br>
                            <dt>@lang('user.available_wallet_balance')</dt>
                            <dd>{{currency(Auth::user()->wallet_balance)}}</dd>
                        @endif
                    </dl>

                    <input type="hidden" name="s_address" value="{{Request::get('s_address')}}">
                    <input type="hidden" name="d_address" value="{{Request::get('d_address')}}">
                    <input type="hidden" name="s_latitude" value="{{Request::get('s_latitude')}}">
                    <input type="hidden" name="s_longitude" value="{{Request::get('s_longitude')}}">
                    <input type="hidden" name="d_latitude" value="{{Request::get('d_latitude')}}">
                    <input type="hidden" name="d_longitude" value="{{Request::get('d_longitude')}}">
                    <input type="hidden" name="service_type" value="{{Request::get('service_type')}}">
                    <input type="hidden" name="distance" value="{{$fare->distance}}">

                    <p>@lang('user.payment_method')</p>
                    <select class="form-control" name="payment_mode" id="payment_mode" onchange="card(this.value);">
                      <option value="CASH">CASH</option>
                      @if(Setting::get('CARD') == 1)
                      @if($cards->count() > 0)
                        <option value="CARD">CARD</option>
                      @endif
                      @endif
                    </select>
                    <br>

                    @if(Setting::get('CARD') == 1)
                        @if($cards->count() > 0)
                        <select class="form-control" name="card_id" style="display: none;" id="card_id">
                          <option value="">Select Card</option>
                          @foreach($cards as $card)
                            <option value="{{$card->card_id}}">{{$card->brand}} **** **** **** {{$card->last_four}}</option>
                          @endforeach
                        </select>
                        @endif
                    @endif

                    <button type="submit" class="full-primary-btn fare-btn">@lang('user.ride.ride_now')</button>

                </form>
            </div>

            <div class="col-md-6">
                <div class="user-request-map">
                    <?php 
                    $map_icon = asset('asset/marker.png');
                    $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:".$map_icon."%7C".$request->s_latitude.",".$request->s_longitude."&markers=icon:".$map_icon."%7C".$request->d_latitude.",".$request->d_longitude."&path=color:0x191919|weight:8|".$request->s_latitude.",".$request->s_longitude."|".$request->d_latitude.",".$request->d_longitude."&key=".env('GOOGLE_MAP_KEY'); ?>
                    <div class="map-static" style="background-image: url({{$static_map}});">
                    </div>
                    <div class="from-to row no-margin">
                        <div class="from">
                            <h5>FROM</h5>
                            <p>{{$request->s_address}}</p>
                        </div>
                        <div class="to">
                            <h5>TO</h5>
                            <p>{{$request->d_address}}</p>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function card(value){
            if(value == 'CARD'){
                $('#card_id').fadeIn(300);
            }else{
                $('#card_id').fadeOut(300);
            }
        }
    </script>
@endsection