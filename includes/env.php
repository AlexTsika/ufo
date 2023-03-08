<?php
    $host = 'ID324796_ufo.db.webhosting.be';
    $user = 'ID324796_ufo';
    $database = 'ID324796_ufo';
    $password = 'm1i4q9ov7moVfpZ01b88';

    // Create connection
    $conn = new mysqli($host, $user, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>