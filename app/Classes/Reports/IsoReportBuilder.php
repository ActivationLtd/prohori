<?php

namespace App\Classes\Reports;

use Cache;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Request;
use Schema;
use View;

/**
 * @property string data_sourece
 */
class IsoReportBuilder
{
    /** @var  \Illuminate\Http\Request Input from form */
    public $request;

    /** @var  string DB Table/View names */
    public $data_source = null;

    /** @var  string Directory location of the report blade templates */
    public $base_dir;

    /** @var  string Directory location of the default report blade templates */
    public $default_base_dir = 'modules.base.report';

    /** @var int Cache time */
    public $cache;

    /** @var array */
    public $data_source_columns;

    /** @var array */
    public $show_columns_options;

    /** @var  Builder */
    public $query;

    /** @var  integer total count */
    public $total;

    /** @var  \Illuminate\Support\Collection Report results */
    public $results;

    /**
     * ReportBuilder constructor.
     *
     * @param string $data_source
     * @param string $base_dir
     * @param int $cache
     */
    public function __construct($data_source = null, $base_dir = null, $cache = 0)
    {
        $this->request = Request::capture();
        $this->data_source = $data_source;
        $this->base_dir = $base_dir ?? 'modules.base.report';
        $this->cache = $cache;
        $this->data_source_columns = $this->dataSourceColumns();
        $this->show_columns_options = $this->showColumnsOptions();

        // Share the variables across all views accessed by this controller
        // View::share([
        //     'base_dir' => $this->base_dir,
        //     'data_source' => $this->data_source,
        //     'data_source_columns' => $this->data_source_columns,
        //     'show_columns_options' => $this->show_columns_options,
        // ]);
    }

    /**
     * Show report blank or filled with data if 'Run'
     */
    public function show()
    {

        $base_dir = $this->base_dir;
        $data_source = $this->data_source;
        $data_source_columns = $this->dataSourceColumns();
        $show_columns_options = $this->showColumnsOptions();

        if ($this->request->get('submit') === 'Run') {
            //$this->run();

            $show_columns = $this->mutateShowColumns($this->showColumns());
            $alias_columns = $this->mutateAliasColumns($this->aliasColumns());
            $results = $this->mutateResults($this->results());
            $total = $this->total();

            if ($this->output() === 'json') {
                return $results;
            }

            if ($this->output() === 'excel') {
                /** @noinspection PhpVoidFunctionResultUsedInspection */
                return $this->dumpExcel($show_columns, $alias_columns, $results);
            }

            if ($this->output() === 'print') {
                return view($this->resultsPrintPath())
                    ->with(compact('show_columns', 'alias_columns', 'total', 'results', 'base_dir', 'data_source', 'data_source_columns', 'show_columns_options'));
            }

            return view($this->resultsViewPath())
                ->with(compact('show_columns', 'alias_columns', 'total', 'results', 'base_dir', 'data_source', 'data_source_columns', 'show_columns_options'));
        }

        return view($this->resultsViewPath())
            ->with(compact('base_dir', 'data_source', 'data_source_columns', 'show_columns_options'));
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function results()
    {
        $query = $this->queryResults();

        if (in_array($this->output(), ['excel', 'print'])) {
            return $query->get();
        }
        if ($this->rowsPerPage()) {
            return $query->paginate($this->rowsPerPage());
        }
        return $query->get();
    }

    /**
     * @param $query   \Illuminate\Database\Query\Builder
     * @return mixed
     */
    public function filters($query)
    {
        /** @var array $escape_fields */
        $escape_fields = []; // Default filter logic will not apply on these

        foreach ($this->request->all() as $name => $val) {
            if (in_array($name, $escape_fields)) {
                // Process custom filters test1,test2,test3
            } else {
                $query = $this->defaultFilter($query, $name, $val);
            }
        }

        if ($this->additionalFilterConditions()) {
            $query = $query->whereRaw($query, $this->additionalFilterConditions());
        }

        if (in_array('deleted_at', $this->dataSourceColumns())) {
            $query = $query->whereNull('deleted_at');
        }

        return $query;
    }

    /**
     * Checks if the input field is date format
     *
     * @param $name
     * @return bool
     */
    public function columnLooksLikeDateField($name)
    {
        if (Str::contains($name, ['_at', 'on', 'date'])) {
            return true;
        }
        return false;

    }

    /**
     * From the name of the input try to assume if it is some data-from field
     *
     * @param $name
     * @return bool
     */
    public function isFromRange($name)
    {
        if (Str::contains($name, ['_from', '_start', '_starts', '_min'])) {
            return true;
        }
        return false;

    }

    /**
     * From the name of the input try to assume if it is some data-to field
     *
     * @param $name
     * @return bool
     */
    public function isToRange($name)
    {
        if (Str::contains($name, ['_to', '_till', '_end', '_ends', '_max'])) {
            return true;
        }
        return false;

    }

    public function possibleJson($name)
    {
        if (Str::contains($name, ['_ids', '_json'])) {
            return true;
        }
        return false;
    }

    /**
     * Get the actual date field
     *
     * @param $name
     * @return string
     */
    public function getActualDateField($name)
    {
        $replaces = [
            '_from', '_start', '_starts',
            '_to', '_till', '_end', '_ends'
        ];

        $actual = $name;
        foreach ($replaces as $replace) {
            $actual = Str::replaceLast($replace, '', $actual);
        }
        return $actual;

    }

    /**
     * Default query builder from input.
     *
     * @param $query \Illuminate\Database\Query\Builder
     * @param $name
     * @param $val
     * @return mixed
     */
    public function defaultFilter($query, $name, $val)
    {
        // The input field name matches a data source field name.
        if ($this->columnInDataSource($name)) {

            // Input is array
            if ($this->paramIsArray($val)) {

                if ($this->possibleJson($name)) { // Data stored in table is possibly json
                    $query = $query->whereJsonContains($name, $val);
                } else { // Not json. A single value.
                    $query = $query->whereIn($name, $this->cleanArray($val));
                }

            } else if ($this->paramIsCsv($val)) { // Input is CSV

                $query = $query->whereIn($name, $this->csvToArray($val));

            } else if ($this->paramIsString($val)) { // Input is string

                if ($this->columnIsFullText($name)) { // Substring search. Good for name, email etc.
                    $query = $query->where($name, 'LIKE', '%' . trim($val) . '%');
                } else { // Exact string match
                    $query = $query->where($name, trim($val));
                }

            }
        }

        /**
         * If there is some field like created_at_from, end_date_from then
         * the builder smartly handles it to create a date range query.
         */
        if (($this->isFromRange($name) || $this->isToRange($name)) && strlen($val)) {
            $actual_column = $this->getActualDateField($name);

            if ($this->isFromRange($name)) {
                $query = $query->where($actual_column, '>=', trim($val));
            } else if ($this->isToRange($name)) {
                $query = $query->where($actual_column, '<=', trim($val));
            }
        }

        return $query;
    }

    public function queryTotal()
    {
        $query = $this->selectDataSource();
        $query = $this->filters($query);
        return $query;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryResults()
    {
        /** @var Builder $query */
        $query = $this->selectDataSource();
        if (count($this->selectColumns())) {
            $query = $query->select($this->selectColumns());
        }
        $query = $this->filters($query);
        // $query = $this->groupBy($query);
        $query = $this->orderBy($query);
        return $query;
    }

    /**
     * @param $query Builder
     * @return \Illuminate\Database\Query\Builder
     */
    public function groupBy($query)
    {

        $group_bys = $this->csvToArray($this->request->get('group_by'));
        foreach ($group_bys as $group_by) {
            $query = $query->groupBy($group_by);
        }
        return $query;
    }

    /**
     * @param $query Builder
     * @return \Illuminate\Database\Query\Builder
     */
    public function orderBy($query)
    {
        $order_by_raw = trim($this->request->get('order_by'));
        if (strlen($order_by_raw)) {
            $query = $query->orderByRaw($order_by_raw);
        }

        return $query;
    }

    /**
     * @param $show_columns
     * @param $alias_columns
     * @param $results
     */
    public function dumpExcel($show_columns, $alias_columns, $results)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $ranges = $this->excelColumnRange(count($show_columns));

        /**
         * First column with title
         */
        $i = 0;
        foreach ($alias_columns as $column) {
            $sheet->setCellValue($ranges[$i++] . 1, $column);
        }

        // Starting from A2

        $j = 2;
        foreach ($results as $row) {
            $k = 0;
            foreach ($show_columns as $column) {
                $sheet->setCellValue($ranges[$k++] . $j, $row->$column);
            }
            $j++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Report=' . now() . '.xlsx';
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $writer->save('php://output');
    }

    /**
     * Generate the data source name that can be used in query string.
     *
     * @return string
     */
    public function dataSource()
    {
        return $this->data_source;
    }

    /**
     * Get the data source field|columns names
     *
     * @return array
     */
    public function dataSourceColumns()
    {
        if ($this->data_source) {
            return $this->tableColumns($this->data_source);
        }
    }

    public function tableColumns($table)
    {
        return Cache::remember('columns-of:' .
            $table, cacheTime('very-long'),
            function () use ($table) {
                return Schema::getColumnListing($table);
            });
    }

    /**
     * Get result view path.
     *
     * @return string
     */
    public function resultsViewPath()
    {
        return $this->base_dir . '.results';
    }

    /**
     * Get result view path.
     *
     * @return string
     */
    public function resultsPrintPath()
    {
        $print_path = $this->base_dir . '.results-print';
        if (!View::exists($print_path)) {
            $print_path = $this->default_base_dir . '.results-print';
        }

        return $print_path;
    }

    /**
     * Check if a column exist in data source
     *
     * @param $column
     * @return bool
     */
    protected function columnIsInDataSource($column)
    {
        return in_array($column, $this->data_source_columns);
    }

    /**
     * cleans a string and returns as csv
     *
     * @param $csv
     * @return string
     */
    protected function cleanCsv($csv)
    {
        // $clearChars = array("\n", " ", "\r");
        $clearChars = ["\n", "\r"];
        return str_replace($clearChars, '', trim($csv, ', '));
    }

    /**
     * removes new line tabs etc( '\n','\t') from a string
     * remove-extra-spaces-tabs-and-line-feeds-from-a-sentence-and-substitute
     *
     * @param $str
     * @return mixed
     */
    protected function cleanString($str)
    {
        return preg_replace('/\s+/S', ' ', $str);
    }

    /**
     * Remove empty values and arrays values from an array.
     *
     * @param array $array
     * @return array
     */
    protected function cleanArray($array = [])
    {
        $temp = [];
        if (is_array($array) && count($array)) {                    // handle if input is an array1
            foreach ($array as $a) {
                if (!is_array($a) && strlen(trim($a))) {
                    $temp[] = $a;
                }
            }
        }
        return $temp;
    }

    /**
     * Function changes results, show_column, alias_columns for the final output
     *
     * @param $results
     * @return mixed
     */
    public function mutateResults($results)
    {
        // foreach ($results as $row) {
        //     $row->new = randomString();
        // }
        return $results;
    }

    /**
     * Change show columns array for output
     *
     * @param $show_columns
     * @return array
     */
    public function mutateShowColumns($show_columns)
    {
        return array_merge($show_columns, [
            // New columns
        ]);
    }

    /**
     * Change alias column array for output
     *
     * @param $alias_columns
     * @return array
     */
    public function mutateAliasColumns($alias_columns)
    {
        return array_merge($alias_columns, [
            // New columns
        ]);
    }

    /**
     * Create column range for Excel
     *
     * @param $no_of_columns
     * @return array // ['A','B', ... 'AA', 'ZZ']
     */
    public function excelColumnRange($no_of_columns)
    {
        $letters = range('A', 'Z');

        $range = array();
        for ($i = 0; $i < $no_of_columns; $i++) {
            $position = $i * 26;
            foreach ($letters as $ii => $letter) {
                $position++;
                if ($position <= $no_of_columns) {
                    $range[] = ($position > 26 ? $range[$i - 1] : '') . $letter;
                }
            }
        }
        return $range;
    }

    /**
     * Run the query to get the results.
     * Run results and store the values.
     */
    public function run()
    {
        $this->total = $this->total();
        $this->results = $this->results();
    }

    /**
     * Get total number of rows
     *
     * @return int
     */
    public function total()
    {
        return $this->queryTotal()->count();
    }

    /**
     * Output type
     *
     * @return mixed
     */
    public function output()
    {
        return $this->request->get('ret');
    }

    /**
     * Rows per page
     *
     * @return mixed
     */
    public function rowsPerPage()
    {
        return $this->request->get('rows_per_page');
    }

    /**
     * Additional filters
     *
     * @return mixed
     */
    public function additionalFilterConditions()
    {
        return $this->request->get('additional_conditions');
    }

    /**
     * Query select table
     *
     * @return \Illuminate\Database\Query\Builder||\Illuminate\Database\Eloquent\Builder
     */
    public function selectDataSource()
    {
        return DB::table($this->dataSource());
    }

    /**
     * Convert CSV to array.
     */
    public function csvToArray($csv)
    {
        return $this->cleanArray(explode(',', $this->cleanCsv($csv)));
    }

    /**
     * Check if a filter parameter has array value
     *
     * @param $input
     * @return bool|int
     */
    public function paramIsArray($input)
    {
        if (is_array($input) && count($input)) {
            return count($this->cleanArray($input));
        }
        return false;
    }

    /**
     * Check if param is string.
     *
     * @param $input
     * @return string
     */
    public function paramIsString($input)
    {
        return trim(strlen($input));
    }

    /**
     * Check if param is csv
     *
     * @param $input
     * @return bool|int
     */
    public function paramIsCsv($input)
    {
        if (strlen($input) && strpos($input, ',') !== false) {
            return strlen($this->cleanCsv($input));
        }
        return false;
    }

    /**
     * Check if a column is for full text search. These will be processed with %LIKE%
     *
     * @param $column
     * @return bool
     */
    public function columnIsFullText($column)
    {
        $full_text_columns = ['name'];
        return in_array($column, $full_text_columns);
    }

    /**
     * Checks if a column exists in data source.
     *
     * @param $name
     * @return bool
     */
    public function columnInDataSource($name)
    {
        return in_array($name, $this->dataSourceColumns());
    }

    /**
     * Get the direct user input CSV
     *
     * @return mixed
     */
    public function selectColumnsCsv()
    {
        return $this->cleanCsv($this->request->get('select_columns_csv'));
    }

    /**
     * Convert input csv to array
     *
     * @return array
     */
    public function selectColumns()
    {
        if (strlen($this->selectColumnsCsv())) {
            $keys = $this->cleanArray(explode(',', $this->selectColumnsCsv()));
        } else if (count($this->showColumns())) {
            $keys = $this->showColumns();
            $keys = $this->addAlwaysSelectColumns($keys);
            $keys = $this->removeGhostShowColumns($keys);
            //dd($keys);

        } else {
            $keys = $this->dataSourceColumns();
        }

        return $keys;
    }

    /**
     * Columns that should be always included in the select column query.
     * Usually this is id field. This is useful to generate a url
     * to the linked element.
     *
     * @return array
     */
    public function alwaysSelectColumns()
    {
        return ['id'];
    }

    /**
     * Some times we need to pass column names that do not exists in the model/table.
     * This should not be considered in query building. Rather we want this to be
     * post processed in mutation function.
     *
     * @return array
     */
    public function ghostSelectColumns()
    {
        return [];
    }

    /**
     * Remove ghost columns from the array of select columns.
     *
     * @param array $keys
     * @return array
     */
    public function removeGhostShowColumns($keys = [])
    {
        $temp = [];
        foreach ($keys as $key) {
            if (!in_array($key, $this->ghostSelectColumns())) {
                $temp[] = $key;
            }
        }
        return $temp;
    }

    /**
     * Add the columns that should be always selected.
     *
     * @param array $keys
     * @return array
     */
    public function addAlwaysSelectColumns($keys = [])
    {
        foreach ($this->alwaysSelectColumns() as $col) {
            if (in_array($col, $keys)) {
                $keys[] = $col;
            }
        }
        return $keys;
    }

    /**
     * Convert input csv to array
     *
     * @return mixed
     */
    public function showColumnsCsv()
    {
        return $this->cleanCsv($this->request->get('show_columns_csv'));
    }

    /**
     * Convert input csv to array
     *
     * @return array
     */
    public function showColumns()
    {

        if (strlen($this->showColumnsCsv())) {
            $keys = $this->cleanArray(explode(',', $this->showColumnsCsv()));
        } else {
            $keys = $this->dataSourceColumns();
        }

        return $keys;
    }

    public function showColumnsOptions()
    {
        return array_merge($this->tableColumns($this->data_source), $this->ghostSelectColumns());
    }

    /**
     * Get column as csv and clean
     *
     * @return mixed
     */
    public function aliasColumnsCsv()
    {

        return $this->cleanCsv($this->request->get('alias_columns_csv'));
    }

    /**
     * Convert input csv to array
     *
     * @return array
     */
    public function aliasColumns()
    {
        if (strlen($this->aliasColumnsCsv())) {
            $keys = $this->cleanArray(explode(',', $this->aliasColumnsCsv()));
        } else {
            $keys = $this->showColumns();
        }

        if (count($keys) <= count($this->showColumns())) {
            $keys = $this->fillAliasColumns($keys);
        }
        if (count($keys) > count($this->showColumns())) {
            $keys = array_slice($keys, count($this->showColumns()));
        }

        return $keys;
    }

    public function fillAliasColumns($keys)
    {

        $sliced = array_slice($this->showColumns(), count($keys));

        $keys = array_merge($keys, $sliced);

        $temp = [];
        foreach ($keys as $key) {
            $temp[] = Str::title(str_replace('_', ' ', $key));
        }

        return $temp;

    }
}