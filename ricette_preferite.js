function richiedi_ricette_preferite() {
    fetch('fetch_ricette_preferite.php')
      .then(onResponse)
      .then(onJSON);
  }
  
  function onJSON(json) {
    console.log(json);
    const ricetteContainer = document.querySelector('.ricette_preferite');
    ricetteContainer.innerHTML = '';
  
    for (const ricetta of json) {
      console.log(ricetta);
  
      const ricettaElement = document.createElement('div');
      ricettaElement.classList.add('ricetta');
  
      const nomeRicettaElement = document.createElement('h3');
      nomeRicettaElement.textContent = ricetta.titolo;
      console.log(nomeRicettaElement);
  
      const fotoRicettaElement = document.createElement('img');
      fotoRicettaElement.src = ricetta.image;

      const link = document.createElement('a');
      link.setAttribute('href', 'dettagli_ricetta.php?id='+ricetta.id); 
      link.textContent = 'Mostra i dettagli';
  
  
    
      ricettaElement.appendChild(nomeRicettaElement);
      ricettaElement.appendChild(fotoRicettaElement);
      ricettaElement.appendChild(link);
  
     
  
      ricetteContainer.appendChild(ricettaElement);
    }
  }
  
  function onResponse(response) {
    return response.json();
  }
  
  richiedi_ricette_preferite();
  