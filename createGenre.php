<?php
# Include script to make a database connection
include("connect.php");
include("menuBar.html");

if (!empty($_GET['genre_name']) || !empty($_GET['monthV']) || !empty($_GET['yearV']) || !empty($_GET['place_of_origin']) || !empty($_GET["notable_bands"]) || !empty($_GET["comments"])) {

    $genre_name = $_GET['genre_name'];
    $monthV     = $_GET['monthV'];
    $yearV      = $_GET['yearV'];

    // Clean and handle place_of_origin
    $clean_place_of_origins = array_map(function($val) {
        return str_replace(',', ' ', trim($val));
    }, $_GET['place_of_origin']);

    $place_of_origins = implode(', ', $clean_place_of_origins); // for genres table

    // Clean and handle notable bands
    $clean_notable_bands  = array_map(function($val) {
        return str_replace(',', ' ', trim($val));
    }, $_GET['notable_bands']);
    $multi_notable_bands = implode(', ', $clean_notable_bands); // for genres table

    $comments = $_GET["comments"];

    // Insert into genres table
    $query = $conn->prepare("INSERT INTO genres (genre_name, monthV, yearV, place_of_origin, notable_bands, comments) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $genre_name, $monthV, $yearV, $place_of_origins, $multi_notable_bands, $comments);
    $query->execute();
    $query->close();

    // Insert unique place_of_origin values
    foreach ($clean_place_of_origins as $origin) {
        $stmtCheck = $conn->prepare("SELECT place_of_origin FROM placeOfOrigin WHERE place_of_origin = ?");
        $stmtCheck->bind_param("s", $origin);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows === 0) {
            $stmtInsert = $conn->prepare("INSERT INTO placeOfOrigin (place_of_origin) VALUES (?)");
            $stmtInsert->bind_param("s", $origin);
            $stmtInsert->execute();
            $stmtInsert->close();
            echo "Inserted new place of origin: $origin<br>";
        } else {
            echo "Place of origin '$origin' already exists.<br>";
        }

        $stmtCheck->close();
    }

    // Insert unique notable bands
    foreach ($clean_notable_bands as $bands) {
        $stmtCheck1 = $conn->prepare("SELECT notable_bands FROM notableBands WHERE notable_bands = ?");
        $stmtCheck1->bind_param("s", $bands);
        $stmtCheck1->execute();
        $stmtCheck1->store_result();

        if ($stmtCheck1->num_rows === 0) {
            $stmtInsert1 = $conn->prepare("INSERT INTO notableBands (notable_bands) VALUES (?)");
            $stmtInsert1->bind_param("s", $bands);
            $stmtInsert1->execute();
            $stmtInsert1->close();
            echo "Inserted new notable band: $bands<br>";
        } else {
            echo "Notable band '$bands' already exists.<br>";
        }

        $stmtCheck1->close();
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

    <label for="monthV" class="required">Month of Origin:</label>
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

    <label for="yearV" class="required">Year of Origin:</label>
    <select class="form-select" id="yearV" name="yearV" required>
        <option value="">year</option>
        <?php
        for ($year = 1940; $year <= 2025; $year++) {
            $selected = ($yearV == $year) ? 'selected' : '';
            echo "<option value=\"$year\" $selected>$year</option>";
        }
        ?>
    </select><br><br>

 <h2>Place of Origin</h2>
<button type="button" onclick="addEntry()">Add Another Location</button>
<div id="place_of_origin">
  <div class="form-group">
    <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required />
    <button type="button" class="remove-btn">Remove</button>
  </div>
</div>

<h2>Notable Bands</h2>
<button type="button" onclick="addFn()">Add Another Band</button>
<div id="notable_bands">
  <div class="form-group">
    <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required />
    <button type="button" class="remove-btn">Remove</button>
  </div>
</div>

    Comments: <textarea name="comments"></textarea><br><br/>
    <input type="submit" name="save" value="submit">
</form>


   <script>
        
      function addEntry() {
    const container = document.getElementById('place_of_origin');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';
    wrapper.innerHTML = `
      <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required />
      <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
  }

  // Add new notable_bands input group
  function addFn() {
    const container = document.getElementById('notable_bands');
    const wrapper = document.createElement('div');
    wrapper.className = 'form-group';
    wrapper.innerHTML = `
      <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required />
      <button type="button" class="remove-btn">Remove</button>
    `;
    container.appendChild(wrapper);
  }

  // Delegated event listener for remove buttons in place_of_origin
  document.getElementById('place_of_origin').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-btn')) {
      const container = this;
      const allGroups = container.querySelectorAll('.form-group');
      if (allGroups.length > 1) {
        e.target.closest('.form-group').remove();
      } else {
        alert('You must keep at least one place of origin input.');
      }
    }
  });

  // Delegated event listener for remove buttons in notable_bands
  document.getElementById('notable_bands').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-btn')) {
      const container = this;
      const allGroups = container.querySelectorAll('.form-group');
      if (allGroups.length > 1) {
        e.target.closest('.form-group').remove();
      } else {
        alert('You must keep at least one band input.');
      }
    }
  });
    </script>


    </body>
</html>
