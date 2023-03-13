<?php
require 'header.php';

$username = sanitizeInput($_POST['username']);
$password = sanitizeInput($_POST['password']);
$user = new User($username,$password);

?>

<div class="row blue">
    <div class="col">
        <?php if($user->checkPassword()) {

          // Admin is logged in, display data
          $query = "SELECT * FROM aliens ORDER BY id DESC";
          $result = mysqli_query($conn, $query);
          // Logout button
          echo '<form action="logout.php" method="post">';
          echo '<button type="submit" name="logout" class="btn btn-primary">Logout</button>';
          echo '</form>';
          // Table titles
          echo '<table class="table">';
          echo '<thead>';
          echo '<tr>';
          echo '<th scope="col">Image</th>';
          echo '<th scope="col">Location</th>';
          echo '<th scope="col">Date &amp; time</th>';
          echo '<th scope="col">Description</th>';
          echo '<th scope="col">Scary</th>';
          echo '<th scope="col">Approved</th>';
          echo '<th scope="col">Details</th>';
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
            echo "<td><a href='details.php?id=".encryptId($row['id'])."' class='btn btn-primary'>Details</a></td>";
            echo '</tr>';
          }

        } else {
            echo 'Password is incorrect';
        }; ?>
    </div>
</div>

<?php
require 'footer.php';
?>
