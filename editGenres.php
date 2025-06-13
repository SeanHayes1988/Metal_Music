<?php
# Include script to make a database connection
include("database.php");
include("menuBar.html");

# Initialize variables
$genre_name = '';
$monthV = '';
$yearV = '';
$place_of_origin= [];
$notable_bands= [];

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
        $place_of_origin = explode(',', $row['place_of_origin']);
        $notable_bands = explode(',', $row['notable_bands']);
    } else {
        echo "Genre not found.";
    }
}

# If form is submitted for updating
if (isset($_POST['submit'])) {
    $genre_name = $_POST['genre_name'];
    $monthV = $_POST['monthV'];
    $yearV = $_POST['yearV'];
    $place_of_origin = $_POST['place_of_origin']; // array
    $place_of_origin_str = implode(', ', array_map('trim', $place_of_origin));

    $notable_bands = $_POST['notable_bands']; // array
    $notable_bands_str = implode(', ', array_map('trim', $notable_bands));


     $stmt = $conn->prepare("UPDATE genres SET monthV = ?, yearV = ?, place_of_origin = ?, notable_bands = ? WHERE genre_name = ?");

     $stmt->bind_param("sssss", $monthV, $yearV, $place_of_origin_str, $notable_bands_str, $genre_name);

    if ($stmt->execute()) {
        echo "Record updated successfully!<br/>";
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
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
</select>
        Year of Origin:
    <select name="yearV">
    <?php
    $years = [
        '1940', '1941', '1942', '1943', '1944', '1945', '1946', '1947', '1948', '1949',
        '1950', '1951', '1952', '1953', '1954', '1955', '1956', '1957', '1958', '1959',
        '1960', '1961', '1962', '1963', '1964', '1965', '1966', '1967', '1968', '1969',
        '1970', '1971', '1972', '1973', '1974', '1975', '1976', '1977', '1978', '1979',
        '1980', '1981', '1982', '1983', '1984', '1985', '1986', '1987', '1988', '1989',
        '1990', '1991', '1992', '1993', '1994', '1995', '1996', '1997', '1998', '1999',
        '2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009',
        '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019',
        '2020', '2021', '2022', '2023', '2024', '2025'
    ];
    foreach ($years as $year) {
        $selectedYear = ($year === $yearV) ? 'selected' : '';
        echo "<option value=\"$year\" $selectedYear>$year</option>";
    }
    ?>
 </select>

Place Of Origin:<br>
<div id="place-of-origin-container">
    <?php
    // Show existing values or at least one empty box
    if (!empty($place_of_origin)) {
        foreach ($place_of_origin as $index => $value) {
    $val = htmlspecialchars(trim($value));
    echo "<div class='origin-entry'>
            <input type='text' name='place_of_origin[]' value='$val'>
            <button type='button' onclick='this.parentElement.remove()'>Remove</button>
          </div>";
      }
  }
  ?>
</div>

<button type="button" onclick="addPlaceOfOrigin()">Add More</button>
    

Notable Bands:<br>
<div id="notable-bands-container">
    <?php
    // Show existing values or at least one empty box
    if (!empty($notable_bands)) {
        foreach ($notable_bands as $index => $value) {
    $val = htmlspecialchars(trim($value));
    echo "<div class='origin-entry'>
            <input type='text' name='notable_bands[]' value='$val'>
            <button type='button' onclick='this.parentElement.remove()'>Remove</button>
          </div>";
      }
  }
  ?>
</div>


<button type="button" onclick="addNotableBands()">Add More Bands</button>
        <input type="submit" name="submit" value="Update">
    </form>

    <!-- Link to external JavaScript file -->
<script src="mainJS.js"></script>

</body>
</html>
