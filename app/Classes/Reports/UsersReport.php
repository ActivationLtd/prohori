<?php

namespace App\Classes\Reports;

use App\Group;
use App\User;

class UsersReport extends IsoReportBuilder
{
    // public function __construct()
    // {
    //
    //     $this->data_source = 'v_invoices';
    //     $this->base_dir = 'custom-reports.bankline-export';
    //
    //     parent::__construct($this->data_source,$this->base_dir);
    //
    // }

    /**
     * Query select table
     *
     * @return \App\User|\Illuminate\Database\Eloquent\Builder
     */
    public function selectDataSource()
    {
        return new User;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return $this|\Illuminate\Database\Query\Builder|mixed
     */
    public function filters($query)
    {
        /** @var array $escape_fields */
        $escape_fields = ['group_ids']; // Escape default filter logic.

        foreach ($this->request->all() as $name => $val) {
            if (in_array($name, $escape_fields)) {
                if ($name == 'group_ids') {
                    $query = $query->whereHas('groups', function ($q) use ($val) {
                        /** @var \Illuminate\Database\Query\Builder $q */
                        $q->whereIn('id', $val);
                    });
                }
            } else {
                $query = $this->defaultFilter($query, $name, $val);
            }
        }

        if ($this->additionalFilterConditions()) {
            $query = $query->whereRaw($query, $this->additionalFilterConditions());
        }

        return $query;
    }

    /**
     * Function changes results, show_column, alias_columns for the final output
     *
     * @param $results
     * @return mixed
     */
    public function mutateResults($results)
    {
        foreach ($results as $row) {

            /** @var User $row */
            if (strlen(trim($row->group_ids_csv))) {
                if ($group = Group::remember(cacheTime('very-long'))->find(trim($row->group_ids_csv, ', '))) {
                    $row->group_ids_csv = $group->title;
                }
            }
            $row->address1 = $row->address();
            $row->gift_aid_checked = $row->gift_aid_checked ? 'Yes' : 'No';
            $row->email_verified_at = $row->email_verified_at ? 'Yes' : 'No';

        }
        return $results;
    }

}