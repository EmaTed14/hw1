// Richiedi lista eventi
function richiedi_ricette()
{
 fetch("fetch_ricette_inserite_dagli_utenti.php").then(onResponse).then(onJSON);   
}



function onJSON(json)
{
console.log(json);
const ricetteContainer = document.querySelector('.ricette_inserite');
    ricetteContainer.innerHTML = '';
console.log(json);
    for (const inserite of json )
    {
      const ricettaElement = document.createElement('div');
      ricettaElement.classList.add('ricetta');
  
      const nomeRicettaElement = document.createElement('h3');
      nomeRicettaElement.textContent = inserite.nome_ricetta;
  
      const fotoRicettaElement = document.createElement('img');
      fotoRicettaElement.src = inserite.foto_ricetta;
  
      const nomeUtenteElement = document.createElement('h4');
      nomeUtenteElement.textContent = 'Post by : ' + inserite.username;
  
      const ingredientiElement = document.createElement('ul');
      ingredientiElement.textContent = inserite.ingredienti;
  
      const procedimentoElement = document.createElement('p');
      procedimentoElement.textContent = inserite.procedimento;
  
      ricettaElement.appendChild(nomeUtenteElement);
      ricettaElement.appendChild(nomeRicettaElement);
      ricettaElement.appendChild(fotoRicettaElement);
      
      ricettaElement.appendChild(ingredientiElement);
      ricettaElement.appendChild(procedimentoElement);
  
      ricetteContainer.appendChild(ricettaElement);
    }

}



function onResponse(response) {
  return response.json();
}

richiedi_ricette();


