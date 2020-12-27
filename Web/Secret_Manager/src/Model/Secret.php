<?php
class Secret{
    private $id;
    private $content;
    private $pseudo;

    public function __construct(){}

    public function init($content,$pseudo){
        $this->pseudo = $pseudo;
        $this->content = $content;
    }

    public function getPseudo(){ return $this->pseudo; }

    public function getId(){ return $this->id; }

    public function getContent(){ return $this->content; }

}