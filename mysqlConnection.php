<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mysqlConnection
 *
 * @author Flavio
 */
class mysqlConnection {

	public $conecta;
	public $query;

	function verifica() {
		if (!$this->conecta) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function conecta() {
		$this->conecta= mysql_connect('localhost');
		if (!$this->conecta) {
			die('Not connected : ' . mysql_error());
		}

		// make foo the current db
		$db_selected = mysql_select_db('test', $this->conecta);
	}

	function sel_banco($banco) {
		global $cf;
		if (!$this->verifica()) {
			$this->erro('e\' necessario conectar ao mysql antes', FALSE);
		} elseif (!isset($cf['db.' . $banco])) {
			$this->erro("variável \$cf['db." . $banco . "'] não encontrada.", FALSE);
		} elseif (!mysql_select_db($banco, $this->conecta)) {
			$this->erro("erro ao selecionar banco de dados: " . $cf['db.' . $banco] . ".");
		} else {
			$this->bd = $banco;
			return true;
		}
	}

	function faz($q = "") {
		global $cf;
		if (!$this->verifica()) {
			$this->erro('e\' necessario conectar ao mysql antes.');
		}
		if (empty($q)) {
			die('e\' necessario uma "query".');
		}
		$this->query = mysql_query($q, $this->conecta) or $this->erro('ERRO NA CONSULTA!  <span style="display:none"> ' . $q . '</span>');
	}

	function objeto($a = '') {
		if (empty($a))
			$a = $this->query;
		return mysql_fetch_object($a);
	}

	function arrayx($a = '', $tipo = 'assoc') {
		if (empty($a))
			$a = $this->query;
		$fc = "mysql_fetch_" . $tipo;
		return $fc($a);
	}
	
	function erro($a='desconhecido',$mysql=TRUE){
			$msg = $nome;
			$msg .= $a;
			if($mysql == 1) $msg .= 'MySQL Error: '.mysql_error();
			
			die($msg);
		}

}
