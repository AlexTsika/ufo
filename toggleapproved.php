<?php
    session_start();
    require 'env.php';

    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        die('Access denied.');
    }

    // Check if the id parameter is set
    if (!isset($_POST['id'])) {
        die('Invalid parameters.');
    }

    // Decrypt the id parameter
    $id = decryptId($_POST['id']);

    // Prepare and execute the SQL query to toggle the approved column
    $stmt = $conn->prepare("UPDATE aliens SET approved = NOT approved WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the admin page
    header('Location: admin.php');
?>