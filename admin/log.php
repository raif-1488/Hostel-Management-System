<?php
$conn = new mysqli("localhost", "hostel", "hostel", "test_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Handle Delete Request
if (isset($_GET['del_regno']) && isset($_GET['del_date'])) {
    $regno = $_GET['del_regno'];
    $date = $_GET['del_date'];

    $sql = "DELETE FROM girl_log_records WHERE regno = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $regno, $date);

    if ($stmt->execute()) {
          // echo "<script>alert('Student record deleted successfully!');</script>";
	   $url = "http://localhost/test-hostel-management-system/admin/manage-students.php";
	   header('Location: ' .$url);
	   exit();
    } else {
        echo "<script>alert('Error deleting record!');</script>";
    }

    $stmt->close();
  
}




// Fetch search query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

//Fetch Add query
$add = isset($_GET['add']) ;



$sql = "SELECT * FROM girl_log_records ";

if ($search !== '') {
    $sql .= " WHERE regno LIKE '%$search%' ";
}
$sql .= " ORDER BY date DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Student Log</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; border: 1px solid black; }
        
        .search-container { text-align: right; margin: 10px 5%; }
        .search-input { padding: 8px; width: 250px; }
        .search-btn { padding: 8px 12px; cursor: pointer; } 
        
        .add-container { text-align: center; margin: 20px 0; }
        .add-btn { 
            padding: 12px 20px; 
            font-size: 16px;
            background-color: green; 
            color: white; 
            border: none; 
            cursor: pointer; 
            border-radius: 5px;
        }
        .add-btn:hover {
            background-color: darkgreen;
        } 
        
        .icon { font-size: 18px; cursor: pointer; }
        .icon-delete { color: red; }
        .icon-edit { color: blue; }
        
    </style>
    
    
</head>


<body>

<h2 style="text-align:center;">Student Log </h2>



<!-- Search Box -->
<div class="search-container">
    <form method="GET">
        <input type="text" name="search" class="search-input" placeholder="Search by regno" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="search-btn">Search</button>
    </form>
</div>


<!-- Add student Box -->
<div class = "add-container">
    <a href="Add-log-students.php">
        <button type="button" class="add-btn">Add New Student </button>
    </a>
</div>

<!-- Data Entry Table   -->

<table>
    <tr>
        <th>Student_ID</th>
        <th>Date</th>
        <th>Incident_Type  </th>
        <th>Description </th>
        <th>Actions</th>
        
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['regno'] ?></td>
            <td><?= $row['date'] ?></td>
            
            <td><?= $row['type'] ?></td> 
            <td><?= $row['description'] ?></td>
            
            <td>
    <a href="edit-log.php?id=<?= urlencode($row['regno']) ?>&date=<?= urlencode($row['date']) ?>" title="Edit">
        <i class="icon icon-edit">✎</i>
    </a>
    &nbsp;&nbsp;
    <a href="log.php?del_regno=<?= urlencode($row['regno']) ?>&del_date=<?= urlencode($row['date']) ?>" title="Delete" onclick="return confirmDelete();">
        <i class="icon icon-delete">✖</i>
    </a>
</td>

<!--When a user clicks delete, it sends regno and date as GET parameters -->
   
            
            
      </tr>
    <?php } ?>
</table>


<script>
        function confirmDelete() {
            return confirm("Do you want to delete this record?");
        }
        
        
</script>

</body>
</html>

<?php $conn->close(); ?>
