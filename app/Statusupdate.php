<?php

namespace App;

use App\Observers\StatusupdateObserver;

/**
 * Class Statusupdate
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
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate query()
 * @property string|null $type
 * @property string|null $note
 * @property int|null $module_id
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @property string|null $status
 * @property int|null $previous_id
 * @property string|null $previous_status
 * @property int|null $next_id
 * @property string|null $next_status
 * @property int|null $diff_secs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \App\Statusupdate|null $to
 * @property-read \App\Statusupdate|null $from
 * @property-read \App\Task|null $task
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDiffSecs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNextId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNextStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate wherePreviousId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate wherePreviousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUuid($value)
 */
class Statusupdate extends Basemodule
{
    //use IsoModule;
    /**
     * Mass assignment fields (White-listed fields)
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'type',
        'note',
        'module_id',
        'element_id',
        'element_uuid',
        'status',
        'previous_id',
        'previous_status',
        'next_id',
        'next_status',
        'diff_secs',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Disallow from mass assignment. (Black-listed fields)
     * @var array
     */
    // protected $guarded = [];

    /**
     * Date fields
     * @var array
     */
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    /**
     * Custom validation messages.
     * @var array
     */
    public static $custom_validation_messages = [
        //'name.required' => 'Custom message.',
    ];

    /**
     * Validation rules. For regular expression validation use array instead of pipe
     * Example: 'name' => ['required', 'Regex:/^[A-Za-z0-9\-! ,\'\"\/@\.:\(\)]+$/']
     * @param       $element
     * @param  array  $merge
     * @return array
     */
    public static function rules($element, $merge = [])
    {
        $rules = [
            //'name' => 'required|between:1,255|unique:statusupdates,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            'is_active' => 'required|in:1,0',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',

        ];
        return array_merge($rules, $merge);
    }

    /**
     * Automatic eager load relation by default (can be expensive)
     * @var array
     */
    // protected $with = ['relation1', 'relation2'];

    ############################################################################################
    # Model events
    ############################################################################################

    public static function boot()
    {
        parent::boot();
        Statusupdate::observe(StatusupdateObserver::class);

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Statusupdate $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)

            /************************************************************/
            //if status is same as previous, it should not save.
            // Only if the status is different from last, it will save.
            /************************************************************/
            $previous_status_entry = $element->previous();
            if ($previous_status_entry) {
                if ($previous_status_entry->status == $element->status) {
                    $valid = false;
                }
            }

            //status_id_field,previous_status_id, status_id - These fields will be used for storing status ids where status options are saved in a table and have id,code,name.

            /************************************************************/
            // if the new entry has previous statusupdates then the new entry's previous_statusupdate_id will be the
            // last current previous entry's statusupdate id
            /************************************************************/
            if ($valid && $previous_status_entry) {
                $element->previous_id     = $previous_status_entry->id;
                $element->previous_status = $previous_status_entry->status;
                $element->type            = "Update";
            }
            if ($valid) {
                $element->is_active = 1; //Auto fill
            }

            /************************************************************/
            return $valid;
        });

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Statusupdate $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Statusupdate $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Statusupdate $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Statusupdate $element) {});

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Statusupdate $element) {
            //Dry update previous Status-updates
            if (isset($element->previousStatusupdate->id)) {
                $element->previousStatusupdate->where('id', $element->previousStatusupdate->id)->update([
                    'next_id' => $element->id,
                    'next_status' => $element->status,
                    'diff_secs' => round(dateDiff($element->previousStatusupdate->created_at, today())) //stores the day count between two status updates
                ]);
            }
        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Statusupdate $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Statusupdate $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Statusupdate $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Statusupdate $element) {});
    }

    ############################################################################################
    # Validator functions
    ############################################################################################

    /**
     * @param  bool|false  $setMsgSession  setting it false will not store the message in session
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
     * @param $id
     */
    // public static function someOtherAction($id) { }
    /**
     * Get the previous status-update
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function previous()
    {
        return Statusupdate::where('module_id', $this->module_id)->where('element_id', $this->element_id)
            ->where('created_at', '<', $this->created_at)->orderBy('created_at', 'DESC')->first();

    }

    /**
     * Get the next status-update
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function next()
    {
        return Statusupdate::where('module_id', $this->module_id)->where('element_id', $this->element_id)
            ->where('created_at', '>', $this->created_at)->orderBy('created_at', 'ASC')->first();
    }

    /**
     * If a status-update is created it will return that newly created object, otherwise it will return null/false
     * @param  Basemodule  $element
     * @param  array  $vals
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function log(Basemodule $element, $vals = [])
    {
        return Statusupdate::create([
            "name" => get_class($element)." ID-".$element->id,
            "module_id" => $element->module()->id,
            "element_id" => $element->id,
            "element_uuid" => $element->uuid,
            "status" => $vals['status'],
            "previous_id" => isset($vals['previous_id']) ? $vals['previous_id'] : null,
            "previous_status" => isset($vals['previous_status']) ? $vals['previous_status'] : null,
            "note" => isset($element->note) ? $element->note : null,
            "type" => "Create"
        ]);

    }
    ############################################################################################
    # Permission functions
    # ---------------------------------------------------------------------------------------- #
    /*
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
     * @param  null  $user_id
     * @return bool
     */
    //    public function isViewable($user_id = null)
    //    {
    //        $valid = false;
    //        if ($valid = spyrElementViewable($this, $user_id)) {
    //            //if ($valid && somethingElse()) $valid = false;
    //        }
    //        return $valid;
    //    }

    /**
     * Checks if the $module is editable by current or any user passed as parameter.
     * spyrElementEditable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     * @param  null  $user_id
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
     * @param  null  $user_id
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
     * @param  null  $user_id
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
    /*
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
    /*
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
    /*
     * This is a place holder to write model relationships. In the parent class there are
     * In the parent class there are the follow two relations creator(), updater() are
     * already defined.
     */
    ############################################################################################

    # Default relationships already available in base Class 'Basemodule'
    //public function updater() { return $this->belongsTo(\App\User::class, 'updated_by'); }
    //public function creator() { return $this->belongsTo(\App\User::class, 'created_by'); }

    // Write new relationships below this line
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(\App\Statusupdate::class, 'previous_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(\App\Statusupdate::class, 'next_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'element_id');
    }
    ############################################################################################
    # Accessors & Mutators
    # ---------------------------------------------------------------------------------------- #
    /*
     * Eloquent provides a convenient way to transform your model attributes when getting or setting them. Simply
     * define a getFooAttribute method on your model to declare an accessor. Keep in mind that the methods
     * should follow camel-casing, even though your database columns are snake-case:
     */
    // Example
    // public function getFirstNameAttribute($value) { return ucfirst($value); }
    // public function setFirstNameAttribute($value) { $this->attributes['first_name'] = strtolower($value); }
    ############################################################################################

    // Write accessors and mutators here.

}
