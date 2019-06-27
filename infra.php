<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();

?>

<body>

	
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip(); 
		});
	</script>

	
	<style>
	.tooltip {
		position: relative;
		display: inline-block;
		border-bottom: 1px dotted black;
	}

	.tooltip .tooltiptext {
		visibility: hidden;
		width: 120px;

		text-align: center;
		border-radius: 6px;
		padding: 5px 0;
		position: absolute;
		z-index: 1;
		bottom: 125%;
		left: 50%;
		margin-left: -60px;
		opacity: 0;
		transition: opacity 0.3s;
	}

	.tooltip .tooltiptext::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -5px;
		border-width: 5px;
		border-style: solid;
		border-color: #555 transparent transparent transparent;
	}

	.tooltip:hover .tooltiptext {
		visibility: visible;
		opacity: 1;
	}
</style>
<?php include "menu/me_arquivo.php"; ?>

<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<?php 
	switch($p){
		case "inicio": 
		
		$id = $_SESSION['id'];
		$entidade = $_SESSION['entidade'];
		
		global $wpdb;

		?>
		<section id="contact" class="home-section bg-white">
			<div class="container">
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<?php
					// listar o evento; criar um if para cada tipo de upload
						$evento = evento($_SESSION['id']);
						?>
						<h1><?php 
						?></h1>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Infra</th>
								<th>Valor</th>
								<th>Diárias</th>
							</tr>
						</thead>
						<tbody>
							<?php 

							
							$sql_list =  "SELECT * FROM sc_infra WHERE tipo = 'ata' ORDER BY cod ASC";
							
				//echo $sql_list;
							$res = $wpdb->get_results($sql_list,ARRAY_A);
							
							for($i = 0; $i < count($res); $i++){
								?>
								<tr>
									<td><?php echo $res[$i]['cod']; ?></td>
									<td><a href="#" data-toggle="tooltip" title="<?php echo $res[$i]['descricao']; ?>" data-placement="right"> <?php echo $res[$i]['nome']; ?></a>
									</div>
								</td>

								<td><?php echo $res[$i]['valor_diaria']; ?></td>
								<td><input type="text" name="<?php echo $res[$i]['cod']; ?>"></td>

							</tr>
						<?php } // fim do for?>	
						
					</tbody>
				</table>
			</div>

		</div>
	</section>
	
	<?php 	 
	break;	 
	case "inserir":


	?>
	<section id="enviar" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h2>Envio de Arquivos</h2>
						<p>Nesta página, você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, etc. O tamanho máximo do arquivo deve ser 60MB.</p>
						<p> Em caso de envio de fotografia, considerar as seguintes especificações técnicas:<br />
							- formato: horizontal <br />
						- tamanho: mínimo de 300dpi”</p>
						<?php
						if( isset( $_POST['enviar'] ) )
						{
							$pathToSave = 'upload/';
		// A variavel $_FILES é uma variável do PHP, e é ela a responsável
		// por tratar arquivos que sejam enviados em um formulário
		// Nesse caso agora, a nossa variável $_FILES é um array com 3 dimensoes
		// e teremos de trata-lo, para realizar o upload dos arquivos
		// Quando é definido o nome de um campo no form html, terminado por []
		// ele é tratado como se fosse um array, e por isso podemos ter varios
		// campos com o mesmo nome
							$i = 0;
							$msg = array( );
							$arquivos = array( array( ) );
							foreach(  $_FILES as $key=>$info )
							{
								foreach( $info as $key=>$dados )
								{
									for( $i = 0; $i < sizeof( $dados ); $i++ )
									{
										$arquivos[$i][$key] = $info[$key][$i];
									}
								}
							}
							$i = 1;
							foreach( $arquivos as $file )
							{
			// Verificar se o campo do arquivo foi preenchido
								if( $file['name'] != '' )
								{
									$pre = date('Ymdhis')."_";
									$data =  date('Y-m-d H:i:s');
									$arquivoTmp = $file['tmp_name'];
									$arquivo = $pathToSave.$pre.semAcento($file['name']);
									$arquivo_base = $pre.semAcento($file['name']);
									if(file_exists($arquivo))
									{
										echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
									}
									else
									{
										global $wpdb;
										$entidade = $_SESSION['entidade'];
										$id = $_SESSION['id'];
										if(isset($_SESSION['tipo'])){
											$entidade = $_SESSION['tipo'];
											$id = $_SESSION['idPessoa'];
										}
					$tipo2 = 301; // evento
					if(isset($_GET['tipo'])){
						$tipo2 = $_GET['tipo'];  //outros tipos
						$id = $_GET['id'];
					}


					$tipo = '';
					$usuario = $user->ID;
					$sql = "INSERT INTO `sc_arquivo` (`idArquivo`, `id`, `entidade`, `tipo`, `arquivo`, `datatime`, `usuario`, `publicado`) 
					VALUES (NULL, $id, '$entidade', '$tipo2', '$arquivo_base', '$data', '$usuario', '1')";
					$wpdb->query($sql);
					
					if( !move_uploaded_file( $arquivoTmp, $arquivo ) )
					{
						$msg[$i] = 'Erro no upload do arquivo '.$i;
					}
					else
					{
						$msg[$i] = sprintf('Upload do arquivo %s foi um sucesso!',$i);
					}
				}
			}
			$i++;
		}
		// Imprimimos as mensagens geradas pelo sistema
		foreach( $msg as $e )
		{
			echo " <div id = 'mensagem_upload'>";
			printf('%s<br>', $e);
			echo " </div>";
		}
	}
	?>
	<br />
	<div class = "center">
		<form method='POST' enctype='multipart/form-data' action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>
			<p><input type='file' name='arquivo[]'></p>

			<br>
			<input type='submit' value='Enviar' name='enviar'>
		</form>
	</div>
</div>
</div>
</div>	  
</div>
</section>


<?php 
break;
case "editar":
?>
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