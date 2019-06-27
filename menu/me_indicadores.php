<?php include "barra.php"; 

?>


<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Indicadores <span class="sr-only">(current)</span></a>
        </li>
      </ul>

        <?php
      $peruser = array(1,5,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="acervos_filtro.php">Acervos</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,18,33,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listaracervos">Listar Relatório Acervos</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,18,33,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inseriracervos">Inserir Relatório Acervos</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
         $peruser = array(1,5);
          if(in_array($user->ID,$peruser)){ ?>
         <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="indicadores.php?p=tabelacontinuadas">Resumo Ações Continuadas / Exposições - TABELA</a>
          </li>
        <?php } ?>
        <?php ?>

      <?php
      $peruser = array(1,5,68);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="continuadas_filtro.php">Ações Continuadas / Exposições</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,18,33,68,69);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listarcontinuadas">Listar Ações Continuadas / Exposições</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,18,33,68,69);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inserircontinuadas">Inserir Ações Continuadas / Exposições</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,5,49,52,66,68,71,153);
      if(in_array($user->ID,$peruser)){ ?>
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="biblioteca_filtro.php">Biblioteca</a>
          </li>
        <?php } ?>
        <?php ?>
        
        <?php
        $peruser = array(1,17,49,52,66,68,71,153);
        if(in_array($user->ID,$peruser)){ ?>
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarbiblioteca">Listar Relatório Biblioteca</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,17,49,52,66,68,71,153);
          if(in_array($user->ID,$peruser)){ ?>     
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inserirbiblioteca">Inserir Relatório Biblioteca</a>
            </li>
          <?php } ?>
          <?php ?>

           <?php
      $peruser = array(1,5,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="comunicacao_filtro.php">Comunicação</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,12,97,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listarcomunicacao">Listar Relatório Comunicação</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,12,97,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inserircomunicacao">Inserir Relatório Comunicação</a>
        </li>
      <?php } ?>
      <?php ?>

       <?php
      $peruser = array(1,5,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="inscricoes_filtro.php">Convocatórias</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,68,79);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listarinscricoes">Listar Relatório Convocatórias</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,68,79);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inseririnscricoes">Inserir Relatório Convocatórias</a>
        </li>
      <?php } ?>
      <?php ?>
 
      <?php
         $peruser = array(1,5);
          if(in_array($user->ID,$peruser)){ ?>
         <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="indicadores.php?p=tabelaevento">Resumo Eventos - TABELA</a>
          </li>
        <?php } ?>
        <?php ?>


          <?php
          $peruser = array(1,5,68);
          if(in_array($user->ID,$peruser)){ ?>      
            <li class="nav-item">
              <a class="nav-link" href="evento_filtro.php">Eventos</a>
            </li>
          <?php } ?>
          <?php ?>
          

          <?php
          $peruser = array(1,16,17,39,142,42,49,52,34,33,28,18,53,77,38,70,71,35,47,26,46,48,79,12,45,56,144,41,145,68,69,66,145,152,153);
          if(in_array($user->ID,$peruser)){ ?>      
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarevento">Listar Relatório Eventos</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,16,17,39,142,42,49,52,34,33,28,18,53,77,38,70,71,35,47,26,46,48,79,12,45,56,144,41,145,68,69,66,145,152,153);
          if(in_array($user->ID,$peruser)){ ?>       
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inserirevento">Inserir Relatório Eventos</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,5,17,68);
          if(in_array($user->ID,$peruser)){ ?>             
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listar_evento_sem_indicador">Eventos Sem Indicador</a>
            </li>
          <?php } ?>
          <?php ?>

           <?php
         $peruser = array(1,5,45,106);
          if(in_array($user->ID,$peruser)){ ?>
         <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="indicadores.php?p=tabelaincentivo">Resumo Incentivo - TABELA</a>
          </li>
        <?php } ?>
        <?php ?>

          <?php
          $peruser = array(1,5,68);
          if(in_array($user->ID,$peruser)){ ?>
            <li class="nav-item">
              <a class="nav-link" href="incentivo_filtro.php">Disciplinas/Cursos Incentivo à Criação</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,17,45,35,47,26,48,46,56,79,41,145,68);
          if(in_array($user->ID,$peruser)){ ?>
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarincentivo">Listar Disciplinas/Cursos Incentivo à Criação</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,17,45,35,47,26,48,46,56,79,41,145,68);
          if(in_array($user->ID,$peruser)){ ?>     
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inseririncentivo">Inserir Disciplinas/Cursos Incentivo à Criação</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
      $peruser = array(1,5);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="orcamento_filtro.php">Orçamento</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,60);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listarorcamento">Listar Relatório Orçamento</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,60);
      if(in_array($user->ID,$peruser)){ ?>   
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inserirorcamento">Inserir Relatório Orçamento</a>
        </li>
      <?php } ?>
      <?php ?>


          <?php
          $peruser = array(1,5,68);
          if(in_array($user->ID,$peruser)){ ?>  
           <li class="nav-item">
            <a class="nav-link" href="culturaz_filtro.php">Plataforma CulturAZ</a>
          </li>
        <?php } ?>
        <?php ?>

        <?php
        $peruser = array(1,17,68);
        if(in_array($user->ID,$peruser)){ ?>  
         <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=listarculturaz">Listar Relatório Plataforma CulturAZ</a>
        </li>
      <?php } ?>
      <?php ?>

      <?php
      $peruser = array(1,17,68);
      if(in_array($user->ID,$peruser)){ ?>  
        <li class="nav-item">
          <a class="nav-link" href="indicadores.php?p=inserirculturaz">Inserir Relatório Plataforma CulturAZ</a>
        </li>
      <?php } ?>
      <?php ?>

       <?php
          $peruser = array(1,5,68);
          if(in_array($user->ID,$peruser)){ ?>   
            <li class="nav-item">
              <a class="nav-link" href="redes_filtro.php">Redes Sociais</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,17,34,45,46,48,18,35,52,49,47,142,33,26,28,41,145,68,71,66,145,152,153);
          if(in_array($user->ID,$peruser)){ ?>   
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarredes">Listar Relatório Redes Sociais</a>
            </li>
          <?php } ?>
          <?php ?>

          <?php
          $peruser = array(1,17,34,45,46,48,18,35,52,49,47,142,33,26,28,41,145,68,71,66,145,152,153);
          if(in_array($user->ID,$peruser)){ ?>  
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inserirredes">Inserir Relatório Redes Sociais</a>
            </li>
          <?php } ?>
          <?php ?>
          

    </ul>

    <ul class="nav nav-pills flex-column">

      <li class="nav-item">
        <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
      </li>
    </ul>
  </nav>