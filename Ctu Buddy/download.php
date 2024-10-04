<?php
// Get file name from URL
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Define the upload directory
$filePath = 'uploads/' . $file;

if (!empty($file) && file_exists($filePath)) {
    // Set headers to initiate file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} else {
    echo 'File not found.';
}
?>
