<?php
 session_start();
?>
<?php
session_unset();
session_destroy();
header("location: /Project/index.php?page=login&mod=Student");
?>