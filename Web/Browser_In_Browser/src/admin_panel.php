<?php
session_start();
//MCTF{ssrf_t0_4cc3ss_4dm1n_p4rt}
if($_SERVER['REMOTE_ADDR'] !== "127.0.0.1"){
    die("<!DOCTYPE html><html><head><title>Unauthorize</title></head><body><h1>403 Forbidden.</h1></body></html>");
}
if(!isset($_GET['action'])){
    var_dump($_GET); die();
    die("Missing action.<br>Available action are: viewUsers, viewFile, ...");
}else{
    if($_GET['action'] === 'viewUsers') die('Database not implemented.<br>Only one user: guest with password guest.');
    if($_GET['action'] === 'viewFile'){
        if(isset($_GET['file'])){
            include($_GET['file'].".php");
        }else{
            die('Missing file.');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin panel 1.0</title>
</head>
<body></body>
</html>