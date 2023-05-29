<?php
//avvia la sessione 
session_start();
//elimina la sessione
session_destroy();
//vai alla pagina login
header('Location: index.php');

exit;


?>