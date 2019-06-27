
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
  <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">BARTIRA / SC.PSA</a>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Início</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../wp-admin">WP-Admin</a>
      </li>
    </ul>
    <form class="form-inline mt-2 mt-md-0" method="POST" action="busca.php?p=busca" >
     <a class="navbar-brand" style="color:white;" > Olá, <?php echo $user->display_name; ?></a>
     
     
   </form>
 </div>
</nav>