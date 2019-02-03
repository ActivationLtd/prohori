@section('style')
    @parent
    <style>
        #tab_advanced .select2-container-multi .select2-choices .select2-search-choice {
            width: 100%;
        }
    </style>
@endsection

{{--@include('form.textarea', array('name'=>'fields_csv','label'=>"Select columns",'class'=>'tags'))--}}
@include('form.textarea',['var'=>['name'=>'fields_csv','label'=>'Select columns', ['params'=>['class'=>'tag']],'container_class'=>'col-md-2']])

{{--@include('form.textarea', array('name'=>'columns_to_show_csv','label'=>'Visible columns','class'=>'tags'))--}}
@include('form.textarea',['var'=>['name'=>'columns_to_show_csv','label'=>'Visible columns', ['params'=>['class'=>'tag']],'container_class'=>'col-md-2']])

{{--@include('form.textarea', array('name'=>'column_aliases_csv','label'=>'Column aliases','class'=>'tags'))--}}
@include('form.textarea',['var'=>['name'=>'column_aliases_csv','label'=>'Column aliases', ['params'=>['class'=>'tag']],'container_class'=>'col-md-2']])


{{--@include('form.textarea', array('name'=>'additional_sql_select','label'=>'Additional SQL WHERE clause','value'=>Request::get('additional_sql_select')))--}}
@include('form.textarea',['var'=>['name'=>'additional_sql_select','label'=>'Additional SQL WHERE clause','value'=>Request::get('additional_sql_select'),'container_class'=>'col-md-2']])


{{--@include('form.text', array('name'=>'group_by','label'=>'SQL GROUP BY','value'=>Request::get('group_by')))--}}
@include('form.input-text',['var'=>['name'=>'group_by','label'=>'SQL GROUP BY','value'=>Request::get('group_by'),'container_class'=>'col-md-2']])

{{--@include('form.text', array('name'=>'order_by','label'=>'SQL ORDER BY','value'=>Request::get('order_by')))--}}
@include('form.input-text',['var'=>['name'=>'order_by','label'=>'SQL ORDER BY','value'=>Request::get('order_by'),'container_class'=>'col-md-2']])


@include('form.select-array',['var'=>['name'=>'rows_per_page','label'=>'Rows per page','options'=>array('10' => '10', '25' => '25', '50' => '50', '100' => '100', '' => 'All'),'container_class'=>'col-md-2']])
{{--@include('form.select_array', array('name'=>'rows_per_page','label'=>'Rows per page', 'options'=>array('10' => '10', '25' => '25', '50' => '50', '100' => '100', '' => 'All') ))--}}

<div class="clearfix"></div>
<div class="col-md-12">
    <h5>Generated SQL query</h5>
    <div class="alert-block">
        <pre class="small">@if(isset($sql)){{$sql}}@endif</pre>
    </div>
    <h5>API URL
        <small>(X-Auth-token based authentication)</small>
    </h5>
    <div class="alert-block">
        <a target="_blank" href="{{genericReportApiUrl()}}">{{genericReportApiUrl()}}</a>
    </div>
    <h5>API URL
        <small>(Reports for any authenticated users)</small>
    </h5>
    <div class="alert-block">
        <a target="_blank" href="{{genericReportJsonUrl()}}">{{genericReportJsonUrl()}}</a>
    </div>
</div>
<div class="clearfix"></div>