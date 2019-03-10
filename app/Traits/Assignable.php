<?php

namespace App\Traits;

use App\Assignment;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

trait Assignable
{

    /**
     * Get a list of uploads under an element.
     *
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'element_id')->where('module_id', $this->module()->id);
    }

    /**
     * Get a list of uploads under an element.
     *
     * @return mixed
     */
    public function latestAssignment()
    {
        return $this->hasOne(Assignment::class, 'element_id')->where('module_id', $this->module()->id)->orderBy('created_at', 'DESC');
    }

}