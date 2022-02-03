<?php include "barra.php"; 

?>

<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Aprovação <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="aprovacao.php">Listar Meus Eventos para Aprovação</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aprovacao.php?p=aprovados">Listar Meus Eventos Aprovados</a>
        </li>
        <li>
          <a class="nav-link" href="aprovacao.php">Listar Meus Eventos</a>
        </li>
        <li>
		        <li>
          <a class="nav-link" href="aprovacao.php?p=cancelados">Listar Eventos Cancelados</a>
        </li>
        <li>
          <a class="nav-link" href="aprovacao.php?p=serie">Aprovação em Série</a>
        </li>
        <?php 
        $lim = opcaoDados("sistema",0);
        if(in_array($user->ID,$lim['diretores'])){

         ?>
         <!-- 
         <li>
          <a class="nav-link" href="aprovacao.php?p=foradeprazo">Eventos Não Enviados</a>
        </li> -->
      <?php } ?>
    </ul>

    <ul class="nav nav-pills flex-column">

      <li class="nav-item">
        <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
      </li>
    </ul>
  </nav>
