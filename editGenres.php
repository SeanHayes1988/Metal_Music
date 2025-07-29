<?php
include("connect.php");
include("menuBar.html");

# Initialize variables
$genreName = '';
$monthOfYear = '';
$yearOfOrigin = '';
$placeOfOrigin = [];
$artistName = [];
$comments = "";

// Handle update submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $genreId      = intval($_POST['genreId']);
    $genreName    = trim($_POST['genreName']);
    $monthOfYear  = $_POST['monthOfYear'];
    $yearOfOrigin = $_POST['yearOfOrigin'];
    $comments     = trim($_POST['comments']);

    $placeOfOrigin = $_POST['placeOfOrigin'] ?? [];
    $artistName    = $_POST['artistName'] ?? [];

    // Clean arrays
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
    // Validation
    if (
        !empty($genreName) && !empty($monthOfYear) && !empty($yearOfOrigin) && !empty($cleanPlaces) && !empty($cleanBands)
    ) {
        $placeOfOrigin_str = implode(', ', $cleanPlaces);
        $Artist_str        = implode(', ', $cleanBands);

        $stmt = $conn->prepare("UPDATE genres SET genreName = ?, monthOfYear = ?, yearOfOrigin = ?, placeOfOrigin = ?, artistName = ?, comments = ? WHERE genreId = ?");
        $stmt->bind_param("ssssssi", $genreName, $monthOfYear, $yearOfOrigin, $placeOfOrigin_str, $Artist_str, $comments, $genreId);

        if ($stmt->execute()) {
            echo "<script>
                alert('Genre updated successfully! Rock On!!');
                window.location.href = 'editGenres.php';
            </script>";
            exit;
        } else {
            echo "<p style='color:red;'>Error updating record: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red;'>All fields must be filled. Empty Place or Band fields are not allowed.</p>";
    }
}

// Load existing genre data
if (!empty($_POST['genreId']) && isset($_POST['load'])) {
    $genreId = intval($_POST['genreId']);
    $query   = "SELECT * FROM genres WHERE genreId=$genreId";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $genreName     = $row["genreName"];
        $monthOfYear   = $row["monthOfYear"];
        $yearOfOrigin  = $row["yearOfOrigin"];
        $placeOfOrigin = explode(',', $row['placeOfOrigin']); // split by comma
        $artistName    = explode(',', $row['artistName']);
        $comments      = htmlspecialchars($row['comments']); // escape HTML
    } else {
        echo "Genre not found.";
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
        <input type="hidden" name="genreId" value="<?php echo htmlspecialchars($genreId ?? ''); ?>">

        Select Genre:
        <select name="genreId" required>
            <option value="">-- Select Genre --</option>
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
            <input type="text" name="genreName" value="<?php echo htmlspecialchars($genreName); ?>"><br><br>

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

            <input type="submit" name="submit" value="Update" onclick="return confirmUpdate();">
        </div>
    </form>

    <script src="editGenres.js"></script>
</body>
</html>