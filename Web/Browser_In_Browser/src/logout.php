<?php
session_start();
session_destroy();
header("Location:./login.php?redirect=./index.php");
?>