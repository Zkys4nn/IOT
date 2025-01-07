<?php
include "conn.php";
include "cookie.php";
session_start();

if (isset($_COOKIE["username"])) {

    $username = $_COOKIE["username"];
    $sql = "SELECT * FROM absen WHERE nama = ? ORDER BY timestamp DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Attendence</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex flex-wrap sm:px-6 lg:px-8">
        <div class="max-w-7xl w-full pb-6">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Data Absensi</h2>
            <div class="px-4 sm:px-6 lg:px-8 xl:px-12">
                <table class="min-w-full table-auto border-collapse bg-white rounded-lg overflow-hidden shadow-xl">
                    <thead>
                        <tr class="bg-cyan-500 text-white">
                            <th class="px-4 py-4 text-center">NIM</th>
                            <th class="px-4 py-4 text-center">Nama</th>
                            <th class="px-4 py-4 text-center">Absensi</th>
                            <th class="px-4 py-4 text-center">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        <?php while ($data = $result->fetch_assoc()) {

                            $user_id = $data["user_id"];
                            $nama = $data["nama"];
                            $absensi = $data["absensi"];
                            $waktu = $data["timestamp"];
                            ?>
                        <tr class="border-t hover:bg-gray-100 text-sm">
                            <td class="px-4 py-4 text-center"><?php echo $user_id; ?></td>
                            <td class="px-4 py-4 text-center"><?php echo $nama; ?></td>
                            <td class="px-4 py-4 text-center"><?php echo $absensi; ?></td>
                            <td class="px-4 py-4 text-center"><?php echo $waktu; ?></td>
                        </tr>
                        <?php
                        } ?>x
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
} else {
    echo "Pengguna tidak ditemukan. Harap login terlebih dahulu.";
    header("Location: index.php");
    exit();
}
?>
