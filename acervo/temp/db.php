<?php 
/*
function conexao(){
	$username = "museup";
	$password = "museup";
	$connection_string="localhost/xe";
	$conn = oci_connect($username,$password,$connection_string,'AL32UTF8');
	return $conn;	
}


	function bancoMysqli()
	{
		$servidor = 'localhost';
		$usuario = 'root';
		$senha = '';
		$banco = 'museu_teste';
		$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
		mysqli_set_charset($con,"utf8");
		return $con;
	}

	function bancoMysqliObj(){

		$servidor = 'localhost';
		$usuario = 'root';
		$senha = '';
		$banco = 'museu_teste';
		$con = new mysqli($servidor,$usuario,$senha,$banco); 
		$con->set_charset("utf8");
		$con->set_charset("utf8");
		return $con;
	}
*/


function conexao_casa(){
	$username = "CASAOLHAR_CON";
	$password = "casaolharprod";
	$connection_string = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = 172.30.72.22)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = PMSA)
    )
)";
	$conn = oci_connect($username,$password,$connection_string,'AL32UTF8');
	return $conn;	
}

function conexao(){
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
	return $conn;	
}


	function bancoMysqli()
	{
		$servidor = '172.30.72.13';
		$usuario = 'user_sc_intranet';
		$senha = 'P45w_sc_intranet!@';
		$banco = 'sc_intranet';
		$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
		mysqli_set_charset($con,"utf8");
		return $con;
	}

	function bancoMysqliObj(){

		$servidor = '172.30.72.13';
		$usuario = 'user_sc_intranet';
		$senha = 'P45w_sc_intranet!@';
		$banco = 'sc_intranet';
		$con = new mysqli($servidor,$usuario,$senha,$banco); 
		$con->set_charset("utf8");

		return $con;
	}




