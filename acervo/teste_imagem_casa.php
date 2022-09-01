<?php

$username = "CASAOLHAR_CON";
$password = "casaolharprod";
$connection_string = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = 172.30.72.22)(PORT = 1521))
    (CONNECT_DATA =
      (SERVICE_NAME = PMSA)
    )
)";
  
$conn = oci_connect($username,$password,$connection_string,'AL32UTF8');
//oci_connect('SECMAN', 'SECMAN', '(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST =192.168.10.24)(PORT = 1521))(CONNECT_DATA =(SERVER = DEDICATED)(SERVICE_NAME = cisqa)))');
/*

 Usuário: museu_con Senha: museu_con
TNSNAME:
 
EGOVP =
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.30.72.22)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = PMSA)
    )
  )
 
 
                Usuário: casaolhar_con Senha: casaolharprod
TNSNAME:
 
EGOVD =
  (DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 172.30.72.22)(PORT = 1521))
    (CONNECT_DATA =
      (SERVICE_NAME = PMSA)
    )
  )
*/

if(isset($_GET['tabela'])){
	$query = "SELECT * FROM ".$_GET['tabela'];
}else{
	$query = "SELECT * FROM ALL_ALL_TABLES ";
	
}


if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, $query );
oci_execute($stid);
$c = 0;
echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		
    }
    echo "</tr>\n";
	$c++;
}
echo "</table>\n";
$err = oci_error($stid);

echo "Há $c registros no banco de dados";

echo "<pre>";
var_dump($err);
echo "</pre>";