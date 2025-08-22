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
        /* $query = "SELECT * FROM genres";
         $result = $conn->query($query);*/
       
       // new query 

         $query = "SELECT genre.genreId, genre.genreName, genre.monthOfYear, genre.yearOfOrigin, places.placeOfOrigin, artist.artistName, genre.comments FROM genres genre LEFT JOIN placeOfOrigin places ON genre.placeOfOriginID = places.placeOfOriginID LEFT JOIN genreArtists genreArtist ON genre.genreId = genreArtist.genreId 
            LEFT JOIN artists artist ON genreArtist.artistID = artist.artistID";

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
       echo "<tr",">",
            "<td>", $row["genreName"],"</td>",
            "<td>", $row["monthOfYear"],"</td>",
            "<td>", $row["yearOfOrigin"],"</td>",
            "<td>", $row["placeOfOrigin"],"</td>",
            "<td>", $row["artistName"],"</td>",
            "<td>", $row["comments"],"</td>",
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
