<?php
require_once "server_connection.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//ensure that the submit button from the recipe page was clicked
if (isset($_POST['submit'])){
    
    //loop through all the selected recipe id 
    foreach ($_POST['id'] as $id):
        // select all recipes whose id are in the loop from recipe table
        $sql = "SELECT * FROM recipes where id='$id'";

        //check if the connection to the recipe table is true
        if($result = $conn->query($sql)){

            /** initialized two arrays: "data" to store nutrition values
             * and "label" to store nutrition names  
            */
            $data = $label = array();

            // store query result as array
            $row = $result->fetch_array();

            /** select the "nutrition_per_serving" column that was stored 
             * as JSON and convert it to array
            */
            $nutrition = json_decode($row["nutrition_per_serving"], true);

            /** loop through nutrition and store both the name and 
             * values except for nutrition named "kcal" 
            */
           foreach($nutrition as $key=>$value):
          
            if($key !== "kcal"){
                $data[] = $value;
                $label[] = $key;
            }
        
           endforeach;
        }
        $result->close(); //close statement      
        
    endforeach;
    
    
    $conn->close();//close connection
 
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Recipe Report</title>
    <link rel="stylesheet" href="layout.css">
    <!-- jquery to enable chartjs work properly -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Chartjs library -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    
    

<body>
    <header>
        <h3>CSYM019 - BBC GOOD FOOD RECIPES</h3>
        <h1> <center> SELECTED RECIPE REPORT </center> </h1>
    </header>
    <nav>
        <ul>
            <li><a href="./welcome.php">Dashboard</a></li>
            <li><a href="./recipeSelection.php">Select Recipe</a></li>
            <li><a href="./newRecipe.php">New Recipe</a></li>
            <li>


                <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <table>
        <thead>
                    <tr>
                        <th>Recipe Info</th>
                        <th>Ingredients</th>
                        <th>Method</th>
                    </tr>
                </thead>
             

            <tr>
                <td class = "report_table" ><?php 
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
            
            </tr>
            
               <h1> <?php echo $row['name']; ?> </h1>
        </table>

    <div class="chart-container" style="position: relative; width:40vw">
        <canvas id="my_Chart"></canvas>
        </div>
    
      
        
       
    </main>


    <script>
    var nutrition_name = <?php  echo json_encode($label); ?>; // Get Labels from php variable
    var nutrition_value = <?php  echo json_encode($data); ?>; // Get Data from php variable
    // Chart data with page load

    myData = {
        labels: nutrition_name,
        datasets: [{
            label: "Chart.JS",
            fill: false,
            backgroundColor: ['#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#b9b7bd', '#ffff00', '#bfff00', '#80ff00'],
            borderColor: 'black',
            data: nutrition_value,
        }]
    };
    // Draw default chart with page load
    var ctx = document.getElementById('my_Chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',    // Define chart type
        data: myData    // Chart data
    });
</script>

</body>

</html>

