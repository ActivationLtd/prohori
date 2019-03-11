<?php

namespace App;

use App\Mail\TaskCreated;
use App\Observers\TaskObserver;
use App\Traits\Assignable;
use App\Traits\IsoModule;

/**
 * Class Task
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
 * @method static \Illuminate\Database\Query\Builder|\App\Task onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 */
class Task extends Basemodule
{
    use IsoModule;
    use Assignable;
    /**
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'name_ext',
        'parent_id',
        'priority',
        'seq',
        'client_id',
        'client_name',
        'clientlocation_id',
        'clientlocation_name',
        'clientlocationtype_id',
        'clientlocationtype_name',
        'division_id',
        'division_name',
        'district_id',
        'district_name',
        'upazila_id',
        'upazila_name',
        'description',
        'tasktype_id',
        'tasktype_name',
        'assignment_id',
        'assigned_to',
        'watchers',
        'status',
        'previous_status',
        'due_date',
        'days_open',
        'is_closed',
        'closed_by',
        'closing_note',
        'is_resolved',
        'resolved_by',
        'resolve_note',
        'is_verified',
        'verified_by',
        'verify_note',
        'is_flagged',
        'flagged_by',
        'flag_note',
        'tags',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'first_login_at',
        'last_login_at',
        'social_account_id',
        'social_account_type',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'watchers' => 'array',
    ];

    /**
     * Disallow from mass assignment. (Black-listed fields)
     *
     * @var array
     */
    // protected $guarded = [];

    /**
     * @var array
     */
    public static $statuses = [
        'To do',
        'In progress',
        'Verify',
        'Done',
        'Closed'
    ];

    /**
     * @var array
     */
    public static $priorities = [
        1 => 'Normal',
        0 => 'Low',
        2 => 'High',
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
    public static function rules($element, $merge = []) {
        $rules = [
            //'name' => 'required|between:1,255|unique:tasks,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            'is_active' => 'required|in:1,0',
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

    public static function boot() {
        parent::boot();
        Task::observe(TaskObserver::class);

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Task $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/
            if ($valid) {
                if ($element->client()->exists()) {
                    $element->client_name = $element->client->name;
                }
            }
            return $valid;
        });

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Task $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        static::created(function (Task $element) {
            //send mail to the assignee when task is created
            \Mail::to($element->assignee->email)->send(
                new TaskCreated($element)
            );
        });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Task $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Task $element) {});

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Task $element) {

            // if ($element->latestAssignment()->exists()) {
            //     $last_assignment = $element->latestAssignment;
            // }

        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Task $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Task $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Task $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Task $element) {});
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
     *
     * @param null $user_id
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee() { return $this->belongsTo(\App\User::class, 'assigned_to'); }

    public function clientlocation() { return $this->belongsTo(\App\Clientlocation::class); }

    public function tasktype() { return $this->belongsTo(\App\Tasktype::class); }

    public function subtTasks() { return $this->hasMany(\App\Task::class, 'parent_id'); }

    public function client() { return $this->belongsTo(\App\Client::class); }

    // Write new relationships below this line

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
    /**
     * Set partnercategory ids to array
     *
     *
     * @param  array $value
     * @return void
     */
    public function setWatchersAttribute($value) {
        // Original default value
        $this->attributes['watchers'] = $value;

        // 1. If the value is originally array converts array to json
        if (is_array($value)) {
            $this->attributes['watchers'] = json_encode(cleanArray($value));
        }
        //2 .If the original value is CSV converts array to json
        // if (isCsv($value)) {
        //     $this->attributes['included_country_ids'] = json_encode(csvToArray($value));
        // }

    }
}
