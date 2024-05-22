
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>

<?php 

if(isset($_GET['id'], $_GET['title'], $_GET['experience'], $_GET['employment_type'])) {
  $job_id = $_GET['id'];
  $title = $_GET['title'];
  $experience = $_GET['experience'];
  $employment_type = $_GET['employment_type'];

  // Now you can use $job_id, $title, $experience, $employment_type in your form
}


?>

<form action="form.php" method="GET">
      <div>
        <h1>Register</h1>
        <p>Kindly fill in this form to register.</p>
        <label for="id"><b>ID</b></label>
        <input
          type="int"
          placeholder="Enter id"
          name="id"
          id="id"
          value="<?php echo isset($job_id) ? $job_id : ''; ?>"
        />
        <label for="fname"><b>First name</b></label>
        <input
          type="text"
          placeholder="Enter name"
          name="firstname"
          id="name"
          value="<?php echo isset($title) ? $title : ''; ?>"
        />

        <label for="lname"><b>Last Name</b></label>
        <input
          type="text"
          placeholder="Enter last name"
          name="lastname"
          id="lname"
          value="<?php echo isset($experience) ? $experience : ''; ?>"
        />
        
        <label for="email"><b>Email</b></label>
        <input
          type="email"
          placeholder="Enter email"
          name="email"
          id="email"
          value="<?php echo isset($employment_type) ? $employment_type : ''; ?>"
        />

        <button type="submit"name="submit" value="submit">Submit</button>
        <button type="submit" name="submit2" value="update"> update</button>
        <a href="form.php"><button>reset</button></a>
      </div>

    </form>

<?php 
include("test.php");
if(isset($_GET['submit'])){
if(empty($_GET['firstname'])){
  echo "fill the data";

}
else{
  $id = $_GET['id'];
  $name = $_GET['firstname'];
  $lastname =$_GET['lastname'];
  $email = $_GET['email'];
  
  $sql = "INSERT INTO MyGuests (id , firstname, lastname, email)
  VALUES ('$id','$name', '$lastname', '$email')";
  
  try {
    if ($con->query($sql) === TRUE) {
        echo "Record submitted successfully";
    } else {
        throw new Exception("Warning: " . $con->error);
    }
    } catch (Exception $e) {
    echo "do not fill dublicate id ";
    }
}
$con->close();
}

?>


<?php 
include("test.php");
if(isset($_GET['submit2'])){

  $id = $_GET['id'];
  $name = $_GET['firstname'];
  $lastname =$_GET['lastname'];
  $email = $_GET['email'];



  $sql = "UPDATE MyGuests SET firstname='$name' ,lastname='$lastname' ,email='$email' WHERE id=$id";

  try {
    if ($con->query($sql) === TRUE) {
        echo "update submitted successfully";
    } else {
        throw new Exception("Error: " . $con->error);
    }
    } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
   }
  $con->close();
}


?>
<?php 

include("test.php");
if(isset($_GET['submit3'])){

  $id = $_GET['id'];

  $sql = "DELETE FROM MyGuests WHERE id=$id";

  if ($con->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $con->error;
  }
  $con->close();
}


?>





<table class="table table-striped table-bordered">
<thead>
<tr>
<th style='width:50px;'>ID</th>
<th style='width:150px;'>Name</th>
<th style='width:50px;'>last name</th>
<th style='width:150px;'>email</th>
<th style='width:150px;'>action</th>
</tr>
</thead>
<tbody>
    <?php

include("test.php");
if (isset($_GET['page_no']) && $_GET['page_no']!=""  ) {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

     
	$total_records_per_page = 3;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `MyGuests`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM `MyGuests` LIMIT $offset, $total_records_per_page");
    while($row = mysqli_fetch_array($result)){
		echo "<tr>
			  <td>".$row['id']."</td>
			  <td>".$row['firstname']."</td>
	 		  <td>".$row['lastname']."</td>
		    <td>".$row['email']."</td>
        <td>
        " ?>
        <a href='update.php?id=<?php  echo $row['id'] ?>'><button style='color:blue;' >edit</button></a>
        <a href='delete.php?id=<?php  echo $row['id'] ?>'><button style='color:red;'>Delete</button></a>
        <?php
        "
        </td>
			  </tr>";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>


        

  
</body>
</html>