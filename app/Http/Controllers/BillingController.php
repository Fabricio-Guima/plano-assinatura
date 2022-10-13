<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    //formulario de pagamento do stripe na view
   public function paymentMethodForm(): Renderable
    {
        $countries = Country::all();
        return view('front.billing.payment_method_form', [
            'intent' => auth()->user()->createSetupIntent(),
            'countries' => $countries,
        ]);
    }


    public function processPaymentMethod(): RedirectResponse
    {
        $this->validate(request(), [
            "pm" => "required|string|starts_with:pm_|max:50",
            "card_holder_name" => "required|max:150|string",
            "country_id" => "required|exists:countries,id",
        ]);

        if (!auth()->user()->hasStripeId()) {
            auth()->user()->createAsStripeCustomer([
                "address" => [
                    "country" => Country::find(request("country_id"))->code,
                ]
            ]);
        }
        auth()->user()->updateDefaultPaymentMethod(request("pm"));

        return back()
            ->with('notification', ['title' => __("¡Método de pagamento atualizado!"), 'message' => __("Seu método de pagamento foi atualizado corretamente")]);
    }

}
