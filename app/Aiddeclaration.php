<?php

namespace App;

use App\Observers\AiddeclarationObserver;
use App\Traits\IsoModule;

/**
 * Class Aiddeclaration
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
 * @method static \Illuminate\Database\Query\Builder|\App\Aiddeclaration onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Aiddeclaration withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Aiddeclaration withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration query()
 * @property int|null $user_id
 * @property int|null $charityselection_id
 * @property int|null $charity_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property int|null $is_acknowledged
 * @property string|null $email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Charity|null $charity
 * @property-read \App\Charityselection|null $charityselection
 * @property-read \App\Country|null $country
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCharityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCharityselectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereIsAcknowledged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereZipCode($value)
 * @property string|null $date_of_declaration
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Aiddeclaration whereDateOfDeclaration($value)
 */
class Aiddeclaration extends Basemodule
{
    use IsoModule;
    /**
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'charityselection_id',
        'charity_id',
        'first_name',
        'last_name',
        'full_name',
        'address1',
        'address2',
        'city',
        'county',
        'country_id',
        'country_name',
        'zip_code',
        'phone',
        'mobile',
        'is_acknowledged',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'email',
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
    public static function rules($element, $merge = [])
    {
        $rules = [
            //'name' => 'required|between:1,255|unique:aiddeclarations,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            //'is_active' => 'required|in:1,0',
            'user_id' => 'required',
            //'charity_id' => 'required',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',
            // 'is_acknowledged' => 'required|in:1',

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
        Aiddeclaration::observe(AiddeclarationObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Aiddeclaration $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Aiddeclaration $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Aiddeclaration $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Aiddeclaration $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Aiddeclaration $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            if ($valid) {

                // Fill fields
                $element->is_active = 1;
                $element->country_name = $element->country()->exists() ? $element->country->name : null;

                /**
                 * Resolve values from current charity selection of user.
                 ********************************************************/
                if ($element->user->currentCharityselection()->exists()) {
                    $charityselection = $element->user->currentCharityselection;
                    $element->charityselection_id = $charityselection->id;
                    $element->charity_id = $charityselection->charity_id;
                }

                /**
                 * If not given explicitly then auto fill from user.
                 ***************************************************/
                $user = $element->user;
                $element->email = isset($element->email) ? $element->email : $user->email;
                $element->first_name = isset($element->first_name) ? $element->first_name : $user->first_name;
                $element->last_name = isset($element->last_name) ? $element->last_name : $user->last_name;
                $element->full_name = $element->first_name . " " . $element->last_name;
                $element->address1 = isset($element->address1) ? $element->address1 : $user->address1;
                $element->address2 = isset($element->address2) ? $element->address2 : $user->address2;
                $element->city = isset($element->city) ? $element->city : $user->city;
                $element->county = isset($element->county) ? $element->county : $user->county;
                $element->country_id = isset($element->country_id) ? $element->country_id : $user->country_id;

                if ($element->country()->exists()) {
                    $element->country_name = $element->country->name;
                }

                $element->zip_code = isset($element->zip_code) ? $element->zip_code : $user->zip_code;
                $element->phone = isset($element->phone) ? $element->phone : $user->phone;
                $element->mobile = isset($element->mobile) ? $element->mobile : $user->mobile;

            }

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        // static::saved(function (Aiddeclaration $element) {});

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Aiddeclaration $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Aiddeclaration $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Aiddeclaration $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Aiddeclaration $element) {});
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
     * Get the latest aid declaration by a user.
     *
     * @param $user \App\User
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function latestByUser($user)
    {
        return Aiddeclaration::where('user_id', $user->id)->where('is_active', 1)
            ->orderBy('created_at', 'desc')->first();
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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() { return $this->belongsTo(User::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() { return $this->belongsTo(Country::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charityselection() { return $this->belongsTo(Charityselection::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charity() { return $this->belongsTo(Charity::class); }

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
