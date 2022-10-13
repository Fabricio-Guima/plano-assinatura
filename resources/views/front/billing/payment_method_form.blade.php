<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Atualizar seu método de pagamento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap -m-4">
                        <div class="p-4 lg:w-1/2 md:w-full">
                            <div class="relative mb-4">
                                <input placeholder="Titular" type="email" id="card-holder-name" name="card-holder-name"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        <div class="p-4 lg:w-1/2 md:w-full">
                            <div class="relative mb-4">
                                <select class="form-select appearance-none block w-full" id="country" name="country">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button" data-secret="{{ $intent->client_secret }}"
                        class="text-white bg-indigo-500 border-0 py-2 px-6 mt-5 focus:outline-none hover:bg-indigo-600 rounded">
                        Atualizar método de pagamento
                    </button>
                </div>

                <form id="payment_method_form" method="post" action="{{ route('billing.payment_method') }}">
                    @csrf
                    <input type="hidden" id="card_holder_name" name="card_holder_name" />
                    <input type="hidden" id="pm" name="pm" />
                    <input type="hidden" id="country_id" name="country_id" />
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{ config('cashier.key') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const country = document.getElementById('country');
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );

                if (error) {
                    alert(error.message)
                } else {
                    document.getElementById("pm").value = setupIntent.payment_method;
                    document.getElementById("card_holder_name").value = cardHolderName.value;
                    document.getElementById("country_id").value = country.value;
                    document.getElementById("payment_method_form").submit();
                }
            });
        </script>
    @endpush
</x-app-layout>
