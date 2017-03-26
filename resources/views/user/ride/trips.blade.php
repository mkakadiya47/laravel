@extends('user.layout.base')

@section('title', 'My Trips ')

@section('content')

<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.my_trips')</h4>
            </div>
        </div>

        <div class="row no-margin ride-detail">
            <div class="col-md-12">
            @if($trips->count() > 0)

                <table class="table table-condensed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>@lang('user.date')</th>
                            <th>@lang('user.profile.name')</th>
                            <th>@lang('user.amount')</th>
                            <th>@lang('user.type')</th>
                            <th>@lang('user.payment')</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($trips as $trip)

                        <tr data-toggle="collapse" data-target="#trip_{{$trip->id}}" class="accordion-toggle collapsed">
                            <td><span class="arrow-icon fa fa-chevron-right"></span></td>
                            <td>{{date('d-m-Y',strtotime($trip->assigned_at))}}</td>
                            <td>{{$trip->provider->first_name}} {{$trip->provider->last_name}}</td>
                            <td>{{currency($trip->payment->total)}}</td>
                            <td>{{$trip->service_type->name}}</td>
                            <td>@lang('user.paid_via') {{$trip->payment_mode}}</td>
                        </tr>
                        <tr class="hiddenRow">
                            <td colspan="6">
                                <div class="accordian-body collapse row" id="trip_{{$trip->id}}">
                                    <div class="col-md-6">
                                        <div class="my-trip-left">
                                        <?php 
                                    $map_icon = asset('asset/marker.png');
                                    $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:".$map_icon."%7C".$trip->s_latitude.",".$trip->s_longitude."&markers=icon:".$map_icon."%7C".$trip->d_latitude.",".$trip->d_longitude."&path=color:0x191919|weight:8|".$trip->s_latitude.",".$trip->s_longitude."|".$trip->d_latitude.",".$trip->d_longitude."&key=".env('GOOGLE_MAP_KEY'); ?>
                                            <div class="map-static" style="background-image: url({{$static_map}});">
                                                
                                            </div>
                                            <div class="from-to row no-margin">
                                                <div class="from">
                                                    <h5>@lang('user.from')</h5>
                                                    <h6>{{date('H:i A - d-m-y', strtotime($trip->started_at))}}</h6>
                                                    <p>{{$trip->s_address}}</p>
                                                </div>
                                                <div class="to">
                                                    <h5>@lang('user.to')</h5>
                                                    <h6>{{date('H:i A - d-m-y', strtotime($trip->finished_at))}}</h6>
                                                    <p>{{$trip->d_address}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="mytrip-right">

                                            <div class="fare-break">

                                                <h4 class="text-center"><strong>{{$trip->service_type->name}} - @lang('user.fare_breakdown')</strong></h4>

                                                <h5>@lang('user.ride.base_price') <span>{{currency($trip->payment->fixed)}}</span></h5>
                                                <h5><strong>@lang('user.ride.tax_price') </strong><span><strong>{{currency($trip->payment->tax)}}</strong></span></h5>
                                                <h5 class="big"><strong>@lang('user.charged') - {{$trip->payment_mode}} </strong><span><strong>{{currency($trip->payment->total)}}</strong></span></h5>

                                            </div>

                                            <div class="trip-user">
                                                <div class="user-img" style="background-image: url({{img($trip->provider->avatar)}});">
                                                </div>
                                                <div class="user-right">
                                                    <h5>{{$trip->provider->first_name}} {{$trip->provider->last_name}}</h5>
                                                    <div class="rating-outer">
                                                        <input type="hidden" class="rating" value="{{$trip->rating->user_rated}}" />
                                                    </div>
                                                    <p>{{$trip->rating->user_comment}}</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </td>
                        </tr>

                        @endforeach


                    </tbody>
                </table>
                @else
                    <hr>
                    <p style="text-align: center;">No trips Available</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection