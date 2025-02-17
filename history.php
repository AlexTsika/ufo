<?php require 'header.php' ?>

<div class="col">
    <h1>Sightings list</h1>

<!--     bootstrap tabel
    query select * from aliens
    foreach van de data
    basic styling -->

    <?php 
    $query = "SELECT * FROM aliens WHERE approved = 1 ORDER BY id DESC";
    // $result = mysqli_query($conn, $query);
    // $results = mysqli_fetch_assoc($result);

    // get result and iterate with while loop
    $result = mysqli_query($conn, $query);
   
/*     Each time when mysqli_fetch_assoc($result) is accessed, the pointer moves to the next record. At last when no records are found, it returns null which breaks the while condition.
 */

    ?>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">Image</th>
      <th scope="col">Location</th>
      <th scope="col">Date & time</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <tbody>
 <?php   
  while ($row = mysqli_fetch_assoc($result)) {
        // $results[] = $row;
        echo '<tr>';
        echo "<td><img src='assets/images/".$row['alienImg']."' width=100px></td>";
        echo '<td>' . $row['location'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo "<td><a href='#' class='btn btn-primary'>Details</a></td>";
        echo '</tr>';
  }
    ?>
    
   
  </tbody>
</table>


</div>

<?php require 'footer.php' ?>