// Selezioniamo il form
const form = document.querySelector('#cerca_ricetta');

// Aggiungiamo l'evento al form
form.addEventListener('submit', cerca);

function cerca(event) {
  // Impediamo il comportamento di default
  event.preventDefault();
  // Leggiamo il valore del campo di testo
  const contenuto = document.querySelector('#contenuto_ricerca').value;

  document.querySelector('#ricette_inserite').classList.add('hidden');


  fetch("ricerca.php?q=" + encodeURIComponent(contenuto)).then(onResponse).then(jsonFood);
}

function onResponse(response) {
  
  return response.json();
}

function jsonFood(json) {

 
  const contenitore = document.querySelector(".ricette");
  
  contenitore.innerHTML = '';

  const ricette = json.meals;

  for (const ricetta of ricette) {
    const card = document.createElement('div');
    card.classList.add('card');
    card.innerHTML = '';

    //prende il titolo della ricetta;
card.dataset.titolo=ricetta.strMeal;
//prende l'id della ricetta;
card.dataset.id=ricetta.idMeal;
//prende url dell'immagine 
card.dataset.imag=ricetta.strMealThumb;

const titolo = document.createElement('h2');
    titolo.textContent = ricetta.strMeal;
    titolo.classList.add('titles');

    const image = document.createElement('img');
    image.classList.add('images');
    image.src = ricetta.strMealThumb;

    const like = document.createElement('div');
    like.classList.add('like');
    const link = document.createElement('a');
    link.setAttribute('href', 'dettagli_ricetta.php?id='+card.dataset.id); 
    link.textContent = 'Mostra i dettagli';
    link.classList.add('link');

    card.appendChild(titolo);
    card.appendChild(image);
    card.appendChild(like);
    card.appendChild(link);
    
    contenitore.appendChild(card);
    like.addEventListener('click',saveRicetta);

   
  }
}


//funzione che salva la ricetta
function saveRicetta(event) {
    const like = event.currentTarget;
    like.classList.add('likerosso');
    
    if (like.classList.contains('likerosso')) {
      
      const card = like.parentNode;
      
      const formData = new FormData();
      formData.append('id', card.dataset.id);
      formData.append('titolo', card.dataset.titolo);
      formData.append('image', card.dataset.imag);
  
      fetch('salva_ricetta.php', {
        method: 'POST',
        body: formData
      })
        .then(onResponse)
        
        ;
    }
     
  
    event.stopPropagation();
  }
  
  window.onload = function() {
    caricaricette();
  };
  

  //funzionce che carica le ricette sulla homepage
  function caricaricette() {
    fetch('fetch_ultime_ricette_aggiunte.php')
      .then(onResponse)
      .then(onJsonLoad);
  }
  
  function onJsonLoad(json) {
    const ricetteContainer = document.querySelector('.ricette_inserite');
    ricetteContainer.innerHTML = '';

  
    for(const ricetta of json) {
      const ricettaElement = document.createElement('div');
      ricettaElement.classList.add('ricetta');

      //id ricetta e id user che ha scritto la ricetta
      ricettaElement.dataset.id=ricetta.id;
      ricettaElement.dataset.user_id=ricetta.user_id;
      
  
      const nomeRicettaElement = document.createElement('h3');
      nomeRicettaElement.textContent = ricetta.nome_ricetta;
  
      const fotoRicettaElement = document.createElement('img');
      fotoRicettaElement.src = ricetta.foto_ricetta;
  
      const nomeUtenteElement = document.createElement('h4');
      nomeUtenteElement.textContent ="Post by: "+ricetta.username;
  
      const ingredientiElement = document.createElement('p');
      ingredientiElement.textContent = ricetta.ingredienti;
  
      const procedimentoElement = document.createElement('p');
      procedimentoElement.textContent = ricetta.procedimento;
      const like = document.createElement('div');
   
      ricettaElement.appendChild(nomeUtenteElement);
      ricettaElement.appendChild(nomeRicettaElement);
      ricettaElement.appendChild(fotoRicettaElement);
      
      ricettaElement.appendChild(ingredientiElement);
      ricettaElement.appendChild(procedimentoElement);
      ricettaElement.appendChild(like);
        
      ricetteContainer.appendChild(ricettaElement);

      
    };
  }
  

  