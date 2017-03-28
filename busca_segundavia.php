<?

include_once 'MsSQLConnection.php';
// esse trexo pode ir no init_database -------------
$serverName = "172.16.32.215\previhm"; //serverName\instanceName

$connectionInfo = array("Database" => "ODS_PREVISUL", "UID" => "usr_leitura", "PWD" => "leitura");

$conexao = new MsSQLConnection($serverName, $connectionInfo);

$conexao->conecta_MSSQL();

//---------------------------------------------
function busca_por_codcor($codcor, $dataI, $dataF) {
	global $conexao; 
	$query = " SP_PORTAL 'FATURA','AND [COD_CORRETOR_1] = $codcor'";
	$conexao->faz($query);
	$faturas = false;
	while ($row = $conexao->arrayx()) {
		$faturas[] = "''$row[NUM_FATURA]''";
	}
//formatação da data em YYYY/mm/dd
	$faturas = implode(',', $faturas);
	$query = "SP_PORTAL 'BOLETO', 'AND [NOSSO_NUMERO] != ''*''  "
			. "                    AND [DATA_VENCIMENTO] > CAST(''$dataI'' AS DATE) "
			. "                    AND [DATA_VENCIMENTO] < CAST( ''$dataF'' AS DATE) "
			. "                    AND [FATURA] IN ($faturas)'";
	$boletos = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$boletos[] = $row;
	}
	return $boletos;
}

function busca_por_CPF($cpf_cnpj, $dataI, $dataF) {
	global $conexao;
//formatação da data em YYYY-mm-dd
	
	$query = "SP_PORTAL 'BOLETO', 'AND [NOSSO_NUMERO] != ''*''  "
			. "                    AND [DATA_VENCIMENTO] > CAST(''$dataI'' AS DATE) "
			. "                    AND [DATA_VENCIMENTO] < CAST( ''$dataF'' AS DATE) "
			. "                    AND [CPF_CNPJ] = ''$cpf_cnpj'' '";
	$boletos = false;
	$conexao->faz($query);
	while ($row = $conexao->arrayx()) {
		$boletos[] = $row;
	}
	return $boletos;
}

$b1 = busca_por_codcor(339, '2017-01-01', '2017-04-30');
$b2 = busca_por_CPF('87758199704', '2017-01-01', '2017-04-30');

echo PHP_EOL;
print_r($b1);
echo PHP_EOL;
print_r($b2);

$conexao->desconecta();
?>