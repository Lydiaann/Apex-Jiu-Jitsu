<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Connection parameters
$host = "localhost";
$port = "5432";
$dbname = "apexforms";
$user = "user";
$password = "pass"; 

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

    $adultsJiuJitsu = isset($_POST['adultsJiuJitsu']) ? true : false;
    $teensJiuJitsu  = isset($_POST['teensJiuJitsu']) ? true : false;
    $kidsJiuJitsu   = isset($_POST['kidsJiuJitsu']) ? true : false;
    $youngJiuJitsu  = isset($_POST['youngJiuJitsu']) ? true : false;
    $MMA             = isset($_POST['MMA']) ? true : false;
    $Boxing          = isset($_POST['Boxing']) ? true : false;
    $Sombo           = isset($_POST['Sombo']) ? true : false;
    $SMS             = isset($_POST['SMS']) ? true : false;
    $Marketing       = isset($_POST['Marketing']) ? true : false;

    // Prepare SQL
    $query = "INSERT INTO form_submissions 
        (firstname, lastname, phone, email, adultsJiuJitsu, teensJiuJitsu, kidsJiuJitsu, youngJiuJitsu, MMA, Boxing, Sombo, subject, SMS, Marketing) 
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
        echo "Error saving data.";
    } else {
        // Success, you can send a success message or just exit
        echo "Submission successful.";
    }

    pg_close($conn);
    exit; // important for AJAX
}


if (!$conn) {
    die("Connection failed");
}

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>