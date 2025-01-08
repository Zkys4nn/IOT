<?php
use PhpMqtt\Client\MqttClient;
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
