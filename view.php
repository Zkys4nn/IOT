<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="icon" href="assets/logo.png" sizes="32x32" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="css/toggle.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="absolute right-16 flex items-center">
        <input type="checkbox" class="openSidebarMenu hidden" id="openSidebarMenu">
        <label for="openSidebarMenu" class="sidebarIconToggle">
            <div class="spinner diagonal part-1"></div>
            <div class="spinner horizontal"></div>
            <div class="spinner diagonal part-2"></div>
        </label>
    </div>
    <header class="bg-cyan-500 fixed top-0 left-0 w-full z-10">
      <div class="mx-auto px-4 sm:px-6 lg:px-8 shadow-lg">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
          <img class="flex-wrap size-12" src="assets/logo.png" alt="Logo Website" width="150">
            <a href="#" class="text-lg font-bold text-white">Attendence</a>
          </div>
      </div>
    </header>
    <div id="sidebar" class="fixed rounded-lg top-0 right-0 w-36 h-40 bg-cyan-500 text-white transform -translate-y-full transition-transform duration-500 ease-in-out shadow-lg">
        <ul class="mt-20">
            <!-- <li><div class="block w-36 h-1 bg-cyan-600 -mt-4 shadow-lg blur-sm"></li> -->
            <!-- <li><div class="mt-4"></li> -->
            <li><a href="javascript:void(0);" class="block py-2 px-6 hover:bg-cyan-600 rounded-xl" onclick="confirmScan()">Scan QR Code</a></li>
            <li><a href="javascript:void(0);" class="block py-2 px-6 hover:bg-cyan-600 rounded-xl" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </div>
    <div class="mt-24"></div>
    <?php include "read_data.php"; ?>

    <script>
    const menuCheckbox = document.getElementById("openSidebarMenu");
    const sidebar = document.getElementById("sidebar");

    menuCheckbox.addEventListener("change", () => {
        if (menuCheckbox.checked) {
            sidebar.classList.remove("-translate-y-full");
        } else {
            sidebar.classList.add("-translate-y-full");
        }
    });

    function confirmLogout() {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Logout',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
          title: 'text-2xl font-bold',
          htmlContainer: 'text-md',
          confirmButton: 'bg-red-500 text-white hover:bg-red-600',
          cancelButton: 'bg-gray-300 text-black hover:bg-gray-400'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php';
        }
      });
    }

    function confirmScan() {
      Swal.fire({
        title: 'Scan QRCode?',
        text: 'Scan QRCode to do Attendance',
        // textSize: ,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Scan QRCode',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
          title: 'text-2xl font-bold',
          htmlContainer: 'text-md',
          confirmButton: 'bg-cyan-500 text-white hover:bg-cyan-600',
          cancelButton: 'bg-gray-300 text-black hover:bg-gray-400'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'scan_qrcode.php';
        }
      });
    }
    </script>
</body>
</html>
