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
	
	<?php include "menu/me_pessoa.php"; ?>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/maskMoney.js"></script> 
	<script>
		$(function() {
			$( ".calendario" ).datepicker();
			$( ".hora" ).mask("99:99");
			$( ".min" ).mask("999");
			$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
		});



	</script>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
case "inicio": //Lista as contratações
?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Pessoa</h1>
			</div>
		</div>

	</div>
</section>



<?php 	 
break;	 
 case "inserir_pf": //inserir pessoa física
 ?>
 <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
 	$(function() {
 		$( ".calendario" ).datepicker();
 		$( ".hora" ).mask("99:99");
 		$( ".min" ).mask("999");
 		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
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
 				<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Nome Completo *</label>
 							<input type="text" name="titulo" class="form-control" id="inputSubject" />
 						</div>
 					</div>
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Nome Artístico *</label>
 							<input type="text" name="titulo" class="form-control" id="inputSubject" />
 						</div>
 					</div>
 					<div class="form-group">
 						<div class="col-6">
 							<label>Nome Artístico *</label>
 							<input type="text" name="titulo" class="form-control" id="inputSubject" />
 						</div>

 					</div>
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Tipo de movimentação</label>
 							<select class="form-control" name="tipo" id="inputSubject" >
 								<option>Escolha uma opção</option>
 								<?php echo geraTipoOpcao("mov_orc") ?>
 							</select>
 						</div>
 					</div>	
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Dotação</label>
 							<select class="form-control" name="dotacao" id="inputSubject" >
 								<option>Escolha uma opção</option>
 								<?php echo geraOpcaoDotacao('2018'); ?>
 							</select>
 						</div>
 					</div>	
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Valor *</label>
 							<input type="text" name="valor" class="form-control valor" id="inputSubject" />
 						</div>
 					</div>
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Data *</label>
 							<input type="text" name="data" class="form-control calendario"  />
 						</div>
 					</div>					
 					
 					
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<label>Descição / Observação*</label>
 							<textarea name="descricao" class="form-control" rows="10" ></textarea>
 						</div> 
 					</div>	
 					<div class="form-group">
 						<div class="col-md-offset-2">
 							<input type="hidden" name="mov_inserir" value="1" />
 							<?php 
 							?>
 							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Movimentação">
 						</div>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
 </section>
 <?php 	 
 break;	 
 case "editar_pf": //editar pessoa física
 ?>


 <?php 	 
 break;	 
 case "inserir_pj": //inserir pessoa jurídica
 ?>

 <?php 	 
 break;	 
 case "editar_pj": //editar pessoa jurídica
 ?>
 
 <?php 	 
 break;	 
 case "inserir_rep": //inserir representante legal
 ?>

 <?php 	 
 break;	 
 case "editar_rep": //editar representante legal
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