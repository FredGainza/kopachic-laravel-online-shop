@if($order->state->slug === 'carte' || $order->state->slug === 'erreur')
<script src="https://js.stripe.com/v3/"></script>
<script>

    const stripe = Stripe('{{ config('stripe.publishable_key') }}');
    console.log(stripe);
    // <?php 
    // dd(config('stripe.publishable_key'));
    // ?>
    
    const style = {
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
    const elements = stripe.elements();
    const card = elements.create("card", { style: style });
    card.mount("#card-element");
    const displayError = document.getElementById('card-errors');

    card.addEventListener('change', ({error}) => {
      displayError.textContent = error ? error.message : '';
    });

    document.getElementById('payment-form').addEventListener('submit', ev => {
      ev.preventDefault();
      displayError.textContent = '';
      document.getElementById('submit').classList.add('hide');
      document.getElementById('wait').classList.remove('hide');
      console.log('{{ session($order->reference) }}');
      stripe.confirmCardPayment('{{ session($order->reference) }}', {
        payment_method: { card: card }
      }).then(result => {
        document.getElementById('wait').classList.add('hide');
        if (result.error) {
          document.getElementById('submit').classList.remove('hide');              
          displayError.textContent = result.error.message;
          console.log(displayError.textContent);
        } else {
          if (result.paymentIntent.status === 'succeeded') {
            document.getElementById('payment-pending').classList.add('hide');
            document.getElementById('payment-ok').classList.remove('hide');
          }
        }
        let info = result.error ? 'error' : result.paymentIntent.id;
        fetch('{{ route('commandes.payment', $order->id) }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ payment_intent_id: info })
        });
      });
    });

</script>
@endif