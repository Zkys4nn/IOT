<?php

if (isset($_COOKIE["username"])) {
} else {
    $link = "<script>window.open('index.php', '_SELF')</script>";
    echo $link;
}
?>
