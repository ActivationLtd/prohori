<?php

namespace App\Http\Classes;

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
        $result_path = "modules.base.report.results"; // Define result path

        if (Input::has('submit') && Input::get('submit') == 'Run') {

            /** @var string $fields_csv_esc Select fields enclosed in escape character (`) */
            $fields_csv_esc = Reportbuilder::fieldsEscCsv(Reportbuilder::fields());

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
                    $filters .= " AND " . tenantIdField() . "='" . userTenantId() . "' ";    // For MySQL
                    // $filters .= " AND " . tenantIdField() . "='" . userTenantId() . "' "; // For PostGre
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

    /**
     * Report excel download
     *
     * @param $results
     * @param $total
     * @return bool
     */
    public static function reportDownloadExcel($results, $total) {
        //taking all the fields that will be shown in data viewer
        $columns_to_show = arrayFromCsv(Input::get('columns_to_show_csv'));
        //blank array
        $final_result = [];
        //initial index=0;
        $var = $i = 0;
        foreach ($results as $result) {
            foreach ($columns_to_show as $col) {
                //setting data to new array
                $final_result[$var][] = $result->$col;
            }
            if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by')))) {
                //if group by then additional data will be added
                $final_result[$var][] = number_format($result->total);
            }
            $var = $var + 1;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $ranges = range("A", "Z");//range of excel sheet
        $columns = arrayFromCsv(Input::get('column_aliases_csv'));
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
        if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by')))) {
            $sheet->setCellValue($ranges[$k] . 1, 'Total'); //additional column will be added for group_by results
            $index = $k - 1;
            $sheet->setCellValue($ranges[$index] . $j, 'Total');//label for total results at the bottom of results
            $sheet->setCellValue($ranges[$k] . $j, $total);//put the total result
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Report-' . Input::get('report_name') . '.xlsx';
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $writer->save('php://output');
    }

    /**
     * Function to get all the fields of the data source as array
     * @param $data_source SQL view/table name
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
        if (Input::has('fields_csv') && strlen(cleanCsv(Input::get('fields_csv')))) {
            $fields_csv = cleanCsv(Input::get('fields_csv'));
            $fields = arrayFromCsv($fields_csv);
            return $fields;
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

        if (Input::has('columns_to_show_csv') && strlen(cleanCsv(Input::get('columns_to_show_csv')))) {
            $valid = true;
            $columns_to_show = arrayFromCsv(cleanCsv(Input::get('columns_to_show_csv'))); // convert csv to array
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
        if (Input::has('column_aliases_csv') && strlen(cleanCsv(Input::get('column_aliases_csv')))) {
            $column_aliases = arrayFromCsv(Input::get('column_aliases_csv'));
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
        if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by')))) {
            $group_by = " GROUP BY " . trim(Input::get('group_by', ", "));
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
        if (Input::has('order_by') && strlen(cleanCsv(Input::get('order_by')))) {
            $order_by = " ORDER BY " . Input::get('order_by');
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
        if ((Input::has('rows_per_page') && strlen(trim(Input::get('rows_per_page'))))) {
            if (Input::get('ret') != 'excel' && Input::get('view') != 'print') {
                $rows_per_page = trim(Input::get('rows_per_page'));
                $page = 1;
                if (Input::has('page')) {
                    $page = Input::get('page');
                }
                $offset = ($page - 1) * $rows_per_page;
                $limit = " LIMIT $offset,$rows_per_page ";
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
        foreach (Input::all() as $name => $val) {
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
        if (Input::has('additional_sql_select') && strlen(trim(Input::get('additional_sql_select')))) {
            $additional_sql_select = " AND (" . trim(Input::get('additional_sql_select') . ") ");
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
     * Report outputs - Json, Excel, Web-based data viewer.
     * @param $ret
     * @param $result_path
     * @return bool|JsonResponse|\Illuminate\View\View
     */
    public static function render($ret, $result_path) {
        if (Input::get('ret') == 'json') {
            $return = Response::json($ret);
        } else if (Input::get('ret') == 'excel') {
            $return = Reportbuilder::reportDownloadExcel($ret['results'], $ret['total']);
        } else {
            /***************************************************************************/
            // Render result in page
            /***************************************************************************/
            // Once you have determined the location of the result.blade.php in the same directory place another files
            // result-print.blade.php to generate the printable version of the result.
            if (Input::get('view') == 'print' && View::exists($result_path . '-print')) {
                $return = View::make($result_path . '-print')->with($ret);
            } else {
                $return = View::make($result_path)->with($ret);
            }
        }

        return $return;

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
            $filters .= Reportbuilder::additionalSqlFilters();

            /***************************************************************************/
            // Get order_by SQL clause
            /***************************************************************************/
            $order_by = Reportbuilder::orderBy();

            /***************************************************************************/
            // Limit pagination
            /***************************************************************************/
            $rows_per_page = $limit = null;
            if (!strlen(trim($group_by))) {
                $rows_per_page = trim(Input::get('rows_per_page'));
                $limit = Reportbuilder::limit();
            }

            // get total count of the full result.
            $sqlCount = cleanStrNTS("SELECT count(*) AS total FROM $data_source WHERE 1 $filters "); // construct SQL and remove new line, tab etc from it
            $total = resultFirst($sqlCount, $cache_time)->total;

            // get paginated results only
            $sql = cleanStrNTS("SELECT $fields_csv_esc FROM $data_source WHERE 1 $filters $group_by $order_by $limit"); // construct SQL and remove new line, tab etc from it
            $results = result($sql, $cache_time); //cacheTime('reports')

            // if no rows_per_page is set by user it means there will be no pagination and
            // all the results will be shown in one(first) page
            if (!$rows_per_page) $rows_per_page = $total ? $total : 1;
            $pagination = Paginator::make($results, $total, $rows_per_page); // call the laravel default Paginator class

            return compact('results', 'sql', 'total', 'pagination');
        }
        return false;
    }
}