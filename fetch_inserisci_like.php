<?php
require_once 'dbconfig.php';

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$postId = $_POST['id'];
$userId = $_POST['user_id'];

$response = array();

// Inserisci il like nella tabella like_post
$sql = "INSERT INTO like_post (post_id, user_id, stato) VALUES ('$postId', '$userId', 'like')";
if (mysqli_query($conn, $sql)) {
    // Calcola il conteggio dei like aggiornato per il post
    $countSql = "SELECT COUNT(*) AS like_count FROM like_post WHERE post_id = '$postId'";
    $result = mysqli_query($conn, $countSql);
    $row = mysqli_fetch_assoc($result);
    $likeCount = $row['like_count'];

    // Aggiungi il conteggio dei like alla risposta
    $response['success'] = true;
    $response['numero_like'] = $likeCount;
} else {
    $response['success'] = false;
    $response['message'] = 'Errore durante l\'inserimento del like';
}

echo json_encode($response);

mysqli_close($conn);
?>
