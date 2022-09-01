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

if($conn){
	echo "Connected!";
}else{
	echo "Not connected...";
	}

$stid = oci_parse($conn, 'SELECT * FROM TAB_FICHA_CATALOGRAFICA',);
oci_execute($stid);	
$j = 0;
echo "<table border='1'>\n";

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		$j++;
    }
    echo "</tr>\n";
}
echo "</table>\n";

echo $j ." registros<br />";

$err = oci_error($stid);

echo "<pre>";
var_dump($err);
echo "</pre>";



$stid = oci_parse($conn, 'SELECT * FROM TAB_IMAGENS_TESTE');
oci_execute($stid);	

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";

		//echo '<div class="caption"><h3><img src="data:image/jpeg;base64,'.base64_encode($item).'"/></h3></div>';
		//echo '<img src="data:image/jpeg;base64,'.base64_encode($item).'" />';

    }
    echo "</tr>\n";
			$j++;
}
echo "</table>\n";



/*
$id='4';
$query = 'SELECT BLB FROM TAB_IMAGENS_TESTE where id=:id';
$stmt = oci_parse ($conn, $query);
oci_bind_by_name($stmt, ':id', $id);
oci_execute($stmt);
$arr = oci_fetch_array($stmt, OCI_ASSOC);
$result = $arr['BLB']->load();
header("Content-type: image/JPEG");
echo $result;
oci_close($conn);
*/
	
	?>