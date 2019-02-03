<?php
/*
 * Documentation :
 * https://developers.google.com/chart/interactive/docs/gallery/barchart
 */
/* change brands count value from @var $partner_count */
$partner_count = 5;
$top_brands = []; //define blank array 
$top_brands[]= ['Brand', 'Recommendations']; // assign 0 key for barchart 
/* get published brands */
$brands = \App\Partner::where('is_published',1)->get();
$partner_ids = array_column($brands->toArray(), 'id'); // get ids of brands in single dimension array
/* get total recommendations according to brands */
$total_recommendations = \App\RecommendUrl::select('partner_name', DB::raw('count(partner_id) as recommend'))->whereIn('partner_id', $partner_ids)->groupBy('partner_name')->orderBy('recommend','DESC')->take($partner_count)->get();
if($total_recommendations){
    // creating the array according to need of barchart 
    foreach ($total_recommendations as $key => $recommendations) {
        $top_brands[++$key] = [$recommendations->partner_name,$recommendations->recommend];    
    }
}
$top_brands = json_encode($top_brands);
?>

<div class="row">
    <div class="col-md-12">
        <h5>Top recommended brands of {{date('Y')}}</h5>
        <div id="top_brands_chart_div"></div>
    </div>
</div>

@section('js')
    @parent
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStacked);


        function drawStacked() {
            var data = google.visualization.arrayToDataTable(
                {!!  $top_brands !!} // assign the data here 
            );
            var options = {
                // title: 'Population of Largest U.S. Cities',
                chartArea: {width: '50%', height: '80%'},
                // isStacked: true,
                hAxis: {
                    title: 'Recommendations by users',
                    minValue: 0
                },
                vAxis: {
                    title: 'Brands'
                },
                bar: {groupWidth: '100%'},
                legend: {position: 'top'}

            };
            var chart = new google.visualization.BarChart(document.getElementById('top_brands_chart_div'));
            chart.draw(data, options);
        }
    </script>
@endsection