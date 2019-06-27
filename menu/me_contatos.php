<?php include "barra.php"; ?>


<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Contatos <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="contato.php">Listar Contatos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contato.php?p=inserir">Inserir novo Contato</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contato.php?p=buscar">Buscar Contato</a>
        </li>
      </ul>

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
        </li>
      </ul>
    </nav>
