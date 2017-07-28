<?php

namespace Model;

use \Framework\Common\Model;
use \Model\Session;

class Usuario extends Model{

    protected $id;
    protected $nome;
    protected $email;
    protected $password;

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }

    public function setNome($nome){
        $this->nome=$nome;
    }
    public function getNome(){
        return $this->nome;
    }

    public function setEmail($email){
        $this->email=$email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password=$password;
    }
    public function getPassword(){
        return $this->$password;
    }

    public function validation(){

        $msg=null;
        if(empty($this->email)) {
            $msg.='Email é obrigatório';
        }
        if(empty($this->password)) {
            $msg.='Senha é obrigatória\n';
        }
         if(empty($this->nome)) {
            $msg.='Nome é obrigatório\n';
        }
        if($msg!=null)
            throw new \Exception($msg,412);
    }

    public function login(){
        $msg=null;
        if(empty($this->email)) {
            $msg.='Email é obrigatório\n';
        }
        if(empty($this->password)) {
            $msg.='Senha é obrigatória\n';
        }
        if($msg!=null)
            throw new \Exception($msg,412);
        
        $sql="select * from usuario where email=:email and password=:password";
        $retorno=$this->query($sql,['email'=>$this->email,'password'=>$this->password]);
        $arry['dados']=$retorno->fetchAll(\PDO::FETCH_ASSOC);
        $count=count($arry['dados']);
        if($count!=0){
            $arry['table']=$this->fieldQuery();//push
            $arry['token']=$this->createToken();
            echo \json_encode($arry);
        }else
            throw new \Exception("Usuario não encontrado", 403);
    }

    public function createUser(){
        
        $this->validation();
        $result['dados'] = $this->pesquisar('email');
        $count=count($result['dados']);
        if($count!=0)
            throw new \Exception('Email já cadastrado', 403);
        //$this->inserir();
        echo \json_encode($result);
    }
}