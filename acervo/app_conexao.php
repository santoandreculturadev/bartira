<?php

if(isset($_POST['teste'])){
	$username = $_POST['usuario'];
	$password = $_POST['senha'];
	$connection_string = $_POST['egvop'];
	
$conn = oci_connect($_POST['usuario'],$_POST['senha'],$_POST['egovp'],'AL32UTF8');


if($conn){
	echo "<h1>Dados do Banco de Dados Oracle ... Conectado!</h1>";
}else{
	echo "<h1>Dados do Banco de Dados Oracle ... Incorreto!</h1>";
	}

echo "<pre>";
var_dump($_POST);
echo "</pre>";

oci_close($conn);	
	
	
echo "<br /> <a href='app_conexao.php'>Testar novamente</a>";	
	
}else{
	?>
	<h1>Teste de Conexão - Bando de Dados Oracle</h1>

<form action="app_conexao.php" method="post">
  <label for="usuario">usuario:</label>
  <input type="text" id="fname" name="usuario"><br><br>
  <label for="lname">senha::</label>
  <input type="text" id="lname" name="senha"><br><br>
  <label>egovp (sem 'egov =')</label>
<textarea name="egovp"></textarea><br />
<input type="hidden" name="teste" value="teste">	
  <input type="submit" value="Testar">
</form>
	
	
	<?php
	
	
	
}


	?>