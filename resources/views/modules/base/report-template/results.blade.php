@extends('template.report')
<?php
/**
 * @var $data_source                         string Table/DB view name (i.e. v_users, users)
 * @var $sql                                 string SQL query
 * @var $results                             \Illuminate\Pagination\LengthAwarePaginator Main array where rows of results are stored
 * @var $sql_count                           string SQL query
 * @var $total                               integer Total number of rows returned
 * @var $group_by                            string 'GROUP BY col1,col2'
 * @var $order_by                            string
 * @var $limit                               integer
 * @var $rows_per_page                       integer
 * @var $filters                             string
 * @var $column_aliases                      array
 * @var $columns_to_show_csv                 array
 * @var $data_source_fields                  array
 * @var $fields                              array
 * @var $fields_csv_esc                      string
 * @var $base_dir                            string
 * @var $result_blade                        string
 */
?>
@include($base_dir.'.init-functions')

@section('content')
    @include($base_dir.'.filters')
    @if(Request::get('submit')==='Run' && isset($results))
        Total {{$total}} items found.
        <div class="clearfix"></div>
        <div class="table-responsive">
            @if(count($results))
                <table class="table table-condensed" id="report-table">
                    <thead>
                    <tr>
                        @foreach ($column_aliases as $column_alias)
                            <th>{{$column_alias}}</th>
                        @endforeach

                        @if (strlen($group_by))
                            <th>Total</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            @foreach ($columns_to_show as $column)
                                <td>
                                    @if(isset($result->$column))
                                        <?php echo transformRow($column, $result, $result->$column, $data_source)?>
                                    @endif
                                </td>
                            @endforeach
                            {{-- if SQL 'GROUP' is set then post stats (male, female, filled etc) are shown --}}
                            @if (strlen($group_by))
                                <td>{{number_format($result->total)}}</td>
                            @endif
                            {{-- end stat ounts --}}
                        </tr>
                    @endforeach
                    <tr>
                        @if (strlen($group_by))
                            @foreach ($columns_to_show as $column)
                                <td></td>
                            @endforeach
                            <td></td>
                            <td>Total : <b>{{number_format($total)}}</b></td>
                        @endif
                    </tr>
                    </tbody>
                </table>
                <?php echo $results->links();?>
            @endif
        </div>
    @endif
@endsection

@section('js')
    @parent
    @include($base_dir.'.js')
    {{-- Write your JS --}}
@endsection