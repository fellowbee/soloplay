<?php
session_start();
session_unset();
session_destroy();

header('Location: login.php?message=User%20logged%20out%20successfully');
exit();
?>
