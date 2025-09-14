<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
   // include('./dbconnection.php');
    
    $conn = new mysqli("localhost", "hostel", "hostel", "test_db");
    
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }
  

//var_dump($_GET['regno']);
//exit;



// Fetch student details if regno is provided
if (isset($_GET['regno'])) {
    $regno = $_GET['regno'];
    
    $stmt = $conn->prepare("SELECT roomno, firstName, middleName, lastName, gender, contactno, emailid, 
    egycontactno, guardianName, guardianRelation, guardianContactno, 
    corresAddress, corresCIty, corresPincode, 
    pmntAddress, pmntCity, pmntPincode 
    FROM registration WHERE regno = ?");

    $stmt->bind_param("s", $regno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}


// Update button
if (isset($_POST['update'])) { 
   //echo "<pre>";
   //print_r($_POST); // Debugging
   //echo "</pre>";
   // exit();
        $roomno=$_POST['roomno'];
        $fname=$_POST['firstName'];
        $mname=$_POST['middleName'];
        $lname=$_POST['lastName'];
        $gender=$_POST['gender'];
        $contactno=$_POST['contactno'];
        $emailid=$_POST['emailid'];
        
        $emcntno=$_POST['egycontactno'];
        $gurname=$_POST['guardianName'];
        $gurrelation=$_POST['guardianRelation'];
        $gurcntno=$_POST['guardianContactno'];
        $caddress=$_POST['corresAddress'];
        $ccity=$_POST['corresCIty'];
        $cpincode=$_POST['corresPincode'];
        $paddress=$_POST['pmntAddress'];
        $pcity=$_POST['pmntCity'];
        $ppincode=$_POST['pmntPincode'];
        
        $regno = $_GET['regno'];  
       

   
        // Update query
        $query = "UPDATE registration SET 
                  roomno=?, firstName=?, middleName=?, lastName=?, gender=?, contactno=?, emailid=?, 
                  egycontactno=?, guardianName=?, guardianRelation=?, guardianContactno=?, 
                  corresAddress=?, corresCIty=?, corresPincode=?, 
                  pmntAddress=?, pmntCity=?, pmntPincode=? 
          WHERE regno=?";

                  
        $stmt = $conn->prepare($query);
     
        $stmt->bind_param(
           "sssssisissississis",  $roomno, $fname, $mname, $lname, $gender, $contactno, $emailid, $emcntno, $gurname, $gurrelation, $gurcntno, $caddress, $ccity, $cpincode, $paddress, $pcity, $ppincode, $regno
	    
	);

	
      if ($stmt->execute()) {
      
      //Image upload backend logic
       if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK ){
	        $file_name = time() . "_" . basename($_FILES['image']['name']);
		$tempname = $_FILES['image']['tmp_name'];
		$folder = 'uploads/'.$file_name;

		//$check_query = mysqli_query($conn, "SELECT COUNT(*) AS count FROM girl_profile_image WHERE file = '$file_name'");
		//$row = mysqli_fetch_assoc($check_query);
		//$count = $row['count'];

		//if ($count > 0){
		    //echo "<h2 style = 'color:red;'>This image already exists!</h2>";
		//} else {
		
            
		    if (copy($tempname, $folder)){
			$query = mysqli_query($conn, "INSERT INTO girl_profile_image (file, regno) VALUES ('$file_name', '$regno')");
			echo "<h2 style = 'color:green;'>File uploaded successfully! </h2>";
		    }  else {
			 echo "<h2 style = 'color:red;'> File not uploaded!</h2>";
		    }

		//}
      
         }
      
      
        $msg = "Student details updated successfully.";
        header("Location: manage-students.php?msg=" . urlencode($msg));
        exit();
    } else {
        $msg = "Error updating record: " . $stmt->error;
    }
    $stmt->close();

}
$conn->close();
    
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body> 
    <h2>Edit Student Details</h2>

    <form method="POST" action="" enctype="multipart/form-data">
    <table>
        <tr>
	    <td>First Name:</td>
	    <td><input type="text" name="firstName" value="<?php echo $row['firstName']; ?>" ></td>
       </tr>

	<tr>
	    <td>Middle Name:</td>
	    <td><input type="text" name="middleName" value="<?php echo $row['middleName']; ?>"></td>
	</tr>

	<tr>
	    <td>Last Name:</td>
	    <td><input type="text" name="lastName" value="<?php echo $row['lastName']; ?>"></td>
	</tr>

	<tr>
	    <td>Gender:</td>
	    <td><input type="text" name="gender" value="<?php echo $row['gender']; ?>" ></td>
	</tr>

	<tr>
	    <td>Contact No:</td>
	    <td><input type="text" name="contactno" value="<?php echo $row['contactno']; ?>" ></td>
	</tr>

	<tr>
	    <td>Email ID:</td>
	    <td><input type="email" name="emailid" value="<?php echo $row['emailid']; ?>" ></td>
	</tr>

	<tr>
	    <td>Room No:</td>
	    <td><input type="text" name="roomno" value="<?php echo $row['roomno']; ?>" ></td>
	</tr>

	<tr>
	    <td>Emergency Contact No:</td>
	    <td><input type="text" name="egycontactno" value="<?php echo $row['egycontactno']; ?>"></td>
	</tr>

	<tr>
	    <td>Guardian Name:</td>
	    <td><input type="text" name="guardianName" value="<?php echo $row['guardianName']; ?>"></td>
	</tr>

	<tr>
	    <td>Guardian Relation:</td>
	    <td><input type="text" name="guardianRelation" value="<?php echo $row['guardianRelation']; ?>"></td>
	</tr>

	<tr>
	    <td>Guardian Contact No:</td>
	    <td><input type="text" name="guardianContactno" value="<?php echo $row['guardianContactno']; ?>"></td>
	</tr>



	<tr>
	    <td>Correspondence Address:</td>
	    <td><input type="text" name="corresAddress" value="<?php echo $row['corresAddress']; ?>"></td>
	</tr>

	<tr>
	    <td>Correspondence City:</td>
	    <td><input type="text" name="corresCIty" value="<?php echo $row['corresCIty']; ?>"></td>
	</tr>

	<tr>
	    <td>Correspondence Pincode:</td>
	    <td><input type="text" name="corresPincode" value="<?php echo $row['corresPincode']; ?>"></td>
	</tr>

	<tr>
	    <td>Permanent Address:</td>
	    <td><input type="text" name="pmntAddress" value="<?php echo $row['pmntAddress']; ?>"></td>
	</tr>

	<tr>
	    <td>Permanent City:</td>
	    <td><input type="text" name="pmntCity" value="<?php echo $row['pmntCity']; ?>"></td>
	</tr>

	<tr>
	    <td>Permanent Pincode:</td>
	    <td><input type="text" name="pmntPincode" value="<?php echo $row['pmntPincode']; ?>"></td>
	</tr>

        
        <tr>
	    <td>Upload Profile Photo:</td>
	    <td><input type="file" name="image" ></td>  <!--accept="image/*"-->
        </tr>
        
        
        
        <tr> 
            <td colspan="2"><input type="submit" name="update" value="Update"></td>
        </tr>
        
        
    </table>
    
</form>


</body>
</html>
