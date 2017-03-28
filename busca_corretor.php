<?

include_once 'MsSQLConnection.php';
// esse trexo pode ir no init_database -------------
$serverName = "172.16.32.215\previhm"; //serverName\instanceName

$connectionInfo = array("Database" => "ODS_PREVISUL", "UID" => "usr_leitura", "PWD" => "leitura");

$conexao = new MsSQLConnection($serverName, $connectionInfo);

$conexao->conecta_MSSQL();

//---------------------------------------------


function buscaCorretorPorCPFCNPJ($cpfCnpj) {
	global $conexao;
//formatação da data em YYYY-mm-dd
	
	$query = "SP_PORTAL 'CORRETOR','AND [CPF] = ''$cpfCnpj''  or [CNPJ] = ''$cpfCnpj'' ';";
	$rows = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$rows[] = $row;
	}
	return $rows;
}

function buscaSeguradoPorEmail($mail) {
	global $conexao;
//formatação da data em YYYY-mm-dd
	
	$query = "SP_PORTAL 'CORRETOR','AND [EMAIL] = ''$mail''  ';";
	$rows = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$rows[] = $row;
	}
	return $rows;
}


$s1 = buscaCorretorPorCPFCNPJ('93694057000119');
$s2 = buscaSeguradoPorEmail('marcus@alcorretora.com.br');

echo PHP_EOL;
print_r($s1);
echo PHP_EOL;
print_r($s2);

$conexao->desconecta();
?>