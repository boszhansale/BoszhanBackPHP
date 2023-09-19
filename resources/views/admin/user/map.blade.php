@extends('admin.layouts.index')



@section('content')
    <div class="row">


        <div class="col-12" id="distance"></div>

        <div class="col-md-12">
            <div id="map" style="height: 600px">

            </div>
        </div>
    </div>

@endsection



@section('js')
    <script>
        var map;
        var markers = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 43.238949, lng: 76.889709},
                zoom: 10
            });

            updateMarkers();
            setInterval(updateMarkers, 3000); // Обновление каждые 3 секунды
        }


        function updateMarkers() {
            clearMarkers();

            fetch('https://boszhan.kz/api/position')
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        var markerColor = (item.role_id === 2) ? 'blue' : 'red';
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(item.lat), lng: parseFloat(item.lng)},
                            map: map,
                            label: item.name,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                fillColor: markerColor,
                                fillOpacity: 1,
                                strokeColor: markerColor,
                                strokeOpacity: 1,
                                strokeWeight: 1.5,
                                scale: 10
                            }
                        });
                        marker.addListener('click', function () {
                            window.open('https://boszhan.kz/admin/user/show/' + item.id, '_blank');
                        });
                        markers.push(marker);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        function clearMarkers() {
            markers.forEach(marker => {
                marker.setMap(null);
            });
            markers = [];
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYjhd-JDSwGWuiZBp_27RfSMOSCB-mTBQ&callback&callback=initMap">
    </script>
@endsection

