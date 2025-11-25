<?php
// CONNECT TO POSTGRES
$host = "localhost";
$port = "5432";
$dbname = "apexforms";
$user = "lydia";
$pass = "password";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    die("Database connection failed.");
}

// FORM FIELDS
$name = $_POST['name'];
$email = $_POST['email'];
$category = $_POST['category'];
$message = $_POST['message'];

// HANDLE IMAGE UPLOAD
$uploadPath = "uploads/";
if (!file_exists($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

$screenshotName = NULL;

if (!empty($_FILES["screenshot"]["name"])) {
    $fileName = time() . "_" . basename($_FILES["screenshot"]["name"]);
    $targetFile = $uploadPath . $fileName;

    if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $targetFile)) {
        $screenshotName = $fileName;
    }
}

// INSERT INTO DATABASE
$query = "INSERT INTO feedback (name, email, category, message, screenshot)
          VALUES ($1, $2, $3, $4, $5)";

$result = pg_query_params($conn, $query, array(
    $name,
    $email,
    $category,
    $message,
    $screenshotName
));

if ($result) {
    echo "Success! Your feedback was saved.";
} else {
    echo "Error saving feedback.";
}
?>
