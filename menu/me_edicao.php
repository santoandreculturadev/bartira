<?php include "barra.php"; 

?>

<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Evento <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      

      <?php 
      if((isset($_GET['p']) AND $_GET['p'] == 'editar') OR isset($_SESSION['id'])){

        ?>
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="edicao.php?p=editar">Informações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ocorrencias.php?p=listar">Listar Ocorrências</a>
          </li>

          <a class="nav-link" href="producao.php">Infraestrutura</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="enviar.php">Enviar</a>
        </li>

      </ul>

      <?php 
    }
    ?>


    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link" href="edicao.php">Listar Meus Eventos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="edicao.php?p=fip2018">Listar Eventos FIP2018</a>
      </li>
    </ul>

    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link" href="evento.php?p=pedido">Listar Meus Pedidos de Contratação</a>
      </li>

    </ul>


    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
      </li>
    </ul>
  </nav>
