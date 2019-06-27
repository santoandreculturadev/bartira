<?php include "header.php"; ?>

<body>
  
  <?php include "menu/menu_editais.php"; ?>
  
  <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
    <h1>Editais</h1>

    <h2>Editais em aberto</h2>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Título</th>
            <th>Link</th>
            <th>Período de Avaliação</th>
            <th>Fases</th>
          </tr>
        </thead>
        <tbody>

         <?php 
         $url = "http://culturaz.santoandre.sp.gov.br/projeto/";
         $edital = editais($user->ID);
         for($i = 0; $i < count($edital); $i++){
           ?>		
           
           <tr>
            <td></td>
            <td><?php echo $edital[$i]['titulo']; ?></td>
            <td><a href="<?php echo $url.$edital[$i]['mapas']; ?>" target=_blank><?php echo  $url.$edital[$i]['mapas']?></a></td>
            <td><?php echo $edital[$i]['periodo']; ?></td>
            <td><?php echo $edital[$i]['fases']['quantidade']; ?></td>
          </tr>
        <?php } ?>		


      </tbody>
    </table>
  </div>
</main>
</div>
</div>

<?php 
include "footer.php";
?>