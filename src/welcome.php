<?php

require_once "server_connection.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Recipe Report</title>
        <link rel="stylesheet" href="layout.css">
    </head>
    <body>
        <header>
            <h3>CSYM019 - BBC GOOD FOOD RECIPES</h3>
        </header>
        <nav>
            <ul>
                <li><a href="./welcome.php">Dashboard</a></li>
                <li><a href="./newRecipe.php">New Recipe</a></li>
                <li><a href="./recipeselection.php"> Recipe Selection</a></li>
                <li><a href="logout.php" class="btn btn-danger ml-3">Logout</a></li>
            </ul>
        </nav>
        <main>
            
            <h3>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> </h3>
            <div class="sketch">
                <img src="BBCGOODFOOD.jpg" alt="Sample Recipe Report">
            </div>
            
            <form action="./newRecipe.php" class="addmore">
                <input type="submit" value="Create New Recipe" />
                            
            </form>
        </main>
        <footer>&copy; CSYM019 2022</footer>
    </body>
</html>