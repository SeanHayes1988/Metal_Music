  <?php
  // Include script to make a database connection
     include("connect.php");
     include("menuBar.html");
?>

<!DOCTYPE html>
<html lang ="en">
   <head>
      <meta charset='utf-8'>
      <meta name='description' content='Rock and Metal Music Encyclopedia'>
      <meta name='keywords' content='Rock and Metal Music'>
      <meta name='author'  content='Know Your Metal - Sean Hayes '>
      <meta name='robots' content='all'>

      <title>Welcome to Know Your Metal \m/ </title>
        <link rel="stylesheet" type="text/css" href="border.css"/>
   </head>
   <body>
      
        <?php

$query = "SELECT genre.genreId, genre.genreName, genre.monthOfYear, genre.yearOfOrigin, GROUP_CONCAT(DISTINCT places.placeOfOrigin SEPARATOR ', ') AS placesOfOrigin, /*concatenates place of origin by a sperator of a coma*/
GROUP_CONCAT(DISTINCT artist.artistName SEPARATOR ', ') AS artists, genre.comments FROM genres genre LEFT JOIN genrePlaces genrePlaces ON genre.genreId = genrePlaces.genreId /*DISTINCT ignores dulipates*/
LEFT JOIN placeOfOrigin places ON genrePlaces.placeOfOriginID = places.placeOfOriginID LEFT JOIN genreArtists genreArtists ON genre.genreId = genreArtists.genreId LEFT JOIN artists artist ON genreArtists.artistID = 
artist.artistID GROUP BY genre.genreId, genre.genreName, genre.monthOfYear, genre.yearOfOrigin, genre.comments ORDER BY genre.genreName ASC";
$result = $conn->query($query);


         if ($result->num_rows > 0) {
            echo "<table border='1'>
              <thead>
                <tr>
                <th>Genre Name</th>
                <th>Month Of Origin</th>
                <th>Year Of Origin</th>
                <th>Places of Origin</th>
                <th>Artist Name</th>
                <th>Comments</th>
                <th>Delete Genre</th>
                </tr>
              </thead>
              ";

    while($row = $result->fetch_assoc()) {
   echo "<tr>",
        "<td>", htmlspecialchars($row["genreName"]), "</td>",
        "<td>", htmlspecialchars($row["monthOfYear"]), "</td>",
        "<td>", htmlspecialchars($row["yearOfOrigin"]), "</td>",
        "<td>", htmlspecialchars($row["placesOfOrigin"]), "</td>",
        "<td>", htmlspecialchars($row["artists"]), "</td>",
        "<td>", htmlspecialchars($row["comments"]), "</td>",
        "<td><a href='deleteGenre.php?id=" . $row["genreId"] . "'>Delete</a></td>",
        "</tr>";
}

    echo  "</table>";
}else {
 echo "No Genre's were Found!!!";
}
      ?>
   </body>
</html>
