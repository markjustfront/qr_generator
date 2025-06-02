<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once 'phpqrcode/qrlib.php';

$qrDir = 'qrcodes/';
if (!is_dir($qrDir)) {
    if (!mkdir($qrDir, 0777, true)) {
        echo json_encode(['success' => false, 'error' => 'Failed to create qrcodes directory']);
        exit;
    }
}

$text = isset($_POST['text']) ? $_POST['text'] : '';

if (empty($text)) {
    echo json_encode(['success' => false, 'error' => 'No text provided']);
    exit;
}

$filename = $qrDir . uniqid() . '.png';

try {
    QRcode::png($text, $filename, QR_ECLEVEL_L, 10);
    if (file_exists($filename)) {
        echo json_encode(['success' => true, 'image' => $filename]);
    } else {
        echo json_encode(['success' => false, 'error' => 'QR code file not created']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
}
?>