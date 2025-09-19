<?php
// Connection parameters
$host = "localhost";          // or your server IP
$port = "5432";               // default PostgreSQL port
$dbname = "apexforms";       // your database name
$user = "Lydia";           // your PostgreSQL username
$password = "Password";   // your PostgreSQL password


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Database connection
    $conn = pg_connect("host=localhost port=5432 dbname=apex_forms user=Lydia password=Password");
    if (!$conn) { exit; }

    // Assign values
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $phone     = $_POST['phone'];
    $email     = $_POST['email'];
    $subject   = $_POST['subject'];

    $adultsJiuJitsu = isset($_POST['adultsJiuJitsu']) ? true : false;
    $teensJiuJitsu  = isset($_POST['teensJiuJitsu']) ? true : false;
    $kidsJiuJitsu   = isset($_POST['kidsJiuJitsu']) ? true : false;
    $youngJiuJitsu  = isset($_POST['youngJiuJitsu']) ? true : false;
    $MMA             = isset($_POST['MMA']) ? true : false;
    $Boxing          = isset($_POST['Boxing']) ? true : false;
    $Sombo           = isset($_POST['Sombo']) ? true : false;
    $SMS             = isset($_POST['SMS']) ? true : false;
    $Marketing       = isset($_POST['Marketing']) ? true : false;

    $query = "INSERT INTO form_submissions 
        (firstname, lastname, phone, email, adultsJiuJitsu, teensJiuJitsu, kidsJiuJitsu, youngJiuJitsu, MMA, Boxing, Sombo, subject, SMS, Marketing) 
        VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)";

    pg_query_params($conn, $query, [
        $firstname, $lastname, $phone, $email,
        $adultsJiuJitsu, $teensJiuJitsu, $kidsJiuJitsu, $youngJiuJitsu,
        $MMA, $Boxing, $Sombo, $subject, $SMS, $Marketing
    ]);

    pg_close($conn);
    exit; // important for AJAX
}
?>
