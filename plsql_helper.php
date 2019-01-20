<?php

namespace App\Helpers\Plsql;
 
class Plsql {

	private $when="";
	private $table;
	private $time="BEFORE" ;
	private $action;
	private $query;
	private $code;
	private $declare="";

	
	public static function table($table){
		$a= new Plsql();
		return $a->setTable($table);
	}
	public function setTable($table){
		$this->table = $table;
		return $this;
	}
	public function before($action){
		$this->action = $action;
		return $this;
	}

	public function after($action){
		$this->action = $action;
		$this->time = "after";
		return $this;
	}

	public function when($string){
		if($this->when != ""){
			$string= " AND ".$string;
		}
		$this->when .= $string;
		return $this;
	}

	public function whenOr($string){
		if($this->when != ""){
			$string= " OR ".$string;
		}
		$this->when .= $string;
		return $this;
	}

	public function begin($text){
		
		$this->code = $text;
		return $this;
	}

	public function declare($variable){
		$text="";
		if(is_array($variable)){
			foreach($variable  as $isi){
				$text .= key($isi)." ".$isi[key($isi)].";";
				// $text .= implode(" ",$isi).";\n";
			}
		}
		if($this->declare == ""){
			$text= "DECLARE ".$text;
		}
		$this->declare .= $text;
		return $this;
	}

	public function create() {
		if($this->when !== ""){
			$this->when = " when (".$this->when.") ";
		}
		 $this->query="
		 DROP TRIGGER IF EXISTS ".$this->table."_".$this->time."_".$this->action." ON $this->table;
		 DROP FUNCTION IF EXISTS fungsi_$this->table();
		 CREATE OR REPLACE FUNCTION fungsi_".$this->table."() 
		 \n
		 RETURNS trigger
		 \n
		 LANGUAGE 'plpgsql'
		 AS
		 $$
		 $this->declare
		 BEGIN
		 $this->code;
		 END$$; 
		 
		 CREATE TRIGGER ".$this->table."_".$this->time."_".$this->action."
		 ".$this->time." ".$this->action." ON ".$this->table."
		 \n
		 FOR EACH ROW
		 \n
		 $this->when
		 \n
		 EXECUTE PROCEDURE fungsi_".$this->table."();
		 ";
		  return $this->query;
	 } 
	 public function drop() {
		 $this->query="
		 DROP TRIGGER IF EXISTS ".$this->table."_".$this->time."_".$this->action." ON $this->table;
		 DROP FUNCTION IF EXISTS fungsi_$this->table();		 
		 ";
		  return $this->query;
	 } 
 		
}
