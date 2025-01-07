<?php
require "vendor/autoload.php";
use PhpMqtt\Client\MqttClient;
include "conn.php";

$randomString = bin2hex(random_bytes(16));
$qrCodeData = $randomString;
$_SESSION["qrCodeData"] = $qrCodeData;

$stmt = $conn->prepare("INSERT INTO tokens (token) VALUES (?)");
$stmt->bind_param("s", $qrCodeData);
$stmt->execute();
$stmt->close();

$mqttServer = "localhost";
$mqttPort = 1884;
$mqttTopic = "esp/topic";
$message = $qrCodeData;

try {
    $mqtt = new MqttClient($mqttServer, $mqttPort, "PHP_Client");
    $mqtt->connect();
    $mqtt->publish($mqttTopic, $message, 0);
    $mqtt->disconnect();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "view.php";
    }, 20);
</script>
