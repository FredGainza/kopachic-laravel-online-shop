<script>
    const toggleProfessionnal = () => {
      if(document.querySelector('#professionnal').checked) {
          document.querySelector('#company').parentNode.parentNode.classList.remove('hide');
          document.querySelector('label[for="name"]').firstChild.textContent = "Nom (optionnel)";
          document.querySelector('label[for="firstname"]').firstChild.textContent = "Prénom (optionnel)";
        } else {
          document.querySelector('#company').parentNode.parentNode.classList.add('hide');
          document.querySelector('label[for="name"]').firstChild.textContent = "Nom";
          document.querySelector('label[for="firstname"]').firstChild.textContent = "Prénom";
        }     
    }
    document.addEventListener('DOMContentLoaded', () => {
      toggleProfessionnal();    
      document.querySelector('#professionnal').addEventListener('click', () => toggleProfessionnal());
    });
</script>