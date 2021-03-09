<?php
session_start();
if($_SERVER['REMOTE_ADDR'] === "127.0.0.1"){
    include("./t3mpl4t3sf0rth3w1n/admin.php");
}else{
    include("./t3mpl4t3sf0rth3w1n/users.php");
}
?>