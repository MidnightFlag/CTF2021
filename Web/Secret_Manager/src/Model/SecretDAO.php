<?php
require_once('Secret.php');
require_once('SqlConnection.php');

class SecretDAO
{
    private static $dao;

    private function __construct(){}


    public final static function getInstance(){
        if(!isset(self::$dao)){
            self::$dao = new SecretDAO();
        }
        return self::$dao;
    }

    public final function insert($secret)
    {
        if($secret instanceof Secret){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("INSERT INTO secret(id, content, pseudo) VALUES(0, :content, :pseudo)");
            $sth->bindValue(':pseudo', $secret->getPseudo());
            $sth->bindValue(':content', $secret->getContent());
            $sth->execute();
        }
    }

    public final function findAll(){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM secret");
        $sth->execute();
        $secrets = array();
        while($secret = $sth->fetchObject(Secret::class)) {
            $secrets[] = $secret;
        }
        return $secrets;
    }

    public final function findSecretOfUser($pseudo){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM secret WHERE pseudo = :pseudo");
        $sth->bindValue(':pseudo',$pseudo);
        $sth->execute();
        $secrets = array();
        while($secret = $sth->fetchObject(Secret::class)) {
            $secrets[] = $secret;
        }
        return $secrets;
    }

    public final function findOneSecret($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM secret WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
        return $sth->fetchObject(Secret::class);
    }

    public final function modifySecret($id,$content){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("UPDATE secret SET content = :content WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->bindValue(':content',$content);
        $sth->execute();
    }

    public final function deleteSecret($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("DELETE FROM secret WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
    }
}
?>