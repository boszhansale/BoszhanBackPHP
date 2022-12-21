@extends('supervisor.layouts.index')

@section('content-header-title',$store->name)

@section('content')
    <div class="row">
        <div class="col-md-12">


            <a class="btn btn-info btn-sm" href="{{route('supervisor.store.edit',$store->id)}}">
                изменить
            </a>
            <a class="btn btn-danger btn-sm" href="{{route('supervisor.store.delete',$store->id)}}"
               onclick="return confirm('Удалить?')">
                удалить
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <table class="table  table-bordered">
                        <tr>
                            <td>ID</td>
                            <td>{{$store->id}}</td>
                        </tr>
                        <tr>
                            <td>Адрес</td>
                            <td>{{$store->address}}</td>
                        </tr>
                        <tr>
                            <td>Телефон номер</td>
                            <td>{{$store->phone}}</td>
                        </tr>
                        <tr>
                            <td>Торговый представитель</td>
                            <td>
                                <a href="{{route('supervisor.user.show',$store->salesrep_id)}}"> {{$store->salesrep->name}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>БИН</td>
                            <td>{{$store->bin}}</td>
                        </tr>
                        <tr>
                            <td>id_1c</td>
                            <td>{{$store->id_sell}}</td>
                        </tr>
                        <tr>
                            <td>Дата создание</td>
                            <td>{{$store->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Количество заявок</td>
                            <td>{{$store->orders()->count()}}</td>
                        </tr>
                        <tr>
                            <td> Сумма заявок</td>
                            <td class="price">{{round($purchasePrices)}}</td>
                        </tr>
                        <tr>
                            <td>Сумма возвратов</td>
                            <td class="price">{{round($returnPrices)}}</td>
                        </tr>
                        <tr>
                            <td>Процент возврата</td>
                            @if($returnPrices > 0)
                                <th>{{ round(($returnPrices / $purchasePrices)*100)  }}%</th>
                            @else
                                <td>0%</td>
                            @endif
                        </tr>

                        <tr>
                            <td>Контрагент</td>
                            <td>{{$store->counteragent?->name}}</td>
                        </tr>
                        <tr>
                            <td>lat</td>
                            <td>{{$store->lat}}</td>
                        </tr>
                        <tr>
                            <td>lng</td>
                            <td>{{$store->lng}}</td>
                        </tr>
                        <tr>
                            <th>Долг</th>
                            <td> {{$store->orders()->where('payment_status_id',2)->sum('purchase_price')- $store->orders()->where('payment_status_id',1)->sum('purchase_price')}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="map" style="height: 600px">

            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        var map;

        function initMap() {
            var mapLayer = document.getElementById("map");
            var centerCoordinates = new google.maps.LatLng({{$store->lat}}, {{$store->lng}});
            var defaultOptions = {
                center: centerCoordinates,
                zoom: 16
            }
            map = new google.maps.Map(mapLayer, defaultOptions);

            google.maps.event.addListener(map, 'click', function (event) {
                // pathCoordinates.push({
                //     lat : event.latLng.lat(),
                //     lng : event.latLng.lng()
                // });
                //


            });

            new google.maps.Marker({
                position: new google.maps.LatLng(centerCoordinates),
                map: map,
                title: 'test'
            });

        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYjhd-JDSwGWuiZBp_27RfSMOSCB-mTBQ&callback&callback=initMap">
    </script>

@endsection
