<?php

$host = 'localhost';        
$user = 'root';             
$pass = '';                 
$db   = 'ctu';              

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM uploaded_files ORDER BY uploaded_on DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li><a href='download.php?file=" . urlencode($row['file_path']) . "'>" . htmlspecialchars($row['file_name']) . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "No files found.";
}

$conn->close();
?>
