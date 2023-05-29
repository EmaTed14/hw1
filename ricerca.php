<?php

#CERCE LE RICETTE SULL'API MEALDB

require_once 'checkuserloggato.php';

if (!isUserLoggedin()) {
    exit;
}

header('Content-Type: application/json');

ricerca();

function ricerca()
{
    // Verifichiamo se è stato passato il parametro 's'
    if (isset($_GET['q'])) {
        $ricerca_query = $_GET['q'];

        // Creiamo due variabili, una con l'API key e una con l'URL
        $apiKey = '1';
        $url = 'https://www.themealdb.com/api/json/v1/' . $apiKey . '/search.php?s=' . urlencode($ricerca_query);

        // Effettuiamo la richiesta GET all'API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decodifichiamo la risposta JSON
        $json = json_decode($response, true);

        echo json_encode($json);
}
}

?>

