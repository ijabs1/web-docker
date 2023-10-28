<?php
require_once "server_connection.php";

// Define variables and initialize with empty values
$name = $author = $preparation_time = $cook_time = $level = $serves = $no_of_ratings = $no_of_comments = $about_food = $sugars = $fibre = $protein = $salt = $method = $ingredient = $kcal = $fat =$saturates =$carbs = $nutrition_per_serving = "";
$name_err = $author_err = $preparation_time_err = $cook_time_err = $level_err = $serves_err = $no_of_ratings_err = $no_of_comments_err = $about_food_err = $method_err = $ingredient_err = $nutrition_per_serving_err = "";
	
if(isset($_POST["id"]) && !empty($_POST["id"])){

    // Get hidden input value
    $recipe_id = $_POST["id"];

     // Validate recipe name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter recipe name.";
    } else{
           $name = trim($_POST["name"]);
    }

     // Validate author
    if(empty(trim($_POST["author"]))){
        $author_err = "Please enter recipe author.";
    } else{
        $author = trim($_POST["author"]);
    }

     // Validate preparation time
    if(empty(trim($_POST["preparation_time"]))){
        $preparation_time_err = "Please enter recipe preparation_time.";
    }else{
        $preparation_time = trim($_POST["preparation_time"]);
    }

    // Validate Cook time
    if(empty(trim($_POST["cook_time"]))){
      $cook_time_err = "Please enter recipe cook_time.";
    } else{
        $cook_time = trim($_POST["cook_time"]);
    }

    // Validate level
    if(empty(trim($_POST["level"]))){
      $level_err = "Please choose a level.";
    }  else{
      $level = trim($_POST["level"]);
    }

    // Validate serves
    if(empty(trim($_POST["serves"]))){
      $serves_err = "Please enter a serves.";
    }  else{
      $serves = trim($_POST["serves"]);
    }

    // Validate ratings
    if(empty(trim($_POST["no_of_ratings"]))){
      $no_of_ratings_err = "Please enter a ratings.";
    }  else{
      $no_of_ratings = trim($_POST["no_of_ratings"]);
    }

    // Validate number of comments
    if(empty(trim($_POST["no_of_comments"]))){
      $no_of_comments_err = "Please enter number of comment.";
    }  else{
      $no_of_comments = trim($_POST["no_of_comments"]);
    }

   // Validate about_food
    if(empty(trim($_POST["about_food"]))){
      $about_food_err = "Please enter recipe info.";
    }  else{
      $about_food = trim($_POST["about_food"]);
    }

   
    
   

    // Validate nutrition
    if(empty(trim($_POST["kcal"])) || empty(trim($_POST["fat"]))|| empty(trim($_POST["saturates"])) || empty(trim($_POST["carbs"])) || empty(trim($_POST["sugars"]))|| empty(trim($_POST["fibre"]))|| empty(trim($_POST["protein"]))|| empty(trim($_POST["salt"]))){
      $nutrition_per_serving_err = "Please fill all Nutrition per serving fields";
    }  else{

      // create an array for nutrition oer sering
      $nutrition_per_serving_array = array(
            "kcal" => trim($_POST["kcal"]),
            "fat" => trim($_POST["fat"]),
            "saturates" => trim($_POST["saturates"]),
            "carbs" => trim($_POST["carbs"]),
            "sugars" => trim($_POST["sugars"]),
            "fibre" => trim($_POST["fibre"]),
            "protein" => trim($_POST["protein"]),
            "salt" => trim($_POST["salt"]),
      );

      // convert array to json
    $nutrition_per_serving = json_encode($nutrition_per_serving_array);
    }

    // Validate method
    if(empty(trim($_POST["method"]))){
      $method_err = "Please choose a method.";
    }  else{
      $method = trim($_POST["method"]);
    }

     // Validate ingredient
    if(empty(trim($_POST["ingredient"]))){
      $ingredient_err = "Please choose a ingredient.";
    }  else{
      $ingredient = trim($_POST["ingredient"]);
    }

     // Check input errors before inserting in database
    if(empty($name_err) && empty($author_err) && empty($preparation_time_err) && empty($cook_time_err) && empty($level_err) && empty($serves_err) && empty($no_of_ratings_err) && empty($no_of_comments_err) && empty($about_food_err) && empty($method_err) && empty($ingredient_err) && empty($nutrition_per_serving_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE recipes SET name=?, author=?, preparation_time=?, cook_time=?, level=?, serves=?, no_of_ratings=?, no_of_comments=?, about_food=?, method=?, ingredient=?, nutrition_per_serving=? WHERE id=?";

        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssssssss", $param_name, $param_author, $param_preparation_time, $param_cook_time, $param_level, $param_serves,  $param_no_of_ratings, $param_no_of_comments, $param_about_food, $param_method, $param_ingredient,  $param_nutrition_per_serving, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_author = $author;
            $param_preparation_time = $preparation_time;
            $param_cook_time = $cook_time;
            $param_level = $level;
            $param_serves = $serves;

            $param_no_of_ratings = $no_of_ratings;
            $param_no_of_comments = $no_of_comments;
            $param_about_food = $about_food;
            $param_method = $method;
            $param_ingredient = $ingredient;
            $param_nutrition_per_serving = $nutrition_per_serving;
            $param_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to welcome page
                $_SESSION['message'] = "New recipe added"; 
                header("location: recipeselection.php");
                //exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

     // Close connection
     $conn->close();
	   
	}else{
        // Check existence of id parameter before processing further
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get URL parameter
            $id =  trim($_GET["id"]);
            
            // Prepare a select statement
            $sql = "SELECT * FROM recipes WHERE id = ?";
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("i", $param_id);
                
                // Set parameters
                $param_id = $id;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    
                    if($result->num_rows == 1){
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        
                        // Retrieve individual field value
                        $name = $row["name"];
                        $author = $row["author"];
                        $preparation_time = $row["preparation_time"];
                        $cook_time = $row["cook_time"];
                        $level = $row["level"];
                        $serves = $row["serves"];

                        $no_of_ratings = $row["no_of_ratings"];
                        $no_of_comments = $row["no_of_comments"];

                        $about_food = $row["about_food"];
                        $method = $row["method"];
                        $ingredient = $row["ingredient"];

                        // Convert nutrition_per_serving column which is in Json to array and access each element  
                        $nutrition_per_serving = json_decode($row["nutrition_per_serving"], true);
                        $kcal = $nutrition_per_serving["kcal"];
                        $fat = $nutrition_per_serving["fat"];
                        $saturates = $nutrition_per_serving["saturates"];
                        $carbs = $nutrition_per_serving["carbs"];

                        $sugars = $nutrition_per_serving["sugars"];
                        $fibre = $nutrition_per_serving["fibre"];
                        $protein = $nutrition_per_serving["protein"];
                        $salt = $nutrition_per_serving["salt"];


                     
                    } else{
                        // URL doesn't contain valid id. Redirect to error page
                        //header("location: error.php");
                        exit();
                    }
                    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            $stmt->close();
            
            // Close connection
            $conn->close();
        }  
    }
?>
