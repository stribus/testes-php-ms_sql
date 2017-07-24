<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
		<form name="login" action="logar.php" method="POST">
			Email : <input type="text" name="email" value="" size="10" /> <br>
			Senha : <input type="password" name="senha" value="" size="10" />			
			<br>				
			<input type="submit" value="Ok" name="Ok" />
			<input type="reset" value="Limpar" name="Limpar" />
		</form>
		<?
		echo '<script>window.location.replace("/cache1.php");</script>';
		
		include_once 'mysqlConnection.php';
		
		
		$conexao = new mysqlConnection();
		
		$conexao->conecta();
		
		//$conexao->faz("SELECT 'S' tipo,COUNT(*) FROM test.temp_chm_0517;
		//				SELECT 'I' tipo, COUNT(*),123 numero FROM test.temp_chm_0517_imp;");
		
		$conexao->faz("SELECT null tipo,COUNT(*) FROM test.temp_chm_0517;");
		while ($a = $conexao->arrayx()) {
			if($a['tipo'])
			{
				echo '1 - '.$a['tipo'];
			}
			else
			{
				echo 'false - '.$a['tipo'];
			}	
			print_r($a);
		}
			
        
        
        
		?>
		
		
    </body>
</html>
