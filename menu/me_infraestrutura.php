<?php include "barra.php"; 

?>

<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Infraestrutura <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="infraestrutura.php">Listar Eventos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="infraestrutura.php?p=pedido">Gerar Pedido de Contratação</a>
        </li>
      </ul>

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
        </li>
      </ul>
    </nav>
