<?php
require_once("Model/SecretDAO.php");
require_once("Controller.php");

class ModifySecretController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['pseudo'])) header('Location:?page=/');
        else{
            if(isset($_POST['action']) && !empty($_POST['action'])){
                if(htmlspecialchars($_POST['action']) === "modify") $this->modifySecret();
                else{
                    if(htmlspecialchars($_POST['action']) === "delete") $this->deleteSecret();
                }
            }else header("Location:?page=manageSecrets");
        }
    }

    public function modifySecret(){
        if(isset($_POST['content']) && isset($_POST['idSecret'])){
            if(!empty($_POST['content']) && !empty($_POST['idSecret'])){
                $content = htmlspecialchars($_POST['content']);
                $id = htmlspecialchars($_POST['idSecret']);
                $allSecrets = SecretDAO::getInstance()->findSecretOfUser(htmlspecialchars($_SESSION['pseudo']));
                $isOwnedByUser = False;
                foreach($allSecrets as $secret){
                    if($secret->getId() === $id){
                        $isOwnedByUser = True;
                        break;
                    }
                }
                if($isOwnedByUser === True){
                    if(strlen($content) <= 100){
                        SecretDAO::getInstance()->modifySecret($id,$content);
                        $_SESSION['msg'] = 'Your secret has been modified.';
                        $_SESSION['currentSecretId'] = $id;
                    }else $_SESSION['msgE'] = 'Content must be at least 100 characters.';
                }else $_SESSION['msgE'] = 'You don\'t own this secret. Get out.';
            }else{
                $_SESSION['msgE'] = 'A field can\'t be empty.';
            }
        }else $_SESSION['msgE'] = 'Missing field.';
        header("Location:?page=manageOneSecret");
    }

    public function deleteSecret(){
        if(isset($_POST['idSecret'])){
            if(!empty($_POST['idSecret'])){
                $id = htmlspecialchars($_POST['idSecret']);
                $allSecrets = SecretDAO::getInstance()->findSecretOfUser(htmlspecialchars($_SESSION['pseudo']));
                $isOwnedByUser = False;
                foreach($allSecrets as $secret){
                    if($secret->getId() === $id){
                        $isOwnedByUser = True;
                        break;
                    }
                }
                if($isOwnedByUser === True){
                    if(strlen($content) <= 100){
                        SecretDAO::getInstance()->deleteSecret($id);
                        header("Location:?page=manageSecrets");
                        die();
                    }else $_SESSION['msgE'] = 'Content must be at least 100 characters.';
                }else $_SESSION['msgE'] = 'You don\'t own this secret. Get out.';
            }else{
                $_SESSION['msgE'] = 'A field can\'t be empty.';
            }
        }else $_SESSION['msgE'] = 'Missing field.';
        header("Location:?page=manageOneSecret");
    }
} 