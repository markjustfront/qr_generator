<?php
require_once 'phpqrcode/qrlib.php';
$filename = 'qrcodes/test.png';
QRcode::png('https://example.com', $filename, QR_ECLEVEL_L, 10);
echo '<img src="' . $filename . '">';
?>