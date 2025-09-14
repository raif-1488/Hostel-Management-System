<?php


$conn = new mysqli("localhost", "hostel", "hostel", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$studentRegno = $_SESSION['regno'];

$sql = "SELECT * FROM girl_log_records WHERE regno = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentRegno);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Log Records</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; border: 1px solid black; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Your Incident Log (<?= htmlspecialchars($studentRegno) ?>)</h2>

<table>
    <tr>
        <th>Student_ID</th>
        <th>Date</th>
        <th>Incident Type</th>
        <th>Description</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['regno']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['type']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
