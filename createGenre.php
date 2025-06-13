<?php
# Include script to make a database connection
include("connect.php");
include("menuBar.html");

if (!empty($_GET['genre_name']) || !empty($_GET['monthV']) || !empty($_GET['year']) || !empty($_GET['place_of_origin']) || !empty($_GET["notable_bands"]) || !empty($_GET["comments"])){

$genre_name         = $_GET['genre_name'];
$monthV             = $_GET['monthV'];
$yearV              = $_GET['yearV'];

//checkes each value in the place_of_origin and notable_bands fields entry, and removes the comma to prevent another entry into the array in the database

$place_of_origin    = array_map(function($val){
    return str_replace(',', ' ', trim($val)); //replaces the coma with a empty string in the database
    }, $_GET['place_of_origin']);
$place_of_origins   = implode(', ', $place_of_origin);

$notable_band       =  array_map(function($val){
     return str_replace(',', ' ', trim($val));
    }, $_GET['notable_bands']);
$notable_bands      = implode(', ', $notable_band);

$comments           = $_GET["comments"];

# Insert into the database
$query = "INSERT INTO genres (genre_name,monthV,yearV,place_of_origin,notable_bands,comments) VALUES ('$genre_name','$monthV','$yearV','$place_of_origins','$notable_bands','$comments')";
if (mysqli_query($conn, $query)) {
    echo "New record created successfully !";
    } else {
         echo "Error inserting record: " . $conn->error;
    }
 }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Genre</title>

</head>
<body>
    <h1>Create Genres </h1>
        <form name="createGenre" method="get" action="createGenre.php" onsubmit="return validateForm()" required>
            Name: <input type="text" name="genre_name"><br><br/>
            <label for="monthV" class="required">   Month of Origin: </label>
       <select class="form-select" id="monthV" name="monthV" required>
    <option value="">month</option>
    <?php
    $months = ['Not Specified', 'January', 'February', 'March', 'April', 'May', 'June',
               'July', 'August', 'September', 'October', 'November', 'December'];
    foreach ($months as $month) {
        $selected = ($monthV == $month) ? 'selected' : '';
        echo "<option value=\"$month\" $selected>$month</option>";
    }
    ?>
</select><br><br>

        <label for="yearV" class="required"> Year of Origin: </label>

        <select class="form-select" id="yearV" name="yearV" required>
    <option value="">year</option>
    <?php
    for ($year = 1940; $year <= 2025; $year++) {
        $selected = ($yearV == $year) ? 'selected' : '';
        echo "<option value=\"$year\" $selected>$year</option>";
    }
    ?>
</select>

        <br/>  <br/>

       <label>Place of Origin</label> <button type="button"  onclick="addEntry();"> Add Another Location </button>
            <br/> <br/>
            <div id="place_of_origin">
                <div class="form-group">
                    <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required="required"/>
                </div>
            </div> 
            <br/>


             <label>Notable Bands</label> <button type="button"  onclick="addFn();"> Add Another Band </button>
            <br/> <br/>
            <div id="notable_bands">
                <div class="form-group">
                    <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required="required"/>
                </div>
            </div>

        
    </div>

            Comments: <textarea name="comments"></textarea><br><br/>
            <input type="submit" name="save" value="submit" >
        </form>

        <script src="mainJS.js"></script>
    </body>
</html>
