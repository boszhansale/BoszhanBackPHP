@extends('admin.layouts.index')

@section('content-header-title')
    <a href="{{route('admin.user.show',$user->id)}}">{{$user->name}}</a>
@endsection


@section('content')
    <div class="row">
        <div class="col-2">
            <form action="{{route('admin.user.position',$user->id)}}">
                <div class="form-group">
                    <label for="">Дата</label>
                    <input type="date" name="date" class="form-control" value="{{now()->format('Y-m-d')}}">

                </div>
                <div class="form-group">
                    <button class="btn btn-primary">показать</button>
                </div>
            </form>
        </div>

        <div class="col-12" id="distance"></div>

        <div class="col-md-12">
            <div id="map" style="height: 800px">

            </div>
        </div>
        {{--        <div class="col-md-12">--}}
        {{--            <table class="table table-bordered">--}}
        {{--                <thead>--}}
        {{--                <tr>--}}
        {{--                    <th>#</th>--}}
        {{--                    <th>дата</th>--}}
        {{--                    <th>lat</th>--}}
        {{--                    <th>lng</th>--}}
        {{--                </tr>--}}
        {{--                </thead>--}}
        {{--                <tbody>--}}
        {{--                @foreach($positions as $position)--}}
        {{--                    <tr>--}}
        {{--                        <td>{{$loop->iteration}}</td>--}}
        {{--                        <td>{{$position['time']}}</td>--}}
        {{--                        <td>{{$position['lat']}}</td>--}}
        {{--                        <td>{{$position['lng']}}</td>--}}
        {{--                    </tr>--}}
        {{--                @endforeach--}}
        {{--                </tbody>--}}
        {{--            </table>--}}
        {{--        </div>--}}
    </div>

@endsection



@section('js')
    <script>

        function initMap() {
            var service = new google.maps.DirectionsService;
            var map = new google.maps.Map(document.getElementById('map'));

            // list of points
            var stations = JSON.parse('@json($positions)');


            // Zoom and center map automatically by stations (each station will be in visible map area)
            var lngs = stations.map(function (station) {
                return station.lng;
            });
            var lats = stations.map(function (station) {
                return station.lat;
            });
            map.fitBounds({
                west: Math.min.apply(null, lngs),
                east: Math.max.apply(null, lngs),
                north: Math.min.apply(null, lats),
                south: Math.max.apply(null, lats),
            });

            // Show stations on the map as markers
            for (var i = 0; i < stations.length; i++) {
                if (i === 0) {
                    new google.maps.Marker({
                            position: stations[i],
                            map: map,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE, // Используем символ круга как иконку маркера
                                fillColor: 'black', // Черный цвет маркера
                                fillOpacity: 1, // Полная непрозрачность
                                strokeColor: 'blue', // Цвет обводки
                                strokeWeight: 2, // Толщина обводки
                                scale: 15
                            },
                            label: {
                                text: stations[i].time, // Номер или текст, который будет отображаться на маркере
                                fontSize: '10px',
                                color: 'white'
                            }
                        }
                    );
                } else if (i === stations.length - 1) {
                    new google.maps.Marker({
                            position: stations[i],
                            map: map,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE, // Используем символ круга как иконку маркера
                                fillColor: 'black', // Черный цвет маркера
                                fillOpacity: 1, // Полная непрозрачность
                                strokeColor: 'red', // Цвет обводки
                                strokeWeight: 2, // Толщина обводки
                                scale: 15
                            },
                            label: {
                                text: stations[i].time, // Номер или текст, который будет отображаться на маркере
                                fontSize: '10px',
                                color: 'white'
                            }
                        }
                    );
                } else {
                    new google.maps.Marker({
                            position: stations[i],
                            map: map,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE, // Используем символ круга как иконку маркера
                                fillColor: 'black', // Черный цвет маркера
                                fillOpacity: 1, // Полная непрозрачность
                                strokeColor: 'black', // Цвет обводки
                                strokeWeight: 2, // Толщина обводки
                                scale: 15
                            },
                            label: {
                                text: stations[i].time, // Номер или текст, который будет отображаться на маркере
                                fontSize: '10px',
                                color: 'white'
                            }
                        }
                    );
                }

            }

            // Divide route to several parts because max stations limit is 25 (23 waypoints + 1 origin + 1 destination)
            for (var i = 0, parts = [], max = 25 - 1; i < stations.length; i = i + max)
                parts.push(stations.slice(i, i + max + 1));

            // Service callback to process service results
            var service_callback = function (response, status) {
                if (status != 'OK') {
                    console.log('Directions request failed due to ' + status);
                    return;
                }
                var renderer = new google.maps.DirectionsRenderer;
                renderer.setMap(map);
                renderer.setOptions({suppressMarkers: true, preserveViewport: true});
                renderer.setDirections(response);
            };

            // Send requests to service to get route (for stations count <= 25 only one request will be sent)
            for (var i = 0; i < parts.length; i++) {
                // Waypoints does not include first station (origin) and last station (destination)
                var waypoints = [];
                for (var j = 1; j < parts[i].length - 1; j++)
                    waypoints.push({location: parts[i][j], stopover: false});
                // Service options
                var service_options = {
                    origin: parts[i][0],
                    destination: parts[i][parts[i].length - 1],
                    waypoints: waypoints,
                    travelMode: 'WALKING'
                };
                // Send request
                service.route(service_options, service_callback);
            }
        }
        {{--var map;--}}
        {{--var coordinates = JSON.parse('@json($positions)');--}}
        {{--var directionsService;--}}
        {{--var directionsDisplay;--}}

        {{--function initMap() {--}}
        {{--    var map = new google.maps.Map(document.getElementById('map'), {--}}
        {{--        center: coordinates[0],--}}
        {{--        zoom: 14--}}
        {{--    });--}}


        {{--    directionsService = new google.maps.DirectionsService();--}}
        {{--    directionsRenderer = new google.maps.DirectionsRenderer();--}}
        {{--    directionsRenderer.setMap(map);--}}


        {{--    var waypoints = [];--}}
        {{--    for (var i = 0; i < coordinates.length; i++) {--}}
        {{--        waypoints.push({--}}
        {{--            location: new google.maps.LatLng(coordinates[i].lat, coordinates[i].lng),--}}
        {{--            stopover: true--}}
        {{--        });--}}
        {{--    }--}}

        {{--    var request = {--}}
        {{--        origin: new google.maps.LatLng(coordinates[0].lat, coordinates[0].lng), // Начальная точка--}}
        {{--        destination: new google.maps.LatLng(coordinates[coordinates.length - 1].lat, coordinates[coordinates.length - 1].lng), // Конечная точка--}}
        {{--        waypoints: waypoints,--}}
        {{--        travelMode: google.maps.TravelMode.DRIVING--}}
        {{--    };--}}

        {{--    directionsService.route(request, function (response, status) {--}}
        {{--        if (status === 'OK') {--}}
        {{--            directionsRenderer.setDirections(response);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        // Инициализация карты
        // function initMap() {
        //     // Создание массива точек маршрута
        //
        //     map = new google.maps.Map(document.getElementById('map'), {
        //         zoom: 14,
        //         center: {lat: 39.8283, lng: -98.5795} // Центрирование карты на США
        //     });
        //
        //     // Создание маркеров для начальной и конечной точек маршрута
        //     var startMarker = new google.maps.Marker({
        //         position: new google.maps.LatLng(coordinates[0].lat, coordinates[0].lng),
        //         map: map
        //     });
        //
        //     var endMarker = new google.maps.Marker({
        //         position: new google.maps.LatLng(coordinates[coordinates.length - 1].lat, coordinates[coordinates.length - 1].lng),
        //         map: map
        //     });
        //
        //     for (var i = 1; i < coordinates.length - 1; i++) {
        //         var marker = new google.maps.Marker({
        //             position: new google.maps.LatLng(coordinates[i].lat, coordinates[i].lng),
        //             map: map,
        //             title: coordinates[i].time
        //         });
        //
        //         // // Создание info window для каждого маркера
        //         // var infoWindowContent = 'Время: ' + coordinates[i].time; // Здесь предполагается, что в массиве coordinates у вас есть поле time с временем для каждой точки маршрута.
        //         // var infoWindow = new google.maps.InfoWindow({
        //         //     content: infoWindowContent
        //         // });
        //         //
        //         // // Отобразить info window сразу после создания маркера
        //         // infoWindow.open(map, marker);
        //     }
        //
        //     // Запрос маршрута с использованием маршрутного сервиса
        //     var directionsService = new google.maps.DirectionsService();
        //     var directionsDisplay = new google.maps.DirectionsRenderer();
        //     directionsDisplay.setMap(map);
        //
        //     // var waypoints = [];
        //     // for (var i = 1; i < coordinates.length - 1; i++) {
        //     //     waypoints.push({
        //     //         location: new google.maps.LatLng(coordinates[i].lat, coordinates[i].lng),
        //     //         stopover: true
        //     //     });
        //     // }
        //
        //     var request = {
        //         origin: new google.maps.LatLng(coordinates[0].lat, coordinates[0].lng),
        //         destination: new google.maps.LatLng(coordinates[coordinates.length - 1].lat, coordinates[coordinates.length - 1].lng),
        //         // waypoints: waypoints,
        //         optimizeWaypoints: false,
        //         travelMode: google.maps.TravelMode.DRIVING
        //     };
        //
        //     directionsService.route(request, function (response, status) {
        //         if (status === google.maps.DirectionsStatus.OK) {
        //             directionsDisplay.setDirections(response);
        //
        //             // Получение расстояния между точками маршрута
        //             var route = response.routes[0];
        //             var totalDistance = 0;
        //
        //             for (var i = 0; i < route.legs.length; i++) {
        //                 totalDistance += route.legs[i].distance.value;
        //             }
        //
        //             var distanceInKm = (totalDistance / 1000).toFixed(2);
        //             document.getElementById('distance').innerHTML = 'Расстояние: ' + distanceInKm + ' км';
        //         }
        //     });
        // }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYjhd-JDSwGWuiZBp_27RfSMOSCB-mTBQ&callback&callback=initMap">
    </script>
@endsection





