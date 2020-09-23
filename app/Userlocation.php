<?php

namespace App;

use App\Observers\UserlocationObserver;
use App\Traits\IsoModule;

/**
 * Class Userlocation
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userlocation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Userlocation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userlocation withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userlocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userlocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userlocation query()
 */
class Userlocation extends Basemodule
{
    //use IsoModule;
    /**
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'longitude',
        'latitude',
        'data',
        'client_id',
        'client_name',
        'clientlocation_id',
        'clientlocation_name',
        'clientlocation_longitude',
        'clientlocation_latitude',
        'distance',
        'distance_flag',
        'tenant_id',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'some_ids' => 'array',
    // ];

    /**
     * Disallow from mass assignment. (Black-listed fields)
     *
     * @var array
     */
    // protected $guarded = [];
    public static $flags = [

        'Green',
        'Yellow',
        'Red',
    ];
    /**
     * Date fields
     *
     * @var array
     */
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Validation rules. For regular expression validation use array instead of pipe
     * Example: 'name' => ['required', 'Regex:/^[A-Za-z0-9\-! ,\'\"\/@\.:\(\)]+$/']
     *
     * @param       $element
     * @param array $merge
     * @return array
     */
    public static function rules($element, $merge = [])
    {

        $rules = [
            //'name' => 'between:1,255',
            'user_id' => 'required|exists:users,id,is_active,1',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'data' => 'nullable|json',
            //'is_active' => 'required|in:1,0',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',

        ];
        return array_merge($rules, $merge);
    }

    /**
     * Custom validation messages.
     *
     * @var array
     */
    public static $custom_validation_messages = [
        //'name.required' => 'Custom message.',
    ];

    /**
     * Automatic eager load relation by default (can be expensive)
     *
     * @var array
     */
    // protected $with = ['relation1', 'relation2'];

    ############################################################################################
    # Model events
    ############################################################################################

    public static function boot()
    {
        parent::boot();
        Userlocation::observe(UserlocationObserver::class);

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Userlocation $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)

            $element->name = $element->user->full_name.' at '.$element->created_at;

            if($element->distance<200){
                $element->distance_flag="Green";
            }elseif($element->distance>200 && $element->distance<400){
                $element->distance_flag="Yellow";
            }else{
                $element->distance_flag="Red";
            }


            /************************************************************/
            return $valid;
        });

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        static::creating(function (Userlocation $element) {

            if (isset($element->user->client_id)) {
                $element->client_id = $element->user->client_id;
                $element->client_name = $element->user->client->name;
            }
            if (isset($element->user->clientlocation_id)) {
                $element->clientlocation_id = $element->user->clientlocation_id;
                $element->clientlocation_name = $element->user->clientlocation->name;
                $element->clientlocation_longitude = isset($element->user->clientlocation->longitude) ? $element->user->clientlocation->longitude : null;
                $element->clientlocation_latitude = isset($element->user->clientlocation->latitude) ? $element->user->clientlocation->latitude : null;
            }
            if($element->clientlocation_longitude!==null && $element->clientlocation_latitude!==null){
                $element->distance=$element->calculateDistance($element->latitude,$element->longitude,$element->clientlocation_latitude,$element->clientlocation_longitude);
            }



        });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        static::created(function (Userlocation $element) {
            $element->is_active = 1;
        });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Userlocation $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Userlocation $element) {});

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        // static::saved(function (Userlocation $element) {});

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Userlocation $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Userlocation $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Userlocation $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Userlocation $element) {});
    }

    ############################################################################################
    # Validator functions
    ############################################################################################

    /**
     * @param bool|false $setMsgSession setting it false will not store the message in session
     * @return bool
     */
    //    public function isSomethingDoable($setMsgSession = false)
    //    {
    //        $valid = true;
    //        // Make invalid(Not request-able) if {something doesn't match with something}
    //        if ($valid && $this->id == null) {
    //            if ($setMsgSession) $valid = setError("Something is wrong. Id is Null!!"); // make valid flag false and set validation error message in session if message flag is true
    //            else $valid = false; // don't set any message only set validation as false.
    //        }
    //
    //        return $valid;
    //    }

    ############################################################################################
    # Helper functions
    ############################################################################################
    /**
     * Non static functions can be directly called $element->function();
     * Such functions are useful when an object(element) is already instantiated
     * and some processing is required for that
     */
    // public function someAction() { }

    /**
     * Static functions needs to be called using Model::function($id)
     * Inside static function you may need to query and get the element
     *
     * @param $id
     */
    // public static function someOtherAction($id) { }

    ############################################################################################
    # Permission functions
    # ---------------------------------------------------------------------------------------- #
    /**
     * This is a place holder to write the functions that resolve permission to a specific model.
     * In the parent class there are the follow functions that checks whether a user has
     * permission to perform the following on an element. Rewrite these functions
     * in case more customized access management is required.
     */
    ############################################################################################

    /**
     * Checks if the $module is viewable by current or any user passed as parameter.
     * spyrElementViewable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    public function isViewable($user_id = null, $set_msg = false)
    {
        $user = user($user_id);
        if (spyrElementViewable($this, $user_id, $set_msg)) {
            return true;
        }
        if ($user->isSuperUser()) {
            return true;
        }
        if ($user->isClientUser()) {
            if (isset($this->user->client_id)) {
                if ($this->user->client_id == $user->client_id) {
                    return true;
                }
            }

        }
        return false;
    }

    /**
     * Checks if the $module is editable by current or any user passed as parameter.
     * spyrElementEditable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isEditable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementEditable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is deletable by current or any user passed as parameter.
     * spyrElementDeletable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isDeletable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementDeletable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is restorable by current or any user passed as parameter.
     * spyrElementRestorable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @return bool
     */
    //    public function isRestorable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementRestorable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    ############################################################################################
    # Query scopes
    # ---------------------------------------------------------------------------------------- #
    /**
     * Scopes allow you to easily re-use query logic in your models. To define a scope, simply
     * prefix a model method with scope:
     */
    /*
       public function scopePopular($query) { return $query->where('votes', '>', 100); }
       public function scopeWomen($query) { return $query->whereGender('W'); }
       # Example of user
       $users = User::popular()->women()->orderBy('created_at')->get();
    */
    ############################################################################################

    // Write new query scopes here.

    ############################################################################################
    # Dynamic scopes
    # ---------------------------------------------------------------------------------------- #
    /**
     * Scopes allow you to easily re-use query logic in your models. To define a scope, simply
     * prefix a model method with scope:
     */
    /*
    public function scopeOfType($query, $type) { return $query->whereType($type); }
    # Example of user
    $users = User::ofType('member')->get();
    */
    ############################################################################################

    // Write new dynamic query scopes here.

    ############################################################################################
    # Model relationships
    # ---------------------------------------------------------------------------------------- #
    /**
     * This is a place holder to write model relationships. In the parent class there are
     * In the parent class there are the follow two relations creator(), updater() are
     * already defined.
     */
    ############################################################################################

    # Default relationships already available in base Class 'Basemodule'
    public function user() { return $this->belongsTo(\App\User::class, 'user_id'); }

    public function client() { return $this->belongsTo(\App\Client::class, 'client_id'); }

    public function clientlocation() { return $this->belongsTo(\App\Clientlocation::class, 'clientlocation_id'); }

    public function updater() { return $this->belongsTo(\App\User::class, 'updated_by'); }

    public function creator() { return $this->belongsTo(\App\User::class, 'created_by'); }

    // Write new relationships below this line

    ############################################################################################
    # Accessors & Mutators
    # ---------------------------------------------------------------------------------------- #
    /**
     * Eloquent provides a convenient way to transform your model attributes when getting or setting them. Simply
     * define a getFooAttribute method on your model to declare an accessor. Keep in mind that the methods
     * should follow camel-casing, even though your database columns are snake-case:
     */
    // Example
    // public function getFirstNameAttribute($value) { return ucfirst($value); }
    // public function setFirstNameAttribute($value) { $this->attributes['first_name'] = strtolower($value); }
    ############################################################################################

    /**
     * Set some ids that comes as csv/array as input
     *
     * @param  array $value
     * @return void
     */
    // public function setSomeIdsAttribute($value)
    // {
    //     // Original default value
    //     $this->attributes['some_ids'] = $value;
    //
    //     // 1. If the value is originally array converts array to json
    //     if (is_array($value)) {
    //         $this->attributes['some_ids'] = json_encode(cleanArray($value));
    //     }
    //     // 2 .If the original value is CSV converts array to json
    //     // if (isCsv($value)) {
    //     //     $this->attributes['some_ids'] = json_encode(csvToArray($value));
    //     // }
    // }
    public function setDataAttribute($value)
    {
        /** @var App\Userlocation\Userlocation $this */
        $this->attributes['data'] = $value;
        // 1. If the value is originally array converts array to json
        if (is_array($value)) {
            $this->attributes['data'] = json_encode(cleanArray($value));
        }

    }
    //https://gist.github.com/LucaRosaldi/5676464
    public function calculateDistance($lat1,$lon1,$lat2,$lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;

        $meters = $kilometers * 1000;

        return $meters;

    }

    // Write accessors and mutators here.

}
