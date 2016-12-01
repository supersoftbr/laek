<?php

require_once "configs.php";
require_once "encoding.php";
require_once "log.class.php";

class BaseSite {
	private $host;
	private $login;
	private $senha;
	private $mysqli;
	private $trans;
	
	function __construct() {
		$this->host = SITE_HOST;
		$this->login = SITE_LOGIN;
		$this->senha = SITE_SENHA;
		$this->database = SITE_DATABASE;
		$this->ConectaBaseSite();
	}

	function __destruct() {
		$this->DesconectaBaseSite();
	}
	
	private function ConectaBaseSite() {
		$this->mysqli = new mysqli($this->host, $this->login, $this->senha, $this->database);
	}
	
	private function DesconectaBaseSite() {
		$this->mysqli->close();
	}
	
	function StartTrans() {
		$this->mysqli->autocommit(FALSE);
	}

	function CommitTrans() {
		$this->mysqli->commit();
	}

	function RollbackTrans() {
		$this->mysqli->rollback();
	}
	
	function UltimoID() { // Último ID gerado pelo campo AutoIncrement. Retorna 0 se não houve auto incremento.
		return $this->mysqli->insert_id;
	}

	function Query($sql) {
		$sql = Encoding::toISO8859($sql);
		$retorna_resultado = (stripos($sql, "SELECT") === 0);
		if ($retorna_resultado) { // SELECT.
			$res = array();
			if ($result = $this->mysqli->query($sql)) {
				while($obj = $result->fetch_object())
					$res[] = $obj; 				
				$result->close();
			}
			else {
				$trace = debug_backtrace();
				$caller = array_shift($trace);
				Logs::MySQL($caller['file']." (linha ".$caller['line'].") em ".$caller['function'].", caller: ".$caller['args'][1]."Query: ".$sql);
			}
		}
		else { // INSERT, UPDATE, DELETE.
			$res = $this->mysqli->query($sql);
			if ($res === FALSE) {
				$trace = debug_backtrace();
				$caller = array_shift($trace);				
				Logs::MySQL($caller['file']." (linha ".$caller['line'].") em ".$caller['function'].", caller: ".$caller['args'][1]."Query: ".$sql);
			}
		}
		return $res;
	}
	
	function CamposTabela($tabela) {    
		$query = "SHOW FIELDS FROM ".$tabela;
		
		$campos = array();
		$result_set = $this->Query($query);
		if (count($result_set) > 0) {
			foreach ($result_set AS $campo)
				$campos[] = trim($campo->Field);
		}
		
		return $campos;
	}
}
?>