<?php


$username = "museu_con";
$password = "museu_con";
$connection_string = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.30.72.22)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = PMSA)
    )
  )";
  
$conn = oci_connect($username,$password,$connection_string,'AL32UTF8');

if($conn){
	echo "<h1>Dados do Banco de Dados Oracle do Museu... Conectado!</h1>";
}else{
	echo "<h1>Dados do Banco de Dados Oracle do Museu... Incorreto!</h1>";
	}

oci_close($conn);



$username = "CASAOLHAR_CON";
$password = "casaolharprod";
$connection_string = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = PSALORA01)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = PMSA)
    )
)";
  
$conn = oci_connect($username,$password,$connection_string,'AL32UTF8');

if($conn){
	echo "<h1>Dados do Banco de Dados Oracle da Casa do Olhar... Conectado!</h1>";
}else{
	echo "<h1>Dados do Banco de Dados Oracle da Casa do Olhar... Incorreto!</h1>";
	}

oci_close($conn);



	?>