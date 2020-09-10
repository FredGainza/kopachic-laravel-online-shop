<br>
@if($order->state->slug === 'cheque')

<script src="https://www.paypal.com/sdk/js?client-id=AdNaGDzrh-dwvQtxN_0L_XtmoPR7T1Vdt2wn2ersfqu_bbqzJpVF2t6BhMt6p7zN0eMiNXC2EFYCkZvK&currency=EUR"> // Replace YOUR_SB_CLIENT_ID with your sandbox client ID
</script>

<div id="paypal-button-container"></div>

<!-- Add the checkout buttons, set up the order and approve the order -->
<script>
  paypal.Buttons({
    createOrder: function() {
        return fetch('/api/create-paypal-transaction', {
            method: 'post',
            headers: {
            'content-type': 'application/json'
            }
        }).then(function(res) {
            return res.json();
        }).then(function(data) {
            return data.orderID; // Use the same key name for order ID on the client and server
        });
    },
    onApprove: function(data) {
        return fetch('/api/authorize-paypal-transaction', {
            method: 'post',
            headers: {
            'content-type': 'application/json'
            },
            body: JSON.stringify({
            orderID: data.orderID
            })
        }).then(function(res) {
            return res.json();
        }).then(function(details) {
            alert('Authorization created for ' + details.payer_given_name);
        });
    }
  }).render('#paypal-button-container'); // Display payment options on your web page
</script>
@endif