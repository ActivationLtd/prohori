<?php

$script_paths = [
    'templates/admin-lte/css/skins/_all-skins.min.css',
    'templates/admin-lte/bootstrap/css/bootstrap.min.css',
    'templates/admin-lte/css/AdminLTE.css',
    'templates/admin-lte/plugins/morris/morris.css',
    'templates/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
    'templates/admin-lte/plugins/datatables/dataTables.bootstrap.css',
    'templates/admin-lte/plugins/validation/css/validationEngine.jquery.css',
    'templates/admin-lte/plugins/select2-3.5.1/select2.css',
    'templates/admin-lte/plugins/uploadfile/uploadfile.css',
    'templates/admin-lte/plugins/iCheck/all.css',
    'templates/admin-lte/plugins/iCheck/square/blue.css',
    'templates/admin-lte/plugins/datepicker/datepicker3.css',
    'templates/admin-lte/css/custom.css',
    'prohori/css/prohori.css',
]
?>

@foreach($script_paths as $script_path)
    <link rel="stylesheet" href="{{asset($script_path)}}">
@endforeach

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu|Comfortaa" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Arvo|Montserrat|Ruda" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Baumans" rel="stylesheet">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
      integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">


@section('css')
    {{-- ++++++++++++ --}}
    {{-- css section --}}
    {{-- ++++++++++++ --}}
@show