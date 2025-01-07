<?php
include "conn.php";

$alertMessage = "";
$alertType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["txtUserId"] ?? "";
    $password = $_POST["txtPassword"] ?? "";

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ? AND password = ?"
    );
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        setcookie("username", $username, time() + 3000);
        $alertMessage = "Login berhasil! Redirecting...";
        $alertType = "success";
        $redirect = "view.php";
    } else {
        $alertMessage = "Username atau Password salah!";
        $alertType = "error";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="icon" href="assets/logo.png" sizes="32x32" type="image/png">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100 h-screen -mt-12 flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <form action="" method="POST">
            <h2 class="text-2xl font-semibold mb-6 text-center">Login</h2>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="txtUserId" placeholder="Enter your username"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="txtPassword" placeholder="Enter your password"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit"
                class="w-full py-2 bg-cyan-500 text-white font-semibold rounded-lg hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Submit
            </button>
        </form>
    </div>

    <?php if (!empty($alertMessage)): ?>
    <script>
        swal({
            title: "<?php echo $alertType === "success"
                ? "Success"
                : "Error"; ?>",
            text: "<?php echo $alertMessage; ?>",
            icon: "<?php echo $alertType; ?>",
            button: false,
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            window.location.href = "<?php echo $redirect ??
                $_SERVER["PHP_SELF"]; ?>";
        });
    </script>

    <?php endif; ?>

</body>
</html>
