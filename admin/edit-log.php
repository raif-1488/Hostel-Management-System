<?php
$conn = new mysqli("localhost", "hostel", "hostel", "test_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){

	$id = $_POST['id'];
	$field = $_POST['field'];
	$action = $_POST['action'];
	
	
	// Validate column names to prevent SQL injection
	
	$allowed_fields = ['medical_emergency', 'alcoholic_substance', 'theft_record'];
	if (!in_array($field, $allowed_fields)){
	    die("Invalid field name");
	}
	
	
	// Determine the SQL query based on action
	if ($action === 'increment') {
	    $sql = "UPDATE girl_log_records SET $field = $field + 1 WHERE id = ?";
	} elseif ($action === 'decrement') {
	    $sql = "UPDATE girl_log_records SET $field = CASE WHEN $field > 0 THEN $field - 1 ELSE 0 END WHERE id = ?";
	} else {
		die("Invalid action");
	}
	
	
        // Use prepared statements
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        
        

        if ($stmt->execute()) {
            echo "Updated successfully!";
        } else {
            echo "Update failed! " . $conn->error;
        }
        
        $stmt->close();
}

$conn->close();  
?>
