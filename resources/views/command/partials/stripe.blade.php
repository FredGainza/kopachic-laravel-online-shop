
<div id="payment-pending" class="card">
  <div class="card-content center-align">
    <br>
    <span class="card-title">Vous avez choisi de payer par carte bancaire. Veuillez compléter le présent formulaire pour procéder à ce règlement</span>
    <p class="orange-text">Nous ne conservons aucune de ces informations sur notre site, elles sont directement transmises à notre prestataire de paiement <a href="https://stripe.com/fr">Stripe</a>.</p>
    <p class="orange-text">La transmission de ces informations est entièrement sécurisée.</p>
    <br>
    <div class="row">
      <form id="payment-form">        
        <div class="card blue-grey darken-1">
          <div class="card-content white-text">
            <div id="card-element"></div>
          </div>
        </div>
        <div id="card-errors" class="helper-text red-text"></div>
        <br>
        <div id="wait" class="hide">
          <div class="loader"></div>
          <br>
          <p><span class="red-text card-title center-align">Processus de paiement en cours, ne fermez pas cette fenêtre avant la fin du traitement !</span></p>
        </div>
        <button style="float: right;" class="btn waves-effect waves-light" id='submit' type="submit" name="action">Payer
          <i class="material-icons right">payment</i>
        </button>
      </form>
    </div>
  </div>
</div>