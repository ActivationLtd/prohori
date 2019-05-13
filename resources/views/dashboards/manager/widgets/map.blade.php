<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */

?>


<h4>See task in map</h4>
<div id="mapid" style="width: 100%; height: 400px;"></div>



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
        var mymap = L.map('mapid').setView([23.483401, 90.186768], 13);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
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

        <?php $tasks = \App\Task::with('clientlocation')->whereIn('status', ['To do', 'In progress', 'Verify'])->where('assigned_to', user()->id)->orWhere('created_by',user()->id)->get(); ?>

        @foreach($tasks as $task)
        @if($task->clientlocation()->exists())
        @if($task->clientlocation->latitude && $task->clientlocation->longitude)
        L.marker([{{$task->clientlocation->latitude}}, {{$task->clientlocation->longitude}}])
            .addTo(mymap)
            .bindPopup("<a href='{{route('tasks.edit',$task->id)}}'><img style='width:50px' src='{{asset($task->assignee->profile_pic_url)}}'/><b>&nbsp{{$task->assignee->name}}&nbsp{{$task->tasktype->name}}&nbsp</b> <br>{{$task->clientlocation->name}}&nbsp<br>{{$task->status}}</a>")
            .openPopup();

        @endif
        @endif
        @endforeach

    </script>
@endsection