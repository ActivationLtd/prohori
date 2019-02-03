<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */

/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */

/** @var array $graph_date Dummy data. */
$graph_date = "
        ['Product', 'Purchases'],
        ['Prod1', 81750],
        ['Prod2', 37920],
        ['Prod3', 26950],
        ['Prod4', 20990],
        ['Prod5', 15260]
    ";
?>

<div class="row">
    <div class="col-md-12">
        <h5>Top purchased product</h5>
        <div id="top_purchases_chart_div"></div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStacked);


        function drawStacked() {
            var data = google.visualization.arrayToDataTable([
                {!!  $graph_date !!}
            ]);

            var options = {
                // title: 'Population of Largest U.S. Cities',
                chartArea: {width: '50%', height: '80%'},
                // isStacked: true,
                hAxis: {
                    title: 'Earnings',
                    minValue: 0
                },
                vAxis: {
                    title: 'Charity'
                },
                bar: {groupWidth: '61%'},
                legend: {position: 'top'},
                colors: ['green'],
                // is3D:true

            };
            var chart = new google.visualization.BarChart(document.getElementById('top_purchases_chart_div'));
            chart.draw(data, options);
        }
    </script>
@endsection