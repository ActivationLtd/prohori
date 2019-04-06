<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */

?>

<div class="row">
    <div class="col-md-12">
        <h4>Area Wise Clients</h4>
        <div id="chart_div_client"></div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStacked);

        function drawStacked() {
            var data = google.visualization.arrayToDataTable([
                ['City', 'Amount of Client'],
                ['Dhaka', 6175000],
                ['Sylhet', 3792000],
                ['Rajshai', 2695000],
                ['Chittagong', 2099000],
                ['Mymensign', 1526000],
                ['Khulna', 1326000],
                ['Rangpur', 1026000],
                ['Barisal', 826000],
            ]);

            var options = {
                // title: 'Population of Largest U.S. Cities',
                chartArea: {width: '75%'},
                // isStacked: true,
                hAxis: {
                    title: 'Total Clients',
                    minValue: 0,
                },
                vAxis: {
                    title: 'Areas'
                }
            };
            var chart = new google.visualization.BarChart(document.getElementById('chart_div_client'));
            chart.draw(data, options);
        }
    </script>
@endsection