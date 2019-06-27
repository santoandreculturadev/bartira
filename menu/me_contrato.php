<?php include "barra.php"; ?>


<div class="container-fluid">
	<div class="row">
		<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="#">Módulo Contratos <span class="sr-only">(current)</span></a>
				</li>
			</ul>
			
			<ul class="nav nav-pills flex-column">	
				<li class="nav-item">
					<a class="nav-link" href="contrato.php">Listar Contratações</a>
				</li>
			</ul>
			
			
			<?php 

			if((isset($_GET['p']) AND $_GET['p'] == 'editar_pedido' )){
				if(isset($_POST['atualizar_pedido'])){
					$id_pedido = $_POST['atualizar_pedido'];
				}else{
					$id_pedido = $_POST['editar_pedido'];
					
				}

				if(isset($_POST['checklist'])){
					$json = "{";
					foreach($_POST as $chave=>$valor){
						$$chave = $valor;
						$json .= '"'.$chave.'": "'.$valor.'",';
					}
					$json = substr($json,0,-1)."}";	
					global $wpdb;
					$select = "SELECT id FROM sc_opcoes WHERE entidade = 'checklist' AND id_entidade = '$id_pedido'";
					$res = $wpdb->get_row($select,ARRAY_A);
				//var_dump($res);
				if($res == NULL){ //insere
					$insert = "INSERT INTO `sc_opcoes` ( `entidade`, `id_entidade`, `opcao`) 
					VALUES ('checklist', '$id_pedido', '$json')";
					$ins = $wpdb->query($insert);
					
				}else{ //atualiza
					$update = "UPDATE sc_opcoes SET
					`opcao` = '$json' WHERE id = '".$res['id']."'";
					$upd = $wpdb->query($update);
					
				}
			}
		//echo $json;
			$opcao = opcaoDados('checklist',$id_pedido);
		//var_dump($json_array);
		//var_dump($opcao);
			?>

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="#">Checklist</a>
				</li>
				<form action="?p=editar_pedido" method="POST">
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="verba" <?php if(isset($opcao['verba'])){ echo "checked='checked'";} ?>/> Verba suficiente</a></p>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="justificativa" <?php if(isset($opcao['justificativa'])){ echo "checked='checked'";} ?>/> Justificativa da área requisitante</a></p>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="autorizacao" <?php if(isset($opcao['autorizacao'])){ echo "checked='checked'";} ?>/> Autorização do Secretário</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="resp_fiscal" <?php if(isset($opcao['resp_fiscal'])){ echo "checked='checked'";} ?>/> Declaração de LRF</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="proposta" <?php if(isset($opcao['proposta'])){ echo "checked='checked'";} ?>/> Proposta de Trabalho</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="nepotismo" <?php if(isset($opcao['nepotimo'])){ echo "checked='checked'";} ?>/> Declaracão de Nepotismo</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="prazo_exec" <?php if(isset($opcao['prazo_exec'])){ echo "checked='checked'";} ?>/> Prazo de execução</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="prazo_paga" <?php if(isset($opcao['prazo_paga'])){ echo "checked='checked'";} ?>/> Prazo de pagamento</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="rg" <?php if(isset($opcao['rg'])){ echo "checked='checked'";} ?>/> RG</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="cpf" <?php if(isset($opcao['cpf'])){ echo "checked='checked'";} ?>/> CPF</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="inss" <?php if(isset($opcao['inss'])){ echo "checked='checked'";} ?>/> Cartão INSS/PIS</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="procuracao" <?php if(isset($opcao['procuracao'])){ echo "checked='checked'";} ?>/> Procuração dos Representados</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="cnd" <?php if(isset($opcao['cnd'])){ echo "checked='checked'";} ?>/> CND/FGTS/CNDT/Cert. Estadual/Municipal/SN</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="contrato_social" <?php if(isset($opcao['contrato_social'])){ echo "checked='checked'";} ?>/> Contrato Social</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="cnpj" <?php if(isset($opcao['cnpj'])){ echo "checked='checked'";} ?>/> CNPJ</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="atestado_curriculo" <?php if(isset($opcao['atestado_curriculo'])){ echo "checked='checked'";} ?>/> Atestados e currículos</a>
					</li>
					<li class="nav-item">
						<p class="nav-link" href="#" /><input type="checkbox" name="critica_reconhecida" <?php if(isset($opcao['critica_reconhecida'])){ echo "checked='checked'";} ?>/> Material da crítica</a>
					</li>
					<li class="nav-item">
						<input type="hidden" name="checklist" value="<?php echo $id_pedido; ?>" />
						<input type="hidden" name="editar_pedido" value="<?php echo $id_pedido; ?>" />
						<p class="nav-link" href="#" /><input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Checklist" ></p>
					</li>
				</ul>
			</form>

			<?php 
		}
		?>

		<ul class="nav nav-pills flex-column">
			<li class="nav-item">
				<a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
			</li>
		</ul>
	</nav>
