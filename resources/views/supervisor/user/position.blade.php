@extends('supervisor.layouts.index')

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
        <div class="col-md-12">
            <div id="map" style="height: 600px">

            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>дата</th>
                    <th>lat</th>
                    <th>lng</th>
                </tr>
                </thead>
                <tbody>
                @foreach($positions as $position)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$position->created_at}}</td>
                        <td>{{$position->lat}}</td>
                        <td>{{$position->lng}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection



@section('js')
    <script>
        var map;
        var pathCoordinates = JSON.parse('@json($positions)');
        var startLngLat = JSON.parse('@json($user->userPositions()->latest()->first(['lat','lng'])->toArray())');

        function initMap() {
            var mapLayer = document.getElementById("map");
            var centerCoordinates = new google.maps.LatLng({{$user->lat}}, {{$user->lng}});
            var defaultOptions = {
                center: centerCoordinates,
                zoom: 13
            }
            map = new google.maps.Map(mapLayer, defaultOptions);

            google.maps.event.addListener(map, 'click', function (event) {
                // pathCoordinates.push({
                //     lat : event.latLng.lat(),
                //     lng : event.latLng.lng()
                // });
                //
                // new google.maps.Marker({
                //     position : new google.maps.LatLng(event.latLng),
                //     map : map,
                //     title : 'test'
                // });

            });

            drawPath();
            for (let pos of pathCoordinates) {
                console.log(pos)
                new google.maps.Marker({
                    position: new google.maps.LatLng(pos),
                    map: map,
                    title: pos.time
                });
            }
        }

        function drawPath() {
            new google.maps.Polyline({
                path: pathCoordinates,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1,
                strokeWeight: 4,
                map: map,
            });

        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYjhd-JDSwGWuiZBp_27RfSMOSCB-mTBQ&callback&callback=initMap">
    </script>

@endsection

