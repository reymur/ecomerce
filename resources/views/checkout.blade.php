@extends('layout')

@section('title', 'Checkout')

@section('extra-css')
    <style>
        .mt-32 {
            margin-top: 32px;
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>

@endsection

@section('content')

    <div class="container">

        @if(session()->has('success_message'))
            <div class="spacer"></div>
            <div id="alert" class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div id="alert" class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="checkout-heading stylish-heading">Checkout</h1>

        <div class="checkout-section">
            <div>
                <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                    {{ csrf_field() }}
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        @if (auth()->user())
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @else
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}" required>
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <h2>Payment Details</h2>

                    <div class="form-group">
                        <label for="name_on_card">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="{{ old('name_on_card') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div> <!--end card elements-->

                    <button type="submit" id="complete-order" class="button-primary full-width">Complete Order</button>

                </form>

                <div class="mt-32">or</div>
                <div class="mt-32">
                    <h2>Pay with PayPal</h2>

                    <form method="post" id="paypal-payment-form" action="">
                        @csrf
                        <section>
                            <div class="bt-drop-in-wrapper">
                                <div id="bt-dropin"></div>
                            </div>
                        </section>

                        <input id="nonce" name="payment_method_nonce" type="hidden" />
                        <button class="button-primary" type="submit"><span>Pay with PayPal</span></button>
                    </form>
                </div>
            </div>



            <div class="checkout-table-container">
                <h2>Your Order</h2>

                <div class="checkout-table">
                    @foreach(Cart::content() as $item)
                        <div class="checkout-table-row">
                            <div class="checkout-table-row-left">
                                <img src="{{ productImage($item->model->slug) }}" alt="item" class="checkout-table-img">
                                <div class="checkout-item-details">
                                    <div class="checkout-table-item">{{ $item->model->name }}</div>
                                    <div class="checkout-table-description">{{ $item->model->details }}</div>
                                    <div class="checkout-table-price">{{ presentPrice($item->price) }}</div>
                                </div>
                            </div> <!-- end checkout-table -->

                            <div class="checkout-table-row-right">
                                <div class="checkout-table-quantity">{{ $item->qty }}</div>
                            </div>
                        </div> <!-- end checkout-table-row -->
                    @endforeach
                </div> <!-- end checkout-table -->

                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        Subtotal <br>
                        @if(session()->has('coupon'))
                            Discount ({{ session()->get('coupon')['name'] ?? '' }}):
                            <form action="{{ route('coupon.destroy') }}" method="post" style="display:inline">
                                @csrf()
                                @method('delete')

                                <button type="submit" style="font-size:11px"> Remove</button>
                            </form>
                            <br>
                            <hr>
                            new subtotal
                            <br>
                        @endif
                        Tax ({{config('cart.tax')}}%) <br>
                        <span class="checkout-totals-total">Total</span>
                    </div>

                    <div class="checkout-totals-right">
                        {{ presentPrice(Cart::subtotal()) }}<br>
                        @if(session()->has('coupon'))
                            -{{ presentPrice( $discount ) }} <br>
                            <hr>
                            {{ presentPrice( $newSubTotal ) }} <br>
                        @endif

                        {{ presentPrice( $newTax ) }}<br>
                        <span class="checkout-totals-total">{{ presentPrice( $newTotal   ) }}</span>
                    </div>
                </div> <!-- end checkout-totals -->

                @if(! session()->has('coupon'))
                    <a href="#" class="have-code">Have code?</a>
                    <div class="have-code-container">
                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf()

                            <label>
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control">
                            </label>
                            <button type="submit" class="button button-plain">Apply</button>
                        </form>
                    </div> <!--end have code container-->
                @endif
            </div>

        </div> <!-- end checkout-section -->
    </div>

@endsection

@section('extra-js')
    <script>
        (function(){
            // Create a Stripe client.
            var stripe = Stripe('pk_test_51GrCQQK0R9dJVTxPVPgvjtH7HmfZl5EWQqMQAjAQjxhpbTS0ghR8UeLF4q6BEy5fiJityMGyQqx6jsc9aNDuX4vs00Ke60Evra');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Roboto", "Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                document.getElementById('complete-order').textContent = 'Please wait...';
                document.getElementById('complete-order').disabled = true;

                var options = {
                    name: document.getElementById('name_on_card').value,
                    address_line1: document.getElementById('address').value,
                    address_city: document.getElementById('city').value,
                    address_state: document.getElementById('province').value,
                    address_zip: document.getElementById('postalcode').value,
                }

                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;

                        document.getElementById('complete-order').textContent = 'complete-order';
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        document.getElementById('complete-order').textContent = 'Please wait...';
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        })();
    </script>
@endsection
