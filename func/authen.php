<?php
function checkRoles($Roles) {

    if (!isset($_SESSION["user_id"]))  
    {
        ?>
            <script>
                alert("เข้าสู่ระบบผิดพลาด โปรดลงชื่อเข้าใช้งานอีกครั้ง");
            </script>
        <meta http-equiv="refresh" content="0; url=../login.html" />
        <?php

    } else {
        if (strpos($Roles, $_SESSION["user_id"]) === FALSE) {
            ?>
            <script>
                alert("เข้าสู่ระบบผิดพลาด โปรดลงชื่อเข้าใช้งานอีกครั้ง");
            </script>
            <meta http-equiv="refresh" content="0; url=../login.html" />" />
            <?php

        }
 
    }
}
?>