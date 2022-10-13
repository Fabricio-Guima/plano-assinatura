<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Minha assinatura
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-8 divide-y-2 divide-gray-100 bg-gray-400 p-4">
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                        <span class="font-semibold title-font text-white">Plano contratado: {{ $subscription }}</span>
                    </div>
                    <div class="md:flex-grow">
                        {{-- <a href="{{ route('billing.portal') }}"
                            class="text-white bg-purple-500 border-0 py-2 px-4 focus:outline-none hover:bg-purple-600 rounded">Ver
                            minha fatura</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
