<?php
session_start();

// Include the env.php file to get the database connection information
require 'env.php';

// Check if admin is already logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {

  // Check if the login form has been submitted
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the users table to check if the submitted credentials are valid
    $sql = "SELECT * FROM users WHERE name='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Credentials are valid, set session variable to indicate admin is logged in
      $_SESSION['admin_logged_in'] = true;
    } else {
      echo 'Invalid login credentials.';
    }
  }

  // Display the login form
  echo '<form method="post">';
  echo '<label for="username">Username:</label>';
  echo '<input type="text" name="username" id="username">';
  echo '<br>';
  echo '<label for="password">Password:</label>';
  echo '<input type="password" name="password" id="password">';
  echo '<br>';
  echo '<button type="submit">Login</button>';
  echo '</form>';

} else {
  // Admin is logged in, display message
  echo '<h1>Admin logged in</h1>';
}

// Close the database connection
$conn->close();
?>