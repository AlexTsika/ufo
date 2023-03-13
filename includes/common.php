<?php
  require 'vendor/autoload.php';
  use Dompdf\Dompdf;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  $host = 'ID324796_ufo.db.webhosting.be';
  $user = 'ID324796_ufo';
  $database = 'ID324796_ufo';
  $password = 'm1i4q9ov7moVfpZ01b88';
  $baseurl = 'http://localhost:8000/';
  $key = '1234567890';

  // Create connection
  $conn = new mysqli($host, $user, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  function sanitizeInput ($input){
      $input = trim($input);
      $input = stripslashes($input);
      $input = htmlspecialchars($input);
      return $input;
  }

  function getAge($birthDate){
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthDate));
    return $diff->y;
  }

  function calculateDiscount($price, $discountPercentage) {
      $discountAmount = $price * ($discountPercentage / 100);
      $discountPrice = $price - $discountAmount;
      return $discountPrice;
  }

  function getDateInDutch() {
      $months = array(
        1 => 'januari',
        2 => 'februari',
        3 => 'maart',
        4 => 'april',
        5 => 'mei',
        6 => 'juni',
        7 => 'juli',
        8 => 'augustus',
        9 => 'september',
        10 => 'oktober',
        11 => 'november',
        12 => 'december'
      );
    
      $daysOfWeek = array(
        'zondag',
        'maandag',
        'dinsdag',
        'woensdag',
        'donderdag',
        'vrijdag',
        'zaterdag'
      );
    
      $month = $months[date('n')];
      $dayOfWeek = $daysOfWeek[date('w')];
      $dayOfMonth = date('j');
      $year = date('Y');
    
      return "$dayOfWeek $dayOfMonth $month $year";
    }

    function formatNumber($number, $decimalPlaces = 2, $thousandsSeparator = ',') {
      $formattedNumber = number_format($number, $decimalPlaces, '.', $thousandsSeparator);
      return $formattedNumber;
    }

    function generateRandomString($length) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $result = '';
      for ($i = 0; $i < $length; $i++) {
        $result .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $result;
    }

    // create a function to format the date from 2023-01-01 to 01-01-2023
    function formatDate($date) {
      $date = explode('-', $date);
      $date = array_reverse($date);
      $date = implode('-', $date);
      return $date;
    }

    function encryptId ($id) {
      $id = base64_encode($id);
      // replace the = char to prevent errors
      $id = str_replace('=', '', $id);
      $id = strrev($id);
      return $id;
    }

    function decryptId ($id) {
      $id = strrev($id);
      $id = base64_decode($id);
      return $id;
    }


  function generatePDF($html) {
      // instantiate and use the dompdf class
      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);

      // (Optional) Setup the paper size and orientation
      $dompdf->setPaper('A4', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      // Output the generated PDF to Browser
      // $dompdf->stream();

      // Save the PDF to a file with a radom name
      $output = $dompdf->output();
      $filenamepdf = 'assets/pdf/' . generateRandomString(16) . '.pdf';
      file_put_contents($filenamepdf, $output);

      // Return the path to the saved PDF file
      return $filenamepdf;
  }

  function getFullUrl() {
      $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
      $host = $_SERVER['HTTP_HOST'];
      return $protocol . '://' . $host;
  }

  function sendSMTP($email, $subject, $message) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
      //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
      $mail->isSMTP();
      $mail->Host       = '0.0.0.0';
      $mail->SMTPAuth   = false;
      $mail->SMTPAutoTLS = false;
      $mail->Port       = 1025;

      //Recipients
      $mail->setFrom('info@spacespy.com', 'SpaceSpy');
      $mail->addAddress($email);     // Add a recipient
      $mail->addBCC('info@spacespy.com', 'SpaceSpy');

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message;

      $mail->send();

    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


  }

  class User {
    private $id;
    public $username;
    private $email;
    private $password;
    private $conn;
    // private $conn = new mysqli('ID324796_ufo.db.webhosting.be', 'ID324796_ufo', 'm1i4q9ov7moVfpZ01b88', 'ID324796_ufo');
    // instantiate a database connection string


    public function __construct($username = null, $password = null) {
    
      $this->username = $username;
      $this->password = $password;
      $this->conn = new mysqli('ID324796_ufo.db.webhosting.be', 'ID324796_ufo', 'm1i4q9ov7moVfpZ01b88', 'ID324796_ufo');
    }


    public function checkPassword () {
      $query = "SELECT * FROM users WHERE name = '$this->username'";
      $result = mysqli_query($this->conn, $query);
      $user = mysqli_fetch_assoc($result);
      $password = $user['password'];
      if (password_verify($this->password, $password)) {
        return true;
      } else {
        return false;
      }
    }

  }
?>