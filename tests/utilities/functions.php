<?php

/**
 * Short hand function to create a factory. This inserts in database.
 *
 * @param $class
 * @param array $attributes
 * @return mixed
 */
function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

/**
 * Short hand function to make a factory. This DOES NOT insert in database.
 *
 * @param $class
 * @param array $attributes
 * @return \Illuminate\Database\Eloquent\Model
 */
function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}