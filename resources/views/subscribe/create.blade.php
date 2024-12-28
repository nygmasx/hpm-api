<x-customer-layout>
    <div>
        <section class="bg-white py-8 antialiased md:py-16">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="mx-auto max-w-5xl">
                    <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Paiement</h2>

                    <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                        <form id="payment-form" class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6 lg:max-w-xl lg:p-8">
                            <div class="mb-6 grid gap-6">
                                <!-- Name field -->
                                <div>
                                    <label for="card-holder-name" class="mb-2 block text-sm font-medium text-gray-900">
                                        Nom*
                                    </label>
                                    <input type="text" id="card-holder-name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" required />
                                </div>

                                <!-- Address fields -->
                                <div>
                                    <label for="line1" class="mb-2 block text-sm font-medium text-gray-900">Addresse 1*</label>
                                    <input type="text" id="line1" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" required />
                                </div>

                                <div>
                                    <label for="line2" class="mb-2 block text-sm font-medium text-gray-900">Addresse 2</label>
                                    <input type="text" id="line2" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="mb-2 block text-sm font-medium text-gray-900">Ville*</label>
                                        <input type="text" id="city" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" required />
                                    </div>

                                    <div>
                                        <label for="postal_code" class="mb-2 block text-sm font-medium text-gray-900">Code postal*</label>
                                        <input type="text" id="postal_code" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" required />
                                    </div>
                                </div>

                                <div>
                                    <label for="country" class="mb-2 block text-sm font-medium text-gray-900">Pays*</label>
                                    <select id="country" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" required>
                                        <option value="FR">France</option>
                                    </select>
                                </div>

                                <!-- Card Element -->
                                <div>
                                    <label for="card-element" class="mb-2 block text-sm font-medium text-gray-900">
                                        Informations bancaires*
                                    </label>
                                    <div id="card-element" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500"></div>
                                    <div id="card-errors" class="mt-2 text-sm text-red-600" role="alert"></div>
                                </div>
                            </div>

                            <button type="submit" id="card-button" data-secret="{{$intent->client_secret}}" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300">
                                <span id="button-text">Payer</span>
                                <div id="spinner" class="hidden">
                                    <svg class="animate-spin h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </form>

                        <div class="mt-6 grow sm:mt-8 lg:mt-0">
                            <div class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6">
                                <dl class="flex items-center justify-between gap-4 pt-2">
                                    <dt class="text-base font-bold text-gray-900">Total</dt>
                                    <dd class="text-base font-bold text-gray-900">19,99€</dd>
                                </dl>
                            </div>

                            <div class="mt-6 flex items-center justify-center gap-8">
                                <img class="h-8 w-auto" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg" alt="" />
                                <img class="h-8 w-auto" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{config('stripe.stripe-key')}}');
            const elements = stripe.elements();

            const style = {
                base: {
                    color: '#32325d',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#dc2626',
                    iconColor: '#dc2626'
                }
            };

            const cardElement = elements.create('card', {style});
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            const cardButton = document.getElementById('card-button');
            const cardHolderName = document.getElementById('card-holder-name');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Disable the submit button to prevent repeated clicks
                cardButton.disabled = true;
                spinner.classList.remove('hidden');
                buttonText.textContent = 'Processing...';

                try {
                    const {setupIntent, error} = await stripe.confirmCardSetup(
                        cardButton.dataset.secret,
                        {
                            payment_method: {
                                card: cardElement,
                                billing_details: {
                                    name: cardHolderName.value,
                                    address: {
                                        line1: document.getElementById('line1').value,
                                        line2: document.getElementById('line2').value || null,
                                        city: document.getElementById('city').value,
                                        postal_code: document.getElementById('postal_code').value,
                                        country: document.getElementById('country').value,
                                    }
                                }
                            }
                        }
                    );

                    if (error) {
                        // Show error to your customer
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = error.message;

                        // Re-enable the submit button
                        cardButton.disabled = false;
                        spinner.classList.add('hidden');
                        buttonText.textContent = 'Pay now';
                    } else {
                        try {
                            const response = await axios.post('{{ route('subscribe.store') }}', {
                                paymentMethod: setupIntent.payment_method,
                                name: cardHolderName.value,
                                address: {
                                    line1: document.getElementById('line1').value,
                                    line2: document.getElementById('line2').value || null,
                                    city: document.getElementById('city').value,
                                    postal_code: document.getElementById('postal_code').value,
                                    country: document.getElementById('country').value,
                                }
                            });

                            if (response.data.success) {
                                window.location.href = '{{ route('subscribe.index') }}';
                            } else {
                                throw new Error(response.data.message || 'Subscription failed');
                            }
                        } catch (error) {
                            const errorElement = document.getElementById('card-errors');
                            errorElement.textContent = error.response?.data?.message || 'An error occurred while processing your payment.';

                            cardButton.disabled = false;
                            spinner.classList.add('hidden');
                            buttonText.textContent = 'Payer maintenant';
                        }
                    }
                } catch (err) {
                    console.error(err);
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = 'An unexpected error occurred. Please try again.';

                    cardButton.disabled = false;
                    spinner.classList.add('hidden');
                    buttonText.textContent = 'Payer mau';
                }
            });

            // Handle real-time validation errors from the card Element
            cardElement.addEventListener('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        </script>
    @endpush
</x-customer-layout>
