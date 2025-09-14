<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$conn = new mysqli("localhost", "hostel", "hostel", "test_db");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = "";

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $regno = trim($_POST['regno']);
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $description = trim($_POST['description']);
    

    // Validation: Ensure required fields are not empty
    if (empty($date) || empty($regno) || empty($type)) {
        $message = "<p style='color: red;'>Please fill in all required fields.</p>";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO girl_log_records (date, regno, type, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $date, $regno, $type, $description);

        if ($stmt->execute()) {
          // $message = "Student record added successfully!";
           $url = "http://localhost/test-hostel-management-system/admin/manage-students.php";
           header('Location: ' .$url);
           exit();
            
        } else {
            $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
            exit();
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Student Log</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 20px; }
        form { width: 50%; margin: 0 auto; padding: 20px; border: 1px solid black; border-radius: 8px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background-color: green; color: white; border: none; cursor: pointer; }
        button:hover { background-color: darkgreen; }
      
    </style>
   
</head>
<body>

<h2>Add New Student Log</h2>
<?= $message; ?>

<form method="POST" action="">
    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Registration Number:</label>
    <input type="text" name="regno" placeholder="Enter Reg No." required>

    <label>Incident Type:</label>
    <select name="type" required>
        <option value="">Select Type</option>
        <option value="medical_emergency">Medical Emergency</option>
        <option value="alcohol_consumption">Alcohol Consumption</option>
        <option value="late_entry">Late Entry</option>
        <option value="theft">Theft</option>
        <option value="others">Others</option>
    </select>

    <label>Description:</label>
    <input type="text" name="description">
  
    
    <button type="submit" name="submit">Add Student Record</button>
</form>

</body>
</html>
