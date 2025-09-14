<?php
    $DB_host = "localhost";
    $DB_user = "hostel";
    $DB_pass = "hostel";
    $DB_name = "test_db";
    try
    {
        $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
        $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connection established successfully.";
    }
        catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
?>
