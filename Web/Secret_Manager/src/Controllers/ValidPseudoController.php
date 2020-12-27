<?php
require_once("Controller.php");
require_once("Model/User.php");
require_once("Model/UserDAO.php");
class ValidPseudoController implements Controller
{
    public function handle($request)
    {
        if (isset($_SESSION['pseudo'])) header('Location:?page=secret');
        else $this->validPseudo();
    }

    public function validPseudo(){
        if(isset($_POST['pseudo'])){
            if(!empty($_POST['pseudo'])){
                $allUsers = UserDAO::getInstance()->findAll();
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $isUnique = True;
                foreach($allUsers as $user){
                    if($user->getPseudo() === $pseudo){
                        $isUnique = False;
                        break;
                    }
                }
                if($isUnique === True){
                    $user = new User();
                    $user->init($pseudo);
                    UserDAO::getInstance()->insert($user);
                    $_SESSION['pseudo'] = $pseudo;
                    header("Location:?page=home");
                }else{
                    $_SESSION['msgE'] = "This pseudo is already taken, please choose another one.";
                    header("Location:?page=/");
                }
            }else{
                $_SESSION['msgE'] = 'Please provide a pseudo.';
                header("Location:?page=/");
            }
        }else{
            $_SESSION['msgE'] = 'Missing field : pseudo';
            header("Location:?page=/");
        }
    }
}
