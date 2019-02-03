{{-- Show field, colum names as tags for selection --}}
<?php
/*$sql_view = DB::getTablePrefix().'facilities';*/
?>

<script type="text/javascript">
    $("textarea[name=fields_csv], textarea[name=columns_to_show_csv]").select2({
        tags: <?php echo(tagsForView(dbTable($module_name)))?>,
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