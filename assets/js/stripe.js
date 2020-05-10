var checker = document.getElementById('checkme');
    var btn = document.getElementById('card-button');
    checker.onchange = function () {
        btn.disabled = !this.checked;
    };

    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    var stripe = Stripe('pk_test_fBBqvVxTywtswCqeFRkhdm4700ul3wdLyN');
    var elements = stripe.elements();
    // Set up Stripe.js and Elements to use in checkout form
    var style = {
        base: {
            color: "#32325d",
        }
    };

    var card = elements.create("card", {
        style: style
    });
    card.mount("#card-element");

    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');



    form.addEventListener('submit', function (ev) {
        ev.preventDefault();

        var name = document.getElementById('card-name').value;
        stripe.confirmCardPayment(btn.dataset.secret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: name
                }
            }
        }).then(function (result) {
            var displayError = document.getElementById('card-errors');
            if (result.error) {
                // Show error to your customer (e.g., insufficient funds)
                displayError.textContent = result.error.message;
                console.log(result.error.message);
            } else {
            // The payment has been processed
            
            if (result.paymentIntent.status === 'succeeded') {
                console.log(result.paymentIntent.status)
                //document.getElementById('token').value = result.paymentIntent.id;
                //console.log(document.getElementById('token').value);
                // Show a success message to your customer
                // There's a risk of the customer closing the window before callback
                // execution. Set up a webhook or plugin to listen for the
                // payment_intent.succeeded event that handles any business critical
                // post-payment actions.
                form.submit();
            }
            }
        });
    });