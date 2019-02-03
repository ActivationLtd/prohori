<?php

namespace App;

use App\Traits\IsoModule;

/**
 * Class Beacon
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
 * @method static \Illuminate\Database\Query\Builder|\App\Beacon onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Beacon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Beacon withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $data
 * @property string|null $lb_env
 * @property string|null $eventtype_name
 * @property int|null $recommended_by
 * @property string|null $recommend_code
 * @property int|null $partner_id
 * @property string|null $partner_name
 * @property string|null $url
 * @property string|null $partner_env
 * @property string|null $partner_product_id
 * @property string|null $partner_product_sku
 * @property string|null $partner_product_name
 * @property float|null $partner_product_price_cents
 * @property string|null $partner_currency
 * @property string|null $partner_purchase_id
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereEventtypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereLbEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerProductPriceCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerProductSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerPurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereRecommendCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereRecommendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereUuid($value)
 * @property string|null $partner_uuid
 * @property string|null $recommender_ids
 * @property string|null $recommender_uuids
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon wherePartnerUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereRecommenderIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereRecommenderUuids($value)
 * @property-read \App\Upload $latestUpload
 * @property string|null $origin
 * @property string|null $headers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Beacon whereOrigin($value)
 * @property-read \App\Partner|null $partner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Purchase[] $purchases
 */
class Beacon extends Basemodule
{
    use IsoModule;

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
     * Mass assignment fields (White-listed fields)
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'data',
        'lb_env',
        'eventtype_name',
        'recommended_by_users',
        'recommend_code',
        'partner_id',
        'partner_name',
        'url',
        'partner_env',
        'partner_product_id',
        'partner_product_sku',
        'partner_product_name',
        'partner_product_price_cents',
        'partner_currency',
        'partner_purchase_id',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
        'origin',
        'headers',
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
            //'name' => 'required|between:1,255|unique:beacons,name,' . (isset($element->id) ? "$element->id" : 'null') . ',id,deleted_at,NULL',
            //'is_active' => 'required|in:1,0',
            // 'tenant_id'  => 'required|tenants,id,is_active,1',
            // 'created_by' => 'exists:users,id,is_active,1', // Optimistic validation for created_by,updated_by
            // 'updated_by' => 'exists:users,id,is_active,1',
            'data' => 'required|json',

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
        //Beacon::observe(BeaconObserver::class);

        /************************************************************/
        // Following code block executes - when an element is in process
        // of creation for the first time but the creation has not
        // completed yet.
        /************************************************************/
        // static::creating(function (Beacon $element) { });

        /************************************************************/
        // Following code block executes - after an element is created
        // for the first time.
        /************************************************************/
        // static::created(function (Beacon $element) { });

        /************************************************************/
        // Following code block executes - when an already existing
        // element is in process of being updated but the update is
        // not yet complete.
        /************************************************************/
        // static::updating(function (Beacon $element) {});

        /************************************************************/
        // Following code block executes - after an element
        // is successfully updated
        /************************************************************/
        //static::updated(function (Beacon $element) {});

        /************************************************************/
        // Execute codes during saving (both creating and updating)
        /************************************************************/
        static::saving(function (Beacon $element) {
            $valid = true;
            /************************************************************/
            // Your validation goes here
            // if($valid) $valid = $element->isSomethingDoable(true)
            /************************************************************/

            //
            // $temp = json_decode($element->data);
            // dd($element->productsInRecommendations());
            // dd($element->productsInPurchases());
            //dd($element->data);
            //$element->data = json_encode($element->data);

            if ($element->partner()->exists()) {
                /** @var \App\Partner $partner */
                $partner = $element->partner;
                $element->lb_env = $partner->status;
                $element->partner_env = $partner->status;
            }

            $element->name = now() . ' ' . randomString();

            //myprint_r($element->productsInBothPurchaseAndRecommendation());
            //dd();

            return $valid;
        });

        /************************************************************/
        // Execute codes after model is successfully saved
        /************************************************************/
        static::saved(function (Beacon $element) {
            $element->createPurchases();
        });

        /************************************************************/
        // Following code block executes - when some element is in
        // the process of being deleted. This is good place to
        // put validations for eligibility of deletion.
        /************************************************************/
        // static::deleting(function (Beacon $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully deleted.
        /************************************************************/
        // static::deleted(function (Beacon $element) {});

        /************************************************************/
        // Following code block executes - when an already deleted element
        // is in the process of being restored.
        /************************************************************/
        // static::restoring(function (Beacon $element) {});

        /************************************************************/
        // Following code block executes - after an element is
        // successfully restored.
        /************************************************************/
        //static::restored(function (Beacon $element) {});
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
     * Match products in both recommendation and purchase events and get the matched products.
     *
     * @return array
     */
    public function productsInBothPurchaseAndRecommendation()
    {
        $products_in_recommendations = $this->productsInRecommendations();
        // myprint_r($products_in_recommendations); // debug
        $products_in_purchases = $this->productsInPurchases();
        // myprint_r($products_in_purchases); // debug

        //dd($products_in_purchases);
        $products = [];
        foreach ($products_in_purchases as $product_id => $product_details) {
            if (array_key_exists($product_id, $products_in_recommendations)) {
                $products[$product_id] = array_merge($product_details, $products_in_recommendations[$product_id]);
            }
        }
        return $products;
    }

    /**
     * Find the products from recommendation events.
     *
     * @return array
     */
    public function productsInRecommendations()
    {
        $products = [];
        $json = json_decode($this->data);

        /** @noinspection PhpUndefinedFieldInspection */
        if (isset($json->events) && is_array($json->events)) {
            /** @noinspection PhpUndefinedFieldInspection */
            foreach ($json->events as $row) {
                // Go through only recommendation
                if ($row->event === 'recommendation') {
                    if (isset($row->productId) && strlen((string)$row->productId)) {
                        // If product id is available add the product details in array.
                        /** Init null */
                        $product_lb_url = $name = $price_cent = $currency = $share_code = $tab_id = $ts = null;

                        $product_id = $row->productId;
                        $ts = isset($row->ts) && is_string($row->ts) ? $row->ts : null;
                        $tab_id = isset($row->tabId) && is_string($row->tabId) ? $row->tabId : null;
                        $product_lb_url = isset($row->url) && is_string($row->url) ? $row->url : null;
                        $user_share_code = isset($row->referrerId) && is_string($row->referrerId) ? $row->referrerId : null;
                        $recommendurl_short_code = isset($row->shortCode) && is_string($row->shortCode) ? $row->shortCode : null;

                        if (isset($row->other)) {
                            $name = isset($row->other->name) && is_string($row->other->name) ? $row->other->name : null;
                            $price_cent = isset($row->other->price) && is_numeric($row->other->price) ? $row->other->price : null;
                            $currency = isset($row->other->currency) && is_string($row->other->currency) ? $row->other->currency : null;
                        }

                        // Construct array.
                        $products[$row->productId] = [
                            'product_id' => $product_id,
                            'ts' => $ts,
                            'product_lb_url' => $product_lb_url,
                            'name' => $name,
                            'price_cent' => $price_cent,
                            'currency' => $currency,
                            'user_share_code' => $user_share_code,
                            'recommendurl_short_code' => $recommendurl_short_code,
                            'tab_id' => $tab_id
                        ];

                    }
                }
            }
        }
        return $products;
    }

    /**
     * Find the products from purchase events.
     *
     * @return array
     */
    public function productsInPurchases()
    {
        $products = [];
        $json = json_decode($this->data);

        /** @noinspection PhpUndefinedFieldInspection */
        if (isset($json->events) && is_array($json->events)) {
            /** @noinspection PhpUndefinedFieldInspection */
            foreach ($json->events as $row) {
                // Go through only recommendation
                if ($row->event === 'purchase' && (isset($row->purchaseId) && strlen((string)$row->purchaseId))) {

                    if (isset($row->other) && (isset($row->other->line_items) && is_array($row->other->line_items))) {
                        foreach ($row->other->line_items as $item) {
                            if (isset($item->product) && (isset($item->product->id) && strlen((string)$item->product->id))) {

                                /** Init null */
                                $checkout_url = $ts = $tab_id = $purchase_id = $sku = $product_url = $price = $title = $vendor = $product_id = $product_image = $quantity = null;

                                $checkout_url = isset($row->url) && is_string($row->url) ? $row->url : null;
                                $ts = isset($row->ts) && is_string($row->ts) ? $row->ts : null;
                                $tab_id = isset($row->tabId) && is_string($row->tabId) ? $row->tabId : null;
                                $purchase_id = $row->purchaseId;

                                $sku = isset($item->sku) && is_string($item->sku) ? $item->sku : null;
                                $product_url = isset($item->url) && is_string($item->url) ? $item->url : null;
                                $price = isset($item->price) ? $item->price : null;
                                $line_price = isset($item->line_price) ? $item->line_price : null;
                                $title = isset($item->title) && is_string($item->title) ? $item->title : null;
                                $vendor = isset($item->vendor) && is_string($item->vendor) ? $item->vendor : null;

                                $quantity = isset($item->quantity) && is_numeric($item->quantity) ? $item->quantity : null;

                                $product = $item->product;
                                $product_id = $product->id;
                                $product_image = isset($product->image) && is_string($product->image) ? $product->image : null;
                                // Construct array.
                                $products[$product_id] = [
                                    'purchase_id' => $purchase_id,
                                    'product_id' => $product->id,
                                    'ts' => $ts,
                                    'tab_id' => $tab_id,
                                    'checkout_url' => $checkout_url,
                                    'product_url' => $product_url,
                                    'sku' => $sku,
                                    'title' => $title,
                                    'price' => $price,
                                    'line_price' => $line_price,
                                    'quantity' => $quantity,
                                    'vendor' => $vendor,
                                    'product_image' => $product_image,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $products;
    }

    /**
     * Take the recommended purchases and add entries in purchases table.
     */
    public function createPurchases()
    {
        $products = $this->productsInBothPurchaseAndRecommendation();
        foreach ($products as $product) {
            $purchase = Purchase::updateOrCreate(
                [
                    'beacon_id' => $this->id,
                    'product_order_id' => $product['purchase_id'],
                    'product_id' => $product['product_id'],
                    'order_ts' => $product['ts'],
                    'tab_id' => $product['tab_id'],
                ], // Check for existence. If this doesn't exist then create an entry.
                [
                    'beacon_id' => $this->id,
                    'product_order_id' => $product['purchase_id'],
                    'product_id' => $product['product_id'],
                    'order_ts' => $product['ts'],
                    'tab_id' => $product['tab_id'],
                    'checkout_url' => $product['checkout_url'],
                    'product_url' => $product['product_url'],
                    'product_sku' => $product['sku'],
                    'product_title' => $product['title'],
                    'product_price_in_product_currency' => $product['price'],
                    'product_line_price' => $product['line_price'],
                    'product_quantity' => $product['quantity'],
                    'product_vendor' => $product['vendor'],
                    'product_image' => $product['product_image'],
                    'product_lb_url' => $product['product_lb_url'],
                    'product_name' => $product['name'],
                    'product_price_cent' => $product['price_cent'],
                    'product_currency' => $product['currency'],
                    'user_share_code' => $product['user_share_code'],
                    'recommendurl_short_code' => $product['recommendurl_short_code'],
                ]
            );
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases() { return $this->hasMany(Purchase::class); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo'
     */
    public function partner() { return $this->belongsTo(Partner::class); }

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
     * Get data as json
     */
    // public function getDataAttribute($value)
    // {
    //     return json_decode($value);
    // }

}
