{{-- Show field, colum names as tags for selection --}}
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
<script type="text/javascript">
    $("textarea[name=fields_csv], textarea[name=columns_to_show_csv]").select2({
        tags: <?php echo(tagsForView(dbTable($data_source)))?>,
        tokenSeparators: [',']
    });
    $("textarea[name=column_aliases_csv]").select2({
        tags: [],
        tokenSeparators: [',']
    });
    $("textarea[name=fields_csv]").select2("container").find("ul.select2-choices").sortable({
        start: function() { $("textarea[name=fields_csv]").select2("onSortStart"); },
        update: function() { $("textarea[name=fields_csv]").select2("onSortEnd"); }
    });
    $("textarea[name=columns_to_show_csv]").select2("container").find("ul.select2-choices").sortable({
        start: function() { $("textarea[name=columns_to_show_csv]").select2("onSortStart"); },
        update: function() { $("textarea[name=columns_to_show_csv]").select2("onSortEnd"); }
    });

    $("textarea[name=column_aliases_csv]").select2("container").find("ul.select2-choices").sortable({
        start: function() { $("textarea[name=column_aliases_csv]").select2("onSortStart"); },
        update: function() {$("textarea[name=column_aliases_csv]").select2("onSortEnd"); }
    });
</script>