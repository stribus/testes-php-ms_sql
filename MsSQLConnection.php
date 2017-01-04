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
	protected $query;


	public function __construct() {
		$this->serverName = "tcp:AGEME-01-PC";
		$this->connectionOptions = array( "Database"=>"PORTAL_SEGURADO", "UID"=>"ageme", "PWD"=>"eme142536");
	
	}
	
	public function __destruct() {
		if ($this->MSconn)
			$this->fechar_conexao();
	}
	
	function conecta_MSSQL(){
		$this->MSconn = sqlsrv_connect( $this->serverName, $this->connectionOptions );
		if (!$this->MSconn)
		{
			var_dump(sqlsrv_errors());
			die;
		}
	}
	
	function buscar($sql){
		if (!$this->MSconn){
			$this->conecta_MSSQL();
		}
		return sqlsrv_query($this->MSconn,$sql);
	}
	
	function executar($sql){
		if (!$this->MSconn){
			$this->conecta_MSSQL();
		}
		if (!$query){
		}
		sqlsrv_query($this->MSconn,$sql);
	}
	
	function obterLinha($resultSet){
		return sqlsrv_fetch_array($resultSet);
	}
	
	function fechar_statement($stm){
		sqlsrv_free_stmt( $stm );
	}
	
	function fechar_conexao(){
		sqlsrv_close( $this->MSconn );
	}
	
}
