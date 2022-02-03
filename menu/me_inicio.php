<?php include "barra.php"; ?>


<div class="container-fluid">
	<div class="row">
		<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="#">Selecione o Módulo <span class="sr-only">(current)</span></a>
				</li>
			</ul>

			
			<ul class="nav nav-pills flex-column">
				<?php 
				$per = opcaoDados('usuario',$user->ID);
				
				$n_modulos = (is_array($per['modulos']) ? count($per['modulos']) : 0);
				
				for($i = 0; $i < $n_modulos ; $i++){
					$modulo = retornaModulo($per['modulos'][$i]);
					
					?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $per['modulos'][$i]; ?>.php"><?php echo $modulo['tipo']; ?></a>
					</li>
					<?php 
				}
				?>
			</ul>

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
				</li>
			</ul>
		</nav>
