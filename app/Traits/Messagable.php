<?php

namespace App\Traits;

use App\Message;

trait Messagable
{

    /**
     * Get a list of uploads under an element.
     *
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'element_id')->where('module_id', $this->module()->id);
    }

    /**
     * Get a list of uploads under an element.
     *
     * @return mixed
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'element_id')->where('module_id', $this->module()->id)->orderBy('created_at', 'DESC');
    }

}