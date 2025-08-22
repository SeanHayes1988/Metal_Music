<?php
include("connect.php");
include("menuBar.html");

$genreInserted = false; // no genre has been inserted 
$submittedGenre = ''; //holds user input until end to see if it already exists

if ($_SERVER["REQUEST_METHOD"] === "POST") { //REQUEST_METHOD checks either get or post
    if (
        !empty($_POST['genreName']) &&
        !empty($_POST['monthOfYear']) &&
        !empty($_POST['yearOfOrigin']) &&
        isset($_POST['placeOfOrigin']) && !empty(array_filter($_POST['placeOfOrigin'])) && //issets() checks to see if variable is set to null
        isset($_POST['artistName']) && !empty(array_filter($_POST['artistName']))// array_filter() removes nulls empties 
    ) {
        $genreName    = trim($_POST['genreName']);
        $monthOfYear  = $_POST['monthOfYear'];
        $yearOfOrigin = $_POST['yearOfOrigin'];
        $comments     = trim($_POST['comments']);
        // goes through the array and checks all the values - trims them, replaces comas with blank space
        $cleanUpPlacesArray = [];

        foreach ($_POST['placeOfOrigin'] as $place) {
            $trimmedPlace = trim($place);                 
            $removeComas = str_replace(',', '', $trimmedPlace);  
            $cleanUpPlacesArray[] = $removeComas;           // 
        }

        $cleanUpArtistsArray = [];
         foreach ($_POST['artistName'] as $artist) {
            $trimmedPlace = trim($artist);                 
            $removeComas = str_replace(',', '', $trimmedPlace);  
            $cleanUpArtistsArray[] = $removeComas;           // 
        }

        $placeOfOrigins = implode(', ', $cleanUpPlacesArray);//joins array items together
        $artistName      = implode(', ', $cleanUpArtistsArray);


        // Check if genre already exists
        $checkGenre = $conn->prepare("SELECT genreName FROM genres WHERE genreName = ?");//prepare() makes sure user cannot accidentally editing the stucture of the data 
        $checkGenre->bind_param("s", $genreName);//binds values to the placeholders in this  case ?
        $checkGenre->execute();
        $checkGenre->store_result();// stores entered data to check later onn 

        if ($checkGenre->num_rows > 0) {
            echo "<script>alert('The genre \"$genreName\" already exists!');</script>";
            $checkGenre->close();
        } else {
            $checkGenre->close();

            // Insert into genres
            $query = $conn->prepare(

                "INSERT INTO genres (genreName, monthOfYear, yearOfOrigin, comments) 
                 VALUES (?, ?, ?, ?)"

               /* "INSERT INTO genres (genreName, monthOfYear, yearOfOrigin, placeOfOrigin, artistName, comments) 
                 VALUES (?, ?, ?, ?, ?, ?)"*/
            );
           // $query->bind_param("ssisss", $genreName, $monthOfYear, $yearOfOrigin, $placeOfOrigins, $artistName, $comments);
            $query->bind_param("ssis", $genreName, $monthOfYear, $yearOfOrigin, $comments);

            if (!$query->execute()) {
                die("Genre was not inserted: " . $query->error);
            }

            $genreId = $conn->insertId; // new code 
            $query->close();

            $genreInserted = true;// now genre is now successfully changed to true
            $submittedGenre = htmlspecialchars($genreName);

            // Insert unique places of origin
            foreach ($cleanUpPlacesArray as $place) {//using foreach loop to put into array -$place is a place holder 
                $checkPlace = $conn->prepare("SELECT placeOfOrigin FROM placeOfOrigin WHERE  placeOfOrigin = ?");
                $checkPlace->bind_param("s", $place);
                $checkPlace->execute();
                $checkPlace->store_result();

                if ($checkPlace->num_rows == 0) {
                    $insertPlace = $conn->prepare("INSERT INTO placeOfOrigin (placeOfOrigin) VALUES (?)");
                    $insertPlace->bind_param("s", $place);
                    $insertPlace->execute();
                    $insertPlace->close();
                }
                $checkPlace->close();
            }


foreach ($cleanUpArtistsArray as $artist) {
    // Check if artist exists
    $checkArtist = $conn->prepare("SELECT artistID FROM artists WHERE artistName = ?");
    $checkArtist->bind_param("s", $artist);
    $checkArtist->execute();
    $checkArtist->store_result();

    if ($checkArtist->num_rows == 0) {
        // Insert new artist
        $insertArtist = $conn->prepare("INSERT INTO artists (artistName) VALUES (?)");
        $insertArtist->bind_param("s", $artist);
        $insertArtist->execute();
        $artistId = $insertArtist->insertId;
        $insertArtist->close();
    } else {
        // Artist exists, fetch ID
        $checkArtist->bind_result($artistId);
        $checkArtist->fetch();
    }
    $checkArtist->close();

    // Link genre to artist
    $linkArtist = $conn->prepare("INSERT INTO genre_artists (genreId, artistID) VALUES (?, ?)");
    $linkArtist->bind_param("ii", $genreId, $artistId);
    $linkArtist->execute();
    $linkArtist->close();
}



////// new code 


                // TODO: more testing



            
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Genre</title>
</head>
<body>

<h1>Create Genres</h1>

<form method="post" action="createGenre.php" id="createGenre" onsubmit="return confirmSubmit();">

    <label for="genreName">Name:</label>
    <input type="text" id="genreName" name="genreName" required><br><br>

    <label for="monthOfYear">Month of Origin:</label>
    <select id="monthOfYear" name="monthOfYear" required>
        <option value="">Select Month</option>
        <?php
        $months = ['Not Specified', 'January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'];
        foreach ($months as $month) {
            echo "<option value=\"$month\">$month</option>";
        }
        ?>
    </select><br><br>

    <label for="yearOfOrigin">Year of Origin:</label>
    <select id="yearOfOrigin" name="yearOfOrigin" required>
        <option value="">Select Year</option>
        <?php
        for ($year = 1940; $year <= date("Y"); $year++) {
            echo "<option value=\"$year\">$year</option>";
        }
        ?>
    </select><br><br>

    <h2>Place of Origin</h2>
    <button type="button" onclick="addNewLocation()">Add Another Location</button>
    <div id="placeOfOrigin">
        <div class="form-group">
            <input type="text" name="placeOfOrigin[]" placeholder="Enter location..." required>
        </div>
    </div>

    <h2>Artist(s)</h2>
    <button type="button" onclick="addArtist()">Add Another Artist</button>
    <div id="artistName">
        <div class="form-group">
            <input type="text" name="artistName[]" placeholder="Enter Artist..." required>
        </div>
    </div>

    <label for="comments">Comments:</label><br>
    <textarea name="comments"></textarea><br><br>

    <input type="submit" name="save" value="Submit">
</form>


<script>
function confirmSubmit() {
    return confirm("Are you sure you want to submit this genre?");
}
</script>


<?php if ($genreInserted): ?>
<script>
    alert("Genre successfully created. Metal Up Your Ass!!!");

    //when genre is addee to the database reset the page 
    if (window.history.replaceState) {
            try {
                let currentURL = new URL(window.location.href);
                currentURL.search = ''; 
                window.history.replaceState(null, '', currentURL.href);
            } catch (err) {
                // error
                console.warn("Couldn't clean the URL:", err);
            }
        }
</script>
<?php endif; ?>



<script src="createGenre.js"></script>
</body>
</html>
