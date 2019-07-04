@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body> --}}

<div class="container">

        @include('inc.errors')

    <div><h1>Checkout</h1></div><br><br>

    <div class="row">

        <div class="col">

            <h3>Billing Details</h3>


    <script src="https://js.stripe.com/v3/"></script>

    <form action="/checkout" method="POST" id="payment-form">
        @csrf

        <div class="form-group">
            <label for="InputName">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name"  value="{{ old('country') }}">
        </div>

        <div class="form-group">
            <label for="InputEmail">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email"  value="{{ old('email') }}">
        </div>

        <div class="form-group">
                <label for="InputCountry">Country</label>
                <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="{{ old('country') }}">
        </div>

        <div class="form-group">
            <label for="InputState">State</label>
            <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ old('state') }}">
        </div>

        <div class="form-group">
                <label for="InputShippingAddress">Shipping address</label>
                <input type="text" name="shippingAddress" id="shippingAddress" class="form-control" placeholder="Shipping Address" value="{{ old('shippingAddress') }}">
        </div>

        <div class="row">

            <div class="form-group col">
                <label for="InputPhone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"  value="{{ old('phone') }}">
            </div>


            <div class="form-group col">
                <label for="Inputcity">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ old('city') }}">
            </div>
        </div>

        <br><br><h3>Payment Details</h3>

        <div class="form-group">
            <label for="InputCardName">Name on Card</label>
            <input type="text" name="nameOnCard" id="cardName" class="form-control" placeholder="Name on Card" required value="{{ old('nameOnCard') }}">
        </div>

         <div class="form-group">

            <div class="form-row flex-column">
                <label for="card-element">
                  Credit or debit card
                </label>

                <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

         </div>
{{--
        <div class="form-group" id="card-number">
            <label for="InputCardName">Card Number</label>
            <input type="text" name="cardNumber" class="form-control" placeholder="Card Number" required value="{{ old('cardNumber') }}">
        </div>

        <div class="row">


                <div class="form-group col">
                    <label for="InputCVC">CVC</label>
                    <input type="text" name="cvc" max="3" class="form-control" placeholder="CVC" required value="{{ old('cvc') }}">
                </div>


                <div class="form-group col">
                    <label for="InputExpire">Expiry</label>
                    <input type="text" name="expiry" class="form-control" placeholder="MM/YY" required value="{{ old('expire') }}">
                </div>

        </div>  --}}

        <button class="btn btn-success" id="complete_order" type="submit">Complete purchase >></button>

    </form>




        </div>

        <div class="col">

            <h2>Order Summary</h2>

            <table class="table">

            @foreach (Cart::instance('default')->content() as $product)

                <tr>
                    <tbody>

                        <td>
                            <a href="products/{{ $product->model->item }}">
                                <img style="max-height:80px; padding:0.5rem"
                                src="storage/images/{{ $product->model->item }}/{{ $product->options->image }}" alt="{{ $product->item }}">
                            </a></td>

                        <td><a href="products/{{ $product->model->item }}">{{ $product->model->item }}</a></td>

                        <td>{{ $product->qty }}</td>

                        <td>{{ $product->model->price }}</td>

                        <td>{{ $product->total }}</td>

                    </tbody>

                </tr>

            @endforeach

                <tr>
                    <td>
                            Subtotal  <span style="margin-left:20rem;" >{{ Cart::instance('default')->subtotal() }}</span>
                    </td>

                </tr>

                <tr>

                    <td>
                        Tax  <span style="margin-left:20rem;">{{ Cart::instance('default')->tax() }}</span>
                    </td>

                </tr>

                <tr>
                    <td>
                        <strong>Subtotal  <span  style="margin-left:20rem;">{{ Cart::instance('default')->total() }}</span></strong>
                    </td>
                </tr>

            </table>

            <div>

                <label for="Inputcouponcode">
                    Having a code?
                </label>

                <form action="" class="form-inline"method="post">
                    <div class="form-group">
                        <input type="text" name="code" class="form-control" placeholder="Enter coupon code" >
                        <button class="btn btn-primary" type="submit">Apply</button>

                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

@endsection

@section('stripe_js')

<script>
            // Create a Stripe client.
        var stripe = Stripe('pk_test_jkxGYc4VblM9Jjv0gxhp8Nn600Nu2kHpKH');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
        base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
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
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
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

        document.getElementById('complete_order').disabled = true;

        var options = {

        Name: document.getElementById('name').value,
        Email: document.getElementById('email').value,
        Country: document.getElementById('country').value,
        Shipping_Address: document.getElementById('shippingAddress').value,
        State: document.getElementById('state').value,
        Phone: document.getElementById('email').value,
        Name_On_Card: document.getElementById('cardName').value
        };


        stripe.createToken(card, options).then(function(result) {
        if (result.error) {
        // Inform the user if there was an error.
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;

        document.getElementById('complete_order').disabled = false;

        } else {
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

    </script>

@endsection
{{--
</body>
</html>
 --}}
