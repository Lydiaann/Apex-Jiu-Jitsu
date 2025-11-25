<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Connection parameters
$host = "localhost";
$port = "5432";
$dbname = "apexforms";
$user = "postgres";
$password = "password"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Build connection string
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

    // Connect to PostgreSQL
    $conn = pg_connect($conn_string);
    if (!$conn) {
        die("Connection failed");
    }

    // Assign values
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $phone     = $_POST['phone'];
    $email     = $_POST['email'];
    $subject   = $_POST['subject'];

    $adultsJiuJitsu = isset($_POST['adultsjiujitsu']) ? true : false;
    $teensJiuJitsu  = isset($_POST['teensjiujitsu']) ? true : false;
    $kidsJiuJitsu   = isset($_POST['kidsjiujitsu']) ? true : false;
    $youngJiuJitsu  = isset($_POST['youngjiujitsu']) ? true : false;
    $MMA             = isset($_POST['mma']) ? true : false;
    $Boxing          = isset($_POST['boxing']) ? true : false;
    $Sombo           = isset($_POST['sombo']) ? true : false;
    $SMS             = isset($_POST['sms']) ? true : false;
    $Marketing       = isset($_POST['marketing']) ? true : false;

    // Prepare SQL
    $query = "INSERT INTO form_submissions 
        (firstname, lastname, phone, email, adultsJiuJitsu, teensJiuJitsu, kidsJiuJitsu, youngJiuJitsu, mma, boxing, sombo, subject, sms, marketing) 
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14)";

    // Execute query
    $result = pg_query_params($conn, $query, [
        $firstname, $lastname, $phone, $email,
        $adultsJiuJitsu, $teensJiuJitsu, $kidsJiuJitsu, $youngJiuJitsu,
        $MMA, $Boxing, $Sombo, $subject, $SMS, $Marketing
    ]);

    if (!$result) {
        // Handle error
        error_log("Database insert failed: " . pg_last_error($conn));
        // Optionally, send an error response
        echo "Error saving data: " . pg_last_error($conn);

    } else {
        // Success, you can send a success message or just exit
        echo "Thank you for signing up! We'll contact you soon.";
    }

    pg_close($conn);
    exit; // important for AJAX
}

?>