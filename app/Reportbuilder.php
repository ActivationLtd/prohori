<?php
namespace App;

use Request;
use DB;
use View;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\JsonResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/**
 * Class Reportbuilder
 * This class is the base class for the report(data viewer creation). The functionality of data-viewer
 * largely depends on the Input parameters passed to the route. The parameters are used as configurations
 * to create a report and show certain columns.
 */
class Reportbuilder
{
    /**
     * Sample code for report building
     * @return bool|JsonResponse|\Illuminate\View\View
     */
    public static function report() {

        /** @var string $data_source SQL view/table full name */
        $data_source = DB::getTablePrefix() . 'divisions'; // Define data source

        /** @var  $result_path  Define path to results view */
        $result_path = "modulebase.report.results"; // Define result path

        if (Request::has('submit') && Request::get('submit') == 'Run') {

            /** @var string $fields_csv_esc Select fields enclosed in escape character (`) */
            $fields_csv_esc = Reportbuilder::fieldsEscCsvPG(Reportbuilder::fields());

            /** @var array $data_source_fields Fields of data source (SQL table, view) */
            $data_source_fields = Reportbuilder::dataSourceFields($data_source);

            /***********************************************
             * Customize : Over-ride this custom query builder for
             * handling special fields. i.e. date range etc.
             ***********************************************/
            /** @var string $filters SQL where clause */
            $filters = Reportbuilder::sqlFiltersFromInputs($data_source_fields); // Custom filter logic

            /***************************************************************************/
            // Based on currently logged in user type further narrow down the query
            // by adding tenant context or facility context.
            /***************************************************************************/
            if ($user = user()) {
                if (userTenantId() && in_array(tenantIdField(), $data_source_fields)) {
                    $filters .= " AND public." . tenantIdField() . "='" . userTenantId() . "' ";
                }
            }
            /***********************************************/

            /** @var string $group_by Group By string */
            $group_by = Reportbuilder::groupBy();

            /***********************************************
             * Customize : Over-ride this for cases where more fields are required to show. i.e. male, female count in
             * sanctioned post report.
             ***********************************************/
            // Add count field (Total) to select fields.
            if (strlen(trim($group_by))) $fields_csv_esc .= " , count(*) AS 'total' ";

            /***************************************************************************/
            // Result
            /***************************************************************************/
            /** @var array $ret compact('results', 'sql', 'total', 'pagination')
             * adds additional_query to the filters */
            $ret = Reportbuilder::query($data_source, $fields_csv_esc, $filters, $group_by);

            /***************************************************************************/
            // Output
            /***************************************************************************/
            return Reportbuilder::render($ret, $result_path); // Show results

        } else {
            return View::make($result_path);
        }
    }
    // public static function reportDownloadExcel($results, $total) {
    //     //taking all the fields that will be shown in data viewer
    //     $columns_to_show = arrayFromCsv(Input::get('columns_to_show_csv'));
    //     //blank array
    //     $final_result = [];
    //     //initial index=0;
    //     $var = 0;
    //     foreach ($results as $result) {
    //         foreach ($columns_to_show as $col) {
    //             //setting data to new array
    //             $final_result[$var][] = $result->$col;
    //         }
    //         if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by')))) {
    //             //if group by then additional data will be added
    //             $final_result[$var][] = number_format($result->total);
    //         }
    //         $var = $var + 1;
    //     }
    //
    //     Excel::create("Report-" . Input::get('report_name'), function ($excel) use ($final_result, $total) {
    //         /** @var \Maatwebsite\Excel\Writers\LaravelExcelWriter $excel */
    //         $excel->setTitle("Report-" . Input::get('report_name')); // Set excel title
    //         $excel->sheet('Report', function ($sheet) use ($final_result, $total) {
    //
    //             // prepare column to put in first row of excel A1
    //             $columns = arrayFromCsv(Input::get('column_aliases_csv'));
    //             if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by')))) {
    //                 $columns = array_merge($columns, ['Total ']); // for grouped result we need to show these additional columns
    //                 $column_size = count($columns);
    //                 for ($i = 0; $i < $column_size; $i++) {
    //                     $total_result[$i] = '';
    //                 }
    //                 $total_result[$column_size - 2] = 'Total ';
    //                 $total_result[$column_size - 1] = $total;
    //                 $excel_row_number = count($final_result) + 2; // find next row where content will be written
    //                 /** @var \Maatwebsite\Excel\Classes\LaravelExcelWorksheet $sheet */
    //                 $sheet->row($excel_row_number, $total_result); // put the content of array in first row 1
    //             }
    //             $sheet->row(1, $columns); // put the content of array in first row 1
    //             // prepare table body
    //             $results = json_decode(json_encode($final_result), true); // convert obejct to array
    //             $data = $results;
    //             $sheet->fromArray($data, null, 'A2', false, false);
    //         });
    //     })->export('csv');
    //
    //     return true;
    // }
    /**
     * Report excel download as xlsx
     * @param $results
     * @param $total
     */
    public static function reportDownloadExcel($results, $total) {
        //taking all the fields that will be shown in data viewer
        $columns_to_show = arrayFromCsv(Request::get('columns_to_show_csv'));
        //blank array
        $final_result = [];
        //initial index=0;
        $var = $i = 0;
        foreach ($results as $result) {
            foreach ($columns_to_show as $col) {
                //setting data to new array
                $final_result[$var][] = $result->$col;
            }
            if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by')))) {
                //if group by then additional data will be added
                $final_result[$var][] = number_format($result->total);
            }
            $var = $var + 1;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $ranges = range("A", "Z");//range of excel sheet
        $columns = arrayFromCsv(Request::get('column_aliases_csv'));
        foreach ($columns as $column) {
            // put the column aliases in excel A1,B1,C1..
            $sheet->setCellValue($ranges[$i] . 1, $column);
            $i++;
        }
        $j = 2;//for starting from A2
        foreach ($final_result as $result) {
            foreach ($result as $k => $v) {
                // put the contents in excel starting from A2
                $sheet->setCellValue($ranges[$k] . $j, $v);
            }
            $j++;
        }
        if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by')))) {
            $sheet->setCellValue($ranges[$k] . 1, 'Total'); //additional column will be added for group_by results
            $index = $k - 1;
            $number = $j + 2;
            $sheet->setCellValue($ranges[$index] . $number, 'Total');//label for total results at the bottom of results
            $sheet->setCellValue($ranges[$k] . $number, $total);//put the total result
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Report-' . Request::get('report_name') . '.xlsx';
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $writer->save('php://output');
    }

    /**
     * Function to get all the fields of the data source as array
     * @param $data_source sql-view/table name
     * @return array
     */
    public static function dataSourceFields($data_source) {
        return columsOfTable($data_source);
    }

    /**
     * Function to get all SELECT fields as array.
     * These are fields that will be injected in "SQL SELECT field1, field2, .. ".
     * This fields are passed as url parameter as plain CSV. However they can not be used
     * directly to create the SQL query because certain SQL escape character needs to be
     * added to enclose each field so that we don't run into issues if a field name is same
     * as SQL reserved word i.e. order.
     *
     * @return array|bool
     */
    public static function fields() {
        if (Request::has('fields_csv') && strlen(cleanCsv(Request::get('fields_csv')))) {
            $fields_csv = cleanCsv(Request::get('fields_csv'));
            $fields = arrayFromCsv($fields_csv);

            return $fields;
        }
        return false;
    }

    /**
     * for pgsql each fields have to called in this syntax 'tablename'.'fieldname'
     * this function appends table name to the fields that are given in the parameter.
     * @param $table_name
     * @return array|bool
     */
    public static function fieldsPG($table_name){
        if (Request::has('fields_csv') && strlen(cleanCsv(Request::get('fields_csv')))) {
            $fields_csv = cleanCsv(Request::get('fields_csv'));

            $fields = arrayFromCsv($fields_csv);
            foreach($fields as $field){
                $fields_pg[]='public'.'.'.$table_name.'.'.$field;

            }
            return $fields_pg;
        }
        return false;

    }
    /**
     * Function to add Escape character(`) to SELECT fields
     * Take an array of field names and create a new CSV string with SQL escape character(`).
     * This will be directly embedded in the SQL SELECT ...
     *
     * @param array $fields
     * @return bool|string
     */
    public static function fieldsEscCsv($fields = []) {
        return "`" . implode("`,`", $fields) . "`";
    }

    /**
     * Function to add Escape character(`) to SELECT fields
     * Take an array of field names and create a new CSV string with SQL escape character(`).
     * This will be directly embedded in the SQL SELECT ...
     *
     * @param array $fields
     * @return bool|string
     */
    public static function fieldsEscCsvPG($fields = []) {
        return   implode(",", $fields) ;
    }

    /**
     * Function to get the columns that will be finally rendered and also validate.
     * Though many fields can be included in SQL SELECT, a subset of them will be used to
     * show in the result. These fields must be a Subset.
     *
     * @param $data_source_fields Validate against this array
     * @param $fields             Validate against this array
     * @return array|bool
     */
    public static function columnsToShow($data_source_fields, $fields) {

        $columns_to_show = null;
        $valid = false;

        if (Request::has('columns_to_show_csv') && strlen(cleanCsv(Request::get('columns_to_show_csv')))) {
            $valid = true;
            $columns_to_show = arrayFromCsv(cleanCsv(Request::get('columns_to_show_csv'))); // convert csv to array
            foreach ($columns_to_show as $column) { // find any column that is not available in SQL view/table
                if (!in_array($column, $data_source_fields)) { // 1. check if all colums are available in SQL view/table,
                    $valid = setError("$column - column missing in view/table ");
                }
                if (!in_array($column, $fields)) { // 2. check if any colum that is supposed
                    $valid = setError("$column - column missing in SQL 'SELECT ... ' ");
                }
            }
        }
        return $valid ? $columns_to_show : false;
    }

    /**
     * Function to generate an array of column titles from CSV passed as URL parameter.
     * @return array|bool
     */
    public static function columnAliases() {
        if (Request::has('column_aliases_csv') && strlen(cleanCsv(Request::get('column_aliases_csv')))) {
            $column_aliases = arrayFromCsv(Request::get('column_aliases_csv'));
            return $column_aliases;
        }
        return false;
    }

    /**
     * Function to construct the SQL GROUP BY clause from passed URL parameter.
     * This is later used in the final SQL
     * Query.
     * @return string
     */
    public static function groupBy() {
        $group_by = "";
        if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by')))) {
            $group_by = " GROUP BY  " . trim(Request::get('group_by', ", "));
        }
        return $group_by;
    }

    /**
     * Function to construct the SQL GROUP BY clause from passed URL parameter.
     * This is later used in the final SQL
     * Query.
     * the syntax for pg sql requires 'schema_name'.'tablename'.Group by
     * this functions appens "public".tablename before Group by statment
     * @param $table_name
     * @return string
     */
    public static function groupByPG($table_name) {
        $group_by = "";
        if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by')))) {
            $group_by = " GROUP BY  \"public\"." .$table_name.'.'. trim(Request::get('group_by', ", "));
        }
        return $group_by;
    }

    /**
     * Function to construct the SQL ORDER BY clause from passed URL parameter.
     * This is later used in the final SQL Query.
     * @return string
     */
    public static function orderBy() {
        $order_by = "";
        if (Request::has('order_by') && strlen(cleanCsv(Request::get('order_by')))) {
            $order_by = " ORDER BY " . Request::get('order_by');
        }
        return $order_by;
    }
    /**
     * Function to construct the ORDER BY clause from passed URL parameter.
     * This is later used in the final SQL
     * Query.
     * the syntax for pg sql requires 'schema_name'.'tablename'.Order by
     * this functions appens "public".tablename before Order by statment
     * @param $table_name
     * @return string
     */
    public static function orderByPG($table_name) {
        $order_by = "";
        if (Request::has('order_by') && strlen(cleanCsv(Request::get('order_by')))) {
            $order_by = " ORDER BY  \"public\"." .$table_name.'.'. Request::get('order_by');
        }
        return $order_by;
    }

    /**
     * Function to construct the SQL LIMIT BY clause from passed URL parameter.
     * This is later used in the final SQL Query and pagination.
     * This is generated when
     * - rows_per_page os given in input param.
     * - Don't use limit for excel and print view. Show the whole report for these two cases.
     * @return string
     */
    public static function limit() {
        $limit = '';
        if ((Request::has('rows_per_page') && strlen(trim(Request::get('rows_per_page'))))) {
            if (Request::get('ret') != 'excel' && Request::get('view') != 'print') {
                $rows_per_page = trim(Request::get('rows_per_page'));
                $page = 1;
                if (Request::has('page')) {
                    $page = Request::get('page');
                }
                $offset = ($page - 1) * $rows_per_page;
                $limit = " LIMIT $offset,$rows_per_page ";
            }
        }

        return $limit;
    }
    /**
     * Function to construct the SQL LIMIT BY clause from passed URL parameter.
     * This is later used in the final SQL Query and pagination.
     * This is generated when
     * - Don't use limit for excel and print view. Show the whole report for these two cases.
     * the syntax for pgsql is LIMIT "Input Number"
     * @return string
     */
    public static function limitPG() {
        $limit = '';
        if ((Request::has('limit') && strlen(trim(Request::get('limit'))))) {
            if (Request::get('ret') != 'excel' && Request::get('view') != 'print') {
                $limit=Request::get('limit');
                $limit = " LIMIT $limit";
            }
        }

        return $limit;
    }

    /**
     * Function to create the SQL WHERE statement Based on input parameters. For many cases custom query
     * generation is required where a straight forward approach of field = value, field IN (values_csv)
     * may not be useful. For example when we are dealing with a date range in input param we need to
     * check for greater than or equal to to certain date in query string. This is the function that
     * is where we write all sorts of query customization.
     *
     * @param array $data_source_fields
     * @return string
     */
    public static function sqlFiltersFromInputs($data_source_fields = []) {
        $filters = "";
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $data_source_fields)) {    // user filters(parameters) that exactly match the name with a column name of view/table. Discard other inputs/url params.
                /*********************************************/
                // If a field exists in the data source and you want to skip generic
                // processing of that field then write it under an 'if' block
                // and re-write the generic processing block under 'elseif'
                /*********************************************/
                /*
                    if ($name == 'some_name'  && strlen(trim($val))) {
                        $filter .= " AND $name = '$val' ";
                        continue; // This will skip the lines below and go to next input.
                    }
                */
                /*********************************************/
                // Generic processing block
                /*********************************************/
                $filters .= Reportbuilder::genericFilter($name, $val);

            }
            // If a field does not exists in data source and yet you want to
            // process it then write here.
            /*********************************************/
            /*if ($name == 'some_name' && strlen(trim($val))) {
               $filter .= " AND $name = '$val' ";
               continue;
           }*/
        }

        return " $filters ";

    }
    /**
     * Function to create the SQL WHERE statement Based on input parameters. For many cases custom query
     * generation is required where a straight forward approach of field = value, field IN (values_csv)
     * may not be useful. For example when we are dealing with a date range in input param we need to
     * check for greater than or equal to to certain date in query string. This is the function that
     * is where we write all sorts of query customization.
     *
     * @param array $data_source_fields
     * @return string
     */
    public static function sqlFiltersFromInputsPG($data_source_fields = [],$table_name) {
        $filters = "";
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $data_source_fields)) {    // user filters(parameters) that exactly match the name with a column name of view/table. Discard other inputs/url params.
                /*********************************************/
                // If a field exists in the data source and you want to skip generic
                // processing of that field then write it under an 'if' block
                // and re-write the generic processing block under 'elseif'
                /*********************************************/
                /*
                    if ($name == 'some_name'  && strlen(trim($val))) {
                        $filter .= " AND $name = '$val' ";
                        continue; // This will skip the lines below and go to next input.
                    }
                */
                /*********************************************/
                // Generic processing block
                /*********************************************/
                $filters .= Reportbuilder::genericFilterPG($name, $val,$table_name);

            }
            // If a field does not exists in data source and yet you want to
            // process it then write here.
            /*********************************************/
            /*if ($name == 'some_name' && strlen(trim($val))) {
               $filter .= " AND $name = '$val' ";
               continue;
           }*/
        }

        return " $filters ";

    }


    /**
     * Adds additional_sql_select based on input param.
     * Adds tenant context in SQL query.
     * @return string
     */
    public static function additionalSqlFilters() {
        $filters = "";
        /***************************************************************************/
        // Get additional_sql_select. This is appended after the generated SELECT statement
        /***************************************************************************/
        $additional_sql_select = "";
        if (Request::has('additional_sql_select') && strlen(trim(Request::get('additional_sql_select')))) {
            $additional_sql_select = " AND (" . trim(Request::get('additional_sql_select') . ") ");
        }
        $filters .= $additional_sql_select;

        return " $filters ";

    }

    /**
     * Adds additional_sql_select based on input param.
     * Adds tenant context in SQL query.
     * for pgsql syntax is schema name table name field name
     * * example "public".settings."id"
     * example
     * @param $table_name
     * @return string
     */
    public static function additionalSqlFiltersPG($table_name) {
        $filters = "";
        /***************************************************************************/
        // Get additional_sql_select. This is appended after the generated SELECT statement
        /***************************************************************************/
        $additional_sql_select = "";
        if (Request::has('additional_sql_select') && strlen(trim(Request::get('additional_sql_select')))) {
            $additional_sql_select = " AND ( \"public\"." .$table_name.'.'.trim(Request::get('additional_sql_select') . ") ");
        }
        $filters .= $additional_sql_select;

        return " $filters ";

    }

    /**
     * For each input parameter (name-value pair) creates a standard SQL match string. This works for standard
     * matching but for custom logic i.e. date range or other exceptions should be handled inside sqlFiltersFromInputs
     * @param $name
     * @param $val
     * @return string
     */
    public static function genericFilter($name, $val) {
        $filters = "";
        if (is_array($val) && count($val)) {    // handle if input is an array
            $temp = removeEmptyVals($val);
            if (count($temp)) $filters .= " AND $name IN('" . implode("','", $temp) . "') ";
        } else if (strlen($val) && strstr($val, ',')) {  // handle if input is a plain csv
            $filters .= " AND $name IN('" . str_replace(',', "','", trim($val, ", ")) . "') ";
        } else if (strlen($val)) {// handles if input is simple name-value pair
            $filters .= " AND $name = '$val' ";
        }
        return " $filters ";
    }

    /**
     * For each input parameter (name-value pair) creates a standard SQL match string. This works for standard
     * matching but for custom logic i.e. date range or other exceptions should be handled inside sqlFiltersFromInputs
     * for pgsql syntax added schema name table name before field name.
     * example "public".settings."id"
     * @param $name
     * @param $val
     * @param $table_name
     * @return string
     */

    public static function genericFilterPG($name, $val,$table_name) {
        $filters = "";
        if (is_array($val) && count($val)) {    // handle if input is an array
            $temp = removeEmptyVals($val);
            if (count($temp)) $filters .= " AND \"public\".$table_name.\"$name\" IN('" . implode("','", $temp) . "') ";
        } else if (strlen($val) && strstr($val, ',')) {  // handle if input is a plain csv
            $filters .= " AND \"public\".$table_name.\"$name\" IN('" . str_replace(',', "','", trim($val, ", ")) . "') ";
        } else if (strlen($val)) {// handles if input is simple name-value pair
            $filters .= " AND \"public\".$table_name.\"$name\" = '$val' ";
        }
        return " $filters ";
    }

    /**
     * Report outputs - Json, Excel, Web-based data viewer.
     * @param $ret
     * @param $result_path
     * @return bool|JsonResponse|\Illuminate\View\View
     */
    public static function render($ret, $result_path) {
        if (Request::get('ret') == 'json') {
            $return = Response::json($ret);
        } else if (Request::get('ret') == 'excel') {
            $return = Reportbuilder::reportDownloadExcel($ret['results'], $ret['total']);
        } else {
            /***************************************************************************/
            // Render result in page
            /***************************************************************************/
            // Once you have determined the location of the result.blade.php in the same directory place another files
            // result-print.blade.php to generate the printable version of the result.
            if (Request::get('view') == 'print' && View::exists($result_path . '-print')) {
                $return = View::make($result_path . '-print')->with($ret);
            } else {
                $return = view($result_path)->with($ret);
            }
        }

        return $return;

    }

    /**
     * Custom pagination system for an array of data
     * Laravel 5.7 uses basic pagination ofr a collection of objects so it could not be used here
     * so I wrote a new pagination system for reporting
     * @param array $results
     * @param $number_of_results
     * @return LengthAwarePaginator
     */
    public static function paginationPG($results=[],$number_of_results){
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($results);

        // Define how many items we want to be visible in each page
        $perPage = $number_of_results;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath(Request::fullUrl());

        return $paginatedItems;
    }

    /**
     * Function for validating fields, columns_to_show and column_aliases.
     *
     * These values are passed as CSV through input/URL param. We need to check if columns_to_show has same
     * number of items as column_aliases. And columns_to_show is a subset of fields.
     * @param $data_source_fields
     * @return bool|string
     */
    public static function validateFields($data_source_fields) {
        $valid = true;
        if ($fields = Reportbuilder::fields()) {
            if ($columns_to_show = Reportbuilder::columnsToShow($data_source_fields, $fields)) {
                if ($column_aliases = Reportbuilder::columnAliases()) {
                    if (count($columns_to_show) != count($column_aliases)) {
                        $valid = setError("Count of columns(" . count($columns_to_show) . ") and column 
                            aliases must be same(" . count($column_aliases) . ").");
                    }
                } else {
                    $valid = setError("Error: Reportbuilder::columnAliases() ");
                }
            } else {
                $valid = setError("Error: Reportbuilder::columnsToShow");
            }
        } else {
            $valid = setError("Incorrect/Missing Fields (fields_csv) Error:Reportbuilder::fields()");
        }

        return $valid ? Reportbuilder::fieldsEscCsv($fields) : false;
    }

    /**
     * Function for final SQL query constructor
     *
     * @param $data_source
     * @param $fields_csv_esc
     * @param $filters
     * @param $group_by
     * @return array|bool
     */
    public static function query($data_source, $fields_csv_esc, $filters, $group_by, $cache_time = 10) {
        if (Reportbuilder::validateFields(Reportbuilder::dataSourceFields($data_source))) {
            /***************************************************************************/
            // Add additional_sql_query to filter statement.
            /***************************************************************************/
            $filters .= Reportbuilder::additionalSqlFiltersPG($data_source);
            /***************************************************************************/
            // Get order_by SQL clause
            /***************************************************************************/
            $order_by = Reportbuilder::orderByPG($data_source);
            /***************************************************************************/
            // Limit pagination
            /***************************************************************************/
            $rows_per_page = $limit = null;
            if (!strlen(trim($group_by))) {
                $rows_per_page = trim(Request::get('rows_per_page'));
                $limit = Reportbuilder::limitPG();
            }

            // get total count of the full result.
            $sqlCount = cleanStrNTS("SELECT Count(*) AS total FROM \"public\".$data_source "); // construct SQL and remove new line, tab etc from it
            $total = resultFirst($sqlCount, $cache_time)->total;
            // get paginated results only
            $sql = cleanStrNTS("SELECT $fields_csv_esc FROM \"public\".$data_source WHERE 1=1 $filters $group_by $order_by $limit "); // construct SQL and remove new line, tab etc from it
            $results = result($sql, $cache_time); //cacheTime('reports')


            // if no rows_per_page is set by user it means there will be no pagination and
            // all the results will be shown in one(first) page
            if (!$rows_per_page) $rows_per_page = $total ? $total : 1;
            $results=Reportbuilder::paginationPG($results,$rows_per_page);
            //$pagination = Paginator::make($results, $total, $rows_per_page); // call the laravel default Paginator class
            return compact('results', 'sql', 'total','paginations');
        }
        return false;
    }
    /**
     * Sample of an old report where everything was handled in the same function.
     * SanctionedpostsController.php
     * @return \Illuminate\View\View|void
     */
    public function oldReport() {
        $module_sys_name = $this->module_name;
        # Report source table/view
        if (!$this->report_data_source) { // If no source(view/table) is set in Module controller set the default table.
            $this->report_data_source = DB::getTablePrefix() . $this->module_name;
        }
        //$sql_view = DB::getTablePrefix() . $module_sys_name; // SQL table/view name that joins necessary tables to generate the report.
        $sql_view = $this->report_data_source;
        $results = $sql = $columns = $column_aliases = $fields_array = $fields_csv = $post_stat = $user = $limit = $count = $rows_per_page = $total = $columns_to_show_array = null; // by default set null to results

        if (Request::has('submit') && Request::get('submit') == 'Run') { // process parameters for SQL only on Submit

            $sql_view_fields = columsOfTable($sql_view); // get all  available field names from SQL view/table
            $valid = true;    // flag to determine if a request(set or parameters) is valid for generating a report. If not valied then don't run SQL query.

            /***************************************************************************/
            //  Set the SQL select fields, these fields will be pulled for report and
            // 	values will be available in report view. But all fields may not show in view.
            /***************************************************************************/
            if (Request::has('fields_csv') && strlen(cleanCsv(Request::get('fields_csv')))) {
                $fields_csv = cleanCsv(Request::get('fields_csv'));
                $fields_array = arrayFromCsv($fields_csv);
            } else {
                $valid = setError("Incorrect/Missing Fields (fields_csv)");
            }
            /***************************************************************************/
            // Among the selected fields above we may want to show some of them in report output.
            // 1. check if all colums are available in SQL view/table, 2. check if any colum that is supposed
            // to show in view has not been included in SQL select (see above)
            /***************************************************************************/

            if (Request::has('columns_to_show_csv') && strlen(cleanCsv(Request::get('columns_to_show_csv')))) {
                $columns_to_show_csv = cleanCsv(Request::get('columns_to_show_csv'));
                $columns_to_show_array = arrayFromCsv($columns_to_show_csv); // convert csv to array
                foreach ($columns_to_show_array as $column) { // find any column that is not available in SQL view/table
                    if (!in_array($column, $sql_view_fields)) { // 1. check if all colums are available in SQL view/table,
                        $valid = setError("$column - column missing in view/table ($sql_view) ");
                    }
                    if (!in_array($column, $fields_array)) { // 2. check if any colum that is supposed
                        $valid = setError("$column - column missing in SQL 'SELECT $fields_csv... ' ");
                    }
                }
            }
            // check if colums and aliases have exact number match
            if (Request::has('column_aliases_csv') && strlen(cleanCsv(Request::get('column_aliases_csv')))) {
                $column_aliases_array = arrayFromCsv(Request::get('column_aliases_csv'));
                if (count($columns_to_show_array) != count($column_aliases_array)) {
                    $valid = setError("Count of columns(" . count($columns_to_show_array) . ") and column aliases must be same(" . count($column_aliases_array) . ").");
                }
            }
            /***************************************************************************/
            // Get group_by from input and additional colums for male,female,vacant etc..
            /***************************************************************************/
            $group_by = "";
            if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by')))) {
                $group_by = " GROUP BY " . trim(Request::get('group_by', ", "));
                $fillup_cal = "count(*) AS 'total',
				(SUM(IF(p_sex_name = 'Male', 1, 0)) +
				SUM(IF (p_sex_name = 'Female', 1, 0)) +
				SUM(IF(p_sex_name = 'Other', 1, 0)) +
				SUM(IF (p_sex_name = 'Trans gender',1,0))) AS filled,
				SUM(IF(p_sex_name = 'Male', 1, 0)) AS filled_male,
				SUM(IF (p_sex_name = 'Female', 1, 0)) AS filled_female,
				SUM(IF(p_sex_name = 'Other', 1, 0)) AS filled_other,
				SUM(IF(p_sex_name = 'Trans gender',1,0)) AS 'filled_transgender',
				(count(*) -(
					SUM(IF(p_sex_name = 'Male', 1, 0)) +
					SUM(IF (p_sex_name = 'Female', 1, 0)) +
					SUM(IF(p_sex_name = 'Other', 1, 0)) +
					SUM(IF(p_sex_name = 'Trans gender',1,0)))
				) AS vacant,
				TRUNCATE (((count(*) - (
					SUM(IF(p_sex_name = 'Male', 1, 0)) +
					SUM(IF (p_sex_name = 'Female', 1, 0)) +
					SUM(IF(p_sex_name = 'Other', 1, 0)) +
					SUM(IF (p_sex_name = 'Trans gender',1,0))
					)
				) / count(*) * 100.00),2)
				 AS 'vacantpercent' ";
                $fields_csv .= " , " . $fillup_cal;
            }

            /***************************************************************************/
            // Process filter inputs and append to where clause
            /***************************************************************************/
            $filter = "";
            foreach (Request::all() as $name => $val) {
                if (in_array($name, $sql_view_fields)) {    // user filters(parameters) that exactly match the name with a column name of view/table. Discard other inputs/url params.
                    /*********************************************/
                    // If a field exists in the data source and you want to skip generic
                    // processing of that field then write it under an 'if' block
                    // and re-write the generic processing block under 'elseif'
                    /*********************************************/
                    /*
                        if ($name == 'some_name'  && strlen(trim($val))) {
                            $filter .= " AND $name = '$val' ";
                            continue; // This will skip the lines below and go to next input.
                        }
                    */

                    /*********************************************/
                    // Generic processing block
                    /*********************************************/
                    if (is_array($val) && count($val)) {    // handle if input is an array
                        $temp = removeEmptyVals($val);
                        if (count($temp)) $filter .= " AND $name IN('" . implode("','", $temp) . "') ";
                    } else if (strlen($val) && strstr($val, ',')) {  // handle if input is a plain csv
                        $filter .= " AND $name IN('" . str_replace(',', "','", trim($val, ", ")) . "') ";
                    } else if (strlen($val)) {// handles if input is simple name-value pair
                        $filter .= " AND $name = '$val' ";
                    }
                }
                // If a field does not exists in data source and yet you want to
                // process it then write here.
                /*********************************************/
                /*if ($name == 'some_name' && strlen(trim($val))) {
                   $filter .= " AND $name = '$val' ";
                   continue;
               }*/
                // acr_year
                if ($name == 'acr_year' && strlen(trim($val))) {
                    $filter .= " AND p_acr_year LIKE '%" . trim($val) . "%' ";
                    continue;
                }
                /* SQL query to check retirement_date range*/
                if ($name == 'retirement_date_start' && strlen(trim($val))) {
                    $filter .= " AND p_prl_start_date >= '$val' ";
                    continue;
                }
                if ($name == 'retirement_date_to' && strlen(trim($val))) {
                    $filter .= " AND p_prl_start_date <= '$val' ";
                    continue;
                }
                /* SQL query to check joining date in govt health service range*/
                if ($name == 'joining_date_govt_health_service_from' && strlen(trim($val))) {
                    $filter .= " AND p_joining_date_govt_health_service >= '$val' ";
                    continue;
                }
                if ($name == 'joining_date_govt_health_service_to' && strlen(trim($val))) {
                    $filter .= " AND p_joining_date_govt_health_service <= '$val' ";
                    continue;
                }
            }
            /***************************************************************************/
            // Based on currently logged in user type further narrow down the query
            /***************************************************************************/
            // Tenant context injection
            if (userTenantId()) {
                $filter .= " AND " . tenantIdField() . "='" . userTenantId() . "'";
            }

            /***************************************************************************/
            // Get additional_sql_select. This is appended after the generated SELECT statement
            /***************************************************************************/
            $additional_sql_select = "";
            if (Request::has('additional_sql_select') && strlen(trim(Request::get('additional_sql_select')))) {
                $additional_sql_select = " AND (" . trim(Request::get('additional_sql_select') . ") ");
                $filter .= $additional_sql_select;
            }

            /***************************************************************************/
            // Get order_by
            /***************************************************************************/
            $order_by = "";
            if (Request::has('order_by') && strlen(cleanCsv(Request::get('order_by')))) {
                $order_by = " ORDER BY " . Request::get('order_by');
            }

            /***************************************************************************/
            // pagination
            /***************************************************************************/

            if (!$group_by && (Request::has('rows_per_page') && strlen(trim(Request::get('rows_per_page')))) && Request::get('ret') != 'excel') {
                if (Request::get('view') != 'print') {
                    $rows_per_page = trim(Request::get('rows_per_page'));
                    $page = 1;
                    if (Request::has('page')) {
                        $page = Request::get('page');
                    }
                    $offset = ($page - 1) * $rows_per_page;
                    $limit = " LIMIT $offset,$rows_per_page ";
                }
            }

            /***************************************************************************/
            // if valid then run query
            /***************************************************************************/
            if ($valid) {
                if (strlen($group_by)) {
                    $post_stat = postStat($filter);
                }
                // get total count of the full result.
                $sqlCount = cleanStrNTS("SELECT count(*) AS total FROM $sql_view WHERE 1 $filter $additional_sql_select "); // construct SQL and remove new line, tab etc from it
                $total = result($sqlCount, $timeout = 10)[0]->total;

                // get paginated results only
                $sql = cleanStrNTS("SELECT $fields_csv FROM $sql_view WHERE 1 $filter $additional_sql_select $group_by $order_by $limit"); // construct SQL and remove new line, tab etc from it
                $results = result($sql, $timeout = 10); //cacheTime('reports')

                if (!$rows_per_page) {
                    if ($total) $rows_per_page = $total;
                    // if no rows_per_page is set by user it means there will be no pagination and
                    // all the results will be shown in one(first) page
                    else $rows_per_page = 1; // this is a default value to make pagination work in the case of zero result.
                }
                $pagination = Paginator::make($results, $total, $rows_per_page); // call the laravel default Paginator class
            }
        }

        /***************************************************************************/
        // JSON/Excel output
        /***************************************************************************/
        $ret = compact('results', 'sql', 'post_stat', 'total', 'pagination');
        if (Request::get('ret') == 'json') {
            return Response::json($ret);
        } else if (Request::get('ret') == 'excel') {
            return Sanctionedpost::reportDownloadExcel($results, $post_stat, $total);
        }

        /***************************************************************************/
        // Render result in page
        /***************************************************************************/
        // Determine which result.blade.php to load.
        // 1. By default load "modulebase.report.results"
        $result_path = "modulebase.report.results";

        // 2. Override default if a module specific report blade exists in location  "{module_name}.report.result"
        $module_report_view_path = $module_sys_name . ".report.results";
        if (View::exists($module_report_view_path)) $result_path = $module_report_view_path;

        // 3. Again override if a tenant specific result blade exists in "{module_name}.{tenant_id.}report.result"
        if (userTenantId()) {
            $tenant_report_view_path = $module_sys_name . "." . userTenantId() . ".report.results";
            if (View::exists($tenant_report_view_path)) $result_path = $tenant_report_view_path;
        }

        // Once you have determined the location of the result.blade.php in the same directory place another files
        // result-print.blade.php to generate the printable version of the result.
        if (Request::get('view') == 'print' && View::exists($result_path . '-print')) {
            return View::make($result_path . '-print')->with($ret);
        }

        return View::make($result_path)->with($ret);
    }
}