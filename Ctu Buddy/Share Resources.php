<?php
// Database configuration
$host = 'localhost';
$user ='root';
$pass = '';
$db ='ctu';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = basename($_FILES['file']['name']);
        $uploadDir = 'uploads/';

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uniqueFileName = uniqid() . '-' . $fileName;
        $destPath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Insert file info into the database
            $stmt = $conn->prepare("INSERT INTO uploaded_files (file_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $fileName, $uniqueFileName);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "file_name" => $uniqueFileName]);
            } else {
                // Log database error
                error_log("Database error: " . $stmt->error);
                echo json_encode(["status" => "error", "message" => "Database error."]);
            }
            $stmt->close();
        } else {
            // Log file moving error
            error_log("Failed to move uploaded file: $fileName");
            echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
        }
    } else {
        // Log upload error
        error_log("Upload error: " . $_FILES['file']['error']);
        echo json_encode(["status" => "error", "message" => "No file uploaded or there was an upload error."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
