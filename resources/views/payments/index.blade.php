<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form
                        x-on:submit.prevent="confirmCardPayment"

                        x-data="{
                            stripe: null,
                            cardElement: null,

                            init(){
                                this.stripe = Stripe('{{config('stripe.key')}}')

                                const elements = this.stripe.elements()
                                this.cardElement = elements.create('card',{})
                                this.cardElement.mount('#card-element')
                            },

                            async confirmCardPayment(){
                                await this.stripe.confirmCardPayment(
                                    '{{$paymentIntent->client_secret}}',{
                                        payment_method: {
                                            card: this.cardElement,
                                            billing_details:{
                                                email: '{{auth()->user()->email}}'
                                            }
                                        }
                                    }
                                )
                            }

                        }"
                    >

                        <div id="card-element"></div>

                        <x-primary-button class="mt-3">
                            Make Payment
                        </x-primary-button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
