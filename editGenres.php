<?php
# Include script to make a database connection
include("database.php");
include("menuBar.html");

# Initialize variables
$genre_name = '';
$monthV = '';
$yearV = '';

# If update button is clicked to load existing data
if (!empty($_POST['genre_name']) && isset($_POST['load'])) {
    $genre_name = $_POST['genre_name'];
    $query = "SELECT * FROM genres WHERE genre_name='$genre_name'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $genre_name = $row["genre_name"];
        $monthV = $row["monthV"];
        $yearV = $row["yearV"];
    } else {
        echo "Genre not found.";
    }
}

# If form is submitted for updating
if (isset($_POST['submit'])) {
    $genre_name = $_POST['genre_name'];
    $monthV = $_POST['monthV'];
    $yearV = $_POST['yearV'];

    $query = "UPDATE genres SET monthV = '$monthV', yearV = '$yearV' WHERE genre_name = '$genre_name'";

    if (mysqli_query($conn, $query)) {
        echo "Record updated successfully!<br/>";
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Genre Details</title>
</head>
<body>
    <h1>Form</h1>
    <p>Edit the record</p>
    <form method="POST" action="editGenres.php">
        Genre Name: <input type="text" name="genre_name" value="<?php echo htmlspecialchars($genre_name); ?>" required><br><br>
        <input type="submit" name="load" value="Load Existing Data"><br><br>

       <!-- Month of Origin: <input type="text" name="monthV" value="<?php echo htmlspecialchars($monthV); ?>"><br><br>-->

    Month of Origin: 
<select name="monthV">
    <?php
    $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    foreach ($months as $month) {
        $selected = ($month === $monthV) ? 'selected' : '';
        echo "<option value=\"$month\" $selected>$month</option>";
    }
    ?>

        Year of Origin: <input type="text" name="yearV" value="<?php echo htmlspecialchars($yearV); ?>"><br><br>

        <input type="submit" name="submit" value="Update">
    </form>

</select>
<br><br>

</body>
</html>
