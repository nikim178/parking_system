<?php
setcookie("c_verified_phone", "", 1, "/");
setcookie("c_verified_phone_number", "", 1, "/");
setcookie("c_verified_phone_timestamp", "", 1, "/");
setcookie("cst_id", "", 1, "/");

echo "<script>
    window.location.href = 'index.php';
</script>";
?>