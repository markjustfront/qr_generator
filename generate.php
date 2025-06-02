<?php
header('Content-Type: application/json');
require_once 'phpqrcode/qrlib.php';

$qrDir = 'qrcodes/';
if (!is_dir($qrDir)) {
    mkdir($qrDir, 0777, true);
}

$text = isset($_POST['text']) ? $_POST['text'] : '';

if (empty($text)) {
    echo json_encode(['success' => false, 'error' => 'No text provided']);
    exit;
}

$filename = $qrDir . uniqid() . '.png';
QRcode::png($text, $filename, QR_ECLEVEL_L, 10);

if (file_exists($filename)) {
    echo json_encode(['success' => true, 'image' => $filename]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to generate QR code']);
}
?>