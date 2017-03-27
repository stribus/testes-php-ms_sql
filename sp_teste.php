<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
		<?php
		include_once 'MsSQLConnection.php';

		$conexao = new MsSQLConnection('AGEME-02', array("Database" => "master", "UID" => "sa", "PWD" => "eme142536"));

		$conexao->conecta_MSSQL();

		$conexao->executar("Exec dbo.auto_fill_teste");

		while ($conexao->proximoResultset()) {
			while ($row = $conexao->arrayx(NULL, "both")) {
				print_r($row);
				print_r("<br>");
			}
		}
		?>
    </body>
</html>
