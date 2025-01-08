<?php include "cookie.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <link rel="icon" href="assets/logo.png" sizes="32x32" type="image/png">
    <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center py-6">
        <div class="max-w-sm w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-cyan-500 text-white p-4 text-center font-semibold text-sm">Scan QR Code to do Attendance</div>
            <div class="p-4">
                <div id="reader" class="mx-auto rounded-xl text-lg" style="width: 100%; max-width: 300px;"></div>
                <p class="text-center text-gray-700 text-sm mt-4">Scan your QR code to proceed</p>
            </div>
        </div>
        <div class="mt-6 text-center">
            <a href="view.php" class="inline-block px-6 py-3 bg-cyan-500 text-white font-semibold rounded-lg shadow-md hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Check Your Attendance
            </a>
        </div>
        <div class="mt-4 text-center">
            <button
                onclick="resetPage()"
                class="inline-block px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                Reset Page
            </button>
        </div>
    </div>

    <script type="text/javascript">
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);

        html5QrcodeScanner.clear();

        fetch('check_token.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'qrCode=' + encodeURIComponent(decodedText)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.success) {
                swal({
                    title: "Success Attendance!",
                    text: data.message,
                    icon: "success",
                    button: "OK",
                    customClass: {
                      title: 'text-2xl font-bold',
                      htmlContainer: 'text-md',
                    }
                }).then(() => {
                    window.location.href = "generate.php";
                });
            } else {\\
                swal({
                    title: "Invalid QR Code",
                    text: data.message,
                    icon: "error",
                    button: "OK",
                    customClass: {
                      title: 'text-xl font-bold',
                      htmlContainer: 'text-md',
                    }
                });

            }
        })
        .catch(error => {
            console.error('Error:', error);
            swal({
                title: "Error",
                text: "Failed to communicate with the server. Please try again.",
                icon: "error",
                button: "OK",
                customClass: {
                  title: 'text-2xl font-bold',
                  htmlContainer: 'text-md',
                }
            });
            scanCompleted = true;
        });
    }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 15, qrbox: 225 });
        html5QrcodeScanner.render(onScanSuccess);

        function resetPage() {
            location.reload();
        }
    </script>



</body>
</html>
