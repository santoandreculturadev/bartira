<?php include "barra.php"; ?>

<div class="container-fluid">
	<div class="row">
		<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="#">Agenda Teatros<span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<div>

			</div>	
			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link" style="background:orange; color: white; align = center;" href="<?php //echo $_SERVER['REQUEST_URI']."&status=2"; ?>">Cine Theatro de Variedades Carlos Gomes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" style="background:blue; color: white; align = center;" href="<?php //echo $_SERVER['HTTP_URI']."&status=3"; ?>">Saguão do Teatro Municipal de Santo André</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" style="background:red; color: white; align = center;" href="<?php //echo $_SERVER['HTTP_URI']."&status=3"; ?>">Teatro Municipal de Santo André Maestro Flavio Florence</a>
				</li>
								<li class="nav-item">
					<a class="nav-link" style="background:purple; color: white; align = center;" href="<?php //echo $_SERVER['HTTP_URI']."&status=3"; ?>">Palco do Saguão do Teatro Municipal de Santo André</a>
				</li>
								<li class="nav-item">
					<a class="nav-link" style="background:gray; color: white; align = center;" href="<?php //echo $_SERVER['HTTP_URI']."&status=3"; ?>">Auditório Heleny Guariba</a>
				</li>


				<li class="nav-item">
					<a class="nav-link" style="background:green; color: white; align = center;" href="<?php //echo $_SERVER['HTTP_URI']."&status=4"; ?>">Teatro Conchita de Moraes</a>
					</li>      
					</ul>
					<form action="?" method="GET">

						<label><center>Local</center></label>
						<select class="form-control" name="local" id="inputSubject" >
							<option value="0">Todos os locais</option>
							<?php geraTipoOpcao("local",$_GET['local']) ?>
							</select>
							<br />
							<select class="form-control" name="locala" id="inputSubject" >
							<option value="0">Todos os locais</option>
							<?php geraTipoOpcao("local",$_GET['local']) ?>
							</select>
							<br />
							<select class="form-control" name="localb" id="inputSubject" >
							<option value="0">Todos os locais</option>
							<?php geraTipoOpcao("local",$_GET['local']) ?>
							</select>
							<br />
						<label><center>Linguagem</center></label>
						<select class="form-control" name="linguagem" id="inputSubject" >
							<option value="0">Todas as linguagens</option>
							<?php geraTipoOpcao("linguagens",$_GET['linguagem']) ?>
						</select>
						<br />
						<label><center>Projeto</center></label>
						<select class="form-control" name="projeto" id="inputSubject" >
							<option value="0">Todos os projetos</option>
							<?php geraTipoOpcao("projeto",$_GET['projeto']) ?>
						</select>
						<br />
						<input type="submit" class="btn btn-theme btn-md btn-block" name="filtro" value="Aplicar filtro" />
					</form>  	
					


					<ul class="nav nav-pills flex-column">


					</ul>
				</nav>


				