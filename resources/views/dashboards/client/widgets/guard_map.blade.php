<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */
use App\User;
use App\Userlocation;
$today = date('Y-m-d');
$tomorrow = date("Y-m-d", strtotime("tomorrow"));
$users = User::where('group_ids_csv', '6')->where('client_id',user()->client_id)->get();

?>
<div class="row">
    <div class="col-md-12">
        <h4>See Guard Location in map</h4>
        <h5>Guard Map Filters</h5>

        <form  method="POST" id="mapfilters" name="mapfilter" action="{{route('custom.guard-location-filter')}}">
            @csrf

            <div class="clearfix"></div>
            @include('form.select-model',['var'=>['name'=>'division_id','label'=>'Division','table'=>'divisions', 'container_class'=>'col-sm-3']])
            @include('form.select-model',['var'=>['name'=>'district_id','label'=>'District','table'=>'districts', 'container_class'=>'col-sm-3']])
            @include('form.select-model',['var'=>['name'=>'upazila_id','label'=>'Upazila','table'=>'upazilas', 'container_class'=>'col-sm-3']])
            <div class="clearfix"></div>
            <?php
            if(user()->isClientUser() && isset(user()->client_id)){
                $var['query']=DB::table('clients')->where('id', user()->client_id);
                }
                $var['name']='client_id';
                $var['label']='Client';
                $var['table']='clients';
                $var['container_class']='col-sm-4';
            ?>


            @include('form.select-model',['var'=>$var])
            @include('form.select-model',['var'=>['name'=>'clientlocation_id','label'=>'ClientLocation','table'=>'clientlocations', 'container_class'=>'col-sm-4']])
            @include('form.select-model',['var'=>['name'=>'clientlocationtype_id','label'=>'Clientlocation Type','table'=>'clientlocationtypes', 'container_class'=>'col-sm-4']])
            <div class="clearfix"></div>

            @include('form.select-model', ['var'=>['name'=>'guard_user_id','label'=>'user','table'=> 'users','container_class'=>'','query'=>DB::table('users')->where('group_ids_csv', 6)]])
            <div class="clearfix"></div>
            <button class="btn-light" type="submit" id="mapfiltersubmit">Filter</button>
            <a href="{{route('home')}}" class="button-primary">Reset</a>
        </form>
        <div id="userlocationmapid" style="width: 100%; height: 400px;"></div>
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
        var userlocationmap = L.map('userlocationmapid').setView([23.7807777, 90.3492858], 12);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(userlocationmap);
        var popup = L.popup();

        function onGuardMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(userlocationmap);
        }

        //        myguardmap.on('click', onGuardMapClick);

                @foreach($users as $user)
        var latlngs = [];
        var colors = ['red', 'yellow', 'green', 'blue', 'orange', 'black', 'white'];

        <?php
        $userlocations = Userlocation::with('user')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', $today)
            ->where('created_at', '<=', $tomorrow)
            ->orderBy('created_at', 'desc')
            ->remember(cacheTime('medium'))->get();
        ?>
        @foreach($userlocations as $userlocation)
        @if(isset($userlocation->latitude,$userlocation->longitude))
        //pushing polyline values in the latings array
        latlngs.push([{{$userlocation->latitude}},{{$userlocation->longitude}}])
        //creating marker points using value from table
        L.marker([{{$userlocation->latitude}}, {{$userlocation->longitude}}])
            .addTo(userlocationmap)
            //adding popup , option autoclose and autopan off because the popup should be always open
            .bindPopup("<a href='{{route('userlocations.edit',$userlocation->id)}}'><img style='width:50px' src='{{asset($userlocation->user->profile_pic_url)}}'/><b>&nbsp{{$userlocation->user->name}}</a>", {
                autoClose: false,
                autoPan: false
            })
            .openPopup();
                @endif
                @endforeach
        var randomColor = colors[Math.floor(Math.random() * colors.length)];
        //creating polyline
        var polyline = L.polyline(latlngs, {color: randomColor});
        polyline.addTo(userlocationmap);
        @endforeach
        function dynamicDistrict() {
            $('select[name=division_id]').change(function () { // change function of listbox
                var division_id = $('select[name=division_id]').select2('val');
                //var assignee_id = $('select[name=assigned_to]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=district_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('custom.district-based-on-division')}}',
                    data: {
                        division_id: division_id,
                    },
                    success: function (response) {
                        console.log(response.data);
                        $.each(response.data, function (i, obj) {
                            $("select[name=district_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                        });
                    },
                });

            });
        }

        function dynamicUpazilla() {
            $('select[name=district_id]').change(function () { // change function of listbox
                var division_id = $('select[name=division_id]').select2('val');
                var district_id = $('select[name=district_id]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=upazila_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('custom.upazila-based-on-district')}}',
                    data: {
                        division_id: division_id,
                        district_id: district_id,
                    },
                    success: function (response) {
                        console.log(response.data);
                        $.each(response.data, function (i, obj) {
                            $("select[name=upazila_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                        });
                    },
                });

            });
        }

        function dynamicClientLocationBasedOnClient() {
            $('select[name=client_id]').change(function () { // change function of listbox
                var client_id = $('select[name=client_id]').select2('val');
                //var district_id = $('select[name=district_id]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=clientlocation_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('custom.clientloacation-based-on-client')}}',
                    data: {
                        client_id: client_id,
                    },
                    success: function (response) {
                        //console.log(response.data);
                        $.each(response.data, function (i, obj) {
                            $("select[name=clientlocation_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                        });
                    },
                });

            });
        }

        dynamicDistrict();
        dynamicUpazilla();
        dynamicClientLocationBasedOnClient();

    </script>
@endsection