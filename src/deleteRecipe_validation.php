<?php
require_once "server_connection.php";


if(isset($_POST["id"]) && !empty($_POST["id"])){

    // Get hidden input value
   $id = $_POST["id"];

   // Prepare a delete statement
   $sql = "DELETE FROM recipes WHERE id = ?";
    
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Recipe Records deleted successfully. Redirect to Recipe Selection page
            header("location: recipeselection.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }    
    
    // Close statement
    $stmt->close();
    
    // Close connection
    $conn->close();
} 
?>