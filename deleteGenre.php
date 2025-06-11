  <?php
     # Button click to Delete
# Check that the input fields are not empty and process the data
if(!empty($_POST['delete']) && !empty($_POST['genre_name'])){
    $query3 = "DELETE FROM  genres WHERE genre_name='".$_POST['genre_name']."' ";
    if (mysqli_query($conn, $query3)) {
        echo "Record deleted successfully !";
    } else {
        # Display an error message if unable to delete the record
       echo "Error deleting record: " . $conn->error;
    }
}
?>