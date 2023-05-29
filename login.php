<?php
include 'auth.php';
if (checkAuth()) {
    header('Location: home.php');
    exit;
}

// Check for the existence of posted data
if (!empty($_POST["username"]) && !empty($_POST['password'])) {

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to verify the credentials
    $query = "SELECT * FROM utenti WHERE username='" . $username . "'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Verify the correctness of the credentials
    if (mysqli_num_rows($res) > 0) {

        $entry = mysqli_fetch_assoc($res);
        if (password_verify($_POST['password'], $entry['password'])) {
            $_SESSION["user_username"] = $entry['username'];
            $_SESSION["user_id"] = $entry['id'];

            header("Location: home.php");

            mysqli_close($conn);
            exit;
        }
    }
    //Se l'utente non è stato trovato o la password non ha passato la verifica 
    $error = "Incorrect username and/or password.";
} else if (isset($_POST["username"]) || isset($_POST["password"])) {
    // Se solo uno dei due è impostato 
    $error = "Enter your username and password.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='register_login.css'>
    <script src="login.js" defer="true"></script>

    <title>Log in</title>
</head>
<body>
    


    <form action="" method="POST" name="login">
    <h1>Log in now!</h1>
        <div class="username">
            <label for="username">Username:</label>
            <input type="text" name="username">
            <p class="error"></p>
        </div>

        <div class="password">
            <label for="password">Password:</label>
            <input type="password" name="password">
        </div>
        <?php
    //verifico la presenza di errori
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
?>
        <div class="submit">
            <input type="submit" value="Log In">
        </div>

        <a href="registrazione.php">Are you not registered yet? Sign up now!</a>
    </form>
</body>
</html>
