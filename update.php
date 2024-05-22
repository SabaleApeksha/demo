<?php
include 'test.php';
if(isset($_GET['id'])) {
    $job_id = $_GET['id'];

    $sql = "SELECT * FROM MyGuests  WHERE id = $job_id";
    $result = $con->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['firstname'];
        $experience = $row['lastname'];
        $employment_type = $row['email'];
        header("Location: form.php?id=$job_id&title=$title&experience=$experience&employment_type=$employment_type");
    } else {
        echo "Job not found";
        exit;
    }

}

?>
