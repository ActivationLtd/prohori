<?php

namespace App;

use App\Observers\UploadObserver;
use App\Traits\IsoModule;
use ImageOptimizer;

/**
 * Class Upload
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
 * @method static \Illuminate\Database\Query\Builder|\App\Upload onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload query()
 * @property string|null $type
 * @property string|null $path
 * @property int|null $order
 * @property string|null $ext
 * @property int|null $bytes
 * @property string|null $description
 * @property int|null $module_id
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereBytes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUuid($value)
 * @property-read mixed $dir
 * @property-read bool $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 * @property float|null $latitude
 * @property float|null $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereLongitude($value)
 */
class Upload extends Basemodule
{
    //use IsoModule;
    /**
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'type',
        'path',
        'order',
        'ext',
        'bytes',
        'description',
        'module_id',
        'element_id',
        'latitude',
        'longitude',
        'distance',
        'distance_flag_id',
        'distacne_flag_name',
        'element_uuid',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * List of appended attribute. This attributes will be loaded in each Model
     *
     * @var array
     */
    protected $appends = ['url', 'dir'];

    /**
     * List of allowed types
     *
     * @var array
     */
    public static $types = ['Profile photo', 'Logo', 'Task file', 'Evidence'];

    public static $upload_flags = [
        '0' => 'Green',
        '1' => 'Yellow',
        '2' => 'Red'
    ];
    /**
     * Disallow from mass assignment. (Black-listed fields)
     *
     * @var array
     */
    // protected $guarded = [];

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
            // 'name' => 'required|between:1,255|unique:uploads,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            // 'is_active' => 'required|in:1,0',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',
            //'latitude' => 'numeric|between:20.661913,26.635695',
            //'longitude' => 'numeric|between:88.002548,92.675171',
            'type' => 'in:' . implode(',', Upload::$types),

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
        Upload::observe(UploadObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Upload $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Upload $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Upload $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Upload $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Upload $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            if ($valid) {
                $element->is_active = 1; // Always set as 'Yes'
                $element->ext = extFrmPath($element->path); // Store file extension separately
            }
            //calculating distance
            if ($element->module_id == 29) {
                $task = Task::find($element->element_id);
                if (isset($task->clientlocation->longitude, $task->clientlocation->latitude, $element->latitude, $element->longitude)) {
                    $element->distance = getDistanceBetweenPoints($element->latitude, $element->longitude, $task->clientlocation->longitude, $task->clientlocation->latitude);
                }
            }
            if ($valid) {
                if ($element->distance > 0 && $element->distance < 200) {
                    $element->distance_flag_id = 0;
                    $element->distance_flag_name = 'Green';
                } else if ($element->distance > 200 && $element->distance < 400) {
                    $element->distance_flag_id = 1;
                    $element->distance_flag_name = 'Yellow';
                } else {
                    $element->distance_flag_id = 2;
                    $element->distance_flag_name = 'Red';
                }
            }
            if(file_exists(public_path($element->path))){
                ImageOptimizer::optimize(public_path($element->path));
            }

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Upload $element) {
            if ($element->type == 'Profile photo') {
                Upload::where('module_id', $element->module_id)->where('element_id', $element->element_id)
                    ->where('type', $element->type)->where('id', '!=', $element->id)
                    ->delete();
            }
            if ($element->type == 'Profile photo' && $element->module_id == 4) {
                User::where('id', $element->element_id)->update(['profile_pic_url' => $element->path]);
            }
        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Upload $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        static::deleted(function (Upload $element) {
            if ($element->type == 'Profile photo' && $element->module_id == 4) {
                User::where('id', $element->element_id)->update(['profile_pic_url' => null]);
            }
        });

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Upload $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Upload $element) {});
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

    /**
     * get all uploads under a module
     *
     * @param array $entry_uuid
     * @param string $filter
     * @return mixed
     */
    public static function getList($entry_uuid, $filter = '') // TODO : filter logic incomplete
    {
        $uploads = Upload::where('element_uuid', $entry_uuid);
        return $uploads->orderBy('created_at', 'DESC')->get();
    }

    /**
     * During creation of a module entry there is no id but still files can be uploaded.
     * At this time system creates an uuid and stores files against that uuid.
     * Once the creation is successful
     *
     * @param $element_id
     * @param $element_uuid
     */
    public static function linkTemporaryUploads($element_id, $element_uuid) {
        Upload::where('element_uuid', $element_uuid)->update([
            'element_id' => $element_id,
        ]);
    }

    /**
     * returns the absolute server path.
     * This function is useful for plugins that needs the file location in the operating system
     *
     * @return string
     */
    public function absPath() {
        return public_path() . $this->path;
    }

    /**
     * Get the url for thumbnail of an upload.
     *
     * @return string
     */
    public function thumbSrc() {

        if ($this->isImage())
            $src = route('get.download', $this->uuid);
        else
            $src = $this->extIconPath();

        return $src;
    }

    /**
     * Checks if an upload file is image
     *
     * @return mixed
     */
    public function isImage() {
        if (isImageExtension($this->ext)) {
            return true;
        }
        return false;
    }

    /**
     * 'file_type_icons' contains number of file type icons.
     *
     * @return string
     */
    public function extIconPath() {
        $ext = strtolower($this->ext); // get full lower case extension
        $icon_path = 'file_type_icons/' . $ext . '.png';

        if (!\File::exists($icon_path)) {
            $icon_path = 'file_type_icons/noimage.png';
        }
        return asset($icon_path);
    }

    /**
     * Generate masked and plain url of the uploaded file.
     *
     * @param bool $auth set false to generate plain url.
     * @return string
     */
    public function downloadUrl($auth = true) {
        if ($auth) return route('get.download', $this->uuid);
        return asset($this->path);
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
    //public function updater() { return $this->belongsTo('User', 'updated_by'); }
    //public function creator() { return $this->belongsTo('User', 'created_by'); }

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

    // Write new dynamic query scopes here.
    ############################################################################################
    # Additional/Appended attributes
    # ---------------------------------------------------------------------------------------- #
    ############################################################################################

    /**
     * Function to return an appended attribute in a Model. The attribute name
     * should be added in $append array.
     *
     * @return bool
     */
    public function getUrlAttribute() {
        return asset($this->path);
    }

    public function getDirAttribute() {
        return public_path() . $this->path;
    }

}
