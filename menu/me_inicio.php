
            <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

                    <div class="sidebar-brand-text mx-3">Administrador</div>
                </a>
<?php 

$per = opcaoDados('usuario',$user->ID);

function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}
				
$ordem = uasort($per['modulos'],'cmp');

?>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">



                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Cadastros
                </div>


                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					
					
                        <i class="fas fa-users"></i>
                        <span>Módulos</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
  <?php 				
foreach($per['modulos'] as $modular){
				$modulo = retornaModulo($modular);
?>                         
                            <a class="collapse-item" href="<?php echo $modulo['descricao']; ?>.php"><?php echo $modulo['tipo']; ?>	</a>
<?php } ?>							
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-home"></i>
                        <span>Turmas / Disciplinas</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                           
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu5 ?>">Cursos</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu6 ?>">Projeto</a>
                            <a class="collapse-item" href="index.php?pag=<?php echo $menu7 ?>">Turmas</a>
                             <a class="collapse-item" href="index.php?pag=<?php echo $menu9 ?>">Diciplinas</a>

                        </div>
                    </div>
                </li>

                 <li class="nav-item">
                    <a class="nav-link" href="../painel-secretaria" target="_blank">
                        <i class="fas fa-phone-alt fa-chart-area"></i>
                        <span>Painel Secretaria</span></a>
                </li>
                <!--

                 <li class="nav-item">
                    <a class="nav-link" href="../painel-tesoureiro" target="_blank">
                        <i class="fas fa-dollar-sign fa-chart-area"></i>
                        <span>Painel Tesouraria</span></a>
                </li>
                       -->

                <!-- Divider -->
                <hr class="sidebar-divider">

              
              

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>

<?php //include "barra.php"; ?>


<div class="container-fluid">
	<div class="row">
		<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

			<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="#">Selecione o Módulo <span class="sr-only">(current)</span></a>
				</li>
			</ul>

			
			<ul class="nav nav-pills flex-column">
				
<ul class="nav nav-pills flex-column">
				<li class="nav-item">
					<a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
				</li>
			</ul>
		</nav>
