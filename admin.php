<?php
    session_start();

    // Include the header.php
    require 'header.php';

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
    echo '<form method="post" class="bg-dark p-2 text-dark bg-opacity-10 rounded mb-2">';
    echo '<input type="text" name="username" id="username" placeholder="Username" class="form-control">';
    echo '<hr>';
    echo '<input type="password" name="password" id="password" placeholder="Password" class="form-control">';
    echo '<hr>';
    echo '<button type="submit" class="btn btn-primary">Login</button>';
    echo '</form>';

    } else {
    // Admin is logged in, display data
    $query = "SELECT * FROM aliens ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Image</th>';
    echo '<th scope="col">Location</th>';
    echo '<th scope="col">Date &amp; time</th>';
    echo '<th scope="col">Description</th>';
    echo '<th scope="col">Scary</th>';
    echo '<th scope="col">Approved</th>';
    echo '<th scope="col">Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        // Construct image path
        $imagePath = 'assets/images/' . $row['alienImg'];
        // Check if image is not empty and exists
        if (!empty($row['alienImg']) && file_exists($imagePath)) {
          echo "<td><img src='$imagePath' width='100px'></td>";
        } else {
          // Display default image
          echo "<td><img src='assets/images/default-image.jpg' width='100px'></td>";
        }
        // Display other data
        echo '<td>' . $row['location'] . '</td>';
        echo '<td>' . formatDate($row['date']) . ' - '. $row['time'] .'</td>';
        echo '<td>' . $row['message'] . '</td>';
        echo '<td>' . ($row['scary'] ? 'Yes' : 'No') . '</td>';
        echo '<td>' . ($row['approved'] ? 'Yes' : 'No') . '</td>';
        echo "<td>";
        if ($row['approved']) {
          echo "<button type='submit' name='unapprove' class='btn btn-danger'>Unapprove</button>";
        } else {
          echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
        }
        echo "</td>";
        echo '</tr>';
      }      
    echo '</tbody>';
    echo '</table>';

    // Display logout button
    echo '<form method="post">';
    echo '<button type="submit" name="logout" class="btn btn-primary">Logout</button>';
    echo '</form>';

    // Check if the logout button has been clicked
    if (isset($_POST['logout'])) {
        // Destroy the session and redirect to the admin page to refresh the page
        session_destroy();
        header('Location: admin.php');
    }
    }

    // Close the database connection
    $conn->close();

    
    
require 'footer.php' ?>