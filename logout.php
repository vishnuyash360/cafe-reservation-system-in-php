<?php
session_start();
session_destroy();
header("Location: p1.html");
exit;
?>