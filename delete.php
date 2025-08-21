<?php 
require 'Database.php';

if (isset($_GET['deleteid'])) { //Checks if the deleteid key exists
    $BookId = (int) $_GET['deleteid']; //Retrieve the deleteid value from the URL

    $sql = "DELETE FROM books WHERE BookId = $BookId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: books.php');
        exit();
    } else {
        die("Delete failed: ". mysqli_error($conn));
    }
}
?>
