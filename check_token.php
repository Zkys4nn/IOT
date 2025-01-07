<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();
include "conn.php";

$uname = $_COOKIE["username"] ?? null;

if ($uname) {
    if (isset($_POST["qrCode"]) && !empty($_POST["qrCode"])) {
        $qrData = $_POST["qrCode"];

        $stmt = $conn->prepare("SELECT token FROM tokens WHERE token = ?");
        $stmt->bind_param("s", $qrData);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // $sql = "";
            $stmt = $conn->prepare(
                "SELECT user_id FROM users WHERE username = ?"
            );
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($uid);
                $stmt->fetch();

                $absensi = "hadir";
                $stmt = $conn->prepare(
                    "INSERT INTO absen (user_id, nama, absensi) VALUES (?, ?, ?)"
                );
                $stmt->bind_param("iss", $uid, $uname, $absensi);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $stmt = $conn->prepare(
                        "DELETE FROM tokens WHERE token = ?"
                    );
                    $stmt->bind_param("s", $qrData);
                    $stmt->execute();
                    $stmt->store_result();
                    echo json_encode([
                        "success" => true,
                        "message" => "Absen berhasil dicatat.",
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Gagal mencatat absensi.",
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Pengguna tidak ditemukan.",
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Gunakan QR Code yang benar!",
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Server tidak menerima QR Code.",
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Pengguna tidak ditemukan.",
    ]);
}
?>
