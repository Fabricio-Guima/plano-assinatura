<?php

use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::group(["middleware" => "auth"], function () {
    Route::get("/dashboard", function () {
        return view('dashboard');
    })->name("dashboard");

    Route::controller(BillingController::class)
        ->as("billing.")
        ->prefix("billing")
        ->group(function () {
            Route::get("/payment-method", "paymentMethodForm")->name("payment_method_form");
            Route::post("/payment-method", "processPaymentMethod")->name("payment_method");
            Route::get("/plans", "plans")->name("plans");
            Route::post("/subscribe", "processSubscription")->name("process_subscription");
            Route::get("/subscription", "mySubscription")->name("my_subscription");
        });
});


require __DIR__.'/auth.php';
