<?php
session_start();

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Esempio di utilizzo
if (isUserLoggedIn()) {
   // echo "L'utente è loggato.";
} else {
    //echo "L'utente non è loggato.";
    
}
?>
