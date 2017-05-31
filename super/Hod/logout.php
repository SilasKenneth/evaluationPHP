<?php
 session_start();
?>
<?php
session_unset();
session_destroy();
header("location: /Project/super/index.php?page=login&mod=Hod");
?>