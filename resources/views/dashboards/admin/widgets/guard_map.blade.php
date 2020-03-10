<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */

?>
<div class="row">
    <div class="col-md-12">
        <h4>See Guard Location in map</h4>
        <div id="guardmapid" style="width: 100%; height: 400px;"></div>
    </div>
</div>
@section('css')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>
@endsection
@section('js')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
            integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
            crossorigin=""></script>
    <script>
        var mymap = L.map('guardmapid').setView([23.7807777, 90.3492858], 12);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(mymap);
        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);
            <?php
            $guardusers = \APP\User::where('group_ids_csv', '6')->get();

            ?>
        @foreach($guardusers as $guarduser)
            var latlngs = [];
            var colors=['red','yellow','green','blue','orange','black','white'];
        <?php
        $userlocations = \App\UserLocation::with('guardUser')
            ->where('user_id', $guarduser->id)
            ->orderBy('created_at', 'desc')
            ->remember(cacheTime('medium'))->get();
        ?>
        @foreach($userlocations as $userlocation)
        @if(isset($userlocation->latitude,$userlocation->longitude))
                //pushing polyline values in the latings array
            latlngs.push([{{$userlocation->latitude}},{{$userlocation->longitude}}])
        //creating marker points using value from table
        L.marker([{{$userlocation->latitude}}, {{$userlocation->longitude}}])
        .addTo(mymap)
        //adding popup , option autoclose and autopan off because the popup should be always open
        .bindPopup("<a href='{{route('userlocations.edit',$userlocation->id)}}'><img style='width:50px' src='{{asset($userlocation->guardUser->profile_pic_url)}}'/><b>&nbsp{{$userlocation->guardUser->name}}</a>",{autoClose: false, autoPan: false})
        .openPopup();
        @endif
        @endforeach
        var randomColor = colors[Math.floor(Math.random() * colors.length)];

            //creating polyline
        var polyline = L.polyline(latlngs, {color: randomColor});
        polyline.addTo(mymap);
        @endforeach
    </script>
@endsection