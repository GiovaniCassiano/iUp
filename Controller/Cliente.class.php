<?php

namespace Controller;

use \Model\Cliente as ClienteModel;

class Cliente{

    function inserirCliente(){
        try{
            $cliente=new ClienteModel;
            $cliente->inserir($_GET);   
        }catch(\Exception $e){
            echo "Erro para inserir cliente ".$e;
        }
    }

    function buscarCliente(){
        $cliente=new ClienteModel;
        print_r($cliente->buscar());
    }
}