<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MsSQLConnection
 *
 * @author Flavio
 */
class MsSQLConnection {

	protected $MSconn;
	protected $serverName;
	protected $connectionOptions;
	public $query;

	public function __construct($nomeServidor = '', $opcoes = null) {
		$this->serverName = ((empty($nomeServidor)) ? "tcp:AGEME-01-PC,49172" : $nomeServidor);
		$this->connectionOptions = (($opcoes) ? $opcoes : array("Database" => "PORTAL_SEGURADO", "UID" => "ageme", "PWD" => "eme142536"));
		$this->query = NULL;
	}

	public function __destruct() {
		$this->fechaQuery();
		if ($this->MSconn)
			$this->fechar_conexao();
	}

	function verifica() {
		if (!$this->$MSconn) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function conecta_MSSQL() {
		$this->MSconn = sqlsrv_connect($this->serverName, $this->connectionOptions);
		if (!$this->MSconn) {
			var_dump(sqlsrv_errors());
			die;
		}
	}

	function buscar($sql, $params = array(), $options = array("Scrollable" => "buffered")) {
		if (!$this->MSconn) {
			$this->conecta_MSSQL();
		}
		if (empty($q)) {
			die('e\' necessario uma "query".');
		}
		$this->fechaQuery();
		$this->query = sqlsrv_query($this->MSconn, $sql, $params, $options) or $this->erro("ERRO NA CONSULTA!  <span style=\"display:none\">  $q </span>");
		return $this->query;
	}

	function faz($q = "") {
		if (!$this->verifica()) {
			$this->erro('e\' necessario conectar ao mysql antes.');
		}
		if (empty($q)) {
			die('e\' necessario uma "query".');
		}
		$this->buscar($q);
	}

	private function fechaQuery() {
		if ($this->query) {
			$this->fechar_statement($this->query);
			$this->query = NULL;
		}
	}

	function executar($sql) {
		if (!$this->MSconn) {
			$this->conecta_MSSQL();
		}
		$this->fechaQuery();
		sqlsrv_query($this->MSconn, $sql);
	}

	function arrayx($a = null, $tipo = 'assoc') {
		if (empty($a))
			$a = $this->query;
		switch (strtoupper($tipo)) {
			case 'ASSOC':
				$fc = SQLSRV_FETCH_ASSOC;
				break;
			case 'NUMERIC':
				$fc = SQLSRV_FETCH_NUMERIC;
				break;

			default:
				$fc = SQLSRV_FETCH_BOTH;
				break;
		}
		return sqlsrv_fetch_array($a, $fc);
	}

	function objeto($a = null) {
		if (empty($a))
			$a = $this->query;
		return sqlsrv_fetch_object($a);
	}

	function fechar_statement($stm) {
		sqlsrv_free_stmt($stm);
	}

	function desconecta() {
		$this->fechaQuery();
		sqlsrv_close($this->MSconn);
	}

	function registros($tipo = 'select') {
		if (!$this->query) {
			return 0;
		} else {
			switch ($tipo) {
				case "delete":
				case "update":
					return qlsrv_rows_affected($this->query);
					break;
				case "select":
				default:
					return sqlsrv_query($this->query);
					break;
			}
		}
	}

	function tabelas() {
		if (!$this->verifica()) {
			die("[ MS SQL - tabelas ]  necess&aacute;rio conectar ao DB antes.\n");
			exit;
		}
		$this->buscar("SELECT name FROM sys.Tables");
		while ($a = $this->arrayx($this->query, "NUMERIC")) {
			$listas[] = $a[0];
		}
		return $listas;
	}

	function erro($a = 'desconhecido', $DB = TRUE) {
		$msg = $nome;
		$msg .= $a;
		if ($DB) {
			if (($errors = sqlsrv_errors() ) != null) {
				$msg .= "\n";
				foreach ($errors as $error) {
					$msg .= "SQLSTATE: " . $error['SQLSTATE'] . "<br />\n";
					$msg .= "code: " . $error['code'] . "<br />\n";
					$msg .= "message: " . $error['message'] . "<br />\n";
				}
			}
		}
		die($msg);
	}

}
