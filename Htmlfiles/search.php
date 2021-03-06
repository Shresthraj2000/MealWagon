<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/search.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Flip/1.1.2/jquery.flip.min.js" ></script>
    <title>Meal Wagon</title>
</head>
<body>
    <section class="content">
        <nav class="container-nav">
            <img src="..Images/logo (1).png" alt="">
            <div class="right-nav">
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <input type="text" placeholder="search meals" name="search">
                        <button><a><i class="fas fa-search"></i></a></button>
                    </form>
                    <?php
                    if(!empty($_GET['search'])){
                        $search = $_GET['search'];
                        $meals_url = 'https://api.spoonacular.com/recipes/complexSearch?query=' . $search . '&apiKey=9d29dd77f35b4d199ea2925104bb46d8';
                        $meals_json = file_get_contents($meals_url);
                        $meals_array = json_decode($meals_json, true);

                        $meals_calorie=array();
                        $meals_summary=array();
                
                        for($i=0;$i<9;$i++)
                        {
                            $meal_id = $meals_array['results'][$i]['id'];
                            $info_url = 'https://api.spoonacular.com/recipes/' . $meal_id . '/information?apiKey=9d29dd77f35b4d199ea2925104bb46d8&includeNutrition=true';
                            $info_json = file_get_contents($info_url);
                            $info_array = json_decode($info_json, true);
                            $summary=$info_array['summary'];
                            str_replace('<b>', '', $summary);
                            str_replace('</b>', '', $summary);
                            array_push($meals_summary,substr( $summary,0,10));
                            array_push($meals_calorie,$info_array['nutrition']['nutrients'][0]['amount']);
                        }
                    }
                    ?>
                </div>
                <a href="preferences.php">Preferences</a>
                <a href="mealplan.php"  class="active">My Meal</a>
                <a href="logout.php" >LogOut</a>
                <h2>Hello, <br><?php echo $_SESSION['username']; ?></h2>
            </div>
        </nav>front
        <div class="top-img">
            <div class="txt">
                <p>Search Recipes</p>  
                <p id="sml">Explore world class dishes and include<br>them in your daily meal plan</p>
             </div>
            <img src="../Images/image 28.png" alt="">
            
        </div>

        <div class="drop-down">
            <!-- <select name="ingredients" id="ingr">
                <option value="" disabled selected>Select Your Ingredients</option>
                <option value="Salt">Salt</option>
                <option value="Sugar">Sugar</option>
            </select> -->
        </div>
        
        <?php
            if(!empty($meals_array))
            {
                $meals = $meals_array['results'];
                for($i=0;$i<9;$i=$i+3){
                    //echo "<h2>". $meal['title'] . "</h2>";
                    echo '<section class="items">
                    <div class="card">
                        <div class="front-1">
                            <img src=' . $meals[$i]['image'] . ' alt="">
                            <div class="text">
                                <div class="name">
                                    <h2>' . $meals[$i]['title'] . '</h2>
                                    <div class="cal">
                                        Calories ' . $meals_calorie[$i] . '
                                    </div>
                                </div>
                                <div class="details">
                                </div>
        
                                <div class="btns">
                                    <a href="../Htmlfiles/recipe.php?id=' . $meals[$i]['id'] .  '" class="recipe">RECIPE</a>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="add-meal-1">
                            <button id="close-1">X</button>
                            <div class="inputs">
                                <div>
                                    <input type="radio" id="breakfast" name="meal" value="breakfast">
                                    <label for="breakfast">Breakfast</label>
                                </div>
                                <div>
                                    <input type="radio" id="lunch" name="meal" value="lunch">
                                    <label for="breakfast">Lunch</label>
                                </div>
                                <div>
                                    <input type="radio" id="dinner" name="meal" value="dinner">
                                    <label for="breakfast">Dinner</label>
                                </div>  
                                
                            </div>
                            <div class="save">
                                <button class="save-1">Save</button>
                            </div>
                            
                            
                        </div>
                    
                    </div>
                    <div class="card">
                        <div class="front-2">
                            <img src=' . $meals[$i+1]['image'] . '>
                            <div class="text">
                                <div class="name">
                                    <h2>' . $meals[$i+1]['title'] . '</h2>
                                    <div class="cal">
                                    Calories ' . $meals_calorie[$i+1] . '
                                    </div>
                                </div>
                                <div class="details">
                                </div>
        
                                <div class="btns">
                                    <a href="../Htmlfiles/recipe.php?id=' . $meals[$i+1]['id'] .  '" class="recipe">RECIPE</a>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="add-meal-2">
                            <button id="close-2">X</button>
                            <div class="inputs">
                                <div>
                                    <input type="radio" id="breakfast" name="meal" value="breakfast">
                                    <label for="breakfast">Breakfast</label>
                                </div>
                                <div>
                                    <input type="radio" id="lunch" name="meal" value="lunch">
                                    <label for="breakfast">Lunch</label>
                                </div>
                                <div>
                                    <input type="radio" id="dinner" name="meal" value="dinner">
                                    <label for="breakfast">Dinner</label>
                                </div>
                                
                            </div>
                            <div class="save">
                                <button class="save-2">Save</button>
                            </div>
                            
                            
                            
                        </div>
                    
                    </div>
                    <div class="card">
                        <div class="front-3">
                            <img src=' . $meals[$i+2]['image'] . ' alt="">
                            <div class="text">
                                <div class="name">
                                    <h2>' . $meals[$i+2]['title'] . '</h2>
                                    <div class="cal">
                                    Calories ' . $meals_calorie[$i+2] . 
                                    '</div>
                                </div>
                                <div class="details">
                                </div>
                                <div class="btns">
                                    <a href="../Htmlfiles/recipe.php?id=' . $meals[$i+2]['id'] .  '" class="recipe">RECIPE</a>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="add-meal-3">
                            <button id="close-3">X</button>
                            <div class="inputs">
                                <div>
                                    <input type="radio" id="breakfast" name="meal" value="breakfast">
                                    <label for="breakfast">Breakfast</label>
                                </div>
                                <div>
                                    <input type="radio" id="lunch" name="meal" value="lunch">
                                    <label for="breakfast">Lunch</label>
                                </div>
                                <div>
                                    <input type="radio" id="dinner" name="meal" value="dinner">
                                    <label for="breakfast">Dinner</label>
                                </div>
                                
                            </div>
                            <div class="save">
                                <button class="save-3">Save</button>
                            </div>
                                
                            
                            
                        </div>
                    
                    </div>
                    
                </section>';
                }
            }
        ?>
    </section>
    <script type="text/javascript" src="../Javascript/search.js"></script>
</body>

</html>