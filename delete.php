<?php
// Include database connection
include 'test.php';

// Check if ID parameter is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
    // Delete job details from the database based on the ID
    $delete_sql = "DELETE FROM MyGuests WHERE id = $id";
    
    if ($con->query($delete_sql) === TRUE) {
        echo "deleted successfully";
        // Redirect back to view_jobs.php or any other page
        header("Location: form.php");
        exit;
    } else {
        echo "Error deleting job: " . $con->error;
    }
} else {
    echo "ID not provided";
    exit;
}
?>