<?php
require_once 'auth.php';
if (!$userid = checkAuth()) exit;

preferiti();

function preferiti()
{
    global $dbconfig, $userid;
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    // Costruisco la query
    $userid = mysqli_real_escape_string($conn, $userid);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    // Verifico se la ricetta è già presente per l'utente
    $query = "SELECT * FROM preferiti WHERE user = '$userid' AND JSON_CONTAINS(content, '{\"id\": \"$id\"}')";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($res) > 0) {
        $query = "DELETE  FROM preferiti WHERE user = '$userid' AND JSON_CONTAINS(content, '{\"id\": \"$id\"}')";
    
    
    }
    else
    {
 // Altrimenti, inserisco la ricetta nella tabella
    $query = "INSERT INTO preferiti (user, content) VALUES ('$userid', JSON_OBJECT('id', '$id', 'titolo', '$titolo', 'image', '$image'))";

    }

   
    // Eseguo la query e verifico se è stata eseguita correttamente
    if (mysqli_query($conn, $query)) {
        echo json_encode(array('ok' => true));
        exit;
    }


    
    mysqli_close($conn);
    echo json_encode(array('ok' => false));
}
?>
