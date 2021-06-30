<?php include "barra.php"; ?>


<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Orçamento <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      

      <?php 
      
      ?>
      <ul class="nav nav-pills flex-column">
       <li class="nav-item button">
        <a class="nav-link" href="orcamento.php?p=visaogeral">Visão Geral</a>
      </li>
      <?php $autorizados = array(1,193,5,62,146,171);
      if(in_array($user->ID,$autorizados)){ ?>		
       <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=mov_inserir">Inserir Movimentação</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=mov_listar">Listar Movimentações</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=inserir">Inserir Dotação</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=listar">Listar Dotações</a>
      </li> 
        <a class="nav-link" href="orcamento.php?p=listaprojeto">Projetos</a>
      </li> 


	  
	 <?php 
	 $ano_orcamento = anoOrcamento();
	 //var_dump($ano_orcamento);
	 for($i = 0; $i < count($ano_orcamento);$i++){
	 ?> 
      <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=planejamento&ano=<?php echo $ano_orcamento[$i]['ano_base']  ?>">Planejamento <?php echo $ano_orcamento[$i]['ano_base']  ?></a>
      </li> 
	 <?php } ?>

      <li class="nav-item">
        <a class="nav-link" href="orcamento.php?p=giap">GIAP</a>
      </li> 
    <?php } ?>
  </ul>

  <?php 
  ?>
  
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
    </li>
  </ul>
</nav>
