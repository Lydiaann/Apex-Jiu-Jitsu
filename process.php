<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // PostgreSQL connection
   

    if (!$conn) {
        die("DB connection failed: " . pg_last_error());
    }

    // Text inputs
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $email     = $_POST['email'] ?? '';
    $subject   = $_POST['subject'] ?? '';

    // Checkbox booleans — MUST match column names exactly
    $adultsJiuJitsu  = isset($_POST['adultsjiujitsu']) ? 't' : 'f';
    $teensJiuJitsu   = isset($_POST['teensjiujitsu']) ? 't' : 'f';
    $kidsJiuJitsu    = isset($_POST['kidsjiujitsu']) ? 't' : 'f';
    $youngJiuJitsu   = isset($_POST['youngjiujitsu']) ? 't' : 'f';
    $mma             = isset($_POST['mma']) ? 't' : 'f';
    $boxing          = isset($_POST['boxing']) ? 't' : 'f';
    $sombo           = isset($_POST['sombo']) ? 't' : 'f';
    $sms             = isset($_POST['sms']) ? 't' : 'f';
    $marketing       = isset($_POST['marketing']) ? 't' : 'f';


    // SQL insert (same column order as your DB)
    $sql = "
        INSERT INTO form_submissions
        (firstname, lastname, phone, email,
         adultsjiujitsu, teensjiujitsu, kidsjiujitsu, youngjiujitsu,
         mma, boxing, sombo,
         sms, marketing,
         subject)
        VALUES
        ($1,$2,$3,$4,
         $5,$6,$7,$8,
         $9,$10,$11,
         $12,$13,
         $14)
    ";

    $params = [
        $firstname,
        $lastname,
        $phone,
        $email,
        $adultsJiuJitsu,
        $teensJiuJitsu,
        $kidsJiuJitsu,
        $youngJiuJitsu,
        $mma,
        $boxing,
        $sombo,
        $sms,
        $marketing,
        $subject
    ];

    $result = pg_query_params($conn, $sql, $params);

    if ($result) {
        echo "Form submitted successfully!";
    } else {
        echo "Error saving data: " . pg_last_error($conn);
    }
}
?>
