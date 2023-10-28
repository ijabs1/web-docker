<?php
require_once 'deleteRecipe_validation.php';

 
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

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>

<body>
    <header>
        <h3>CSYM019 - BBC GOOD FOOD RECIPES</h3>
        
    </header>
    <nav>
        <ul>
        <li><a href="./welcome.php">Dashboard</a></li>
            <li><a href="./recipeSelectionForm.html">Recipe Report</a></li>
            <li><a href="./newRecipe.php">New Recipe</a></li>
            <li>
                <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <h3>Delete Recipe</h3>
                          <!-- Performs the delete function-->

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this Recipe record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="welcome.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
    </main>
    <footer>&copy; CSYM019 2022</footer>
</body>

</html>