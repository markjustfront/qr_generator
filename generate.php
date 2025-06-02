<?php
header('Content-Type: application/json');

// Include the phpqrcode library
require_once 'phpqrcode/qrlib.php';

// Directory to store QR codes
$qrDir = 'qrcodes/';
if (!is_dir($qrDir)) {
    mkdir($qrDir, 0777, true);
}

// Get input text
$text = isset($_POST['text']) ? $_POST['text'] : '';

if (empty($text)) {
    echo json_encode(['success' => false, 'error' => 'No text provided']);
    exit;
}

// Generate unique filename
$filename = $qrDir . uniqid() . '.png';

// Generate QR code
QRcode::png($text, $filename, QR_ECLEVEL_L, 10);

if (file_exists($filename)) {
    echo json_encode(['success' => true, 'image' => $filename]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to generate QR code']);
}
?>