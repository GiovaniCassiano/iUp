<?php

namespace Model;

use \Framework\Common\Model;

class Turma extends Model{
    protected $id=null;
    protected $nome=null;

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this-id;
    }

    public function setNome($nome){
        $this->nome=$nome;
    }
    public function getNome(){
        return $this->nome;
    }
}