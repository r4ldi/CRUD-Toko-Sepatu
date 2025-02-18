<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "";     // Replace with your DB password
$dbname = "db_merdekabb"; // Your database name

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form data if POST request is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    // Prepare the SQL statement to insert data into 'kontak' table
    $stmt = $conn->prepare("INSERT INTO kontak (nama, email, pesan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $pesan);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Pesan Anda telah berhasil dikirim!";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
