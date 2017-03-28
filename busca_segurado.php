<?

include_once 'MsSQLConnection.php';
// esse trexo pode ir no init_database -------------
$serverName = "172.16.32.215\previhm"; //serverName\instanceName

$connectionInfo = array("Database" => "ODS_PREVISUL", "UID" => "usr_leitura", "PWD" => "leitura");

$conexao = new MsSQLConnection($serverName, $connectionInfo);

$conexao->conecta_MSSQL();

//---------------------------------------------


function buscaSeguradoPorCPF($cpf) {
	global $conexao;
//formatação da data em YYYY-mm-dd
	
	$query = "SP_PORTAL 'SEGURADO', 'AND [CPF] = ''$cpf'' ';";
	$rows = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$rows[] = $row;
	}
	return $rows;
}

function buscaSeguradoPorCNPJ($cnpj) {
	global $conexao;
//formatação da data em YYYY-mm-dd
	
	$query = "SP_PORTAL 'SEGURADO', 'AND [CNPJ]  = ''$cnpj'' ';";
	$rows = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$rows[] = $row;
	}
	return $rows;
}


$s1 = buscaSeguradoPorCPF('87758199704');
$s2 = buscaSeguradoPorCNPJ('80284367000113');

echo PHP_EOL;
print_r($s1);
echo PHP_EOL;
print_r($s2);

$conexao->desconecta();
?>