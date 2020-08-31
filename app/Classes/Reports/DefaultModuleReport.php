<?php

namespace App\Classes\Reports;

class DefaultModuleReport extends IsoReportBuilder
{
    /**
     * @param $query   \Illuminate\Database\Query\Builder
     * @return mixed
     */
    public function filters($query)
    {
        /** @var array $escape_fields */
        $escape_fields = ['assigned_to']; // Default filter logic will not apply on these

        foreach ($this->request as $name => $val) {
            if (in_array($name, $escape_fields)) {
                // Process custom filters test1,test2,test3
                if ($this->paramIsArray($val)) {

                    if ($this->possibleJson($name)) { // Data stored in table is possibly json
                        // $query = $query->whereJsonContains($name, $val); // Does't work for older maria db
                    } else { // Not json. A single value.
                        $query = $query->whereIn($name, $this->cleanArray($val));
                    }
                    // Process custom filters test1,test2,test3
                }
            }else {

                $query = $this->defaultFilter($query, $name, $val);
            }
        }

        if ($this->additionalFilterConditions()) {
            $query = $query->whereRaw($query, $this->additionalFilterConditions());
        }

        $query = $query->whereNull('deleted_at');

        return $query;
    }

}