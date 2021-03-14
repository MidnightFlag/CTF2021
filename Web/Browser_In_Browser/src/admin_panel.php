<?php
session_start();
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
    if($_GET['action'] === 's3cr3t4ct10n'){
        if(isset($_GET['cmd'])){
            //I prefer to separate my preg match call as I can see them, yes, I am a beginner with PHP :p
            if(preg_match("/shell_exec/i",$_GET['cmd']) || preg_match("/system/i",$_GET['cmd']) || preg_match("/exec/i",$_GET['cmd'])) die('Unauthorize function.');
            else{
                try{
                    var_dump(eval($_GET['cmd']));
                }catch(ParseError $e){
                    echo("Error in your function call.");
                }
            } 
        }else{
            die('Missing cmd.');
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