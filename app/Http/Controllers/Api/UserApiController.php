<?php

namespace App\Http\Controllers\Api;

use App\Charity;
use App\Http\Controllers\AiddeclarationsController;
use App\Http\Controllers\CharityselectionsController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RecommendurlsController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\UsersController;
use App\Partner;
use App\Partnercategory;
use Request;
use Response;

class UserApiController extends ApiController
{

    /**
     * Gets user app users profile and summary data.
     *
     * @return string
     */
    public function getUserProfile()
    {
        $ret = ret('success', "User information", ['data' => $this->user()]);
        return Response::json(fillRet($ret));
    }

    /**
     * Resolve user based on logged_user. This is set in middleware CheckBearerToken.
     *
     * @return \App\User
     */
    public function user()
    {
        // This is set during bearer token check in middleware : app/Http/Middleware/CheckBearerToken.php
        return Request::get('logged_user');
    }

    /**
     * Update a recommendation url
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function usersPatch()
    {
        //dd(Request::all());
        //Request::merge(['recommender_user_id' => $this->user()->id]);
        return app(UsersController::class)->update($this->user()->id);
    }

    /**
     * Get a list of brand categories and brands under them with singled out featured brand.
     *
     * @var Partnercategory $partnercategory
     * @var \App\Partner $partner
     * @return \Illuminate\Http\JsonResponse
     */
    public function brands()
    {
        /*
         *  Get featured partner
         ************************/
        $featured_partner = $this->fillPartnerData(Partner::featured());
        // $featured_partner = Partner::featured();

        // Find the partner id
        $user_viewable_partner_ids = Partner::idsOfPartnerViewableByUser($this->user());

        /*
         * Prepare categorized partner payload
         *************************************/
        $partnercategories = Partnercategory::getActiveList();
        $categories_array = [];
        foreach ($partnercategories as $partnercategory) {
            $partners_array = [];
            // For each partner prepare API payload
            foreach ($partnercategory->partners as $partner) {
                if (in_array($partner->id, $user_viewable_partner_ids)) {
                    $partners_array[] = $this->fillPartnerData($partner);
                    // $partners_array[] = $partner;
                }
            }
            /*
             * Prepare category payload
             ***************************/
            if (count($partners_array)) {
                $categories_array[] = array_merge(
                    $this->fillPartnercategoryData($partnercategory),
                    ['brands' => $partners_array]
                );
            }
        }
        /**
         * Pack and return data as payload
         *********************************/
        $data = [
            'featured_partner' => $featured_partner,
            'categories' => $categories_array,
        ];
        $ret = ret('success', "Featured partner with categorised partner list", ['data' => $data]);
        return Response::json(fillRet($ret));
    }

    /**
     * Create an array filled with partner data for API response.
     *
     * @param $partner \App\Partner
     * @return array
     */
    public function fillPartnerData($partner)
    {
        return [
            'id' => $partner->id,
            'name' => $partner->name,
            'logo' => $partner->logo,
            'live_url_root' => $partner->live_url_root,
            'block_logo' => $partner->block_logo,
            'cover_photo_horizontal' => $partner->cover_photo_horizontal,
            'cover_photo_vertical' => $partner->cover_photo_vertical,
        ];
    }

    /**
     * Create an array filled with partner category data for API response.
     *
     * @param $partnercategory \App\Partnercategory
     * @return array
     */
    public function fillPartnercategoryData($partnercategory)
    {
        return [
            'id' => $partnercategory->id,
            'name' => $partnercategory->name,
            'order' => $partnercategory->order,
        ];
    }

    /**
     * Get a list of charities that are available in users country/region.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function charities()
    // {
    //     // Find the partner id
    //     $user_viewable_charity_ids = Charity::idsOfCharityViewableByUser($this->user());
    //     Request::merge(['user_id' => $this->user()->id, 'sort_by' => 'name', 'sort_order' => 'asc',
    //         'id' => implode(',', $user_viewable_charity_ids)]);
    //     return app(CharitiesController::class)->list();
    // }

    /**
     * Get a list of charities that are available in users country/region.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function charities()
    {
        // Find the charities viewable by logged in user.
        $charities = Charity::whereIn('id', Charity::idsOfCharityViewableByUser($this->user()))->get();

        // Add in paylaod and respond.
        $ret = ret('success', "Charity list", ['data' => $charities]);
        return Response::json(fillRet($ret));
    }

    /**
     * Add a new charity-selection and store share percentage.
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function charityselectionsStore()
    {
        Request::merge(['user_id' => $this->user()->id]);
        return app(CharityselectionsController::class)->store();
    }

    /**
     * List of charity-selections by a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function charityselectionsList()
    {
        Request::merge(['user_id' => $this->user()->id, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        return app(CharityselectionsController::class)->list();
    }

    /**
     * List of charity-selections by a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function charityselectionsLatest()
    {
        $charityselection = $this->user()->currentCharityselection;
        $data = $charityselection;
        $data['charity'] = $charityselection->charity;
        $ret = ret('success', "Latest charity selection", ['data' => $data]);
        return Response::json(fillRet($ret));
    }

    /**
     * Add a new charity-selection and store share percentage.
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function aiddeclarationsStore()
    {
        Request::merge(['user_id' => $this->user()->id]);
        return app(AiddeclarationsController::class)->store();
    }

    /**
     * List of charity-selections by a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function aiddeclarationsList()
    {
        Request::merge(['user_id' => $this->user()->id, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        return app(AiddeclarationsController::class)->list();
    }

    /**
     * List of charity-selections by a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function aiddeclarationsLatest()
    {
        $data = $this->user()->currentAiddeclaration;
        $ret = ret('success', "Latest aid-declaration by user", ['data' => $data]);
        return Response::json(fillRet($ret));
    }

    /**
     * Create a recommendation url
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function recommendurlsStore()
    {
        Request::merge(['recommender_user_id' => $this->user()->id]);
        return app(RecommendurlsController::class)->store();
    }

    /**
     * List of recommendations by a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommendurlsList()
    {
        Request::merge(['recommender_user_id' => $this->user()->id, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        return app(RecommendurlsController::class)->list();
    }

    /**
     * Get a summary of user earnings and donations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommenderUserSummary()
    {
        $data = $this->user()->recommenderSummary();
        $ret = ret('success', "Recommender summary of earnings and donations ", ['data' => $data]);
        return Response::json(fillRet($ret));
    }

    /**
     * Get a list of activities of user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommenderUserActivities()
    {
        Request::merge(['recommender_user_id' => $this->user()->id, 'sort_by' => 'created_at', 'sort_order' => 'desc', 'with' => 'recommendurl']);
        return app(PurchasesController::class)->list();
    }

    /**
     * Make user uplaods
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uplaodsStore()
    {
        Request::merge([
            'module_id' => 4, // 4=users module
            'element_id' => $this->user()->id,
        ]);
        return app(UploadsController::class)->store();
    }

    /**
     * Delete avatar
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function uplaodsDeleteAvatar()
    {
        $this->user()->update(['avatar_url' => null]);
        $this->user()->uploads()->where('type', 'Avatar')->delete();
        $ret = ret('success', "Avatar deleted");
        return Response::json(fillRet($ret));
    }
}
