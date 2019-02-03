@extends('template.report')
@include('modules.base.report.init-functions')
@section('content')
    {{-- ---------------------------------------\
    \ Include top filter box
    \------------------------------------------}}
    @include("modules.base.report.filters")
    {{-- ---------------------------------------\
    \ Show search result if submit=run
    \------------------------------------------}}
    @if(Request::get('submit')=='Run' && isset($results))
        Total {{count($results)}} items found.
        <div class="clearfix"></div>
        @if(count($results))
            <table class="table table-condensed" id="report-table">
                <thead>
                <tr>
                    @foreach (arrayFromCsv(Request::get('column_aliases_csv')) as $column_alias)
                        <th>{{$column_alias}}</th>
                    @endforeach
                    {{-- if SQL 'GROUP' is set then post stats (male, female, filled etc) are shown--}}
                    @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                        <th>Total</th>
                    @endif
                    {{-- end stat headings --}}
                </tr>
                </thead>
                <tbody>

                @foreach ($results as $result)
                    <tr>
                        @foreach (arrayFromCsv(Request::get('columns_to_show_csv')) as $column)
                            <td>@if(isset($result->$column))<?php echo transformRow($column,$result,$result->$column,$module_name)?>@endif</td>
                        @endforeach
                        {{-- if SQL 'GROUP' is set then post stats (male, female, filled etc) are shown --}}
                        @if (Request::has('group_by') && strlen(Request::get('group_by')))
                            <td>{{number_format($result->total)}}</td>
                        @endif
                        {{-- end stat ounts --}}
                    </tr>
                @endforeach
                <tr>
                     @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                        @foreach (arrayFromCsv(Request::get('columns_to_show_csv')) as $column)
                            <td></td>
                        @endforeach
                        {{-- if 'SQL GROUP is set then show additional row showing total counts in the last column '--}}
                        @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                                <td></td>
                                <td>Total : <b>{{number_format($total)}}</b></td>
                        @endif
                    @endif
                </tr>
                </tbody>

            </table>
            <?php echo $results->links();?>
        @endif
    @endif
@endsection

@section('js')
    @parent
    @include('modules.base.report.js')
    {{-- if you have any specific JS for this report write it here --}}
@endsection