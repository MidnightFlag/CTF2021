<?php
class User{
    private $pseudo;

    /**
     * User constructor.of User
     */
    public function __construct(){}

    /**
     * @param $name string nom de l'abonné
     * @param $mail string mail de l'abonné
     * @param $password string mot de passe de l'abonné
     * @param $sexe string le sexe de l'abonné
     * @param $ville string la ville de la sentinelle
     * Cette fonction permet de créer un User pour ensuite l'insérer / actualiser ses données dans la base.
     */
    public function init($pseudo){
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed Return le nom du User
     */
    public function getPseudo(){ return $this->pseudo; }

}