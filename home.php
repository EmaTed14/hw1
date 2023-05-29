<?php


require_once 'auth.php';
if(!$userid=checkAuth())
{
    header("Location:login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="cerca_ricetta.css">
    <script src="home.js" defer="true"></script>

    <title>Emi's CookBook</title>
</head>
<body>

        

        <nav class="navbar">
            <a href="home.php" class="logo">Emi's CookBook</a>
             <form id="cerca_ricetta">
                <div class="cerca">
                <input type="text" placeholder="Search..." id="contenuto_ricerca">
        <button type="submit">Search</button>
                </div>

            </div>
           

            </form>

            <a href="ricette_inserite.php">Recipes submitted by users</a>
            <a href="ricette_preferite.php">Favorite recipes</a>
            <a href="aggiungi_ricetta.php">Add Recipe</a>


            <div class="dropdown">
        <a href="#">Area Personale</a>
        <div class="dropdown-content">
          
          <a href="logout.php">Logout</a>
        </div>
            
        </nav>

    <header>
    <div id="overlay"></div>
       <div class="benvenuto">
      <h1>Welcome to Emi's cookbook</h1>
      <p>"Discover the best recipes, watch video tutorials, and save your favorite recipes!"</p>
    </div>
</header>
       







<section class="ricette">
            

        </section>

        <section class= "ricette_inserite" id="ricette_inserite">
             </section>

             <footer> © 2023 Emanuela Tedesco. All rights reserved. </footer>
</body>
</html>