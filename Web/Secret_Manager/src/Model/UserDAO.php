<?php
require_once('User.php');
require_once('SqlConnection.php');

class UserDAO
{
    private static $dao;

    /**
     * UserDAO constructor of UserDAO
     */
    private function __construct(){}


    /**
     * @return UserDAO Instance of UserDAO (pattern used: Singleton)
     */
    public final static function getInstance(){
        if(!isset(self::$dao)){
            self::$dao = new UserDAO();
        }
        return self::$dao;
    }

    /**
     * Ajoute un utilisateur à la base de données
     * @param $user l'utilisateur à ajouter à la base de données
     */
    public final function insert($user)
    {
        if($user instanceof User){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("INSERT INTO users(pseudo) VALUES(:pseudo)");
            $sth->bindValue(':pseudo', $user->getPseudo());
            $sth->execute();
        }
    }

    public final function findAll(){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM users");
        $sth->execute();
        $users = array();
        while($user = $sth->fetchObject(User::class)) {
            $users[] = $user;
        }
        return $users;
    }
}
?>