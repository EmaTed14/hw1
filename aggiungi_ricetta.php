<?php

#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
# AGGIUNGE LE RICETTE INSERITE DALL'UTENTE NEL DATABSE 
#
#
#
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#

require_once "auth.php";

$userid = checkAuth();
if (!$userid) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]);

if (!$conn) {
    die("Errore di connessione: " . mysqli_connect_error());
}



if (isset($_POST["nome_ricetta"], $_POST["ingredienti"], $_POST["procedimento"], $_FILES["foto_ricetta"])) {
    $nome_ricetta = mysqli_real_escape_string($conn, $_POST["nome_ricetta"]);
    $ingredienti = mysqli_real_escape_string($conn, $_POST["ingredienti"]);
    $procedimento = mysqli_real_escape_string($conn, $_POST["procedimento"]);
    $image = $_FILES["foto_ricetta"]["name"];

    $allowed_types = ["image/jpeg", "image/jpg", "image/png"];

    if (in_array($_FILES["foto_ricetta"]["type"], $allowed_types)) {
        $ricetta_image_name = uniqid("ricetta_") . "." . pathinfo($_FILES["foto_ricetta"]["name"], PATHINFO_EXTENSION);
        $ricetta_image_path = "img_ricette/" . $ricetta_image_name;

        if (move_uploaded_file($_FILES["foto_ricetta"]["tmp_name"], $ricetta_image_path)) {
            $query = "INSERT INTO ricette (`user_id`, `nome_ricetta`, `foto_ricetta`, `ingredienti`, `procedimento`) VALUES ('$userid', '$nome_ricetta', '$ricetta_image_path', '$ingredienti', '$procedimento')";

            if (mysqli_query($conn, $query)) {
                header("Location: home.php");
                exit();
            } 
        }
    }
           
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aggiungi_ricetta.css">
    <link rel="stylesheet" href="navbar_general.css">

    <title>Add Recipe</title>

</head>

<body>
    <nav class="navbar">
        <a href="home.php" class="logo">Emi's CookBook</a>
        <a href="home.php">Home</a>
        <a href="ricette_inserite.php">Recipes submitted by users</a>
        <a href="ricette_preferite.php">Favorite recipes</a>
        <a href="aggiungi_ricetta.php">Add Recipe</a>


        <div class="dropdown">
            <a href="#">Area Personale</a>
            <div class="dropdown-content">
                
                <a href="logout.php">Logout</a>
            </div>

    </nav>

    <form action="aggiungi_ricetta.php" method="POST" enctype="multipart/form-data">
        <h1>Add Recipe</h1>
        

        <div class="nome_ricetta">
            <label for="nome_ricetta">Recipe Name:</label>
            <input type="text" name="nome_ricetta" id="nome_ricetta">
        </div>
        <div class="foto">
            <label for="foto_ricetta">Upload Recipe Photo:</label>
            <input type="file" name="foto_ricetta" accept=".jpg, .jpeg, .gif, .png" id="foto_ricetta">
        </div>
       
        <div class="ingredienti">
            <label for="ingredienti">Ingredients:</label>
            <textarea name="ingredienti" id="ingredienti" rows=""></textarea>
        </div>


        <div class="procedimento">
            <label for="procedimento">Ingredients:</label>
            <textarea name="procedimento" id="procedimento" rows=""></textarea>
        </div>

        <div class="submit">
            <input type="submit" value="Save" id="submit">
        </div>
    </form>
</body>

</html>
