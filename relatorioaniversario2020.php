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
    <h1>CONVOCATÓRIA NO. 06.11.2019 - SC</h1>
    <h2>Aniversário da Cidade 2020</h2>


    <h3>Relação de intervenções selecionadas</h3>

    <p>As inscrições para a convocatória, ocorridas entre 11/11/2019 e 28/12/2019 somaram um total de 94 propostas. Os membros da comissão de seleção reuniram-se na SC
    nos dias 12/02/2020 e 13/02/2020, das 9:00 horas as 18:00 horas, para análise coletiva. </p>

    <p>Participaram os seguintes pareceristas: Marcelo de Souza Guilhem Dorador, Luciana Zorzato e Rodrigo Fernando da Silva (SC), Antonio Duque de Souza Neto,
        Carlos Eduardo M. Rizzo e Carolina de Melo Ferrarese (Sociedade Civil).
    </p>

    <p>A comissão, em consenso, decidiu não avaliar os projetos sob números on-1753116959, on-1637758956 e on-330644840 em função do item 4.3.b da convocatória em questão.
        A comissão também decidiu que não haveria nota de corte, ou seja, que todas as demais propostas seriam avaliadas na etapa coletiva.
    </p>

    <p>Durante os dias de trabalho todas as propostas foram debatidas, analisadas no coletivo, tiveram seus vídeos e releases vistos, e na sequência
    pontuadas.</p>


    <div>


        <?php
        // Seleciona as categorias
        $sql_cat = "SELECT DISTINCT filtro FROM ava_ranking WHERE edital = '579' ORDER BY filtro ASC";
        $res_cat = $wpdb->get_results($sql_cat,ARRAY_A);

        for($i = 0; $i < count($res_cat); $i++){
            $filtro = $res_cat[$i]['filtro'];
            ?>

            <h3><?php echo $filtro; ?></h3>
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
                $sql_ins = "SELECT inscricao,nota FROM ava_ranking WHERE filtro = '$filtro' AND edital = '579'  ORDER BY nota DESC";
                $res_ins = $wpdb->get_results($sql_ins,ARRAY_A);

                for($k = 0; $k < count($res_ins); $k++){
                    $inscricao = $res_ins[$k]['inscricao'];
                    $sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";
                    $json = $wpdb->get_row($sel,ARRAY_A);
                    $res_json = converterObjParaArray(json_decode(($json['descricao'])));
                    $nota = nota($inscricao,579);
                    ?>

                    <tr>
                        <td><?php echo $res_json['Título']; ?></td>
                        <td><?php echo $inscricao; ?></td>
                        <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
                        <td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
                        <td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
                        <td><?php if(isset($nota['media'])){echo substr($nota['media'], 0, 2);}?></td>
                        <td><?php echo retornaNota2Fase($inscricao,'580'); ?></td>
                        <td><?php echo $res_ins[$k]['nota']; ?></td>
                        <td><?php echo retornaAnotacao($inscricao,16,'580'); ?></td>
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


    <br /><br /><br />
    <p>Antonio Duque de Souza Neto&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
         </p><br />
    <p>Carlos Eduardo M. Rizzo &nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
        </p><br />
    <p>Carolina de Melo Ferrarese &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
        </p><br />
    <p>Luciana Zorzato&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
        </p><br />
    <p>Marcelo de Souza G. Dourador&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
        </p><br />
    <p>Rodrigo Fernando da Silva&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------------------------------------- <br />
        </p><br />

</div>
