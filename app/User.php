<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App;

use Request;
use App\Traits\IsoModule;
use App\Observers\UserObserver;
use App\Traits\ProhoriUserTrait;
use App\Traits\IsoUserPermission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property bool $email_confirmed
 * @property string|null $email_confirmed_at
 * @property string|null $email_confirmation_code
 * @property string|null $access_token
 * @property string|null $access_token_generated_at
 * @property string|null $api_token
 * @property string|null $api_token_generated_at
 * @property bool $tenant_editable
 * @property string|null $permissions
 * @property string|null $  groups
 * @property string|null $group_ids_csv
 * @property string|null $group_titles_csv
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupIdsCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupTitlesCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid($value)
 * @mixin \Eloquent
 * @property int|null $partner_id
 * @property string|null $partner_name
 * @property int|null $charity_id
 * @property string|null $charity_name
 * @property string|null $name_initial
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $gender
 * @property string|null $avatar_url
 * @property string|null $profile_pic_url
 * @property string|null $device_token
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property int|null $notification_count
 * @property \Carbon\Carbon|string|null $first_login_at
 * @property \Carbon\Carbon|string|null $last_login_at
 * @property float|null $total_earnings
 * @property float|null $total_donations
 * @property int|null $recommendation_count
 * @property int|null $purchase_count
 * @property string|null $next_billing_at
 * @property string|null $share_code
 * @property string|null $paypal_email
 * @property string|null $payment_settings
 * @property string|null $account_holder_name
 * @property string|null $account_number
 * @property string|null $account_type
 * @property string|null $account_country
 * @property string|null $account_city
 * @property string|null $account_state
 * @property string|null $account_post_code
 * @property string|null $account_first_line
 * @property string|null $sort_code
 * @property string|null $abartn
 * @property string|null $iban
 * @property string|null $swift
 * @property string|null $auth_token
 * @property string|null $device_name
 * @property string|null $current_app_version
 * @property string|null $transferwise_account_id
 * @property string|null $session_secret
 * @property-read \App\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $groups
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAbartn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountFirstLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAuthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrentAppVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNameInitial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNextBillingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePaymentSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfilePicUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePurchaseCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRecommendationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSessionSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereShareCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTotalDonations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTotalEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTransferwiseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereZipCode($value)
 * @property string|null $email_verified_at
 * @property string|null $partner_uuid
 * @property string|null $charity_uuid
 * @property mixed $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerUuid($value)
 * @property-read \App\Country|null $country
 * @property-read \App\Upload $latestUpload
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrency($value)
 * @property string|null $social_account_id
 * @property string|null $social_account_type
 * @property int|null $gift_aid_checked
 * @property-read mixed $avatar
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGiftAidChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialAccountType($value)
 * @property string|null $email_verification_code
 * @property array|null $group_ids
 * @property int|null $employee_id
 * @property int|null $designation_id
 * @property string|null $designation_name
 * @property int|null $department_id
 * @property string|null $department_name
 * @property-read \App\Department|null $department
 * @property-read \App\Designation|null $designation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDesignationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupIds($value)
 * @property array|null $watchers
 * @property array|null $operating_area_ids
 * @property string|null $operating_area_names
 * @property-read mixed $operating_area_ids_objects
 * @property-read mixed $watcher_objs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOperatingAreaIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOperatingAreaNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWatchers($value)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use IsoModule;
    use IsoUserPermission;
    use ProhoriUserTrait;

    // use Rememberable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'email',
        'password',
        'remember_token',
        'email_verification_code',
        'email_verified_at',
        'access_token',
        'access_token_generated_at',
        'api_token',
        'api_token_generated_at',
        'auth_token',
        'session_secret',
        'tenant_editable',
        'permissions',
        'group_ids',
        'group_ids_csv',
        'group_titles_csv',
        'employee_id',
        'name_initial',
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'profile_pic_url',
        'currency',
        'device_token',
        'address1',
        'address2',
        'city',
        'county',
        'country_id',
        'country_name',
        'zip_code',
        'phone',
        'mobile',
        'first_login_at',
        'last_login_at',
        'social_account_id',
        'social_account_type',
        'is_active',
        'designation_id',
        'department_id',
        'watchers',
        'operating_area_ids',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'group_ids' => 'array',
        'watchers' => 'array',
        'operating_area_ids' => 'array',
    ];

    /**
     * List of appended attribute. This attributes will be loaded in each Model
     * @var array
     */
    protected $appends = ['avatar', 'watcher_objs', 'operating_area_ids_objects'];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public static $custom_validation_messages = [
        //'name.required' => 'Custom message.',
    ];
    /**
     * Allowed permissions values.
     * Possible options:
     *   -1 => Deny (adds to array, but denies regardless of user's group).
     *    0 => Remove.
     *    1 => Add.
     * @var array
     */
    protected $allowedPermissionsValues = [-1, 0, 1];
    /**
     * Automatic eager load relation by default (can be expensive)
     * @var array
     */
    protected $with = ['groups'];

    /**
     * Validation rules. For regular expression validation use array instead of pipe
     * Example: 'name' => ['required', 'Regex:/^[A-Za-z0-9\-! ,\'\"\/@\.:\(\)]+$/']
     * @param       $element
     * @param  array $merge
     * @return array
     */
    public static function rules($element, $merge = []) {
        $rules = [
            //'name' => ['required', 'between:3,255', 'unique:users,name' . (isset($element->id) ? ",$element->id" : '')],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'group_ids' => 'required',
            'email' => 'required|email|unique:users,email,' . (isset($element->id) ? $element->id : 'null') . ',id,deleted_at,NULL',
            //'employee_id' =>'integer',
            // 'address1' => 'between:0,512',
            // 'address2' => 'between:0,512',
            // 'city' => 'between:0,64',
            // 'county' => 'between:0,64',
            // 'zip_code' => 'between:0,20',
            // 'phone' => 'between:0,20',
            // 'mobile' => 'between:0,20',
        ];

        // While creation/registration of user password and password_confirm both should be available
        // Also if one password is given the other one should be given as well
        // While creation/registration of user password and password_confirm both should be available
        if (!isset($element->id)) {
            $rules = array_merge($rules, [
                'password' => 'required|min:6|confirmed',
            ]);
        } else {
            if (Request::get('password')) {
                $rules = array_merge($rules, [
                    'password' => 'min:6|confirmed',
                ]);
            }
        }
        //for manager add this validations
        if (user()->isManagerUser()) {
            $rules = array_merge($rules, [
                'operating_area_ids' => 'required',
                'watchers' => 'required',

            ]);
        }

        return array_merge($rules, $merge);
    }

    ############################################################################################
    # Model events
    ############################################################################################

    public static function boot() {
        /**
         * parent::boot() was previously used. However this invocation stops from the other classes
         * of other spyr modules(Models) to override the boot() method. Need to check more.
         * make the parent (Eloquent) boot method run.
         */
        parent::boot();
        User::observe(UserObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (User $element) {
        //     // Check if hte email domain is banned.
        //     //return false;
        // });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (User $element) {
        //     if ($element->inGroupIds([8])) {
        //         $element->sendRegistrationWithVerificationNotification();
        //     }
        // });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        // static::updated(function (User $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (User $element) {
            $valid = true;
            $element = $element->resolveName();

            // Generate new api token
            if (Request::get('api_token_generate') === 'yes') {
                $element->api_token = hash('sha256', randomString(10), false);
            }

            if (is_array($element->group_ids)) {
                $group_ids = $element->group_ids;
                $element->group_ids = json_encode($element->group_ids);
            } else {
                $group_ids = json_decode($element->group_ids);
            }

            // Set group selection limit
            $max_groups = 1;
            if (is_array($group_ids) && (count($group_ids) > $max_groups)) {
                $valid = setError("You can assign only {$max_groups} group.");
            }
            if (is_array($group_ids) && count($group_ids)) {
                $element->group_ids_csv = implode(',', Group::whereIn('id', $group_ids)->pluck('id')->toArray());
                $element->group_titles_csv = implode(',', Group::whereIn('id', $group_ids)->pluck('title')->toArray());
            }

            // fill common fields, null-fill, trim blanks from Request
            if ($valid) {

                if ($element->country()->exists()) {
                    $element->country_name = $element->country->name;
                    $element->currency = $element->country->currency();
                }

                if ($element->designation()->exists()) {
                    $element->designation_name = $element->designation->name;
                }
                if ($element->department()->exists()) {
                    $element->department_name = $element->department->name;
                }

                if (!isset($element->is_active)) {
                    $element->is_active = ($element->email_confirmed == 1) ? 1 : 0;
                }

                if ($element->is_active && $element->email_verified_at === null) {
                    $element->email_verified_at = now();
                }
                if (isset($element->first_name) && isset($element->last_name) && !isset($element->full_name)) {
                    $element->full_name = $element->first_name . $element->last_name;
                }
                if (!isset($element->profile_pic_url)) {
                    $element->profile_pic_url = '/files/male.png';
                    if (isset($element->gender)) {
                        if ($element->gender === "female") {
                            $element->profile_pic_url = '/files/female.png';
                        }
                    }
                }
            }

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (User $element) {
            // Sync partner_category table
            $element->groups()->sync($element->group_ids);

        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (User $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (User $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (User $element) {});
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
     * Resolve name based on given input.
     */
    public function resolveName() {
        // No 'name' field is
        if (!isset($this->name)) {
            $this->full_name = $this->first_name . " " . $this->last_name;
            $this->name = $this->full_name;
        }

        return $this;
    }

    /**
     * Get the last uploaded avatar
     */
    public function avatar() {
        if ($this->uploads()->exists()) {
            return $this->uploads->where('type', 'Avatar')->first();
        }
        return null;
    }

    /**
     * Construct address
     * @return string
     */
    public function address() {
        $str = '';

        $fields = [
            'address1',
            'address2',
            'city',
            'county',
            'country_name',
            'zip_code'
        ];

        foreach ($fields as $field) {
            if (strlen($this->$field)) {
                $str .= $this->$field . ', ';
            }
        }

        return trim($str, ', ');
    }

    /**
     * Find user based on bearer token(auth_token)
     * @param $bearer_token
     * @return mixed|null
     */
    public static function ofBearer($bearer_token) {
        // $user = null;
        // // Try to find the user.
        // if (\Cache::has('user' . $bearer_token)) {
        //     $user = \Cache::get('user' . $bearer_token);
        // } else {
        //     $minutes = now()->addMinutes(60);
        //     $user = \Cache::remember('user' . $bearer_token, $minutes, function () use ($bearer_token) {
        //         return User::where('auth_token', $bearer_token)->first();
        //     });
        // }
        // return $user;

        if ($bearer_token) {
            return User::where('auth_token', $bearer_token)->first();
        }
        return null;
    }

    /**
     * Generates auth_token (bearer token) for this user.
     * @return bool|string
     */
    public function generateAuthToken() {
        return substr(bcrypt($this->email . '|' . $this->password . '|' . date("Y-m-d H:i:s")), 10, 32);
    }

    /**
     * Email notification sent to user when he logs in for the first time.
     */
    public function sendRegistrationWithVerificationNotification() {
        userRegistrationWithVerificationNotification($this);
    }

    /**
     * Email notification sent to user when he logs in for the first time.
     */
    public function firstLoginNotification() {
        userFirstLoginNotification($this);
    }

    /**
     * Send the email verification notification.
     * @return void
     */
    public function sendEmailVerificationNotification() {
        emailVerificationNotification($this);
        //$this->notify(new Notifications\VerifyEmail);
    }

    /**
     * Send the password reset notification.
     * @param  string $token
     */
    public function sendPasswordResetNotification($token) {
        //$this->notify(new ResetPasswordNotification($token));
        resetPasswordNotification($this, $token);
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
     * Checks if user belongs to super admin group.
     * This function is created with an idea so that some more admin groups i.e. LB-admin, LB-accounts
     * etc can be covered/included in this same group.
     * @return bool
     */
    public function ofSuperadminGroup() {
        return $this->inGroupIds(Group::superadminGroupIds());
    }

    /**
     * Checks if the $element is viewable by current or any user passed as parameter.
     * spyrElementViewable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     * @param  null $user_id
     * @param  bool $set_msg
     * @return bool
     */
    public function isViewable($user_id = null, $set_msg = false) {
        /** @var \App\User $user */
        $user = user($user_id);
        if (!spyrElementViewable($this, $user_id, $set_msg)) {
            return false;
        }
        // Allow super user
        if ($user->isSuperUser()) {
            return true;
        }
        return false;
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
    //public function updater() { return $this->belongsTo('User', 'updated_by'); }
    //public function creator() { return $this->belongsTo('User', 'created_by'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() { return $this->belongsToMany(Group::class, 'user_group')->remember(cacheTime('very-short')); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() { return $this->belongsTo(Country::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designation() { return $this->belongsTo(Designation::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department() { return $this->belongsTo(Department::class); }


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

    /**
     * Mutator for giving permissions.
     * @param  mixed $permissions
     * @return array  $_permissions
     */
    public function getPermissionsAttribute($permissions) {
        if (!$permissions) {
            return [];
        }

        if (is_array($permissions)) {
            return $permissions;
        }

        if (!$_permissions = json_decode($permissions, true)) {
            throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
        }

        return $_permissions;
    }

    /**
     * Mutator for taking permissions.
     * @param  array $permissions
     * @return string
     */
    public function setPermissionsAttribute(array $permissions) {
        // Merge permissions
        $permissions = array_merge($this->permissions, $permissions);

        // Loop through and adjust permissions as needed
        foreach ($permissions as $permission => &$value) {
            // Lets make sure there is a valid permission value
            if (!in_array($value = (int)$value, $this->allowedPermissionsValues)) {
                throw new \InvalidArgumentException("Invalid value [$value] for permission [$permission] given.");
            }

            // If the value is 0, delete it
            if ($value === 0) {
                unset($permissions[$permission]);
            }
        }

        $this->attributes['permissions'] = (!empty($permissions)) ? json_encode($permissions) : '';
    }

    // Write accessors and mutators here.

    public function getAvatarAttribute() {
        if ($this->avatar()) {
            return $this->avatar()->url;
        }
        return null;
    }

    /**
     * Set partnercategory ids to array
     * @param  array $value
     * @return void
     */
    public function setGroupIdsAttribute($value) {
        // Original default value
        $this->attributes['group_ids'] = $value;

        // 1. If the value is originally array converts array to json
        if (is_array($value)) {
            $this->attributes['group_ids'] = json_encode(cleanArray($value));
        }
        //2 .If the original value is CSV converts array to json
        // if (isCsv($value)) {
        //     $this->attributes['included_country_ids'] = json_encode(csvToArray($value));
        // }

    }

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

    public function setOperatingAreaIdsAttribute($value) {
        // Original default value
        $this->attributes['operating_area_ids'] = $value;

        // 1. If the value is originally array converts array to json
        if (is_array($value)) {
            $this->attributes['operating_area_ids'] = json_encode(cleanArray($value));
        }
        //2 .If the original value is CSV converts array to json
        // if (isCsv($value)) {
        //     $this->attributes['included_country_ids'] = json_encode(csvToArray($value));
        // }

    }

    public function getOperatingAreaIdsObjectsAttribute() {
        if (isset($this->operating_area_ids))
            return Operatingarea::whereIn('id', $this->operating_area_ids)->remember(cacheTime('long'))->get();
        return null;
    }

}
