<?php
require_once("Controller.php");
require_once("Model/Secret.php");
require_once("Model/SecretDAO.php");

class SaveSecretController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['pseudo'])) header('Location:?page=/');
        else $this->saveSecret();
    }

    public function saveSecret(){
        if(isset($_POST['content'])){
            if(!empty($_POST['content'])){
                $content = htmlspecialchars($_POST['content']);
                if(strlen($content) <= 100){
                    $secret = new Secret();
                    $secret->init($content,htmlspecialchars($_SESSION['pseudo']));
                    SecretDAO::getInstance()->insert($secret);
                    $_SESSION['msg'] = 'Your secret has been stored.';
                }else{
                    $_SESSION['msgE'] = 'Content must be at least 100 characters.';
                }
            }else{
                $_SESSION['msgE'] = "Content can't be empty.";
            }
        }else{
            $_SESSION['msgE'] = 'Missing field : content';
        }
        header("Location:?page=addSecret");
    }
}