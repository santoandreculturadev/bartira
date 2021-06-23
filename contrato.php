<?php include "header.php"; ?>

<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

?>

<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>


<body>
	
	<?php include "menu/me_contrato.php"; ?>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/maskMoney.js"></script> 
	<script>
		$(function() {
			$( ".calendario" ).datepicker();
			$(".cpf").mask("999.999.999-99");
			$(".cnpj").mask("99.999.999/9999-99");
			$( ".hora" ).mask("99:99");
			$( ".min" ).mask("999");
			$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
		});



	</script>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
case "inicio": //Lista as contratações

// Insere Pessoa Física e Cria Pedido de Contratação
if(isset($_POST['inserir_pf'])){

	// Carrega as variáveis
	$Nome = $_POST["Nome"];
	$NomeArtistico = $_POST["NomeArtistico"];
	$CPF = $_POST["CPF"];
	$RG = $_POST["RG"];
	$tipo = $_POST["tipo"];
	$DataNascimento = exibirDataMysql($_POST["DataNascimento"]);
	$LocalNascimento = $_POST["LocalNascimento"];
	$Nacionalidade = $_POST["Nacionalidade"];
	$cep = $_POST["cep"];
	$Numero = $_POST["Numero"];
	$rua = $_POST["rua"];
	$bairro = $_POST["bairro"];
	$Complemento = $_POST["Complemento"];
	$cidade = $_POST["cidade"];
	$uf = $_POST["uf"];
	$Telefone1 = $_POST["Telefone1"];
	$Telefone2 = $_POST["Telefone2"];
	$Telefone3 = $_POST["Telefone3"];
	$Email = $_POST["Email"];
	$CCM = $_POST["CCM"];
	$INSS = $_POST["INSS"];
	$DRT = $_POST["DRT"];
	$OMB = $_POST["OMB"];
	$Funcao = $_POST["Funcao"];
	$PIS = $_POST["PIS"];
	$observacoes = $_POST["observacoes"];
	$Banco = $_POST["Banco"];
	$agencia = $_POST["agencia"];
	$conta = $_POST["conta"];
	$cbo = $_POST["cbo"];
	$data = date("Y-m-d");
	$id_usuario = $user->ID;
	
	// Insere na tabela sc_pf
	$sql_insere = "INSERT INTO `sc_pf` (`Nome`, `NomeArtistico`, `RG`, `CPF`, `CCM`, `IdEstadoCivil`, `DataNascimento`, `LocalNascimento`, `Nacionalidade`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DRT`, `Funcao`, `InscricaoINSS`, `Pis`, `OMB`, `DataAtualizacao`, `Observacao`, `IdUsuario`, `codBanco`, `agencia`, `conta`, `cbo`) VALUES ('$Nome', '$NomeArtistico', '$RG', '$CPF', '$CCM', '$tipo', '$DataNascimento', '$LocalNascimento', '$Nacionalidade', '$cep', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$DRT', '$Funcao', '$INSS', '$PIS', '$OMB', '$data', '$observacoes', '$id_usuario',  '$Banco', '$agencia', '$conta', '$cbo')";
	$query = $wpdb->query($sql_insere);
	$numero = $wpdb->insert_id;
	
}

// Se foi inserido uma pessoa física, insere um pedido de contratação.
if((isset($numero))){
	if($numero > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`, `ano_base`) 
		VALUES ('$evento', '1', '$numero','1','2020')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id){
			$mensagem = '<div class="alert alert-success"> Pedido inserido com sucesso. </div>';			
		}
	}
}

// Insere Pedido Via Busca PF
if(isset($_POST['insere_pedido_pf'])){
	if($_POST['insere_pedido_pf'] > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$id_pessoa = $_POST['insere_pedido_pf'];
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`, `ano_base`) 
		VALUES ('$evento', '1', '$id_pessoa', '1', '2020')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id > 0){
			$mensagem = '<div class="alert alert-success">Pedido criado com sucesso.</div>';
		}else{
			$mensagem = '<div class="alert alert-warning">Erro ao criar Pedido.</div>';
		}
	}
}
// Insere Pedido Via Busca PJ
if(isset($_POST['insere_pedido_pj'])){
	if($_POST['insere_pedido_pj'] > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 2;
		$id_pessoa = $_POST['insere_pedido_pj'];
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`, `ano_base`) 
		VALUES ('$evento', '2', '$id_pessoa', '1', '2020')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id > 0){
			$mensagem = '<div class="alert alert-success">Pedido criado com sucesso.</div>';
		}else{
			$mensagem = '<div class="alert alert-warning">Erro ao criar Pedido.</div>';
		}
	}
}

if(isset($_POST['apaga_pedido'])){
	$sql_apaga = "UPDATE sc_contratacao SET publicado = '0' WHERE idPedidoContratacao = '".$_POST['apaga_pedido']."'";
	$query_apaga = $wpdb->query($sql_apaga);

	$sql_apaga_mov = "UPDATE sc_mov_orc SET publicado = '0' WHERE idPedidoContratacao = '".$_POST['apaga_pedido']."'";
	$query_apaga_mov = $wpdb->query($sql_apaga_mov);

	if($query_apaga == 1){
		$mensagem = '<div class="alert alert-success"> Pedido cancelado com sucesso. </div>';
	}
}

if(isset($_POST['reabrir_pedido'])){
	$evento = retornaPedido($_POST['reabrir_pedido']);
	$id = $evento['id'];
	$sql_apaga = "UPDATE sc_evento SET dataEnvio = NULL WHERE idEvento = '$id'";
	$query_apaga = $wpdb->query($sql_apaga);
	$sql_status_apaga = "UPDATE sc_evento SET status = '1' WHERE idEvento = '$id'";
	$query_status_apaga = $wpdb->query($sql_status_apaga);
	if($query_apaga == 1){
		$mensagem = '<div class="alert alert-success"> Evento  reaberto com sucesso. </div>';
	}
}

if(isset($_POST['inserir_pj'])){

	//carrega as variaveis	
	$razao_social =  	  $_POST["razao_social"];
	$cnpj =  	  $_POST["cnpj"];
	$CCM  =  	  $_POST["CCM"];
	$cep =  	  $_POST["cep"];
	$Numero =  	  $_POST["Numero"];
	$rua =  	  $_POST["rua"];
	$bairro =  	  $_POST["bairro"];
	$Complemento =  	  $_POST["Complemento"];
	$cidade =  	  $_POST["cidade"];
	$uf =  	  $_POST["uf"];
	$Telefone1 = 	  $_POST["Telefone1"];
	$Telefone2 =  	  $_POST["Telefone2"];
	$Telefone3 =  	  $_POST["Telefone3"];
	$Email =  	  $_POST["Email"];
	$observacoes =  	  $_POST["observacoes"];
	$Banco =  	  $_POST["Banco"];
	$agencia =  	  $_POST["agencia"];
	$conta =  	  $_POST["conta"];
	$cbo =  	  $_POST["cbo"];
	$rep_nome =  	  $_POST["rep_nome"];
	$rep_cpf =  	  $_POST["rep_cpf"];
	$rep_rg =  	  $_POST["rep_rg"];
	$rep_civil =  	  $_POST["rep_civil"];
	$rep_nacionalidade = $_POST['rep_nacionalidade'];
	$data_atualiza = date("Y-m-d");
	$id_usuario = $user->ID;
	$sql_insere = "INSERT INTO `sc_pj` (`RazaoSocial`, `CNPJ`, `CCM`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DataAtualizacao`, `Observacao`, `IdUsuario`, `codBanco`, `agencia`, `conta`, `rep_nome`, `rep_rg`, `rep_cpf`, `rep_nacionalidade`, `rep_civil`) 
	VALUES ('$razao_social', '$cnpj', '$CCM', '$cep', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$data_atualiza', '$observacoes', '$id_usuario', '$Banco', 'agencia', '$conta', '$rep_nome', '$rep_cpf', '$rep_civil', '$rep_nacionalidade`', '$rep_civil')";	
	$query = $wpdb->query($sql_insere);
	$numero_pj = $wpdb->insert_id;
	
}
if((isset($numero_pj))){
	if($numero_pj > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`, `ano_base`) 
		VALUES ('$evento', '2', '$numero_pj','1','2020')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id){
			$mensagem = '<div class="alert alert-success"> Pedido inserido com sucesso. </div>';			
		}
	}
}


?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Pedidos de Contratação</h1>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<p>Filtro: <a href="?" >Todos os pedidos</a> | <a href="?f=liberacao" >Pedidos sem Número de Liberação ou Data de Pedido de Liberação</a></p>
			</div>
		</div>

		<?php 
		// se existe pedido, listar
		
		?>
		
		<div class="container">
			<div class="row">    
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Num</th>
							<th>Data</th>
							<th>NumLib</th>
							<th>Tipo</th>
							<th>Nome / Razão Social</th>
							<th>Objeto</th>
							<th>Período</th>
							<th>Valor</th>
							<th></th>

						</tr>
					</thead>
					<tbody>
						<?php 
						if(isset($_GET['f'])){
							$sql_seleciona = "SELECT * FROM sc_contratacao WHERE publicado = '1' AND ano_base = '2020' AND (liberado = '0000-00-00' OR nLiberacao = '') 
                            AND (idEvento IN (SELECT idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL AND (status = '3' OR status = '4') 
                            AND cancelamento = '0') OR idAtividade <> '0') AND (valor <> '0' AND valor IS NOT NULL) 
                            AND (dotacao IS NOT NULL AND dotacao <> '0')  ORDER BY nLiberacao DESC";
							$peds = $wpdb->get_results($sql_seleciona,ARRAY_A);
						}
						else
						{
							$sql_seleciona = "SELECT * FROM sc_contratacao WHERE publicado = '1' AND ano_base = '2020' 
                            AND (liberado != '0000-00-00' OR nLiberacao != '') AND (idEvento IN (SELECT idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL 
                            AND (status = '3' OR status = '4') AND cancelamento = '0') OR idAtividade <> '0') AND (valor <> '0' AND valor IS NOT NULL) 
                            AND (dotacao IS NOT NULL AND dotacao <> '0')  ORDER BY nLiberacao DESC";
							$peds = $wpdb->get_results($sql_seleciona,ARRAY_A);

						}	

						for($i = 0; $i < count($peds); $i++){
							if($peds[$i]['idEvento'] != 0 AND $peds[$i]['idEvento'] != NULL){
								$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
							}else{
						//$pedido = atividade($peds[$i]['idAtividade']);
								$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
							}
					//var_dump($pedido);
							?>
							<tr>
								<td><?php echo $peds[$i]['idPedidoContratacao']; ?></td>
								<td><?php if($pedido['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?></td>
								<td><?php echo $peds[$i]['nLiberacao']; ?></td>
								<td><?php if ($peds[$i]['idEvento'] == '0' ) { echo "Atividade";
							} else { echo "Evento"; } ?></td>
							<td><?php echo $pedido['nome']; ?></td>
							<td><?php echo $pedido['objeto']; ?></td>
							<td><?php echo $pedido['periodo']; ?></td>
							<td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>
							<td>	
								<form method="POST" action="?p=editar_pedido" class="form-horizontal" role="form" target="_blank">
									<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pedido">
								</form>
								<?php 

								?></td>
								<td>	
									<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
										<input type="hidden" name="reabrir_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Reabrir Pedido">
									</form>
									<?php 

									?></td>

									<td>	
									<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
										<input type="hidden" name="apaga_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Cancelar Pedido">
									</form>
									<?php 

									?></td>

								</tr>
							<?php } // fim do for?>	

						</tbody>
					</table>
				</div>



			</div>
		</section>

		<?php 
		break;
		case "listativ":
		?>


		<?php 
		break;
		case "busca_pf":
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Busca Pessoa Física</h3>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=resultado_pf" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Insira o CPF (somente números) *</label>
									<input type="text" name="busca" class="form-control cpf" id="inputSubject" />
								</div>
							</div>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
case "resultado_pf":

$sql_busca = "SELECT Id_PessoaFisica, Nome, NomeArtistico, CPF FROM sc_pf WHERE CPF LIKE '%".$_POST['busca']."%'";
echo $sql_busca;
$res = $wpdb->get_results($sql_busca,ARRAY_A);
if(count($res) > 0){
		// lista os cpfs encontrados
	?>
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pessoas Físicas Encontradas</h1>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>CPF</th>
							<th>Nome</th>
							<th>Nome Artístico</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						for($i = 0; $i < count($res); $i++){

							?>
							<tr>
								<td><?php echo $res[$i]['CPF']; ?></td>
								<td><?php echo $res[$i]['Nome']; ?></td>
								<td><?php echo $res[$i]['NomeArtistico']; ?></td>
								<td></td>
								<td>	
									<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
										<input type="hidden" name="insere_pedido_pf" value="<?php echo $res[$i]['Id_PessoaFisica']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Pedido de Contratação">
									</form>
									<?php 

									?></td>
								</tr>
							<?php } // fim do for?>	

						</tbody>
					</table>
				</div>

			</div>
		</section>
		<?php

	}else{
		// Cria um formulário de inserção
		?>
		<script type="text/javascript">
			$(function() {
				$( ".calendario" ).datepicker();
				$( ".hora" ).mask("99:99");
				$( ".min" ).mask("999");
				$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
			});
		</script>

		<script type="text/javascript" >

			$(document).ready(function() {

				function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        	if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>

    <section id="inserir" class="home-section bg-white">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-offset-2 col-md-8">

    				<h3>Inserir Pessoa Física</h3>
    				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

    			</div>
    		</div> 
    		<div class="row">
    			<div class="col-md-offset-1 col-md-10">
    				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
    					<div class="row">
    						<div class="col-12">
    							<label>Nome Completo *</label>
    							<input type="text" name="Nome" class="form-control" id="inputSubject" />
    						</div>
    					</div>
    					<br />
    					<div class="row">
    						<div class="col-12">
    							<label>Nome Artístico *</label>
    							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" />
    						</div>
    					</div>
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>CPF *</label>
    							<input type="text" name="CPF" class="form-control cpf" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
    						</div>
    						<div class="col-6">
    							<label>RG *</label>
    							<input type="text" name="RG" class="form-control" id="inputSubject" />
    						</div>

    					</div>
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Estado civil</label>
    							<select class="form-control" name="tipo" id="inputSubject" name="IdEstadoCivil">
    								<option>Escolha uma opção</option>
    								<?php echo geraTipoOpcao("civil") ?>
    							</select>
    						</div>
    						<div class="col-6">
    							<label>Data de Nascimento</label>
    							<input type="text" class="form-control calendario" name="DataNascimento"> 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Local de Nascimento</label>
    							<input type="text" class="form-control" name="LocalNascimento" > 
    						</div>
    						<div class="col-6">
    							<label>Nacionalidade</label>
    							<input type="text" class="form-control" name="Nacionalidade" > 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>CEP</label>
    							<input type="text" class="form-control" name="cep" id="cep" > 
    						</div>
    						<div class="col-6">
    							<label>Número</label>
    							<input type="text" class="form-control" name="Numero" > 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-12">
    							<label>Logradouro *</label>
    							<input type="text" name="rua" class="form-control" id="rua" />
    						</div>
    					</div>
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Bairro</label>
    							<input type="text" class="form-control" name="bairro" id="bairro" > 
    						</div>
    						<div class="col-6">
    							<label>Complemento</label>
    							<input type="text" class="form-control" name="Complemento"> 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Cidade</label>
    							<input type="text" class="form-control" name="cidade" id="cidade"> 
    						</div>
    						<div class="col-6">
    							<label>Estado</label>
    							<input type="text" class="form-control" name="uf" id="uf"> 
    						</div>
    					</div>	
    					<br />					
    					<div class="row">
    						<div class="col-6">
    							<label>Telefone 01</label>
    							<input type="text" class="form-control" name="Telefone1" > 
    						</div>
    						<div class="col-6">
    							<label>Telefone 02</label>
    							<input type="text" class="form-control" name="Telefone2"> 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Telefone 03</label>
    							<input type="text" class="form-control" name="Telefone3"> 
    						</div>
    						<div class="col-6">
    							<label>E-mail</label>
    							<input type="text" class="form-control" name="Email"> 
    						</div>
    					</div>	
    					<br />

    					<div class="row">
    						<div class="col-6">
    							<label>CCM</label>
    							<input type="text" class="form-control" name="CCM"> 
    						</div>
    						<div class="col-6">
    							<label>INSS</label>
    							<input type="text" class="form-control" name="INSS" > 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>DRT</label>
    							<input type="text" class="form-control" name="DRT" > 
    						</div>
    						<div class="col-6">
    							<label>OMB</label>
    							<input type="text" class="form-control" name="OMB" > 
    						</div>
    					</div>	
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Função</label>
    							<input type="text" class="form-control" name="Funcao" > 
    						</div>
    						<div class="col-6">
    							<label>PIS</label>
    							<input type="text" class="form-control" name="PIS" > 
    						</div>
    					</div>	
    					<br />					
    					<div class="row">
    						<div class="col-12">
    							<label>Observações </label>
    							<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
    						</div>
    					</div>
    					<br />
    					<div class="row">
    						<div class="col-6">
    							<label>Banco</label>
    							<input type="text" class="form-control" name="Banco" > 
    						</div>
    						<div class="col-6">
    							<label>Agência bancária</label>
    							<input type="text" class="form-control" name="agencia"> 
    						</div>
    					</div>	
    					<br />					
    					<div class="row">
    						<div class="col-6">
    							<label>Conta Corrente</label>
    							<input type="text" class="form-control" name="conta"> 
    						</div>
    						<div class="col-6">
    							<label>CBO</label>
    							<input type="text" class="form-control" name="cbo"> 
    						</div>
    					</div>	
    					<br />					

    					<div class="form-group">
    						<div class="col-md-offset-2">
    							<input type="hidden" name="inserir_pf" value="1" />
    							<?php 
    							?>
    							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Física e Criar Pedido de Contratação">
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
    </section>	
    
    <?php
}

?>

<?php 
break;
case "busca_pj":
?>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Busca Pessoa Jurídica</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=resultado_pj" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Insira o CNPJ *</label>
							<input type="text" name="busca" class="form-control cnpj" id="inputSubject" />
						</div>
					</div>
					<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar">
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</section>

<?php 
break;
case "resultado_pj":
?>
<?php 
$sql_busca = "SELECT Id_PessoaJuridica, CNPJ, RazaoSocial FROM sc_pj WHERE CNPJ LIKE '%".$_POST['busca']."%'";
echo $sql_busca;
$res = $wpdb->get_results($sql_busca,ARRAY_A);
if(count($res) > 0){
		// lista os cpfs encontrados
	?>
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pessoas Jurídica Encontradas</h1>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>CNPJ</th>
							<th>Razão Social</th>
							<th>Nome Artístico</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						for($i = 0; $i < count($res); $i++){
							
							?>
							<tr>
								<td><?php echo $res[$i]['CNPJ']; ?></td>
								<td><?php echo $res[$i]['RazaoSocial']; ?></td>
								<td><?php //echo $res[$i]['NomeArtistico']; ?></td>
								<td></td>
								<td>	
									<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
										<input type="hidden" name="insere_pedido_pj" value="<?php echo $res[$i]['Id_PessoaJuridica']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Pedido de Contratação">
									</form>
									<?php 
									
									?></td>
								</tr>
							<?php } // fim do for?>	
							
						</tbody>
					</table>
				</div>

			</div>
		</section>


		<?php		
	}else{
		// Cria um formulário de inserção
		?>


		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Inserir Pessoa Jurídica</h3>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
							<div class="row">
								<div class="col-12">
									<label>Razão Social</label>
									<input type="text" name="razao_social" class="form-control" id="inputSubject" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-12">
									<label>CNPJ</label>
									<input type="text" name="cnpj" class="form-control" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-12">
									<label>CCM</label>
									<input type="text" name="CCM" class="form-control" id="inputSubject" />
								</div>
							</div>
							<br />

							<div class="row">
								<div class="col-6">
									<label>CEP</label>
									<input type="text" class="form-control" name="cep" id="cep" > 
								</div>
								<div class="col-6">
									<label>Número</label>
									<input type="text" class="form-control" name="Numero" > 
								</div>
							</div>	
							<br />
							<div class="row">
								<div class="col-12">
									<label>Logradouro *</label>
									<input type="text" name="rua" class="form-control" id="rua" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-6">
									<label>Bairro</label>
									<input type="text" class="form-control" name="bairro" id="bairro" > 
								</div>
								<div class="col-6">
									<label>Complemento</label>
									<input type="text" class="form-control" name="Complemento"> 
								</div>
							</div>	
							<br />
							<div class="row">
								<div class="col-6">
									<label>Cidade</label>
									<input type="text" class="form-control" name="cidade" id="cidade"> 
								</div>
								<div class="col-6">
									<label>Estado</label>
									<input type="text" class="form-control" name="uf" id="uf"> 
								</div>
							</div>	
							<br />					
							<div class="row">
								<div class="col-6">
									<label>Telefone 01</label>
									<input type="text" class="form-control" name="Telefone1" > 
								</div>
								<div class="col-6">
									<label>Telefone 02</label>
									<input type="text" class="form-control" name="Telefone2"> 
								</div>
							</div>	
							<br />
							<div class="row">
								<div class="col-6">
									<label>Telefone 03</label>
									<input type="text" class="form-control" name="Telefone3"> 
								</div>
								<div class="col-6">
									<label>E-mail</label>
									<input type="text" class="form-control" name="Email"> 
								</div>
							</div>	
							<br />

							
							<div class="row">
								<div class="col-12">
									<label>Observações </label>
									<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-6">
									<label>Banco</label>
									<input type="text" class="form-control" name="Banco" > 
								</div>
								<div class="col-6">
									<label>Agência bancária</label>
									<input type="text" class="form-control" name="agencia"> 
								</div>
							</div>	
							<br />					
							<div class="row">
								<div class="col-6">
									<label>Conta Corrente</label>
									<input type="text" class="form-control" name="conta"> 
								</div>
								<div class="col-6">
									<label>CBO</label>
									<input type="text" class="form-control" name="cbo"> 
								</div>
							</div>	
							<br />					

							<div class="row">
								<div class="col-12">
									<h3>Representante Legal</h3>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-12">
									<label>Nome Completo</label>
									<input type="text" name="rep_nome" class="form-control" id="inputSubject" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-6">
									<label>CPF *</label>
									<input type="text" name="rep_cpf" class="form-control cpf" id="inputSubject"  />
								</div>
								<div class="col-6">
									<label>RG *</label>
									<input type="text" name="rep_rg" class="form-control" id="inputSubject" />
								</div>

							</div>
							<br />
							<div class="row">
								<div class="col-6">
									<label>Estado civil</label>
									<select class="form-control" name="rep_civil" id="inputSubject" name="IdEstadoCivil">
										<option>Escolha uma opção</option>
										<?php echo geraTipoOpcao("civil") ?>
									</select>
								</div>
								<div class="col-6">
									<label>Data de Nascimento</label>
									<input type="text" class="form-control calendario" name="rep_nascimento"> 
								</div>
							</div>	
							<br />

							<div class="row">
								<div class="col-12">
									<label>Nacionalidade</label>
									<input type="text" name="rep_nacionalidade" class="form-control" id="inputSubject" />
								</div>
							</div>
							<br />
							<div class="form-group">
								<div class="col-md-offset-2">
									<input type="hidden" name="inserir_pj" value="1" />
									<?php 
									?>
									<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Jurídica e Criar Pedido de Contratação">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>	
		
		<?php
	}
	
	?>

	
	<?php 	 
	break;	 
 case "editar_pf": //editar pessoa física
 ?>

 <section id="inserir" class="home-section bg-white">
 	<div class="container">
 		<div class="row">
 			<div class="col-md-offset-2 col-md-8">

 				<h3>Inserir Pessoa Física</h3>
 				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

 			</div>
 		</div> 
 		<div class="row">
 			<div class="col-md-offset-1 col-md-10">
 				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
 					<div class="row">
 						<div class="col-12">
 							<label>Nome Completo *</label>
 							<input type="text" name="Nome" class="form-control" id="inputSubject" />
 						</div>
 					</div>
 					<br />
 					<div class="row">
 						<div class="col-12">
 							<label>Nome Artístico *</label>
 							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" />
 						</div>
 					</div>
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>CPF *</label>
 							<input type="text" name="CPF" class="form-control cpf" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
 						</div>
 						<div class="col-6">
 							<label>RG *</label>
 							<input type="text" name="RG" class="form-control" id="inputSubject" />
 						</div>

 					</div>
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Estado civil</label>
 							<select class="form-control" name="tipo" id="inputSubject" name="IdEstadoCivil">
 								<option>Escolha uma opção</option>
 								<?php echo geraTipoOpcao("civil") ?>
 							</select>
 						</div>
 						<div class="col-6">
 							<label>Data de Nascimento</label>
 							<input type="text" class="form-control calendario" name="DataNascimento"> 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Local de Nascimento</label>
 							<input type="text" class="form-control" name="LocalNascimento" > 
 						</div>
 						<div class="col-6">
 							<label>Nacionalidade</label>
 							<input type="text" class="form-control" name="Nacionalidade" > 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>CEP</label>
 							<input type="text" class="form-control" name="cep" id="cep" > 
 						</div>
 						<div class="col-6">
 							<label>Número</label>
 							<input type="text" class="form-control" name="Numero" > 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-12">
 							<label>Logradouro *</label>
 							<input type="text" name="rua" class="form-control" id="rua" />
 						</div>
 					</div>
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Bairro</label>
 							<input type="text" class="form-control" name="bairro" id="bairro" > 
 						</div>
 						<div class="col-6">
 							<label>Complemento</label>
 							<input type="text" class="form-control" name="Complemento"> 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Cidade</label>
 							<input type="text" class="form-control" name="cidade" id="cidade"> 
 						</div>
 						<div class="col-6">
 							<label>Estado</label>
 							<input type="text" class="form-control" name="uf" id="uf"> 
 						</div>
 					</div>	
 					<br />					
 					<div class="row">
 						<div class="col-6">
 							<label>Telefone 01</label>
 							<input type="text" class="form-control" name="Telefone1" > 
 						</div>
 						<div class="col-6">
 							<label>Telefone 02</label>
 							<input type="text" class="form-control" name="Telefone2"> 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Telefone 03</label>
 							<input type="text" class="form-control" name="Telefone3"> 
 						</div>
 						<div class="col-6">
 							<label>E-mail</label>
 							<input type="text" class="form-control" name="Email"> 
 						</div>
 					</div>	
 					<br />

 					<div class="row">
 						<div class="col-6">
 							<label>CCM</label>
 							<input type="text" class="form-control" name="CCM"> 
 						</div>
 						<div class="col-6">
 							<label>INSS</label>
 							<input type="text" class="form-control" name="INSS" > 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>DRT</label>
 							<input type="text" class="form-control" name="DRT" > 
 						</div>
 						<div class="col-6">
 							<label>OMB</label>
 							<input type="text" class="form-control" name="OMB" > 
 						</div>
 					</div>	
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Função</label>
 							<input type="text" class="form-control" name="Funcao" > 
 						</div>
 						<div class="col-6">
 							<label>PIS</label>
 							<input type="text" class="form-control" name="PIS" > 
 						</div>
 					</div>	
 					<br />					
 					<div class="row">
 						<div class="col-12">
 							<label>Observações </label>
 							<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
 						</div>
 					</div>
 					<br />
 					<div class="row">
 						<div class="col-6">
 							<label>Banco</label>
 							<input type="text" class="form-control" name="Banco" > 
 						</div>
 						<div class="col-6">
 							<label>Agência bancária</label>
 							<input type="text" class="form-control" name="agencia"> 
 						</div>
 					</div>	
 					<br />					
 					<div class="row">
 						<div class="col-6">
 							<label>Conta Corrente</label>
 							<input type="text" class="form-control" name="conta"> 
 						</div>
 						<div class="col-6">
 							<label>CBO</label>
 							<input type="text" class="form-control" name="cbo"> 
 						</div>
 					</div>	
 					<br />					

 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<input type="hidden" name="inserir_pf" value="1" />
 							<?php 
 							?>
 							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Física e Criar Pedido de Contratação">
 						</div>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
 </section>	

 <?php 	 
 break;	 
 case "editar_pj": //editar pessoa jurídica
 ?>
 
 <?php 	 
 break;	 
 case "editar_pedido": //editar pessoa jurídica

 if(isset($_POST['editar_pedido'])){
 	$id_pedido = $_POST['editar_pedido'];
 }

 if(isset($_POST['atualizar_pedido'])){
 	$id_pedido = $_POST['atualizar_pedido'];

 	if($_POST['data_liberado'] != ""){
 		$liberado = exibirDataMysql($_POST['data_liberado']);
 	}else{
 		$liberado = '0000-00-00';
 	}
 	if($_POST['data_empenhado'] != ""){
 		$empenhado = exibirDataMysql($_POST['data_empenhado']);
 	}else{
 		$empenhado = '0000-00-00';	
 	}
 	
 	$valor =  dinheiroDeBr($_POST["valor"]);
 	$dotacao =   $_POST["dotacao"];
 	$observacao =   $_POST["observacao"];
 	$n_liberacao = $_POST['n_liberacao'];

 	
 	$sql_atualiza = "UPDATE sc_contratacao SET
 	valor = '$valor',
 	dotacao = '$dotacao',
 	liberado = '$liberado',
 	empenhado = '$empenhado',
 	nLiberacao = '$n_liberacao',
 	observacao = '$observacao'
 	WHERE idPedidoContratacao = '$id_pedido'";
 	$res = $wpdb->query($sql_atualiza);
 	if($res == 1){
 		$mensagem = alerta("Pedido atualizado com sucesso.","success");
 	}else{
 		$mensagem = alerta("Pedido não atualizado.","warning");
 	}

 	
 	$y = atualizaHistorico($id_pedido);
	//var_dump($y);
 }
 
 
 
 
 $pedido = recuperaDados("sc_contratacao",$id_pedido,"idPedidoContratacao");
 $ped = retornaPedido($id_pedido);
 ?>
 <section id="inserir" class="home-section bg-white">
 	<div class="container">
 		<div class="row">
 			<div class="col-md-offset-2 col-md-8">

 				<h3>Editar Pedido</h3>
 				<?php if(isset($mensagem)){ echo $mensagem;} ?>

 			</div>
 		</div> 
 		<div class="row">
 			<div class="col-md-offset-1 col-md-10">
 				<form method="POST" action="?p=editar_pedido" class="form-horizontal" role="form">
 					<div class="row">
 						<div class="col-12">
 							<p><strong><?php echo $id_pedido; ?><br />
 								<?php echo $ped['objeto']; ?> <br />
 								<?php echo $ped['nome_razaosocial']." ( ".$ped['cpf_cnpj']." )"; ?> <br />
 								<?php echo $ped['periodo'] ?> <?php if($ped['local'] != ""){echo " - ".$ped['local'];}?><br />
 								Responsável: <?php echo $ped['usuario']; ?><br />
 								Enviado em: <?php if($pedido['dataEnvio'] != '0000-00-00 00:00:00' OR $pedido['dataEnvio'] != NULL){echo exibirDataHoraBr($ped['dataEnvio']);}?> <br />
 								<?php 
 								$dotac = orcamento($pedido['dotacao']);
 								$saldo = $dotac['revisado'] - $dotac['liberado'];
 								?>
 								Saldo Dotação: <?php echo dinheiroParaBr($saldo); ?>
 								
 							</strong>
 							
 						</p>						
 					</div>
 				</div>
 				<br />
 				<div class="row">
 					<div class="col-6">
 						<label>Data do Pedido </label>
 						<input type="text" name="data_liberado" class="form-control calendario" value="<?php if($pedido['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?>">
 					</div>
 					<div class="col-6">
 						<label>Data do Empenho </label>
 						<input type="text" name="data_empenhado" class="form-control calendario" value="<?php if($pedido['empenhado'] != '0000-00-00'){echo exibirDataBr($pedido['empenhado']);} ?>">					
 					</div>
 				</div>
 				<br />
 				
 				<div class="row">
 					<div class="col-12">
 						<label>Número de liberação</label>
 						<input type="text" name="n_liberacao" class="form-control" id="inputSubject" value="<?php echo $pedido['nLiberacao']; ?>" />
 					</div>
 				</div>
 				<br />					
 				<div class="row">
 					<div class="col-12">
 						<label>Valor *</label>
 						<input type="text" name="valor" class="form-control valor" id="inputSubject" value="<?php echo dinheiroParaBr($pedido['valor']); ?>" />
 					</div>
 				</div>
 				<br />
 				
 				<div class="row">
 					<div class="col-12">
 						<label>Dotação</label>
 						<select class="form-control" name="dotacao" id="inputSubject" >
 							<option>Escolha uma opção</option>
 							<?php echo geraOpcaoDotacao(date('Y'),$pedido['dotacao']); ?>
 						</select>			
 					</div>
 				</div>
 				<br />
 				
 				<div class="row">
 					<div class="col-12">
 						<label>Observação:</label>
 						<textarea name="observacao" class="form-control" rows="10" ><?php echo $pedido['observacao']; ?></textarea>					
 					</div>
 				</div>
 				<br />

 				<div class="row">
 					<div class="col-12">
 						<input type="hidden" name="atualizar_pedido" value="<?php echo $id_pedido; ?>" />
 						<?php 
 						?>
 						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Pedido">
 					</div>
 				</div>
 			</form>
 			<form action="arquivo.php?p=inserir&tipo=302&id=<?php echo $id_pedido; ?>" method="post">
 				<br />
 				<div class="row">
 					<div class="col-12">
 						<input type="hidden" name="atualizar_pedido" value="<?php echo $id_pedido; ?>" />
 						<?php 
 						?>
 						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Anexar arquivos ao Pedido">
 					</div>
 				</div>
 			</form>
 			
 			<div class="row">
 				<div class="col-12">
 					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=396&id=<?php echo $id_pedido?>" target="_blank">Gerar Pedido de Liberação</a>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-12">
 					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=320&id=<?php echo $id_pedido?>" target="_blank">Gerar Pedido de Liberação Multiplas Dotações</a>
 				</div>
 			</div>
 			
 		</div>
 	</div>
 </div>
</section>	



<?php 
break;
} // fim da switch p

?>

</main>
</div>
</div>

<?php 
include "footer.php";
?>