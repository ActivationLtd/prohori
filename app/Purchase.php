<?php

namespace App;

use App\Observers\PurchaseObserver;
use App\Traits\IsoModule;

/**
 * Class Purchase
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
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $lb_env
 * @property string|null $partner_env
 * @property int|null $recommendurl_id
 * @property int|null $partner_id
 * @property int|null $recommender_user_id
 * @property string|null $product_name
 * @property string|null $product_sku
 * @property float|null $product_price
 * @property string|null $product_price_currency
 * @property string|null $product_order_id
 * @property string|null $product_data
 * @property string|null $purchase_data
 * @property float|null $earn_amount
 * @property int|null $charity_share_percentage
 * @property float|null $donation_amount
 * @property int|null $charity_id
 * @property string|null $charity_name
 * @property string|null $status
 * @property string|null $note
 * @property int|null $recommender_invoice_id
 * @property string|null $recommender_invoice_status
 * @property int|null $recommender_transaction_id
 * @property string|null $recommender_transaction_status
 * @property int|null $charity_invoice_id
 * @property string|null $charity_invoice_status
 * @property int|null $charity_transaction_id
 * @property string|null $charity_transaction_status
 * @property int|null $partner_invoice_id
 * @property string|null $partner_invoice_status
 * @property int|null $partner_transaction_id
 * @property string|null $partner_transaction_status
 * @property int|null $beacon_id
 * @property string|null $recommendurl_short_code
 * @property float|null $product_original_price
 * @property string|null $product_original_price_currency
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereBeaconId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharitySharePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereDonationAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereEarnAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereLbEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductOriginalPriceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePurchaseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommendurlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommendurlShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property string|null $recommendurl_uuid
 * @property string|null $partner_uuid
 * @property string|null $recommender_user_uuid
 * @property string|null $product_currency
 * @property string|null $user_currency
 * @property string|null $charity_currency
 * @property string|null $lb_currency
 * @property float|null $commission_percentage_lb
 * @property float|null $commission_percentage_recommender
 * @property float|null $product_price_in_product_currency
 * @property float|null $product_price_in_user_currency
 * @property float|null $product_price_in_lb_currency
 * @property float|null $product_price_in_charity_currency
 * @property float|null $user_commission_in_user_currency
 * @property float|null $user_commission_in_lb_currency
 * @property float|null $user_commission_in_charity_currency
 * @property float|null $charity_donation_in_user_currency
 * @property float|null $charity_donation_in_lb_currency
 * @property float|null $charity_donation_charity_currency
 * @property float|null $lb_commission_in_user_currency
 * @property float|null $lb_commission_in_lb_currency
 * @property float|null $lb_commission_in_charity_currency
 * @property int|null $product_quantity
 * @property-read \App\Upload $latestUpload
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityDonationCharityCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityDonationInLbCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCharityDonationInUserCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCommissionPercentageLb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCommissionPercentageRecommender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereLbCommissionInCharityCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereLbCommissionInLbCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereLbCommissionInUserCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereLbCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceInCharityCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceInLbCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceInProductCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceInUserCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommendurlUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUserCommissionInCharityCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUserCommissionInLbCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUserCommissionInUserCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUserCurrency($value)
 * @property string|null $product_id
 * @property string|null $order_ts
 * @property string|null $tab_id
 * @property string|null $checkout_url
 * @property string|null $product_url
 * @property string|null $product_title
 * @property float|null $product_line_price
 * @property string|null $product_vendor
 * @property string|null $product_image
 * @property string|null $product_lb_url
 * @property int|null $product_price_cent
 * @property string|null $user_share_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereCheckoutUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereOrderTs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductLbUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductLinePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductPriceCent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereProductVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereTabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereUserShareCode($value)
 * @property-read \App\Beacon|null $beacon
 * @property-read \App\Charity|null $charity
 * @property-read \App\Partner|null $partner
 * @property-read \App\User|null $recommender
 * @property-read \App\Recommendurl|null $recommendurl
 * @property-read \App\User|null $user
 * @property int|null $is_approved
 * @property string|null $partner_name
 * @property string|null $recommender_full_name
 * @property string|null $recommender_email
 * @property-read \App\Invoice|null $charityInvoice
 * @property-read \App\Transaction|null $charityTransaction
 * @property-read mixed $formatted_charity_donation_in_user_currency
 * @property-read mixed $formatted_product_price_in_user_currency
 * @property-read mixed $formatted_user_commission_in_user_currency
 * @property-read \App\Invoice|null $recommenderInvoice
 * @property-read \App\Transaction|null $recommenderTransaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Purchase whereRecommenderFullName($value)
 */
class Purchase extends Basemodule
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
        'lb_env',
        'partner_env',
        'recommendurl_id',
        'partner_id',
        'recommender_user_id',
        'product_name',
        'product_sku',
        'product_order_id',
        'product_data',
        'purchase_data',
        'charity_id',
        'charity_name',
        'status',
        'note',
        'recommender_invoice_id',
        'recommender_invoice_status',
        'recommender_transaction_id',
        'recommender_transaction_status',
        'charity_invoice_id',
        'charity_invoice_status',
        'charity_transaction_id',
        'charity_transaction_status',
        'partner_invoice_id',
        'partner_invoice_status',
        'partner_transaction_id',
        'partner_transaction_status',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'beacon_id',
        'recommendurl_short_code',
        'recommendurl_uuid',
        'partner_uuid',
        'recommender_user_uuid',
        'product_currency',
        'user_currency',
        'charity_currency',
        'lb_currency',
        'commission_percentage_lb',
        'commission_percentage_recommender',
        'charity_share_percentage',
        'product_price_in_product_currency',
        'product_price_in_user_currency',
        'product_price_in_lb_currency',
        'product_price_in_charity_currency',
        'user_commission_in_user_currency',
        'user_commission_in_lb_currency',
        'user_commission_in_charity_currency',
        'charity_donation_in_user_currency',
        'charity_donation_in_lb_currency',
        'charity_donation_charity_currency',
        'lb_commission_in_user_currency',
        'lb_commission_in_lb_currency',
        'lb_commission_in_charity_currency',
        'product_quantity',
        'product_id',
        'order_ts',
        'tab_id',
        'checkout_url',
        'product_url',
        'product_title',
        'product_line_price',
        'product_vendor',
        'product_image',
        'product_lb_url',
        'product_price_cent',
        'user_share_code',
        'is_approved',
        'partner_name',
        'recommender_full_name',
        'recommender_email',
    ];

    /**
     * List of appended attribute. This attributes will be loaded in each Model
     *
     * @var array
     */
    protected $appends = [
        'formatted_product_price_in_user_currency',
        'formatted_user_commission_in_user_currency',
        'formatted_charity_donation_in_user_currency'
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
            // 'name' => 'required|between:1,255|unique:purchases,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            // 'is_active' => 'required|in:1,0',
            //'beacon_id' => 'required|exists:beacons,id',
            'user_share_code' => 'required',
            'recommendurl_short_code' => 'required',
            'product_currency' => 'required',
            'product_price_in_product_currency' => 'required',
            //'lb_env' => 'in:' . implode(',', Partner::$statuses),
            'partner_env' => 'in:' . implode(',', Partner::$statuses),
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
        Purchase::observe(PurchaseObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        static::creating(function (Purchase $element) {
            $valid = true;
            $element->is_approved = 1; // Default set as approved.
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            /** @var \App\Recommendurl $recommendurl */
            if ($recommendurl = Recommendurl::fromShortCode($element->recommendurl_short_code)) {

                //dd($recommendurl);

                /*
                 * Resolve recommendurl
                 ************************************/
                $element->recommendurl_id = $recommendurl->id;
                $element->recommendurl_uuid = $recommendurl->uuid;

                $element->commission_percentage_lb = $recommendurl->commission_percentage_lb;
                $element->commission_percentage_recommender = $recommendurl->commission_percentage_recommender;
                $element->charity_share_percentage = $recommendurl->charity_share_percentage;

                /*
                 * Resolve charity related fields
                 ************************************/
                $element->partner_id = $recommendurl->partner_id;
                if ($element->partner()->exists()) {
                    /** @var \App\Partner $partner */
                    $partner = $element->partner;
                    // Resolve environments from product url
                    // $partner_env = Partner::partnerEnvFromUrl($element->product_url);
                    $partner_env = $partner->status;
                    if ($partner_env) {
                        $element->lb_env = $partner_env;
                        $element->partner_env = $partner_env;
                    }
                    $element->partner_uuid = $partner->uuid;
                    $element->partner_name = $partner->name;
                    $element->product_currency = $partner->currency;
                }

                /*
                 * Resolve charity related fields
                 ************************************/
                if (!isset($element->charity_id)) $element->charity_id = $recommendurl->charity_id;
                if ($element->charity()->exists()) {
                    /** @var \App\Charity $charity */
                    $charity = $element->charity;
                    $element->charity_name = $charity->name;
                    $element->charity_currency = $charity->currency;

                }

                /*
                 * Resolve recommender/user related fields
                 ************************************/
                $element->recommender_user_id = $recommendurl->recommender_user_id;
                if ($element->recommender()->exists()) {
                    /** @var \App\User $recommender */
                    $recommender = $element->recommender;
                    $element->recommender_user_uuid = $recommender->uuid;
                    $element->recommender_full_name = $recommender->full_name;
                    $element->recommender_femail = $recommender->email;
                    $element->user_currency = $recommender->currency;
                    $element->user_commission_in_lb_currency = convert($element->user_commission_in_user_currency, $element->user_currency, $element->user_currency);
                }

                /**
                 * Resolve LB commissions
                 **************************/
                $element->lb_currency = 'GBP';

                $element->product_price_in_user_currency = convert($element->product_price_in_product_currency, $element->product_currency, $element->user_currency);
                $element->product_price_in_lb_currency = convert($element->product_price_in_product_currency, $element->product_currency, $element->lb_currency);
                $element->product_price_in_charity_currency = convert($element->product_price_in_product_currency, $element->product_currency, $element->charity_currency);

                $element->user_commission_in_user_currency = number_format($element->product_price_in_user_currency * ($element->commission_percentage_recommender / 100), 2);
                $element->user_commission_in_lb_currency = convert($element->user_commission_in_user_currency, $element->user_currency, $element->lb_currency);
                $element->user_commission_in_charity_currency = convert($element->user_commission_in_user_currency, $element->user_currency, $element->charity_currency);

                $element->charity_donation_in_user_currency = number_format($element->user_commission_in_user_currency * ($element->charity_share_percentage / 100), 2);
                $element->charity_donation_in_lb_currency = convert($element->charity_donation_in_user_currency, $element->user_currency, $element->lb_currency);
                $element->charity_donation_charity_currency = convert($element->user_commission_in_user_currency, $element->user_currency, $element->charity_currency);

                $element->lb_commission_in_user_currency = number_format($element->product_price_in_user_currency * ($element->commission_percentage_lb / 100));
                $element->lb_commission_in_lb_currency = convert($element->lb_commission_in_user_currency, $element->user_currency, $element->lb_currency);
                $element->lb_commission_in_charity_currency = convert($element->lb_commission_in_user_currency, $element->user_currency, $element->charity_currency);

            } else {
                $valid = setError("Recommendation can not be found.");
            }

            return $valid;
        });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Purchase $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Purchase $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Purchase $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Purchase $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            /*
             * Resolve charity related fields
             ************************************/
            if ($element->charity()->exists()) {
                /** @var \App\Charity $charity */
                $charity = $element->charity;
                $element->charity_name = $charity->name;
                $element->charity_currency = $charity->currency;

            }

            /*
             * Resolve recommender/user related fields
             ************************************/
            if ($element->recommender()->exists()) {
                /** @var \App\User $recommender */
                $recommender = $element->recommender;
                $element->recommender_user_uuid = $recommender->uuid;
                $element->user_currency = $recommender->currency;
                //$element->user_commission_in_lb_currency = convert($element->user_commission_in_user_currency, $element->user_currency, $element->user_currency);
            }
            return $valid;

        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        // static::saved(function (Purchase $element) {});

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Purchase $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Purchase $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Purchase $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Purchase $element) {});
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
     * Get product price in currency of beneficiary type.
     *
     * @param $beneficiary_type
     * @return float|null
     */
    public function productPriceInCurrencyOf($beneficiary_type = null)
    {
        if ($beneficiary_type === 'recommender') return $this->product_price_in_user_currency;
        if ($beneficiary_type === 'charity') return $this->product_price_in_charity_currency;
        if ($beneficiary_type === 'partner') return $this->product_price_in_product_currency;
        if ($beneficiary_type === 'lb') return $this->product_price_in_lb_currency;

        return null;
    }

    /**
     * Get charity donation in currency of beneficiary type.
     *
     * @param $beneficiary_type
     * @return float|null
     */
    public function charityDonationInCurrencyOf($beneficiary_type = null)
    {
        if ($beneficiary_type === 'recommender') return $this->charity_donation_in_user_currency;
        if ($beneficiary_type === 'charity') return $this->charity_donation_charity_currency;
        if ($beneficiary_type === 'lb') return $this->charity_donation_in_lb_currency;

        return null;
    }

    /**
     * Get user commission in currency of beneficiary type.
     *
     * @param $beneficiary_type
     * @return float|null
     */
    public function recommenderCommissionInCurrencyOf($beneficiary_type = null)
    {
        if ($beneficiary_type === 'recommender') return $this->user_commission_in_user_currency;
        if ($beneficiary_type === 'charity') return $this->user_commission_in_charity_currency;
        if ($beneficiary_type === 'lb') return $this->user_commission_in_lb_currency;

        return null;
    }

    /**
     * For charity invoice get charity amount in charity currency. and for recommender invoice
     * get recommender commission amount in recommender currency.
     *
     * @param \App\Invoice $invoice
     * @return bool
     */
    public function amountForInvoice(Invoice $invoice)
    {
        if ($beneficiary_type = $invoice->beneficiaryType()) {
            if ($beneficiary_type === 'charity') {
                return $this->charityDonationInCurrencyOf($beneficiary_type);
            }
            if ($beneficiary_type === 'recommender') {
                return $this->recommenderCommissionInCurrencyOf($beneficiary_type);
            }
        }
        return null;
    }

    /**
     * Checks if a purchase is invoiceable.
     *
     * @param bool $set_msg If 'true' then validation error message will be stored in session.
     * @return bool
     */
    public function isInvoicable($set_msg = false)
    {
        if ($this->partner_env !== 'Live') {
            return setError('partner_env is not - Live.', $set_msg);
        }
        if ($this->is_approved !== 1) {
            return setError('Purchase is not approved.', $set_msg);
        }
        return true;
    }

    /**
     * Check if a specific purchase is valid to be invoiced for a charity
     *
     * @param \App\Charity $charity
     * @param bool $set_msg If 'true' then validation error message will be stored in session.
     * @return bool
     */
    public function isInvoicableForCharity(Charity $charity, $set_msg = false)
    {
        if (!$this->isInvoicable()) {
            return setError('Error : Purchase::isInvoicable.', $set_msg);
        }
        if ($this->charity_id !== $charity->id) {
            return setError('Charity id does not match.', $set_msg);
        }
        if ($this->charity_donation_charity_currency <= 0) {
            return setError('Charity donation amount is not invoicable.', $set_msg);
        }
        if ($this->charity_invoice_id) {
            return setError("Already invoiced. Invoice #{$this->charity_invoice_id}.", $set_msg);
        }
        return true;

    }

    /**
     * Check if a specific purchase is valid to be invoiced for a recommender
     *
     * @param \App\User $recommender
     * @param bool $set_msg If 'true' then validation error message will be stored in session.
     * @return bool
     */
    public function isInvoicableForRecommender(User $recommender, $set_msg = false)
    {
        if (!$this->isInvoicable()) {
            return setError('Error : Purchase::isInvoicable.', $set_msg);
        }
        if ($this->recommender_user_id !== $recommender->id) {
            return setError('Recommender id does not match.', $set_msg);
        }
        if ($this->user_commission_in_user_currency <= 0) {
            return setError('Recommender commission amount is not invoicable.', $set_msg);
        }
        if ($this->recommender_invoice_id) {
            return setError("Already invoiced. Invoice #{$this->recommender_invoice_id}.", $set_msg);
        }
        return true;
    }

    /**
     * @param \App\Invoice $invoice
     * @param bool $set_msg If 'true' then validation error message will be stored in session.
     * @return bool
     */
    public function validForInvoice(Invoice $invoice, $set_msg = false)
    {
        if ($beneficiary_type = $invoice->beneficiaryType()) {
            if ($beneficiary_type === 'charity') {
                return $this->isInvoicableForCharity($invoice->charity, $set_msg);
            }
            if ($beneficiary_type === 'recommender') {
                return $this->isInvoicableForRecommender($invoice->recommender, $set_msg);
            }
        }
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
     * Checks if the $element is creatable by current or any user passed as parameter.
     * spyrElementViewable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @param bool $set_msg
     * @return bool
     */
    public function isCreatable($user_id = null, $set_msg = false)
    {
        $valid = true;
        if ($valid = spyrElementCreatable($this, $user_id, $set_msg)) {
            // Write new validation logic for this operation in this block.
        }
        return $valid;
    }

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
            if ($user->partner_id === $this->partner_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the $element is editable by current or any user passed as parameter.
     * spyrElementEditable() is the primary default checker based on permission
     * whether this should be allowed or not. The logic can be further
     * extend to implement more conditions.
     *
     * @param null $user_id
     * @param bool $set_msg
     * @return bool
     */
    public function isEditable($user_id = null, $set_msg = false)
    {
        /** @var \App\User $user */
        $user = user($user_id);
        if (!spyrElementEditable($this, $user_id, $set_msg)) {
            return false;
        }

        if ($this->isViewable($user_id, $set_msg)) {
            return true;
        }

        return false;
    }

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
    public function recommender() { return $this->belongsTo(User::class, 'recommender_user_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() { return $this->belongsTo(User::class, 'recommender_user_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() { return $this->belongsTo(Partner::class, 'partner_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommendurl() { return $this->belongsTo(Recommendurl::class, 'recommendurl_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charity() { return $this->belongsTo(Charity::class, 'charity_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beacon() { return $this->belongsTo(Beacon::class, 'beacon_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommenderInvoice() { return $this->belongsTo(Invoice::class, 'recommender_invoice_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charityInvoice() { return $this->belongsTo(Invoice::class, 'charity_invoice_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommenderTransaction() { return $this->belongsTo(Transaction::class, 'recommender_transaction_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charityTransaction() { return $this->belongsTo(Transaction::class, 'charity_transaction_id'); }


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
    public function getFormattedProductPriceInUserCurrencyAttribute()
    {
        return symbol($this->user_currency) . " " . money($this->product_price_in_user_currency);
    }

    // Write accessors and mutators here.
    public function getFormattedUserCommissionInUserCurrencyAttribute()
    {
        return symbol($this->user_currency) . " " . money($this->user_commission_in_user_currency);
    }

    // Write accessors and mutators here.
    public function getFormattedCharityDonationInUserCurrencyAttribute()
    {
        return symbol($this->user_currency) . " " . money($this->charity_donation_in_user_currency);
    }

}
