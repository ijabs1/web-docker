<?php

/* Invoke the server connection */
require_once "server_connection.php";

// Define variables and initialize with empty values
$name = $author = $preparation_time = $cook_time = $level = $serves = $no_of_ratings = $no_of_comments = $about_food = $sugars = $fibre = $protein = $salt = $method = $ingredient = $kcal = $fat =$saturates =$carbs = $nutrition_per_serving = "";
$name_err = $author_err = $preparation_time_err = $cook_time_err = $level_err = $serves_err = $no_of_ratings_err = $no_of_comments_err = $about_food_err = $method_err = $ingredient_err = $nutrition_per_serving_err = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     // Validate recipe name: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter recipe name.";
    } else{

        // Prepare a select statement to recipes table
        $sql = "SELECT id FROM recipes WHERE name = ?";
          
        // Ensure recipe name is not duplicated
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_name);
            
            // Set parameter to store recipe name
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){

                /* store result */
                $stmt->store_result();
                
                //Check if recipe name already exist in recipes table before storing it to prevent duplicate name
                if($stmt->num_rows == 1){
                    $name_err = "Recipe name already exists.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again!.";
            }

            // Close statement
            $stmt->close();
        }
    }

     // Validate author
    if(empty(trim($_POST["author"]))){
        $author_err = "Please enter recipe author.";
    } else{
        $author = trim($_POST["author"]);
    }

     // Validate preparation time: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["preparation_time"]))){
        $preparation_time_err = "Please enter recipe preparation_time.";
    }else{
        $preparation_time = trim($_POST["preparation_time"]);
    }

    // Validate Cook time: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["cook_time"]))){
      $cook_time_err = "Please enter recipe cook_time.";
    } else{
        $cook_time = trim($_POST["cook_time"]);
    }

    // Validate level : Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["level"]))){
      $level_err = "Please choose a level.";
    }  else{
      $level = trim($_POST["level"]);
    }

    // Validate serves : Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["serves"]))){
      $serves_err = "Please enter a serves.";
    }  else{
      $serves = trim($_POST["serves"]);
    }

    // Validate ratings : Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["no_of_ratings"]))){
      $no_of_ratings_err = "Please enter a ratings.";
    }  else{
      $no_of_ratings = trim($_POST["no_of_ratings"]);
    }

    // Validate number of comments: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["no_of_comments"]))){
      $no_of_comments_err = "Please enter number of comment.";
    }  else{
      $no_of_comments = trim($_POST["no_of_comments"]);
    }

   // Validate about_food: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["about_food"]))){
      $about_food_err = "Please enter recipe info.";
    }  else{
      $about_food = trim($_POST["about_food"]);
    }

   
    // Validate nutrition: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["kcal"])) || empty(trim($_POST["fat"]))|| empty(trim($_POST["saturates"])) || empty(trim($_POST["carbs"])) || empty(trim($_POST["sugars"]))|| empty(trim($_POST["fibre"]))|| empty(trim($_POST["protein"]))|| empty(trim($_POST["salt"]))){
      $nutrition_per_serving_err = "Please fill all Nutrition per serving fields";
    }  else{

      // create an array for nutrition per sering using the below input fields
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

    // Validate method: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["method"]))){
      $method_err = "Please choose a method.";
    }  else{
      $method = trim($_POST["method"]);
    }

     // Validate ingredient: Ensure the name is not empty and remove empty spaces before and after the entered value
    if(empty(trim($_POST["ingredient"]))){
      $ingredient_err = "Please choose a ingredient.";
    }  else{
      $ingredient = trim($_POST["ingredient"]);
    }

     // Check to ensure that there is no input errors before inserting into recipes table
    if(empty($name_err) && empty($author_err) && empty($preparation_time_err) && empty($cook_time_err) && empty($level_err) && empty($serves_err) && empty($no_of_ratings_err) && empty($no_of_comments_err) && empty($about_food_err) && empty($method_err) && empty($ingredient_err) && empty($nutrition_per_serving_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO recipes (name, author, preparation_time, cook_time, level, serves, no_of_ratings, no_of_comments, about_food, method, ingredient, nutrition_per_serving) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)";
        
        //Ensure connection is successfull
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssssss", $param_name, $param_author, $param_preparation_time, $param_cook_time, $param_level, $param_serves,  $param_no_of_ratings, $param_no_of_comments, $param_about_food, $param_method, $param_ingredient,  $param_nutrition_per_serving);
            
            // Set parameters to store input fields from the form
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
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
               
                $_SESSION['message'] = "New recipe added"; //stored success message in a session variable "message"
                header("location: recipeselection.php");  // Redirect to recipeselection page
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

     // Close connection
     $conn->close();
	   
	}
?>