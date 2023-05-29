<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="ricette_preferite.js" defer="true"></script>
    <link rel="stylesheet" href="ricette_preferite.css">
    <link rel="stylesheet" href="navbar_general.css">
    <title>Document</title>
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

    <h1>Favourite Recipe</h1>
    <section class="ricette_preferite"></section>
    
</body>
</html>