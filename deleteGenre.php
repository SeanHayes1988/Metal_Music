  <?php
  include("connect.php");
  include("menuBar.html");

if (!empty($_GET['id'])) {
    $genreId = $_GET['id'];
    $query = "DELETE FROM genres WHERE genreId='$genreId'";
    if (mysqli_query($conn, $query)) {
        echo "Record deleted successfully !";
    } else {
        # Display an error message if unable to delete the record
       echo "Error deleting record: " . $conn->error;
    }
}
?>

