<?
include_once 'MsSQLConnection.php';
// esse trexo pode ir no init_database -------------
$serverName = "172.16.32.215\previhm"; //serverName\instanceName
 
$connectionInfo = array( "Database"=>"ODS_PREVISUL", "UID"=>"usr_leitura", "PWD"=>"leitura");

$conexao = new MsSQLConnection($serverName,$connectionInfo);

$conexao->conecta_MSSQL();
//---------------------------------------------
$query = " SP_PORTAL 'CORRETOR', 'AND COD_COR = 339'";
$conexao->faz($query);
while ( $row = $conexao->arrayx()){
	print_r($row);
}

$query = "SP_PORTAL 'CERTIFICADO', 'AND [NUM_CERTIFICADO] = ''310.82.9.00002038'' '";
$conexao->faz($query);
while ( $row = $conexao->arrayx()){
	$certificado = $row;
}	

$query = "SP_PORTAL 'CERTIFICADO_GARANTIA', 'AND [NUM_CERTIFICADO] = ''310.82.9.00002038'' '";
$conexao->faz($query);
while ( $row = $conexao->arrayx()){
	$garantias[] = $row;
}

$query = "SP_PORTAL 'CERTIFICADO_ASSISTENCIA', 'AND [NUM_CERTIFICADO] = ''310.82.9.00002038'' '";
$conexao->faz($query);
while ( $row = $conexao->arrayx()){
	$assistencias[] = $row;
}

$query = "SP_PORTAL 'CERTIFICADO_BENEFICIARIO', 'AND [NUM_CERTIFICADO] = ''310.82.9.00002038'' '";
$conexao->faz($query);
while ( $row = $conexao->arrayx()){
	$beneficiarios[] = $row;
}

echo PHP_EOL;
print_r($certificado);
print_r($assistencias);
print_r($garantias);
print_r($beneficiarios);

$conexao->desconecta();

?>