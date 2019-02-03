<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */
/* change charity count value from @var $charity_count */
$charity_count = 5;
$top_earned_charities = []; //define blank array 
$top_earned_charities[]= ['Charity', 'Recommendations']; // assign 0 key for barchart 
/* get published charities */
$charities = \App\Charity::where('is_published',1)->get();
$charity_ids = array_column($charities->toArray(), 'id'); // get ids of charities in single dimension array
/* get total purchases according to charities */
$total_purchases = \App\Purchase::select('charity_name', DB::raw('sum(charity_donation_charity_currency) as purchase'))->whereIn('charity_id', $charity_ids)->groupBy('charity_name')->orderBy('purchase','DESC')->take($charity_count)->get();
if($total_purchases){
    // creating the array according to need of barchart 
    foreach ($total_purchases as $key => $purchases) {
        $top_earned_charities[++$key] = [$purchases->charity_name,(float) $purchases->purchase];    
    }
}

$top_earned_charities = json_encode($top_earned_charities);
?>

<div class="row">
    <div class="col-md-12">
        <h5>Top earned charities of {{date('Y')}}</h5>
        <div id="top_charities_chart_div" ></div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStacked);


        function drawStacked() {
            var data = google.visualization.arrayToDataTable(
                {!!  $top_earned_charities !!} // assign the data here 
            );

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
                bar: {groupWidth: '100%'},
                legend: {position: 'top'},
                colors: ['green'],
                // is3D:true

            };
            var chart = new google.visualization.BarChart(document.getElementById('top_charities_chart_div'));
            chart.draw(data, options);
        }
    </script>
@endsection