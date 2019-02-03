<?php

namespace App\Http\Controllers;

use App\Recommendurl;
use DB;
use Redirect;
use View;

class RecommendurlsController extends ModulebaseController
{

    /*********************************************************************
     * Grid related functions.
     * Uncomment the functions to show modified grid.
     ********************************************************************/

    /**
     * Define grid SELECT statement and HTML column name.
     *
     * @return array
     */
    public function gridColumns()
    {
        if (user()->isSuperUser()) {
            return [
                //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
                ["{$this->module_name}.id", "id", "ID"],
                ["{$this->module_name}.short_code", "short_code", "Short code"],
                ["{$this->module_name}.partner_name", "partner_name", "Partner"],
                ["{$this->module_name}.partner_name", "partner_name", "Partner"],
                ["recommender.name", "recommender_name", "Recommender"],
                ["{$this->module_name}.charity_name", "charity_name", "Charity"],
                ["{$this->module_name}.commission_percentage_lb", "commission_percentage_lb", "LB %"],
                ["{$this->module_name}.commission_percentage_recommender", "commission_percentage_recommender", "User %"],
                ["{$this->module_name}.charity_share_percentage", "charity_share_percentage", "Charity %"],
                ["{$this->module_name}.expires_at", "expires_at", "Expires on"],
                ["{$this->module_name}.created_at", "created_at", "Time"],
                // ["{$this->module_name}.is_active", "is_active", "Active"]
            ];
        }
        if (user()->ofPartner()) {
            return [
                //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
                ["{$this->module_name}.id", "id", "ID"],
                ["{$this->module_name}.short_code", "short_code", "Short code"],
                ["{$this->module_name}.partner_name", "partner_name", "Partner"],
                ["{$this->module_name}.product_url", "product_url", "Product URL"],
                ["{$this->module_name}.expires_at", "expires_at", "Expires on"],
                ["{$this->module_name}.created_at", "created_at", "Time"],
                // ["{$this->module_name}.is_active", "is_active", "Active"]
            ];
        }
    }

    /**
     * Construct SELECT statement based
     *
     * @return array
     */
    // public function selectColumns()
    // {
    //     $select_cols = [];
    //     foreach ($this->gridColumns() as $col)
    //         $select_cols[] = $col[0] . ' as ' . $col[1];
    //
    //     return $select_cols;
    // }

    /**
     * Define Query for generating results for grid
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function sourceTables()
    {
        return DB::table($this->module_name)
            ->leftJoin('users as recommender', $this->module_name . '.recommender_user_id', 'recommender.id');
    }

    /**
     * Define Query for generating results for grid
     *
     * @return $this|mixed
     */
    public function gridQuery()
    {
        $query = $this->sourceTables()->select($this->selectColumns());

        // Inject tenant context in grid query
        if ($tenant_id = inTenantContext($this->module_name)) {
            $query = injectTenantIdInModelQuery($this->module_name, $query);
        }

        // Exclude deleted rows
        $query = $query->whereNull($this->module_name . '.deleted_at'); // Skip deleted rows

        // Only show entries from the same partner
        if (user()->partner_id) {
            $query = $query->where("{$this->module_name}.partner_id", user()->partner_id); // Skip deleted rows
        }

        return $query;
    }

    /**
     * Modify datatable values
     *
     * @var $dt \Yajra\DataTables\DataTableAbstract
     * @return mixed
     */
    public function datatableModify($dt)
    {
        // First set columns for  HTML rendering
        $dt = $dt->rawColumns(['id']); // HTML can be printed for raw columns

        // Next modify each column content
        /** @var $dt \Yajra\DataTables\DataTableAbstract */
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
        return $dt;
    }

    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @var \Yajra\DataTables\DataTables $dt
     * @return \Illuminate\Http\JsonResponse
     */
    // public function grid()
    // {
    //     // Make datatable
    //     /** @var \Yajra\DataTables\DataTableAbstract $dt */
    //     $dt = datatables($this->gridQuery());
    //     $dt = $this->datatableModify($dt);
    //     return $dt->toJson();
    // }

    // ****************** Grid functions end *********************************

    /**
     * Redirect to partner product page. If link is expired show the link expiry page.
     * If user go with /u then the splash screen comes on the product detail page
     *
     * @param $short_code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectU($short_code)
    {
        if ($recommendurl = Recommendurl::where('short_code', $short_code)->first()) {
            if (strtotime($recommendurl->expires_at) > time()) {
                return Redirect::to($recommendurl->url, 301);
            }
        }
        return View::make('template.letsbab.link-expired');
    }

    /**
     * Redirect to actual product page url.
     * If user click on the link from the activity screen section then that time
     * we have to hide the splash screen
     *
     * @param $short_code
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function redirectM($short_code)
    {
        if ($recommendurl = Recommendurl::where('short_code', $short_code)->first()) {
            $target_url = explode("?bAb", $recommendurl->product_url);
            $target_url = isset($target_url[0]) ? $target_url[0] : 'https://www.letsbab.com';
            return Redirect::to($target_url, 301);
        }
        return View::make('layouts.letsbab.link-expired');
    }

}
