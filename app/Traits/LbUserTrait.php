<?php

namespace App\Traits;

use App\Aiddeclaration;
use App\Charityselection;
use App\Invoice;
use App\Purchase;
use App\Recommendurl;
use DB;

trait LbUserTrait
{

    /**
     * Get a list of recent/all charity selections of this user.
     *
     * @return mixed|Charityselection
     */
    public function charityselctions()
    {
        return $this->hasMany(Charityselection::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get current charity selection of this user
     *
     * @return mixed|Charityselection
     */
    public function currentCharityselection()
    {
        return $this->hasOne(Charityselection::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get a list of recent/all aid-declarations of this user
     *
     * @return mixed|Aiddeclaration
     */
    public function aiddeclarations()
    {
        return $this->hasMany(Aiddeclaration::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get current aid-declaration of this user
     *
     * @return mixed|Aiddeclaration
     */
    public function currentAiddeclaration()
    {
        return $this->hasOne(Aiddeclaration::class)->orderBy('created_at', 'desc');
    }

    /**
     * @return mixed|Invoice
     */
    public function lastInvoice()
    {
        return $this->hasOne(Invoice::class, 'recommender_user_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get next billing details of the user with (possible)amount and date.
     *
     * @param null $currency
     * @return array
     */
    public function nextBilling($currency = null)
    {
        /** @var \App\User $this */
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
     * Calculate users last billing date. If user(recommender) has an invoice then the take
     * the last invoice date.If not then consider user->created_at to be the last billing
     * date (theoretically) for the sake of calculation.
     *
     * @return string
     */
    public function lastBillingDate()
    {
        /** @var \App\User $this */
        if ($this->lastInvoice()->exists()) {
            $date = $this->lastInvoice->created_at;
        } else {
            $date = $this->created_at; // Update calculation
        }

        return $date->toDateString(); // Return a date Not datetime
    }

    /**
     * Calculate users next billing date.
     *
     * @return string
     */
    public function nextBillingDate()
    {
        /** @var \App\User $this */
        $date = $this->created_at->addDays(45)->toDateString(); // Update calculation
        return $date; // Return a date Not datetime
    }

    /**
     * Next billing amount (Total earning for next billing)
     *
     * @param null $currency
     * @return array
     */
    public function nextBillingAmount($currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>', $this->lastBillingDate())
            ->where(DB::raw('date(created_at)'), '<=', $this->nextBillingDate())
            ->sum('user_commission_in_user_currency');

        $total = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
        ];

        return $total;
    }

    /**
     * details of the users next donation to charity
     *
     * @param null $currency
     * @return array
     */
    public function nextDonation($currency = null)
    {
        /** @var \App\User $this */
        $amount = $this->nextDonationAmount($currency);
        $date = $this->nextDonationDate();

        $ret = [
            'currency' => $amount['currency'],
            'currency_symbol' => currencySymbol($amount['currency']),
            'amount' => $amount['amount'],
            'date' => $date,
        ];

        return $ret;
    }

    /**
     * Calculate users last donation date
     *
     * @return \Carbon\Carbon|string
     */
    public function lastDonationDate()
    {
        /** @var \App\User $this */
        $date = $this->lastBillingDate(); // Update calculation
        return $date; // Return a date Not datetime
    }

    /**
     * Calculate users next billing date
     *
     * @return \Carbon\Carbon|string
     */
    public function nextDonationDate()
    {
        /** @var \App\User $this */
        $date = $this->nextBillingDate(); // Update calculation
        return $date; // Return a date Not datetime
    }

    /**
     * Next Donation amount (Total earning for next billing)
     *
     * @param null $currency
     * @return array
     */
    public function nextDonationAmount($currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>', $this->lastDonationDate())
            ->where(DB::raw('date(created_at)'), '<=', $this->nextDonationDate())
            ->sum('charity_donation_in_user_currency');

        $total = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
        ];

        return $total;
    }

    /**
     * Calculate total commission earned by a user till today. This amount includes
     * user commission of current billing cycle also which is not yet paid(transferred)
     * but will be paid(probably) on the upcoming billing date of user (if the minimum
     * required amount is earned).
     *
     * @param null $currency
     * @return array
     */
    public function totalCommissionEarned($currency = null)
    {
        /** @var \App\User $this */
        return $this->totalCommissionEarnedDuring(null, null, $currency);
    }

    /**
     * Calculate total commission earned by a user on a specific day.
     *
     * @param null $date
     * @param null $currency
     * @return array
     */
    public function totalCommissionEarnedOn($date = null, $currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$date) $date = today()->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), $date)
            ->sum('user_commission_in_user_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'date' => $date
        ];

        return $ret;
    }

    /**
     * Calculate total commission earned by a user on a date range.
     *
     * @param null $start_date
     * @param null $end_date
     * @param null $currency
     * @return array
     */
    public function totalCommissionEarnedDuring($start_date = null, $end_date = null, $currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$start_date) $start_date = $this->created_at->format('Y-m-d'); // By default set $start_date to user creation date.
        if (!$end_date) $end_date = today()->toDateString(); // By default set end date to today.
        //$end_date_plus_one = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>=', $start_date)
            ->where(DB::raw('date(created_at)'), '<=', $end_date)
            ->sum('user_commission_in_user_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $ret;
    }

    /**
     * Calculate total donation earned by a user till today. This amount includes
     * donation amount of current billing cycle also which is not yet paid(transferred)
     * to charity but will be paid(probably) on the upcoming billing date of charity.
     *
     * @param null $currency
     * @return array
     */
    public function totalDonation($currency = null)
    {
        /** @var \App\User $this */
        return $this->totalDonationDuring(null, null, $currency);
    }

    /**
     * Calculate total donation given by a user on a specific day.
     *
     * @param null $date
     * @param null $currency
     * @return array
     */
    public function totalDonationOn($date = null, $currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$date) $date = today()->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), $date)
            ->sum('charity_donation_in_user_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'date' => $date
        ];

        return $ret;
    }

    /**
     * Calculate total donation given by a user on a range of days.
     *
     * @param null $start_date
     * @param null $end_date
     * @param null $currency
     * @return array
     */
    public function totalDonationDuring($start_date = null, $end_date = null, $currency = null)
    {
        /** @var \App\User $this */
        // If no currency is set then set to user currency
        if (!$currency) $currency = $this->currency;
        if (!$start_date) $start_date = $this->created_at->format('Y-m-d'); // By default set $start_date to user creation date.
        if (!$end_date) $end_date = today()->toDateString(); // By default set end date to today.
        //$end_date_plus_one = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        //$amount = 99.99; // Complete calculation.
        $amount = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>=', $start_date)
            ->where(DB::raw('date(created_at)'), '<=', $end_date)
            ->sum('charity_donation_in_user_currency');

        $ret = [
            'currency' => $currency,
            'currency_symbol' => currencySymbol($currency),
            'amount' => money($amount),
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $ret;
    }

    /**
     * Count total number of recommendations by a user till now.
     *
     * @return array
     */
    public function totalRecommendationCount()
    {
        /** @var \App\User $this */
        return $this->totalRecommendationCountDuring(null, null);
    }

    /**
     * Count total recommendations made by a user on a specific day.
     *
     * @param null $date
     * @return array
     */
    public function totalRecommendationCountOn($date = null)
    {
        /** @var \App\User $this */
        if (!$date) $date = today()->toDateString();

        //$count = 999; // Complete calculation.
        $count = Recommendurl::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), $date)
            ->count();

        $ret = [
            'count' => $count,
            'date' => $date
        ];

        return $ret;
    }

    /**
     * Count total recommendations made by a user on a range of days.
     *
     * @param null $start_date
     * @param null $end_date
     * @return array
     */
    public function totalRecommendationCountDuring($start_date = null, $end_date = null)
    {
        /** @var \App\User $this */
        if (!$start_date) $start_date = $this->created_at->format('Y-m-d'); // By default set $start_date to user creation date.
        if (!$end_date) $end_date = today()->toDateString(); // By default set end date to today.

        $count = Recommendurl::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>=', $start_date)
            ->where(DB::raw('date(created_at)'), '<=', $end_date)
            ->count();

        $ret = [
            'count' => $count,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $ret;
    }

    /**
     * Count total number of purchases made through this user.
     *
     * @return array
     */
    public function totalPurchaseCount()
    {
        /** @var \App\User $this */
        return $this->totalPurchaseCountDuring(null, null);
    }

    /**
     * Count total number of purchases made through this user on a specific day.
     *
     * @param null $date
     * @return array
     */
    public function totalPurchaseCountOn($date = null)
    {
        /** @var \App\User $this */
        if (!$date) $date = today()->toDateString();

        //$count = 9999; // Complete calculation.
        $count = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), $date)
            ->count();

        $ret = [
            'count' => $count,
            'date' => $date
        ];

        return $ret;
    }

    /**
     * Count total number of purchases made through this user on a range of days.
     *
     * @param null $start_date
     * @param null $end_date
     * @return array
     */
    public function totalPurchaseCountDuring($start_date = null, $end_date = null)
    {
        /** @var \App\User $this */
        if (!$start_date) $start_date = $this->created_at->format('Y-m-d'); // By default set $start_date to user creation date.
        if (!$end_date) $end_date = today()->toDateString(); // By default set end date to today.
        //$end_date_plus_one = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        //$count = 999; // Complete calculation.
        $count = Purchase::where('recommender_user_id', $this->id)
            ->where(DB::raw('date(created_at)'), '>=', $start_date)
            ->where(DB::raw('date(created_at)'), '<=', $end_date)
            ->count();

        $ret = [
            'count' => $count,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return $ret;
    }

    /**
     * Calculate users conversion rate.
     *
     * @return float|int
     */
    public function conversionRate()
    {

        $total_recommendation_count = $this->totalRecommendationCount();
        $total_purchase_count = $this->totalPurchaseCount();

        $conversion_rate = 0;
        if ($total_recommendation_count['count'] > 0) {
            if ((($total_purchase_count['count'] * 100) / $total_recommendation_count['count']) > 100) {
                $conversion_rate = 100;
            } else {
                $conversion_rate = floor(($total_purchase_count['count'] * 100) / $total_recommendation_count['count']);
            }
        }

        return $conversion_rate;

    }

    /**
     * Get recommender summary of earnings and donations.
     *
     * @return array
     */
    public function recommenderSummary()
    {
        /** @var \App\User $this */
        $total_commission_earned = $this->totalCommissionEarned();
        $total_donated = $this->totalDonation();
        $total_recommendation_count = $this->totalRecommendationCount();
        $total_purchase_count = $this->totalPurchaseCount();
        $conversion_rate = $this->conversionRate();
        $next_user_billing = $this->nextBilling();
        $next_donation = $this->nextDonation();

        /*
         *  Need to clarify what else is considered here.
         */
        //$total_purchases =
        // $conversion_rate = null;
        // $conversion_rate = null;

        $summary = [
            'total_commission_earned' => $total_commission_earned,
            'total_donated' => $total_donated,
            'total_recommendation_count' => $total_recommendation_count,
            'total_purchase_count' => $total_purchase_count,
            'conversion_rate' => $conversion_rate,
            'next_user_billing' => $next_user_billing,
            'next_donation' => $next_donation,
            'user' => $this,
        ];

        return $summary;
    }

}