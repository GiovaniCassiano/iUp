<?php

namespace Model;

use \Framework\Common\Model;
use \Model\Usuario;
use \Model\Turma;

class TurmaAluno extends Model{

    protected $tabela;
    protected $listaNome=[];
    protected $atributos=[];
    protected $campos=[];
    protected $nomesAtributos=[];
    protected $tableSQL=[];

    public function Create_Class2(){
        $arquivo=\file_get_contents(__DIR__.'/bd.sql',\FILE_SKIP_EMPTY_LINES);
        //$limpo=\str_replace(' ',' ',$arquivo);
        $table=$this->_explode('/**/',$arquivo);
        \array_splice($table,0,1);
        $this->tabela=$table;
        $TT=$this->getNameTables();
    }

    public function getNameTables(){
        for($i=0;$i<count($this->tabela);$i++){
            $sql[]=$this->_explode('(',$this->tabela[$i]);
            $row[]=$this->_explode(' ',$sql[$i][0]);
            $this->listaNome[]=$row[$i][3];
        }
        $this->getAtributos();
    }

    public function getAtributos(){
        for($i=0;$i<count($this->tabela);$i++){
            $colunas=$this->_explode($this->listaNome[$i].'(',$this->tabela[$i]);
            $this->campos[$this->listaNome[$i]]=$this->_explode(',',$colunas[1]);
        }
        $this->getNomeAtributos();
    }

    public function getNomeAtributos(){
        for($i=0;$i<count($this->campos);$i++){
            $t=count($this->campos[$this->listaNome[$i]]);
            unset($vetor);
            for($x=0;$x<$t;$x++){
                $vetor[]=$this->_explode('_',$this->campos[$this->listaNome[$i]][$x]);
                $this->atributos[$this->listaNome[$i]]=$vetor;
            }
        }
        $this->listarCampo();
    }

    public function listarCampo(){
        for($i=0;$i<count($this->atributos);$i++){
            $t=count($this->atributos[$this->listaNome[$i]]);
            unset($vetor);
            for($x=0;$x<$t;$x++){
                $cunt=$this->atributos[$this->listaNome[$i]][$x][1];
                $vetor[]=$this->_explode(' ',$cunt);
                $this->nomesAtributos[$this->listaNome[$i]]=$vetor;
            }
        }
        $this->arrayAssociativoCampo();
    }

    public function arrayAssociativoCampo(){
        for($i=0;$i<count($this->nomesAtributos);$i++){
             $t=count($this->nomesAtributos[$this->listaNome[$i]]);
             unset($newarray);
            for($x=0;$x<$t;$x++){
                $newarray[]=$this->nomesAtributos[$this->listaNome[$i]][$x][0];
                $this->tableSQL[$this->listaNome[$i]]=$newarray;
            }
        }

        $this->criarClasses();
    }

    public function criarClasses(){
        for($i=0;$i<count($this->nomesAtributos);$i++){
            $name=$this->listaNome[$i];
            $valor=\array_unique($this->tableSQL[$this->listaNome[$i]]);
            $countcolunas=count($valor);
            $propriedades="";
            $setGet="";
            for($x=0;$x<$countcolunas;$x++){
                $propriedades.=" protected $".$valor[$x].";\n ";
                $setGet.="\n public function set".$valor[$x].
                "($".$valor[$x]."){\n  $"."this->".$valor[$x].
                ";\n }\n ";
                $setGet.=" public function get".$valor[$x].
                "(){\n  return $"."this->".$valor[$x].
                ";\n }\n ";
            }
            $this->createFile($propriedades,$setGet,$name);
        }
    }

    public function createFile($propriedades,$setGet,$name){
        $txt = "<?php\n/*\n Generation of Class in PHP\n Version Beta\n */\n namespace Model; \n\n class ".$name.
            "{\n\n ";
        $myfile = \fopen($name."_.class.php", "w") or die("Unable to open file!");
        \fwrite($myfile, $txt);
        \fwrite($myfile, $propriedades);
        \fwrite($myfile, $setGet);
        \fwrite($myfile, "\n }");
        \fclose($myfile);
    }

    /*public function creatSQL(){
        $files = new \FilesystemIterator(__DIR__);
        $listaOfObj=[];
        foreach($files as $file)
        {
            if(\strrpos($file,".class.php")){
                $arquivo[]=\explode('\n',$file->getFilename());
                $name=\str_replace('.class.php',"",$file->getFilename());
                $test="\\Model\\".$name;
                $obj=new $test;
                $listaOfObj[]=$obj;
            }
        }
        for($i=0;$i<count($listaOfObj);$i++){
            $tbName=new \ReflectionClass($listaOfObj[$i]);
            $propriedades=$tbName->getProperties();
        }
    }*/

}