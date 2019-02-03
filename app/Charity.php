<?php

namespace App;

use App\Observers\CharityObserver;
use App\Traits\IsoModule;
use DB;
use Request;

/**
 * Class Charity
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
 * @method static \Illuminate\Database\Query\Builder|\App\Charity onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Charity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Charity withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $code
 * @property string|null $slug
 * @property int|null $order
 * @property string|null $description
 * @property string|null $website
 * @property string|null $logo_url
 * @property string|null $registration_no
 * @property string|null $ein_no
 * @property string|null $contact_name
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $contact_address
 * @property string|null $finance_contact_name
 * @property string|null $finance_contact_email
 * @property string|null $finance_contact_phone
 * @property string|null $finance_contact_address
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property float|null $total_donations_received
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
 * @property string|null $currency
 * @property string|null $account_name
 * @property string|null $bank_name
 * @property string|null $bank_account_address
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAbartn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountFirstLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereBankAccountAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereContactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereEinNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereFinanceContactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereFinanceContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereFinanceContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereFinanceContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity wherePaymentSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereRegistrationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereSortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereTotalDonationsReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereZipCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Country|null $country
 * @property-read \App\Upload $latestUpload
 * @property string|null $included_country_ids
 * @property string|null $excluded_country_ids
 * @property int|null $is_published
 * @property-read mixed $block_logo
 * @property-read mixed $logo
 * @property-read \App\Invoice $lastInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereExcludedCountryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereIncludedCountryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charity whereIsPublished($value)
 */
class Charity extends Basemodule
{
    use IsoModule;
    /**
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'code',
        'slug',
        'order',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'website',
        'logo_url',
        'registration_no',
        'ein_no',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_address',
        'finance_contact_name',
        'finance_contact_email',
        'finance_contact_phone',
        'finance_contact_address',
        'address1',
        'address2',
        'city',
        'county',
        'country_id',
        'country_name',
        'zip_code',
        'phone',
        'mobile',
        'total_donations_received',
        'paypal_email',
        'payment_settings',
        'account_holder_name',
        'account_number',
        'account_type',
        'account_country',
        'account_city',
        'account_state',
        'account_post_code',
        'account_first_line',
        'sort_code',
        'abartn',
        'iban',
        'swift',
        'currency',
        'account_name',
        'bank_name',
        'bank_account_address',
        'included_country_ids',
        'excluded_country_ids',
        'is_published',
    ];

    /**
     * List of appended attribute. This attributes will be loaded in each Model
     *
     * @var array
     */
    protected $appends = ['block_logo', 'logo'];
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
            'name' => 'required|between:1,255|unique:charities,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            'is_active' => 'required|in:1,0',
            'is_published' => 'in:1,0',
            'code' => 'required',
            'website' => 'required|url',
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required',
            'description' => 'required',
            'finance_contact_email' => 'sometimes|nullable|email',
            'included_country_ids' => 'between:0,5000',
            'excluded_country_ids' => 'between:0,5000',
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
        'website.url' => 'Please enter a valid website url.',
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
        Charity::observe(CharityObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Charity $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Charity $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Charity $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Charity $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Charity $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            /*
             * Handle country inclusion/exclusion
             *****************************************/
            $element->included_country_ids = $element->excluded_country_ids = null;

            if (inputIsArray('included_country_ids')) {
                $element->included_country_ids = implode(',', Request::get('included_country_ids'));
            }
            if (inputIsArray('excluded_country_ids')) {
                $element->excluded_country_ids = implode(',', Request::get('excluded_country_ids'));
            }
            if (strlen($element->included_country_ids) && strlen($element->excluded_country_ids)) {
                $valid = setError('You can either include or exclude a list of countries.');
            }
            if ($valid) {
                if ($element->country()->exists()) {
                    $element->country_name = $element->country->name;
                    $element->currency = $element->country->currency();
                }
            }
            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        // static::saved(function (Charity $element) {});

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Charity $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Charity $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Charity $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Charity $element) {});
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
     * Construct address
     * @return string
     */
    public function address()
    {
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
     * This function returns an array of charity ids that are viewable by a specific user
     *
     * @param \App\User $user
     * @return array
     */
    public static function idsOfCharityViewableByUser($user) {
        return Charity::pluck('id')->toArray();
    }

    /**
     * Get the last uploaded Charity block logo.
     */
    public function blockLogo() {
        return $this->uploads->where('type', 'Block-logo')->first();
    }

    /**
     * Get the last uploaded Charity cover logo
     */
    public function logo() {
        return $this->uploads->where('type', 'Logo')->first();
    }

    /**
     * Calculate last billing date. If charity has an existing invoice then the take
     * the last invoice date.If not then consider created_at to be the last billing
     * date (theoretically) for the sake of calculation.
     *
     * @return string
     */
    public function lastBillingDate() {
        if ($this->lastInvoice()->exists()) {
            $date = $this->lastInvoice->created_at;
        } else {
            $date = $this->created_at; // Update calculation
        }

        return $date->toDateString(); // Return a date Not datetime
    }

    /**
     * Calculate charity next billing date
     *
     * @return \Carbon\Carbon
     */
    public function nextBillingDate() {
        /** @var \App\User $this */
        $billing_date = $this->created_at->addDays(45);
        return $billing_date; // Return a date Not datetime
    }

    /**
     * Get next billing details of the charity with (possible)amount and date.
     *
     * @param null $currency
     * @return array
     */
    public function nextBilling($currency = null) {
        // Auto-resolve user currency if not set
        if (!$currency) $currency = $this->currency;

        $amount = $this->nextBillingAmount($currency);
        $date = $this->nextBillingDate();

        $ret = [
            'currency' => $amount['currency'],
            'currency_symbol' => currencySymbol($amount['currency']),
            'amount' => $amount['amount'],
            'date' => $date,
        ];

        return $ret;
    }

    /**
     * Next billing amount (Total earning for next billing)
     *
     * @param null $currency
     * @return array
     */
    public function nextBillingAmount($currency = null) {
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('charity_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>', $this->lastBillingDate())
            ->where(DB::raw('date(created_at)'), '<=', $this->nextBillingDate())
            ->sum('charity_donation_charity_currency');

        $total = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
        ];

        return $total;
    }

    /**
     * Calculate total donation received by a charity till today. This amount includes
     * donation amount of current billing cycle also which is not yet paid(transferred)
     * to charity but will be paid(probably) on the upcoming billing date of charity.
     *
     * @param null $currency
     * @return array
     */
    public function totalDonation($currency = null) {
        return $this->totalDonationDuring(null, null, $currency);
    }

    /**
     * Calculate total donation received on a specific day.
     *
     * @param null $date
     * @param null $currency
     * @return array
     */
    public function totalDonationOn($date = null, $currency = null) {
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$date) $date = today()->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('charity_id', $this->id)
            ->where(DB::raw('date(created_at)'), $date)
            ->sum('charity_donation_charity_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'date' => $date
        ];

        return $ret;
    }

    /**
     * Calculate total donation received by a charity on a range of days.
     *
     * @param null $start_date
     * @param null $end_date
     * @param null $currency
     * @return array
     */
    public function totalDonationDuring($start_date = null, $end_date = null, $currency = null) {
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$start_date) $start_date = $this->created_at->format('Y-m-d'); // By default set $start_date to user creation date.
        if (!$end_date) $end_date = today()->toDateString(); // By default set end date to today.
        //$end_date_plus_one = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('charity_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>=', $start_date)
            ->where(DB::raw('date(created_at)'), '<=', $end_date)
            ->sum('charity_donation_charity_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $ret;
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
    public function country() { return $this->belongsTo(Country::class); }

    /**
     * @return mixed|Invoice
     */
    public function lastInvoice() {
        return $this->hasOne(Invoice::class, 'charity_id')->orderBy('created_at', 'desc');
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

    public function getBlockLogoAttribute() {
        if ($this->blockLogo()) return $this->blockLogo()->url;
        return null;
    }

    public function getLogoAttribute() {
        if ($this->logo()) return $this->logo()->url;
        return null;
    }

}
