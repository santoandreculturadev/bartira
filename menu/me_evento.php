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
            <a class="nav-link" href="evento.php?p=editar">Informações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ocorrencias.php?p=listar">Editar Ocorrências</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ocorrencias.php?p=inserir">Inserir Ocorrências</a>
          </li>

          
         <!-- <li class="nav-item">
            <a class="nav-link" href="arquivo.php">Listar Arquivos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="arquivo.php?p=inserir">Inserir Arquivos</a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" href="contratacao.php">Pedidos de Contratação</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="producao.php">Produção / Comunicação</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="enviar.php">Enviar Evento</a>
          </li>
        </ul>

        <?php 
      }
      ?>


      <ul class="nav nav-pills flex-column">

        <li class="nav-item">
          <a class="nav-link" href="evento.php">Listar Meus Eventos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="evento.php?p=inserir">Inserir Novo Evento</a>
        </li>
        <!--
		<li class="nav-item">
          <a class="nav-link" href="documentos_artista.doc">Documentos do Artista</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="documentos_pj.doc">Documentos da Empresa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="documentos_pf.doc">Documentos Pessoa Física</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="montar_os.doc">Como montar uma OS</a>
        </li> -->
      </ul>

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="evento.php?p=pedido">Listar Meus Pedidos de Contratação</a>
        </li>
      </ul>

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="evento.php?p=dotacoes">Listar Dotações</a>
        </li>
      </ul>


      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
        </li>
      </ul>
    </nav>
