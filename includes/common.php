<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

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

  // encrypt id
  function encrypt_id($id) {
    $id_encrypted = openssl_encrypt($id, 'AES-256-CBC', 'my-secret-key');
    return $id_encrypted;
  }

  //decrypt id
  function decrypt_id($id_encrypted) {
    $id_decrypted = openssl_decrypt($id_encrypted, 'AES-256-CBC', 'my-secret-key');
    return intval($id_decrypted);
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