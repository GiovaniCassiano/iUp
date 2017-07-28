<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

require __DIR__.'/Framework/App.class.php';

use Framework\App;
use Framework\Common\Conexao;

try{
    $app = new App();
    Conexao::setConfig(__DIR__.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Config.ini');
    $app->start();
    //phpinfo();
}catch(Exception $e){
    header('HTTP/1.1 ' . $e->getCode());
    echo json_encode(['message'=>$e->getMessage()]);
}