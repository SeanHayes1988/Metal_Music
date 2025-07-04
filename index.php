  <?php
  // Include script to make a database connection
     include("connect.php");
     include("menuBar.html");
     include("deleteGenre.php");

     # Button click to Delete
# Check that the input fields are not empty and process the data
/*if(!empty($_POST['delete']) && !empty($_POST['genre_name'])){
    $query3 = "DELETE FROM  genres WHERE genre_name='".$_POST['genre_name']."' ";
    if (mysqli_query($conn, $query3)) {
        echo "Record deleted successfully !";
    } else {
        # Display an error message if unable to delete the record
       echo "Error deleting record: " . $conn->error;
    }
}*/

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
         /*echo'<a href="index.php"><b> Home</b> </a>';
         echo'<a href="createGenre.php"><b> Create Genre </b> </a>';*/
         
         $query = "SELECT * FROM genres";
         $result = $conn->query($query);
       

         if ($result->num_rows > 0) {
            echo "<table border='1'>
              <thead>
                <tr>
                <th>Genre Name</th>
                <th>Month Of Origin</th>
                <th>Year Of Origin</th>
                <th>Places of Origin</th>
                <th>Notable Bands</th>
                <th>Comments</th>
                <th>Delete Genre</th>
                </tr>
              </thead>
              ";
    while($row = $result->fetch_assoc()) {
       echo "<tr",">",
            "<td>", $row["genre_name"],"</td>",
            "<td>", $row["monthV"],"</td>",
            "<td>", $row["yearV"],"</td>",
            "<td>", $row["place_of_origin"],"</td>",
            "<td>", $row["notable_bands"],"</td>",
            "<td>", $row["comments"],"</td>",

            "<td>",
                "<form action='index.php' method='post'>
                 <input name='genre_name' value='",$row["genre_name"],"' hidden >
                 <button type='submit' name='delete' value='delete'>Delete</button>
                </form>",
            "</td>",
            "</tr>";
    }
    echo  "</table>";
}else {
 echo "No Genre's were Found!!!";
}
      ?>
   </body>
</html>
