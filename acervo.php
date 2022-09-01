<?php 
/*
    > criar tabela sc_tainancan_oracle (id, tombo, tainacan, date);   
    > importar as IDs do Tainacan 

    rotina:
        gera tabela app_tainacan (museu e casa do olhar);
        verifica se existe o tombo na tabela sc_tainacan_oracle
            se não existe:
                 cria e insere dados no taincan via api
            se existe:
                compara infos de cada campo | tainacan via api x app_tainacan
                atualiza no tainacan caso o campo não bata


*/

if(isset($_GET['pag'])){
    $pag = $_GET['pag'];
}else{
    $pag = "";
}


?>

<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Acervo Oracle <> Tainacan</h1>

    <?php 
    switch($pag){   
    
        case "atualiza":
        
        // atualiza os dados vindos do oracle     

        include ".\acervo\gera_casa.php";
        include ".\acervo\gera_museu.php";    

        break;

        default:
           ?>
           <h2></h2>
           <p>Este módulo atualiza as informações do Programa Gestor de Acervos da Secretaria de Cultura 
            na plataforma Tainacan em <strong>https://www3.santoandre.sp.gov.br/cultura/acervosculturais/</strong></p>
           <?php 
        

        break;





    }
    
    
    
    
    
    
    
    ?>





        </main>

	
<?php 
include "footer.php";
?>