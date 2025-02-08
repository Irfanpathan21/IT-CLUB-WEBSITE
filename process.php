<?php
// Database configuration
$db_host = 'localhost';  // Change this according to your hosting
$db_user = 'root';  // Change this
$db_pass = '';  // Change this
$db_name = 'it_club';

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
$interest_area = $conn->real_escape_string($_POST['interest_area']);

    // Prepare SQL statement
    $sql = "INSERT INTO members (name, email, phone, interest_area) VALUES (?, ?, ?, ?)";
    
    // Create prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $name, $email, $phone, $interest_area);

        // Execute statement and handle response
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful! We will contact you soon.');
                    window.location.href = 'index.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Registration failed. Please try again.');
                    window.location.href = 'index.html';
                  </script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>
                alert('Error: Unable to prepare statement.');
                window.location.href = 'index.html';
              </script>";
    }

    // Close connection
    $conn->close();
}
?>
