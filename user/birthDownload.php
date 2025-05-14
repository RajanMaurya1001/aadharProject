<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $baseDir = realpath('assets/certificates');
    $fullPath = realpath($file);

    if ($fullPath && strpos($fullPath, $baseDir) === 0 && file_exists($fullPath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);
        exit;
    } else {
        echo "File not found or access denied.";
    }
} else {
    echo "No file specified.";
}
