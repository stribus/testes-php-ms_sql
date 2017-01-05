<?

include_once 'MsSQLConnection.php';

$conexao = new MsSQLConnection();

$query = 'select COD_SEG,SENHA from VW_LOGIN where MAIL = \''.$_REQUEST['email'].'\'';

$resultset =  $conexao->buscar($query);

$senha = $conexao->arrayx( $resultset );

if($senha){
	if(!$senha['SENHA']){
		$query = '
	INSERT INTO [dbo].[SENHAS_SEGURADOS]
           ([COD_SEG]
           ,[SENHA])
    VALUES
           ('.$senha['COD_SEG'].'
           ,\''.$_REQUEST['senha'].'\')';
		$conexao->executar($query);
	echo 'gravado senha '.$_REQUEST['senha'];
	}elseif ($senha['SENHA']==$_REQUEST['senha']){
		echo 'logado';
	} else {
		echo 'senha nao confere';
	}
	
} else {
	echo 'Usuario \''.$_REQUEST['email'].'\' nao cadastrado';
	
}
	


$conexao->fechar_conexao();
?>