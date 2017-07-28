<?php
namespace Controller;

use \Config\Conexao;
use \Model\TurmaAluno;

class Usuario{

    function LoginUser(){
        $usuario = new \Model\Usuario;
        //$obj=json_decode(file_get_contents("php://input"));
        $obj=$_POST;
        $usuario->setEmail($obj["email"]);
        $usuario->setPassword($obj["senha"]);
        $usuario->login();
    }

    function createUser(){
        $obj=$_POST;
        $usuario=new \Model\Usuario;
        $session=new \Model\Session;
        $usuario->setEmail($obj['email']);
        $usuario->setNome($obj['nome']);
        $usuario->setPassword($obj['senha']);
        $result=$usuario->createUser();
        $session->setId($usuario->getId());
        $session->saveToken();
    }

    function buscarUser(){
        $usuario=new  \Model\Usuario;
        $lista=$usuario->listar();
        for($i=0;$i<count($lista);$i++){
            echo ($lista[$i]['nome']).'</br>';
            var_dump($lista[$i]);
        }
    }

    function Tb_N_N(){
        $turma_aluno=new TurmaAluno();
        $turma_aluno->Create_Class2();
       // $turma_aluno->__construct();
    }
}
