<?php

require_once 'auth.php';
if (!$userid = checkAuth()) exit;

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$userid = mysqli_real_escape_string($conn, $userid);

$query = "SELECT * FROM preferiti WHERE user = '$userid'";

$result = mysqli_query($conn, $query);

$preferiti = array();

while ($row = mysqli_fetch_assoc($result)) {
    $preferiti[] = json_decode($row['content'], true);
}

mysqli_close($conn);

echo json_encode($preferiti);
?>


