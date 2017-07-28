<?php 

namespace Model;

class Session extends \Model\Usuario{
    protected $token;

    public function setToken($token){
        $this->token=$token;
    }

    public function getToken(){
        return $this->token;
    }

    public function creatToken(){
       return $this->token=\md5(date('c'));
    }
    public function saveToken(){
        $this->creatToken();
        $sql='insert into '.$this->getTbName().' ('.\implode(',',
        $this->getPropiers()).') values ('.[":id"=>$this->id,"token"=>$this->token].') ';
    }
}