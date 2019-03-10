<?php
$script_paths = [
    'templates/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
    'templates/js/jquery-ui-1.10.3.min.js',
    'templates/admin-lte/bootstrap/js/bootstrap.min.js',
    'templates/admin-lte/plugins/chartjs/Chart.min.js',
    'templates/admin-lte/plugins/fastclick/fastclick.js',
    'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
    'templates/admin-lte/plugins/morris/morris.min.js',
    'templates/admin-lte/plugins/sparkline/jquery.sparkline.min.js',
    'https://www.gstatic.com/charts/loader.js',
    'templates/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
    'templates/admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
    'templates/admin-lte/plugins/knob/jquery.knob.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
    'templates/admin-lte/plugins/datepicker/bootstrap-datepicker.js',
    'templates/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
    'templates/admin-lte/plugins/fastclick/fastclick.js',
    'templates/admin-lte/plugins/iCheck/icheck.min.js',
    'templates/admin-lte/plugins/ckeditor/ckeditor.js',
    'templates/admin-lte/js/app.min.js',
    // 'templates/admin-lte/js/demo.js',
    // 'templates/admin-lte/plugins/validator/validation.js',
    'templates/admin-lte/plugins/uploadfile/jquery.uploadfile.js',
    'templates/admin-lte/plugins/datatables/jquery.dataTables.min.js',
    'templates/admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
    'templates/admin-lte/plugins/datatables/jquery.dataTables.fnSetFilteringDelay.js',
    'templates/admin-lte/plugins/validation/js/languages/jquery.validationEngine-en.js',
    'templates/admin-lte/plugins/validation/js/jquery.validationEngine.js',
    'templates/admin-lte/plugins/select2-3.5.1/select2.js',
    'templates/admin-lte/js/spyr.js',
    'templates/admin-lte/js/spyr-validation.js',
    'templates/admin-lte/js/vue.js',
    'templates/admin-lte/js/axios.min.js',

    'templates/admin-lte/js/custom.js',
];
?>

@foreach($script_paths as $script_path)
    <script type="text/javascript" src="{{asset($script_path)}}"></script>
@endforeach

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

