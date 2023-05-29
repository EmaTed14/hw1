<?php

#AGGIUNGE LE R


require_once 'auth.php';
if (!$userid = checkAuth()) exit;

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$userid = mysqli_real_escape_string($conn, $userid);


$query = "SELECT ricette.id, ricette.user_id, ricette.nome_ricetta, ricette.foto_ricetta, ricette.ingredienti, ricette.procedimento, utenti.nome AS nome_utente, utenti.username
          FROM ricette
          JOIN utenti ON ricette.user_id = utenti.id ORDER BY ricette.id DESC LIMIT 10";

$result = mysqli_query($conn, $query);

$ricette = array();

while ($row = mysqli_fetch_assoc($result)) {
    $ricetta = array(
        'id' => $row['id'],
        'user_id' => $row['user_id'],
        'nome_ricetta' => $row['nome_ricetta'],
        'foto_ricetta' => $row['foto_ricetta'],
        'ingredienti' => $row['ingredienti'],
        'procedimento' => $row['procedimento'],
        'nome_utente' => $row['nome_utente'],
        'username' => $row['username'],
    );

    $ricette[] = $ricetta;
}

mysqli_close($conn);

echo json_encode($ricette);
?>
