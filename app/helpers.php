<?php

use Stripe\StripeClient;

/**
 * @param $amount
 * @return int|string
 */
function formatCurrency($amount): int|string {
    if (!$amount) {
        $amount = 0;
    }

    if (!is_numeric($amount)) {
        return $amount;
    }

    return (new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY))->formatCurrency(
        $amount, config("cashier.currency"),
    );
}

function getPlanNameByStripePlan(\Stripe\Plan $plan): string {
    if($plan->interval_count === 3) {
        return "Trimestral";
    } else {
        if ($plan->interval === "year") {
            return "Anual";
        } else {
            return "Mensal";
        }
    }
}

function getSubscriptionNameForUser(): string {
    if (isSubscribed()) {
        $subscription = auth()->user()->subscription();
        $key = config('cashier.secret');
        $stripe = new StripeClient($key);
        $plan = $stripe->plans->retrieve($subscription->stripe_price);
        return getPlanNameByStripePlan($plan);
    }
    return "N/D";
}


function isSubscribed(): bool {
    return auth()->check() && auth()->user()->subscribed();
}
