<?php
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
    /*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
    $_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
    /*** REDIRECT TO LOGIN PAGE ***/
    header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";
$orcamento = orcamentoTotal(2020);
$projeto = array();
$w = 0;


?>
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 30;  /* this affects the margin in the printer settings */
    }

</style>
<style>

    .pieChart{
        float: right;
    }
    .margem {
        margin: 20px;

    }
    }
</style>

<div class="margem">

    <div>


        <?php
        // Seleciona as categorias
        $sql_cat = "SELECT DISTINCT filtro FROM ava_ranking WHERE edital = '577' ORDER BY filtro ASC";
        $res_cat = $wpdb->get_results($sql_cat,ARRAY_A);

        for($i = 0; $i < count($res_cat); $i++){
            $filtro = $res_cat[$i]['filtro'];
            ?>

            <h2><?php echo $filtro; ?></h2>
            <table border= "1" class="table table-striped">
                <thead>
                <tr>
                    <th>Proposta</th>
                    <th>Inscrição</th>
                    <th>Proponente</th>
                    <th>Nota01</th>
                    <th>Nota02</th>
                    <th>Média</th>
                    <th>Coletiva</th>
                    <th>Final</th>
                    <th>Obs</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $sql_ins = "SELECT inscricao,nota FROM ava_ranking WHERE filtro = '$filtro' AND edital = '577'  ORDER BY nota DESC";
                $res_ins = $wpdb->get_results($sql_ins,ARRAY_A);

                for($k = 0; $k < count($res_ins); $k++){
                    $inscricao = $res_ins[$k]['inscricao'];
                    $sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";
                    $json = $wpdb->get_row($sel,ARRAY_A);
                    $res_json = converterObjParaArray(json_decode(($json['descricao'])));
                    $nota = nota($inscricao,577);
                    ?>

                    <tr>
                        <td><?php echo $res_json['2.1 Título do Projeto']; ?></td>
                        <td><?php echo $inscricao; ?></td>
                        <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
                        <td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
                        <td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
                        <td><?php if(isset($nota['media'])){echo substr($nota['media'], 0, 2);}?></td>
                        <td><?php echo retornaNota2Fase($inscricao,'578'); ?></td>
                        <td><?php echo $res_ins[$k]['nota']; ?></td>
                        <td><?php echo retornaAnotacao($inscricao,1,'577'); ?></td>
                    </tr>

                    <?php
                }
                ?>

                </tbody>
            </table>
            <?php

        }



        ?>



    </div>

    <div style="page-break-before: always;"> </div>
    <br /><br /><br />
    <p>-------------------------------------------------------------- <br />
        Antonio Carlos Pedro Ferreira </p><br /><br />
    <p>-------------------------------------------------------------- <br />
        Cristiana Gimenes Parada dos Santos</p><br /><br />
</div>