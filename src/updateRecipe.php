<?php
require_once 'updaterecipe_validation.php';
 
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
    <!-- jquery-->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
   

    <!-- CK Editor online standard package-->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <!-- Initialized CK Editor for ingredient and method-->
    <script>
        $(function() {
            CKEDITOR.replace('ingredient')
        })

        $(function() {
            CKEDITOR.replace('method')
        })
    </script>
    
</head>

<body>
    <header>
        <h3>CSYM019 - BBC GOOD FOOD RECIPES</h3>
        <h1 class="">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
    </header>
    <nav>
        <ul>
        <li><a href="./welcome.php">Dashboard</a></li>
            <li><a href="./recipeselection.php">Recipe Report</a></li>
            <li><a href="./newRecipe.php">New Recipe</a></li>
            <li>
                <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <h3> New Recipe Entry Form</h3>

        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
        
            <div class="m-4">
                     
                <!-- BASIC RECIPE INFO -->
                <div class="row">
                    <div class="col-4">
                        <!--  
                            Recipe name form input field
                        -->
                        <div class="form-group">
                            <label for="food_name">Recipe Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" required>
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <!--  
                            Recipe Author form input field
                        -->

                        <div class="form-group">
                            <label for="author">Author</label>
                            <input class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" type="text" id="author" placeholder="" value="<?php echo $author; ?>"  name="author" required>
                            <span class="invalid-feedback"><?php echo $author_err; ?></span>
                        </div>
                        <!--  
                            Recipe Preparation time form input field
                        -->

                        <div class="form-group">
                            <label for="preparation time">Preparation Time</label>
                            <input type="text" class="form-control <?php echo (!empty($preparation_time_err)) ? 'is-invalid' : ''; ?>" placeholder="" name="preparation_time" value="<?php echo $preparation_time; ?>" required>
                            <span class="invalid-feedback"><?php echo $preparation_time_err; ?></span>
                            
                        </div>
                        <!--  
                            Recipe Cook time form input field
                        -->

                        <div class="form-group">
                            <label for="cook_time">Cook Time</label>
                            <input type="text" class="form-control <?php echo (!empty($cook_time_err)) ? 'is-invalid' : ''; ?>" placeholder="" name="cook_time" value="<?php echo $cook_time; ?>" required>
                            <span class="invalid-feedback"><?php echo $cook_time_err; ?></span>
                        </div>

                    </div>

                    <div class="col-4">

                    <!--  
                            Recipe Level, can only accept Easy or More Effort
                        -->

                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="form-select form-control <?php echo (!empty($level_err)) ? 'is-invalid' : ''; ?>" placeholder="Level" name="level" required>
                                <option value="" selected disabled>Choose</option>
                                <option value="Easy">Easy</option>
                                <option value="More Effort">More Effort</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $level_err; ?></span>
                        </div>
                                 <!--  
                            Recipe Serves form input field, determine the number of people the food can serve
                        -->

                        <div class="form-group">
                            <label for="serves">Serves</label>
                            <input type="text" class="form-control <?php echo (!empty($serves_err)) ? 'is-invalid' : ''; ?>" id="serves" placeholder="" name="serves" value="<?php echo $serves; ?>" required>
                            <span class="invalid-feedback"><?php echo $serves_err; ?></span>
                        </div>
                        <!--  
                            Recipe ratings form input field
                        -->

                        <div class="form-group">
                            <label for="ratings">Rating</label>
                            <input type="text" class="form-control <?php echo (!empty($no_of_ratings_err)) ? 'is-invalid' : ''; ?>" id="no_of_ratings" placeholder="" name="no_of_ratings" value="<?php echo $no_of_ratings; ?>" required>
                            <span class="invalid-feedback"><?php echo $no_of_ratings_err; ?></span>
                        </div>
                        

                        <div class="form-group">
                            <label for="comments">No of comments</label>
                            <input type="text" class="form-control <?php echo (!empty($no_of_comments_err)) ? 'is-invalid' : ''; ?>" id="no_of_comments" placeholder="" name="no_of_comments" value="<?php echo $no_of_comments; ?>" required>
                            <span class="invalid-feedback"><?php echo $no_of_comments_err; ?></span>
                        </div>
 
                    </div>
                      <!--  
                            About Recipe form input field
                        -->

                    <div class="col-4">
                        <div class="form-group">
                            <label for="about_food">About food</label>
                            <textarea id="about_food" class="form-control <?php echo (!empty($about_food_err)) ? 'is-invalid' : ''; ?>" placeholder="" name="about_food" rows="5" value="<?php echo $about_food; ?>" required> 
                                 <?php echo $about_food; ?>
                            </textarea>
                            <span class="invalid-feedback"><?php echo $about_food_err; ?></span>

                        </div>

                        <div>

                    </div>

                </div>
                <hr>
                <p>Nutrition per serving</p>
                <hr>

                <!-- NUTRITION PER SERVING FOR RECIPE -->
                <div class="row col-md-12">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kcal">kcal</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="kcal" placeholder="" name="kcal" value="<?php echo $kcal; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="fat">fat</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="fat" placeholder="" name="fat" value="<?php echo $fat; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="saturates">saturates</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="saturates" placeholder="" name="saturates" value="<?php echo $saturates; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="carbs">carbs</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="carbs" placeholder="" name="carbs" value="<?php echo $carbs; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="sugars">sugars</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="sugars" placeholder="" name="sugars" value="<?php echo $sugars; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="fibre">fibre</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="fibre" placeholder="" name="fibre" value="<?php echo $fibre; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="protein">protein</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="protein" placeholder="" name="protein" value="<?php echo $protein; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="salt">salt</label>
                            <input type="number" step="0.01" class="form-control <?php echo (!empty($nutrition_per_serving_err)) ? 'is-invalid' : ''; ?>" id="salt" placeholder="" name="salt" value="<?php echo $salt; ?>" required>
                            <span class="invalid-feedback"><?php echo $nutrition_per_serving_err; ?></span>
                        </div>
                    </div>

                </div>
                <!-- END -- NUTRITION PER SERVING FOR RECIPE -->
                <hr>

                <!-- PREPARATION METHODS AND INGREDIENTS FOR RECIPE -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="methods">Method(s)</label>
                            <!-- id="method" calls the CK-Editor as defined in the head script section above -->

                            <textarea id="method" class="form-control <?php echo (!empty($method_err)) ? 'is-invalid' : ''; ?>" placeholder="...enter methods here" name="method" value="<?php echo $method; ?>" required>
                                    <?php echo $method; ?>
                            </textarea>
                            <span class="invalid-feedback"><?php echo $method_err; ?></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="ingredient">Ingredient(s)</label>
                            <textarea id="ingredient" class="form-control <?php echo (!empty($ingredient_err)) ? 'is-invalid' : ''; ?>" placeholder="...enter methods here" name="ingredient" value="<?php echo $ingredient; ?>" required>
                               <!-- Retain textarea input field if available until form is submitted -->
                                <?php if(isset($_POST['ingredient'])) { 
                                    echo htmlentities ($_POST['ingredient']); }?>
                             </textarea>
                            <span class="invalid-feedback"><?php echo $ingredient_err; ?></span>
                        </div>
                    </div>
                </div>

                <div class="addmore"> <br><br>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Update Recipe" />
                </div>
                
               
            </div>

        </form>
    </main>
    <footer>&copy; CSYM019 2022</footer>
</body>

</html>