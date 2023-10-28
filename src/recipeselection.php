<?php

/** Invoke the connection to the server */
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
            <h1><br> <center> RECIPE SELECTION FORM </center></h1>
        </header>
        <nav>
            <ul>
            <li><a href="./welcome.php">Dashboard</a></li>  <!--Goto Dashboard -->
                <li><a href="./newRecipe.php">New Recipe</a></li>  <!--Add New Recipe -->
                <li>
                    <a href="logout.php" class="btn btn-danger ml-3">Logout</a> <!--LOGOUT-->
                </li>
            </ul>
        </nav>
        <main>
            <h3>All Recipes</h3>
            <form method="POST" action = "recipeReport.php">   <!--Goto Recipe Report -->
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Recipe Info</th>
                        <th>Ingredients</th>
                       <!-- <th>nutrition per serving(gram)</th> -->
                        <th>Method</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                 
                <?php
                /* Calls data stored in the database to be displayed */
                $sql = "SELECT * FROM recipes";
                if($result = $conn->query($sql)){
                    if($result->num_rows > 0){
                        while($row = $result->fetch_array()){ ?>
                            <tr>
                            <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="id[]"></td>

                                <td><?php 
                                     echo "<b>Name: </b>".$row['name']."<br/>";
                                     echo "<b>Author: </b>".$row['author']."<br/>";
                                     echo "<b>Prep Time: </b>".$row['preparation_time']."<br/>";

                                     echo "<b>Cook Time: </b>".$row['cook_time']."<br/>";
                                     echo "<b>Level: </b>".$row['level']."<br/>";
                                     echo "<b>Serves: </b>".$row['serves']."<br/>";
                                     echo "<b>Ratings: </b>".$row['no_of_ratings']."<br/>";
                                 ?>
                                 </td>
                                 
                                <td><?php echo $row['ingredient']; ?></td>
                                
                                
                               <td><?php echo $row['method']; ?></td>
                               
                                <td>
                                    <a href="updateRecipe.php?id=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
                                </td>
                                <td>
                                    <a href="deleteRecipe.php?id=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
                                </td>
                               
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </table>

            <br>
	            <input type="submit" name="submit" value="Generate Report">
            </form>
                   
            <div>
		
		<?php
			if (isset($_POST['submit'])){
				foreach ($_POST['id'] as $id):
                    $sql = "SELECT * FROM recipes where id='$id'";
                    if($result = $conn->query($sql)){
                        $srow = $result->fetch_array();
                        echo $srow['name']. "<br>";
                    }
				endforeach;
			}
		?>
	</div>
        </main>
        <footer>&copy; CSYM019 2022</footer>
    </body>
</html>