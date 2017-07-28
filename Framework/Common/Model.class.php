<?php

namespace Framework\Common;

use Framework\Common\Conexao;

abstract class Model{

    public function getClassName(){
        return $this->$className;
    }

    private function getClass(){
        return new \ReflectionClass($this);
    }

    protected function getTbName(){
        $str=str_replace($this->getClass()->getNamespaceName() . '\\','',$this->getClass()->getName());
        return \strtolower($str);
    }

    protected function getPropiers(){
        $props=$this->getClass()->getProperties();
        $count=count($props);
        $array=[];
        for($i = 0; $i < $count; $i++){
            $array[]=$props[$i]->name;
        }
        return $array;
    }

    protected function getPropiersWithValues(){
        $props=$this->getPropiers();
        $count=count($props);
        $array=[];
        for($i=0;$i<$count;$i++){
            $array[$props[$i]]=$this->{$props[$i]};
        }
        return $array;
    }

    protected function query($sql, $obj=null){
        $conexao =new Conexao();
        $executar=$conexao->prepare($sql);
        $executar->execute($obj);
        $this->id=$conexao->lastInsertId();
        return $executar;
    }

    protected function fieldQuery(){
        $sql="SHOW FIELDS FROM ".$this->getTbName();
        return $this->query($sql)->fetchAll(\PDO::FETCH_ASSOC);//SÓ TRAS OS NOMES

    }

    public function _explode($cond,$obj){
        return \explode($cond,$obj);
    }

    public function listar(){
        $sql="select * from ".$this->getTbName();
        $lista=$this->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return $lista;
    }

    public function inserir(){
        $this->$className=$this;
        $sql='insert into '.$this->getTbName().' ('.\implode(',',$this->getPropiers()).') values (:'.\implode(',:',$this->getPropiers()).') ';
       return $this->query($sql,$this->getPropiersWithValues());
    }

    public function editar(){
        $this->$className=$this;
        $sql='Update ' . $this->getTbName() . ' set ';
        $array=$this->getPropiers();
        $count=count($array);
        for($i=0; $i<$count; $i++){
            $sql.=$array[$i].'=:'.$array[$i];
            if($i!=$count-1)
                $sql.=',';  
        }
        $sql.=' where id=:id';
        $this->query($sql,$this->getPropiersWithValues());
    }

    public function delete(){
        $this->$className=$this;
        $sql='Delete from '.$this->getTbName().' where id=:id';
        $this->query(['id'=>$this->id]);
    }

    public function pesquisar($pesq){
        $this->$className=$this;
        $sql="select * from ".$this->getTbName()." where ".$pesq."=:".$pesq;
        $result=$this->query($sql,[$pesq=>$this->email]);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function table_N_N($props,$props2){
        $count_props=count($props['propiers']);
        $id_pros=$props['tbName']."_id";
        $id_pros2=$props2['tbName']."_id";
        $count_props2=count($props2['propiers']);
        $sql='insert into '.$this->getTbName().' ('.\implode(',',$this->getPropiers()).
        ','.$id_pros.','.$id_pros2.') values ('.\implode(',',$this->getPropiers()).','.$id_pros.','.$id_pros2.') ';
        
    }

    /*protected function getClass(){
        return new \ReflectionClass($this);
    }

    private function getTbName(){
         $tb_name=str_replace($this->getClass()->getNamespaceName().'\\', '', $this->getClass()->getName());//nome da tabela; o "" é para substituir
        return \strtolower($tb_name);
    }

    private function getProperties() {
        $props = $this->getClass()->getProperties();
        $propsArr = [];
        $quantidadeProperties = count($props);
        for($i = 0; $i < $quantidadeProperties; $i++) {
            $propsArr[] = $props[$i]->name;
        }
        return $propsArr;
    }

    private function getPropertiesWithValue(){
        $props = $this->getProperties();
        $propsArr = [];
        $quantidadeProperties = count($props);
        for($i = 0; $i < $quantidadeProperties; $i++) {
            $propsArr[$props[$i]] = $this->{$props[$i]};
        }
        return $propsArr;
    }

    private function query($sql){
        $conexao=new Conexao;
        return $conexao->prepare($sql);
    }

    public function inserir(){
        $sql = 'insert into '. $this->getTbName() . ' (' . \implode(',',$this->getProperties()) . ') values (:' . \implode(',:',$this->getProperties()) . ')'; 
        $insert=$this->query($sql);
        $insert->execute($this->getPropertiesWithValue());
    }

    public function listar($limit=1000){
        $sql="select * from ".$this->getTbName()." limit ".$limit;
        $busca=$this->query($sql);
        $busca->execute();
        return $busca->fetchAll();
    }

    public function update(){
        $sql="update " . $this->getTbName() . " set ";
        $props=$this->getProperties();
        $count=count($props);
        for($i=0;$i<$count;$i++){
            $sql.=$props[$i] . '=:' . $props[$i];
            if($i!=($count-1))
                $sql.=',';
        }
        $sql.=' where id=:id';
        $inserir=$this->query($sql);
        $inserir->execute($this->getPropertiesWithValue());
    }

    public function delete(){
        $sql='delete from '. $this->getTbName();
        $deletar=$this->query($sql);
        echo $sql;
        $props=$this->getPropertiesWithValue();
        $sql.=' where id=:id';
        $deletar=$this->query($sql);
        $props=$this->getPropertiesWithValue();
        $deletar->execute(['id' => $props['id']]);
    }*/
}