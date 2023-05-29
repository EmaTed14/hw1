<?php

#PRENDE I DETTAGLI DELLE RICETTE CERCATE TRAMITE API

require_once 'checkuserloggato.php';

if (!isUserLoggedin()) {
    exit;
}


$ricetta=ricerca()['meals'][0];

function ricerca()
{
    // Verifichiamo se è stato passato il parametro 's'
    if (isset($_GET['id'])) {
        $ricerca_query = $_GET['id'];

        // Creiamo due variabili, una con l'API key e una con l'URL
        $apiKey = '1';
        $url = 'https://www.themealdb.com/api/json/v1/' . $apiKey . '/lookup.php?i=' . urlencode($ricerca_query);

        // Effettuiamo la richiesta GET all'API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decodifichiamo la risposta JSON
        $json = json_decode($response, true);

       return($json);
}
}

?>






<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="dettagli_ricetta.js" defer="true"></script>
    <link rel="stylesheet" href="dettagli.css">
    <title></title>
</head>
<body>
    <h1> <?php echo $ricetta['strMeal']; ?></h1>
    <ul> 
       
    <?php  for($i=1; $i<=20; ++$i){
       
       if(isset($ricetta['strIngredient'.$i]) && strlen($ricetta['strIngredient'.$i]>0) )
       {
       ?>             

        <li> <?php echo $ricetta['strIngredient'.$i]." ".$ricetta['strMeasure'.$i]; ?> </li>  
       
       
    <?php } }?>

       
       

    </ul>

    <p> <?php echo $ricetta['strInstructions']; ?> </p>

    
</body>
</html>
