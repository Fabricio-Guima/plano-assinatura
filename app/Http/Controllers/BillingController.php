<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\StripeClient;

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

    //usuário autenticado dá os seus dados para o stripe (nome, email, num do cartao e país)
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
            ->with('notification', ['title' => __("Método de pagamento atualizado!"), 'message' => __("Seu método de pagamento foi atualizado corretamente")]);
    }


    /**
    * @throws ApiErrorException
    */
    public function plans(): Renderable|RedirectResponse {
        //se o user não tiver um cartao de credito válido e registrado, não siga o próximo passo
        // if (!auth()->user()->hasdefaultPaymentMethod()) {
        //     return back();
        // }

        //pegue os planos do dono da conta do stripe
        $key = config('cashier.secret');
        $stripe = new StripeClient($key);
        $plans = $stripe->plans->all();
        $plans = $plans->data;
        $plans = array_reverse($plans);

        return view('front.billing.plans', compact("plans"));
    }

    //usuário de fato assinando um plano
    //defaultPaymentMethod é o cartão do user
    /**
     * @throws ApiErrorException
     */
    public function processSubscription(): RedirectResponse {
        $this->validate(request(), [
            "price_id" => "required|string|starts_with:price_",
        ]);

        $key = config('cashier.secret');
        $stripe = new StripeClient($key);
        $plan = $stripe->plans->retrieve(request("price_id"));

        try {
            auth()
                ->user()
                ->newSubscription('default', request("price_id"))
                ->create(auth()->user()->defaultPaymentMethod()->id);

                return redirect(route("billing.my_subscription"))
                    ->with('notification', ['title' => __("Obrigado por assinar um plano"), 'message' => __('Você assinou um plano ' . getPlanNameByStripePlan($plan) . ' corretamente lembre-se de olhar seu correio eletrônico caso seja necessário confirmar o pagamento')]);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route("billing.my_subscription")]
            );
        } catch (\Exception $exception) {
            return back()->with('notification', ['title' => __("Error"), 'message' => $exception->getMessage()]);
        }
    }

    public function mySubscription(): Renderable {
        $subscription = getSubscriptionNameForUser();
        return view("front.billing.my_subscription", compact("subscription"));
    }

}
