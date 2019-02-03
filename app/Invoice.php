<?php

namespace App;

use App\Observers\InvoiceObserver;
use App\Traits\IsoModule;
use DB;

/**
 * Class Invoice
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
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $recommender_user_id
 * @property string|null $recommender_user_name
 * @property int|null $charity_id
 * @property string|null $charity_name
 * @property int|null $partner_id
 * @property string|null $partner_name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $purchases_from
 * @property string|null $purchases_till
 * @property int|null $days_span
 * @property string|null $purchase_ids
 * @property string|null $status
 * @property string|null $details
 * @property string|null $note
 * @property string|null $currency
 * @property float|null $total_amount
 * @property float|null $vat_percentage
 * @property float|null $vat_amount
 * @property float|null $total_with_vat_amount
 * @property float|null $tax_percentage
 * @property float|null $tax_amount
 * @property float|null $subtotal
 * @property string|null $generated_at
 * @property string|null $due_date
 * @property int|null $transaction_id
 * @property string|null $transaction_status
 * @property mixed $transfer_method
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCharityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCharityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDaysSpan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePurchaseIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePurchasesFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePurchasesTill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereRecommenderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereRecommenderUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTaxPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTotalWithVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereZipCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 * @property float|null $adjustment_amount
 * @property string|null $adjustment_note
 * @property-read \App\Charity|null $charity
 * @property-read \App\Country|null $country
 * @property-read \App\Partner|null $partner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Purchase[] $purchases
 * @property-read \App\User|null $recommender
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAdjustmentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAdjustmentNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereTransferMethod($value)
 */
class Invoice extends Basemodule
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
        'recommender_user_id',
        'recommender_user_name',
        'charity_id',
        'charity_name',
        'partner_id',
        'partner_name',
        'address1',
        'address2',
        'city',
        'county',
        'country_id',
        'country_name',
        'zip_code',
        'phone',
        'mobile',
        'purchases_from',
        'purchases_till',
        'days_span',
        'purchase_ids',
        'status',
        'details',
        'note',
        'currency',
        'total_amount',
        'vat_percentage',
        'vat_amount',
        'total_with_vat_amount',
        'tax_percentage',
        'tax_amount',
        'subtotal',
        'generated_at',
        'due_date',
        'transaction_id',
        'transaction_status',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'transfer_method',
        'adjustment_amount',
        'adjustment_note',
    ];

    /**
     * List of available transfer method through which the invoice will be paid
     *
     * @var array
     */
    public static $transfer_methods = [
        'TransferWise',
        'NatWest',
    ];

    /**
     * Invoice statuses
     *
     * @var array
     */
    public static $statuses = [
        'Paid',
        'Due',
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
            //'name' => 'required|between:1,255|unique:invoices,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            //'is_active' => 'required|in:1,0',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',
            'purchase_ids' => 'required',
            'status' => 'in:' . implode(',', self::$statuses),
            'transfer_method' => 'in:' . implode(',', self::$transfer_methods),

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
        Invoice::observe(InvoiceObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        static::creating(function (Invoice $element) {

            $valid = true;
            $element->status = 'Due';
            $element->is_active = 1;
            $element->generated_at = now();

            /*
             * Resolve purchases and calculate amount
             *******************************************/
            $purchase_ids = explode(',', $element->purchase_ids);
            $valid_purchase_ids = []; // We shall go through each of the purchases and store only the valid ones here.

            if ($valid && count($purchase_ids)) {

                $purchases = Purchase::whereIn('id', $purchase_ids)->get();
                $total_amount = 0;

                foreach ($purchases as $purchase) {

                    // Exit if purchase is not valid for invoicing.
                    if (!$purchase->validForInvoice($element, true)) {
                        $valid = setError("Purchase #{$purchase->id} not valid for invoice.");
                        break;
                    }

                    $amount = $purchase->amountForInvoice($element);
                    // Exit if amount is not valid for invoicing.
                    if (!$amount) {
                        $valid = setError("Amount of purchase #{$purchase->id} not valid for invoice.");
                        break;
                    }

                    $total_amount += $amount;
                    $valid_purchase_ids[] = $purchase->id;
                }

                $element->total_amount = $total_amount;
                if ($valid && $total_amount <= 0) {
                    $valid = setError('Total amount is not greater than 0');
                }
                $element->purchase_ids = implode(',', $valid_purchase_ids);
            } else {
                $valid = setError('No/Invalid purchase ids');
            }

            if ($valid) {
                $element->name = $element->beneficiary()->name . " " . date('Y-m-d');
                $element = $element->fillAmounts();
            }

            return $valid;
        });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Invoice $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Invoice $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Invoice $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Invoice $element) {

            $valid = true;
            /*
             * Resolve if the invoice is for a charity or a recommender
             ************************************************************/
            $beneficiary = $element->beneficiary();
            $beneficiary_type = $element->beneficiaryType();

            if ($beneficiary) {
                $element = $element->fillAddress();
                // If transfer_method is not preselected then obtain the method and set.
                $element->currency = $beneficiary->currency;
                $element->transfer_method = $element->transfer_method ?? $element->transferMethod();

            } else {
                $valid = setError('Invalid beneficiary entity(i.e. Charity, Recommender).');
            }

            if (!$element->country_id) $valid = setError('Beneficiary country not defined.');
            if (!$element->currency) $valid = setError('Beneficiary currency not defined.');

            if ($valid) {
                $element = $element->fillAmounts();
                if ($element->charity()->exists()) {
                    $element->charity_name = $element->charity->name;
                }
                if ($element->recommender()->exists()) {
                    $element->recommender_user_name = $element->recommender->name;
                }
                $element->is_active = 1;
            }

            return $valid;

        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Invoice $element) {
            Purchase::whereIn('id', explode(',', $element->purchase_ids))->update([
                "{$element->beneficiaryType()}_invoice_id" => $element->id,
                "{$element->beneficiaryType()}_invoice_status" => $element->status
            ]);
        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Invoice $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        static::deleted(function (Invoice $element) {
            DB::table('purchases')->whereIn('id', explode(',', $element->purchase_ids))->update([
                "{$element->beneficiaryType()}_invoice_id" => null,
                "{$element->beneficiaryType()}_invoice_status" => null
            ]);
        });

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Invoice $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Invoice $element) {});
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
     * Determine the type of payment recipient. i.e. Charity, Recommender.
     *
     * @return null|string
     */
    public function beneficiaryType()
    {
        if ($this->charity()->exists()) {
            return 'charity';
        }
        if ($this->recommender()->exists()) {
            return 'recommender';
        }
        return null;
    }

    /**
     * Get the beneficiary object . i.e. Charity, User
     *
     * @return mixed|\App\User|\App\Charity
     */
    public function beneficiary()
    {
        $beneficiary_type = $this->beneficiaryType();
        if ($beneficiary_type === 'charity') {
            return $this->charity;
        }
        if ($beneficiary_type === 'recommender') {
            return $this->recommender;
        }
        return null;
    }

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
            'zip_code',
        ];

        foreach ($fields as $field) {
            if (strlen($this->$field)) {
                $str .= $this->$field . ', ';
            }
        }

        return trim($str, ', ');
    }

    /**
     * Fill address from Charity/User existing address
     *
     * @return $this
     */
    public function fillAddress()
    {
        /** @var \App\Charity| \App\User $beneficiary */
        if ($beneficiary = $this->beneficiary()) {
            $this->address1 = $beneficiary->address1;
            $this->address2 = $beneficiary->address2;
            $this->city = $beneficiary->city;
            $this->county = $beneficiary->county;
            $this->country_id = $beneficiary->country_id;
            $this->country_name = $beneficiary->country_name;
            $this->zip_code = $beneficiary->zip_code;
            $this->phone = $beneficiary->phone;
            $this->mobile = $beneficiary->mobile;
        }

        return $this;
    }

    /**
     * Calculate and fill financial amounts
     *
     * @return $this
     */
    public function fillAmounts()
    {

        $this->vat_percentage = $this->vat_percentage ?? $this->vatPercentage();
        $this->vat_amount = $this->vat_amount ?? $this->vatAmount();
        $this->total_with_vat_amount = $this->total_with_vat_amount ?? $this->totalWithVat();
        $this->tax_percentage = $this->tax_percentage ?? $this->taxPercentage();
        $this->tax_amount = $this->tax_amount ?? $this->taxAmount();
        $this->subtotal = $this->calculateSubtotal();

        return $this;
    }

    /**
     * Based on beneficiary type and it's country determine which transfer method should be applied.
     * Transfer method options 'TransferWise', 'NatWest',
     *
     * @return null|string
     */
    public function transferMethod()
    {
        if ($this->country()->exists()) {
            /** @var \App\Country $country */
            $country = $this->country;

            $beneficiary_type = $this->beneficiaryType();

            if ($beneficiary_type === 'recommender') {
                if ($country->isUK()) {
                    return 'NatWest';
                }
                return 'TransferWise';
            }

            if ($beneficiary_type === 'charity') {
                return 'NatWest';
            }
        }
        return null;
    }

    /**
     * obtain vat percentage of the beneficiary.
     *
     * @return float
     */
    public function vatPercentage()
    {
        return 0.0;
    }

    /**
     * Calculate vat amount.
     *
     * @return string
     */
    public function vatAmount()
    {
        return money($this->total_amount * $this->vatPercentage() / 100);
    }

    /**
     * Add vat with total amount.
     *
     * @return float|string
     */
    public function totalWithVat()
    {
        return money((float)$this->total_amount + (float)$this->vatAmount());
    }

    /**
     * Obtain tax percentage of beneficiary i.e. charity, recommender.
     *
     * @return float
     */
    public function taxPercentage()
    {
        return 0.0;
    }

    /**
     * Calculate tax amount
     *
     * @return float|string
     */
    public function taxAmount()
    {
        return money($this->total_amount * $this->taxPercentage() / 100);
    }

    /**
     * Calculate subtotal
     *
     * @return float|string
     */
    public function calculateSubtotal()
    {
        return money((float)$this->total_amount + (float)$this->vatAmount() + (float)$this->taxAmount() + (float)$this->adjustment_amount);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | \App\User
     */
    public function recommender()
    {
        return $this->belongsTo(User::class, 'recommender_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | \App\Charity
     */
    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | \App\Charity
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | \App\Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
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

}
