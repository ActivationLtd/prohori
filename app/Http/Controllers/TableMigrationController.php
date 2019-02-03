<?php

namespace App\Http\Controllers;

use App\Charity;
use App\Country;
use App\Partner;
use App\Partnercategory;
use App\User;
use App\Recommendurl;
use App\Beacon;
use Illuminate\Routing\Controller as BaseController;

class TableMigrationController extends BaseController
{

    /**
     * Migrate partnercategories from old categories table.
     */
    public function migratePartnercategories()
    {
        echo "<pre>";
        echo "Migration start: partnercategories <br/>";

        $source_rows = \DB::table('categories_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->uuid}";
            \DB::table('partnercategories')->updateOrInsert(
                ['uuid' => $row->uuid], // Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->uuid,
                    'name' => $row->cat_name,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at,
                    'is_active' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'order' => $row->display_order,

                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate partners from old partners table.
     */
    public function migratePartners()
    {
        echo "<pre>";
        echo "Migration start: partners <br/>";

        $source_rows = \DB::table('partners_old')->get();

        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";
            \DB::table('partners')->updateOrInsert(
                ['uuid' => $row->id], // Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'name' => $row->vendor_name,
                    'live_url_root' => $row->site_url,
                    'updated_at' => $row->updated_at,
                    'is_active' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'country_id' => 187,
                    'country_name' => 'United Kingdom',
                    'commission_percentage_lb'=> 1,
                    'commission_percentage_recommender'=> 5,
                    'partnercategory_id' => $row->category_id,
                    'partnercategory_name' => ($row->category_id) ? Partnercategory::find($row->category_id)->name : null,
                    'recommendation_expiry_in_days' => $row->recommend_expire,
                    'images' => $row->images,
                    'is_featured' => $row->is_featured,
                    'featured_images' => $row->featured_images,
                    'commission_percentage_total' => $row->display_order,
                    'address1' => $row->address1,
                    'contact_name' => $row->contact_name,
                    'contact_email' => $row->contact_email,
                    'contact_phone' => $row->contact_phone,
                    'finance_contact_email' => $row->finance_contact_email,
                    'finance_contact_phone' => $row->finance_contact_phone,
                    'it_contact_name' => $row->it_contact_name,
                    'it_contact_email' => $row->it_contact_email,
                    'it_contact_phone' => $row->it_contact_phone,
                    'sitecms_name' => $row->sitecms_name,
                    'account_number' => $row->account_number,
                    'sort_code' => $row->sort_code,
                    'abartn' => $row->abartn,
                    'iban' => $row->iban,
                    'swift' => $row->swift,
                    'account_type' => $row->account_type,
                    'vat_no' => $row->vat_no,
                    'bank_account_address' => isset($row->bank_account_address) ? $row->bank_account_address : null,
                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate charities from old charities table.
     */
    public function migrateCharities()
    {
        echo "<pre>";
        echo "Migration start: charities <br/>";

        $source_rows = \DB::table('charities_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";

            if($row->currency == "USD"){
                $row->country = "US (United States)";
            }elseif($row->currency == "GBP"){
                $row->country = "UK (United Kingdom)";
            }elseif($row->currency == "EUR"){
                $row->country = "Europe";
            }else{
                $row->country = null;
            }
            
            $country_id = $country_name = null;
            if (Country::where('name', $row->country)->remember(cacheTime('short'))->exists()) {
                $country = Country::where('name', $row->country)->remember(cacheTime('short'))->first();
                $country_id = $country->id;
                $country_name = $country->name;
            }

            \DB::table('charities')->updateOrInsert(
                ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'name' => $row->name,
                    'code' => $row->code,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at,
                    'is_active' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'order' => $row->disp_order,
                    'website' => $row->website,
                    'country_id'=> $country_id,
                    'country_name'=> $country_name,
                    'currency' => $row->currency,
                    'contact_name' => $row->contact_name,
                    'contact_email' => $row->contact_email,
                    'contact_phone' => $row->contact_phone_no,
                    'contact_address' => $row->contact_address,
                    'registration_no' => $row->registration_no,
                    'ein_no' => $row->ein_no,
                    'account_number' => $row->account_no,
                    'sort_code' => $row->sort_code,
                    'abartn' => $row->abartn,
                    'iban' => $row->iban,
                    'swift' => $row->swift,
                    'account_type' => $row->account_type,
                    'finance_contact_name' => $row->finance_contact_name,
                    'finance_contact_email' => $row->finance_contact_email,
                    'finance_contact_phone' => $row->finance_contact_telephone_no,
                    'account_name' => $row->account_name,
                    'bank_name' => $row->bank_name,
                    'bank_account_address' => $row->bank_account_address,

                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate users from old accounts table.
     */
    public function migrateUsers()
    {
        /*
            ID  Name
            --  ---------------
            1	Superuser
            2	Brand admin
            3	Brand user
            4	Brand LB Admin
            5	Charity admin
            6	Charity user
            7	Charity LB admin
            8	User(Recommender)
            9	API user
            10	System
            11	LB Admin
        */

        echo "<pre>";
        echo "Migration start: users <br/>";

        $map = [
            'is_admin' => [
                'group_ids_csv' => '1',
                'group_titles_csv' => 'Superuser',
            ],
            'is_partner_admin' => [
                'group_ids_csv' => '2',
                'group_titles_csv' => 'Brand admin',
            ],
            'is_charity_admin' => [
                'group_ids_csv' => '5',
                'group_titles_csv' => 'Charity admin',
            ],
            'is_app_user' => [
                'group_ids_csv' => '8',
                'group_titles_csv' => 'User',
            ],
            'none' => [
                'group_ids_csv' => null,
                'group_titles_csv' => null,
            ],
        ];

        /*
         * Code block for migrating superadmins
         */
        $source_rows = \DB::table('accounts_old')->get();
        foreach ($source_rows as $key=>$row) {
            if($row->email == 'admin@letsbab.com'){
                continue;
            }
            echo "Migrating: {$row->id}";

            // Resolve group id, name
            $map_key = 'none';
            if ($row->is_admin == true) {
                $map_key = 'is_admin';
            } else if ($row->is_partner_admin == true) {
                $map_key = 'is_partner_admin';
            } else if ($row->is_charity_admin == true) {
                $map_key = 'is_charity_admin';
            } else if ($row->is_app_user == true) {
                $map_key = 'is_app_user';
            }

            $group_ids_csv = $map[$map_key]['group_ids_csv'];
            $group_titles_csv = $map[$map_key]['group_titles_csv'];
            // Resolve country id, name
            if($row->country == "US"){
                $row->country = "US (United States)";
            }elseif($row->country == "UK"){
                $row->country = "UK (United Kingdom)";
            }
            
            $country_id = $country_name = $currency = null;
            if (Country::where('name', $row->country)->remember(cacheTime('short'))->exists()) {
                $country = Country::where('name', $row->country)->remember(cacheTime('short'))->first();
                $country_id = $country->id;
                $country_name = $country->name;
                $currency = $country->currency;
            }

            // Resolve partner id, name
            $partner_id = null;
            $partner_uuid = null;
            $partner_name = null;
            if (Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->exists()) {
                $partner = Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->first();
                $partner_id = $partner->id;
                $partner_uuid = $partner->uuid;
                $partner_name = $partner->name;
            }

            // Resolve charity id, name
            $charity_id = null;
            $charity_uuid = null;
            $charity_name = null;
            if (Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->exists()) {
                $charity = Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->first();
                $charity_id = $charity->id;
                $charity_uuid = $charity->uuid;
                $charity_name = $charity->name;
            }
            $name = explode(' ', $row->name);
            if(isset($name[0])){
                $first_name = $name[0];
                $last_name = str_replace($first_name.' ', '', $row->name);
            }else{
                $first_name = null;
                $last_name = null;
            }
            \DB::table('users')->updateOrInsert(
                ['email' => $row->email],
                [
                    'uuid' => $row->id,
                    'name' => $row->name,
                    'full_name' => $row->name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $row->email,
                    'password' => $row->hashed_password,
                    'share_code' => $row->share_code,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at,
                    'auth_token' => $row->auth_token,
                    'group_ids_csv' => $group_ids_csv, // User group id
                    'group_titles_csv' => $group_titles_csv, // User group name
                    'email_confirmed' => 1,
                    'is_active' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'paypal_email' => $row->paypal_email,
                    'gender' => $row->gender,
                    'avatar_url' => $row->avatar_url,
                    'country_id' => $country_id,
                    'country_name' => $country_name,
                    'currency'=> $currency,
                    'payment_settings' => $row->payment_settings,
                    'device_token' => $row->device_token,
                    'notification_count' => $row->badge,
                    'next_billing_at' => $row->next_billing_on,
                    'total_earnings' => $row->total_earning,
                    'total_donations' => $row->total_donation,
                    'first_login_at' => $row->first_login_on,
                    'recommendation_count' => $row->total_recommend,
                    'purchase_count' => $row->total_purchase,
                    'device_name' => $row->device_name,
                    'current_app_version' => $row->current_app_version,
                    'transferwise_account_id' => $row->transferwise_account_id,
                    'email_verified_at' => isset($row->email_verified_at) ? $row->email_verified_at : now(),
                    'partner_id' => $partner_id,
                    'partner_uuid' => $partner_uuid,
                    'partner_name' => $partner_name,
                    'charity_id' => $charity_id,
                    'charity_uuid' => $charity_uuid,
                    'charity_name' => $charity_name,
                ]);

            // Add this user to group.
            User::where('uuid', $row->id)->first()->updateGroups();
            echo "  $key ... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate recommendurls from old recommend_urls  table.
     *
     * @param int $start
     */
    public function migrateRecommendurls($start = 0)
    {
        echo "<pre>";
        echo "Migration start: recommendurls <br/>";

        //$source_rows = \DB::table('recommend_urls_old')->orderBy('inserted_at', 'asc')->offset($start)->limit(500)->get();

        \DB::table('recommend_urls_old')->orderBy('inserted_at', 'asc')->chunk(100, function ($source_rows) {
            foreach ($source_rows as $row) {
                echo "Migrating: {$row->id}";

                // Resolve partner id, name
                $partner_id = null;
                $partner_uuid = null;
                $partner_name = null;
                if (Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->exists()) {
                    $partner = Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->first();
                    $partner_id = $partner->id;
                    $partner_uuid = $partner->id;
                    $partner_name = $partner->name;
                }
                // Resolve user id, name
                $user_id = $user_uuid = null;
                if (User::where('uuid', $row->user_id)->remember(cacheTime('short'))->exists()) {
                    $user = User::where('uuid', $row->user_id)->remember(cacheTime('short'))->first();
                    $user_id = $user->id;
                    $user_uuid = $user->uuid;
                }
                \DB::table('recommendurls')->updateOrInsert(
                    ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                    [
                        'uuid' => $row->id,
                        'url' => $row->url,
                        'short_code' => $row->short_code,
                        'created_by' => $user_id,
                        'updated_by' => $user_id,
                        'created_at' => $row->inserted_at,
                        'updated_at' => $row->updated_at,
                        'partner_id' => $partner_id,
                        'partner_uuid' => $partner_uuid,
                        'partner_name' => $partner_name,
                        'recommender_user_id' => $user_id,
                        'recommender_user_uuid' => $user_uuid,
                        'product_name' => $row->title,
                        'product_sku' => $row->sku_id,
                        'product_price' => $row->original_price,
                        'product_price_currency' => $row->currency,
                        'lb_env' => 'live',
                        'partner_env' => 'production',
                        'original_price' => $row->original_price,
                        'original_price_currency' => $row->currency
                    ]
                );
                echo "... Done <br/>";
            }
        });
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate beacons from old beacons  table.
     */
    public function migrateBeacons()
    {
        echo "<pre>";
        echo "Migration start: beacons <br/>";
        $source_rows = \DB::table('beacons_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";
            $data = json_decode($row->data, true);
            $products = array();
            if (isset($data['events'])) {
                foreach ($data['events'] AS $events) {
                    if (isset($events['event']) && $events['event'] == 'recommendation') {
                        $products['url'] = isset($events['url']) ? $events['url'] : '';
                        $products['partner_currency'] = isset($events['other']['currency']) ? $events['other']['currency'] : '';
                        $products['share_code'][] = isset($events['referrerId']) ? $events['referrerId'] : '';
                        $products['shortCode'][] = isset($events['shortCode']) ? $events['shortCode'] : '';
                    }
                    if (isset($events['event']) && isset($events['other']['line_items']) && $events['event'] == 'purchase') {
                        foreach ($events['other']['line_items'] as $line_items) {
                            if (isset($line_items['product']['id'])) {
                                $products['partner_product_id'][] = $line_items['product']['id'];
                                $products['partner_product_name'][] = $line_items['title'];
                                $products['price'][] = $line_items['price'];
                                if (isset($line_items['sku'])) {
                                    $products['partner_product_sku'][] = $line_items['sku'];
                                }
                            }
                        }
                        $products['partner_purchase_id'] = $events['purchaseId'];
                    }
                }
            }
            $partner_id = null;
            $partner_uuid = null;
            $partner_name = null;
            $partner_domain = isset($products['url']) ? parse_url($products['url'], PHP_URL_HOST) : '';
            $partner_domain = str_replace('www.', '', $partner_domain);
            if (Partner::where('live_url_root', 'like', '%' . $partner_domain . '%')->remember(cacheTime('short'))->exists()) {
                $partner = Partner::where('live_url_root', 'like', '%' . $partner_domain . '%')->remember(cacheTime('short'))->first();
                $partner_id = $partner->id;
                $partner_uuid = $partner->uuid;
                $partner_name = $partner->name;
            }
            if ($row->recommend_code == "") {
                $lb_env = 'sandbox';
            } else {
                $lb_env = 'live';
            }

            $recommender_ids = array();
            $recommender_uuids = array();
            if (isset($products['share_code'])) {
                if (User::whereIn('share_code', $products['share_code'])->remember(cacheTime('short'))->exists()) {
                    $user = User::whereIn('share_code', $products['share_code'])->remember(cacheTime('short'))->select('id')->get();
                    $recommender_ids = array_column($user->toArray(), 'id');
                    $recommender_uuids = array_column($user->toArray(), 'uuid');
                }
            }

            \DB::table('beacons')->updateOrInsert(
                ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'data' => $row->data,
                    'lb_env' => $lb_env,
                    'eventtype_name' => 'purchase',
                    'recommend_code' => json_encode($products['shortCode']),
                    'partner_id' => $partner_id,
                    'partner_uuid' => $partner_uuid,
                    'partner_name' => $partner_name,
                    'url' => isset($products['url']) ? $products['url'] : null,
                    'partner_product_id' => isset($products['partner_product_id']) ? json_encode($products['partner_product_id']) : json_encode(array()),
                    'partner_product_sku' => isset($products['partner_product_sku']) ? json_encode($products['partner_product_sku']) : json_encode(array()),
                    'partner_product_name' => isset($products['partner_product_name']) ? json_encode($products['partner_product_name']) : json_encode(array()),
                    // 'partner_product_price_cents' => isset($products['price']) ? json_encode($products['price']) : json_encode(array()),
                    'partner_currency' => $products['partner_currency'],
                    'partner_purchase_id' => isset($products['partner_purchase_id']) ? $products['partner_purchase_id'] : null,
                    'created_by' => null,
                    'updated_by' => null,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at,
                    'recommender_ids' => json_encode($recommender_ids),
                    'recommender_uuids' => json_encode($recommender_uuids)
                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate conversionrates from old conversionrates  table.
     */
    public function migrateConversionrates()
    {
        echo "<pre>";
        echo "Migration start: conversionrates <br/>";
        $source_rows = \DB::table('conversion_rates_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";
            $conversion_rates = json_decode($row->conversion_rates, true);
            \DB::table('conversionrates')->updateOrInsert(
                ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'data' => $row->conversion_rates,
                    'rate_u2e' => $conversion_rates['U2E'],
                    'rate_u2g' => $conversion_rates['U2G'],
                    'rate_e2u' => $conversion_rates['E2U'],
                    'rate_e2g' => $conversion_rates['E2G'],
                    'rate_g2u' => $conversion_rates['G2U'],
                    'rate_g2e' => $conversion_rates['G2E'],
                    'data_time' => $row->conversion_date,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at
                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate charityselections from old charity_choices  table.
     */
    public function migrateCharityselections()
    {
        echo "<pre>";
        echo "Migration start: charityselections <br/>";
        $source_rows = \DB::table('charity_choices_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";

            // Resolve charity
            $charity_id = $charity_uuid = $charity_name = null;
            if (Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->exists()) {
                $charity = Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->first();
                $charity_id = $charity->id;
                $charity_uuid = $charity->uuid;
                $charity_name = $charity->name;
            }
            // Resolve user id, name,email
            $user_id = null;
            $user_uuid = null;
            $user_name = null;
            $user_email = null;
            if (User::where('uuid', $row->account_id)->remember(cacheTime('short'))->exists()) {
                $user = User::where('uuid', $row->account_id)->remember(cacheTime('short'))->first();
                $user_id = $user->id;
                $user_uuid = $user->uuid;
                $user_name = $user->name;
                $user_email = $user->email;
            }
            \DB::table('charityselections')->updateOrInsert(
                ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'share_percentage' => $row->share,
                    'user_id' => $user_id,
                    'user_uuid' => $user_uuid,
                    'user_name' => $user_name,
                    'user_email' => $user_email,
                    'charity_id' => $charity_id,
                    'charity_uuid' => $charity_uuid,
                    'charity_name' => $charity_name,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at
                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate pushnotifications from old pushnotifications  table.
     */
    public function migratePushnotifications()
    {
        echo "<pre>";
        echo "Migration start: pushnotifications <br/>";
        $source_rows = \DB::table('push_notifications_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";
            \DB::table('pushnotifications')->updateOrInsert(
                ['uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                [
                    'uuid' => $row->id,
                    'name' => $row->title,
                    'message' => $row->message,
                    'success_count' => $row->total_sent,
                    'failure_count' => 0,
                    'created_at' => $row->inserted_at,
                    'updated_at' => $row->updated_at
                ]
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }

    /**
     * Migrate purchases from old purchases  table.
     */
    /*public function migratePurchases()
    {
        echo "<pre>";
        echo "Migration start: purchases <br/>";
        $source_rows = \DB::table('purchases_old')->get();
        foreach ($source_rows as $row) {
            echo "Migrating: {$row->id}";
            $data = array();
            $partner_id = null; 
            if (Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->exists()) {
                $partner = Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->first();
                $partner_id = $partner->id;
            }
            $user_id = null;
            if (User::where('uuid', $row->recommender_user_id)->remember(cacheTime('short'))->exists()) {
                $user = User::where('uuid', $row->recommender_user_id)->remember(cacheTime('short'))->first();
                $user_id = $user->id;
            }
            $recommendurl_id = null;
            if (Recommendurl::where('uuid', $row->recommendurl_id)->remember(cacheTime('short'))->exists()) {
                $recommendurl = Recommendurl::where('uuid', $row->recommendurl_id)->remember(cacheTime('short'))->first();
                $recommendurl_id = $recommendurl->id;
            }
            // Resolve charity id
            $charity_id = null;
            if (Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->exists()) {
                $charity = Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->first();
                $charity_id = $charity->id;
            }
            // Resolve beacon id
            $beacon_id = null;
            if (Beacon::where('uuid', $row->beacon_id)->remember(cacheTime('short'))->exists()) {
                $beacon = Beacon::where('uuid', $row->beacon_id)->remember(cacheTime('short'))->first();
                $beacon_id = $beacon->id;
            }
            foreach ($row as $key_row => $value_row) {
                $data[$key_row] = $value_row;
            }
            $data['recommendurl_id'] = $recommendurl_id;
            $data['partner_id'] = $partner_id;
            $data['recommender_user_id'] = $user_id;
            $data['charity_id'] = $charity_id;
            $data['beacon_id'] = $beacon_id;
            $data['recommendurl_uuid'] = $row->recommendurl_id;
            $data['partner_uuid'] = $row->partner_id;
            $data['recommender_user_uuid'] = $row->recommender_user_id;
            unset($data['id']);

            \DB::table('purchases')->updateOrInsert(
                ['id' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                $data
            );
            echo "... Done <br/>";
        }
        echo "... Migration complete.<br/>";
    }*/

    public function migratePurchases()
    {
        echo "<pre>";
        echo "Migration start: purchases <br/>";
        
        \DB::table('recommend_urls_old')->whereNotNull('purchased_on')->orderBy('id', 'asc')->chunk(100, function ($source_rows) {
            foreach ($source_rows as $key=>$row) {
                echo "Migrating: {$row->id}";

                // Resolve partner id, name
                $partner_id = null;
                $partner_uuid = null;
                $partner_name = null;
                if (Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->exists()) {
                    $partner = Partner::where('uuid', $row->partner_id)->remember(cacheTime('short'))->first();
                    $partner_id = $partner->id;
                    $partner_uuid = $row->partner_id;
                    $partner_name = $partner->name;
                }
                // Resolve user id, name
                $user_id = $user_uuid = $user_share_code = $user_currency = null;
                if (User::where('uuid', $row->user_id)->remember(cacheTime('short'))->exists()) {
                    $user = User::where('uuid', $row->user_id)->remember(cacheTime('short'))->first();
                    $user_id = $user->id;
                    $user_uuid = $user->uuid;
                    $user_share_code = $user->share_code;
                    $user_currency = $user->currency;
                }

                $beacon = Beacon::where('recommend_code', $row->short_code)->first();
                $beacon_raw = null;
                $beacon_id = null;
                if(isset($beacon->id)){
                    $beacon_raw = $beacon->data;
                    $beacon_id = $beacon->id;
                }
                // Resolve charity id
                $charity_id = null;
                $charity_name = null;
                $charity_currency = null;
                if (Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->exists()) {
                    $charity = Charity::where('uuid', $row->charity_id)->remember(cacheTime('short'))->first();
                    $charity_id = $charity->id;
                    $charity_name = $charity->name;
                    $charity_currency = $charity->currency;
                }
                
                if($row->currency == "GBP"){
                    $product_price_in_lb_currency = $row->original_price;
                }elseif ($user_currency == "GBP") {
                    $product_price_in_lb_currency = $row->price;
                }else{
                    $product_price_in_lb_currency = null;
                }
                if($charity_currency == $row->currency){
                    $product_price_in_charity_currency = $row->original_price;
                }elseif ($charity_currency == $user_currency) {
                    $product_price_in_charity_currency = $row->price;
                }else{
                    $product_price_in_charity_currency = null;
                }
                \DB::table('purchases')->updateOrInsert(
                    ['recommendurl_uuid' => $row->id], //  Check for existence. If this doesn't exist then create an entry.
                    [
                        'uuid' => uuid(),
                        'partner_id' => $partner_id,
                        'recommender_user_id' => $user_id,
                        'product_name' => $row->title,
                        'product_sku' => $row->sku_id,
                        'product_order_id' => $row->product_order_id,
                        'purchase_data' => $beacon_raw,
                        'charity_id' => $charity_id,
                        'charity_name' => $charity_name,
                        'charity_currency' => $charity_currency,
                        'recommender_invoice_status' => 'Payment due',
                        'recommender_transaction_status' => 'Payment due',
                        'charity_invoice_status' => !is_null($charity_id) ? 'Payment due' : null,
                        'charity_transaction_status' => !is_null($charity_id) ? 'Payment due' : null,
                        'partner_invoice_status' => 'Payment due',
                        'created_at' => $row->purchased_on,
                        'updated_at' => $row->purchased_on,
                        'beacon_id' => $beacon_id,
                        'recommendurl_short_code' => $row->short_code,
                        'recommendurl_uuid' => $row->id,
                        'partner_uuid'=> $partner_uuid,
                        'recommender_user_uuid'=> $user_uuid,
                        'product_currency'=> $row->currency,
                        'user_currency'=> $user_currency,
                        'lb_currency'=> 'GBP',
                        'commission_percentage_lb'=> 1,
                        'commission_percentage_recommender'=> 5,
                        'charity_share_percentage'=> $row->charity_share,
                        'product_price_in_product_currency'=>  $row->original_price,
                        'product_price_in_user_currency'=> $row->price,
                        'product_price_in_lb_currency'=> $product_price_in_lb_currency,
                        'product_price_in_charity_currency'=> $product_price_in_charity_currency,
                        'user_commission_in_user_currency'=> (($row->price * 5)/100),
                        'user_commission_in_lb_currency'=> !is_null($product_price_in_lb_currency) ? (($product_price_in_lb_currency * 5)/100) : null,
                        'user_commission_in_charity_currency'=> !is_null($product_price_in_charity_currency) ? (($product_price_in_charity_currency * 5)/100) : null,
                        'charity_donation_in_user_currency'=> (($row->price * $row->charity_share)/100),
                        'charity_donation_in_lb_currency'=> !is_null($product_price_in_lb_currency) ? (($product_price_in_lb_currency * $row->charity_share)/100) : null,
                        'charity_donation_charity_currency'=> !is_null($product_price_in_charity_currency) ? (($product_price_in_charity_currency * $row->charity_share)/100) : null,
                        'lb_commission_in_user_currency'=> ($row->price/100),
                        'lb_commission_in_lb_currency'=> !is_null($product_price_in_lb_currency) ? ($product_price_in_lb_currency/100) : null,
                        'lb_commission_in_charity_currency'=> !is_null($product_price_in_charity_currency) ? ($product_price_in_lb_currency/100) : null,
                        'product_url' => $row->url,
                        'product_title' => $row->title,
                        'product_line_price' => $row->original_price,
                        'product_vendor' => $partner_name,
                        'user_share_code' =>$user_share_code,
                    ]
                );
                echo "    $key... Done <br/>";
            }
        });
        echo "... Migration complete.<br/>";
    }
}
