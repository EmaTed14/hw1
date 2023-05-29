<?php
//Dobbiamo verificare che nel database non ci siano due username uguali

//importiamo il  file contenente la cinfigurazione del database
require_once 'dbconfig.php';

//specifichiamo che il client voglia  ritornato un json
header('Content-Type: application/json');

//connessione al database
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

//leggiamo il campo 'q' dell'array GET che ci è stato passato dal client, in questo modo leggiamo il l'userneme che ci è stato passato 
$email=$_GET['q'];
//evitiamo l'injection
$username=mysqli_real_escape_string($conn, $_GET['q']);

//Query da fare al database
$query="SELECT email FROM utenti WHERE email='$email'";

//conserviamo i risultati trovati dentro una varibile 
$res=mysqli_query($conn,$query);

//creaimo l'array che dobbiamo convertire in json
//mysqli_num_rows restituisce il numero di elementi restituiti dalla query
//se gli elementi sono maggiori di zero restituisce true
$json_array=array('exists'=>mysqli_num_rows($res)>0 ?true : false );

//salviamo in un avaribile la risposta
//la variabile $json conterrà una stringa che rappresenta l'array $json_array
//la funzione json_encode converte in automatico i tipi di dati php in equvalenti json 
$json=json_encode($json_array);
echo $json;

mysqli_close($conn);


?>