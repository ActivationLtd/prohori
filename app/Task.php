<?php

namespace App;

use App\Mail\TaskCreated;
use App\Traits\Assignable;
use App\Observers\TaskObserver;
use DB;

/**
 * Class Task
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
 * @property string|null $name_ext
 * @property int|null $parent_id
 * @property int|null $priority
 * @property int|null $seq
 * @property int|null $client_id
 * @property string|null $client_name
 * @property string|null $client_obj
 * @property int|null $clientlocation_id
 * @property string|null $clientlocation_name
 * @property string|null $clientlocation_obj
 * @property int|null $clientlocationtype_id
 * @property string|null $clientlocationtype_name
 * @property int|null $division_id
 * @property string|null $division_name
 * @property int|null $district_id
 * @property string|null $district_name
 * @property int|null $upazila_id
 * @property string|null $upazila_name
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $description
 * @property int|null $tasktype_id
 * @property string|null $tasktype_name
 * @property int|null $assignment_id
 * @property int|null $assigned_to
 * @property array|null $watchers
 * @property string|null $status
 * @property string|null $previous_status
 * @property string|null $due_date
 * @property string|null $days_open
 * @property int|null $is_closed
 * @property int|null $closed_by
 * @property string|null $closing_note
 * @property int|null $is_resolved
 * @property int|null $resolved_by
 * @property string|null $resolve_note
 * @property int|null $is_verified
 * @property int|null $verified_by
 * @property string|null $verify_note
 * @property int|null $is_flagged
 * @property int|null $flagged_by
 * @property string|null $flag_note
 * @property string|null $tags
 * @property-read \App\User|null $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Client|null $client
 * @property-read \App\Clientlocation|null $clientlocation
 * @property-read \App\Assignment $latestAssignment
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $subtasks
 * @property-read \App\Tasktype|null $tasktype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientObj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationObj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationtypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClosedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClosingNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDaysOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereFlagNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereFlaggedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsFlagged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsResolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task wherePreviousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereResolveNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereResolvedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTasktypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTasktypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpazilaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpazilaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereVerifyNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereWatchers($value)
 */
class Task extends Basemodule
{
    //use IsoModule;
    use Assignable;
    /**
     * Mass assignment fields (White-listed fields)
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
        'client_obj',
        'clientlocation_id',
        'clientlocation_name',
        'clientlocation_obj',
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
        'deleted_by'
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'watchers' => 'array',
    ];

    /**
     * Disallow from mass assignment. (Black-listed fields)
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
     * @var array
     */
    protected $appends = ['watcher_objs', 'priorities_name'];
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
     * @param  array $merge
     * @return array
     */
    public static function rules($element, $merge = []) {
        $rules = [
            'name' => 'required|between:1,255',
            'assigned_to' => 'required',
            'tasktype_id' => 'required',
            'priority' => 'required',
            'client_id' => 'required',
            'clientlocation_id' => 'required',
            'due_date' => 'required',
            //'is_active' => 'required|in:1,0',
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
                    $element->client_obj = $element->client->toJson();
                }
            }
            if ($element->clientlocation()->exists()) {
                $element->clientlocation_obj = $element->clientlocation->toJson();
                $element->clientlocation_name = $element->clientlocation->name;

                $element->clientlocationtype_id = $element->clientlocation->clientlocationtype_id;
                $element->clientlocationtype_name = $element->clientlocation->clientlocationtype_name;

                $element->clientlocation_obj = $element->clientlocation->toJson();

                $element->division_id = $element->clientlocation->division_id;
                $element->division_name = $element->clientlocation->division_name;

                $element->district_id = $element->clientlocation->district_id;
                $element->district_name = $element->clientlocation->district_name;

                $element->upazila_id = $element->clientlocation->upazila_id;
                $element->upazila_name = $element->clientlocation->upazila_name;

                $element->longitude = $element->clientlocation->longitude;
                $element->latitude = $element->clientlocation->latitude;
            }
            if ($element->tasktype()->exists()) {
                $element->tasktype_name = $element->tasktype->name;
            }
            //storing previous status
            if ($element->getOriginal('status') != $element->status) {
                $element->previous_status = $element->getOriginal('status');
            }
            //update assignment and closed by
            if ($element->status == 'Closed') {
                $element->is_closed = 1;
                $element->closed_by = $element->assigned_to;
                if (count($element->assignments) > 0) {
                    foreach ($element->assignments as $assignment) {
                        $assignment->is_closed = 1;
                        $assignment->save();
                    }
                }
            }

            $element->is_active = 1;

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
            if ($element->assignee()->exists()) {
                $emails = [];
                if (isset($element->watchers)) {
                    foreach ($element->watchers as $user_id) {
                        $emails[] = User::find($user_id)->email;
                    }
                }
                //send mail to the assignee when task is created
                \Mail::to($element->assignee->email)
                    ->cc($emails)->send(
                        new TaskCreated($element)
                    );
            }

            $element->status = 'To do'; // Set initial status to draft.

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
            $valid = true;
            //creating assignement based on changing of assingee
            if (isset($element->assigned_to)) {
                if ($element->getOriginal('assigned_to') != $element->assigned_to) {
                    //if assignment does not exists
                    $assignment = Assignment::create([
                        'name' => $element->name,
                        'type' => $element->tasktype_id,
                        'module_id' => '29',
                        'element_id' => $element->id,
                        'assigned_by' => user()->id,
                        'assigned_to' => $element->assigned_to,
                    ]);
                    //filling the assignment id in task table
                    $element->assignment_id = $assignment->id;
                    $valid = setMessage("Assignment created");
                }
            }
            Statusupdate::log($element, [
                'status' => $element->status,
            ]);
            return $valid;
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
     * @param  bool|false $setMsgSession setting it false will not store the message in session
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
     * @param  null $user_id
     * @return bool
     */
    public function isViewable($user_id = null, $set_msg = false) {

        $valid = false;
        if ($valid = spyrElementViewable($this, $user_id)) {
            $valid = false;
            if ($this->created_by == User()->id) {
                $valid = true;
            } else {
                if ($this->assigned_to == User()->id) {
                    $valid = true;
                } else {
                    if (User()->isSuperUser()) {
                        $valid = true;
                    }
                }
            }
            //if ($valid && somethingElse()) $valid = false;
        }
        return $valid;
    }

    /**
     * Checks if the $module is editable by current or any user passed as parameter.
     * spyrElementEditable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     * @param  null $user_id
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
     * @param  null $user_id
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
     * @param  null $user_id
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
    public function assignee() {
        return $this->belongsTo(\App\User::class, 'assigned_to');
    }

    public function flagger() {
        return $this->belongsTo(\App\User::class, 'flagged_by');
    }

    public function verifier() {
        return $this->belongsTo(\App\User::class, 'verified_by');
    }

    public function resolver() {
        return $this->belongsTo(\App\User::class, 'resolved_by');
    }

    public function closer() {
        return $this->belongsTo(\App\User::class, 'closed_by');
    }

    public function clientlocation() {
        return $this->belongsTo(\App\Clientlocation::class);
    }

    public function tasktype() {
        return $this->belongsTo(\App\Tasktype::class);
    }

    public function subtasks() {
        return $this->hasMany(\App\Task::class, 'parent_id');
    }

    public function assignments() {
        return $this->hasMany(\App\Assignment::class, 'element_id');
    }

    public function client() {
        return $this->belongsTo(\App\Client::class);
    }


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

    /**
     * @return mixed
     */
    public function getWatcherObjsAttribute() {
        if (isset($this->watchers))
            return User::whereIn('id', $this->watchers)->remember(cacheTime('long'))->get();
        return null;
    }

    /**
     * @return string
     */
    public function getPrioritiesNameAttribute() {
        if (isset($this->priority)) {
            if ($this->priority == 0) {
                return 'Low';
            } else if ($this->priority == 1) {
                return 'Normal';
            } else if ($this->priority == 2) {
                return 'High';
            }
        }
        return null;
    }

}
