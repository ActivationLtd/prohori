<?php

namespace App;

use App\Observers\PartnerObserver;
use App\Traits\IsoModule;
use Request;

/**
 * Class Partner
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
 * @method static \Illuminate\Database\Query\Builder|\App\Partner onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Partner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Partner withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $description
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $zip_code
 * @property int|null $country_id
 * @property string|null $country_name
 * @property int|null $partnercategory_id
 * @property string|null $partnercategory_name
 * @property int|null $is_featured
 * @property int|null $sitecms_id
 * @property string|null $sitecms_name
 * @property string|null $live_url_root
 * @property string|null $live_url_product
 * @property string|null $live_url_order_confirmation
 * @property string|null $live_access
 * @property string|null $stage_url_root
 * @property string|null $stage_url_product
 * @property string|null $stage_url_order_confirmation
 * @property string|null $stage_access
 * @property string|null $site_file_structure
 * @property string|null $integration_note
 * @property string|null $status
 * @property string|null $signup_date
 * @property string|null $test_date
 * @property string|null $go_live_date
 * @property int|null $order
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $legal_name
 * @property string|null $vat_no
 * @property string|null $integration_by
 * @property string|null $logo_url
 * @property string|null $logo_white_url
 * @property string|null $featured_img_url
 * @property string|null $representative_image_urls
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
 * @property string|null $it_contact_name
 * @property string|null $it_contact_email
 * @property string|null $it_contact_phone
 * @property string|null $it_contact_address
 * @property float|null $commission_percentage_lb
 * @property float|null $commission_percentage_recommender
 * @property float|null $commission_percentage_total
 * @property int|null $recommendation_expiry_in_days
 * @property int|null $recommendation_count
 * @property int|null $purchase_count
 * @property string|null $paypal_email
 * @property string|null $payment_settings
 * @property string|null $account_holder_name
 * @property string|null $bank_name
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
 * @property string|null $images
 * @property string|null $featured_images
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAbartn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountFirstLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCommissionPercentageLb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCommissionPercentageRecommender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCommissionPercentageTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereContactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereEinNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFeaturedImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFeaturedImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFinanceContactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFinanceContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFinanceContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFinanceContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereGoLiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIntegrationBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIntegrationNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereItContactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereItContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereItContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereItContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLegalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLiveAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLiveUrlOrderConfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLiveUrlProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLiveUrlRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLogoWhiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePartnercategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePartnercategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePaymentSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePurchaseCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereRecommendationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereRecommendationExpiryInDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereRegistrationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereRepresentativeImageUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSignupDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSiteFileStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSitecmsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSitecmsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereStageAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereStageUrlOrderConfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereStageUrlProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereStageUrlRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereTestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereVatNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereZipCode($value)
 * @property string|null $bank_account_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankAccountAddress($value)
 * @property-read \App\Country|null $country
 * @property-read bool $block_logo
 * @property-read mixed $cover_photo_horizontal
 * @property-read mixed $cover_photo_vertical
 * @property-read mixed $logo
 * @property-read \App\Upload $latestUpload
 * @property-read \App\Partnercategory|null $partnercategory
 * @property string|null $account_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAccountName($value)
 * @property string|null $included_country_ids
 * @property string|null $excluded_country_ids
 * @property int|null $is_published
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereExcludedCountryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIncludedCountryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereIsPublished($value)
 */
class Partner extends Basemodule
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
        'description',
        'address1',
        'address2',
        'city',
        'county',
        'zip_code',
        'country_id',
        'country_name',
        'partnercategory_id',
        'partnercategory_name',
        'is_featured',
        'sitecms_id',
        'sitecms_name',
        'live_url_root',
        'live_url_product',
        'live_url_order_confirmation',
        'live_access',
        'stage_url_root',
        'stage_url_product',
        'stage_url_order_confirmation',
        'stage_access',
        'site_file_structure',
        'integration_note',
        'status',
        'signup_date',
        'test_date',
        'go_live_date',
        'order',
        'phone',
        'mobile',
        'legal_name',
        'vat_no',
        'integration_by',
        'logo_url',
        'logo_white_url',
        'featured_img_url',
        'representative_image_urls',
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
        'it_contact_name',
        'it_contact_email',
        'it_contact_phone',
        'it_contact_address',
        'commission_percentage_lb',
        'commission_percentage_recommender',
        'commission_percentage_total',
        'recommendation_expiry_in_days',
        'recommendation_count',
        'purchase_count',
        'paypal_email',
        'payment_settings',
        'account_holder_name',
        'bank_name',
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
        'images',
        'featured_images',
        'bank_account_address',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'account_name',
        'included_country_ids',
        'excluded_country_ids',
        'is_published',
    ];

    /**
     * List of appended attribute. This attributes will be loaded in each Model
     *
     * @var array
     */
    protected $appends = ['block_logo', 'logo', 'cover_photo_horizontal', 'cover_photo_vertical'];

    /**
     * Disallow from mass assignment. (Black-listed fields)
     *
     * @var array
     */
    // protected $guarded = [];

    protected $hidden = [
        "logo_url",
        "logo_white_url",
        "featured_img_url",
        "representative_image_urls"
    ];

    /**
     * Date fields
     *
     * @var array
     */
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Partners current status.
     *
     * @var array
     */
    public static $statuses = [
        'Sandbox',
        'Live',
    ];

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
            'name' => 'required|between:1,255|unique:partners,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
        ];

        // Only all the fields are required when publishing a partner
        if ($element->is_published == 1 || $element->status === 'Live') {
            $rules = array_merge($rules, [
                'live_url_root' => 'required|url',
                'country_id' => 'required',
                //'partnercategory_id' => 'required',
                'address1' => 'required',
                'contact_name' => 'required',
                'contact_email' => 'required|email',
                'contact_phone' => 'required',
                //'is_featured' => 'required',
                'commission_percentage_lb' => 'required|numeric',
                'commission_percentage_recommender' => 'required|numeric',
                'recommendation_expiry_in_days' => 'required|numeric',
                //'finance_contact_email' => 'email',
                //'it_contact_email' => 'email',
                'status' => 'required|in:' . implode(',', self::$statuses),
                'is_active' => 'required|in:1,0',
                'is_published' => 'in:1,0',
                'included_country_ids' => 'between:0,5000',
                'excluded_country_ids' => 'between:0,5000',
                // 'tenant_id'  => 'required|tenants,id,is_active,1',
                // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
                // 'updated_by' => 'exists:users,id,is_active,1',
            ]);
        }

        return array_merge($rules, $merge);
    }

    /**
     * Custom validation messages.
     *
     * @var array
     */
    public static $custom_validation_messages = [
        'name.required' => 'The brand name field is required.',
        'address1.required' => 'The brand address field is required.',
        'live_url_root.required' => 'The brand url field is required.',
        'live_url_root.url' => 'Please enter a valid brand url.',
        'partnercategory_id.required' => 'The category field is required.',
        'contact_name.required' => 'The brand contact name field is required.',
        'contact_email.required' => 'The brand contact email is required.',
        'contact_email.email' => 'Please enter a valid brand contact email.',
        'contact_phone.required' => 'The contact telephone number field is required.',
        'contact_email.unique' => 'The brand contact email has already been taken.',
        'commission_percentage_lb.required' => 'The LetsBab Commission field is required.',
        'commission_percentage_lb.numeric' => 'The LetsBab Commission field must be numeric.',
        'commission_percentage_recommender.required' => 'The User Commission field is required.',
        'commission_percentage_recommender.numeric' => 'The User Commission field must be numeric.',
        'recommendation_expiry_in_days.required' => 'The Recommend Expire field is required.',
        'recommendation_expiry_in_days.numeric' => 'The Recommend Expire field must be numeric.',
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
        Partner::observe(PartnerObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        static::creating(function (Partner $element) {
            /*
             * Default value while creating
             *********************************/
            $element->commission_percentage_lb = $element->commission_percentage_lb ?? 1;
            $element->commission_percentage_recommender = $element->commission_percentage_recommender ?? 5;
            $element->recommendation_expiry_in_days = $element->recommendation_expiry_in_days ?? 10;
            $element->status = $element->status ?? 'Sandbox';
            $element->is_active = $element->is_active ?? 0;
            $element->is_published = $element->is_active ?? 0;
        });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Partner $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Partner $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Partner $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Partner $element) {
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

            /* Auto fill fields
            *****************************************/
            if ($valid) {
                if ($element->country()->exists()) {
                    $element->country_name = $element->country->name;
                    $element->currency = $element->country->currency();
                }
                $element->partnercategory_name = $element->partnercategory()->exists() ? $element->partnercategory->name : null;
                $element->commission_percentage_total = $element->commission_percentage_lb + $element->commission_percentage_recommender;
            }

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Partner $element) {
            // If the partner is set as featured then make other un-featured.
            if ($element->is_featured) {
                Partner::where('id', '!=', $element->id)->update(['is_featured' => 0]);
            }
        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Partner $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Partner $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Partner $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Partner $element) {});
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
     *
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
     * Get the last uploaded partner block logo.
     */

    public function blockLogo()
    {
        return $this->uploads->where('type', 'Block-logo')->first();
    }

    /**
     * Get the last uploaded cover logo
     */
    public function logo()
    {
        return $this->uploads->where('type', 'Logo')->first();
    }

    /**
     * Get the last uploaded horizontal cover photo
     */
    public function coverPhotoHorizontal()
    {
        return $this->uploads->where('type', 'Cover-horizontal')->first();
    }

    /**
     * Get the last uploaded vertical cover photo
     */
    public function coverPhotoVertical()
    {
        return $this->uploads->where('type', 'Cover-vertical')->first();
    }

    /**
     * This function returns an array of partner ids that are viewable by a specific user
     *
     * @param \App\User $user
     * @return array
     */
    public static function idsOfPartnerViewableByUser($user)
    {
        return Partner::where('is_featured', 0)->pluck('id')->toArray();
    }

    /**
     * Get featured partner
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function featured()
    {
        return Partner::where('is_featured', 1)->first();
    }

    /**
     * Function to find a partner from a given url
     *
     * @param $url
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function findByUrl($url)
    {
        $parse = parse_url($url);
        if (isset($parse['host'])) {
            $domain = $parse['host'];
            $domain_excluding_www = str_replace('www.', '', $domain);

            /** @noinspection PhpUndefinedMethodInspection */
            return Partner::where('live_url_root', 'LIKE', "%$domain_excluding_www%")
                ->orWhere('stage_url_root', 'LIKE', "%$domain_excluding_www%")
                ->remember(cacheTime('none'))
                ->first();
        }
        return null;
    }

    /**
     * Returns partner env from url,preferably product url.
     *
     * @param $url string
     * @return string|null
     */
    public static function partnerEnvFromUrl($url)
    {
        if ($partner = Partner::findByUrl($url)) {
            if (strstr($url, $partner->live_url_product)) {
                return 'Live';
            } else {
                return 'Sandbox';
            }
        }
        return null;
    }

    /**
     * Calculate partner next billing date
     *
     * @return \Carbon\Carbon
     */
    public function nextBillingDate()
    {
        /** @var \App\User $this */
        $billing_date = $this->created_at->addDays(45);
        return $billing_date; // Return a date Not datetime
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
     * Checks if the $element is viewable by current or any user passed as parameter.
     * spyrElementViewable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @param bool $set_msg
     * @return bool
     */
    public function isViewable($user_id = null, $set_msg = false)
    {
        /** @var \App\User $user */
        $user = user($user_id);
        if (!spyrElementViewable($this, $user_id, $set_msg)) {

            return false;
        }
        // Allow super user
        if ($user->isSuperUser()) {
            return true;
        }
        // Allow partner users of same partner
        if ($user->ofPartner()) {
            if ($user->partner_id === $this->id) {
                return true;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partnercategory() { return $this->belongsTo(Partnercategory::class); }
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
     * Function to return an appended attribute in a Model. The attribute name
     * should be added in $append array.
     *
     * @return bool
     */

    public function getBlockLogoAttribute()
    {
        if ($this->blockLogo()) return $this->blockLogo()->url;
        return null;
    }

    public function getLogoAttribute()
    {
        if ($this->logo()) return $this->logo()->url;
        return null;
    }

    public function getCoverPhotoHorizontalAttribute()
    {
        if ($this->coverPhotoHorizontal()) return $this->coverPhotoHorizontal()->url;
        return null;
    }

    public function getCoverPhotoVerticalAttribute()
    {
        if ($this->coverPhotoVertical()) return $this->coverPhotoVertical()->url;
        return null;
    }
    // Write accessors and mutators here.

}
