<?php

#REGISTRAIZIONE DELL'UTENTE


require_once "dbconfig.php";

// Verifica l'esistenza dei dati post
if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['data']) && isset($_POST['sesso']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data = $_POST['data'];
    $sesso = $_POST['sesso'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    // Password criptata
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
    // Effettua la validazione dei campi
    $errori = array();

    // Connessione al database
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
   
    // Validazione per il campo username
    if(!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errori[] = "Username can only contain numbers, letters, and underscores (_)";;
    } else {
        // Verifica dell'unicità dell'username nel database
        $query_username = "SELECT username FROM utenti WHERE username='$username'";
        $res = mysqli_query($conn, $query_username);
        if(mysqli_num_rows($res) > 0) {
            $errori[] = "Username already used";
        }
    }

    // Validazione password
    if(strlen($password) < 8) {
        $errori[] = "Password must be at least 8 characters long";
    }

    // Conferma password
    if(strcmp($password, $_POST["conferma_password"]) != 0) {
        $errori[] = "Passwords do not match";
    }

    // Controllo email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errori[] = "Invalid email address";
    } else {
        $query_email = "SELECT email FROM utenti WHERE email='$email'";
        $res = mysqli_query($conn, $query_email);
        if(mysqli_num_rows($res) > 0) {
            $errori[] = "Email already used";
        }
    }
   
    // Caricamento immagine del profilo
    // Controllo se l'immagine è stata caricata
    if(isset($_FILES['foto_profilo']) && $_FILES['foto_profilo']['error'] === UPLOAD_ERR_OK) {
        $foto_profilo = $_FILES['foto_profilo'];

        // Verifico il tipo di file
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $file_type = $foto_profilo['type'];

        if(!in_array($file_type, $allowed_types)) {
            $errori[] = "Invalid image format. Only JPEG, JPG, and PNG files are allowed.";
        } else {
            // Cartella dove salvare il file
            $image_folder = 'img_profile/';

            // Genero un nome univoco per l'immagine del profilo
            $profile_image_name = uniqid('profile_') . '.' . pathinfo($foto_profilo['name'], PATHINFO_EXTENSION);

            // Percorso completo per l'immagine del profilo
            $profile_image_path = $image_folder . $profile_image_name;

            // Sposto l'immagine nel percorso di destinazione
            if(move_uploaded_file($foto_profilo['tmp_name'], $profile_image_path)) {
                
            } else {
                $errori[] = "Error uploading profile image";
            }
        }
    } else {
        $errori[] = "Error uploading file";
    }

    // Inserimento nel database
    if(count($errori) == 0) {
        $query = "INSERT INTO utenti (nome, cognome, data_nascita, sesso, foto_profilo, username, email, password) VALUES ('$nome', '$cognome', '$data', '$sesso', '$profile_image_path', '$username', '$email', '$hashedPassword')";
        $res = mysqli_query($conn, $query);
        mysqli_close($conn);

        if($res) {
            // Imposta le variabili di sessione
            session_start();
            $_SESSION["username"] = $username;

            // Vai alla pagina home
            header("Location: home.php");
            exit;
        } else {
            $errori[] = "Error inserting into the database";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='register_login.css'>
    <script src="registrazione.js" defer="true"></script>
    <title>Signup</title>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data" id="form">
    <h1>Sign up now!</h1>
    <div class="nome">
        <label for="nome">First Name:</label>
        <input type="text" name="nome">
        <p></p>
    </div>

    <div class="cognome">
        <label for="cognome">Last Name:</label>
        <input type="text" name="cognome">
        <p></p>
    </div>

    <div class="data">
        <label for="data">Date of Birth:</label>
        <input type="date" name="data">
    </div>

    <div class="sesso">
        <label>Gender:</label>
        <input type="radio" name="sesso" value="maschio" checked>Male
        <input type="radio" name="sesso" value="femmina">Female
        <input type="radio" name="sesso" value="non-binary">Non-binary
    </div>

    <div class="foto_profilo">
        <label for="foto_profilo">Profile Picture:</label>
        <input type="file" name="foto_profilo" accept=".jpg, .jpeg, .png">
    </div>

    <div class="username">
        <label for="username">Username:</label>
        <input type="text" name="username">
        <p class="error"></p>
    </div>

    <div class="email">
        <label for="email">Email:</label>
        <input type="text" name="email">
    </div>

    <div class="password">
        <label for="password">Password:</label>
        <input type="password" name="password">
    </div>

    <div class="conferma_password">
        <label for="conferma_password">Confirm Password:</label>
        <input type="password" name="conferma_password">
    </div>
   
    <div class="submit">
        <input type="submit" value="Sign Up">
    </div>

    <a href="login.php">Already registered? Log in</a>
</form>
</body>
</html>