@extends('admin.layouts.index')

@section('content-header-title',$store->name)

@section('content')
        <div class="row">
            <div class="col-md-12">

                <a class="btn btn-info btn-sm" href="{{route('admin.store.edit',$store->id)}}">
                   изменить
                </a>
                <a  class="btn btn-danger btn-sm" href="{{route('admin.store.delete',$store->id)}}" onclick="return confirm('Удалить?')">
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
                                    <a href="{{route('admin.user.show',$store->salesrep_id)}}"> {{$store->salesrep->name}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>БИН</td>
                                <td>{{$store->bin}}</td>
                            </tr>
                            <tr>
                                <td>id_1c</td>
                                <td>{{$store->id_1c}}</td>
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

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="map" style="height: 600px">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover text-nowrap table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Статус</th>
                                <th>Торговый</th>
                                <th>Водитель</th>
                                <th>сумма</th>
                                <th>возврат</th>
                                <th>Дата создание</th>
                                <th>Дата доставки</th>
                                <th>тип оплаты</th>
                                <th>статус оплаты</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td  class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.order.show',$order->id)}}">
                                            <i class="fas fa-folder">
                                            </i>

                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a  class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$order->id)}}" onclick="return confirm('Удалить?')">
                                            <i class="fas fa-trash"></i>

                                        </a>
                                    </td>
                                    <td>{{$order->status->description}}</td>
                                    <td><a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a></td>
                                    <td><a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a></td>
                                    <td class="price">{{$order->purchase_price}}</td>
                                    <td class="price">{{$order->return_price}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>{{$order->paymentType->name}}</td>
                                    <td>{{$order->paymentStatus->name}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
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
                center : centerCoordinates,
                zoom : 16
            }
            map = new google.maps.Map(mapLayer, defaultOptions);

            google.maps.event.addListener(map, 'click', function(event) {
                // pathCoordinates.push({
                //     lat : event.latLng.lat(),
                //     lng : event.latLng.lng()
                // });
                //


            });

            new google.maps.Marker({
                position : new google.maps.LatLng(centerCoordinates),
                map : map,
                title : 'test'
            });

        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYjhd-JDSwGWuiZBp_27RfSMOSCB-mTBQ&callback&callback=initMap">
    </script>

@endsection
