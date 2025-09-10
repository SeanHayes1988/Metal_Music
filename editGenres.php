<?php
include("connect.php");
include("menuBar.html");

// Initialize variables
$genreId = '';
$genreName = '';
$monthOfYear ='';
$yearOfOrigin = '';
$comments = '';
$placeOfOrigin ='';
$artistName = [];
$formVisible = false;
$genreInserted = false; // initialize to false

// Handle "Load Existing Data"
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['load']) && !empty($_POST['genreId'])) {
    $genreId = intval($_POST['genreId']);
    $formVisible = true;

    $query = "SELECT genre.genreId, genre.genreName, genre.monthOfYear, genre.yearOfOrigin, GROUP_CONCAT(DISTINCT place.placeOfOrigin SEPARATOR ',') AS places,GROUP_CONCAT(DISTINCT a.artistName SEPARATOR ',') 
    AS artistNames,genre.comments FROM genres genre LEFT JOIN genrePlaces genrePlace ON genre.genreId = genrePlace.genreId LEFT JOIN placeOfOrigin place ON genrePlace.placeOfOriginID = place.placeOfOriginID
    LEFT JOIN genreArtists genreArtist ON genre.genreId = genreArtist.genreId LEFT JOIN artists a ON genreArtist.artistID = a.artistID WHERE genre.genreId = ? GROUP BY genre.genreId";

    $formInsert = $conn->prepare($query);
    $formInsert->bind_param("i", $genreId);
    $formInsert->execute();
    $result = $formInsert->get_result();

    if ($row = $result->fetch_assoc()) {
        $genreName = $row["genreName"];
        $monthOfYear = $row["monthOfYear"];
        $yearOfOrigin = $row["yearOfOrigin"];
        $placeOfOrigin = !empty($row['places']) ? explode(',', $row['places']) : [];//splits strings into array and puts in a comma(explode)
        $artistName = !empty($row['artistNames']) ? explode(',', $row['artistNames']) : [];
        $comments = htmlspecialchars($row['comments']);
    } else {
        echo "<p style='color:red;'>Genre not found.</p>";
    }

    $formInsert->close();
}

// updates the data "
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $genreId = intval($_POST['genreId']);
    $genreName = trim($_POST['genreName']);
    $monthOfYear = $_POST['monthOfYear'];
    $yearOfOrigin = $_POST['yearOfOrigin'];
    $comments = trim($_POST['comments']);
    $placeOfOrigin = $_POST['placeOfOrigin'] ?? [];
    $artistName = $_POST['artistName'] ?? [];
    $formVisible = true;

    // Cleans up the array
    $cleanPlaces = array_filter(array_map(function($place){ return trim(str_replace(',', '', $place)); }, $placeOfOrigin));//fiters through the array and trim off the comas and replace it with space
    $cleanArtists = array_filter(array_map(function($artist){ return trim(str_replace(',', '', $artist)); }, $artistName));

    // validating the inputs
    if (!empty($genreName) && !empty($monthOfYear) && !empty($yearOfOrigin)
        && !empty($cleanPlaces) && !empty($cleanArtists)) {

        // Update genres table
        $format = $conn->prepare("UPDATE genres SET monthOfYear=?, yearOfOrigin=?, comments=? WHERE genreId=?");
        $format->bind_param("sisi", $monthOfYear, $yearOfOrigin, $comments, $genreId);
        $format->execute();
        $format->close();

        // Update places
        $conn->query("DELETE FROM genrePlaces WHERE genreId=$genreId");
        foreach ($cleanPlaces as $place) {
            $cleanPlace = $conn->prepare("INSERT INTO placeOfOrigin (placeOfOrigin) VALUES (?) ON DUPLICATE KEY UPDATE placeOfOrigin=placeOfOrigin");
            $cleanPlace->bind_param("s", $place);
            $cleanPlace->execute();
            $placeId = $cleanPlace->insert_id ?: $conn->insert_id;
            $cleanPlace->close();

            $updatePlace = $conn->prepare("INSERT INTO genrePlaces (genreId, placeOfOriginID) VALUES (?, ?)");
            $updatePlace->bind_param("ii", $genreId, $placeId);
            $updatePlace->execute();
            $updatePlace->close();
        }

        // Update artists
        $conn->query("DELETE FROM genreArtists WHERE genreId=$genreId");
        foreach ($cleanArtists as $artist) {
            $cleanArtist = $conn->prepare("INSERT INTO artists (artistName) VALUES (?) ON DUPLICATE KEY UPDATE artistName=artistName");
            $cleanArtist->bind_param("s", $artist);
            $cleanArtist->execute();
            $artistId = $cleanArtist->insert_id ?: $conn->insert_id;
            $cleanArtist->close();

            $updateArtist = $conn->prepare("INSERT INTO genreArtists (genreId, artistID) VALUES (?, ?)");
            $updateArtist->bind_param("ii", $genreId, $artistId);
            $updateArtist->execute();
            $updateArtist->close();

            $genreInserted = true; 
        }

        echo "<script>alert('Genre updated successfully!'); window.location.href='editGenres.php';</script>";
        exit;

    } else {
        echo "<p style='color:red;'>All fields must be filled. Empty Place or Band fields are not allowed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Genre Details</title>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update this genre?");
        }
    </script>
</head>
<body>
    <h1>Form</h1>
    <p>Edit the record</p>

    <?php $formVisible = isset($_POST['load']) && !empty($_POST['genreId']); ?>

    <form method="POST" action="editGenres.php">
        <input type="hidden" name="genreId"  value="<?php echo isset($genreId) ? htmlspecialchars($genreId) : ''; ?>"/>

        Select Genre:
        <select name="genreId" required>
            <option value=""> Select Genre </option>
            <?php
            $result = $conn->query("SELECT genreId, genreName FROM genres ORDER BY genreName ASC");
            while ($row = $result->fetch_assoc()) {
                $selected = (isset($_POST['genreId']) && $_POST['genreId'] == $row['genreId']) ? 'selected' : '';
                echo "<option value=\"{$row['genreId']}\" $selected>" . htmlspecialchars($row['genreName']) . "</option>";
            }
            ?>
        </select><br><br>
        
        <input type="submit" name="load" value="Load Existing Data"><br><br>

        <?php $formVisible = isset($_POST['load']) && !empty($_POST['genreId']); ?>

        <div id="formFields" style="display: <?php echo $formVisible ? 'block' : 'none'; ?>;">
            Genre Name:
            <input type="text" name="genreName" value="<?php echo htmlspecialchars($genreName); ?>" readonly><br><br>

            Month of Origin:
            <select name="monthOfYear">
                <?php
                foreach ([
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ] as $month) {
                    $selected = ($month === $monthOfYear) ? 'selected' : '';
                    echo "<option value=\"$month\" $selected>$month</option>";
                }
                ?>
            </select><br><br>

            Year of Origin:
            <select name="yearOfOrigin">
                <?php
                for ($year = 1940; $year <= 2025; $year++) {
                    $selected = ($year == $yearOfOrigin) ? 'selected' : '';
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select><br><br>

            Place of Origin:
            <div id="placeOfOrigin">
                <?php foreach ($placeOfOrigin as $val): ?>
                    <div class="form-group origin-entry">
                        <input type="text" name="placeOfOrigin[]" value="<?= htmlspecialchars(trim($val)) ?>" class="form-control" required>
                        <button type="button" class="remove-btn">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <div>
                <button type="button" onclick="addNewLocation()">Add Place of Origin</button>
            </div>
            <br>

            Notable Bands:
            <div id="artistName">
                <?php foreach ($artistName as $val): ?>
                    <div class="form-group origin-entry">
                        <input type="text" name="artistName[]" value="<?= htmlspecialchars(trim($val)) ?>" class="form-control" required>
                        <button type="button" class="remove-btn">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" onclick="addArtist()">Add More Artist</button>
            <br><br>

            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments" rows="10" cols="50"><?php echo htmlspecialchars($comments); ?></textarea><br><br>

            <input type="submit" name="submit" value="Update" onclick="return confirmSubmit();">
        </div>
    </form>
    
    <script>
function confirmSubmit() {
    return confirm("Are you sure you want to update this genre?");
}
</script>


<?php if ($genreInserted): ?>
<script>
    alert("Genre successfully Updated. Metal Up Your Ass!!!");

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

    <script src="editGenres.js"></script>
</body>
</html>