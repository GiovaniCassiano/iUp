<?php

namespace Framework\Common;

use \PDO;
class Conexao extends PDO{

    private static $configFile = null;

    public static function setConfig($file){
        self::$configFile = $file;
    }
    public function __construct(){
        if(is_null(self::$configFile))
            throw new Exception("Arquivo de configuração não informado");
        $config = \parse_ini_file(self::$configFile);
        parent::__construct("mysql:dbname=".$config["DATABASE"].";host=".$config["HOST"],$config["USER"],$config["PASSWORD"]);
    }
}