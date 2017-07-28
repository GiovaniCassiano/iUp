<?php

namespace Model\Traits;

trait ClienteTrait {
    
    private $cnpj;
    private $telefone;

    public function setCPNJ($cnpj){
        $this->cnpj=$cnpj;
    }
    public function getCNPJ(){
        return $this->cnpj;
    }

    public function setTelefone($telefone){
        $this->telefone=$telefone;
    }
    public function getTelefone(){
        return $this->telefone;
    }
}