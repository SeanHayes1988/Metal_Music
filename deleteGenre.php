<?php
include("connect.php");
include("menuBar.html");

if (!empty($_GET['id'])) {
    $genreId = intval($_GET['id']); // always sanitize input

    // First, delete dependent rows in child tables
    $deleteGenreArtists = "DELETE FROM genreArtists WHERE genreId = $genreId";
    $deleteGenrePlaces  = "DELETE FROM genrePlaces WHERE genreId = $genreId";

    mysqli_query($conn, $deleteGenreArtists);
    mysqli_query($conn, $deleteGenrePlaces);

    // Now delete from genres
    $deleteGenre = "DELETE FROM genres WHERE genreId = $genreId";
    if (mysqli_query($conn, $deleteGenre)) {
        echo "Record deleted successfully!";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
