<?php
require "vendor/autoload.php";

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

$writer = new PngWriter();
$randomString = bin2hex(random_bytes(16));
$qrCodeData = $randomString;
$_SESSION["qrCodeData"] = $qrCodeData;

$qrCode = new QrCode(
    data: $qrCodeData,
    encoding: new Encoding("UTF-8"),
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    foregroundColor: new Color(0, 0, 0),
    backgroundColor: new Color(255, 255, 255)
);

$logo = new Logo(
    path: __DIR__ . "/assets/logo.png",
    resizeToWidth: 20,
    punchoutBackground: true
);

$label = new Label(text: "Label", textColor: new Color(255, 0, 0));
$result = $writer->write($qrCode, $logo, $label);
$dataUri = $result->getDataUri();

include "conn.php";

$stmt = $conn->prepare("INSERT INTO tokens (token) VALUES (?)");
$stmt->bind_param("s", $qrCodeData);
$stmt->execute();
$stmt->close();

include "mqtt_conn.php";
?>

<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "view.php";
    }, 20);
</script>
