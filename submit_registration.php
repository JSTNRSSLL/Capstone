<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "dbcapstone";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // File upload handling
    $valid_id_path = "path_to_upload_directory/"; // Change this to your actual file upload path
    $valid_id_filename = $_FILES['valid_id']['name'];

    // Move the uploaded file to the server
    move_uploaded_file($_FILES['valid_id']['tmp_name'], $valid_id_path . $valid_id_filename);

    // SQL query to insert data into the database
    $sql = "INSERT INTO users (first_name, last_name, address, birthday, gender, contact_number, email, password, valid_id_filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name, $last_name, $address, $birthday, $gender, $contact_number, $email, $password, $valid_id_filename);

    // Execute the query
    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Registration failed: " . $stmt->error;
    }

    // Close the database connection
    $conn->close();
}
?>
