<?php include "header.php"; ?>
<?php
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 'listar_evento_sem_indicador';
}
$usuario =  $user->ID;

//session_start(); // carrega a sessão

?>

<?php

error_reporting(0);
ini_set(“display_errors”, 0);

?>




    <body>

<?php include "menu/me_indicadores.php"; ?>
  <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">


        <?php
        switch ($p){
        case "inicio": ?>
            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Relatórios de Público</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <p>Escolha no Menu ao lado o tipo de indicador que deseja inserir.</p>

                    </div>

                </div>
            </section>
            <?php
            break;
        
    
        case "inserirevento_longaduracao":
            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>

            <script type="application/javascript">
                $(function () {
                    $('#ano_base').change(function () {
                        if ($(this).val()) {
                            $('#idEvento').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.evento.longa.ajax.php?', {ano: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idEvento + '">' + j[i].nomeEvento + '</option>';
                                }
                                $('#idEvento').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#idEvento').html('<option value="">-- Escolha um Evento --</option>');
                        }
                    });
                });
            </script>

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
							$('#enviar_id').val($(this).val());
                        } 
                    });
                });
            </script>

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
                            $('#mes_ano').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.mes.ajax.php?', {idEvento: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].dia + '">' + j[i].mes + '</option>';
                                }
                                $('#mes_ano').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#mes_ano').html('<option value="">-- Escolha um Evento --</option>');
                        }
                    });
                });
            </script>
 <script type="application/javascript">
	$(function()
	{
		$('#idEvento').change(function()
		{
			if( $(this).val() )
			{
				$('#idOcorrencia').hide();
				$('.carregando').show();
				$.getJSON('inc/ind.ocor.ajax.php?',{idEvento: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
					}	
					$('#idOcorrencia').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
			}
		});
	});
</script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h2>Relatórios de Público / Longa Duração- Inserir</h2>
                            <?php
                            // listar o evento;
                            ?>
                            <br/><Br/>
                        </div>
                    </div>

                </div>

                <?php
               
                ?>
                <div class="row">
                    <form class="formocor" action="?p=listarevento" method="POST" role="form">
					<div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <select class="form-control" name="tipo" id="ano_base">
                                    <option>Selecione</option>
									<?php opcaoAnoBase(); ?>
                                </select>
                            </div>
                        </div>    
					
					
					
					
					
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do Evento *</label>
                                <select class="form-control" name="idEvento" id="idEvento" required>
                                    <option value=''>Escolha uma opção (<?php echo count($eventos); ?> )</option>
                                    <?php for ($i = 0; $i < count($eventos); $i++) { ?>
                                        <option value='<?php echo $eventos[$i]['idEvento'];?>.' 
										<?php 
										if(isset($_GET['evento']) AND $_GET['evento'] == $eventos[$i]['idEvento']){
											echo " selected";
													
										}
										
										?>
										>
										
										
										<?php echo $eventos[$i]['nomeEvento']." (".$eventos[$i]['idEvento'].")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Local</label>
							<select class="form-control" name="idOcorrencia" id="idOcorrencia" >

							</select>
						</div>
					</div>
						
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relatório do mês</label>
                                <select class="form-control" name="mes_ano" id="mes_ano">
                                    <option>Selecione</option>
									<?php $mes_ano = geraMesOcorrencia($idEvento); 
									for ($i = 0; $i < count($mes_ano); $i++){
									
									?>
                                    <option value="01/<?php echo $mes_ano[$i];?>" ><?php echo $mes_ano[$i];?></option>

									<?php } ?>
                                </select>
                            </div>
                        </div>                     
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Dias úteis do período (se for data única, não preencher)</label>
                                <input type="text" name="ndias" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Contagem</label>
                                <select class="form-control" name="contagem" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="1" selected>Número total (absoluto)</option>
                                    <option value="2">Média Geral (por dia)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público (Número de Espectadores)</label>
                                <input type="text" name="valor" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Público</label>
                                <select class="form-control" name="tipo" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="1" selected>Geral</option>
                                    <option value="2">Específico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" id="enviar_id" value="1"/>
								<input type="hidden" name="tipo_relatorio" value="longaduracao" />
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>


            <?php
            break;
        case "inserirevento_dataunica":
            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>
			
			         <script type="application/javascript">
                $(function () {
                    $('#ano_base').change(function () {
                        if ($(this).val()) {
                            $('#idEvento').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.evento.unica.ajax.php?', {ano: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idEvento + '">' + j[i].nomeEvento + '</option>';
                                }
                                $('#idEvento').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#idEvento').html('<option value="">-- Escolha um Evento --</option>');
                        }
                    });
                });
            </script>
			

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
							$('#enviar_id').val($(this).val());
                        } 
                    });
                });
            </script>

 <script type="application/javascript">
	$(function()
	{
		$('#idEvento').change(function()
		{
			if( $(this).val() )
			{
				$('#idOcorrencia').hide();
				$('.carregando').show();
				$.getJSON('inc/ind.ocor.ajax.php?',{idEvento: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
					}	
					$('#idOcorrencia').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
			}
		});
	});
</script>

            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h2>Relatórios de Público - Inserir</h2>
                            <?php
                            // listar o evento;
                            ?>
                            <br/><Br/>
                        </div>
                    </div>

                </div>

                <?php
				$ano_base = NULL;
				if(isset($_GET['evento'])){
					$evento = evento($_GET['evento']);
					$ano_base = $evento['ano_base'];
					
				 $idUsuario = $user->ID;
                if ($idUsuario != '1' AND $idUsuario != '17' AND $idUsuario != '68') {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario')  AND (dataEnvio IS NOT NULL) AND status IN (3,4) ORDER BY nomeEvento ASC";
                } else {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL ORDER BY nomeEvento ASC";

                }
                $eventos = $wpdb->get_results($sql_lista_evento, ARRAY_A);
					
				} 
                ?>
                <div class="row">
                    <form class="formocor" action="?p=listarevento" method="POST" role="form">
                        					<div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <select class="form-control" name="tipo" id="ano_base">
                                    <option>Selecione</option>
									<?php opcaoAnoBase($ano_base); ?>
                                </select>
                            </div>
                        </div>    
					
					
					
					
					
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do Evento *</label>
                                <select class="form-control" name="idEvento" id="idEvento" required>
                                    <option value=''>Escolha uma opção </option>
                                    <?php 
									
									if(isset($_GET['evento'])){
											echo "<option value='".$_GET['evento']."' selected>".$evento['titulo']."</option>";
													
										}
									
									
										
									
										?>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Local</label>
							<select class="form-control" name="idOcorrencia" id="idOcorrencia" >
								<?php if(isset($_GET['evento'])){
										$ocor = listaLocaisOcorrencia($_GET['evento']);
											for($k = 0; $k < count($ocor); $k++){
												$local = tipo($ocor[$k]['local']);	
												echo "<option value='".$ocor[$k]['local']."' selected>".$local['tipo']."</option>";
													
											}
										}
										?>
							</select>
						</div>
					</div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Data do Evento:</label>
                                <input type='text' class="form-control calendario" name="mes_ano"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público (Número de Espectadores)</label>
                                <input type="text" name="valor" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Público</label>
                                <select class="form-control" name="tipo" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="1" selected>Geral</option>
                                    <option value="2">Específico</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" id="enviar_id" value="1"/>
								<input type="hidden" name="tipo_relatorio" value="dataunica" />
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;
			case "inserircontinuadas":
            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
                            $('#idOcorrencia').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.ocor.ajax.php?', {idEvento: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
                                }
                                $('#idOcorrencia').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
                        }
                    });
                });
            </script>

            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h2>Exposição / Ação Continuada - Inserir</h2>
                            <?php
                            // listar o evento;
                            ?>
                            <br/><Br/>
                        </div>
                    </div>

                </div>

                <?php
                $idUsuario = $user->ID;
                if ($idUsuario != '1' AND $idUsuario != '17' AND $idUsuario != '68') {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario') AND (ano_base = 'ano_base') AND (dataEnvio IS NOT NULL) ORDER BY nomeEvento ASC";
                } else {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL AND (ano_base = 'ano_base') ORDER BY nomeEvento ASC";

                }
                $eventos = $wpdb->get_results($sql_lista_evento, ARRAY_A);
                ?>
                <div class="row">
                    <form class="formocor" action="?p=listarcontinuadas" method="POST" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do Evento</label>
                                <select class="form-control" name="idEvento" id="idEvento">
                                    <option>Selecione</option>
                                    <?php for ($i = 0; $i < count($eventos); $i++) { ?>
                                        <option value='<?php echo $eventos[$i]['idEvento']; ?>'><?php echo $eventos[$i]['nomeEvento']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome da Atração Principal</label>
                                <input type="text" name="atracao_principal" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Local</label>
                                <select class="form-control" name="idOcorrencia" id="idOcorrencia">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Outros Locais</label>
                                <input type="text" name="outros_locais" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Bairro</label>
                                <select class="form-control" name="bairro" id="bairro">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("bairro") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Projeto</label>
                                <select class="form-control" name="projeto" id="projeto">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcaoAno("projeto") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Linguagem</label>
                                <select class="form-control" name="linguagem" id="linguagem">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("linguagens") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Segmento/Tipo</label>
                                <select class="form-control" name="tipo_evento" id="tipo_evento">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("tipo_evento") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Data de Abertura da Ação:</label>
                                <input type='text' class="form-control calendario" name="abertura_acao"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Visitação - Data de Início:</label>
                                <input type='text' class="form-control calendario" name="periodoInicio"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Visitação - Data de Encerramento (se for data única, não
                                    preencher):</label>
                                <input type='text' class="form-control calendario" name="periodoFim"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control" id="inputSubject" value="ano_base"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Horário de Abertura:</label>
                                <input type='text' class="form-control hora" name="hora"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Dias úteis do período (se for data única, não preencher)</label>
                                <input type="text" name="ndias" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Contagem</label>
                                <select class="form-control" name="contagem" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="1" selected>Número total (absoluto)</option>
                                    <option value="2">Média Geral (por dia)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público de Abertura(Número de Espectadores)</label>
                                <input type="text" name="valor" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Público</label>
                                <select class="form-control" name="tipo" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="1" selected>Geral</option>
                                    <option value="2">Específico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nº de Grupos/Agentes Culturais e de Lazer</label>
                                <input type="text" name="numero_agentes" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Selecionados por Convocatória/Edital?</label>
                                <select class="form-control" name="convocatoria_edital" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="0" selected>Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, qual?</label>
                                <select class="form-control" name="nome_convocatoria" id="nome_convocatoria">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("convocatoria") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação contou com artistas/profissionais da cidade?</label>
                                <select class="form-control" name="prof_sa" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="0" selected>Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, quantos indivíduos?</label>
                                <input type="text" name="quantidade_prof_sa" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação realizada em parceria?</label>
                                <select class="form-control" name="acao_parceria" id="inputSubject">
                                    <option>Selecione</option>
                                    <option value="0" selected>Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do parceiro</label>
                                <input type="text" name="nome_parceiro" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com contratação de pessoal para esta ação específica</label>
                                <input type="text" name="gastos_pessoal" class="form-control valor" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com estrutura para esta ação específica</label>
                                <input type="text" name="gastos_estrutura" class="form-control valor" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Janeiro</label>
                                <input type="text" name="pub_jan" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Fevereiro</label>
                                <input type="text" name="pub_fev" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Março</label>
                                <input type="text" name="pub_mar" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Abril</label>
                                <input type="text" name="pub_abr" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Maio</label>
                                <input type="text" name="pub_mai" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Junho</label>
                                <input type="text" name="pub_jun" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Julho</label>
                                <input type="text" name="pub_jul" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Agosto</label>
                                <input type="text" name="pub_ago" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Setembro</label>
                                <input type="text" name="pub_set" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Outubro</label>
                                <input type="text" name="pub_out" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Novembro</label>
                                <input type="text" name="pub_nov" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Dezembro</label>
                                <input type="text" name="pub_dez" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" value="1"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>


            <?php
            break;
        case "inserirbiblioteca":

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Biblioteca - Inserir</h3>
                            <p><?php //echo $sql;
                                ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=listarbiblioteca" method="POST" role="form">
                        
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control" id="inputSubject" value="<?php echo date('Y'); ?>"/>
                            </div>
                        </div>
						                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
							  <label>Mês</label>
                                <select class="form-control" name="mes" id="mes">
                                    <option>Escolha uma opção</option>
                                    <?php 
									for($m = 1; $m < 13; $m++){
										echo '<option value="'.$m.'">'.$m.'</option>';
									}
									
									?>
									
									
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="pub_central" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="pub_ramais" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Empréstimos Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="emp_central" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Empréstimos Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="emp_ramais" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Sócios Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="soc_central" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Sócios Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="soc_ramais" class="form-control publico" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Central(só número, sem pontuação)</label>
                                <input type="text" name="acervo_central" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="acervo_ramais" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Digital (só número, sem pontuação)</label>
                                <input type="text" name="acervo_digital" class="form-control publico" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_central" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_ramais" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Digital (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_digital" class="form-control publico" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Downloads - Digital (só número, sem pontuação)</label>
                                <input type="text" name="downloads" class="form-control publico" value=""/>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="obs" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" value="1"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "editarbiblioteca":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_ind_biblioteca", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["biblioteca"])) {
	

                $pub_central = $_POST["pub_central"];
                $pub_ramais = $_POST["pub_ramais"];
                $emp_central = $_POST["emp_central"];
                $emp_ramais = $_POST["emp_ramais"];
                $soc_central = $_POST["soc_central"];
                $soc_ramais = $_POST["soc_ramais"];
                $acervo_central = $_POST["acervo_central"];
                $acervo_ramais = $_POST["acervo_ramais"];
                $acervo_digital = $_POST["acervo_digital"];
                $incorporacoes_central = $_POST["incorporacoes_central"];
                $incorporacoes_ramais = $_POST["incorporacoes_ramais"];
                $incorporacoes_digital = $_POST["incorporacoes_digital"];
                $ano_base = $_POST["ano_base"];
                $downloads = $_POST["downloads"];
                $obs = $_POST["obs"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_ind_biblioteca SET

						pub_central = '$pub_central',
						pub_ramais = '$pub_ramais',
						emp_central = '$emp_central',
						emp_ramais = '$emp_ramais',
						soc_central = '$soc_central',
						soc_ramais = '$soc_ramais',
						acervo_central = '$acervo_central',
						acervo_ramais = '$acervo_ramais',
						acervo_digital = '$acervo_digital',
						incorporacoes_central = '$incorporacoes_central',
						incorporacoes_ramais = '$incorporacoes_ramais',
						incorporacoes_digital = '$incorporacoes_digital',
						ano_base = '$ano_base',
						downloads = '$downloads',
						obs = '$obs'
						WHERE id = '" . $_POST['biblioteca'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_ind_biblioteca", $_POST['biblioteca'], "id");

            }
			
			
			$timestamp = strtotime($ind['periodo_inicio']); 
			$m = date('m', $timestamp);
			$ano_base = date('Y', $timestamp);
            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Biblioteca - Editar - <?php echo $m."/".$ano_base; ?></h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Relatório atualizado.", "success");
                                }else{
									echo alerta("Erro ao atualizar ou nenhum dado a atualizar.", "danger");
									
								} ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=editarbiblioteca" method="POST" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="pub_central" class="form-control"
                                       value="<?php echo $ind['pub_central']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Biblioteca Ramais (só número, sem pontuação)</label>
                                <input type="text" name="pub_ramais" class="form-control"
                                       value="<?php echo $ind['pub_ramais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Empréstimos Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="emp_central" class="form-control"
                                       value="<?php echo $ind['emp_central']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Empréstimos Biblioteca Ramais (só número, sem pontuação)</label>
                                <input type="text" name="emp_ramais" class="form-control"
                                       value="<?php echo $ind['emp_ramais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Sócios Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="soc_central" class="form-control"
                                       value="<?php echo $ind['soc_central']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Sócios Biblioteca Ramais (só número, sem pontuação)</label>
                                <input type="text" name="soc_ramais" class="form-control"
                                       value="<?php echo $ind['soc_ramais']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="acervo_central" class="form-control"
                                       value="<?php echo $ind['acervo_central']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="acervo_ramais" class="form-control"
                                       value="<?php echo $ind['acervo_ramais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Itens no Acervo Biblioteca Digital (só número, sem pontuação)</label>
                                <input type="text" name="acervo_digital" class="form-control"
                                       value="<?php echo $ind['acervo_digital']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Central (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_central" class="form-control"
                                       value="<?php echo $ind['incorporacoes_central']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_ramais" class="form-control"
                                       value="<?php echo $ind['incorporacoes_ramais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novas Incorporações Biblioteca Descentralizada (só número, sem pontuação)</label>
                                <input type="text" name="incorporacoes_digital" class="form-control"
                                       value="<?php echo $ind['incorporacoes_digital']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Downloads - Digital (só número, sem pontuação)</label>
                                <input type="text" name="downloads" class="form-control"
                                       value="<?php echo $ind['downloads']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="obs" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["obs"] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="biblioteca" value="<?php echo $ind['id']; ?>"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "editarevento":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_indicadores", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["evento"])) {
                $tipo = $_POST["tipo"];
                $periodoInicio = exibirDataMysql($_POST["periodoInicio"]);
                $periodoFim = exibirDataMysql($_POST["periodoFim"]);
                $ndias = $_POST["ndias"];
                $contagem = $_POST["contagem"];
                $valor = $_POST["valor"];
                $relato = $_POST["relato"];
                $hora = $_POST["hora"];
                $outros_locais = $_POST["outros_locais"];
                $bairro = $_POST["bairro"];
                $projeto = $_POST["projeto"];
                $atracao_principal = $_POST["atracao_principal"];
                $linguagem = $_POST["linguagem"];
                $tipo_evento = $_POST["tipo_evento"];
                $numero_agentes = $_POST["numero_agentes"];
                $convocatoria_edital = $_POST["convocatoria_edital"];
                $nome_convocatoria = $_POST["nome_convocatoria"];
                $prof_sa = $_POST["prof_sa"];
                $quantidade_prof_sa = $_POST["quantidade_prof_sa"];
                $acao_parceria = $_POST["acao_parceria"];
                $nome_parceiro = $_POST["nome_parceiro"];
                $gastos_pessoal = dinheiroDeBr($_POST["gastos_pessoal"]);
                $gastos_estrutura = dinheiroDeBr($_POST["gastos_estrutura"]);
                $ano_base = $_POST["ano_base"];
                $data = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_indicadores SET
						tipo = '$tipo',
						periodoInicio = '$periodoInicio',
						periodoFim = '$periodoFim',
						ndias = '$ndias',
						contagem = '$contagem',
						valor = '$valor',
						relato = '$relato',
						hora = '$hora',
						outros_locais = '$outros_locais',
						bairro = '$bairro',
						projeto = '$projeto',
						atracao_principal = '$atracao_principal',
						linguagem = '$linguagem',
						tipo_evento = '$tipo_evento',
						numero_agentes = '$numero_agentes',
						convocatoria_edital = '$convocatoria_edital',
						nome_convocatoria = '$nome_convocatoria',
						prof_sa = '$prof_sa',
						quantidade_prof_sa = '$quantidade_prof_sa',
						acao_parceria = '$acao_parceria',
						nome_parceiro = '$nome_parceiro',
						gastos_pessoal = '$gastos_pessoal',
						gastos_estrutura = '$gastos_estrutura',
						ano_base = '$ano_base'
						WHERE id = '" . $_POST['evento'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_indicadores", $_POST['evento'], "id");

            }

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
                            $('#idOcorrencia').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.ocor.ajax.php?', {idEvento: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
                                }
                                $('#idOcorrencia').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
                        }
                    });
                });
            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Relatório de Público - Editar</h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Relatório atualizado.", "success");
                                }; ?></p>
                        </div>
                    </div>

                </div>

                <?php
                $idUsuario = $user->ID;
                if ($idUsuario != '1' AND $idUsuario != '17' AND $idUsuario != '68') {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario') AND (ano_base = 'ano_base') AND (dataEnvio IS NOT NULL) ORDER BY nomeEvento ASC";
                } else {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (dataEnvio IS NOT NULL) AND (ano_base = 'ano_base') ORDER BY nomeEvento ASC";

                }
                $eventos = $wpdb->get_results($sql_lista_evento, ARRAY_A);
                ?>

                <div class="row">

                    <form class="formocor" action="?p=editarevento" method="POST" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome da Atração Principal</label>
                                <input type="text" name="atracao_principal" class="form-control"
                                       value="<?php echo $ind['atracao_principal']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Outros Locais</label>
                                <input type="text" name="outros_locais" class="form-control"
                                       value="<?php echo $ind['outros_locais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Bairro</label>
                                <select class="form-control" name="bairro" id="bairro">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("bairro", $ind['bairro']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Projeto</label>
                                <select class="form-control" name="projeto" id="projeto">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcaoAno("projeto", $ind['projeto']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Linguagem</label>
                                <select class="form-control" name="linguagem" id="linguagem">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("linguagens", $ind['linguagem']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Segmento/Tipo</label>
                                <select class="form-control" name="tipo_evento" id="tipo_evento">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("tipo_evento", $ind['tipo_evento']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Data de Início</label>
                                <input type='text' class="form-control calendario" name="periodoInicio"
                                       value="<?php echo exibirDataBr($ind['periodoInicio']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Data de Encerramento (se for data única, não preencher)</label>
                                <input type='text' class="form-control calendario" name="periodoFim"
                                       value="<?php if ($ind['periodoFim'] != '0000-00-00') {
                                           echo exibirDataBr($ind['periodoFim']);
                                       } ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control"
                                       value="<?php echo $ind['ano_base']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Hora</label>
                                <input type="text" name="hora" class="form-control hora"
                                       value="<?php echo $ind['hora']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Dias úteis do período (se for data única, não preencher)</label>
                                <input type="text" name="ndias" class="form-control"
                                       value="<?php echo $ind['ndias']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Contagem</label>
                                <select class="form-control" name="contagem" id="contagem">
                                    <option value='1' <?php if ($ind['contagem'] == 1) {
                                        echo "selected";
                                    } ?> >Número total (absoluto)
                                    </option>
                                    <option value='2' <?php if ($ind['contagem'] == 2) {
                                        echo "selected";
                                    } ?> >Média Geral (por dia)
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público (Número de espectadores)</label>
                                <input type="text" name="valor" class="form-control"
                                       value="<?php echo $ind['valor']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Público</label>
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value='1' <?php if ($ind['tipo'] == 1) {
                                        echo "selected";
                                    } ?> >Geral
                                    </option>
                                    <option value='2' <?php if ($ind['tipo'] == 2) {
                                        echo "selected";
                                    } ?> >Específico
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Agentes Culturais e de Lazer</label>
                                <input type="text" name="numero_agentes" class="form-control"
                                       value="<?php echo $ind['numero_agentes']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Selecionados por Convocatória/Edital?</label>
                                <select class="form-control" name="convocatoria_edital" id="convocatoria_edital">
                                    <option value='0' <?php if ($ind['convocatoria_edital'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['convocatoria_edital'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, qual?</label>
                                <select class="form-control" name="nome_convocatoria" id="nome_convocatoria">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("convocatoria", $ind['nome_convocatoria']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação contou com artistas/profissionais da cidade?</label>
                                <select class="form-control" name="prof_sa" id="prof_sa">
                                    <option value='0' <?php if ($ind['prof_sa'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['prof_sa'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, quantos indivíduos?</label>
                                <input type="text" name="quantidade_prof_sa" class="form-control"
                                       value="<?php echo $ind['quantidade_prof_sa']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação realizada em parceria?</label>
                                <select class="form-control" name="acao_parceria" id="acao_parceria">
                                    <option value='0' <?php if ($ind['acao_parceria'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['acao_parceria'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do parceiro</label>
                                <input type="text" name="nome_parceiro" class="form-control"
                                       value="<?php echo $ind['nome_parceiro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com contratação de pessoal para esta ação específica (R$)
                                </label>
                                <input type="text" name="gastos_pessoal" class="form-control valor"
                                       value="<?php echo $ind['gastos_pessoal']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com estrutura para esta ação específica (R$)</label>
                                <input type="text" name="gastos_estrutura" class="form-control valor"
                                       value="<?php echo $ind['gastos_estrutura']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="evento" value="<?php echo $ind['id']; ?>"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "editarcontinuadas":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_ind_continuadas", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["continuadas"])) {
                $tipo = $_POST["tipo"];
                $periodoInicio = exibirDataMysql($_POST["periodoInicio"]);
                $periodoFim = exibirDataMysql($_POST["periodoFim"]);
                $abertura_acao = exibirDataMysql($_POST["abertura_acao"]);
                $ndias = $_POST["ndias"];
                $contagem = $_POST["contagem"];
                $valor = $_POST["valor"];
                $relato = $_POST["relato"];
                $hora = $_POST["hora"];
                $outros_locais = $_POST["outros_locais"];
                $bairro = $_POST["bairro"];
                $projeto = $_POST["projeto"];
                $atracao_principal = $_POST["atracao_principal"];
                $linguagem = $_POST["linguagem"];
                $tipo_evento = $_POST["tipo_evento"];
                $numero_agentes = $_POST["numero_agentes"];
                $convocatoria_edital = $_POST["convocatoria_edital"];
                $nome_convocatoria = $_POST["nome_convocatoria"];
                $prof_sa = $_POST["prof_sa"];
                $quantidade_prof_sa = $_POST["quantidade_prof_sa"];
                $acao_parceria = $_POST["acao_parceria"];
                $nome_parceiro = $_POST["nome_parceiro"];
                $pub_jan = $_POST["pub_jan"];
                $pub_fev = $_POST["pub_fev"];
                $pub_mar = $_POST["pub_mar"];
                $pub_abr = $_POST["pub_abr"];
                $pub_mai = $_POST["pub_mai"];
                $pub_jun = $_POST["pub_jun"];
                $pub_jul = $_POST["pub_jul"];
                $pub_ago = $_POST["pub_ago"];
                $pub_out = $_POST["pub_out"];
                $pub_set = $_POST["pub_set"];
                $pub_nov = $_POST["pub_nov"];
                $pub_dez = $_POST["pub_dez"];
                $gastos_pessoal = dinheiroDeBr($_POST["gastos_pessoal"]);
                $gastos_estrutura = dinheiroDeBr($_POST["gastos_estrutura"]);
                $ano_base = $_POST["ano_base"];
                $data = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_ind_continuadas SET
						tipo = '$tipo',
						periodoInicio = '$periodoInicio',
						periodoFim = '$periodoFim',
						abertura_acao = '$abertura_acao',
						ndias = '$ndias',
						contagem = '$contagem',
						valor = '$valor',
						relato = '$relato',
						hora = '$hora',
						outros_locais = '$outros_locais',
						bairro = '$bairro',
						projeto = '$projeto',
						atracao_principal = '$atracao_principal',
						linguagem = '$linguagem',
						tipo_evento = '$tipo_evento',
						numero_agentes = '$numero_agentes',
						convocatoria_edital = '$convocatoria_edital',
						nome_convocatoria = '$nome_convocatoria',
						prof_sa = '$prof_sa',
						quantidade_prof_sa = '$quantidade_prof_sa',
						acao_parceria = '$acao_parceria',
						nome_parceiro = '$nome_parceiro',
						pub_jan = '$pub_jan',
						pub_fev = '$pub_fev',
						pub_mar = '$pub_mar',
						pub_abr = '$pub_abr',
						pub_mai = '$pub_mai',
						pub_jun = '$pub_jun',
						pub_jul = '$pub_jul',
						pub_ago = '$pub_ago',
						pub_set = '$pub_set',
						pub_out = '$pub_out',
						pub_nov = '$pub_nov',
						pub_dez = '$pub_dez',
						gastos_pessoal = '$gastos_pessoal',
						gastos_estrutura = '$gastos_estrutura',
						ano_base = '$ano_base'
						WHERE id = '" . $_POST['continuadas'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_ind_continuadas", $_POST['continuadas'], "id");

            }

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>

            <script type="application/javascript">
                $(function () {
                    $('#idEvento').change(function () {
                        if ($(this).val()) {
                            $('#idOcorrencia').hide();
                            $('.carregando').show();
                            $.getJSON('inc/ind.ocor.ajax.php?', {idEvento: $(this).val(), ajax: 'true'}, function (j) {
                                var options = '<option value="0"></option>';
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
                                }
                                $('#idOcorrencia').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
                            $('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
                        }
                    });
                });
            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Exposição / Ação Continuada - Editar</h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Relatório atualizado.", "success");
                                }; ?></p>
                        </div>
                    </div>

                </div>

                <?php
                $idUsuario = $user->ID;
                if ($idUsuario != '1' AND $idUsuario != '17' AND $idUsuario != '68') {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario') AND (ano_base = '2020') AND (dataEnvio IS NOT NULL) ORDER BY nomeEvento ASC";
                } else {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (dataEnvio IS NOT NULL) AND (ano_base = 'ano_base') ORDER BY nomeEvento ASC";

                }
                $eventos = $wpdb->get_results($sql_lista_evento, ARRAY_A);
                ?>

                <div class="row">

                    <form class="formocor" action="?p=editarcontinuadas" method="POST" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome da Atração Principal</label>
                                <input type="text" name="atracao_principal" class="form-control"
                                       value="<?php echo $ind['atracao_principal']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Outros Locais</label>
                                <input type="text" name="outros_locais" class="form-control"
                                       value="<?php echo $ind['outros_locais']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Bairro</label>
                                <select class="form-control" name="bairro" id="bairro">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("bairro", $ind['bairro']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Projeto</label>
                                <select class="form-control" name="projeto" id="projeto">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcaoAno("projeto", $ind['projeto']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Linguagem</label>
                                <select class="form-control" name="linguagem" id="linguagem">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("linguagens", $ind['linguagem']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Segmento/Tipo</label>
                                <select class="form-control" name="tipo_evento" id="tipo_evento">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("tipo_evento", $ind['tipo_evento']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Data de Abertura da Ação</label>
                                <input type='text' class="form-control calendario" name="abertura_acao"
                                       value="<?php echo exibirDataBr($ind['abertura_acao']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período do Relatório - Data de Início</label>
                                <input type='text' class="form-control calendario" name="periodoInicio"
                                       value="<?php echo exibirDataBr($ind['periodoInicio']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período do Relatório - Data de Encerramento (se for data única, não
                                    preencher)</label>
                                <input type='text' class="form-control calendario" name="periodoFim"
                                       value="<?php if ($ind['periodoFim'] != '0000-00-00') {
                                           echo exibirDataBr($ind['periodoFim']);
                                       } ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control"
                                       value="<?php echo $ind['ano_base']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Horário de Abertura</label>
                                <input type="text" name="hora" class="form-control hora"
                                       value="<?php echo $ind['hora']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Dias úteis do período (se for data única, não preencher)</label>
                                <input type="text" name="ndias" class="form-control"
                                       value="<?php echo $ind['ndias']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Contagem</label>
                                <select class="form-control" name="contagem" id="contagem">
                                    <option value='1' <?php if ($ind['contagem'] == 1) {
                                        echo "selected";
                                    } ?> >Número total (absoluto)
                                    </option>
                                    <option value='2' <?php if ($ind['contagem'] == 2) {
                                        echo "selected";
                                    } ?> >Média Geral (por dia)
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público de Abertura(Número de espectadores)</label>
                                <input type="text" name="valor" class="form-control"
                                       value="<?php echo $ind['valor']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de Público</label>
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value='1' <?php if ($ind['tipo'] == 1) {
                                        echo "selected";
                                    } ?> >Geral
                                    </option>
                                    <option value='2' <?php if ($ind['tipo'] == 2) {
                                        echo "selected";
                                    } ?> >Específico
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Agentes Culturais e de Lazer</label>
                                <input type="text" name="numero_agentes" class="form-control"
                                       value="<?php echo $ind['numero_agentes']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Selecionados por Convocatória/Edital?</label>
                                <select class="form-control" name="convocatoria_edital" id="convocatoria_edital">
                                    <option value='0' <?php if ($ind['convocatoria_edital'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['convocatoria_edital'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, qual?</label>
                                <select class="form-control" name="nome_convocatoria" id="nome_convocatoria">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("convocatoria", $ind['nome_convocatoria']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação contou com artistas/profissionais da cidade?</label>
                                <select class="form-control" name="prof_sa" id="prof_sa">
                                    <option value='0' <?php if ($ind['prof_sa'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['prof_sa'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Se sim, quantos indivíduos?</label>
                                <input type="text" name="quantidade_prof_sa" class="form-control"
                                       value="<?php echo $ind['quantidade_prof_sa']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ação realizada em parceria?</label>
                                <select class="form-control" name="acao_parceria" id="acao_parceria">
                                    <option value='0' <?php if ($ind['acao_parceria'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>
                                    <option value='1' <?php if ($ind['acao_parceria'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do parceiro</label>
                                <input type="text" name="nome_parceiro" class="form-control"
                                       value="<?php echo $ind['nome_parceiro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com contratação de pessoal para esta ação específica (R$)
                                </label>
                                <input type="text" name="gastos_pessoal" class="form-control valor"
                                       value="<?php echo $ind['gastos_pessoal']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com estrutura para esta ação específica (R$)</label>
                                <input type="text" name="gastos_estrutura" class="form-control valor"
                                       value="<?php echo $ind['gastos_estrutura']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Janeiro </label>
                                <input type="text" name="pub_jan" class="form-control"
                                       value="<?php echo $ind['pub_jan']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Fevereiro</label>
                                <input type="text" name="pub_fev" class="form-control"
                                       value="<?php echo $ind['pub_fev']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Março</label>
                                <input type="text" name="pub_mar" class="form-control"
                                       value="<?php echo $ind['pub_mar']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Abril</label>
                                <input type="text" name="pub_abr" class="form-control"
                                       value="<?php echo $ind['pub_abr']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Maio</label>
                                <input type="text" name="pub_mai" class="form-control"
                                       value="<?php echo $ind['pub_mai']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Junho</label>
                                <input type="text" name="pub_jun" class="form-control"
                                       value="<?php echo $ind['pub_jun']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Julho</label>
                                <input type="text" name="pub_jul" class="form-control"
                                       value="<?php echo $ind['pub_jul']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Agosto</label>
                                <input type="text" name="pub_ago" class="form-control"
                                       value="<?php echo $ind['pub_ago']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Setembro</label>
                                <input type="text" name="pub_set" class="form-control"
                                       value="<?php echo $ind['pub_set']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Outubro</label>
                                <input type="text" name="pub_out" class="form-control"
                                       value="<?php echo $ind['pub_out']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Novembro</label>
                                <input type="text" name="pub_nov" class="form-control"
                                       value="<?php echo $ind['pub_nov']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público - Dezembro</label>
                                <input type="text" name="pub_dez" class="form-control"
                                       value="<?php echo $ind['pub_dez']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="continuadas" value="<?php echo $ind['id']; ?>"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "listarbiblioteca":

            if (isset($_POST['apagar'])) {
                $sql_update = "UPDATE sc_ind_biblioteca SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                $apagar = $wpdb->query($sql_update);
                if ($apagar == 1) {
                    $mensagem = alerta("Relatório apagado com sucesso", "success");
                }
            }


            if (isset($_POST['inserir'])) {
                $mensagem = alerta("Erro.", "");
                $ano_base = $_POST["ano_base"];
				$m = $_POST['mes'];
				$periodo_inicio = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-01";
				$ultimo_dia = ultimoDiaMes($ano_base,$m);
				$periodo_fim = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-".$ultimo_dia;		
                $pub_central = $_POST["pub_central"];
                $pub_ramais = $_POST["pub_ramais"];
                $emp_central = $_POST["emp_central"];
                $emp_ramais = $_POST["emp_ramais"];
                $soc_central = $_POST["soc_central"];
                $soc_ramais = $_POST["soc_ramais"];
                $acervo_central = $_POST["acervo_central"];
                $acervo_ramais = $_POST["acervo_ramais"];
                $acervo_digital = $_POST["acervo_digital"];
                $incorporacoes_central = $_POST["incorporacoes_central"];
                $incorporacoes_ramais = $_POST["incorporacoes_ramais"];
                $incorporacoes_digital = $_POST["incorporacoes_digital"];

                $downloads = $_POST["downloads"];
                $obs = $_POST["obs"];


				// controle de inserção
				$sql_verifica = "SELECT id FROM sc_ind_biblioteca WHERE periodo_inicio = '$periodo_inicio' AND publicado ='1'";
				$res_verifica = $wpdb->get_results($sql_verifica,ARRAY_A);
				//var_dump($sql_verifica);
				if(count($res_verifica) > 0){
					$mensagem = alerta("Dado já inserido. Edite se for necessário.", "danger");
				}else{
                $sql_inserir = "INSERT INTO `sc_ind_biblioteca` (`id`, `periodo_inicio`, `periodo_fim`, `pub_central`, `pub_ramais`, `emp_central`, `emp_ramais`, `soc_central`, `soc_ramais`, `acervo_central`, `acervo_ramais`, `acervo_digital`, `incorporacoes_central`, `incorporacoes_ramais`, `incorporacoes_digital`, `ano_base`, `downloads`, `obs`, `idUsuario`, `atualizacao`, `publicado`) VALUES (NULL, '$periodo_inicio', '$periodo_fim', '$pub_central', '$pub_ramais', '$emp_central', '$emp_ramais', '$soc_central', '$soc_ramais', '$acervo_central', '$acervo_ramais', '$acervo_digital', '$incorporacoes_central','$incorporacoes_ramais', '$incorporacoes_digital','$ano_base','$downloads', '$obs', '" . $user->ID . "', '" . date("Y-m-d") . "','1')";
                //echo $sql_inserir;
                $ins = $wpdb->query($sql_inserir);
                if ($ins == 1) {
                    $mensagem = alerta("Relatório inserido com sucesso.", "success");
                }
					
					
				}





            }


            ?>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h3>Biblioteca - Listar Relatórios</h3>
                    <p><?php if (isset($mensagem)) {
                            echo $mensagem;
                        } ?></p>
                    <?php
                    // listar o evento;
                    // var_dump($ex);
                    ?>

                </div>
            </div>

            <?php
            $sel = "SELECT * FROM sc_ind_biblioteca WHERE publicado = '1' ORDER BY periodo_inicio DESC";
            $ocor = $wpdb->get_results($sel, ARRAY_A);
            if (count($ocor) > 0) {
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Período/Data</th>
                            <th>Público</th>
                            <th>Empréstimos</th>
                            <th>Sócios</th>
                            <th>Acervo</th>
                            <th>Novas Incorporações</th>
                            <th>Downloads</th>
                            <th width="10%"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($ocor); $i++) {
                            ?>
                            <tr>
                                <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if ($ocor[$i]['periodo_fim'] != '0000-00-00') {
                                        echo " a " . exibirDataBr($ocor[$i]['periodo_fim']);
                                    } ?></td>
                                <td><?php echo $ocor[$i]['pub_central'] + $ocor[$i]['pub_ramais'] ?></td>
                                <td><?php echo $ocor[$i]['emp_central'] + $ocor[$i]['emp_ramais'] ?></td>
                                <td><?php echo $ocor[$i]['soc_central'] + $ocor[$i]['soc_ramais'] ?></td>
                                <td><?php echo $ocor[$i]['acervo_central'] + $ocor[$i]['acervo_ramais'] + $ocor[$i]['acervo_digital'] ?></td>
                                <td><?php echo $ocor[$i]['incorporacoes_central'] + $ocor[$i]['incorporacoes_ramais'] + $ocor[$i]['incorporacoes_digital'] ?></td>
                                <td><?php echo $ocor[$i]['downloads'] ?></td>
                                <td>
                                    <form method="POST" action="?p=editarbiblioteca" class="form-horizontal"
                                          role="form">
                                        <input type="hidden" name="editar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="?p=listarbiblioteca" class="form-horizontal"
                                          role="form">
                                        <input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                </div>


            <?php } else { ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <p> Não há relatórios cadastrados. </p>
                    </div>
                </div>


            <?php } ?>


            <?php
            break;
        case "inseririncentivo":

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Incentivo à Criação - Inserir Disciplina</h3>
                            <p><?php //echo $sql;
                                ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=listarincentivo" method="POST" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Equipamentos Culturais / Local *</label>
                                <select class="form-control" name="equipamento" id="programa" required>
                                    <option value=''>Escolha uma opção</option>
                                    <?php geraTipoOpcao("local") ?>
                                    <option value='0'>Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Outros Locais</label>
                                <input type="text" name="outros" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Bairro</label>
                                <select class="form-control" name="bairro" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("bairro") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Projeto *</label>
                                <select class="form-control" name="projeto" id="programa" required>
                                    <option value=''>Escolha uma opção</option>
                                    <?php geraTipoOpcaoAno("projeto") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de ação</label>
                                <select class="form-control" name="tipo_acao" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("tipo_evento") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Título da ação (título usado para divulgação na cidade)</label>
                                <input type="text" name="titulo_acao" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Linguagem</label>
                                <select class="form-control" name="linguagem" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("linguagens") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Disciplinas</label>
                                <input type="text" name="disciplinas" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Início:</label>
                                <input type='text' class="form-control calendario" name="ocor_inicio"
                                       value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Fim:</label>
                                <input type='text' class="form-control calendario" name="ocor_fim"
                                       value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control" id="inputSubject" value="ano_base"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Carga Horária</label>
                                <input type="text" name="carga_horaria" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Concluintes</label>
                                <input type="text" name="n_concluintes" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Evasão (preencher apenas no final do período das atividades)</label>
                                <input type="text" name="n_evasao" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do(s) profissional(is)</label>
                                <input type="text" name="nome_profissional" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Quantos profissional são de Santo André?</label>
                                <input type="text" name="santo_andre" class="form-control" value="" id="programa"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Custo da hora/aula do profissional</label>
                                <input type="text" name="custo_hora_aula" class="form-control valor" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Carga horária total do profissional para esta ação</label>
                                <input type="text" name="carga_horaria_prof" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Custo total de contratação do profissional para esta ação (R$)
                                </label>
                                <input type="text" name="custo_total" class="form-control valor" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com materiais de consumo</label>
                                <input type="text" name="material_consumo" class="form-control valor" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Houve parceria para esta ação?</label>
                                <select class="form-control" name="parceria" id="programa">
                                    <option value='1'>Sim</option>
                                    <option value='0'>Não</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Qual o parceiro (incluindo voluntariado)?</label>
                                <input type="text" name="parceiro" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de vagas oferecidas</label>
                                <input type="text" name="vagas" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de rematriculados
                                </label>
                                <input type="text" name="rematriculas" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de inscritos
                                </label>
                                <input type="text" name="inscritos" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de interessados em lista de espera</label>
                                <input type="text" name="espera" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="obs" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Janeiro</label>
                                <input type="text" name="janeiro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Janeiro</label>
                                <input type="text" name="janeiro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Fevereiro</label>
                                <input type="text" name="fevereiro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Fevereiro</label>
                                <input type="text" name="fevereiro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Março</label>
                                <input type="text" name="marco" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Março</label>
                                <input type="text" name="marco_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Abril</label>
                                <input type="text" name="abril" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Abril</label>
                                <input type="text" name="abril_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Maio</label>
                                <input type="text" name="maio" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Maio</label>
                                <input type="text" name="maio_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Junho</label>
                                <input type="text" name="junho" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Junho</label>
                                <input type="text" name="junho_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Julho</label>
                                <input type="text" name="julho" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Julho</label>
                                <input type="text" name="julho_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido- Agosto</label>
                                <input type="text" name="agosto" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Agosto</label>
                                <input type="text" name="agosto_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido- Setembro</label>
                                <input type="text" name="setembro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Setembro</label>
                                <input type="text" name="setembro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Outubro</label>
                                <input type="text" name="outubro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Outubro</label>
                                <input type="text" name="outubro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Novembro</label>
                                <input type="text" name="novembro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Novembro</label>
                                <input type="text" name="novembro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Dezembro</label>
                                <input type="text" name="dezembro" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Dezembro</label>
                                <input type="text" name="dezembro_sa" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" value="1"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>


            <?php
            break;
        case "editarincentivo":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_ind_incentivo", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["equipamento"])) {
                $equipamento = $_POST["equipamento"];
                $outros = $_POST["outros"];
                $bairro = $_POST["bairro"];
                $projeto = $_POST["projeto"];
                $tipo_acao = $_POST["tipo_acao"];
                $titulo_acao = $_POST["titulo_acao"];
                $linguagem = $_POST["linguagem"];
                $disciplinas = $_POST["disciplinas"];
                $ocor_inicio = exibirDataMysql($_POST["ocor_inicio"]);
                $ocor_fim = exibirDataMysql($_POST["ocor_fim"]);
                $carga_horaria = $_POST["carga_horaria"];
                $n_concluintes = $_POST["n_concluintes"];
                $n_evasao = $_POST["n_evasao"];
                $nome_profissional = $_POST["nome_profissional"];
                $santo_andre = $_POST["santo_andre"];
                $custo_hora_aula = dinheiroDeBr($_POST["custo_hora_aula"]);
                $carga_horaria_prof = $_POST["carga_horaria_prof"];
                $custo_total = dinheiroDeBr($_POST["custo_total"]);
                $material_consumo = dinheiroDeBr($_POST["material_consumo"]);
                $parceria = $_POST["parceria"];
                $parceiro = $_POST["parceiro"];
                $vagas = $_POST["vagas"];
                $rematriculas = $_POST["rematriculas"];
                $inscritos = $_POST["inscritos"];
                $espera = $_POST["espera"];
                $obs = $_POST["obs"];
                $janeiro = $_POST["janeiro"];
                $fevereiro = $_POST["fevereiro"];
                $marco = $_POST["marco"];
                $abril = $_POST["abril"];
                $maio = $_POST["maio"];
                $junho = $_POST["junho"];
                $julho = $_POST["julho"];
                $agosto = $_POST["agosto"];
                $setembro = $_POST["setembro"];
                $outubro = $_POST["outubro"];
                $novembro = $_POST["novembro"];
                $dezembro = $_POST["dezembro"];
                $janeiro_sa = $_POST["janeiro_sa"];
                $fevereiro_sa = $_POST["fevereiro_sa"];
                $marco_sa = $_POST["marco_sa"];
                $abril_sa = $_POST["abril_sa"];
                $maio_sa = $_POST["maio_sa"];
                $junho_sa = $_POST["junho_sa"];
                $julho_sa = $_POST["julho_sa"];
                $agosto_sa = $_POST["agosto_sa"];
                $setembro_sa = $_POST["setembro_sa"];
                $outubro_sa = $_POST["outubro_sa"];
                $novembro_sa = $_POST["novembro_sa"];
                $dezembro_sa = $_POST["dezembro_sa"];
                $ano_base = $_POST["ano_base"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_ind_incentivo SET
						equipamento = '$equipamento',
						outros = '$outros',
						bairro = '$bairro',
						projeto = '$projeto',
						tipo_acao = '$tipo_acao',
						titulo_acao = '$titulo_acao',
						linguagem = '$linguagem',
						disciplinas = '$disciplinas',
						ocor_inicio = '$ocor_inicio',
						ocor_fim = '$ocor_fim',
						carga_horaria = '$carga_horaria',
						n_concluintes = '$n_concluintes',
						n_evasao = '$n_evasao',
						nome_profissional = '$nome_profissional',
						santo_andre = '$santo_andre',
						custo_hora_aula = '$custo_hora_aula',
						carga_horaria_prof = '$carga_horaria_prof',   
						custo_total = '$custo_total',
						material_consumo = '$material_consumo',
						parceria = '$parceria',
						parceiro = '$parceiro',
						vagas = '$vagas',
						rematriculas = '$rematriculas',
						inscritos = '$inscritos',
						espera = '$espera',
						obs = '$obs',
						janeiro = '$janeiro',
						fevereiro = '$fevereiro',
						marco = '$marco',
						abril = '$abril',
						maio = '$maio',
						junho = '$junho',
						julho = '$julho',
						agosto = '$agosto',
						setembro = '$setembro',
						outubro = '$outubro',
						novembro = '$novembro',
						dezembro = '$dezembro',
						janeiro_sa = '$janeiro_sa',
						fevereiro_sa = '$fevereiro_sa',
						marco_sa = '$marco_sa',
						abril_sa = '$abril_sa',
						maio_sa = '$maio_sa',
						junho_sa = '$junho_sa',
						julho_sa = '$julho_sa',
						agosto_sa = '$agosto_sa',
						setembro_sa = '$setembro_sa',
						outubro_sa = '$outubro_sa',
						novembro_sa = '$novembro_sa',
						dezembro_sa = '$dezembro_sa',
						ano_base = '$ano_base'
						WHERE id = '" . $_POST['editar'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_ind_incentivo", $_POST['editar'], "id");

            }

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Incentivo à Criação - Editar Disciplina</h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Disciplina/Curso atualizado.", "success");
                                }; ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=editarincentivo" method="POST" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Equipamentos Culturais / Local *</label>
                                <select class="form-control" name="equipamento" id="programa" required>
                                    <option value=''>Escolha uma opção</option>
                                    <?php geraTipoOpcao("local", $ind['equipamento']) ?>
                                    <option value='0'>Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Outros Locais</label>
                                <input type="text" name="outros" class="form-control"
                                       value="<?php echo $ind['outros']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Bairro</label>
                                <select class="form-control" name="bairro" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("bairro", $ind['bairro']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Projeto</label>
                                <select class="form-control" name="projeto" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcaoAno("projeto", $ind['projeto']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tipo de ação</label>
                                <select class="form-control" name="tipo_acao" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("tipo_evento", $ind['tipo_acao']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Título da ação (título usado para divulgação na cidade)</label>
                                <input type="text" name="titulo_acao" class="form-control"
                                       value="<?php echo $ind['titulo_acao']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Linguagem</label>
                                <select class="form-control" name="linguagem" id="programa">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("linguagens", $ind['linguagem']) ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Disciplinas</label>
                                <input type="text" name="disciplinas" class="form-control"
                                       value="<?php echo $ind['disciplinas']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Início:</label>
                                <input type='text' class="form-control calendario" name="ocor_inicio"
                                       value="<?php echo exibirDataBr($ind['ocor_inicio']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Fim:</label>
                                <input type='text' class="form-control calendario" name="ocor_fim"
                                       value="<?php if ($ind['ocor_fim'] != '0000-00-00') {
                                           echo exibirDataBr($ind['ocor_fim']);
                                       } ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control"
                                       value="<?php echo $ind['ano_base']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Carga Horária</label>
                                <input type="text" name="carga_horaria" class="form-control"
                                       value="<?php echo $ind['carga_horaria']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Concluintes</label>
                                <input type="text" name="n_concluintes" class="form-control"
                                       value="<?php echo $ind['n_concluintes']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Evasão (preencher apenas no final do período das atividades)</label>
                                <input type="text" name="n_evasao" class="form-control"
                                       value="<?php echo $ind['n_evasao']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Nome do(s) profissional(is)</label>
                                <input type="text" name="nome_profissional" class="form-control"
                                       value="<?php echo $ind['nome_profissional']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Quantos profissional são de Santo André?</label>
                                <input type="text" name="santo_andre" class="form-control"
                                       value="<?php echo $ind['santo_andre']; ?>" id="programa"/>
                            </div>
                        </div>
                        <!--<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Profissional é de Santo André?</label>
										<select class="form-control" name="santo_andre" id="programa" >
											<option value = '1' <?php if ($ind['santo_andre'] == 1) {
                            echo "selected";
                        } ?> >Sim</option>
											<option value = '0' <?php if ($ind['santo_andre'] == 0) {
                            echo "selected";
                        } ?> >Não</option>

										</select>
									</div>
								</div>-->
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Custo da hora/aula do profissional</label>
                                <input type="text" name="custo_hora_aula" class="form-control valor"
                                       value="<?php echo $ind['custo_hora_aula']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Carga horária total do profissional para esta ação</label>
                                <input type="text" name="carga_horaria_prof" class="form-control"
                                       value="<?php echo $ind['carga_horaria_prof']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Custo total de contratação do profissional para esta ação (R$)
                                </label>
                                <input type="text" name="custo_total" class="form-control valor"
                                       value="<?php echo $ind['custo_total']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Gastos com materiais de consumo</label>
                                <input type="text" name="material_consumo" class="form-control valor"
                                       value="<?php echo $ind['material_consumo']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Houve parceria para esta ação?</label>
                                <select class="form-control" name="parceria" id="programa">
                                    <option value='1' <?php if ($ind['parceria'] == 1) {
                                        echo "selected";
                                    } ?> >Sim
                                    </option>
                                    <option value='0' <?php if ($ind['parceria'] == 0) {
                                        echo "selected";
                                    } ?> >Não
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Qual o parceiro (incluindo voluntariado)?</label>
                                <input type="text" name="parceiro" class="form-control"
                                       value="<?php echo $ind['parceiro']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de vagas oferecidas</label>
                                <input type="text" name="vagas" class="form-control"
                                       value="<?php echo $ind['vagas']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de rematriculados
                                </label>
                                <input type="text" name="rematriculas" class="form-control"
                                       value="<?php echo $ind['rematriculas']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de inscritos
                                </label>
                                <input type="text" name="inscritos" class="form-control"
                                       value="<?php echo $ind['inscritos']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de interessados em lista de espera</label>
                                <input type="text" name="espera" class="form-control"
                                       value="<?php echo $ind['espera']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="obs" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["obs"] ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Janeiro</label>
                                <input type="text" name="janeiro" class="form-control"
                                       value="<?php echo $ind['janeiro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Janeiro</label>
                                <input type="text" name="janeiro_sa" class="form-control"
                                       value="<?php echo $ind['janeiro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Fevereiro</label>
                                <input type="text" name="fevereiro" class="form-control"
                                       value="<?php echo $ind['fevereiro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Fevereiro</label>
                                <input type="text" name="fevereiro_sa" class="form-control"
                                       value="<?php echo $ind['fevereiro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Março</label>
                                <input type="text" name="marco" class="form-control"
                                       value="<?php echo $ind['marco']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Março</label>
                                <input type="text" name="marco_sa" class="form-control"
                                       value="<?php echo $ind['marco_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Abril</label>
                                <input type="text" name="abril" class="form-control"
                                       value="<?php echo $ind['abril']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Abril</label>
                                <input type="text" name="abril_sa" class="form-control"
                                       value="<?php echo $ind['abril_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Maio</label>
                                <input type="text" name="maio" class="form-control"
                                       value="<?php echo $ind['maio']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Maio</label>
                                <input type="text" name="maio_sa" class="form-control"
                                       value="<?php echo $ind['maio_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Junho</label>
                                <input type="text" name="junho" class="form-control"
                                       value="<?php echo $ind['junho']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André- Junho</label>
                                <input type="text" name="junho_sa" class="form-control"
                                       value="<?php echo $ind['junho_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Julho</label>
                                <input type="text" name="julho" class="form-control"
                                       value="<?php echo $ind['julho']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Julho</label>
                                <input type="text" name="julho_sa" class="form-control"
                                       value="<?php echo $ind['julho_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Agosto</label>
                                <input type="text" name="agosto" class="form-control"
                                       value="<?php echo $ind['agosto']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Agosto</label>
                                <input type="text" name="agosto_sa" class="form-control"
                                       value="<?php echo $ind['agosto_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Setembro</label>
                                <input type="text" name="setembro" class="form-control"
                                       value="<?php echo $ind['setembro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Setembro</label>
                                <input type="text" name="setembro_sa" class="form-control"
                                       value="<?php echo $ind['setembro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Outubro</label>
                                <input type="text" name="outubro" class="form-control"
                                       value="<?php echo $ind['outubro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Outubro</label>
                                <input type="text" name="outubro_sa" class="form-control"
                                       value="<?php echo $ind['outubro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Novembro</label>
                                <input type="text" name="novembro" class="form-control"
                                       value="<?php echo $ind['novembro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Novembro</label>
                                <input type="text" name="novembro_sa" class="form-control"
                                       value="<?php echo $ind['novembro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Total Atendido - Dezembro</label>
                                <input type="text" name="dezembro" class="form-control"
                                       value="<?php echo $ind['dezembro']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Público Atendido em Santo André - Dezembro</label>
                                <input type="text" name="dezembro_sa" class="form-control"
                                       value="<?php echo $ind['dezembro_sa']; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="editar" value="<?php echo $ind['id']; ?>"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>


            <?php
            break;

        case "listarincentivo":

            if (isset($_POST['apagar'])) {
                $sql_update = "UPDATE sc_ind_incentivo SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                $apagar = $wpdb->query($sql_update);
                if ($apagar == 1) {
                    $mensagem = alerta("Relatório apagado com sucesso", "success");
                }
            }


            if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                $equipamento = $_POST["equipamento"];
                $outros = $_POST["outros"];
                $bairro = $_POST["bairro"];
                $projeto = $_POST["projeto"];
                $tipo_acao = $_POST["tipo_acao"];
                $titulo_acao = $_POST["titulo_acao"];
                $linguagem = $_POST["linguagem"];
                $disciplinas = $_POST["disciplinas"];
                $ocor_inicio = exibirDataMysql($_POST["ocor_inicio"]);
                $ocor_fim = exibirDataMysql($_POST["ocor_fim"]);
                $carga_horaria = $_POST["carga_horaria"];
                $n_concluintes = $_POST["n_concluintes"];
                $n_evasao = $_POST["n_evasao"];
                $nome_profissional = $_POST["nome_profissional"];
                $santo_andre = $_POST["santo_andre"];
                $custo_hora_aula = dinheiroDeBr($_POST["custo_hora_aula"]);
                $carga_horaria_prof = $_POST["carga_horaria_prof"];
                $custo_total = dinheiroDeBr($_POST["custo_total"]);
                $material_consumo = dinheiroDeBr($_POST["material_consumo"]);
                $parceria = $_POST["parceria"];
                $parceiro = $_POST["parceiro"];
                $vagas = $_POST["vagas"];
                $rematriculas = $_POST["rematriculas"];
                $inscritos = $_POST["inscritos"];
                $espera = $_POST["espera"];
                $obs = $_POST["obs"];
                $janeiro = $_POST["janeiro"];
                $fevereiro = $_POST["fevereiro"];
                $marco = $_POST["marco"];
                $abril = $_POST["abril"];
                $maio = $_POST["maio"];
                $junho = $_POST["junho"];
                $julho = $_POST["julho"];
                $agosto = $_POST["agosto"];
                $setembro = $_POST["setembro"];
                $outubro = $_POST["outubro"];
                $novembro = $_POST["novembro"];
                $dezembro = $_POST["dezembro"];
                $janeiro_sa = $_POST["janeiro_sa"];
                $fevereiro_sa = $_POST["fevereiro_sa"];
                $marco_sa = $_POST["marco_sa"];
                $abril_sa = $_POST["abril_sa"];
                $maio_sa = $_POST["maio_sa"];
                $junho_sa = $_POST["junho_sa"];
                $julho_sa = $_POST["julho_sa"];
                $agosto_sa = $_POST["agosto_sa"];
                $setembro_sa = $_POST["setembro_sa"];
                $outubro_sa = $_POST["outubro_sa"];
                $novembro_sa = $_POST["novembro_sa"];
                $dezembro_sa = $_POST["dezembro_sa"];
                $ano_base = $_POST["ano_base"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;
            }

            if (isset($_POST['inserir'])) {
                $sql_ins = "INSERT INTO `sc_ind_incentivo` (`equipamento`, `outros`, `bairro`, `projeto`, `tipo_acao`, `titulo_acao`, `disciplinas`, `linguagem`, `ocor_inicio`, `ocor_fim`, `carga_horaria`, `n_concluintes`, `n_evasao`, `nome_profissional`, `santo_andre`, `custo_hora_aula`, `carga_horaria_prof`, `custo_total`, `material_consumo`, `parceria`, `parceiro`, `vagas`, `rematriculas`, `inscritos`, `espera`, `obs`, `janeiro`, `fevereiro`, `marco`, `abril`, `maio`, `junho`, `julho`, `agosto`, `setembro`, `outubro`, `novembro`, `dezembro`,`janeiro_sa`, `fevereiro_sa`, `marco_sa`, `abril_sa`, `maio_sa`, `junho_sa`, `julho_sa`, `agosto_sa`, `setembro_sa`, `outubro_sa`, `novembro_sa`, `dezembro_sa`, `ano_base`, `atualizacao`, `idUsuario`, `publicado`) VALUES ( '$equipamento', '$outros', '$bairro', '$projeto', '$tipo_acao', '$titulo_acao', '$disciplinas', '$linguagem', '$ocor_inicio', '$ocor_fim', '$carga_horaria', '$n_concluintes', '$n_evasao', '$nome_profissional', '$santo_andre', '$custo_hora_aula', '$carga_horaria_prof', '$custo_total', '$material_consumo', '$parceria', '$parceiro', '$vagas', '$rematriculas', '$inscritos', '$espera', '$obs','$janeiro','$fevereiro','$marco','$abril','$maio','$junho','$julho','$agosto','$setembro','$outubro','$novembro', '$dezembro','$janeiro_sa','$fevereiro_sa','$marco_sa','$abril_sa','$maio_sa','$junho_sa','$julho_sa','$agosto_sa','$setembro_sa','$outubro_sa','$novembro_sa', '$dezembro_sa','$ano_base','$atualizacao','$idUsuario','1' );";
                $ins = $wpdb->query($sql_ins);
                $lastid = $wpdb->insert_id;

            }


            if (isset($_POST['apagar'])) {
                global $wpdb;
                $id = $_POST['apagar'];
                $sql = "UPDATE sc_ind_incentivo SET publicado = '0' WHERE id = '$id'";
                $apagar = $wpdb->query($sql);
            }


            ?>


            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h3>Incentivo à Criação - Listar Disciplinas</h3>
                    <?php
                    // listar o evento;
                    //var_dump($lastid);
                    ?>

                </div>
            </div>

            <?php
            $sel = "SELECT * FROM sc_ind_incentivo WHERE publicado = '1' ORDER BY ocor_inicio DESC";
            $ocor = $wpdb->get_results($sel, ARRAY_A);
            if (count($ocor) > 0) {
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Título Disciplina/Curso</th>
                            <th>Equipamento/Local</th>
                            <th>Responsável</th>
                            <th>Período</th>
                            <th width="10%"></th>
                            <th width="10%"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($ocor); $i++) {

                            ?>
                            <tr>
                                <td><?php echo $ocor[$i]['titulo_acao']; ?></td>
                                <?php $equipamento = retornaTipo($ocor[$i]['equipamento']); ?>
                                <td><?php echo $equipamento['tipo']; ?></td>
                                <td><?php echo $ocor[$i]['nome_profissional']; ?></td>
                                <td><?php echo exibirDataBr($ocor[$i]['ocor_inicio']) ?>
                                    a <?php echo exibirDataBr($ocor[$i]['ocor_fim']) ?> </td>
                                <td>
                                    <form method="POST" action="?p=editarincentivo" class="form-horizontal" role="form">
                                        <input type="hidden" name="editar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="?p=listarincentivo" class="form-horizontal" role="form">
                                        <input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                </div>

                </div>

            <?php } else { ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <p> Não há disciplinas/cursos cadastrados. </p>
                    </div>
                </div>


            <?php } ?>

            <?php
            break;
        case "editarculturaz":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_ind_culturaz", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["culturaz"])) {
                $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                $eventos_geral = $_POST["eventos_geral"];
                $eventos_secretaria = $_POST["eventos_secretaria"];
                $espacos_geral = $_POST["espacos_geral"];
                $espacos_secretaria = $_POST["espacos_secretaria"];
                $projetos_geral = $_POST["projetos_geral"];
                $projetos_secretaria = $_POST["projetos_secretaria"];
                $numero_agentes = $_POST["numero_agentes"];
                $novos_agentes = $_POST["novos_agentes"];
                $relato = $_POST["relato"];
                $ano_base = $_POST["ano_base"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_ind_culturaz SET	
					periodo_inicio = '$periodo_inicio',
					periodo_fim = '$periodo_fim',
					eventos_geral = '$eventos_geral',
					eventos_secretaria = '$eventos_secretaria',
					espacos_geral = '$espacos_geral',
					espacos_secretaria = '$espacos_secretaria',
					projetos_geral = '$projetos_geral',
					projetos_secretaria = '$projetos_secretaria',
					numero_agentes = '$numero_agentes',
					novos_agentes = '$novos_agentes',
					relato = '$relato',
					ano_base = '$ano_base'
					WHERE id = '" . $_POST['culturaz'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_ind_culturaz", $_POST['culturaz'], "id");

            }

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Plataforma CulturAZ - Editar Relatório</h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Relatório atualizado.", "success");
                                }; ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=editarculturaz" method="POST" role="form">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Período da Avaliação -Início:</label>
                                    <input type='text' class="form-control calendario" name="periodo_inicio"
                                           value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Período da Avaliação - Fim:</label>
                                    <input type='text' class="form-control calendario" name="periodo_fim"
                                           value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                               echo exibirDataBr($ind['periodo_fim']);
                                           } ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Ano Base</label>
                                    <input type="text" name="ano_base" class="form-control"
                                           value="<?php echo $ind['ano_base']; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Eventos (Geral)</label>
                                    <input type="text" name="eventos_geral" class="form-control"
                                           value="<?php echo $ind['eventos_geral']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Eventos da Secretaria de Cultura</label>
                                    <input type="text" name="eventos_secretaria" class="form-control"
                                           value="<?php echo $ind['eventos_secretaria']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Espaços (Geral)</label>
                                    <input type="text" name="espacos_geral" class="form-control"
                                           value="<?php echo $ind['espacos_geral']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Espaços da Secretaria de Cultura</label>
                                    <input type="text" name="espacos_secretaria" class="form-control"
                                           value="<?php echo $ind['espacos_secretaria']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Projetos (Geral)</label>
                                    <input type="text" name="projetos_geral" class="form-control"
                                           value="<?php echo $ind['projetos_geral']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Projetos da Secretaria de Cultura</label>
                                    <input type="text" name="projetos_secretaria" class="form-control"
                                           value="<?php echo $ind['projetos_secretaria']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Número de Agentes</label>
                                    <input type="text" name="numero_agentes" class="form-control"
                                           value="<?php echo $ind['numero_agentes']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Novos Agentes</label>
                                    <input type="text" name="novos_agentes" class="form-control"
                                           value="<?php echo $ind['novos_agentes']; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Relato</label>
                                    <textarea name="relato" class="form-control" rows="10"
                                              placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <input type="hidden" name="culturaz" value="<?php echo $ind['id']; ?>"/>
                                    <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "inserirculturaz":

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Plataforma CulturAZ - Inserir Relatório</h3>
                            <p><?php //echo $sql;
                                ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=listarculturaz" method="POST" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Avaliação - Início:</label>
                                <input type='text' class="form-control calendario" name="periodo_inicio"
                                       value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Avaliação - Fim:</label>
                                <input type='text' class="form-control calendario" name="periodo_fim"
                                       value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control" id="inputSubject" value="ano_base"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Eventos (Geral)</label>
                                <input type="text" name="eventos_geral" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Eventos da Secretaria de Cultura</label>
                                <input type="text" name="eventos_secretaria" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Espaços (Geral)</label>
                                <input type="text" name="espacos_geral" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Espaços da Secretaria de Cultura</label>
                                <input type="text" name="espacos_secretaria" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Projetos (Geral)</label>
                                <input type="text" name="projetos_geral" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Projetos da Secretaria de Cultura</label>
                                <input type="text" name="projetos_secretaria" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Número de Agentes</label>
                                <input type="text" name="numero_agentes" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Novos Agentes</label>
                                <input type="text" name="novos_agentes" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" value="1"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;

        case "listarculturaz":

            if (isset($_POST['apagar'])) {
                $sql_update = "UPDATE sc_ind_culturaz SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                $apagar = $wpdb->query($sql_update);
                if ($apagar == 1) {
                    $mensagem = alerta("Relatório apagado com sucesso", "success");
                }
            }


            if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                $eventos_geral = $_POST["eventos_geral"];
                $eventos_secretaria = $_POST["eventos_secretaria"];
                $espacos_geral = $_POST["espacos_geral"];
                $espacos_secretaria = $_POST["espacos_secretaria"];
                $projetos_geral = $_POST["projetos_geral"];
                $projetos_secretaria = $_POST["projetos_secretaria"];
                $numero_agentes = $_POST["numero_agentes"];
                $novos_agentes = $_POST["novos_agentes"];
                $relato = $_POST["relato"];
                $ano_base = $_POST["ano_base"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;
            }

            if (isset($_POST['inserir'])) {
                $sql_ins = "INSERT INTO `sc_ind_culturaz` (`periodo_inicio`, `periodo_fim`, `eventos_geral`, `eventos_secretaria`, `espacos_geral`, `espacos_secretaria`, `projetos_geral`, `projetos_secretaria`, `numero_agentes`, `novos_agentes`,`relato`,`ano_base`,`atualizacao`, `idUsuario`, `publicado`) VALUES ('$periodo_inicio', '$periodo_fim', '$eventos_geral', '$eventos_secretaria', '$espacos_geral', '$espacos_secretaria', '$projetos_geral', '$projetos_secretaria', '$numero_agentes', '$novos_agentes', '$relato','$ano_base', '$atualizacao','$idUsuario','1' );";
                $ins = $wpdb->query($sql_ins);
                $lastid = $wpdb->insert_id;

            }


            if (isset($_POST['apagar'])) {
                global $wpdb;
                $id = $_POST['apagar'];
                $sql = "UPDATE sc_ind_culturaz SET publicado = '0' WHERE id = '$id'";
                $apagar = $wpdb->query($sql);
            }


            ?>


            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h3>Plataforma CulturAZ - Listar Relatórios</h3>
                    <?php
                    // listar o evento;
                    //var_dump($lastid);
                    ?>

                </div>
            </div>

            <?php
            $sel = "SELECT * FROM sc_ind_culturaz WHERE publicado = '1' ORDER BY periodo_inicio DESC";
            $ocor = $wpdb->get_results($sel, ARRAY_A);
            if (count($ocor) > 0) {
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Período</th>
                            <th>Nº de Eventos</th>
                            <th>Nº de Espaços</th>
                            <th>Nº de Projetos</th>
                            <th>Nº Total de Agentes</th>
                            <th>Nº de Novos Agentes</th>
                            <th width="10%"></th>
                            <th width="10%"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($ocor); $i++) {

                            ?>
                            <tr>
                                <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?>
                                    a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
                                <td><?php echo $ocor[$i]['eventos_geral'] + $ocor[$i]['eventos_secretaria'] ?></td>
                                <td><?php echo $ocor[$i]['espacos_geral'] + $ocor[$i]['espacos_secretaria'] ?></td>
                                <td><?php echo $ocor[$i]['projetos_geral'] + $ocor[$i]['projetos_secretaria'] ?></td>
                                <td><?php echo $ocor[$i]['numero_agentes']; ?></td>
                                <td><?php echo $ocor[$i]['novos_agentes']; ?></td>
                                <td>
                                    <form method="POST" action="?p=editarculturaz" class="form-horizontal" role="form">
                                        <input type="hidden" name="editar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="?p=listarculturaz" class="form-horizontal" role="form">
                                        <input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                </div>

                </div>

            <?php } else { ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <p> Não há informações cadastradas. </p>
                    </div>
                </div>


            <?php } ?>

            <?php
            break;
        case "inseriracervos":

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Acervos - Inserir Relatório</h3>
                            <p><?php //echo $sql;
                                ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=listaracervos" method="POST" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Avaliação - Início:</label>
                                <input type='text' class="form-control calendario" name="periodo_inicio"
                                       value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Período de Avaliação - Fim:</label>
                                <input type='text' class="form-control calendario" name="periodo_fim"
                                       value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                       ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Ano Base</label>
                                <input type="text" name="ano_base" class="form-control" id="inputSubject" value="ano_base"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Total de Itens no Acervo do Museu</label>
                                <input type="text" name="museu_total" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Total de Acervos/Produtos Digitalizados do Museu</label>
                                <input type="text" name="museu_digitalizados" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Acervos/Produtos Disponibilizados no Museu</label>
                                <input type="text" name="museu_disponiveis" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Total de Itens no Acervo de Arte Contemporânea</label>
                                <input type="text" name="artec_total" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Total de Acervos/Produtos Digitalizados de Arte Contemporânea</label>
                                <input type="text" name="artec_digitalizados" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Acervos/Produtos Disponibilizados na Arte Contemporânea</label>
                                <input type="text" name="artec_disponiveis" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Relato</label>
                                <textarea name="relato" class="form-control" rows="10"
                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="inserir" value="1"/>
                                <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <?php
            break;

        case "listaracervos":

            if (isset($_POST['apagar'])) {
                $sql_update = "UPDATE sc_ind_acervos SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                $apagar = $wpdb->query($sql_update);
                if ($apagar == 1) {
                    $mensagem = alerta("Relatório apagado com sucesso", "success");
                }
            }


            if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                $museu_total = $_POST["museu_total"];
                $museu_digitalizados = $_POST["museu_digitalizados"];
                $museu_disponiveis = $_POST["museu_disponiveis"];
                $artec_total = $_POST["artec_total"];
                $artec_digitalizados = $_POST["artec_digitalizados"];
                $artec_disponiveis = $_POST["artec_disponiveis"];
                $ano_base = $_POST["ano_base"];
                $relato = $_POST["relato"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;
            }

            if (isset($_POST['inserir'])) {
                $sql_ins = "INSERT INTO `sc_ind_acervos` (`periodo_inicio`, `periodo_fim`,`museu_total`,`museu_digitalizados`,`museu_disponiveis`,`artec_total`,`artec_digitalizados`,`artec_disponiveis`,`ano_base`,`relato`,`atualizacao`, `idUsuario`, `publicado`) VALUES ('$periodo_inicio', '$periodo_fim', '$museu_total', '$museu_digitalizados', '$museu_disponiveis', '$artec_total', '$artec_digitalizados', '$artec_disponiveis', '$ano_base', '$relato', '$atualizacao','$idUsuario','1' );";
                $ins = $wpdb->query($sql_ins);
                $lastid = $wpdb->insert_id;

            }


            if (isset($_POST['apagar'])) {
                global $wpdb;
                $id = $_POST['apagar'];
                $sql = "UPDATE sc_ind_acervos SET publicado = '0' WHERE id = '$id'";
                $apagar = $wpdb->query($sql);
            }


            ?>


            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h3>Acervos- Listar Relatórios</h3>
                    <?php
                    // listar o evento;
                    //var_dump($lastid);
                    ?>

                </div>
            </div>

            <?php
            $sel = "SELECT * FROM sc_ind_acervos WHERE publicado = '1' ORDER BY id DESC";
            $ocor = $wpdb->get_results($sel, ARRAY_A);
            if (count($ocor) > 0) {
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Período</th>
                            <th>Nº de Itens no Acervo</th>
                            <th>Nº de Acervos/Produtos Digitalizados</th>
                            <th>Nº de Acervos/Produtos Disponibilizados</th>
                            <th width="10%"></th>
                            <th width="10%"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($ocor); $i++) {

                            ?>
                            <tr>
                                <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?>
                                    a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
                                <td><?php echo $ocor[$i]['museu_total'] + $ocor[$i]['artec_total'] ?></td>
                                <td><?php echo $ocor[$i]['museu_digitalizados'] + $ocor[$i]['artec_digitalizados'] ?></td>
                                <td><?php echo $ocor[$i]['museu_disponiveis'] + $ocor[$i]['artec_disponiveis'] ?></td>
                                <td>
                                    <form method="POST" action="?p=editaracervos" class="form-horizontal" role="form">
                                        <input type="hidden" name="editar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="?p=listaracervos" class="form-horizontal" role="form">
                                        <input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>"/>
                                        <input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                </div>

                </div>

            <?php } else { ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <p> Não há relatórios cadastrados. </p>
                    </div>
                </div>


            <?php } ?>

            <?php
            break;
        case "editaracervos":
            if (isset($_POST['editar'])) {
                $ind = recuperaDados("sc_ind_acervos", $_POST['editar'], "id");

            }
            $editar = 0;

            if (isset($_POST["acervos"])) {
                $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                $museu_total = $_POST["museu_total"];
                $museu_digitalizados = $_POST["museu_digitalizados"];
                $museu_disponiveis = $_POST["museu_disponiveis"];
                $artec_total = $_POST["artec_total"];
                $artec_digitalizados = $_POST["artec_digitalizados"];
                $artec_disponiveis = $_POST["artec_disponiveis"];
                $ano_base = $_POST["ano_base"];
                $relato = $_POST["relato"];
                $atualizacao = date("Y-m-d H:s:i");
                $idUsuario = $user->ID;

                $sql_update = "UPDATE sc_ind_acervos SET	
	periodo_inicio = '$periodo_inicio',
	periodo_fim = '$periodo_fim',
	museu_total = '$museu_total',
	museu_digitalizados = '$museu_digitalizados',
	museu_disponiveis = '$museu_disponiveis',
	artec_total = '$artec_total',
	artec_digitalizados = '$artec_digitalizados',
	artec_disponiveis = '$artec_disponiveis',
	ano_base = '$ano_base',
	relato = '$relato'
	WHERE id = '" . $_POST['acervos'] . "'";

                $editar = $wpdb->query($sql_update);
                $ind = recuperaDados("sc_ind_acervos", $_POST['acervos'], "id");

            }

            ?>

            <link href="css/jquery-ui.css" rel="stylesheet">
            <script src="js/jquery-ui.js"></script>
            <script src="js/mask.js"></script>
            <script src="js/maskMoney.js"></script>
            <script>
                $(function () {
                    $(".calendario").datepicker();
                    $(".hora").mask("99:99");
                    $(".min").mask("999");
                    $(".valor").maskMoney({prefix: '', thousands: '.', decimal: ',', affixesStay: true});
                });


            </script>


            <section id="contact" class="home-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h3>Acervos - Editar Relatório</h3>
                            <p><?php if ($editar == 1) {
                                    echo alerta("Relatório atualizado.", "success");
                                }; ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <form class="formocor" action="?p=editaracervos" method="POST" role="form">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Período da Avaliação -Início:</label>
                                    <input type='text' class="form-control calendario" name="periodo_inicio"
                                           value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Período da Avaliação - Fim:</label>
                                    <input type='text' class="form-control calendario" name="periodo_fim"
                                           value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                               echo exibirDataBr($ind['periodo_fim']);
                                           } ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Ano Base</label>
                                    <input type="text" name="ano_base" class="form-control"
                                           value="<?php echo $ind['ano_base']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Total de Itens no Acervo do Museu</label>
                                    <input type="text" name="museu_total" class="form-control"
                                           value="<?php echo $ind['museu_total']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Total de Acervos/Produtos Digitalizados do Museu</label>
                                    <input type="text" name="museu_digitalizados" class="form-control"
                                           value="<?php echo $ind['museu_digitalizados']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Acervos/Produtos Disponibilizados no Museu</label>
                                    <input type="text" name="museu_disponiveis" class="form-control"
                                           value="<?php echo $ind['museu_disponiveis']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Total de Itens no Acervo de Arte Contemporânea</label>
                                    <input type="text" name="artec_total" class="form-control"
                                           value="<?php echo $ind['artec_total']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Total de Acervos/Produtos Digitalizados de Arte Contemporânea</label>
                                    <input type="text" name="artec_digitalizados" class="form-control"
                                           value="<?php echo $ind['artec_digitalizados']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Acervos/Produtos Disponibilizados na Arte Contemporânea</label>
                                    <input type="text" name="artec_disponiveis" class="form-control"
                                           value="<?php echo $ind['artec_disponiveis']; ?>"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Relato</label>
                                    <textarea name="relato" class="form-control" rows="10"
                                              placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <input type="hidden" name="acervos" value="<?php echo $ind['id']; ?>"/>
                                    <button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>

            </section>

            <?php
            break;
        case "tabelaevento":
			
			fixAnoBase("sc_indicadores","id","periodoInicio","ano_base");

        ?>

           <div class="form-group">
                <div class="col-md-offset-2">
                    <h1>Resumo dos Eventos</h1>
                </div>
            </div>

        <br/><br/>
<?php 

$ano_orcamento = anoOrcamento(true);

for($i = 0; $i < count($ano_orcamento); $i++){

	$indica = indicadores($ano_orcamento[$i]['ano_base'],"evento");

?>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <label><h2><?php echo $ano_orcamento[$i]['ano_base']; ?> - Geral</h2></label>
                <tr>
                    <th>Período</th>
                    <th>Público</th>
                    <th>Nº Atividades</th>
                    <th>Nº Atividades com Agentes Locais</th>
                    <th>Nº Agentes Culturais Locais Envolvidos</th>
                    <th>Nº Bairros</th>
                    <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                    <th>Nº Bairros Descentralizados</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
			<?php 
				for($j = 1; $j <= count($indica['mes']); $j++){
			?>
				<tr>
				<td><?php echo retornaMes($j); ?></td>
				<td><?php echo $indica['mes'][$j]['publico']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['agentes_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros']; ?></td>
				<td><?php echo $indica['mes'][$j]['bairros_atendidos']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>

				<?php } ?>
				<tr>
				<td>Total do ano</td>
				<td><?php echo $indica['ano']['publico']; ?></td>
				<td><?php echo $indica['ano']['n_atividades']; ?></td>
				<td><?php echo $indica['ano']['n_atividades_locais']; ?></td>
				<td><?php echo $indica['ano']['agentes_locais']; ?></td>
				<td><?php echo $indica['ano']['n_bairros']; ?></td>
				<td><?php echo $indica['ano']['bairros_atendidos']; ?></td>
				<td><?php echo $indica['ano']['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>



                </tbody>
</table>
               </div>
			   <hr>
<?php }// fim do loop do ano ?>

			   <br /><br />
<?php
            break;
        case "tabelaeventolazer":
?>
        ?>

           <div class="form-group">
                <div class="col-md-offset-2">
                    <h1>Resumo dos Eventos - Lazer</h1>
                </div>
            </div>

        <br/><br/>
<?php 

$ano_orcamento = anoOrcamento(true);

for($i = 0; $i < count($ano_orcamento); $i++){

	$indica = indicadores($ano_orcamento[$i]['ano_base'],"evento",NULL,1194 );

?>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <label><h2><?php echo $ano_orcamento[$i]['ano_base']; ?> - Geral</h2></label>
                <tr>
                    <th>Período</th>
                    <th>Público</th>
                    <th>Nº Atividades</th>
                    <th>Nº Atividades com Agentes Locais</th>
                    <th>Nº Agentes Culturais Locais Envolvidos</th>
                    <th>Nº Bairros</th>
                    <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                    <th>Nº Bairros Descentralizados</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
			<?php 
				for($j = 1; $j <= count($indica['mes']); $j++){
			?>
				<tr>
				<td><?php echo retornaMes($j); ?></td>
				<td><?php echo $indica['mes'][$j]['publico']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['agentes_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros']; ?></td>
				<td><?php echo $indica['mes'][$j]['bairros_atendidos']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>

				<?php } ?>
				<tr>
				<td>Total do ano</td>
				<td><?php echo $indica['ano']['publico']; ?></td>
				<td><?php echo $indica['ano']['n_atividades']; ?></td>
				<td><?php echo $indica['ano']['n_atividades_locais']; ?></td>
				<td><?php echo $indica['ano']['agentes_locais']; ?></td>
				<td><?php echo $indica['ano']['n_bairros']; ?></td>
				<td><?php echo $indica['ano']['bairros_atendidos']; ?></td>
				<td><?php echo $indica['ano']['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>



                </tbody>
</table>
               </div>
			   <hr>
<?php }// fim do loop do ano ?>

			   <br /><br />

<?php
            break;
        case "tabelaeventoorquestra":
?>
        ?>

           <div class="form-group">
                <div class="col-md-offset-2">
                    <h1>Resumo dos Eventos - Orquestra</h1>
                </div>
            </div>

        <br/><br/>
<?php 

$ano_orcamento = anoOrcamento(true);

for($i = 0; $i < count($ano_orcamento); $i++){

	$indica = indicadores($ano_orcamento[$i]['ano_base'],"evento","346,347,348,349,755,769,771,772" );

?>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <label><h2><?php echo $ano_orcamento[$i]['ano_base']; ?> - Geral</h2></label>
                <tr>
                    <th>Período</th>
                    <th>Público</th>
                    <th>Nº Atividades</th>
                    <th>Nº Atividades com Agentes Locais</th>
                    <th>Nº Agentes Culturais Locais Envolvidos</th>
                    <th>Nº Bairros</th>
                    <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                    <th>Nº Bairros Descentralizados</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
			<?php 
				for($j = 1; $j <= count($indica['mes']); $j++){
			?>
				<tr>
				<td><?php echo retornaMes($j); ?></td>
				<td><?php echo $indica['mes'][$j]['publico']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_atividades_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['agentes_locais']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros']; ?></td>
				<td><?php echo $indica['mes'][$j]['bairros_atendidos']; ?></td>
				<td><?php echo $indica['mes'][$j]['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>

				<?php } ?>
				<tr>
				<td>Total do ano</td>
				<td><?php echo $indica['ano']['publico']; ?></td>
				<td><?php echo $indica['ano']['n_atividades']; ?></td>
				<td><?php echo $indica['ano']['n_atividades_locais']; ?></td>
				<td><?php echo $indica['ano']['agentes_locais']; ?></td>
				<td><?php echo $indica['ano']['n_bairros']; ?></td>
				<td><?php echo $indica['ano']['bairros_atendidos']; ?></td>
				<td><?php echo $indica['ano']['n_bairros_descentralizados']; ?></td>
				<td></td>
				<td></td>
				</tr>



                </tbody>
</table>
               </div>
			   <hr>
<?php }// fim do loop do ano ?>

			   <br /><br />


                                                <?php
                                               break;
                                               /* case "tabelacontinuadas":

                                                ?>

                                                <form method="POST" action="?p=tabelacontinuadas"
                                                      class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <div class="col-md-offset-2">
                                                            <h1>Resumo dos Eventos</h1>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br/><br/>

                                                


                                             <!--   <div class="table-responsive"> 
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <label><h2>2019</h2></label>
                                                        <tr>
                                                            <th>Período</th>
                                                            <th>Público</th>
                                                            <th>Nº Atividades</th>
                                                            <th>Nº Atividades com Agentes Locais</th>
                                                            <th>Nº Agentes Culturais Locais Envolvidos</th>
                                                            <th>Nº Bairros</th>
                                                            <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                                                            <th>Nº Bairros Descentralizados</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>

                                                            <?php
                                                            echo "<tr>";
                                                            echo "<td><strong>DEZ</strong></td>";

                                                            $sql_pub_dezembro = "SELECT SUM(pub_dez) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1'";
                                                            $pub_dezembro = $wpdb->get_results($sql_pub_dezembro, ARRAY_A);
                                                            echo "<td>" . $pub_dezembro[0]['SUM(pub_dez)'] . "</td>";

                                                            $sql_ativ_dezembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $ativ_dezembro = $wpdb->get_results($sql_ativ_dezembro, ARRAY_A);
                                                            echo "<td>" . $ativ_dezembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_dezembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1' AND prof_sa = '1' AND pub_dez > '0'";
                                                            $age_dezembro = $wpdb->get_results($sql_age_dezembro, ARRAY_A);
                                                            echo "<td>" . $age_dezembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_dezembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $num_age_dezembro = $wpdb->get_results($sql_num_age_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_age_dezembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $num_bairros_dezembro = $wpdb->get_results($sql_num_bairros_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_dezembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $per_bairros_dezembro = $wpdb->get_results($sql_per_bairros_dezembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_dezembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-12-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_dez > '0'";
                                                            $num_desc_dezembro = $wpdb->get_results($sql_num_desc_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>NOV</strong></td>";

                                                            $sql_pub_novembro = "SELECT SUM(pub_nov) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1'";
                                                            $pub_novembro = $wpdb->get_results($sql_pub_novembro, ARRAY_A);
                                                            echo "<td>" . $pub_novembro[0]['SUM(pub_nov)'] . "</td>";

                                                            $sql_ativ_novembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $ativ_novembro = $wpdb->get_results($sql_ativ_novembro, ARRAY_A);
                                                            echo "<td>" . $ativ_novembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_novembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1' AND prof_sa = '1' AND pub_nov > '0'";
                                                            $age_novembro = $wpdb->get_results($sql_age_novembro, ARRAY_A);
                                                            echo "<td>" . $age_novembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_novembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $num_age_novembro = $wpdb->get_results($sql_num_age_novembro, ARRAY_A);
                                                            echo "<td>" . $num_age_novembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $num_bairros_novembro = $wpdb->get_results($sql_num_bairros_novembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_novembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $per_bairros_novembro = $wpdb->get_results($sql_per_bairros_novembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_novembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-11-01' AND '2019-11-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_nov > '0'";
                                                            $num_desc_novembro = $wpdb->get_results($sql_num_desc_novembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>OUT</strong></td>";
                                                            $sql_pub_outubro = "SELECT SUM(pub_out) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1'";
                                                            $pub_outubro = $wpdb->get_results($sql_pub_outubro, ARRAY_A);
                                                            echo "<td>" . $pub_outubro[0]['SUM(pub_out)'] . "</td>";

                                                            $sql_ativ_outubro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $ativ_outubro = $wpdb->get_results($sql_ativ_outubro, ARRAY_A);
                                                            echo "<td>" . $ativ_outubro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_outubro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1' AND prof_sa = '1' AND pub_out > '0'";
                                                            $age_outubro = $wpdb->get_results($sql_age_outubro, ARRAY_A);
                                                            echo "<td>" . $age_outubro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_outubro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $num_age_outubro = $wpdb->get_results($sql_num_age_outubro, ARRAY_A);
                                                            echo "<td>" . $num_age_outubro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $num_bairros_outubro = $wpdb->get_results($sql_num_bairros_outubro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_outubro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $per_bairros_outubro = $wpdb->get_results($sql_per_bairros_outubro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_outubro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-10-01' AND '2019-10-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_out > '0'";
                                                            $num_desc_outubro = $wpdb->get_results($sql_num_desc_outubro, ARRAY_A);
                                                            echo "<td>" . $num_desc_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>SET</strong></td>";

                                                            $sql_pub_setembro = "SELECT SUM(pub_set) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1'";
                                                            $pub_setembro = $wpdb->get_results($sql_pub_setembro, ARRAY_A);
                                                            echo "<td>" . $pub_setembro[0]['SUM(pub_set)'] . "</td>";

                                                            $sql_ativ_setembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $ativ_setembro = $wpdb->get_results($sql_ativ_setembro, ARRAY_A);
                                                            echo "<td>" . $ativ_setembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_setembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1' AND prof_sa = '1' AND pub_set > '0'";
                                                            $age_setembro = $wpdb->get_results($sql_age_setembro, ARRAY_A);
                                                            echo "<td>" . $age_setembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_setembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $num_age_setembro = $wpdb->get_results($sql_num_age_setembro, ARRAY_A);
                                                            echo "<td>" . $num_age_setembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $num_bairros_setembro = $wpdb->get_results($sql_num_bairros_setembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_setembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $per_bairros_setembro = $wpdb->get_results($sql_per_bairros_setembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_setembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-09-01' AND '2019-09-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_set > '0'";
                                                            $num_desc_setembro = $wpdb->get_results($sql_num_desc_setembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>AGO</strong></td>";

                                                            $sql_pub_agosto = "SELECT SUM(pub_ago) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1'";
                                                            $pub_agosto = $wpdb->get_results($sql_pub_agosto, ARRAY_A);
                                                            echo "<td>" . $pub_agosto[0]['SUM(pub_ago)'] . "</td>";

                                                            $sql_ativ_agosto = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $ativ_agosto = $wpdb->get_results($sql_ativ_agosto, ARRAY_A);
                                                            echo "<td>" . $ativ_agosto[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_agosto = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1' AND prof_sa = '1' AND pub_ago > '0'";
                                                            $age_agosto = $wpdb->get_results($sql_age_agosto, ARRAY_A);
                                                            echo "<td>" . $age_agosto[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_agosto = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $num_age_agosto = $wpdb->get_results($sql_num_age_agosto, ARRAY_A);
                                                            echo "<td>" . $num_age_agosto[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $num_bairros_agosto = $wpdb->get_results($sql_num_bairros_agosto, ARRAY_A);
                                                            echo "<td>" . $num_bairros_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_agosto = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $per_bairros_agosto = $wpdb->get_results($sql_per_bairros_agosto, ARRAY_A);
                                                            echo "<td>" . $per_bairros_agosto[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-08-01' AND '2019-08-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_ago > '0'";
                                                            $num_desc_agosto = $wpdb->get_results($sql_num_desc_agosto, ARRAY_A);
                                                            echo "<td>" . $num_desc_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JUL</strong></td>";

                                                            $sql_pub_julho = "SELECT SUM(pub_jul) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1'";
                                                            $pub_julho = $wpdb->get_results($sql_pub_julho, ARRAY_A);
                                                            echo "<td>" . $pub_julho[0]['SUM(pub_jul)'] . "</td>";

                                                            $sql_ativ_julho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $ativ_julho = $wpdb->get_results($sql_ativ_julho, ARRAY_A);
                                                            echo "<td>" . $ativ_julho[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_julho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1' AND prof_sa = '1' AND pub_jul > '0'";
                                                            $age_julho = $wpdb->get_results($sql_age_julho, ARRAY_A);
                                                            echo "<td>" . $age_julho[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_julho = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $num_age_julho = $wpdb->get_results($sql_num_age_julho, ARRAY_A);
                                                            echo "<td>" . $num_age_julho[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $num_bairros_julho = $wpdb->get_results($sql_num_bairros_julho, ARRAY_A);
                                                            echo "<td>" . $num_bairros_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_julho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $per_bairros_julho = $wpdb->get_results($sql_per_bairros_julho, ARRAY_A);
                                                            echo "<td>" . $per_bairros_julho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-07-01' AND '2019-07-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jul > '0'";
                                                            $num_desc_julho = $wpdb->get_results($sql_num_desc_julho, ARRAY_A);
                                                            echo "<td>" . $num_desc_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JUN</strong></td>";

                                                            $sql_pub_junho = "SELECT SUM(pub_jun) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1'";
                                                            $pub_junho = $wpdb->get_results($sql_pub_junho, ARRAY_A);
                                                            echo "<td>" . $pub_junho[0]['SUM(pub_jun)'] . "</td>";

                                                            $sql_ativ_junho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio 	BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $ativ_junho = $wpdb->get_results($sql_ativ_junho, ARRAY_A);
                                                            echo "<td>" . $ativ_junho[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_junho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1' AND prof_sa = '1' AND pub_jun > '0'";
                                                            $age_junho = $wpdb->get_results($sql_age_junho, ARRAY_A);
                                                            echo "<td>" . $age_junho[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_junho = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $num_age_junho = $wpdb->get_results($sql_num_age_junho, ARRAY_A);
                                                            echo "<td>" . $num_age_junho[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $num_bairros_junho = $wpdb->get_results($sql_num_bairros_junho, ARRAY_A);
                                                            echo "<td>" . $num_bairros_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_junho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $per_bairros_junho = $wpdb->get_results($sql_per_bairros_junho, ARRAY_A);
                                                            echo "<td>" . $per_bairros_junho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-06-01' AND '2019-06-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jun > '0'";
                                                            $num_desc_junho = $wpdb->get_results($sql_num_desc_junho, ARRAY_A);
                                                            echo "<td>" . $num_desc_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>MAI</strong></td>";

                                                            $sql_pub_maio = "SELECT SUM(pub_mai) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1'";
                                                            $pub_maio = $wpdb->get_results($sql_pub_maio, ARRAY_A);
                                                            echo "<td>" . $pub_maio[0]['SUM(pub_mai)'] . "</td>";

                                                            $sql_ativ_maio = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $ativ_maio = $wpdb->get_results($sql_ativ_maio, ARRAY_A);
                                                            echo "<td>" . $ativ_maio[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_maio = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1' AND prof_sa = '1' AND pub_mai > '0'";
                                                            $age_maio = $wpdb->get_results($sql_age_maio, ARRAY_A);
                                                            echo "<td>" . $age_maio[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_maio = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $num_age_maio = $wpdb->get_results($sql_num_age_maio, ARRAY_A);
                                                            echo "<td>" . $num_age_maio[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $num_bairros_maio = $wpdb->get_results($sql_num_bairros_maio, ARRAY_A);
                                                            echo "<td>" . $num_bairros_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_maio = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $per_bairros_maio = $wpdb->get_results($sql_per_bairros_maio, ARRAY_A);
                                                            echo "<td>" . $per_bairros_maio[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-05-01' AND '2019-05-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_mai > '0'";
                                                            $num_desc_maio = $wpdb->get_results($sql_num_desc_maio, ARRAY_A);
                                                            echo "<td>" . $num_desc_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>ABR</strong></td>";

                                                            $sql_pub_abril = "SELECT SUM(pub_abr) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1'";
                                                            $pub_abril = $wpdb->get_results($sql_pub_abril, ARRAY_A);
                                                            echo "<td>" . $pub_abril[0]['SUM(pub_abr)'] . "</td>";

                                                            $sql_ativ_abril = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $ativ_abril = $wpdb->get_results($sql_ativ_abril, ARRAY_A);
                                                            echo "<td>" . $ativ_abril[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_abril = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1' AND prof_sa = '1' AND pub_abr > '0'";
                                                            $age_abril = $wpdb->get_results($sql_age_abril, ARRAY_A);
                                                            echo "<td>" . $age_abril[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_abril = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $num_age_abril = $wpdb->get_results($sql_num_age_abril, ARRAY_A);
                                                            echo "<td>" . $num_age_abril[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $num_bairros_abril = $wpdb->get_results($sql_num_bairros_abril, ARRAY_A);
                                                            echo "<td>" . $num_bairros_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_abril = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $per_bairros_abril = $wpdb->get_results($sql_per_bairros_abril, ARRAY_A);
                                                            echo "<td>" . $per_bairros_abril[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-04-01' AND '2019-04-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_abr > '0'";
                                                            $num_desc_abril = $wpdb->get_results($sql_num_desc_abril, ARRAY_A);
                                                            echo "<td>" . $num_desc_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>MAR</strong></td>";

                                                            $sql_pub_marco = "SELECT SUM(pub_mar) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1'";
                                                            $pub_marco = $wpdb->get_results($sql_pub_marco, ARRAY_A);
                                                            echo "<td>" . $pub_marco[0]['SUM(pub_mar)'] . "</td>";

                                                            $sql_ativ_marco = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $ativ_marco = $wpdb->get_results($sql_ativ_marco, ARRAY_A);
                                                            echo "<td>" . $ativ_marco[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_marco = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1' AND prof_sa = '1' AND pub_mar > '0'";
                                                            $age_marco = $wpdb->get_results($sql_age_marco, ARRAY_A);
                                                            echo "<td>" . $age_marco[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_marco = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $num_age_marco = $wpdb->get_results($sql_num_age_marco, ARRAY_A);
                                                            echo "<td>" . $num_age_marco[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $num_bairros_marco = $wpdb->get_results($sql_num_bairros_marco, ARRAY_A);
                                                            echo "<td>" . $num_bairros_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_marco = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $per_bairros_marco = $wpdb->get_results($sql_per_bairros_marco, ARRAY_A);
                                                            echo "<td>" . $per_bairros_marco[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-03-01' AND '2019-03-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_mar > '0'";
                                                            $num_desc_marco = $wpdb->get_results($sql_num_desc_marco, ARRAY_A);
                                                            echo "<td>" . $num_desc_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>FEV</strong></td>";

                                                            $sql_pub_fevereiro = "SELECT SUM(pub_fev) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1'";
                                                            $pub_fevereiro = $wpdb->get_results($sql_pub_fevereiro, ARRAY_A);
                                                            echo "<td>" . $pub_fevereiro[0]['SUM(pub_fev)'] . "</td>";

                                                            $sql_ativ_fevereiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $ativ_fevereiro = $wpdb->get_results($sql_ativ_fevereiro, ARRAY_A);
                                                            echo "<td>" . $ativ_fevereiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_fevereiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1' AND prof_sa = '1' AND pub_fev > '0'";
                                                            $age_fevereiro = $wpdb->get_results($sql_age_fevereiro, ARRAY_A);
                                                            echo "<td>" . $age_fevereiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_fevereiro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $num_age_fevereiro = $wpdb->get_results($sql_num_age_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_age_fevereiro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $num_bairros_fevereiro = $wpdb->get_results($sql_num_bairros_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_fevereiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $per_bairros_fevereiro = $wpdb->get_results($sql_per_bairros_fevereiro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_fevereiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-02-01' AND '2019-02-28' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_fev > '0'";
                                                            $num_desc_fevereiro = $wpdb->get_results($sql_num_desc_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_desc_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JAN</strong></td>";
                                                            $sql_pub_janeiro = "SELECT SUM(pub_jan) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1'";
                                                            $pub_janeiro = $wpdb->get_results($sql_pub_janeiro, ARRAY_A);
                                                            echo "<td>" . $pub_janeiro[0]['SUM(pub_jan)'] . "</td>";

                                                            $sql_ativ_janeiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $ativ_janeiro = $wpdb->get_results($sql_ativ_janeiro, ARRAY_A);
                                                            echo "<td>" . $ativ_janeiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_janeiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1' AND prof_sa = '1' AND pub_jan > '0'";
                                                            $age_janeiro = $wpdb->get_results($sql_age_janeiro, ARRAY_A);
                                                            echo "<td>" . $age_janeiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_janeiro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $num_age_janeiro = $wpdb->get_results($sql_num_age_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_age_janeiro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $num_bairros_janeiro = $wpdb->get_results($sql_num_bairros_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_janeiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $per_bairros_janeiro = $wpdb->get_results($sql_per_bairros_janeiro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_janeiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2019-01-01' AND '2019-01-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jan > '0'";
                                                            $num_desc_janeiro = $wpdb->get_results($sql_num_desc_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_desc_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                             ?>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <label><h2>2018</h2></label>
                                                        <tr>
                                                            <th>Período</th>
                                                            <th>Público</th>
                                                            <th>Nº Atividades</th>
                                                            <th>Nº Atividades com Agentes Locais</th>
                                                            <th>Nº Agentes Culturais Locais Envolvidos</th>
                                                            <th>Nº Bairros</th>
                                                            <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                                                            <th>Nº Bairros Descentralizados</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>

                                                            <?php
                                                            echo "<tr>";
                                                            echo "<td><strong>DEZ</strong></td>";

                                                            $sql_pub_dezembro = "SELECT SUM(pub_dez) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1'";
                                                            $pub_dezembro = $wpdb->get_results($sql_pub_dezembro, ARRAY_A);
                                                            echo "<td>" . $pub_dezembro[0]['SUM(pub_dez)'] . "</td>";

                                                            $sql_ativ_dezembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $ativ_dezembro = $wpdb->get_results($sql_ativ_dezembro, ARRAY_A);
                                                            echo "<td>" . $ativ_dezembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_dezembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1' AND prof_sa = '1' AND pub_dez > '0'";
                                                            $age_dezembro = $wpdb->get_results($sql_age_dezembro, ARRAY_A);
                                                            echo "<td>" . $age_dezembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_dezembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $num_age_dezembro = $wpdb->get_results($sql_num_age_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_age_dezembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $num_bairros_dezembro = $wpdb->get_results($sql_num_bairros_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_dezembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND publicado = '1' AND pub_dez > '0'";
                                                            $per_bairros_dezembro = $wpdb->get_results($sql_per_bairros_dezembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_dezembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-12-01' AND '2018-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_dez > '0'";
                                                            $num_desc_dezembro = $wpdb->get_results($sql_num_desc_dezembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>NOV</strong></td>";

                                                            $sql_pub_novembro = "SELECT SUM(pub_nov) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1'";
                                                            $pub_novembro = $wpdb->get_results($sql_pub_novembro, ARRAY_A);
                                                            echo "<td>" . $pub_novembro[0]['SUM(pub_nov)'] . "</td>";

                                                            $sql_ativ_novembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $ativ_novembro = $wpdb->get_results($sql_ativ_novembro, ARRAY_A);
                                                            echo "<td>" . $ativ_novembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_novembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1' AND prof_sa = '1' AND pub_nov > '0'";
                                                            $age_novembro = $wpdb->get_results($sql_age_novembro, ARRAY_A);
                                                            echo "<td>" . $age_novembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_novembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $num_age_novembro = $wpdb->get_results($sql_num_age_novembro, ARRAY_A);
                                                            echo "<td>" . $num_age_novembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $num_bairros_novembro = $wpdb->get_results($sql_num_bairros_novembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_novembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND publicado = '1' AND pub_nov > '0'";
                                                            $per_bairros_novembro = $wpdb->get_results($sql_per_bairros_novembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_novembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-11-01' AND '2018-11-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_nov > '0'";
                                                            $num_desc_novembro = $wpdb->get_results($sql_num_desc_novembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>OUT</strong></td>";
                                                            $sql_pub_outubro = "SELECT SUM(pub_out) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1'";
                                                            $pub_outubro = $wpdb->get_results($sql_pub_outubro, ARRAY_A);
                                                            echo "<td>" . $pub_outubro[0]['SUM(pub_out)'] . "</td>";

                                                            $sql_ativ_outubro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $ativ_outubro = $wpdb->get_results($sql_ativ_outubro, ARRAY_A);
                                                            echo "<td>" . $ativ_outubro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_outubro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1' AND prof_sa = '1' AND pub_out > '0'";
                                                            $age_outubro = $wpdb->get_results($sql_age_outubro, ARRAY_A);
                                                            echo "<td>" . $age_outubro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_outubro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $num_age_outubro = $wpdb->get_results($sql_num_age_outubro, ARRAY_A);
                                                            echo "<td>" . $num_age_outubro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $num_bairros_outubro = $wpdb->get_results($sql_num_bairros_outubro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_outubro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND publicado = '1' AND pub_out > '0'";
                                                            $per_bairros_outubro = $wpdb->get_results($sql_per_bairros_outubro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_outubro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-10-01' AND '2018-10-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_out > '0'";
                                                            $num_desc_outubro = $wpdb->get_results($sql_num_desc_outubro, ARRAY_A);
                                                            echo "<td>" . $num_desc_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>SET</strong></td>";

                                                            $sql_pub_setembro = "SELECT SUM(pub_set) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1'";
                                                            $pub_setembro = $wpdb->get_results($sql_pub_setembro, ARRAY_A);
                                                            echo "<td>" . $pub_setembro[0]['SUM(pub_set)'] . "</td>";

                                                            $sql_ativ_setembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $ativ_setembro = $wpdb->get_results($sql_ativ_setembro, ARRAY_A);
                                                            echo "<td>" . $ativ_setembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_setembro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1' AND prof_sa = '1' AND pub_set > '0'";
                                                            $age_setembro = $wpdb->get_results($sql_age_setembro, ARRAY_A);
                                                            echo "<td>" . $age_setembro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_setembro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $num_age_setembro = $wpdb->get_results($sql_num_age_setembro, ARRAY_A);
                                                            echo "<td>" . $num_age_setembro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $num_bairros_setembro = $wpdb->get_results($sql_num_bairros_setembro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_setembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND publicado = '1' AND pub_set > '0'";
                                                            $per_bairros_setembro = $wpdb->get_results($sql_per_bairros_setembro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_setembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-09-01' AND '2018-09-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_set > '0'";
                                                            $num_desc_setembro = $wpdb->get_results($sql_num_desc_setembro, ARRAY_A);
                                                            echo "<td>" . $num_desc_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>AGO</strong></td>";

                                                            $sql_pub_agosto = "SELECT SUM(pub_ago) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1'";
                                                            $pub_agosto = $wpdb->get_results($sql_pub_agosto, ARRAY_A);
                                                            echo "<td>" . $pub_agosto[0]['SUM(pub_ago)'] . "</td>";

                                                            $sql_ativ_agosto = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $ativ_agosto = $wpdb->get_results($sql_ativ_agosto, ARRAY_A);
                                                            echo "<td>" . $ativ_agosto[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_agosto = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1' AND prof_sa = '1' AND pub_ago > '0'";
                                                            $age_agosto = $wpdb->get_results($sql_age_agosto, ARRAY_A);
                                                            echo "<td>" . $age_agosto[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_agosto = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $num_age_agosto = $wpdb->get_results($sql_num_age_agosto, ARRAY_A);
                                                            echo "<td>" . $num_age_agosto[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $num_bairros_agosto = $wpdb->get_results($sql_num_bairros_agosto, ARRAY_A);
                                                            echo "<td>" . $num_bairros_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_agosto = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND publicado = '1' AND pub_ago > '0'";
                                                            $per_bairros_agosto = $wpdb->get_results($sql_per_bairros_agosto, ARRAY_A);
                                                            echo "<td>" . $per_bairros_agosto[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-08-01' AND '2018-08-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_ago > '0'";
                                                            $num_desc_agosto = $wpdb->get_results($sql_num_desc_agosto, ARRAY_A);
                                                            echo "<td>" . $num_desc_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JUL</strong></td>";

                                                            $sql_pub_julho = "SELECT SUM(pub_jul) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1'";
                                                            $pub_julho = $wpdb->get_results($sql_pub_julho, ARRAY_A);
                                                            echo "<td>" . $pub_julho[0]['SUM(pub_jul)'] . "</td>";

                                                            $sql_ativ_julho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $ativ_julho = $wpdb->get_results($sql_ativ_julho, ARRAY_A);
                                                            echo "<td>" . $ativ_julho[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_julho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1' AND prof_sa = '1' AND pub_jul > '0'";
                                                            $age_julho = $wpdb->get_results($sql_age_julho, ARRAY_A);
                                                            echo "<td>" . $age_julho[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_julho = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $num_age_julho = $wpdb->get_results($sql_num_age_julho, ARRAY_A);
                                                            echo "<td>" . $num_age_julho[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $num_bairros_julho = $wpdb->get_results($sql_num_bairros_julho, ARRAY_A);
                                                            echo "<td>" . $num_bairros_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_julho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND publicado = '1' AND pub_jul > '0'";
                                                            $per_bairros_julho = $wpdb->get_results($sql_per_bairros_julho, ARRAY_A);
                                                            echo "<td>" . $per_bairros_julho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-07-01' AND '2018-07-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jul > '0'";
                                                            $num_desc_julho = $wpdb->get_results($sql_num_desc_julho, ARRAY_A);
                                                            echo "<td>" . $num_desc_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JUN</strong></td>";

                                                            $sql_pub_junho = "SELECT SUM(pub_jun) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1'";
                                                            $pub_junho = $wpdb->get_results($sql_pub_junho, ARRAY_A);
                                                            echo "<td>" . $pub_junho[0]['SUM(pub_jun)'] . "</td>";

                                                            $sql_ativ_junho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio 	BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $ativ_junho = $wpdb->get_results($sql_ativ_junho, ARRAY_A);
                                                            echo "<td>" . $ativ_junho[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_junho = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1' AND prof_sa = '1' AND pub_jun > '0'";
                                                            $age_junho = $wpdb->get_results($sql_age_junho, ARRAY_A);
                                                            echo "<td>" . $age_junho[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_junho = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $num_age_junho = $wpdb->get_results($sql_num_age_junho, ARRAY_A);
                                                            echo "<td>" . $num_age_junho[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $num_bairros_junho = $wpdb->get_results($sql_num_bairros_junho, ARRAY_A);
                                                            echo "<td>" . $num_bairros_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_junho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND publicado = '1' AND pub_jun > '0'";
                                                            $per_bairros_junho = $wpdb->get_results($sql_per_bairros_junho, ARRAY_A);
                                                            echo "<td>" . $per_bairros_junho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-06-01' AND '2018-06-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jun > '0'";
                                                            $num_desc_junho = $wpdb->get_results($sql_num_desc_junho, ARRAY_A);
                                                            echo "<td>" . $num_desc_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>MAI</strong></td>";

                                                            $sql_pub_maio = "SELECT SUM(pub_mai) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1'";
                                                            $pub_maio = $wpdb->get_results($sql_pub_maio, ARRAY_A);
                                                            echo "<td>" . $pub_maio[0]['SUM(pub_mai)'] . "</td>";

                                                            $sql_ativ_maio = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $ativ_maio = $wpdb->get_results($sql_ativ_maio, ARRAY_A);
                                                            echo "<td>" . $ativ_maio[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_maio = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1' AND prof_sa = '1' AND pub_mai > '0'";
                                                            $age_maio = $wpdb->get_results($sql_age_maio, ARRAY_A);
                                                            echo "<td>" . $age_maio[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_maio = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $num_age_maio = $wpdb->get_results($sql_num_age_maio, ARRAY_A);
                                                            echo "<td>" . $num_age_maio[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $num_bairros_maio = $wpdb->get_results($sql_num_bairros_maio, ARRAY_A);
                                                            echo "<td>" . $num_bairros_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_maio = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND publicado = '1' AND pub_mai > '0'";
                                                            $per_bairros_maio = $wpdb->get_results($sql_per_bairros_maio, ARRAY_A);
                                                            echo "<td>" . $per_bairros_maio[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-05-01' AND '2018-05-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_mai > '0'";
                                                            $num_desc_maio = $wpdb->get_results($sql_num_desc_maio, ARRAY_A);
                                                            echo "<td>" . $num_desc_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>ABR</strong></td>";

                                                            $sql_pub_abril = "SELECT SUM(pub_abr) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1'";
                                                            $pub_abril = $wpdb->get_results($sql_pub_abril, ARRAY_A);
                                                            echo "<td>" . $pub_abril[0]['SUM(pub_abr)'] . "</td>";

                                                            $sql_ativ_abril = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $ativ_abril = $wpdb->get_results($sql_ativ_abril, ARRAY_A);
                                                            echo "<td>" . $ativ_abril[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_abril = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1' AND prof_sa = '1' AND pub_abr > '0'";
                                                            $age_abril = $wpdb->get_results($sql_age_abril, ARRAY_A);
                                                            echo "<td>" . $age_abril[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_abril = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $num_age_abril = $wpdb->get_results($sql_num_age_abril, ARRAY_A);
                                                            echo "<td>" . $num_age_abril[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $num_bairros_abril = $wpdb->get_results($sql_num_bairros_abril, ARRAY_A);
                                                            echo "<td>" . $num_bairros_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_abril = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND publicado = '1' AND pub_abr > '0'";
                                                            $per_bairros_abril = $wpdb->get_results($sql_per_bairros_abril, ARRAY_A);
                                                            echo "<td>" . $per_bairros_abril[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-04-01' AND '2018-04-30' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_abr > '0'";
                                                            $num_desc_abril = $wpdb->get_results($sql_num_desc_abril, ARRAY_A);
                                                            echo "<td>" . $num_desc_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>MAR</strong></td>";

                                                            $sql_pub_marco = "SELECT SUM(pub_mar) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1'";
                                                            $pub_marco = $wpdb->get_results($sql_pub_marco, ARRAY_A);
                                                            echo "<td>" . $pub_marco[0]['SUM(pub_mar)'] . "</td>";

                                                            $sql_ativ_marco = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $ativ_marco = $wpdb->get_results($sql_ativ_marco, ARRAY_A);
                                                            echo "<td>" . $ativ_marco[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_marco = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1' AND prof_sa = '1' AND pub_mar > '0'";
                                                            $age_marco = $wpdb->get_results($sql_age_marco, ARRAY_A);
                                                            echo "<td>" . $age_marco[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_marco = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $num_age_marco = $wpdb->get_results($sql_num_age_marco, ARRAY_A);
                                                            echo "<td>" . $num_age_marco[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $num_bairros_marco = $wpdb->get_results($sql_num_bairros_marco, ARRAY_A);
                                                            echo "<td>" . $num_bairros_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_marco = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND publicado = '1' AND pub_mar > '0'";
                                                            $per_bairros_marco = $wpdb->get_results($sql_per_bairros_marco, ARRAY_A);
                                                            echo "<td>" . $per_bairros_marco[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-03-01' AND '2018-03-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_mar > '0'";
                                                            $num_desc_marco = $wpdb->get_results($sql_num_desc_marco, ARRAY_A);
                                                            echo "<td>" . $num_desc_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>FEV</strong></td>";

                                                            $sql_pub_fevereiro = "SELECT SUM(pub_fev) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1'";
                                                            $pub_fevereiro = $wpdb->get_results($sql_pub_fevereiro, ARRAY_A);
                                                            echo "<td>" . $pub_fevereiro[0]['SUM(pub_fev)'] . "</td>";

                                                            $sql_ativ_fevereiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $ativ_fevereiro = $wpdb->get_results($sql_ativ_fevereiro, ARRAY_A);
                                                            echo "<td>" . $ativ_fevereiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_fevereiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1' AND prof_sa = '1' AND pub_fev > '0'";
                                                            $age_fevereiro = $wpdb->get_results($sql_age_fevereiro, ARRAY_A);
                                                            echo "<td>" . $age_fevereiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_fevereiro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $num_age_fevereiro = $wpdb->get_results($sql_num_age_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_age_fevereiro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $num_bairros_fevereiro = $wpdb->get_results($sql_num_bairros_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_fevereiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND publicado = '1' AND pub_fev > '0'";
                                                            $per_bairros_fevereiro = $wpdb->get_results($sql_per_bairros_fevereiro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_fevereiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-02-01' AND '2018-02-28' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_fev > '0'";
                                                            $num_desc_fevereiro = $wpdb->get_results($sql_num_desc_fevereiro, ARRAY_A);
                                                            echo "<td>" . $num_desc_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            echo "<td><strong>JAN</strong></td>";
                                                            $sql_pub_janeiro = "SELECT SUM(pub_jan) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1'";
                                                            $pub_janeiro = $wpdb->get_results($sql_pub_janeiro, ARRAY_A);
                                                            echo "<td>" . $pub_janeiro[0]['SUM(pub_jan)'] . "</td>";

                                                            $sql_ativ_janeiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $ativ_janeiro = $wpdb->get_results($sql_ativ_janeiro, ARRAY_A);
                                                            echo "<td>" . $ativ_janeiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_age_janeiro = "SELECT COUNT(id) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1' AND prof_sa = '1' AND pub_jan > '0'";
                                                            $age_janeiro = $wpdb->get_results($sql_age_janeiro, ARRAY_A);
                                                            echo "<td>" . $age_janeiro[0]['COUNT(id)'] . "</td>";

                                                            $sql_num_age_janeiro = "SELECT SUM(quantidade_prof_sa) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $num_age_janeiro = $wpdb->get_results($sql_num_age_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_age_janeiro[0]['SUM(quantidade_prof_sa)'] . "</td>";

                                                            $sql_num_bairros_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $num_bairros_janeiro = $wpdb->get_results($sql_num_bairros_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_bairros_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                            $sql_per_bairros_janeiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND publicado = '1' AND pub_jan > '0'";
                                                            $per_bairros_janeiro = $wpdb->get_results($sql_per_bairros_janeiro, ARRAY_A);
                                                            echo "<td>" . $per_bairros_janeiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                            $sql_num_desc_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_continuadas WHERE periodoInicio BETWEEN '2018-01-01' AND '2018-01-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND pub_jan > '0'";
                                                            $num_desc_janeiro = $wpdb->get_results($sql_num_desc_janeiro, ARRAY_A);
                                                            echo "<td>" . $num_desc_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                            echo "</tr>";

                                                            echo "<tr>";
                                                            ?>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <?php
                                                break; */
                                                /*case "tabelaincentivo":

                                                ?>

                                                    <div class="form-group">
                                                        <div class="col-md-offset-2">
                                                            <h1>Resumo das Ações de Incentivo</h1>

                                                        </div>
                                                    </div>
                                                <br/><br/>
<?php
$ano = anoOrcamento(true);

for($i = 0; $i < count($ano); $i++){
	$ano_base = $ano[$i]['ano_base'];

	?>
	


                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <label><h2><?php echo $ano_base; ?></h2></label>
                                                        <tr>
                                                            <th>Período</th>
                                                            <th>Público Geral</th>
                                                            <th>Público Santo André</th>
                                                            <th>Nº Atividades</th>
                                                            <th>Nº Atividades com Agentes Locais</th>
                                                            <th>Nº Agentes Culturais Locais Envolvidos</th>
                                                            <th>Nº Bairros</th>
                                                            <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                                                            <th>Nº Bairros Descentralizados</th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?php

                                                        echo "<tr>";
                                                        echo "<td><strong>DEZ</strong></td>";

                                                        $sql_pub_dezembro = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_dezembro = $wpdb->get_results($sql_pub_dezembro, ARRAY_A);
                                                        echo "<td>" . $pub_dezembro[0]['SUM(dezembro)'] . "</td>";

                                                        $sql_pub_sa_dezembro = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_dezembro = $wpdb->get_results($sql_pub_sa_dezembro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_dezembro[0]['SUM(dezembro_sa)'] . "</td>";

                                                        $sql_ativ_dezembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND dezembro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_dezembro = $wpdb->get_results($sql_ativ_dezembro, ARRAY_A);
                                                        echo "<td>" . $ativ_dezembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_dezembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND dezembro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_dezembro = $wpdb->get_results($sql_age_dezembro, ARRAY_A);
                                                        echo "<td>" . $age_dezembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_dezembro = "SELECT SUM(santo_andre) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_dezembro = $wpdb->get_results($sql_num_age_dezembro, ARRAY_A);
                                                        echo "<td>" . $num_age_dezembro[0]['SUM(santo_andre)'] . "</td>";

                                                        $sql_num_bairros_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND dezembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_dezembro = $wpdb->get_results($sql_num_bairros_dezembro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_dezembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/105,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND dezembro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_dezembro = $wpdb->get_results($sql_per_bairros_dezembro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_dezembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND dezembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_dezembro = $wpdb->get_results($sql_num_desc_dezembro, ARRAY_A);
                                                        echo "<td>" . $num_desc_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>NOV</strong></td>";

                                                        $sql_pub_novembro = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_novembro = $wpdb->get_results($sql_pub_novembro, ARRAY_A);
                                                        echo "<td>" . $pub_novembro[0]['SUM(novembro)'] . "</td>";

                                                        $sql_pub_sa_novembro = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_novembro = $wpdb->get_results($sql_pub_sa_novembro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_novembro[0]['SUM(novembro_sa)'] . "</td>";

                                                        $sql_ativ_novembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND novembro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_novembro = $wpdb->get_results($sql_ativ_novembro, ARRAY_A);
                                                        echo "<td>" . $ativ_novembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_novembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND novembro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_novembro = $wpdb->get_results($sql_age_novembro, ARRAY_A);
                                                        echo "<td>" . $age_novembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_novembro = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_novembro = $wpdb->get_results($sql_num_age_novembro, ARRAY_A);
                                                        echo "<td>" . $num_age_novembro[0]['SUM(novembro_sa)'] . "</td>";

                                                        $sql_num_bairros_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND novembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_novembro = $wpdb->get_results($sql_num_bairros_novembro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_novembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND novembro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_novembro = $wpdb->get_results($sql_per_bairros_novembro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_novembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND novembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_novembro = $wpdb->get_results($sql_num_desc_novembro, ARRAY_A);
                                                        echo "<td>" . $num_desc_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>OUT</strong></td>";

                                                        $sql_pub_outubro = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_outubro = $wpdb->get_results($sql_pub_outubro, ARRAY_A);
                                                        echo "<td>" . $pub_outubro[0]['SUM(outubro)'] . "</td>";

                                                        $sql_pub_sa_outubro = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_outubro = $wpdb->get_results($sql_pub_sa_outubro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_outubro[0]['SUM(outubro_sa)'] . "</td>";

                                                        $sql_ativ_outubro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND outubro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_outubro = $wpdb->get_results($sql_ativ_outubro, ARRAY_A);
                                                        echo "<td>" . $ativ_outubro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_outubro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND outubro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_outubro = $wpdb->get_results($sql_age_outubro, ARRAY_A);
                                                        echo "<td>" . $age_outubro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_outubro = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_outubro = $wpdb->get_results($sql_num_age_outubro, ARRAY_A);
                                                        echo "<td>" . $num_age_outubro[0]['SUM(outubro_sa)'] . "</td>";

                                                        $sql_num_bairros_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND outubro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_outubro = $wpdb->get_results($sql_num_bairros_outubro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_outubro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND outubro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_outubro = $wpdb->get_results($sql_per_bairros_outubro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_outubro[0]['ROUND(COUNT(DISTINCT(bairro))*100/105,2)'] . "</td>";

                                                        $sql_num_desc_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND outubro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_outubro = $wpdb->get_results($sql_num_desc_outubro, ARRAY_A);
                                                        echo "<td>" . $num_desc_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>SET</strong></td>";

                                                        $sql_pub_setembro = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_setembro = $wpdb->get_results($sql_pub_setembro, ARRAY_A);
                                                        echo "<td>" . $pub_setembro[0]['SUM(setembro)'] . "</td>";

                                                        $sql_pub_sa_setembro = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_setembro = $wpdb->get_results($sql_pub_sa_setembro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_setembro[0]['SUM(setembro_sa)'] . "</td>";

                                                        $sql_ativ_setembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND setembro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_setembro = $wpdb->get_results($sql_ativ_setembro, ARRAY_A);
                                                        echo "<td>" . $ativ_setembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_setembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND setembro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_setembro = $wpdb->get_results($sql_age_setembro, ARRAY_A);
                                                        echo "<td>" . $age_setembro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_setembro = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_setembro = $wpdb->get_results($sql_num_age_setembro, ARRAY_A);
                                                        echo "<td>" . $num_age_setembro[0]['SUM(setembro_sa)'] . "</td>";

                                                        $sql_num_bairros_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND setembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_setembro = $wpdb->get_results($sql_num_bairros_setembro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_setembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND setembro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_setembro = $wpdb->get_results($sql_per_bairros_setembro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_setembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND setembro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_setembro = $wpdb->get_results($sql_num_desc_setembro, ARRAY_A);
                                                        echo "<td>" . $num_desc_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>AGO</strong></td>";

                                                        $sql_pub_agosto = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_agosto = $wpdb->get_results($sql_pub_agosto, ARRAY_A);
                                                        echo "<td>" . $pub_agosto[0]['SUM(agosto)'] . "</td>";

                                                        $sql_pub_sa_agosto = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_agosto = $wpdb->get_results($sql_pub_sa_agosto, ARRAY_A);
                                                        echo "<td>" . $pub_sa_agosto[0]['SUM(agosto_sa)'] . "</td>";

                                                        $sql_ativ_agosto = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND agosto > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_agosto = $wpdb->get_results($sql_ativ_agosto, ARRAY_A);
                                                        echo "<td>" . $ativ_agosto[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_agosto = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND agosto_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_agosto = $wpdb->get_results($sql_age_agosto, ARRAY_A);
                                                        echo "<td>" . $age_agosto[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_agosto = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_agosto = $wpdb->get_results($sql_num_age_agosto, ARRAY_A);
                                                        echo "<td>" . $num_age_agosto[0]['SUM(agosto_sa)'] . "</td>";

                                                        $sql_num_bairros_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND agosto > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_agosto = $wpdb->get_results($sql_num_bairros_agosto, ARRAY_A);
                                                        echo "<td>" . $num_bairros_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_agosto = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND agosto > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_agosto = $wpdb->get_results($sql_per_bairros_agosto, ARRAY_A);
                                                        echo "<td>" . $per_bairros_agosto[0]['ROUND(COUNT(DISTINCT(bairro))*100/105,2)'] . "</td>";

                                                        $sql_num_desc_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND agosto > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_agosto = $wpdb->get_results($sql_num_desc_agosto, ARRAY_A);
                                                        echo "<td>" . $num_desc_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>JUL</strong></td>";

                                                        $sql_pub_julho = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_julho = $wpdb->get_results($sql_pub_julho, ARRAY_A);
                                                        echo "<td>" . $pub_julho[0]['SUM(julho)'] . "</td>";

                                                        $sql_pub_sa_julho = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_julho = $wpdb->get_results($sql_pub_sa_julho, ARRAY_A);
                                                        echo "<td>" . $pub_sa_julho[0]['SUM(julho_sa)'] . "</td>";

                                                        $sql_ativ_julho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND julho > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_julho = $wpdb->get_results($sql_ativ_julho, ARRAY_A);
                                                        echo "<td>" . $ativ_julho[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_julho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND julho_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_julho = $wpdb->get_results($sql_age_julho, ARRAY_A);
                                                        echo "<td>" . $age_julho[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_julho = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_julho = $wpdb->get_results($sql_num_age_julho, ARRAY_A);
                                                        echo "<td>" . $num_age_julho[0]['SUM(julho_sa)'] . "</td>";

                                                        $sql_num_bairros_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND julho > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_julho = $wpdb->get_results($sql_num_bairros_julho, ARRAY_A);
                                                        echo "<td>" . $num_bairros_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_julho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND julho > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_julho = $wpdb->get_results($sql_per_bairros_julho, ARRAY_A);
                                                        echo "<td>" . $per_bairros_julho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND julho > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_julho = $wpdb->get_results($sql_num_desc_julho, ARRAY_A);
                                                        echo "<td>" . $num_desc_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>JUN</strong></td>";

                                                        $sql_pub_junho = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_junho = $wpdb->get_results($sql_pub_junho, ARRAY_A);
                                                        echo "<td>" . $pub_junho[0]['SUM(junho)'] . "</td>";

                                                        $sql_pub_sa_junho = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_junho = $wpdb->get_results($sql_pub_sa_junho, ARRAY_A);
                                                        echo "<td>" . $pub_sa_junho[0]['SUM(junho_sa)'] . "</td>";

                                                        $sql_ativ_junho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND junho > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_junho = $wpdb->get_results($sql_ativ_junho, ARRAY_A);
                                                        echo "<td>" . $ativ_junho[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_junho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND junho_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_junho = $wpdb->get_results($sql_age_junho, ARRAY_A);
                                                        echo "<td>" . $age_junho[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_junho = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_junho = $wpdb->get_results($sql_num_age_junho, ARRAY_A);
                                                        echo "<td>" . $num_age_junho[0]['SUM(junho_sa)'] . "</td>";

                                                        $sql_num_bairros_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND junho > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_junho = $wpdb->get_results($sql_num_bairros_junho, ARRAY_A);
                                                        echo "<td>" . $num_bairros_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_junho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND junho > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_junho = $wpdb->get_results($sql_per_bairros_junho, ARRAY_A);
                                                        echo "<td>" . $per_bairros_junho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND junho > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_junho = $wpdb->get_results($sql_num_desc_junho, ARRAY_A);
                                                        echo "<td>" . $num_desc_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>MAI</strong></td>";

                                                        $sql_pub_maio = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_maio = $wpdb->get_results($sql_pub_maio, ARRAY_A);
                                                        echo "<td>" . $pub_maio[0]['SUM(maio)'] . "</td>";

                                                        $sql_pub_sa_maio = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_maio = $wpdb->get_results($sql_pub_sa_maio, ARRAY_A);
                                                        echo "<td>" . $pub_sa_maio[0]['SUM(maio_sa)'] . "</td>";

                                                        $sql_ativ_maio = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND maio > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_maio = $wpdb->get_results($sql_ativ_maio, ARRAY_A);
                                                        echo "<td>" . $ativ_maio[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_maio = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND maio_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_maio = $wpdb->get_results($sql_age_maio, ARRAY_A);
                                                        echo "<td>" . $age_maio[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_maio = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_maio = $wpdb->get_results($sql_num_age_maio, ARRAY_A);
                                                        echo "<td>" . $num_age_maio[0]['SUM(maio_sa)'] . "</td>";

                                                        $sql_num_bairros_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND maio > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_maio = $wpdb->get_results($sql_num_bairros_maio, ARRAY_A);
                                                        echo "<td>" . $num_bairros_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_maio = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND maio > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_maio = $wpdb->get_results($sql_per_bairros_maio, ARRAY_A);
                                                        echo "<td>" . $per_bairros_maio[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND maio > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_maio = $wpdb->get_results($sql_num_desc_maio, ARRAY_A);
                                                        echo "<td>" . $num_desc_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>ABR</strong></td>";

                                                        $sql_pub_abril = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_abril = $wpdb->get_results($sql_pub_abril, ARRAY_A);
                                                        echo "<td>" . $pub_abril[0]['SUM(abril)'] . "</td>";

                                                        $sql_pub_sa_abril = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_abril = $wpdb->get_results($sql_pub_sa_abril, ARRAY_A);
                                                        echo "<td>" . $pub_sa_abril[0]['SUM(abril_sa)'] . "</td>";

                                                        $sql_ativ_abril = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND abril > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_abril = $wpdb->get_results($sql_ativ_abril, ARRAY_A);
                                                        echo "<td>" . $ativ_abril[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_abril = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND abril_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_abril = $wpdb->get_results($sql_age_abril, ARRAY_A);
                                                        echo "<td>" . $age_abril[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_abril = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_abril = $wpdb->get_results($sql_num_age_abril, ARRAY_A);
                                                        echo "<td>" . $num_age_abril[0]['SUM(abril_sa)'] . "</td>";

                                                        $sql_num_bairros_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND abril > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_abril = $wpdb->get_results($sql_num_bairros_abril, ARRAY_A);
                                                        echo "<td>" . $num_bairros_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_abril = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND abril > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_abril = $wpdb->get_results($sql_per_bairros_abril, ARRAY_A);
                                                        echo "<td>" . $per_bairros_abril[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND abril > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_abril = $wpdb->get_results($sql_num_desc_abril, ARRAY_A);
                                                        echo "<td>" . $num_desc_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>MAR</strong></td>";

                                                        $sql_pub_marco = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_marco = $wpdb->get_results($sql_pub_marco, ARRAY_A);
                                                        echo "<td>" . $pub_marco[0]['SUM(marco)'] . "</td>";

                                                        $sql_pub_sa_marco = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_marco = $wpdb->get_results($sql_pub_sa_marco, ARRAY_A);
                                                        echo "<td>" . $pub_sa_marco[0]['SUM(marco_sa)'] . "</td>";

                                                        $sql_ativ_marco = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND marco > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_marco = $wpdb->get_results($sql_ativ_marco, ARRAY_A);
                                                        echo "<td>" . $ativ_marco[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_marco = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND marco_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_marco = $wpdb->get_results($sql_age_marco, ARRAY_A);
                                                        echo "<td>" . $age_marco[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_marco = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_marco = $wpdb->get_results($sql_num_age_marco, ARRAY_A);
                                                        echo "<td>" . $num_age_marco[0]['SUM(marco_sa)'] . "</td>";

                                                        $sql_num_bairros_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND marco > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_marco = $wpdb->get_results($sql_num_bairros_marco, ARRAY_A);
                                                        echo "<td>" . $num_bairros_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_marco = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND marco > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_marco = $wpdb->get_results($sql_per_bairros_marco, ARRAY_A);
                                                        echo "<td>" . $per_bairros_marco[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND marco > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_marco = $wpdb->get_results($sql_num_desc_marco, ARRAY_A);
                                                        echo "<td>" . $num_desc_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>FEV</strong></td>";

                                                        $sql_pub_fevereiro = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_fevereiro = $wpdb->get_results($sql_pub_fevereiro, ARRAY_A);
                                                        echo "<td>" . $pub_fevereiro[0]['SUM(fevereiro)'] . "</td>";

                                                        $sql_pub_sa_fevereiro = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_fevereiro = $wpdb->get_results($sql_pub_sa_fevereiro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_fevereiro[0]['SUM(fevereiro_sa)'] . "</td>";

                                                        $sql_ativ_fevereiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND fevereiro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_fevereiro = $wpdb->get_results($sql_ativ_fevereiro, ARRAY_A);
                                                        echo "<td>" . $ativ_fevereiro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_fevereiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND fevereiro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_fevereiro = $wpdb->get_results($sql_age_fevereiro, ARRAY_A);
                                                        echo "<td>" . $age_fevereiro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_fevereiro = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_fevereiro = $wpdb->get_results($sql_num_age_fevereiro, ARRAY_A);
                                                        echo "<td>" . $num_age_fevereiro[0]['SUM(fevereiro_sa)'] . "</td>";

                                                        $sql_num_bairros_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND fevereiro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_fevereiro = $wpdb->get_results($sql_num_bairros_fevereiro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_fevereiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND fevereiro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_fevereiro = $wpdb->get_results($sql_per_bairros_fevereiro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_fevereiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND fevereiro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_fevereiro = $wpdb->get_results($sql_num_desc_fevereiro, ARRAY_A);
                                                        echo "<td>" . $num_desc_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";

                                                        echo "<tr>";
                                                        echo "<td><strong>JAN</strong></td>";

                                                        $sql_pub_janeiro = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_janeiro = $wpdb->get_results($sql_pub_janeiro, ARRAY_A);
                                                        echo "<td>" . $pub_janeiro[0]['SUM(janeiro)'] . "</td>";

                                                        $sql_pub_sa_janeiro = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $pub_sa_janeiro = $wpdb->get_results($sql_pub_sa_janeiro, ARRAY_A);
                                                        echo "<td>" . $pub_sa_janeiro[0]['SUM(janeiro_sa)'] . "</td>";

                                                        $sql_ativ_janeiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND janeiro > '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $ativ_janeiro = $wpdb->get_results($sql_ativ_janeiro, ARRAY_A);
                                                        echo "<td>" . $ativ_janeiro[0]['COUNT(id)'] . "</td>";

                                                        $sql_age_janeiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND janeiro_sa > '0' AND projeto NOT IN (378,723)";
                                                        $age_janeiro = $wpdb->get_results($sql_age_janeiro, ARRAY_A);
                                                        echo "<td>" . $age_janeiro[0]['COUNT(id)'] . "</td>";

                                                        $sql_num_age_janeiro = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                        $num_age_janeiro = $wpdb->get_results($sql_num_age_janeiro, ARRAY_A);
                                                        echo "<td>" . $num_age_janeiro[0]['SUM(janeiro_sa)'] . "</td>";

                                                        $sql_num_bairros_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND janeiro > '0' AND projeto NOT IN (378,723)";
                                                        $num_bairros_janeiro = $wpdb->get_results($sql_num_bairros_janeiro, ARRAY_A);
                                                        echo "<td>" . $num_bairros_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                        $sql_per_bairros_janeiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' AND janeiro > '0' AND projeto NOT IN (378,723)";
                                                        $per_bairros_janeiro = $wpdb->get_results($sql_per_bairros_janeiro, ARRAY_A);
                                                        echo "<td>" . $per_bairros_janeiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                        $sql_num_desc_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND janeiro > '0' AND projeto NOT IN (378,723)";
                                                        $num_desc_janeiro = $wpdb->get_results($sql_num_desc_janeiro, ARRAY_A);
                                                        echo "<td>" . $num_desc_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                        echo "</tr>";
                                                        echo "</tr>";

                                                        ?>

                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <br>
                                                                <label><h2><?php echo $ano_base; ?> - Por Espaço</h2></label>
                                                                <tr>
                                                                    <th>Período</th>
                                                                    <th>CEU Ana Maria</th>
                                                                    <th>CEU Marek</th>
                                                                    <th>EMIA - Escola Municipal de Iniciação Artística
                                                                        Jaçatuba
                                                                    </th>
                                                                    <th>ELCV - Escola livre de Cinema e Vídeo</th>
                                                                    <th>ELD - Escola Livre de Dança</th>
                                                                    <th>ELT - Escola Livre de Teatro</th>
                                                                    <th>Territórios de Cultura</th>
                                                                    <th width="10%"></th>
                                                                    <th width="10%"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php

                                                                echo "<tr>";
                                                                echo "<td><strong>DEZ - GERAL</strong></td>";

                                                                $sql_dez_marek = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_marek = $wpdb->get_results($sql_dez_marek, ARRAY_A);
                                                                echo "<td>" . $dez_marek[0]['SUM(dezembro)'] . "</td>";

                                                                $sql_dez_emia = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_emia = $wpdb->get_results($sql_dez_emia, ARRAY_A);
                                                                echo "<td>" . $dez_emia[0]['SUM(dezembro)'] . "</td>";

                                                                $sql_dez_elcv = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_elcv = $wpdb->get_results($sql_dez_elcv, ARRAY_A);
                                                                echo "<td>" . $dez_elcv[0]['SUM(dezembro)'] . "</td>";

                                                                $sql_dez_eld = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_eld = $wpdb->get_results($sql_dez_eld, ARRAY_A);
                                                                echo "<td>" . $dez_eld[0]['SUM(dezembro)'] . "</td>";

                                                                $sql_dez_elt = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_elt = $wpdb->get_results($sql_dez_elt, ARRAY_A);
                                                                echo "<td>" . $dez_elt[0]['SUM(dezembro)'] . "</td>";

                                                                $sql_dez_territoriosc = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_territoriosc = $wpdb->get_results($sql_dez_territoriosc, ARRAY_A);
                                                                echo "<td>" . $dez_territoriosc[0]['SUM(dezembro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>DEZ - SA</strong></td>";

                                                                $sql_dez_sa_marek = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_marek = $wpdb->get_results($sql_dez_sa_marek, ARRAY_A);
                                                                echo "<td>" . $dez_sa_marek[0]['SUM(dezembro_sa)'] . "</td>";

                                                                $sql_dez_sa_emia = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_emia = $wpdb->get_results($sql_dez_sa_emia, ARRAY_A);
                                                                echo "<td>" . $dez_sa_emia[0]['SUM(dezembro_sa)'] . "</td>";

                                                                $sql_dez_sa_elcv = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_elcv = $wpdb->get_results($sql_dez_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $dez_sa_elcv[0]['SUM(dezembro_sa)'] . "</td>";

                                                                $sql_dez_sa_eld = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_eld = $wpdb->get_results($sql_dez_sa_eld, ARRAY_A);
                                                                echo "<td>" . $dez_sa_eld[0]['SUM(dezembro_sa)'] . "</td>";

                                                                $sql_dez_sa_elt = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_elt = $wpdb->get_results($sql_dez_sa_elt, ARRAY_A);
                                                                echo "<td>" . $dez_sa_elt[0]['SUM(dezembro_sa)'] . "</td>";

                                                                $sql_dez_sa_territoriosc = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $dez_sa_territoriosc = $wpdb->get_results($sql_dez_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $dez_sa_territoriosc[0]['SUM(dezembro_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>NOV - GERAL</strong></td>";

                                                                $sql_nov_marek = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_marek = $wpdb->get_results($sql_nov_marek, ARRAY_A);
                                                                echo "<td>" . $nov_marek[0]['SUM(novembro)'] . "</td>";

                                                                $sql_nov_emia = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_emia = $wpdb->get_results($sql_nov_emia, ARRAY_A);
                                                                echo "<td>" . $nov_emia[0]['SUM(novembro)'] . "</td>";

                                                                $sql_nov_elcv = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_elcv = $wpdb->get_results($sql_nov_elcv, ARRAY_A);
                                                                echo "<td>" . $nov_elcv[0]['SUM(novembro)'] . "</td>";

                                                                $sql_nov_eld = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_eld = $wpdb->get_results($sql_nov_eld, ARRAY_A);
                                                                echo "<td>" . $nov_eld[0]['SUM(novembro)'] . "</td>";

                                                                $sql_nov_elt = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_elt = $wpdb->get_results($sql_nov_elt, ARRAY_A);
                                                                echo "<td>" . $nov_elt[0]['SUM(novembro)'] . "</td>";

                                                                $sql_nov_territoriosc = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_territoriosc = $wpdb->get_results($sql_nov_territoriosc, ARRAY_A);
                                                                echo "<td>" . $nov_territoriosc[0]['SUM(novembro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>NOV - SA</strong></td>";

                                                                $sql_nov_sa_marek = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_marek = $wpdb->get_results($sql_nov_sa_marek, ARRAY_A);
                                                                echo "<td>" . $nov_sa_marek[0]['SUM(novembro_sa)'] . "</td>";

                                                                $sql_nov_sa_emia = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_emia = $wpdb->get_results($sql_nov_sa_emia, ARRAY_A);
                                                                echo "<td>" . $nov_sa_emia[0]['SUM(novembro_sa)'] . "</td>";

                                                                $sql_nov_sa_elcv = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_elcv = $wpdb->get_results($sql_nov_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $nov_sa_elcv[0]['SUM(novembro_sa)'] . "</td>";

                                                                $sql_nov_sa_eld = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_eld = $wpdb->get_results($sql_nov_sa_eld, ARRAY_A);
                                                                echo "<td>" . $nov_sa_eld[0]['SUM(novembro_sa)'] . "</td>";

                                                                $sql_nov_sa_elt = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_elt = $wpdb->get_results($sql_nov_sa_elt, ARRAY_A);
                                                                echo "<td>" . $nov_sa_elt[0]['SUM(novembro_sa)'] . "</td>";

                                                                $sql_nov_sa_territoriosc = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $nov_sa_territoriosc = $wpdb->get_results($sql_nov_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $nov_sa_territoriosc[0]['SUM(novembro_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>OUT - GERAl</strong></td>";

                                                                $sql_out_marek = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_marek = $wpdb->get_results($sql_out_marek, ARRAY_A);
                                                                echo "<td>" . $out_marek[0]['SUM(outubro)'] . "</td>";

                                                                $sql_out_emia = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_emia = $wpdb->get_results($sql_out_emia, ARRAY_A);
                                                                echo "<td>" . $out_emia[0]['SUM(outubro)'] . "</td>";

                                                                $sql_out_elcv = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_elcv = $wpdb->get_results($sql_out_elcv, ARRAY_A);
                                                                echo "<td>" . $out_elcv[0]['SUM(outubro)'] . "</td>";

                                                                $sql_out_eld = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_eld = $wpdb->get_results($sql_out_eld, ARRAY_A);
                                                                echo "<td>" . $out_eld[0]['SUM(outubro)'] . "</td>";

                                                                $sql_out_elt = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_elt = $wpdb->get_results($sql_out_elt, ARRAY_A);
                                                                echo "<td>" . $out_elt[0]['SUM(outubro)'] . "</td>";

                                                                $sql_out_territoriosc = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_territoriosc = $wpdb->get_results($sql_out_territoriosc, ARRAY_A);
                                                                echo "<td>" . $out_territoriosc[0]['SUM(outubro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>OUT - SA</strong></td>";

                                                                $sql_out_sa_marek = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_marek = $wpdb->get_results($sql_out_sa_marek, ARRAY_A);
                                                                echo "<td>" . $out_sa_marek[0]['SUM(outubro_sa)'] . "</td>";

                                                                $sql_out_sa_emia = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_emia = $wpdb->get_results($sql_out_sa_emia, ARRAY_A);
                                                                echo "<td>" . $out_sa_emia[0]['SUM(outubro_sa)'] . "</td>";

                                                                $sql_out_sa_elcv = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_elcv = $wpdb->get_results($sql_out_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $out_sa_elcv[0]['SUM(outubro_sa)'] . "</td>";

                                                                $sql_out_sa_eld = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_eld = $wpdb->get_results($sql_out_sa_eld, ARRAY_A);
                                                                echo "<td>" . $out_sa_eld[0]['SUM(outubro_sa)'] . "</td>";

                                                                $sql_out_sa_elt = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_elt = $wpdb->get_results($sql_out_sa_elt, ARRAY_A);
                                                                echo "<td>" . $out_sa_elt[0]['SUM(outubro_sa)'] . "</td>";

                                                                $sql_out_sa_territoriosc = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $out_sa_territoriosc = $wpdb->get_results($sql_out_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $out_sa_territoriosc[0]['SUM(outubro_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>SET - GERAL</strong></td>";

                                                                $sql_set_marek = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_marek = $wpdb->get_results($sql_set_marek, ARRAY_A);
                                                                echo "<td>" . $set_marek[0]['SUM(setembro)'] . "</td>";

                                                                $sql_set_emia = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_emia = $wpdb->get_results($sql_set_emia, ARRAY_A);
                                                                echo "<td>" . $set_emia[0]['SUM(setembro)'] . "</td>";

                                                                $sql_set_elcv = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_elcv = $wpdb->get_results($sql_set_elcv, ARRAY_A);
                                                                echo "<td>" . $set_elcv[0]['SUM(setembro)'] . "</td>";

                                                                $sql_set_eld = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_eld = $wpdb->get_results($sql_set_eld, ARRAY_A);
                                                                echo "<td>" . $set_eld[0]['SUM(setembro)'] . "</td>";

                                                                $sql_set_elt = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_elt = $wpdb->get_results($sql_set_elt, ARRAY_A);
                                                                echo "<td>" . $set_elt[0]['SUM(setembro)'] . "</td>";

                                                                $sql_set_territoriosc = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_territoriosc = $wpdb->get_results($sql_set_territoriosc, ARRAY_A);
                                                                echo "<td>" . $set_territoriosc[0]['SUM(setembro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>SET - SA</strong></td>";

                                                                $sql_set_sa_marek = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_marek = $wpdb->get_results($sql_set_sa_marek, ARRAY_A);
                                                                echo "<td>" . $set_sa_marek[0]['SUM(setembro_sa)'] . "</td>";

                                                                $sql_set_sa_emia = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_emia = $wpdb->get_results($sql_set_sa_emia, ARRAY_A);
                                                                echo "<td>" . $set_sa_emia[0]['SUM(setembro_sa)'] . "</td>";

                                                                $sql_set_sa_elcv = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_elcv = $wpdb->get_results($sql_set_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $set_sa_elcv[0]['SUM(setembro_sa)'] . "</td>";

                                                                $sql_set_sa_eld = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_eld = $wpdb->get_results($sql_set_sa_eld, ARRAY_A);
                                                                echo "<td>" . $set_sa_eld[0]['SUM(setembro_sa)'] . "</td>";

                                                                $sql_set_sa_elt = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_elt = $wpdb->get_results($sql_set_sa_elt, ARRAY_A);
                                                                echo "<td>" . $set_sa_elt[0]['SUM(setembro_sa)'] . "</td>";

                                                                $sql_set_sa_territoriosc = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $set_sa_territoriosc = $wpdb->get_results($sql_set_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $set_sa_territoriosc[0]['SUM(setembro_sa)'] . "</td>";

                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>AGO - GERAL</strong></td>";

                                                                $sql_ago_marek = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_marek = $wpdb->get_results($sql_ago_marek, ARRAY_A);
                                                                echo "<td>" . $ago_marek[0]['SUM(agosto)'] . "</td>";

                                                                $sql_ago_emia = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_emia = $wpdb->get_results($sql_ago_emia, ARRAY_A);
                                                                echo "<td>" . $ago_emia[0]['SUM(agosto)'] . "</td>";

                                                                $sql_ago_elcv = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_elcv = $wpdb->get_results($sql_ago_elcv, ARRAY_A);
                                                                echo "<td>" . $ago_elcv[0]['SUM(agosto)'] . "</td>";

                                                                $sql_ago_eld = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE equipamento = '204' AND 		ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_eld = $wpdb->get_results($sql_ago_eld, ARRAY_A);
                                                                echo "<td>" . $ago_eld[0]['SUM(agosto)'] . "</td>";

                                                                $sql_ago_elt = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_elt = $wpdb->get_results($sql_ago_elt, ARRAY_A);
                                                                echo "<td>" . $ago_elt[0]['SUM(agosto)'] . "</td>";

                                                                $sql_ago_territoriosc = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_territoriosc = $wpdb->get_results($sql_ago_territoriosc, ARRAY_A);
                                                                echo "<td>" . $ago_territoriosc[0]['SUM(agosto)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>AGO - SA</strong></td>";

                                                                $sql_ago_sa_marek = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_marek = $wpdb->get_results($sql_ago_sa_marek, ARRAY_A);
                                                                echo "<td>" . $ago_sa_marek[0]['SUM(agosto_sa)'] . "</td>";

                                                                $sql_ago_sa_emia = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_emia = $wpdb->get_results($sql_ago_sa_emia, ARRAY_A);
                                                                echo "<td>" . $ago_sa_emia[0]['SUM(agosto_sa)'] . "</td>";

                                                                $sql_ago_sa_elcv = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_elcv = $wpdb->get_results($sql_ago_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $ago_sa_elcv[0]['SUM(agosto_sa)'] . "</td>";

                                                                $sql_ago_sa_eld = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_eld = $wpdb->get_results($sql_ago_sa_eld, ARRAY_A);
                                                                echo "<td>" . $ago_sa_eld[0]['SUM(agosto_sa)'] . "</td>";

                                                                $sql_ago_sa_elt = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_elt = $wpdb->get_results($sql_ago_sa_elt, ARRAY_A);
                                                                echo "<td>" . $ago_sa_elt[0]['SUM(agosto_sa)'] . "</td>";

                                                                $sql_ago_sa_territoriosc = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $ago_sa_territoriosc = $wpdb->get_results($sql_ago_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $ago_sa_territoriosc[0]['SUM(agosto_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>JUL - GERAL </strong></td>";

                                                                $sql_jul_marek = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_marek = $wpdb->get_results($sql_jul_marek, ARRAY_A);
                                                                echo "<td>" . $jul_marek[0]['SUM(julho)'] . "</td>";

                                                                $sql_jul_emia = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_emia = $wpdb->get_results($sql_jul_emia, ARRAY_A);
                                                                echo "<td>" . $jul_emia[0]['SUM(julho)'] . "</td>";

                                                                $sql_jul_elcv = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_elcv = $wpdb->get_results($sql_jul_elcv, ARRAY_A);
                                                                echo "<td>" . $jul_elcv[0]['SUM(julho)'] . "</td>";

                                                                $sql_jul_eld = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_eld = $wpdb->get_results($sql_jul_eld, ARRAY_A);
                                                                echo "<td>" . $jul_eld[0]['SUM(julho)'] . "</td>";

                                                                $sql_jul_elt = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_elt = $wpdb->get_results($sql_jul_elt, ARRAY_A);
                                                                echo "<td>" . $jul_elt[0]['SUM(julho)'] . "</td>";

                                                                $sql_jul_territoriosc = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_territoriosc = $wpdb->get_results($sql_jul_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jul_territoriosc[0]['SUM(julho)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>JUL - SA</strong></td>";

                                                                $sql_jul_sa_marek = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_marek = $wpdb->get_results($sql_jul_sa_marek, ARRAY_A);
                                                                echo "<td>" . $jul_sa_marek[0]['SUM(julho_sa)'] . "</td>";

                                                                $sql_jul_sa_emia = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_emia = $wpdb->get_results($sql_jul_sa_emia, ARRAY_A);
                                                                echo "<td>" . $jul_sa_emia[0]['SUM(julho_sa)'] . "</td>";

                                                                $sql_jul_sa_elcv = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_elcv = $wpdb->get_results($sql_jul_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $jul_sa_elcv[0]['SUM(julho_sa)'] . "</td>";

                                                                $sql_jul_sa_eld = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_eld = $wpdb->get_results($sql_jul_sa_eld, ARRAY_A);
                                                                echo "<td>" . $jul_sa_eld[0]['SUM(julho_sa)'] . "</td>";

                                                                $sql_jul_sa_elt = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_elt = $wpdb->get_results($sql_jul_sa_elt, ARRAY_A);
                                                                echo "<td>" . $jul_sa_elt[0]['SUM(julho_sa)'] . "</td>";

                                                                $sql_jul_sa_territoriosc = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jul_sa_territoriosc = $wpdb->get_results($sql_jul_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jul_sa_territoriosc[0]['SUM(julho_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>JUN - GERAL</strong></td>";

                                                                $sql_jun_marek = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_marek = $wpdb->get_results($sql_jun_marek, ARRAY_A);
                                                                echo "<td>" . $jun_marek[0]['SUM(junho)'] . "</td>";

                                                                $sql_jun_emia = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_emia = $wpdb->get_results($sql_jun_emia, ARRAY_A);
                                                                echo "<td>" . $jun_emia[0]['SUM(junho)'] . "</td>";

                                                                $sql_jun_elcv = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_elcv = $wpdb->get_results($sql_jun_elcv, ARRAY_A);
                                                                echo "<td>" . $jun_elcv[0]['SUM(junho)'] . "</td>";

                                                                $sql_jun_eld = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_eld = $wpdb->get_results($sql_jun_eld, ARRAY_A);
                                                                echo "<td>" . $jun_eld[0]['SUM(junho)'] . "</td>";

                                                                $sql_jun_elt = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_elt = $wpdb->get_results($sql_jun_elt, ARRAY_A);
                                                                echo "<td>" . $jun_elt[0]['SUM(junho)'] . "</td>";

                                                                $sql_jun_territoriosc = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_territoriosc = $wpdb->get_results($sql_jun_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jun_territoriosc[0]['SUM(junho)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>JUN - SA</strong></td>";

                                                                $sql_jun_sa_marek = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_marek = $wpdb->get_results($sql_jun_sa_marek, ARRAY_A);
                                                                echo "<td>" . $jun_sa_marek[0]['SUM(junho_sa)'] . "</td>";

                                                                $sql_jun_sa_emia = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_emia = $wpdb->get_results($sql_jun_sa_emia, ARRAY_A);
                                                                echo "<td>" . $jun_sa_emia[0]['SUM(junho_sa)'] . "</td>";

                                                                $sql_jun_sa_elcv = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_elcv = $wpdb->get_results($sql_jun_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $jun_sa_elcv[0]['SUM(junho_sa)'] . "</td>";

                                                                $sql_jun_sa_eld = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_eld = $wpdb->get_results($sql_jun_sa_eld, ARRAY_A);
                                                                echo "<td>" . $jun_sa_eld[0]['SUM(junho_sa)'] . "</td>";

                                                                $sql_jun_sa_elt = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_elt = $wpdb->get_results($sql_jun_sa_elt, ARRAY_A);
                                                                echo "<td>" . $jun_sa_elt[0]['SUM(junho_sa)'] . "</td>";

                                                                $sql_jun_sa_territoriosc = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jun_sa_territoriosc = $wpdb->get_results($sql_jun_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jun_sa_territoriosc[0]['SUM(junho_sa)'] . "</td>";
                                                                echo "</tr>";


                                                                echo "<tr>";
                                                                echo "<td><strong>MAI - GERAL</strong></td>";

                                                                $sql_mai_marek = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_marek = $wpdb->get_results($sql_mai_marek, ARRAY_A);
                                                                echo "<td>" . $mai_marek[0]['SUM(maio)'] . "</td>";

                                                                $sql_mai_emia = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_emia = $wpdb->get_results($sql_mai_emia, ARRAY_A);
                                                                echo "<td>" . $mai_emia[0]['SUM(maio)'] . "</td>";

                                                                $sql_mai_elcv = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_elcv = $wpdb->get_results($sql_mai_elcv, ARRAY_A);
                                                                echo "<td>" . $mai_elcv[0]['SUM(maio)'] . "</td>";

                                                                $sql_mai_eld = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_eld = $wpdb->get_results($sql_mai_eld, ARRAY_A);
                                                                echo "<td>" . $mai_eld[0]['SUM(maio)'] . "</td>";

                                                                $sql_mai_elt = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_elt = $wpdb->get_results($sql_mai_elt, ARRAY_A);
                                                                echo "<td>" . $mai_elt[0]['SUM(maio)'] . "</td>";

                                                                $sql_mai_territoriosc = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_territoriosc = $wpdb->get_results($sql_mai_territoriosc, ARRAY_A);
                                                                echo "<td>" . $mai_territoriosc[0]['SUM(maio)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>MAI - SA</strong></td>";

                                                                $sql_mai_sa_marek = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_marek = $wpdb->get_results($sql_mai_sa_marek, ARRAY_A);
                                                                echo "<td>" . $mai_sa_marek[0]['SUM(maio_sa)'] . "</td>";

                                                                $sql_mai_sa_emia = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_emia = $wpdb->get_results($sql_mai_sa_emia, ARRAY_A);
                                                                echo "<td>" . $mai_sa_emia[0]['SUM(maio_sa)'] . "</td>";

                                                                $sql_mai_sa_elcv = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_elcv = $wpdb->get_results($sql_mai_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $mai_sa_elcv[0]['SUM(maio_sa)'] . "</td>";

                                                                $sql_mai_sa_eld = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_eld = $wpdb->get_results($sql_mai_sa_eld, ARRAY_A);
                                                                echo "<td>" . $mai_sa_eld[0]['SUM(maio_sa)'] . "</td>";

                                                                $sql_mai_sa_elt = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_elt = $wpdb->get_results($sql_mai_sa_elt, ARRAY_A);
                                                                echo "<td>" . $mai_sa_elt[0]['SUM(maio_sa)'] . "</td>";

                                                                $sql_mai_sa_territoriosc = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mai_sa_territoriosc = $wpdb->get_results($sql_mai_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $mai_sa_territoriosc[0]['SUM(maio_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>ABR - GERAL</strong></td>";

                                                                $sql_abr_marek = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_marek = $wpdb->get_results($sql_abr_marek, ARRAY_A);
                                                                echo "<td>" . $abr_marek[0]['SUM(abril)'] . "</td>";

                                                                $sql_abr_emia = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_emia = $wpdb->get_results($sql_abr_emia, ARRAY_A);
                                                                echo "<td>" . $abr_emia[0]['SUM(abril)'] . "</td>";

                                                                $sql_abr_elcv = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_elcv = $wpdb->get_results($sql_abr_elcv, ARRAY_A);
                                                                echo "<td>" . $abr_elcv[0]['SUM(abril)'] . "</td>";

                                                                $sql_abr_eld = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_eld = $wpdb->get_results($sql_abr_eld, ARRAY_A);
                                                                echo "<td>" . $abr_eld[0]['SUM(abril)'] . "</td>";

                                                                $sql_abr_elt = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_elt = $wpdb->get_results($sql_abr_elt, ARRAY_A);
                                                                echo "<td>" . $abr_elt[0]['SUM(abril)'] . "</td>";

                                                                $sql_abr_territoriosc = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_territoriosc = $wpdb->get_results($sql_abr_territoriosc, ARRAY_A);
                                                                echo "<td>" . $abr_territoriosc[0]['SUM(abril)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>ABR - SA</strong></td>";

                                                                $sql_abr_sa_marek = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_marek = $wpdb->get_results($sql_abr_sa_marek, ARRAY_A);
                                                                echo "<td>" . $abr_sa_marek[0]['SUM(abril_sa)'] . "</td>";

                                                                $sql_abr_sa_emia = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_emia = $wpdb->get_results($sql_abr_sa_emia, ARRAY_A);
                                                                echo "<td>" . $abr_sa_emia[0]['SUM(abril_sa)'] . "</td>";

                                                                $sql_abr_sa_elcv = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_elcv = $wpdb->get_results($sql_abr_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $abr_sa_elcv[0]['SUM(abril_sa)'] . "</td>";

                                                                $sql_abr_sa_eld = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_eld = $wpdb->get_results($sql_abr_sa_eld, ARRAY_A);
                                                                echo "<td>" . $abr_sa_eld[0]['SUM(abril_sa)'] . "</td>";

                                                                $sql_abr_sa_elt = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_elt = $wpdb->get_results($sql_abr_sa_elt, ARRAY_A);
                                                                echo "<td>" . $abr_sa_elt[0]['SUM(abril_sa)'] . "</td>";

                                                                $sql_abr_sa_territoriosc = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $abr_sa_territoriosc = $wpdb->get_results($sql_abr_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $abr_sa_territoriosc[0]['SUM(abril_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>MAR - GERAL</strong></td>";

                                                                $sql_mar_marek = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_marek = $wpdb->get_results($sql_mar_marek, ARRAY_A);
                                                                echo "<td>" . $mar_marek[0]['SUM(marco)'] . "</td>";

                                                                $sql_mar_emia = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_emia = $wpdb->get_results($sql_mar_emia, ARRAY_A);
                                                                echo "<td>" . $mar_emia[0]['SUM(marco)'] . "</td>";

                                                                $sql_mar_elcv = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_elcv = $wpdb->get_results($sql_mar_elcv, ARRAY_A);
                                                                echo "<td>" . $mar_elcv[0]['SUM(marco)'] . "</td>";

                                                                $sql_mar_eld = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_eld = $wpdb->get_results($sql_mar_eld, ARRAY_A);
                                                                echo "<td>" . $mar_eld[0]['SUM(marco)'] . "</td>";

                                                                $sql_mar_elt = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_elt = $wpdb->get_results($sql_mar_elt, ARRAY_A);
                                                                echo "<td>" . $mar_elt[0]['SUM(marco)'] . "</td>";

                                                                $sql_mar_territoriosc = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_territoriosc = $wpdb->get_results($sql_mar_territoriosc, ARRAY_A);
                                                                echo "<td>" . $mar_territoriosc[0]['SUM(marco)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>MAR - SA</strong></td>";

                                                                $sql_mar_sa_marek = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_marek = $wpdb->get_results($sql_mar_sa_marek, ARRAY_A);
                                                                echo "<td>" . $mar_sa_marek[0]['SUM(marco_sa)'] . "</td>";

                                                                $sql_mar_sa_emia = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_emia = $wpdb->get_results($sql_mar_sa_emia, ARRAY_A);
                                                                echo "<td>" . $mar_sa_emia[0]['SUM(marco_sa)'] . "</td>";

                                                                $sql_mar_sa_elcv = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_elcv = $wpdb->get_results($sql_mar_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $mar_sa_elcv[0]['SUM(marco_sa)'] . "</td>";

                                                                $sql_mar_sa_eld = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_eld = $wpdb->get_results($sql_mar_sa_eld, ARRAY_A);
                                                                echo "<td>" . $mar_sa_eld[0]['SUM(marco_sa)'] . "</td>";

                                                                $sql_mar_sa_elt = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_elt = $wpdb->get_results($sql_mar_sa_elt, ARRAY_A);
                                                                echo "<td>" . $mar_sa_elt[0]['SUM(marco_sa)'] . "</td>";

                                                                $sql_mar_sa_territoriosc = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $mar_sa_territoriosc = $wpdb->get_results($sql_mar_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $mar_sa_territoriosc[0]['SUM(marco_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>FEV - Geral</strong></td>";

                                                                $sql_fev_marek = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_marek = $wpdb->get_results($sql_fev_marek, ARRAY_A);
                                                                echo "<td>" . $fev_marek[0]['SUM(fevereiro)'] . "</td>";

                                                                $sql_fev_emia = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_emia = $wpdb->get_results($sql_fev_emia, ARRAY_A);
                                                                echo "<td>" . $fev_emia[0]['SUM(fevereiro)'] . "</td>";

                                                                $sql_fev_elcv = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_elcv = $wpdb->get_results($sql_fev_elcv, ARRAY_A);
                                                                echo "<td>" . $fev_elcv[0]['SUM(fevereiro)'] . "</td>";

                                                                $sql_fev_eld = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_eld = $wpdb->get_results($sql_fev_eld, ARRAY_A);
                                                                echo "<td>" . $fev_eld[0]['SUM(fevereiro)'] . "</td>";

                                                                $sql_fev_elt = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_elt = $wpdb->get_results($sql_fev_elt, ARRAY_A);
                                                                echo "<td>" . $fev_elt[0]['SUM(fevereiro)'] . "</td>";

                                                                $sql_fev_territoriosc = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_territoriosc = $wpdb->get_results($sql_fev_territoriosc, ARRAY_A);
                                                                echo "<td>" . $fev_territoriosc[0]['SUM(fevereiro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>FEV - SA</strong></td>";

                                                                $sql_fev_sa_marek = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_marek = $wpdb->get_results($sql_fev_sa_marek, ARRAY_A);
                                                                echo "<td>" . $fev_sa_marek[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                $sql_fev_sa_emia = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_emia = $wpdb->get_results($sql_fev_sa_emia, ARRAY_A);
                                                                echo "<td>" . $fev_sa_emia[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                $sql_fev_sa_elcv = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_elcv = $wpdb->get_results($sql_fev_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $fev_sa_elcv[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                $sql_fev_sa_eld = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_eld = $wpdb->get_results($sql_fev_sa_eld, ARRAY_A);
                                                                echo "<td>" . $fev_sa_eld[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                $sql_fev_sa_elt = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_elt = $wpdb->get_results($sql_fev_sa_elt, ARRAY_A);
                                                                echo "<td>" . $fev_sa_elt[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                $sql_fev_sa_territoriosc = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $fev_sa_territoriosc = $wpdb->get_results($sql_fev_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $fev_sa_territoriosc[0]['SUM(fevereiro_sa)'] . "</td>";
                                                                echo "</tr>";


                                                                echo "<tr>";
                                                                echo "<td><strong>JAN - Geral</strong></td>";

                                                                $sql_jan_marek = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_marek = $wpdb->get_results($sql_jan_marek, ARRAY_A);
                                                                echo "<td>" . $jan_marek[0]['SUM(janeiro)'] . "</td>";

                                                                $sql_jan_emia = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_emia = $wpdb->get_results($sql_jan_emia, ARRAY_A);
                                                                echo "<td>" . $jan_emia[0]['SUM(janeiro)'] . "</td>";

                                                                $sql_jan_elcv = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_elcv = $wpdb->get_results($sql_jan_elcv, ARRAY_A);
                                                                echo "<td>" . $jan_elcv[0]['SUM(janeiro)'] . "</td>";

                                                                $sql_jan_eld = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_eld = $wpdb->get_results($sql_jan_eld, ARRAY_A);
                                                                echo "<td>" . $jan_eld[0]['SUM(janeiro)'] . "</td>";

                                                                $sql_jan_elt = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_elt = $wpdb->get_results($sql_jan_elt, ARRAY_A);
                                                                echo "<td>" . $jan_elt[0]['SUM(janeiro)'] . "</td>";

                                                                $sql_jan_territoriosc = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_territoriosc = $wpdb->get_results($sql_jan_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jan_territoriosc[0]['SUM(janeiro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>JAN - SA</strong></td>";

                                                                $sql_jan_sa_marek = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_marek = $wpdb->get_results($sql_jan_sa_marek, ARRAY_A);
                                                                echo "<td>" . $jan_sa_marek[0]['SUM(janeiro_sa)'] . "</td>";

                                                                $sql_jan_sa_emia = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_emia = $wpdb->get_results($sql_jan_sa_emia, ARRAY_A);
                                                                echo "<td>" . $jan_sa_emia[0]['SUM(janeiro_sa)'] . "</td>";

                                                                $sql_jan_sa_elcv = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_elcv = $wpdb->get_results($sql_jan_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $jan_sa_elcv[0]['SUM(janeiro_sa)'] . "</td>";

                                                                $sql_jan_sa_eld = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_eld = $wpdb->get_results($sql_jan_sa_eld, ARRAY_A);
                                                                echo "<td>" . $jan_sa_eld[0]['SUM(janeiro_sa)'] . "</td>";

                                                                $sql_jan_sa_elt = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_elt = $wpdb->get_results($sql_jan_sa_elt, ARRAY_A);
                                                                echo "<td>" . $jan_sa_elt[0]['SUM(janeiro_sa)'] . "</td>";

                                                                $sql_jan_sa_territoriosc = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $jan_sa_territoriosc = $wpdb->get_results($sql_jan_sa_territoriosc, ARRAY_A);
                                                                echo "<td>" . $jan_sa_territoriosc[0]['SUM(janeiro_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>TOTAL -Atendidos ao longo da ação</strong></td>";

                                                                $sql_total_marek = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_marek = $wpdb->get_results($sql_total_marek, ARRAY_A);
                                                                echo "<td>" . $total_marek[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";

                                                                $sql_total_emia = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_emia = $wpdb->get_results($sql_total_emia, ARRAY_A);
                                                                echo "<td>" . $total_emia[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";

                                                                $sql_total_elcv = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_elcv = $wpdb->get_results($sql_total_elcv, ARRAY_A);
                                                                echo "<td>" . $total_elcv[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";

                                                                $sql_total_eld = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_eld = $wpdb->get_results($sql_total_eld, ARRAY_A);
                                                                echo "<td>" . $total_eld[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";

                                                                $sql_total_elt = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_elt = $wpdb->get_results($sql_total_elt, ARRAY_A);
                                                                echo "<td>" . $total_elt[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";

                                                                $sql_total_elt = "SELECT SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                $total_elt = $wpdb->get_results($sql_total_elt, ARRAY_A);
                                                                echo "<td>" . $total_elt[0]['SUM(janeiro+fevereiro+marco+abril+maio+junho+julho+agosto+setembro+outubro+novembro+dezembro)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "<tr>";
                                                                echo "<td><strong>TOTAL - Atendidos que são moradores de Santo André</strong></td>";

                                                                $sql_sa_marek = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '271' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_marek = $wpdb->get_results($sql_sa_marek, ARRAY_A);
                                                                echo "<td>" . $sa_marek[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";

                                                                $sql_sa_emia = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '205' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_emia = $wpdb->get_results($sql_sa_emia, ARRAY_A);
                                                                echo "<td>" . $sa_emia[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";

                                                                $sql_sa_elcv = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '206' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_elcv = $wpdb->get_results($sql_sa_elcv, ARRAY_A);
                                                                echo "<td>" . $sa_elcv[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";

                                                                $sql_sa_eld = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '204' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_eld = $wpdb->get_results($sql_sa_eld, ARRAY_A);
                                                                echo "<td>" . $sa_eld[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";

                                                                $sql_sa_elt = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE equipamento = '283' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_elt = $wpdb->get_results($sql_sa_elt, ARRAY_A);
                                                                echo "<td>" . $sa_elt[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";

                                                                $sql_sa_elt = "SELECT SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND publicado = '1';";
                                                                $sa_elt = $wpdb->get_results($sql_sa_elt, ARRAY_A);
                                                                echo "<td>" . $sa_elt[0]['SUM(janeiro_sa+fevereiro_sa+marco_sa+abril_sa+maio_sa+junho_sa+julho_sa+agosto_sa+setembro_sa+outubro_sa+novembro_sa+dezembro_sa)'] . "</td>";
                                                                echo "</tr>";

                                                                echo "</tr>";

                                                                ?>

                                                                <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                        <br>
                                                                        <label><h2><?php echo $ano_base; ?> - Por Projeto (Qtde. de
                                                                                ações)</h2></label>
                                                                        <tr>
                                                                            <th>Período</th>
                                                                            <th>Projeto Territórios de Cultura</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php

                                                                        echo "<tr>";
                                                                        echo "<td><strong>DEZ</strong></td>";

                                                                        $sql_dez_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND dezembro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $dez_territorios = $wpdb->get_results($sql_dez_territorios, ARRAY_A);
                                                                        echo "<td>" . $dez_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>NOV</strong></td>";
                                                                        $sql_nov_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND novembro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $nov_territorios = $wpdb->get_results($sql_nov_territorios, ARRAY_A);
                                                                        echo "<td>" . $nov_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>OUT</strong></td>";
                                                                        $sql_out_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND outubro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $out_territorios = $wpdb->get_results($sql_out_territorios, ARRAY_A);
                                                                        echo "<td>" . $out_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>SET</strong></td>";
                                                                        $sql_set_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND setembro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $set_territorios = $wpdb->get_results($sql_set_territorios, ARRAY_A);
                                                                        echo "<td>" . $set_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>AGO</strong></td>";
                                                                        $sql_ago_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND agosto != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $ago_territorios = $wpdb->get_results($sql_ago_territorios, ARRAY_A);
                                                                        echo "<td>" . $ago_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>JUL</strong></td>";
                                                                        $sql_jul_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND julho != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $jul_territorios = $wpdb->get_results($sql_jul_territorios, ARRAY_A);
                                                                        echo "<td>" . $jul_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>JUN</strong></td>";
                                                                        $sql_jun_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND junho != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $jun_territorios = $wpdb->get_results($sql_jun_territorios, ARRAY_A);
                                                                        echo "<td>" . $jun_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>MAI</strong></td>";
                                                                        $sql_mai_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND maio != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $mai_territorios = $wpdb->get_results($sql_mai_territorios, ARRAY_A);
                                                                        echo "<td>" . $mai_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>ABR</strong></td>";
                                                                        $sql_abr_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND abril != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $abr_territorios = $wpdb->get_results($sql_abr_territorios, ARRAY_A);
                                                                        echo "<td>" . $abr_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>MAR</strong></td>";
                                                                        $sql_mar_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND marco != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $mar_territorios = $wpdb->get_results($sql_mar_territorios, ARRAY_A);
                                                                        echo "<td>" . $mar_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>FEV</strong></td>";
                                                                        $sql_fev_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND fevereiro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $fev_territorios = $wpdb->get_results($sql_fev_territorios, ARRAY_A);
                                                                        echo "<td>" . $fev_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";

                                                                        echo "<tr>";
                                                                        echo "<td><strong>JAN</strong></td>";
                                                                        $sql_jan_territorios = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE projeto = '792' AND ocor_inicio LIKE '%$ano_base%' AND janeiro != '0' AND publicado = '1' AND projeto NOT IN (378,723)";
                                                                        $jan_territorios = $wpdb->get_results($sql_jan_territorios, ARRAY_A);
                                                                        echo "<td>" . $jan_territorios[0]['COUNT(id)'] . "</td>";
                                                                        echo "</tr>";
                                                                        echo "</tr>";

                                                                        echo "</tr>";

                                                                        ?>
																		
	<hr>
	
<?php 	} // final loop ano ?>



                                                                                                <?php
                                                                                                break;*/
																								
                                                case "tabelaincentivo_novo":

                                                ?>

                                                    <div class="form-group">
                                                        <div class="col-md-offset-2">
                                                            <h1>Resumo das Ações de Incentivo</h1>

                                                        </div>
                                                    </div>
                                                <br/><br/>
<?php
set_time_limit(0);
$ano = anoOrcamento(true);

for($i = 0; $i < count($ano); $i++){
	$ano_base = $ano[$i]['ano_base'];
	
	$ind = indicadores($ano_base,"incentivo","378,723",TRUE);




	?>
	


                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <label><h2><?php echo $ano_base; ?></h2></label>
                                                        <tr>
                                                            <th>Período</th>
                                                            <th>Público Geral</th>
                                                            <th>Público Santo André</th>
                                                            <th>Nº Atividades</th>
                                                            <th>Nº Atividades com Agentes Locais</th>
                                                            <th>Nº Agentes Culturais Locais Envolvidos</th>
                                                            <th>Nº Bairros</th>
                                                            <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                                                            <th>Nº Bairros Descentralizados</th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
	<?php 
	for($m = 1; $m < 13; $m++){ // rodar os meses
	?>
			<tr>

			<td><?php echo campoMes($m); ?></td>
			<td><?php echo nuloZero($ind[$m]['total']['all']); ?></td>
			<td><?php echo nuloZero($ind[$m]['sa']['all']); ?></td>
			<td><?php echo nuloZero($ind[$m]['atividades']); ?></td>
			<td><?php echo nuloZero($ind[$m]['atividades_agentes_locais']); ?></td>
			<td><?php echo nuloZero($ind[$m]['agentes_locais']); ?></td>
			<td><?php echo nuloZero($ind[$m]['bairros']['n_bairros']); ?></td>
			<td><?php echo round(($ind[$m]['bairros']['n_bairros']/112)*100,2); ?></td>
			<td><?php echo nuloZero($ind[$m]['bairros']['n_bairros_descentralizados']); ?></td>
			<td></td>
			<td></td>

			</tr>	
	<?php 	
	} // fim do for do mês
	
	?>
<tr>

<td>Total</td>
			<td><?php echo $ind['total']['all']; ?></td>
			<td><?php echo $ind['sa']['all']; ?></td>
			<td><?php echo $ind['atividades']; ?></td>
			<td><?php echo $ind['atividades_agentes_locais']; ?></td>
			<td><?php echo $ind['agentes_locais']; ?></td>
			<td><?php echo $ind['bairros']['n_bairros']; ?></td>
			<td><?php echo round(($ind['bairros']['n_bairros']/112)*100,2); ?></td>
			<td><?php echo $ind['bairros']['n_bairros_descentralizados']; ?></td>
			<td></td>
			<td></td>

</tr>

</tbody>
</table>
<hr />
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <br>
                                                                <label><h2><?php echo $ano_base; ?> - Por Espaço</h2></label>
                                                                <tr>
                                                                    <th  width="10%">Período</th>
                                                                    <th>EMIA - Escola Municipal de Iniciação Artística
                                                                        Jaçatuba
                                                                    </th>
                                                                    <th>ELCV - Escola livre de Cinema e Vídeo</th>
                                                                    <th>ELD - Escola Livre de Dança</th>
                                                                    <th>ELT - Escola Livre de Teatro</th>
                                                                    <th>Territórios</th>
                                                                    
                                                                    <th width="10%"></th>
                                                                    <th width="10%"></th>
                                                                </tr>
																
								<?php 
								
								$t_205 = 0;
								$t_206 = 0;
								$t_204 = 0;
								$t_283 = 0;
								$sa_711 = 0;
								$sa_271 = 0;
								$sa_205 = 0;
								$sa_206 = 0;
								$sa_204 = 0;
								$sa_283 = 0;
                                //territorios
                                $ter = 0;
								
								for($m = 1; $m < 13; $m++){ // rodar os meses
								
								
								
								
								
	?>
			<tr>

			<td><?php echo campoMes($m)." - Geral"; ?></td>
			<td><?php echo nuloZero($ind[$m]["total"][205]["valor"]); $t_205 += $ind[$m]["total"][205]["valor"];// EMIA 205 ?></td>
			<td><?php echo nuloZero($ind[$m]["total"][206]["valor"]); $t_206 += $ind[$m]["total"][206]["valor"]; // ELCV 206 ?></td>
			<td><?php echo nuloZero($ind[$m]["total"][204]["valor"]); $t_204 += $ind[$m]["total"][204]["valor"];// ELD 204 ?></td>
			<td><?php echo nuloZero($ind[$m]["total"][283]["valor"]); $t_283 += $ind[$m]["total"][283]["valor"];//ELT 283 ?></td>
            <td><?php echo nuloZero($ind[$m]["total"][735][335][336][338][819][852][792][80]["valor"]); $ter += $ind[$m]["total"][735][335][336][338][819][852][792][80]["valor"];//territorios 735- 335-336-338-819-852-797-792-80 ?></td>

			<td></td>
			<td></td>

			</tr>	

			<tr>

			<td><?php echo campoMes($m)." - SA"; ?></td>
			<td><?php echo nuloZero($ind[$m]["sa"][205]["valor"]); $sa_205 += $ind[$m]["sa"][205]["valor"];// EMIA 205 ?></td>
			<td><?php echo nuloZero($ind[$m]["sa"][206]["valor"]); $sa_206 += $ind[$m]["sa"][206]["valor"]; // ELCV 206 ?></td>
			<td><?php echo nuloZero($ind[$m]["sa"][204]["valor"]); $sa_204 += $ind[$m]["sa"][204]["valor"];// ELD 204 ?></td>
			<td><?php echo nuloZero($ind[$m]["sa"][283]["valor"]); $sa_283 += $ind[$m]["sa"][283]["valor"];//ELT 283 ?></td>

			<td></td>
			<td></td>

			</tr>			
	<?php 	
	} // fim do for do mês
								
								
								?>								
			<td>TOTAL -Atendimentos ao longo da ação</td>
		
			<td><?php echo $t_205; // EMIA 205 ?></td>
			<td><?php echo $t_206; // ELCV 206 ?></td>
			<td><?php echo $t_204; // ELD 204 ?></td>
			<td><?php echo $t_283; //ELT 283 ?></td>
            <td><?php echo $ter; //territorios ?></td>

			<td></td>
			<td></td>

			</tr>	
			<td>TOTAL - Atendimentos que são moradores de Santo André</td>
		
			<td><?php echo $sa_205; // EMIA 205 ?></td>
			<td><?php echo $sa_206; // ELCV 206 ?></td>
			<td><?php echo $sa_204; // ELD 204 ?></td>
			<td><?php echo $sa_283; //ELT 283 ?></td>

			<td></td>
			<td></td>

			</tr>				
																
                                                                </thead>
                                                                </tbody>

			
									</table>

<?php 

$t = tipo(tipoId("Indicadores por projeto"));
//var_dump(tipoId("Indicadores por projeto"));
$tipo = json_decode($t['descricao'],TRUE);





?>

											<table class="table table-striped">
                                                                        <thead>
                                                                        <br>
                                                                        <label><h2><?php echo $ano_base; ?> - Por Projeto (Qtde. de
                                                                                ações)</h2></label>
                                                                        <tr>
                                                                            <th>Período</th>
                                                                  <?php    foreach($tipo as $key => $value){
															echo "<th>".$key."<th />";
															
																  } ?>
                                                                      <th>Territorios</th>
                                                                      <th width="10%"></th>
                                                                    <th width="10%"></th>
																			
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody>
<?php 
for($m = 1; $m < 13; $m++){

?>
<tr>
<td><?php echo campoMes($m)?> </td>
	<?php foreach ($tipo as $key => $value){
		$indicador[$key] = indicadores($ano_base,"incentivo",$value);
		echo "<td>".nuloZero($indicador[$key][$m]['total']['all'])."<td>";
		?>
	<?php } // fim do foreach?>


<td>  <?php $t = tipo(tipoId("indicadores por projeto"));
	    	$tipo = json_decode($t['descricao'],TRUE);
			$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			echo count($conta_bairro); ?>  </td>
</tr>					
<?php } ?>
<tr>
<td>Total  </td>
	<?php foreach ($tipo as $key => $value){
		echo "<td>".nuloZero($indicador[$key]['total']['all'])."<td>";
		?>
	<?php } // fim do foreach?>
<td></td>
<td></td>
</tr>	
                                        </tbody>
									</table>
<?php 	
	//echo "<pre>";
	//var_dump($indicador);
	//echo "</pre>";
	
	?>
<?php } // fim do for do ano ?>

<?php 
break;

case "tabelaatendimento":


set_time_limit(0);
$ano = anoOrcamento(true);

for($i = 0; $i < count($ano); $i++){
	$ano_base = $ano[$i]['ano_base'];

$ind_evento = indicadores($ano_base,"evento");
$ind_biblioteca = indicadores($ano_base,"biblioteca");
$ind_incentivo = indicadores($ano_base,"incentivo");
?>

                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <label><h2><?php echo $ano_base; ?></h2></label>
                                                        <tr>
                                                            <th>Período</th>
                                                            <th>Público Geral</th>
                                                            
                                                            <th>Nº Atividades</th>
                                                            <th>Nº Atividades com Agentes Locais</th>
                                                            <th>Nº Agentes Culturais Locais Envolvidos</th>
                                                            <th>Nº Bairros</th>
                                                            <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                                                            <th>Nº Bairros Descentralizados</th>
                                                            <th>Nome dos Bairros </th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
<?php 
for($m = 1; $m < 13; $m++){
	?>
	<tr>
 <th><?php echo $m; ?></th>
                                                            <th><?php echo ($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']);   ?></th>
                                                            
                                                            <th><?php echo ($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']);   ?></th>
                                                            <th><?php echo ($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']);   ?></th>
                                                            <th><?php echo ($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']);   ?></th>
                                                            <th>
															<?php 
															$conta_bairro = array();
															$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
															$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairro'],$conta_bairro);
															
															$t = tipo(tipoId("Bibliotecas"));
															$tipo = json_decode($t['descricao'],TRUE);
															$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
															echo count($conta_bairro);
                                                            /* $string_bairro = "";
                                                                foreach($conta_bairro as $id_bairro){
                                                                   $x = tipo($id_bairro);     
                                                                   $bairro = $x['tipo']; 
                                                                   $string_bairro = $string_bairro.",".$bairro;
                                                                }                                                                    
                                                                echo $string_bairro;
                                                            */

															?>
															
															</th>
                                                            <th><?php echo  round((count($conta_bairro)/112)*100,2) ?></th>
                                                            <th><?php echo count($conta_bairro) - 1;?></th>
                                                            <th><?php $string_bairro = "";
                                                                foreach($conta_bairro as $id_bairro){
                                                                   $x = tipo($id_bairro);     
                                                                   $bairro = $x['tipo']; 
                                                                   $string_bairro = $string_bairro.",".$bairro;
                                                                }                                                                    
                                                                echo $string_bairro?></th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>	
															</tr>
	<?php 
} // for mês
/*
<td>Total</td>
<th><?php echo ($ind_evento['all']['publico'] + $ind_biblioteca['all']['Público - Biblioteca Central'] + $ind_biblioteca['all']['Público - Biblioteca Descentralizada'] + $ind_incentivo['total']['all']);   ?></th>
                                                            
<th><?php echo ($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo['atividades']);   ?></th>
<th><?php echo ($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo['atividades_agentes_locais']);   ?></th>
<th><?php echo ($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo['agentes_locais']);   ?></th>
<th>
<?php 
$conta_bairro = array();
$conta_bairro = contaBairros($ind_evento['all']['id_bairros'],$conta_bairro);
$conta_bairro = contaBairros($ind_incentivo['bairros']['id_bairro'],$conta_bairro);

$t = tipo(tipoId("Bibliotecas"));
$tipo = json_decode($t['descricao'],TRUE);
$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
echo count($conta_bairro);
/* $string_bairro = "";
    foreach($conta_bairro as $id_bairro){
       $x = tipo($id_bairro);     
       $bairro = $x['tipo']; 
       $string_bairro = $string_bairro.",".$bairro;
    }                                                                    
    echo $string_bairro;


?>

</th>
<th><?php echo  round((count($conta_bairro)/112)*100,2) ?></th>
<th><?php echo count($conta_bairro) - 1;?></th>
<th><?php $string_bairro = "";
    foreach($conta_bairro as $id_bairro){
       $x = tipo($id_bairro);     
       $bairro = $x['tipo']; 
       $string_bairro = $string_bairro.",".$bairro;
    }                                                                    
    echo $string_bairro?></th>

</tr>*/

?>


														</tbody>
												</table>

<?php } // for ano_base ?>


<h1>Tabela Atendimento Geral</h1>

<h2>Evento</h2>
<?php 

echo "<pre>";
var_dump(indicadores(2019,"evento"));
echo "</pre>";
?>

<h2>Biblioteca</h2>
<?php 
echo "<pre>";
var_dump(indicadores(2019,"biblioteca"));
echo "</pre>";
?>

<h2>Incentivo</h2>
<?php 
echo "<pre>";
var_dump(indicadores(2019,"incentivo"));
echo "</pre>";

?>



                                                                                                <?php
                                                                                                break;
																								
																								
                                                                                                case "tabelaincentivolazer":

                                                                                                ?>

                                                                                                <form method="POST"
                                                                                                      action="?p=tabelaincentivolazer"
                                                                                                      class="form-horizontal"
                                                                                                      role="form">
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2">
                                                                                                            <h1>Resumo
                                                                                                                das
                                                                                                                Ações de
                                                                                                                Incentivo
                                                                                                                -
                                                                                                                LAZER</h1>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                                <br/><br/>

                                                                                                <div class="table-responsive">
                                                                                                    <table class="table table-striped">
                                                                                                        <thead>
                                                                                                        <label><h2>
                                                                                                                2019</h2>
                                                                                                        </label>
                                                                                                        <tr>
                                                                                                            <th>
                                                                                                                Período
                                                                                                            </th>
                                                                                                            <th>Público
                                                                                                                Geral
                                                                                                            </th>
                                                                                                            <th>Público
                                                                                                                Santo
                                                                                                                André
                                                                                                            </th>
                                                                                                            <th>Nº
                                                                                                                Atividades
                                                                                                            </th>
                                                                                                            <th>Nº
                                                                                                                Atividades
                                                                                                                com
                                                                                                                Agentes
                                                                                                                Locais
                                                                                                            </th>
                                                                                                            <th>Nº
                                                                                                                Agentes
                                                                                                                Culturais
                                                                                                                Locais
                                                                                                                Envolvidos
                                                                                                            </th>
                                                                                                            <th>Nº
                                                                                                                Bairros
                                                                                                            </th>
                                                                                                            <th>%
                                                                                                                Bairros
                                                                                                                da
                                                                                                                Cidade
                                                                                                                Atendidos
                                                                                                                (Ref.
                                                                                                                112
                                                                                                                bairros)
                                                                                                            </th>
                                                                                                            <th>Nº
                                                                                                                Bairros
                                                                                                                Descentralizados
                                                                                                            </th>
                                                                                                            <th width="10%"></th>
                                                                                                            <th width="10%"></th>
                                                                                                        </tr>
                                                                                                        </thead>
                                                                                                        <tbody>

                                                                                                        <?php

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>DEZ</strong></td>";

                                                                                                        $sql_pub_dezembro = "SELECT SUM(dezembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_dezembro = $wpdb->get_results($sql_pub_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_dezembro[0]['SUM(dezembro)'] . "</td>";

                                                                                                        $sql_pub_sa_dezembro = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_dezembro = $wpdb->get_results($sql_pub_sa_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_dezembro[0]['SUM(dezembro_sa)'] . "</td>";

                                                                                                        $sql_ativ_dezembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND dezembro > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_dezembro = $wpdb->get_results($sql_ativ_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_dezembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_dezembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND dezembro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_dezembro = $wpdb->get_results($sql_age_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $age_dezembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_dezembro = "SELECT SUM(dezembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_dezembro = $wpdb->get_results($sql_num_age_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_dezembro[0]['SUM(dezembro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND dezembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_dezembro = $wpdb->get_results($sql_num_bairros_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_dezembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/105,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND dezembro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_dezembro = $wpdb->get_results($sql_per_bairros_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_dezembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_dezembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND dezembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_dezembro = $wpdb->get_results($sql_num_desc_dezembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_dezembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>NOV</strong></td>";

                                                                                                        $sql_pub_novembro = "SELECT SUM(novembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_novembro = $wpdb->get_results($sql_pub_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_novembro[0]['SUM(novembro)'] . "</td>";

                                                                                                        $sql_pub_sa_novembro = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_novembro = $wpdb->get_results($sql_pub_sa_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_novembro[0]['SUM(novembro_sa)'] . "</td>";

                                                                                                        $sql_ativ_novembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND novembro > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_novembro = $wpdb->get_results($sql_ativ_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_novembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_novembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND novembro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_novembro = $wpdb->get_results($sql_age_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $age_novembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_novembro = "SELECT SUM(novembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_novembro = $wpdb->get_results($sql_num_age_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_novembro[0]['SUM(novembro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND novembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_novembro = $wpdb->get_results($sql_num_bairros_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_novembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND novembro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_novembro = $wpdb->get_results($sql_per_bairros_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_novembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_novembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND novembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_novembro = $wpdb->get_results($sql_num_desc_novembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_novembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>OUT</strong></td>";

                                                                                                        $sql_pub_outubro = "SELECT SUM(outubro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_outubro = $wpdb->get_results($sql_pub_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_outubro[0]['SUM(outubro)'] . "</td>";

                                                                                                        $sql_pub_sa_outubro = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_outubro = $wpdb->get_results($sql_pub_sa_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_outubro[0]['SUM(outubro_sa)'] . "</td>";

                                                                                                        $sql_ativ_outubro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND outubro > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_outubro = $wpdb->get_results($sql_ativ_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_outubro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_outubro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND outubro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_outubro = $wpdb->get_results($sql_age_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $age_outubro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_outubro = "SELECT SUM(outubro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_outubro = $wpdb->get_results($sql_num_age_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_outubro[0]['SUM(outubro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND outubro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_outubro = $wpdb->get_results($sql_num_bairros_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_outubro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND outubro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_outubro = $wpdb->get_results($sql_per_bairros_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_outubro[0]['ROUND(COUNT(DISTINCT(bairro))*100/105,2)'] . "</td>";

                                                                                                        $sql_num_desc_outubro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND outubro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_outubro = $wpdb->get_results($sql_num_desc_outubro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_outubro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>SET</strong></td>";

                                                                                                        $sql_pub_setembro = "SELECT SUM(setembro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_setembro = $wpdb->get_results($sql_pub_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_setembro[0]['SUM(setembro)'] . "</td>";

                                                                                                        $sql_pub_sa_setembro = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_setembro = $wpdb->get_results($sql_pub_sa_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_setembro[0]['SUM(setembro_sa)'] . "</td>";

                                                                                                        $sql_ativ_setembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND setembro > '0' AND publicado = '1 AND projeto IN (723,378)'";
                                                                                                        $ativ_setembro = $wpdb->get_results($sql_ativ_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_setembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_setembro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND setembro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_setembro = $wpdb->get_results($sql_age_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $age_setembro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_setembro = "SELECT SUM(setembro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_setembro = $wpdb->get_results($sql_num_age_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_setembro[0]['SUM(setembro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND setembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_setembro = $wpdb->get_results($sql_num_bairros_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_setembro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND setembro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_setembro = $wpdb->get_results($sql_per_bairros_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_setembro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_setembro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND setembro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_setembro = $wpdb->get_results($sql_num_desc_setembro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_setembro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>AGO</strong></td>";

                                                                                                        $sql_pub_agosto = "SELECT SUM(agosto) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_agosto = $wpdb->get_results($sql_pub_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $pub_agosto[0]['SUM(agosto)'] . "</td>";

                                                                                                        $sql_pub_sa_agosto = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_agosto = $wpdb->get_results($sql_pub_sa_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_agosto[0]['SUM(agosto_sa)'] . "</td>";

                                                                                                        $sql_ativ_agosto = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND agosto > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_agosto = $wpdb->get_results($sql_ativ_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_agosto[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_agosto = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND agosto_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_agosto = $wpdb->get_results($sql_age_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $age_agosto[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_agosto = "SELECT SUM(agosto_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_agosto = $wpdb->get_results($sql_num_age_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_agosto[0]['SUM(agosto_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND agosto > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_agosto = $wpdb->get_results($sql_num_bairros_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_agosto = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND agosto > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_agosto = $wpdb->get_results($sql_per_bairros_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_agosto[0]['ROUND(COUNT(DISTINCT(bairro))*100/105,2)'] . "</td>";

                                                                                                        $sql_num_desc_agosto = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND agosto > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_agosto = $wpdb->get_results($sql_num_desc_agosto, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_agosto[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>JUL</strong></td>";

                                                                                                        $sql_pub_julho = "SELECT SUM(julho) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_julho = $wpdb->get_results($sql_pub_julho, ARRAY_A);
                                                                                                        echo "<td>" . $pub_julho[0]['SUM(julho)'] . "</td>";

                                                                                                        $sql_pub_sa_julho = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_julho = $wpdb->get_results($sql_pub_sa_julho, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_julho[0]['SUM(julho_sa)'] . "</td>";

                                                                                                        $sql_ativ_julho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND julho > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_julho = $wpdb->get_results($sql_ativ_julho, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_julho[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_julho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND julho_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_julho = $wpdb->get_results($sql_age_julho, ARRAY_A);
                                                                                                        echo "<td>" . $age_julho[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_julho = "SELECT SUM(julho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_julho = $wpdb->get_results($sql_num_age_julho, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_julho[0]['SUM(julho_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND julho > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_julho = $wpdb->get_results($sql_num_bairros_julho, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_julho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND julho > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_julho = $wpdb->get_results($sql_per_bairros_julho, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_julho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_julho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND julho > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_julho = $wpdb->get_results($sql_num_desc_julho, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_julho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>JUN</strong></td>";

                                                                                                        $sql_pub_junho = "SELECT SUM(junho) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_junho = $wpdb->get_results($sql_pub_junho, ARRAY_A);
                                                                                                        echo "<td>" . $pub_junho[0]['SUM(junho)'] . "</td>";

                                                                                                        $sql_pub_sa_junho = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_junho = $wpdb->get_results($sql_pub_sa_junho, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_junho[0]['SUM(junho_sa)'] . "</td>";

                                                                                                        $sql_ativ_junho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND junho > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_junho = $wpdb->get_results($sql_ativ_junho, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_junho[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_junho = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND junho_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_junho = $wpdb->get_results($sql_age_junho, ARRAY_A);
                                                                                                        echo "<td>" . $age_junho[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_junho = "SELECT SUM(junho_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_junho = $wpdb->get_results($sql_num_age_junho, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_junho[0]['SUM(junho_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND junho > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_junho = $wpdb->get_results($sql_num_bairros_junho, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_junho = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND junho > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_junho = $wpdb->get_results($sql_per_bairros_junho, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_junho[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_junho = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND junho > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_junho = $wpdb->get_results($sql_num_desc_junho, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_junho[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>MAI</strong></td>";

                                                                                                        $sql_pub_maio = "SELECT SUM(maio) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_maio = $wpdb->get_results($sql_pub_maio, ARRAY_A);
                                                                                                        echo "<td>" . $pub_maio[0]['SUM(maio)'] . "</td>";

                                                                                                        $sql_pub_sa_maio = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_maio = $wpdb->get_results($sql_pub_sa_maio, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_maio[0]['SUM(maio_sa)'] . "</td>";

                                                                                                        $sql_ativ_maio = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND maio > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_maio = $wpdb->get_results($sql_ativ_maio, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_maio[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_maio = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND maio_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_maio = $wpdb->get_results($sql_age_maio, ARRAY_A);
                                                                                                        echo "<td>" . $age_maio[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_maio = "SELECT SUM(maio_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_maio = $wpdb->get_results($sql_num_age_maio, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_maio[0]['SUM(maio_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND maio > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_maio = $wpdb->get_results($sql_num_bairros_maio, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_maio = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND maio > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_maio = $wpdb->get_results($sql_per_bairros_maio, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_maio[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_maio = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND maio > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_maio = $wpdb->get_results($sql_num_desc_maio, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_maio[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>ABR</strong></td>";

                                                                                                        $sql_pub_abril = "SELECT SUM(abril) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_abril = $wpdb->get_results($sql_pub_abril, ARRAY_A);
                                                                                                        echo "<td>" . $pub_abril[0]['SUM(abril)'] . "</td>";

                                                                                                        $sql_pub_sa_abril = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_abril = $wpdb->get_results($sql_pub_sa_abril, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_abril[0]['SUM(abril_sa)'] . "</td>";

                                                                                                        $sql_ativ_abril = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND abril > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_abril = $wpdb->get_results($sql_ativ_abril, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_abril[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_abril = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND abril_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_abril = $wpdb->get_results($sql_age_abril, ARRAY_A);
                                                                                                        echo "<td>" . $age_abril[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_abril = "SELECT SUM(abril_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_abril = $wpdb->get_results($sql_num_age_abril, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_abril[0]['SUM(abril_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND abril > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_abril = $wpdb->get_results($sql_num_bairros_abril, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_abril = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND abril > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_abril = $wpdb->get_results($sql_per_bairros_abril, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_abril[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_abril = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND abril > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_abril = $wpdb->get_results($sql_num_desc_abril, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_abril[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>MAR</strong></td>";

                                                                                                        $sql_pub_marco = "SELECT SUM(marco) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_marco = $wpdb->get_results($sql_pub_marco, ARRAY_A);
                                                                                                        echo "<td>" . $pub_marco[0]['SUM(marco)'] . "</td>";

                                                                                                        $sql_pub_sa_marco = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_marco = $wpdb->get_results($sql_pub_sa_marco, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_marco[0]['SUM(marco_sa)'] . "</td>";

                                                                                                        $sql_ativ_marco = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND marco > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_marco = $wpdb->get_results($sql_ativ_marco, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_marco[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_marco = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND marco_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_marco = $wpdb->get_results($sql_age_marco, ARRAY_A);
                                                                                                        echo "<td>" . $age_marco[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_marco = "SELECT SUM(marco_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_marco = $wpdb->get_results($sql_num_age_marco, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_marco[0]['SUM(marco_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND marco > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_marco = $wpdb->get_results($sql_num_bairros_marco, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_marco = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND marco > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_marco = $wpdb->get_results($sql_per_bairros_marco, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_marco[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_marco = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND marco > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_marco = $wpdb->get_results($sql_num_desc_marco, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_marco[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>FEV</strong></td>";

                                                                                                        $sql_pub_fevereiro = "SELECT SUM(fevereiro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_fevereiro = $wpdb->get_results($sql_pub_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_fevereiro[0]['SUM(fevereiro)'] . "</td>";

                                                                                                        $sql_pub_sa_fevereiro = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_fevereiro = $wpdb->get_results($sql_pub_sa_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_fevereiro[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                                                        $sql_ativ_fevereiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND fevereiro > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_fevereiro = $wpdb->get_results($sql_ativ_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_fevereiro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_fevereiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND fevereiro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_fevereiro = $wpdb->get_results($sql_age_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $age_fevereiro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_fevereiro = "SELECT SUM(fevereiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_fevereiro = $wpdb->get_results($sql_num_age_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_fevereiro[0]['SUM(fevereiro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND fevereiro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_fevereiro = $wpdb->get_results($sql_num_bairros_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_fevereiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND fevereiro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_fevereiro = $wpdb->get_results($sql_per_bairros_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_fevereiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_fevereiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND fevereiro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_fevereiro = $wpdb->get_results($sql_num_desc_fevereiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_fevereiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";

                                                                                                        echo "<tr>";
                                                                                                        echo "<td><strong>JAN</strong></td>";

                                                                                                        $sql_pub_janeiro = "SELECT SUM(janeiro) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_janeiro = $wpdb->get_results($sql_pub_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_janeiro[0]['SUM(janeiro)'] . "</td>";

                                                                                                        $sql_pub_sa_janeiro = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $pub_sa_janeiro = $wpdb->get_results($sql_pub_sa_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $pub_sa_janeiro[0]['SUM(janeiro_sa)'] . "</td>";

                                                                                                        $sql_ativ_janeiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND janeiro > '0' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $ativ_janeiro = $wpdb->get_results($sql_ativ_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $ativ_janeiro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_age_janeiro = "SELECT COUNT(id) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND janeiro_sa > '0' AND projeto IN (723,378)";
                                                                                                        $age_janeiro = $wpdb->get_results($sql_age_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $age_janeiro[0]['COUNT(id)'] . "</td>";

                                                                                                        $sql_num_age_janeiro = "SELECT SUM(janeiro_sa) FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND projeto IN (723,378)";
                                                                                                        $num_age_janeiro = $wpdb->get_results($sql_num_age_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_age_janeiro[0]['SUM(janeiro_sa)'] . "</td>";

                                                                                                        $sql_num_bairros_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND janeiro > '0' AND projeto IN (723,378)";
                                                                                                        $num_bairros_janeiro = $wpdb->get_results($sql_num_bairros_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_bairros_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";

                                                                                                        $sql_per_bairros_janeiro = "SELECT ROUND(COUNT(DISTINCT(bairro))*100/112,2) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND publicado = '1' AND janeiro > '0' AND projeto IN (723,378)";
                                                                                                        $per_bairros_janeiro = $wpdb->get_results($sql_per_bairros_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $per_bairros_janeiro[0]['ROUND(COUNT(DISTINCT(bairro))*100/112,2)'] . "</td>";

                                                                                                        $sql_num_desc_janeiro = "SELECT COUNT(DISTINCT(bairro)) FROM sc_ind_incentivo WHERE  ocor_inicio BETWEEN '2019-01-01' AND '2019-12-31' AND bairro NOT IN (574,583,648,660,578,651,576,587,652,649) AND publicado = '1' AND janeiro > '0' AND projeto IN (723,378)";
                                                                                                        $num_desc_janeiro = $wpdb->get_results($sql_num_desc_janeiro, ARRAY_A);
                                                                                                        echo "<td>" . $num_desc_janeiro[0]['COUNT(DISTINCT(bairro))'] . "</td>";
                                                                                                        echo "</tr>";
                                                                                                        echo "</tr>";

                                                                                                        ?>


                                                                                                        </tbody>


                                                                                                        <?php
                                                                                                        break;
                                                                                                        case "listarevento":


                                                                                                        if (isset($_POST['apagar'])) {
                                                                                                            $sql_update = "UPDATE sc_indicadores SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                                                                            $apagar = $wpdb->query($sql_update);
                                                                                                            if ($apagar == 1) {
                                                                                                                $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                                                                            }
                                                                                                        }

						
                                                                                                        if (isset($_POST['inserir'])) {


                                                                                                            $idEvento = $_POST['idEvento'];
                                                                                                            //'0000-00-00'
                                                                                                            $periodoInicio = exibirDataMysql($_POST['mes_ano']);
																											if($_POST['tipo_relatorio'] == 'longaduracao'){
																												$ano = substr($periodoInicio,0, 4);
																												$mes = substr($periodoInicio,5, 2);
																												$periodoFim = $ano."-".$mes."-".ultimoDiaMes($mes,$ano);
																												$contagem = $_POST['contagem'];
																											}else{

																												$periodoFim = '0000-00-00';
																												$contagem = 1;
                                                                                                            }
                                                                                                            $ndias = $_POST['ndias'];
                                                                                                            
                                                                                                            $valor = $_POST['valor'];
                                                                                                            $relato = $_POST['relato'];
                                                                                                            $idOcorrencia = $_POST['idOcorrencia'];
                                                                                                            $idUsuario = $user->ID;

                                                                                                            $sql_inserir = "INSERT INTO `sc_indicadores` (`id`, `idEvento`,`idOcorrencia`, `valor`, `contagem`, `tipo`, `periodoInicio`, `periodoFim`, `ndias`, `idUsuario`, `relato`, `publicado`) VALUES (NULL, '$idEvento', '$idOcorrencia', '$valor','$contagem', '$tipo','$periodoInicio', '$periodoFim', '$ndias', '$idUsuario', '$relato', '1')";
                                                                                                            $ex = $wpdb->query($sql_inserir);
                                                                                                            if ($ex == 1) {
                                                                                                                $mensagem = alerta("Relatório inserido com sucesso.", "success");
                                                                                                            }

                                                                                                        }

                                                                                                        if (isset($_GET['filter'])) {
                                                                                                            $order = ' ORDER BY "' . $_GET['filter'] . '" ' . $_GET['order'];
                                                                                                        } else {
                                                                                                            $order = ' ORDER BY id DESC ';
                                                                                                        }

                                                                                                        $total = 0;
                                                                                                        $k = 1;
                                                                                                        ?>
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                                                <h3>
                                                                                                                    Eventos
                                                                                                                    -
                                                                                                                    Listar
                                                                                                                    Relatórios</h3>
                                                                                                                <p><?php if (isset($mensagem)) {
                                                                                                                        echo $mensagem;
                                                                                                                    } ?></p>
                                                                                                                <?php
                                                                                                                // listar o evento;
                                                                                                                // var_dump($ex);
                                                                                                                ?>

                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <?php
                                                                                                        if ($user->ID != 1 AND $user->ID != 5 AND $user->ID != 17 AND $user->ID != 68) {
                                                                                                            $sel = "SELECT * FROM sc_indicadores WHERE publicado = '1' AND idUsuario = '" . $user->ID . "' $order LIMIT 0,100" ;
                                                                                                        } else {
                                                                                                            $sel = "SELECT * FROM sc_indicadores WHERE publicado = '1' $order  LIMIT 0,100";

                                                                                                        }
                                                                                                        $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                                                                        if (count($ocor) > 0){
                                                                                                        ?>

                                                                                                        <div class="table-responsive">
                                                                                                            <table class="table table-striped">
                                                                                                                <thead>
                                                                                                                <tr>
                                                                                                                    <th></th>
                                                                                                                    <th>
                                                                                                                        Evento
                                                                                                                    </th>
                                                                                                                    <th>
                                                                                                                        Período/Data
                                                                                                                    </th>
                                                                                                                    <th>
                                                                                                                        Contagem
                                                                                                                    </th>
                                                                                                                    <th width="10%"></th>
                                                                                                                    <th width="10%"></th>

                                                                                                                </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                <?php
                                                                                                                for ($i = 0; $i < count($ocor); $i++) {
                                                                                                                    $evento = evento($ocor[$i]['idEvento']);
                                                                                                                    if ($ocor[$i]['idOcorrencia'] != 0) {
                                                                                                                        $ocorrencia = ocorrencia($ocor[$i]['idOcorrencia']);
                                                                                                                        $local = " (" . $ocorrencia['local'] . ")";
                                                                                                                    } else {
                                                                                                                        $local = "";
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td><?php echo $k;
                                                                                                                            $k++; ?></td>
                                                                                                                        <td><?php echo $evento['titulo'] . $local; ?></td>
                                                                                                                        <td><?php echo exibirDataBr($ocor[$i]['periodoInicio']); ?><?php if ($ocor[$i]['periodoFim'] != '0000-00-00') {
                                                                                                                                echo " a " . exibirDataBr($ocor[$i]['periodoFim']);
                                                                                                                            } ?></td>
                                                                                                                        <td><?php echo $ocor[$i]['valor'];
                                                                                                                            if ($ocor[$i]['contagem'] == 1) {
                                                                                                                                echo " (total)";
                                                                                                                            } else {
                                                                                                                                echo " (média/dia)";
                                                                                                                            }
                                                                                                                            $total = $total + $ocor[$i]['valor'];

                                                                                                                            ?></td>
                                                                                                                        <td>

                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <form method="POST"
                                                                                                                                  action="?p=listarevento"
                                                                                                                                  class="form-horizontal"
                                                                                                                                  role="form">
                                                                                                                                <input type="hidden"
                                                                                                                                       name="apagar"
                                                                                                                                       value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                                                                <input type="submit"
                                                                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                                                                       value="Apagar">
                                                                                                                            </form>
                                                                                                                        </td>
                                                                                                                    </tr>

                                                                                                                <?php }

                                                                                                                $sql = "SELECT idEvento,nomeEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND (ano_base = 'ano_base') AND dataEnvio IS NOT NULL";
                                                                                                                $evento = $wpdb->get_results($sql, ARRAY_A);


                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td></td>
                                                                                                                    <td>
                                                                                                                        Total:
                                                                                                                    </td>
                                                                                                                    <td><?php echo count($evento); ?>
                                                                                                                        eventos
                                                                                                                        sem
                                                                                                                        indicação
                                                                                                                        de
                                                                                                                        público
                                                                                                                    </td>
                                                                                                                    <td><?php echo $total; ?></td>
                                                                                                                    <td></td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>


                                                                                                        </div>

                                                                                                </div>

                                                                                                <?php } else { ?>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                                        <p> Não há
                                                                                                            eventos
                                                                                                            cadastrados. </p>
                                                                                                    </div>
                                                                                                </div>


                                                                                                <?php } ?>

                                                                                                <?php
                                                                                                break;
                                                                                                case "listarcontinuadas":


                                                                                                if (isset($_POST['apagar'])) {
                                                                                                    $sql_update = "UPDATE sc_ind_continuadas SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                                                                    $apagar = $wpdb->query($sql_update);
                                                                                                    if ($apagar == 1) {
                                                                                                        $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                                                                    }
                                                                                                }


                                                                                                if (isset($_POST['inserir'])) {


                                                                                                    $idEvento = $_POST['idEvento'];
                                                                                                    $tipo = $_POST['tipo'];
                                                                                                    $idOcorrencia = $_POST['idOcorrencia'];
                                                                                                    $periodoInicio = exibirDataMysql($_POST['periodoInicio']);
                                                                                                    if ($_POST['periodoFim'] != '') {
                                                                                                        $periodoFim = exibirDataMysql($_POST['periodoFim']);
                                                                                                    } else {
                                                                                                        $periodoFim = '0000-00-00';

                                                                                                    }
                                                                                                    $abertura_acao = exibirDataMysql($_POST['abertura_acao']);
                                                                                                    $ndias = $_POST['ndias'];
                                                                                                    $contagem = $_POST['contagem'];
                                                                                                    $valor = $_POST['valor'];
                                                                                                    $relato = $_POST['relato'];
                                                                                                    $hora = $_POST["hora"];
                                                                                                    $outros_locais = $_POST["outros_locais"];
                                                                                                    $bairro = $_POST["bairro"];
                                                                                                    $projeto = $_POST["projeto"];
                                                                                                    $atracao_principal = $_POST["atracao_principal"];
                                                                                                    $linguagem = $_POST["linguagem"];
                                                                                                    $tipo_evento = $_POST["tipo_evento"];
                                                                                                    $numero_agentes = $_POST["numero_agentes"];
                                                                                                    $convocatoria_edital = $_POST["convocatoria_edital"];
                                                                                                    $nome_convocatoria = $_POST["nome_convocatoria"];
                                                                                                    $prof_sa = $_POST["prof_sa"];
                                                                                                    $quantidade_prof_sa = $_POST["quantidade_prof_sa"];
                                                                                                    $acao_parceria = $_POST["acao_parceria"];
                                                                                                    $nome_parceiro = $_POST["nome_parceiro"];
                                                                                                    $pub_jan = $_POST["pub_jan"];
                                                                                                    $pub_fev = $_POST["pub_fev"];
                                                                                                    $pub_mar = $_POST["pub_mar"];
                                                                                                    $pub_abr = $_POST["pub_abr"];
                                                                                                    $pub_mai = $_POST["pub_mai"];
                                                                                                    $pub_jun = $_POST["pub_jun"];
                                                                                                    $pub_jul = $_POST["pub_jul"];
                                                                                                    $pub_ago = $_POST["pub_ago"];
                                                                                                    $pub_set = $_POST["pub_set"];
                                                                                                    $pub_out = $_POST["pub_out"];
                                                                                                    $pub_nov = $_POST["pub_nov"];
                                                                                                    $pub_dez = $_POST["pub_dez"];
                                                                                                    $gastos_pessoal = dinheiroDeBr($_POST["gastos_pessoal"]);
                                                                                                    $gastos_estrutura = dinheiroDeBr($_POST["gastos_estrutura"]);
                                                                                                    $ano_base = $_POST["ano_base"];
                                                                                                    $idUsuario = $user->ID;

                                                                                                    $sql_inserir = "INSERT INTO `sc_ind_continuadas` (`id`, `idEvento`, `valor`, `contagem`, `tipo`, `periodoInicio`, `periodoFim`, `abertura_acao`, `ndias`, `idUsuario`, `relato`, `hora`, `outros_locais`, `bairro`, `projeto`, `atracao_principal`, `linguagem`, `tipo_evento`, `numero_agentes`, `convocatoria_edital`, `nome_convocatoria`, `prof_sa`, `quantidade_prof_sa`, `acao_parceria`, `nome_parceiro`, `pub_jan`, `pub_fev`, `pub_mar`,`pub_abr`, `pub_mai`, `pub_jun`, `pub_jul`, `pub_ago`,`pub_set`, `pub_out`, `pub_nov`, `pub_dez`, `gastos_pessoal`, `gastos_estrutura`,`ano_base`, `publicado`, `idOcorrencia`) VALUES (NULL, '$idEvento','$valor','$contagem', '$tipo','$periodoInicio', '$periodoFim', '$abertura_acao', '$ndias', '$idUsuario', '$relato', '$hora', '$outros_locais', '$bairro', '$projeto', '$atracao_principal', '$linguagem', '$tipo_evento', '$numero_agentes', '$convocatoria_edital', '$nome_convocatoria', '$prof_sa', '$quantidade_prof_sa', '$acao_parceria', '$nome_parceiro', '$pub_jan', '$pub_fev', '$pub_mar', '$pub_abr','$pub_mai','$pub_jun','$pub_jul','$pub_ago','$pub_set','$pub_out','$pub_nov','$pub_dez', '$gastos_pessoal', '$gastos_estrutura', '$ano_base', '1','$idOcorrencia')";
                                                                                                    $ex = $wpdb->query($sql_inserir);
                                                                                                    if ($ex == 1) {
                                                                                                        $mensagem = alerta("Relatório inserido com sucesso.", "success");
                                                                                                    }

                                                                                                }

                                                                                                if (isset($_GET['filter'])) {
                                                                                                    $order = ' ORDER BY "' . $_GET['filter'] . '" ' . $_GET['order'];
                                                                                                } else {
                                                                                                    $order = ' ORDER BY id DESC ';
                                                                                                }

                                                                                                $total = 0;
                                                                                                $k = 1;
                                                                                                ?>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                                        <h3>Exposições /
                                                                                                            Ações
                                                                                                            Continuadas
                                                                                                            - Listar
                                                                                                            Relatórios</h3>
                                                                                                        <p><?php if (isset($mensagem)) {
                                                                                                                echo $mensagem;
                                                                                                            } ?></p>
                                                                                                        <?php
                                                                                                        // listar o evento;
                                                                                                        // var_dump($ex);
                                                                                                        ?>

                                                                                                    </div>
                                                                                                </div>

                                                                                                <?php
                                                                                                if ($user->ID != 1 AND $user->ID != 5 AND $user->ID != 17 AND $user->ID != 68) {
                                                                                                    $sel = "SELECT * FROM sc_ind_continuadas WHERE publicado = '1' AND idUsuario = '" . $user->ID . "' ORDER BY periodoInicio DESC";
                                                                                                } else {
                                                                                                    $sel = "SELECT * FROM sc_ind_continuadas WHERE publicado = '1' ORDER BY periodoInicio DESC";

                                                                                                }
                                                                                                $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                                                                if(count($ocor) > 0){
                                                                                                ?>

                                                                                                <div class="table-responsive">
                                                                                                    <table class="table table-striped">
                                                                                                        <thead>
                                                                                                        <tr>
                                                                                                            <th></th>
                                                                                                            <th>Ação
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Período/Data
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Contagem
                                                                                                            </th>
                                                                                                            <th width="10%"></th>
                                                                                                            <th width="10%"></th>

                                                                                                        </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                        <?php
                                                                                                        for ($i = 0; $i < count($ocor); $i++) {
                                                                                                            $evento = evento($ocor[$i]['idEvento']);
                                                                                                            if ($ocor[$i]['idOcorrencia'] != 0) {
                                                                                                                $ocorrencia = ocorrencia($ocor[$i]['idOcorrencia']);
                                                                                                                $local = " (" . $ocorrencia['local'] . ")";
                                                                                                            } else {
                                                                                                                $local = "";
                                                                                                            }
                                                                                                            ?>
                                                                                                            <tr>
                                                                                                                <td><?php echo $k;
                                                                                                                    $k++; ?></td>
                                                                                                                <td><?php echo $evento['titulo'] . $local; ?></td>
                                                                                                                <?php if ($ocor[$i]['periodoInicio'] != '0000-00-00')
                                                                                                                {
                                                                                                                    ?>
                                                                                                                    <td><?php echo exibirDataBr($ocor[$i]['periodoInicio']); ?><?php if ($ocor[$i]['periodoFim'] != '0000-00-00') {
                                                                                                                            echo " a " . exibirDataBr($ocor[$i]['periodoFim']);
                                                                                                                        } ?></td>
                                                                                                                    <?php
                                                                                                                }else{
                                                                                                                ?>
                                                                                                                <td><?php echo "LONGA DURAÇÃO" ?>
                                                                                                                    <?php
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                <td><?php echo $ocor[$i]['valor'] + $ocor[$i]['pub_jan'] + $ocor[$i]['pub_fev'] + $ocor[$i]['pub_mar'] + $ocor[$i]['pub_abr'] + $ocor[$i]['pub_mai'] + $ocor[$i]['pub_jun'] + $ocor[$i]['pub_jul'] + $ocor[$i]['pub_ago'] + $ocor[$i]['pub_set'] + $ocor[$i]['pub_out'] + $ocor[$i]['pub_nov'] + $ocor[$i]['pub_dez'];
                                                                                                                    if ($ocor[$i]['contagem'] == 1) {
                                                                                                                        echo " (total)";
                                                                                                                    } else {
                                                                                                                        echo " (média/dia)";
                                                                                                                    }
                                                                                                                    $total = $total + ($ocor[$i]['valor'] + $ocor[$i]['pub_jan'] + $ocor[$i]['pub_fev'] + $ocor[$i]['pub_mar'] + $ocor[$i]['pub_abr'] + $ocor[$i]['pub_mai'] + $ocor[$i]['pub_jun'] + $ocor[$i]['pub_jul'] + $ocor[$i]['pub_ago'] + $ocor[$i]['pub_set'] + $ocor[$i]['pub_out'] + $ocor[$i]['pub_nov'] + $ocor[$i]['pub_dez']);

                                                                                                                    ?></td>
                                                                                                                <td>

                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <form method="POST"
                                                                                                                          action="?p=editarcontinuadas"
                                                                                                                          class="form-horizontal"
                                                                                                                          role="form">
                                                                                                                        <input type="hidden"
                                                                                                                               name="editar"
                                                                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                                                        <input type="submit"
                                                                                                                               class="btn btn-theme btn-sm btn-block"
                                                                                                                               value="Carregar">
                                                                                                                    </form>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <form method="POST"
                                                                                                                          action="?p=listarcontinuadas"
                                                                                                                          class="form-horizontal"
                                                                                                                          role="form">
                                                                                                                        <input type="hidden"
                                                                                                                               name="apagar"
                                                                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                                                        <input type="submit"
                                                                                                                               class="btn btn-theme btn-sm btn-block"
                                                                                                                               value="Apagar">
                                                                                                                    </form>
                                                                                                                </td>
                                                                                                            </tr>

                                                                                                        <?php }

                                                                                                        $sql = "SELECT idEvento,nomeEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND (ano_base = '2019') AND dataEnvio IS NOT NULL";
                                                                                                        $evento = $wpdb->get_results($sql, ARRAY_A);


                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td><strong>Total</strong>
                                                                                                            </td>
                                                                                                            <td><?php echo $total; ?></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>


                                                                                                </div>

                                                                                        </div>

                                                                                        <?php } else { ?>
                                                                                        <div class="row">
                                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                                <p> Não há eventos
                                                                                                    cadastrados. </p>
                                                                                            </div>
                                                                                        </div>


                                                                                        <?php } ?>

                                                                                        <?php
                                                                                        break;
                                                                                        case "inserircomunicacao":

                                                                                        ?>

                                                                                        <link href="css/jquery-ui.css"
                                                                                              rel="stylesheet">
                                                                                        <script src="js/jquery-ui.js"></script>
                                                                                        <script src="js/mask.js"></script>
                                                                                        <script src="js/maskMoney.js"></script>
                                                                                        <script>
                                                                                            $(function () {
                                                                                                $(".calendario").datepicker();
                                                                                                $(".hora").mask("99:99");
                                                                                                $(".min").mask("999");
                                                                                                $(".valor").maskMoney({
                                                                                                    prefix: '',
                                                                                                    thousands: '.',
                                                                                                    decimal: ',',
                                                                                                    affixesStay: true
                                                                                                });
                                                                                            });


                                                                                        </script>


                                                                                        <section id="contact"
                                                                                                 class="home-section bg-white">
                                                                                            <div class="container">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                                        <h3>Comunicação
                                                                                                            - Inserir
                                                                                                            Relatório</h3>
                                                                                                        <p><?php //echo $sql;
                                                                                                            ?></p>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
                                                                                            <div class="row">

                                                                                                <form class="formocor"
                                                                                                      action="?p=listarcomunicacao"
                                                                                                      method="POST"
                                                                                                      role="form">
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Período
                                                                                                                de
                                                                                                                Avaliação
                                                                                                                -
                                                                                                                Início:</label>
                                                                                                            <input type='text'
                                                                                                                   class="form-control calendario"
                                                                                                                   name="periodo_inicio"
                                                                                                                   value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                                                                                                   ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Período
                                                                                                                de
                                                                                                                Avaliação
                                                                                                                -
                                                                                                                Fim:</label>
                                                                                                            <input type='text'
                                                                                                                   class="form-control calendario"
                                                                                                                   name="periodo_fim"
                                                                                                                   value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                                                                                                   ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Ano
                                                                                                                Base</label>
                                                                                                            <input type="text"
                                                                                                                   name="ano_base"
                                                                                                                   class="form-control"
                                                                                                                   id="inputSubject"
                                                                                                                   value="ano_base"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Facebook
                                                                                                                - Nº de
                                                                                                                Postagens</label>
                                                                                                            <input type="text"
                                                                                                                   name="fb_postagens"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Facebook
                                                                                                                - Nº de
                                                                                                                Curtidas</label>
                                                                                                            <input type="text"
                                                                                                                   name="fb_curtidas"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Clipping
                                                                                                                - Nº de
                                                                                                                Matérias
                                                                                                                sobre a
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura
                                                                                                                publicadas</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_clipping"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Releases
                                                                                                                - Nº de
                                                                                                                Matérias
                                                                                                                sobre
                                                                                                                Atividades
                                                                                                                da
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura
                                                                                                                publicadas</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_releases"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Material
                                                                                                                Publicitário
                                                                                                                e Vídeos
                                                                                                                -
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura</label>
                                                                                                            <input type="text"
                                                                                                                   name="artevideo_cultura"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Material
                                                                                                                Publicitário
                                                                                                                e Vídeos
                                                                                                                -
                                                                                                                Comunicação</label>
                                                                                                            <input type="text"
                                                                                                                   name="artevideo_comunicacao"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Cadastros
                                                                                                                no
                                                                                                                Mailing
                                                                                                                da
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_mailing"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Agenda
                                                                                                                Cultural
                                                                                                                Online -
                                                                                                                Nº de
                                                                                                                Acessos</label>
                                                                                                            <input type="text"
                                                                                                                   name="agenda_acessos"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Agenda
                                                                                                                Cultural
                                                                                                                Online -
                                                                                                                Nº de
                                                                                                                Usuários</label>
                                                                                                            <input type="text"
                                                                                                                   name="agenda_usuarios"
                                                                                                                   class="form-control"
                                                                                                                   value=""/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Relato</label>
                                                                                                            <textarea
                                                                                                                    name="relato"
                                                                                                                    class="form-control"
                                                                                                                    rows="10"
                                                                                                                    placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                                                                                                ?></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <input type="hidden"
                                                                                                                   name="inserir"
                                                                                                                   value="1"/>
                                                                                                            <button type="submit"
                                                                                                                    class="btn btn-theme btn-lg btn-block">
                                                                                                                Enviar
                                                                                                                Relatório
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>

                                                                                        </section>

                                                                                        <?php
                                                                                        break;

                                                                                        case "listarcomunicacao":

                                                                                        if (isset($_POST['apagar'])) {
                                                                                            $sql_update = "UPDATE sc_ind_comunicacao SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                                                            $apagar = $wpdb->query($sql_update);
                                                                                            if ($apagar == 1) {
                                                                                                $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                                                            }
                                                                                        }


                                                                                        if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                                                                                            $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                                                            $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                                                            $fb_postagens = $_POST["fb_postagens"];
                                                                                            $fb_curtidas = $_POST["fb_curtidas"];
                                                                                            $sc_clipping = $_POST["sc_clipping"];
                                                                                            $sc_releases = $_POST["sc_releases"];
                                                                                            $artevideo_cultura = $_POST["artevideo_cultura"];
                                                                                            $artevideo_comunicacao = $_POST["artevideo_comunicacao"];
                                                                                            $sc_mailing = $_POST["sc_mailing"];
                                                                                            $agenda_acessos = $_POST["agenda_acessos"];
                                                                                            $agenda_usuarios = $_POST["agenda_usuarios"];
                                                                                            $relato = $_POST["relato"];
                                                                                            $ano_base = $_POST["ano_base"];
                                                                                            $atualizacao = date("Y-m-d H:s:i");
                                                                                            $idUsuario = $user->ID;
                                                                                        }

                                                                                        if (isset($_POST['inserir'])) {
                                                                                            $sql_ins = "INSERT INTO `sc_ind_comunicacao` (`periodo_inicio`, `periodo_fim`, `fb_postagens`, `fb_curtidas`, `sc_clipping`, `sc_releases`, `artevideo_cultura`, `artevideo_comunicacao`, `sc_mailing`, `agenda_acessos`, `agenda_usuarios`,`relato`,`ano_base`,`atualizacao`, `idUsuario`, `publicado`) VALUES ('$periodo_inicio', '$periodo_fim', '$fb_postagens', '$fb_curtidas', '$sc_clipping', '$sc_releases', '$artevideo_cultura', '$artevideo_comunicacao', '$sc_mailing', '$agenda_acessos', '$agenda_usuarios', '$relato', '$ano_base', '$atualizacao','$idUsuario','1' );";
                                                                                            $ins = $wpdb->query($sql_ins);
                                                                                            $lastid = $wpdb->insert_id;

                                                                                        }



                                                                                        if (isset($_POST['apagar'])) {
                                                                                            global $wpdb;
                                                                                            $id = $_POST['apagar'];
                                                                                            $sql = "UPDATE sc_ind_comunicacao SET publicado = '0' WHERE id = '$id'";
                                                                                            $apagar = $wpdb->query($sql);
                                                                                        }



                                                                                        ?>


                                                                                        <div class="row">
                                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                                <h3>Comunicação - Listar
                                                                                                    Relatórios</h3>
                                                                                                <?php
                                                                                                // listar o evento;
                                                                                                //var_dump($lastid);
                                                                                                ?>

                                                                                            </div>
                                                                                        </div>

                                                                                        <?php
                                                                                        $sel = "SELECT * FROM sc_ind_comunicacao WHERE publicado = '1' ORDER BY periodo_inicio DESC";
                                                                                        $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                                                        if(count($ocor) > 0){
                                                                                        ?>

                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-striped">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>Período</th>
                                                                                                    <th>Facebook -
                                                                                                        Postagens
                                                                                                    </th>
                                                                                                    <th>Facebook -
                                                                                                        Curtidas
                                                                                                    </th>
                                                                                                    <th>Clipping</th>
                                                                                                    <th>Releases</th>
                                                                                                    <th>Mailing</th>
                                                                                                    <th>Agenda Acessos
                                                                                                    </th>
                                                                                                    <th>Agenda
                                                                                                        Usuários
                                                                                                    </th>
                                                                                                    <th width="10%"></th>
                                                                                                    <th width="10%"></th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php
                                                                                                for ($i = 0; $i < count($ocor); $i++) {

                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?>
                                                                                                            a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
                                                                                                        <td><?php echo $ocor[$i]['fb_postagens'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['fb_curtidas'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['sc_clipping'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['sc_releases'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['sc_mailing'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['agenda_acessos'] ?></td>
                                                                                                        <td><?php echo $ocor[$i]['agenda_usuarios'] ?></td>
                                                                                                        <td>
                                                                                                            <form method="POST"
                                                                                                                  action="?p=editarcomunicacao"
                                                                                                                  class="form-horizontal"
                                                                                                                  role="form">
                                                                                                                <input type="hidden"
                                                                                                                       name="editar"
                                                                                                                       value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                                                <input type="submit"
                                                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                                                       value="Carregar">
                                                                                                            </form>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <form method="POST"
                                                                                                                  action="?p=listarcomunicacao"
                                                                                                                  class="form-horizontal"
                                                                                                                  role="form">
                                                                                                                <input type="hidden"
                                                                                                                       name="apagar"
                                                                                                                       value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                                                <input type="submit"
                                                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                                                       value="Apagar">
                                                                                                            </form>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                <?php } ?>

                                                                                                </tbody>
                                                                                            </table>


                                                                                        </div>

                                                                                </div>

                                                                                <?php } else { ?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <p> Não há relatórios
                                                                                                cadastrados. </p>
                                                                                        </div>
                                                                                    </div>


                                                                                <?php } ?>

                                                                                <?php
                                                                                break;
                                                                                case "editarcomunicacao":
                                                                                    if (isset($_POST['editar'])) {
                                                                                        $ind = recuperaDados("sc_ind_comunicacao", $_POST['editar'], "id");

                                                                                    }
                                                                                    $editar = 0;

                                                                                    if (isset($_POST["comunicacao"])) {
                                                                                        $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                                                        $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                                                        $fb_postagens = $_POST["fb_postagens"];
                                                                                        $fb_curtidas = $_POST["fb_curtidas"];
                                                                                        $sc_clipping = $_POST["sc_clipping"];
                                                                                        $sc_releases = $_POST["sc_releases"];
                                                                                        $artevideo_cultura = $_POST["artevideo_cultura"];
                                                                                        $artevideo_comunicacao = $_POST["artevideo_comunicacao"];
                                                                                        $sc_mailing = $_POST["sc_mailing"];
                                                                                        $agenda_acessos = $_POST["agenda_acessos"];
                                                                                        $agenda_usuarios = $_POST["agenda_usuarios"];
                                                                                        $relato = $_POST["relato"];
                                                                                        $ano_base = $_POST["ano_base"];
                                                                                        $atualizacao = date("Y-m-d H:s:i");
                                                                                        $idUsuario = $user->ID;

                                                                                        $sql_update = "UPDATE sc_ind_comunicacao SET	
	periodo_inicio = '$periodo_inicio',
	periodo_fim = '$periodo_fim',
	fb_postagens = '$fb_postagens',
	fb_curtidas = '$fb_curtidas',
	sc_clipping = '$sc_clipping',
	sc_releases = '$sc_releases',
	artevideo_cultura = '$artevideo_cultura',
	artevideo_comunicacao = '$artevideo_comunicacao',
	sc_mailing = '$sc_mailing',
	agenda_acessos = '$agenda_acessos',
	agenda_usuarios = '$agenda_usuarios',
	relato = '$relato',
	ano_base = '$ano_base'
	WHERE id = '" . $_POST['comunicacao'] . "'";

                                                                                        $editar = $wpdb->query($sql_update);
                                                                                        $ind = recuperaDados("sc_ind_comunicacao", $_POST['comunicacao'], "id");

                                                                                    }

                                                                                    ?>

                                                                                    <link href="css/jquery-ui.css"
                                                                                          rel="stylesheet">
                                                                                    <script src="js/jquery-ui.js"></script>
                                                                                    <script src="js/mask.js"></script>
                                                                                    <script src="js/maskMoney.js"></script>
                                                                                    <script>
                                                                                        $(function () {
                                                                                            $(".calendario").datepicker();
                                                                                            $(".hora").mask("99:99");
                                                                                            $(".min").mask("999");
                                                                                            $(".valor").maskMoney({
                                                                                                prefix: '',
                                                                                                thousands: '.',
                                                                                                decimal: ',',
                                                                                                affixesStay: true
                                                                                            });
                                                                                        });


                                                                                    </script>


                                                                                    <section id="contact"
                                                                                             class="home-section bg-white">
                                                                                        <div class="container">
                                                                                            <div class="row">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <h3>Comunicação -
                                                                                                        Editar
                                                                                                        Relatório</h3>
                                                                                                    <p><?php if ($editar == 1) {
                                                                                                            echo alerta("Relatório atualizado.", "success");
                                                                                                        }; ?></p>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="row">

                                                                                            <form class="formocor"
                                                                                                  action="?p=editarcomunicacao"
                                                                                                  method="POST"
                                                                                                  role="form">
                                                                                                <div class="form-group">
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Período
                                                                                                                da
                                                                                                                Avaliação
                                                                                                                -Início:</label>
                                                                                                            <input type='text'
                                                                                                                   class="form-control calendario"
                                                                                                                   name="periodo_inicio"
                                                                                                                   value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Período
                                                                                                                da
                                                                                                                Avaliação
                                                                                                                -
                                                                                                                Fim:</label>
                                                                                                            <input type='text'
                                                                                                                   class="form-control calendario"
                                                                                                                   name="periodo_fim"
                                                                                                                   value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                                                                                                       echo exibirDataBr($ind['periodo_fim']);
                                                                                                                   } ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Ano
                                                                                                                Base</label>
                                                                                                            <input type="text"
                                                                                                                   name="ano_base"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['ano_base']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Facebook
                                                                                                                - Nº de
                                                                                                                Postagens</label>
                                                                                                            <input type="text"
                                                                                                                   name="fb_postagens"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['fb_postagens']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Facebook
                                                                                                                - Nº de
                                                                                                                Curtidas</label>
                                                                                                            <input type="text"
                                                                                                                   name="fb_curtidas"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['fb_curtidas']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Clipping
                                                                                                                - Nº de
                                                                                                                Matérias
                                                                                                                sobre a
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura
                                                                                                                publicadas</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_clipping"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['sc_clipping']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Releases
                                                                                                                - Nº de
                                                                                                                Matérias
                                                                                                                sobre
                                                                                                                Atividades
                                                                                                                da
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura
                                                                                                                publicadas</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_releases"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['sc_releases']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Material
                                                                                                                Publicitário
                                                                                                                e Vídeos
                                                                                                                -
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura</label>
                                                                                                            <input type="text"
                                                                                                                   name="artevideo_cultura"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['artevideo_cultura']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Material
                                                                                                                Publicitário
                                                                                                                e Vídeos
                                                                                                                -
                                                                                                                Comunicação</label>
                                                                                                            <input type="text"
                                                                                                                   name="artevideo_comunicacao"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['artevideo_comunicacao']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Cadastros
                                                                                                                no
                                                                                                                Mailing
                                                                                                                da
                                                                                                                Secretaria
                                                                                                                de
                                                                                                                Cultura</label>
                                                                                                            <input type="text"
                                                                                                                   name="sc_mailing"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['sc_mailing']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Agenda
                                                                                                                Cultural
                                                                                                                Online -
                                                                                                                Nº de
                                                                                                                Acessos</label>
                                                                                                            <input type="text"
                                                                                                                   name="agenda_acessos"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['agenda_acessos']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Agenda
                                                                                                                Cultural
                                                                                                                Online -
                                                                                                                Nº de
                                                                                                                Usuários</label>
                                                                                                            <input type="text"
                                                                                                                   name="agenda_usuarios"
                                                                                                                   class="form-control"
                                                                                                                   value="<?php echo $ind['agenda_usuarios']; ?>"/>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <label>Relato</label>
                                                                                                            <textarea
                                                                                                                    name="relato"
                                                                                                                    class="form-control"
                                                                                                                    rows="10"
                                                                                                                    placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <input type="hidden"
                                                                                                                   name="comunicacao"
                                                                                                                   value="<?php echo $ind['id']; ?>"/>
                                                                                                            <button type="submit"
                                                                                                                    class="btn btn-theme btn-lg btn-block">
                                                                                                                Enviar
                                                                                                                Relatório
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                            </form>
                                                                                        </div>

                                                                                    </section>

                                                                                    <?php
                                                                                    break;
                                                                                case "inserirredes":

                                                                                ?>

                                                                                <link href="css/jquery-ui.css"
                                                                                      rel="stylesheet">
                                                                                <script src="js/jquery-ui.js"></script>
                                                                                <script src="js/mask.js"></script>
                                                                                <script src="js/maskMoney.js"></script>
                                                                                <script>
                                                                                    $(function () {
                                                                                        $(".calendario").datepicker();
                                                                                        $(".hora").mask("99:99");
                                                                                        $(".min").mask("999");
                                                                                        $(".valor").maskMoney({
                                                                                            prefix: '',
                                                                                            thousands: '.',
                                                                                            decimal: ',',
                                                                                            affixesStay: true
                                                                                        });
                                                                                    });


                                                                                </script>


                                                                                <section id="contact"
                                                                                         class="home-section bg-white">
                                                                                    <div class="container">
                                                                                        <div class="row">
                                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                                <h3>Redes Sociais -
                                                                                                    Inserir</h3>
                                                                                                <p><?php //echo $sql;
                                                                                                    ?></p>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="row">

                                                                                        <form class="formocor"
                                                                                              action="?p=listarredes"
                                                                                              method="POST" role="form">
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Período de
                                                                                                        Avaliação -
                                                                                                        Início:</label>
                                                                                                    <input type='text'
                                                                                                           class="form-control calendario"
                                                                                                           name="periodo_inicio"
                                                                                                           value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                                                                                           ?>"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Período de
                                                                                                        Avaliação -
                                                                                                        Fim:</label>
                                                                                                    <input type='text'
                                                                                                           class="form-control calendario"
                                                                                                           name="periodo_fim"
                                                                                                           value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                                                                                           ?>"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Ano
                                                                                                        Base</label>
                                                                                                    <input type="text"
                                                                                                           name="ano_base"
                                                                                                           class="form-control"
                                                                                                           id="inputSubject"
                                                                                                           value="ano_base"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Postagens -
                                                                                                        Casa da Palavra
                                                                                                        (só número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="posts_casapalavra"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Membros -
                                                                                                        Casa da Palavra
                                                                                                        (só número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="membros_casapalavra"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Postagens -
                                                                                                        ELCV (só número,
                                                                                                        sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="posts_elcv"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Membros -
                                                                                                        ELCV (só número,
                                                                                                        sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="membros_elcv"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Postagens -
                                                                                                        EMIA Aron
                                                                                                        Feldman (só
                                                                                                        número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="posts_emiaaf"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Membros -
                                                                                                        EMIA Aron
                                                                                                        Feldman (só
                                                                                                        número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="membros_emiaaf"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Postagens -
                                                                                                        Museu de Santo
                                                                                                        André (só
                                                                                                        número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="posts_museu"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                                    <label>Membros -
                                                                                                        Museu de Santo
                                                                                                        André (só
                                                                                                        número, sem
                                                                                                        pontuação)</label>
                                                                                                    <input type="text"
                                                                                                           name="membros_museu"
                                                                                                           class="form-control"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<label>Postagens - CEU Ana Maria (só número, sem pontuação)</label>
						<input type="text" name="posts_ceuana" class="form-control" value="" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<label>Membros - CEU Ana Maria (só número, sem pontuação)</label>
						<input type="text" name="membros_ceuana" class="form-control" value="" />
					</div>
				-->
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - CEU Marek
                                                                                                (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_ceumarek"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - CEU Marek
                                                                                                (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_ceumarek"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - Rede de
                                                                                                Bibliotecas de Santo
                                                                                                André - REBISA (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_rebisa"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - Rede de
                                                                                                Bibliotecas de Santo
                                                                                                André - REBISA (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_rebisa"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - ELD
                                                                                                (Página) (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_eld"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - ELD
                                                                                                (Página) (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_eld"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - ELD
                                                                                                (Grupo) (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_grupoeld"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - ELD (Grupo)
                                                                                                (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_grupoeld"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - Orquestra
                                                                                                Sinfônica de Santo André
                                                                                                (OSSA) (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_orquestra"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - Orquestra
                                                                                                Sinfônica de Santo André
                                                                                                (OSSA) (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_orquestra"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - Casa do
                                                                                                Olhar (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_casaolhar"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - Casa do
                                                                                                Olhar (só número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_casaolhar"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens - ELT (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_elt"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros - ELT (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_elt"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Postagens -
                                                                                                COMDEPHAAPASA (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="posts_comde"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                            <label>Membros -
                                                                                                COMDEPHAAPASA (só
                                                                                                número, sem
                                                                                                pontuação)</label>
                                                                                            <input type="text"
                                                                                                   name="membros_comde"
                                                                                                   class="form-control"
                                                                                                   value=""/>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Relato</label>
                                                                                <textarea name="relato"
                                                                                          class="form-control" rows="10"
                                                                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                                                                    ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <input type="hidden" name="inserir"
                                                                                       value="1"/>
                                                                                <button type="submit"
                                                                                        class="btn btn-theme btn-lg btn-block">
                                                                                    Enviar Relatório
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                </div>

                                                                    </section>

                                                                <?php
                                                                break;
                                                                case "editarredes":
                                                                    if (isset($_POST['editar'])) {
                                                                        $ind = recuperaDados("sc_ind_redes", $_POST['editar'], "id");

                                                                    }
                                                                    $editar = 0;

                                                                    if (isset($_POST["redes"])) {
                                                                        $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                                        $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                                        $posts_casapalavra = $_POST["posts_casapalavra"];
                                                                        $membros_casapalavra = $_POST["membros_casapalavra"];
                                                                        $posts_elcv = $_POST["posts_elcv"];
                                                                        $membros_elcv = $_POST["membros_elcv"];
                                                                        $posts_emiaaf = $_POST["posts_emiaaf"];
                                                                        $membros_emiaaf = $_POST["membros_emiaaf"];
                                                                        $posts_museu = $_POST["posts_museu"];
                                                                        $membros_museu = $_POST["membros_museu"];
                                                                        //$posts_ceuana = $_POST["posts_ceuana"];
                                                                        //$membros_ceuana = $_POST["membros_ceuana"];
                                                                        $posts_ceumarek = $_POST["posts_ceumarek"];
                                                                        $membros_ceumarek = $_POST["membros_ceumarek"];
                                                                        $posts_rebisa = $_POST["posts_rebisa"];
                                                                        $membros_rebisa = $_POST["membros_rebisa"];
                                                                        $posts_eld = $_POST["posts_eld"];
                                                                        $membros_eld = $_POST["membros_eld"];
                                                                        $posts_orquestra = $_POST["posts_orquestra"];
                                                                        $membros_orquestra = $_POST["membros_orquestra"];
                                                                        $posts_casaolhar = $_POST["posts_casaolhar"];
                                                                        $membros_casaolhar = $_POST["membros_casaolhar"];
                                                                        $posts_elt = $_POST["posts_elt"];
                                                                        $membros_elt = $_POST["membros_elt"];
                                                                        $posts_grupoeld = $_POST["posts_grupoeld"];
                                                                        $membros_grupoeld = $_POST["membros_grupoeld"];
                                                                        $posts_comde = $_POST["posts_comde"];
                                                                        $membros_comde = $_POST["membros_comde"];
                                                                        $ano_base = $_POST["ano_base"];
                                                                        $relato = $_POST["relato"];
                                                                        $atualizacao = date("Y-m-d H:s:i");
                                                                        $idUsuario = $user->ID;

                                                                        $sql_update = "UPDATE sc_ind_redes SET
	periodo_inicio = '$periodo_inicio',
	periodo_fim = '$periodo_fim',
	posts_casapalavra = '$posts_casapalavra',
	membros_casapalavra = '$membros_casapalavra',
	posts_elcv = '$posts_elcv',
	membros_elcv = '$membros_elcv',
	posts_emiaaf = '$posts_emiaaf',
	membros_emiaaf = '$membros_emiaaf',
	posts_museu = '$posts_museu',
	membros_museu = '$membros_museu',
	
	posts_ceumarek = '$posts_ceumarek',
	membros_ceumarek = '$membros_ceumarek',
	posts_rebisa = '$posts_rebisa',
	membros_rebisa = '$membros_rebisa',
	posts_eld = '$posts_eld',
	membros_eld = '$membros_eld',
	posts_orquestra = '$posts_orquestra',
	membros_orquestra = '$membros_orquestra',
	posts_casaolhar = '$posts_casaolhar',
	membros_casaolhar = 'membros_casaolhar',
	posts_elt = '$posts_elt',
	membros_elt = '$membros_elt',
	posts_grupoeld = '$posts_grupoeld',
	membros_grupoeld = '$membros_grupoeld',
	posts_comde = '$posts_comde',
	membros_comde = '$membros_comde',
	ano_base = '$ano_base',
	relato = '$relato'
	WHERE id = '" . $_POST['redes'] . "'";

                                                                        $editar = $wpdb->query($sql_update);
                                                                        $ind = recuperaDados("sc_ind_redes", $_POST['redes'], "id");

                                                                    }

                                                                    ?>

                                                                    <link href="css/jquery-ui.css" rel="stylesheet">
                                                                    <script src="js/jquery-ui.js"></script>
                                                                    <script src="js/mask.js"></script>
                                                                    <script src="js/maskMoney.js"></script>
                                                                    <script>
                                                                        $(function () {
                                                                            $(".calendario").datepicker();
                                                                            $(".hora").mask("99:99");
                                                                            $(".min").mask("999");
                                                                            $(".valor").maskMoney({
                                                                                prefix: '',
                                                                                thousands: '.',
                                                                                decimal: ',',
                                                                                affixesStay: true
                                                                            });
                                                                        });

                                                                    </script>

                                                                    <section id="contact" class="home-section bg-white">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-md-offset-2 col-md-8">
                                                                                    <h3>Redes Sociais - Editar</h3>
                                                                                    <p><?php if ($editar == 1) {
                                                                                            echo alerta("Redes Sociais atualizadas.", "success");
                                                                                        }; ?></p>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">

                                                                            <form class="formocor"
                                                                                  action="?p=editarredes" method="POST"
                                                                                  role="form">
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Período de Avaliação -
                                                                                            Início:</label>
                                                                                        <input type='text'
                                                                                               class="form-control calendario"
                                                                                               name="periodo_inicio"
                                                                                               value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Período de Avaliação -
                                                                                            Fim:</label>
                                                                                        <input type='text'
                                                                                               class="form-control calendario"
                                                                                               name="periodo_fim"
                                                                                               value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                                                                                   echo exibirDataBr($ind['periodo_fim']);
                                                                                               } ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Ano Base</label>
                                                                                        <input type="text"
                                                                                               name="ano_base"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['ano_base']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - Casa da
                                                                                            Palavra (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_casapalavra"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_casapalavra']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - Casa da Palavra
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_casapalavra"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_casapalavra']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - ELCV (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_elcv"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_elcv']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - ELCV (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_elcv"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_elcv']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - EMIA Aron
                                                                                            Feldman (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_emiaaf"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_emiaaf']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - EMIA Aron
                                                                                            Feldman (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_emiaaf"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_emiaaf']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - Museu de
                                                                                            Santo André (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_museu"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_museu']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - Museu de Santo
                                                                                            André (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_museu"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_museu']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <!--<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Postagens - CEU Ana Maria (só número, sem pontuação)</label>
					<input type="text" name="posts_ceuana" class="form-control" value="<?php echo $ind['posts_ceuana']; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Membros - CEU Ana Maria (só número, sem pontuação)</label>
					<input type="text" name="membros_ceuana" class="form-control" value="<?php echo $ind['membros_ceuana']; ?>" />
				</div>
			</div>-->
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - CEU Marek (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_ceumarek"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_ceumarek']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - CEU Marek (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_ceumarek"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_ceumarek']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - Rede de
                                                                                            Bibliotecas de Santo André -
                                                                                            REBISA (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_rebisa"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_rebisa']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - Rede de
                                                                                            Bibliotecas de Santo André -
                                                                                            REBISA (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_rebisa"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_rebisa']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - ELD (Página)
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_eld"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_eld']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - ELD (Página)
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_eld"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_eld']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - ELD (Grupo)
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_grupoeld"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_grupoeld']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - ELD (Grupo) (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_grupoeld"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_grupoeld']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - Orquestra
                                                                                            Sinfônica de Santo André
                                                                                            (OSSA) (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_orquestra"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_orquestra']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - Orquestra
                                                                                            Sinfônica de Santo André
                                                                                            (OSSA) (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_orquestra"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_orquestra']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - Casa do Olhar
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_casaolhar"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_casaolhar']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - Casa do Olhar
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_casaolhar"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_casaolhar']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - ELT (só
                                                                                            número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_elt"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_elt']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - ELT (só número,
                                                                                            sem pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_elt"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_elt']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Membros - COMDEPHAAPASA
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="membros_comde"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['membros_comde']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Postagens - COMDEPHAAPASA
                                                                                            (só número, sem
                                                                                            pontuação)</label>
                                                                                        <input type="text"
                                                                                               name="posts_comde"
                                                                                               class="form-control"
                                                                                               value="<?php echo $ind['posts_comde']; ?>"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <label>Relato</label>
                                                                                        <textarea name="relato"
                                                                                                  class="form-control"
                                                                                                  rows="10"
                                                                                                  placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-offset-2 col-md-8">
                                                                                        <input type="hidden"
                                                                                               name="redes"
                                                                                               value="<?php echo $ind['id']; ?>"/>
                                                                                        <button type="submit"
                                                                                                class="btn btn-theme btn-lg btn-block">
                                                                                            Enviar Relatório
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </section>

                                                                    <?php
                                                                    break;
                                                                case "listarredes":

                                                                if (isset($_POST['apagar'])) {
                                                                    $sql_update = "UPDATE sc_ind_redes SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                                    $apagar = $wpdb->query($sql_update);
                                                                    if ($apagar == 1) {
                                                                        $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                                    }
                                                                }


                                                                if (isset($_POST['inserir'])) {
                                                                    $mensagem = alerta("Erro.", "");
                                                                    $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                                    $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                                    $posts_casapalavra = $_POST["posts_casapalavra"];
                                                                    $membros_casapalavra = $_POST["membros_casapalavra"];
                                                                    $posts_elcv = $_POST["posts_elcv"];
                                                                    $membros_elcv = $_POST["membros_elcv"];
                                                                    $posts_emiaaf = $_POST["posts_emiaaf"];
                                                                    $membros_emiaaf = $_POST["membros_emiaaf"];
                                                                    $posts_museu = $_POST["posts_museu"];
                                                                    $membros_museu = $_POST["membros_museu"];
                                                                    //$posts_ceuana = $_POST["posts_ceuana"];
                                                                    //$membros_ceuana = $_POST["membros_ceuana"];
                                                                    $posts_ceumarek = $_POST["posts_ceumarek"];
                                                                    $membros_ceumarek = $_POST["membros_ceumarek"];
                                                                    $posts_rebisa = $_POST["posts_rebisa"];
                                                                    $membros_rebisa = $_POST["membros_rebisa"];
                                                                    $posts_eld = $_POST["posts_eld"];
                                                                    $membros_eld = $_POST["membros_eld"];
                                                                    $posts_grupoeld = $_POST["posts_grupoeld"];
                                                                    $membros_grupoeld = $_POST["membros_grupoeld"];
                                                                    $posts_orquestra = $_POST["posts_orquestra"];
                                                                    $membros_orquestra = $_POST["membros_orquestra"];
                                                                    $posts_casaolhar = $_POST["posts_casaolhar"];
                                                                    $membros_casaolhar = $_POST["membros_casaolhar"];
                                                                    $posts_elt = $_POST["posts_elt"];
                                                                    $membros_elt = $_POST["membros_elt"];
                                                                    $posts_comde = $_POST["posts_comde"];
                                                                    $membros_comde = $_POST["membros_comde"];
                                                                    $ano_base = $_POST["ano_base"];
                                                                    $relato = $_POST["relato"];


                                                                    $sql_inserir = "INSERT INTO `sc_ind_redes` (`id`, `periodo_inicio`, `periodo_fim`, `posts_casapalavra`, `membros_casapalavra`, `posts_elcv`, `membros_elcv`, `posts_emiaaf`, `membros_emiaaf`, `posts_museu`, `membros_museu`,`posts_ceumarek`, `membros_ceumarek`, `posts_rebisa`, `membros_rebisa`, `posts_eld`, `membros_eld`, `posts_grupoeld`, `membros_grupoeld`, `posts_orquestra`, `membros_orquestra`, `posts_casaolhar`, `membros_casaolhar`, `posts_elt`, `membros_elt`, `posts_comde`, `membros_comde`,`ano_base`, `relato`, `idUsuario`, `atualizacao`, `publicado`) VALUES (NULL, '$periodo_inicio', '$periodo_fim', '$posts_casapalavra', '$membros_casapalavra', '$posts_elcv', '$membros_elcv', '$posts_emiaaf', '$membros_emiaaf', '$posts_museu', '$membros_museu', '$posts_ceumarek', '$membros_ceumarek', '$posts_rebisa', '$membros_rebisa', '$posts_eld', '$membros_eld', '$posts_grupoeld', '$membros_grupoeld', '$posts_orquestra', '$membros_orquestra', '$posts_casaolhar', '$membros_casaolhar', '$posts_elt', '$membros_elt', '$posts_comde', '$membros_comde','$ano_base', '$relato', '" . $user->ID . "', '" . date("Y-m-d") . "','1')";
                                                                    //echo $sql_inserir;
                                                                    $ins = $wpdb->query($sql_inserir);
                                                                    if ($ins == 1) {
                                                                        $mensagem = alerta("Relatório inserido com sucesso.", "success");
                                                                    }
                                                                }

                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <h3>Redes Sociais - Listar Relatórios</h3>
                                                                        <p><?php if (isset($mensagem)) {
                                                                                echo $mensagem;
                                                                            } ?></p>
                                                                        <?php
                                                                        // listar o evento;
                                                                        // var_dump($ex);
                                                                        ?>

                                                                    </div>
                                                                </div>

                                                                <?php
                                                                $sel = "SELECT * FROM sc_ind_redes WHERE publicado = '1' ORDER BY periodo_inicio DESC";
                                                                $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                                if (count($ocor) > 0){
                                                                ?>

                                                                <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Período/Data</th>
                                                                            <th>Postagens</th>
                                                                            <th>Membros</th>
                                                                            <th width="10%"></th>

                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        for ($i = 0; $i < count($ocor); $i++) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if ($ocor[$i]['periodo_fim'] != '0000-00-00') {
                                                                                        echo " a " . exibirDataBr($ocor[$i]['periodo_fim']);
                                                                                    } ?></td>
                                                                                <td><?php echo $ocor[$i]['posts_casapalavra'] + $ocor[$i]['posts_elcv'] + $ocor[$i]['posts_emiaaf'] + $ocor[$i]['posts_museu'] + $ocor[$i]['posts_ceumarek'] + $ocor[$i]['posts_rebisa'] + $ocor[$i]['posts_eld'] + $ocor[$i]['posts_grupoeld'] + $ocor[$i]['posts_orquestra'] + $ocor[$i]['posts_casaolhar'] + $ocor[$i]['posts_elt'] + $ocor[$i]['posts_comde'] ?></td>
                                                                                <td><?php echo $ocor[$i]['membros_casapalavra'] + $ocor[$i]['membros_elcv'] + $ocor[$i]['membros_emiaaf'] + $ocor[$i]['membros_museu'] + $ocor[$i]['membros_ceumarek'] + $ocor[$i]['membros_rebisa'] + $ocor[$i]['membros_eld'] + $ocor[$i]['membros_grupoeld'] + $ocor[$i]['membros_orquestra'] + $ocor[$i]['membros_casaolhar'] + $ocor[$i]['membros_elt'] + $ocor[$i]['membros_comde'] ?></td>
                                                                                <td>
                                                                                    <form method="POST"
                                                                                          action="?p=editarredes"
                                                                                          class="form-horizontal"
                                                                                          role="form">
                                                                                        <input type="hidden"
                                                                                               name="editar"
                                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                        <input type="submit"
                                                                                               class="btn btn-theme btn-sm btn-block"
                                                                                               value="Carregar">
                                                                                    </form>
                                                                                </td>
                                                                                <td>
                                                                                    <form method="POST"
                                                                                          action="?p=listarredes"
                                                                                          class="form-horizontal"
                                                                                          role="form">
                                                                                        <input type="hidden"
                                                                                               name="apagar"
                                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                        <input type="submit"
                                                                                               class="btn btn-theme btn-sm btn-block"
                                                                                               value="Apagar">
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        </tbody>
                                                                    </table>


                                                                </div>

                                                        </div>

                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <p> Não há relatórios cadastrados. </p>
                                                                </div>
                                                            </div>


                                                        <?php } ?>

                                                        <?php
                                                        break;
                                                        case "inseririnscricoes":

                                                            ?>

                                                            <link href="css/jquery-ui.css" rel="stylesheet">
                                                            <script src="js/jquery-ui.js"></script>
                                                            <script src="js/mask.js"></script>
                                                            <script src="js/maskMoney.js"></script>
                                                            <script>
                                                                $(function () {
                                                                    $(".calendario").datepicker();
                                                                    $(".hora").mask("99:99");
                                                                    $(".min").mask("999");
                                                                    $(".valor").maskMoney({
                                                                        prefix: '',
                                                                        thousands: '.',
                                                                        decimal: ',',
                                                                        affixesStay: true
                                                                    });
                                                                });


                                                            </script>


                                                            <section id="contact" class="home-section bg-white">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-offset-2 col-md-8">
                                                                            <h3>Inscrições Convocatórias - Inserir
                                                                                Relatório</h3>
                                                                            <p><?php //echo $sql;
                                                                                ?></p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">

                                                                    <form class="formocor" action="?p=listarinscricoes"
                                                                          method="POST" role="form">
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Início da Convocatória</label>
                                                                                <input type='text'
                                                                                       class="form-control calendario"
                                                                                       name="periodo_inicio"
                                                                                       value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                                                                       ?>"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Fim da Convocatória</label>
                                                                                <input type='text'
                                                                                       class="form-control calendario"
                                                                                       name="periodo_fim"
                                                                                       value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                                                                       ?>"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Ano Base</label>
                                                                                <input type="text" name="ano_base"
                                                                                       class="form-control"
                                                                                       id="inputSubject" value="ano_base"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Convocatória/Credenciamento/Mobilização</label>
                                                                                <select class="form-control"
                                                                                        name="convocatoria"
                                                                                        id="convocatoria">
                                                                                    <option>Escolha uma opção</option>
                                                                                    <?php geraTipoOpcao("convocatoria") ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Valor Total Disponibilizado
                                                                                    (R$)</label>
                                                                                <input type="text"
                                                                                       name="valor_disponibilizado"
                                                                                       class="form-control valor"
                                                                                       value=""/>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Rascunhos</label>
                                                                                <input type="text" name="rascunhos"
                                                                                       class="form-control" value=""/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Inscritos</label>
                                                                                <input type="text" name="inscritos"
                                                                                       class="form-control" value=""/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Selecionados</label>
                                                                                <input type="text" name="selecionados"
                                                                                       class="form-control" value=""/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Contratados</label>
                                                                                <input type="text" name="contratados"
                                                                                       class="form-control" value=""/>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <label>Relato</label>
                                                                                <textarea name="relato"
                                                                                          class="form-control" rows="10"
                                                                                          placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                                                                    ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-md-offset-2 col-md-8">
                                                                                <input type="hidden" name="inserir"
                                                                                       value="1"/>
                                                                                <button type="submit"
                                                                                        class="btn btn-theme btn-lg btn-block">
                                                                                    Enviar Relatório
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </section>

                                                            <?php
                                                            break;

                                                        case "listarinscricoes":

                                                        if (isset($_POST['apagar'])) {
                                                            $sql_update = "UPDATE sc_ind_inscricoes SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                            $apagar = $wpdb->query($sql_update);
                                                            if ($apagar == 1) {
                                                                $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                            }
                                                        }


                                                        if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                                                            $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                            $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                            $convocatoria = $_POST["convocatoria"];
                                                            $valor_disponibilizado = dinheiroDeBr($_POST["valor_disponibilizado"]);

                                                            $rascunhos = $_POST["rascunhos"];
                                                            $inscritos = $_POST["inscritos"];
                                                            $selecionados = $_POST["selecionados"];
                                                            $contratados = $_POST["contratados"];

                                                            $relato = $_POST["relato"];
                                                            $ano_base = $_POST["ano_base"];
                                                            $atualizacao = date("Y-m-d H:s:i");
                                                            $idUsuario = $user->ID;
                                                        }

                                                        if (isset($_POST['inserir'])) {
                                                            $sql_ins = "INSERT INTO `sc_ind_inscricoes` (`periodo_inicio`, `periodo_fim`, `convocatoria`, `valor_disponibilizado`,`rascunhos`,`inscritos`, `selecionados`, `contratados`,`relato`,`ano_base`,`atualizacao`, `idUsuario`, `publicado`) 
	VALUES ('$periodo_inicio', '$periodo_fim', '$convocatoria', '$valor_disponibilizado', '$rascunhos', '$inscritos', '$selecionados', '$contratados','$relato', '$ano_base', '$atualizacao','$idUsuario','1' );";
                                                            $ins = $wpdb->query($sql_ins);
                                                            $lastid = $wpdb->insert_id;

                                                        }


                                                        if (isset($_POST['apagar'])) {
                                                            global $wpdb;
                                                            $id = $_POST['apagar'];
                                                            $sql = "UPDATE sc_ind_inscricoes SET publicado = '0' WHERE id = '$id'";
                                                            $apagar = $wpdb->query($sql);
                                                        }


                                                        ?>


                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <h3>Inscrições Convocatórias - Listar Relatórios</h3>
                                                                <?php
                                                                // listar o evento;
                                                                //var_dump($lastid);
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <?php
                                                        $sel = "SELECT * FROM sc_ind_inscricoes WHERE publicado = '1' ORDER BY periodo_inicio DESC";
                                                        $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                        if (count($ocor) > 0){
                                                        ?>

                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Período</th>
                                                                    <th>Nome</th>
                                                                    <th>Valor Disponibilizado (R$)</th>
                                                                    <th>Rascunhos</th>
                                                                    <th>Inscritos</th>
                                                                    <th>Selecionados</th>
                                                                    <th>Contratados</th>
                                                                    <th width="10%"></th>
                                                                    <th width="10%"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                for ($i = 0; $i < count($ocor); $i++) {
                                                                    $convocatoria = tipo($ocor[$i]['convocatoria']);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?>
                                                                            a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
                                                                        <td><?php echo $convocatoria['tipo'] ?></td>
                                                                        <td><?php echo dinheiroParaBr($ocor[$i]['valor_disponibilizado']) ?></td>
                                                                        <td><?php echo $ocor[$i]['rascunhos'] ?></td>
                                                                        <td><?php echo $ocor[$i]['inscritos'] ?></td>
                                                                        <td><?php echo $ocor[$i]['selecionados'] ?></td>
                                                                        <td><?php echo $ocor[$i]['contratados'] ?></td>
                                                                        <td>
                                                                            <form method="POST"
                                                                                  action="?p=editarinscricoes"
                                                                                  class="form-horizontal" role="form">
                                                                                <input type="hidden" name="editar"
                                                                                       value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                <input type="submit"
                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                       value="Carregar">
                                                                            </form>
                                                                        </td>
                                                                        <td>
                                                                            <form method="POST"
                                                                                  action="?p=listarinscricoes"
                                                                                  class="form-horizontal" role="form">
                                                                                <input type="hidden" name="apagar"
                                                                                       value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                                <input type="submit"
                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                       value="Apagar">
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>

                                                                </tbody>
                                                            </table>


                                                        </div>

                                                </div>

                                                <?php } else { ?>
                                                <div class="row">
                                                    <div class="col-md-offset-2 col-md-8">
                                                        <p> Não há relatórios cadastrados. </p>
                                                    </div>
                                                </div>


                                                <?php } ?>

                                                <?php
                                                break;
                                                case "editarinscricoes":
                                                if (isset($_POST['editar'])) {
                                                    $ind = recuperaDados("sc_ind_inscricoes", $_POST['editar'], "id");

                                                }
                                                $editar = 0;

                                                if (isset($_POST["inscricoes"])) {
                                                    $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                    $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                    $convocatoria = $_POST["convocatoria"];
                                                    $valor_disponibilizado = dinheiroDeBr($_POST["valor_disponibilizado"]);
                                                    $rascunhos = $_POST["rascunhos"];
                                                    $inscritos = $_POST["inscritos"];
                                                    $selecionados = $_POST["selecionados"];
                                                    $contratados = $_POST["contratados"];

                                                    $relato = $_POST["relato"];
                                                    $ano_base = $_POST["ano_base"];
                                                    $atualizacao = date("Y-m-d H:s:i");
                                                    $idUsuario = $user->ID;

                                                    $sql_update = "UPDATE sc_ind_inscricoes SET	
	periodo_inicio = '$periodo_inicio',
	periodo_fim = '$periodo_fim',
	convocatoria = '$convocatoria',
	valor_disponibilizado = '$valor_disponibilizado',
	rascunhos ='$rascunhos',
	inscritos = '$inscritos',
	selecionados = '$selecionados',
	contratados = '$contratados',
	relato = '$relato',
	ano_base = '$ano_base'
	WHERE id = '" . $_POST['inscricoes'] . "'";

                                                    $editar = $wpdb->query($sql_update);
                                                    $ind = recuperaDados("sc_ind_inscricoes", $_POST['inscricoes'], "id");

                                                }

                                                ?>

                                                <link href="css/jquery-ui.css" rel="stylesheet">
                                                <script src="js/jquery-ui.js"></script>
                                                <script src="js/mask.js"></script>
                                                <script src="js/maskMoney.js"></script>
                                                <script>
                                                    $(function () {
                                                        $(".calendario").datepicker();
                                                        $(".hora").mask("99:99");
                                                        $(".min").mask("999");
                                                        $(".valor").maskMoney({
                                                            prefix: '',
                                                            thousands: '.',
                                                            decimal: ',',
                                                            affixesStay: true
                                                        });
                                                    });


                                                </script>


                                                <section id="contact" class="home-section bg-white">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <h3>Inscrições Convocatórias - Editar Relatório</h3>
                                                                <p><?php if ($editar == 1) {
                                                                        echo alerta("Relatório atualizado.", "success");
                                                                    }; ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <form class="formocor" action="?p=editarinscricoes"
                                                              method="POST" role="form">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Início da Convocatória</label>
                                                                        <input type='text'
                                                                               class="form-control calendario"
                                                                               name="periodo_inicio"
                                                                               value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Fim da Convocatória</label>
                                                                        <input type='text'
                                                                               class="form-control calendario"
                                                                               name="periodo_fim"
                                                                               value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                                                                   echo exibirDataBr($ind['periodo_fim']);
                                                                               } ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Ano Base</label>
                                                                        <input type="text" name="ano_base"
                                                                               class="form-control"
                                                                               value="<?php echo $ind['ano_base']; ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Convocatória/Credenciamento/Mobilização</label>
                                                                        <select class="form-control" name="convocatoria"
                                                                                id="convocatoria">
                                                                            <option>Escolha uma opção</option>
                                                                            <?php geraTipoOpcao("convocatoria", $ind['convocatoria']) ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Valor Total Disponibilizado (R$)</label>
                                                                        <input type="text" name="valor_disponibilizado"
                                                                               class="form-control valor" value=""/>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Rascunhos</label>
                                                                        <input type="text" name="rascunhos"
                                                                               class="form-control"
                                                                               value="<?php echo $ind['rascunhos']; ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Inscritos</label>
                                                                        <input type="text" name="inscritos"
                                                                               class="form-control"
                                                                               value="<?php echo $ind['inscritos']; ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Selecionados</label>
                                                                        <input type="text" name="selecionados"
                                                                               class="form-control"
                                                                               value="<?php echo $ind['selecionados']; ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Contratados</label>
                                                                        <input type="text" name="contratados"
                                                                               class="form-control"
                                                                               value="<?php echo $ind['contratados']; ?>"/>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <label>Relato</label>
                                                                        <textarea name="relato" class="form-control"
                                                                                  rows="10"
                                                                                  placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="col-md-offset-2 col-md-8">
                                                                        <input type="hidden" name="inscricoes"
                                                                               value="<?php echo $ind['id']; ?>"/>
                                                                        <button type="submit"
                                                                                class="btn btn-theme btn-lg btn-block">
                                                                            Enviar Relatório
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                        </form>
                                                    </div>

                                                </section>

                                                <?php
                                                break;
                                                case "listaconvocatoria":

                                                if (isset($_POST['inserir'])) {
                                                    $tipo = $_POST['tipo'];
                                                    $json = array(
                                                        "tipo" => "$tipo"
                                                    );
                                                    $des = json_encode($json);
                                                    $sql_upd = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `abreviatura`, `publicado`) VALUES (NULL, '$tipo','convocatoria','1')";
                                                    $upd = $wpdb->query($sql_upd);
                                                    if ($upd == 1) {
                                                        $mensagem = alerta("Inserido com sucesso.", "success");
                                                    } else {
                                                        $mensagem = alerta("Não inserido. Tente novamente.", "warning");
                                                    }
                                                }

                                                if (isset($_POST['deleta'])) {
                                                    $deleta = $_POST['deleta'];
                                                    $sql = "UPDATE sc_tipo SET publicado = '0' WHERE id_tipo = '$deleta'";
                                                    $del = $wpdb->query($sql);
                                                    if ($del == 1) {
                                                        $mensagem = alerta("Deletado com sucesso.", "success");
                                                    } else {
                                                        $mensagem = alerta("Não deletado Tente novamente. $sql", "info");
                                                    }
                                                }

                                                ?>
                                                <link href="css/jquery-ui.css" rel="stylesheet">
                                                <script src="js/jquery-ui.js"></script>
                                                <script src="js/mask.js"></script>
                                                <script src="js/maskMoney.js"></script>
                                                <script>
                                                    $(function () {
                                                        $(".calendario").datepicker();
                                                        $(".hora").mask("99:99");
                                                        $(".min").mask("999");
                                                        $(".valor").maskMoney({
                                                            prefix: '',
                                                            thousands: '.',
                                                            decimal: ',',
                                                            affixesStay: true
                                                        });
                                                    });


                                                </script>
                                                <section id="contact" class="home-section bg-white">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <h1>Convocatórias CulturAZ</h1>
                                                                <p>Os itens cadastrados aqui servem de base para o
                                                                    preenchimento dos Indicadores referentes às
                                                                    Convocatórias. Mantenha sempre atualizado!</p>
                                                                <p><?php if (isset($mensagem)) {
                                                                        echo $mensagem;
                                                                    } ?></p>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-offset-1 col-md-10">

                                                        </div>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>

                                                                    <th>Nome da Convocatória</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <form method="POST" action="?p=listaconvocatoria"
                                                                          class="form-horizontal" role="form">
                                                                        <td>
                                                                            <input type="text" name="tipo"
                                                                                   class="form-control"
                                                                                   id="inputSubject"/>
                                                                        </td>
                                                                        <td>

                                                                            <input type="hidden" name="inserir"
                                                                                   value="1"/>
                                                                            <input type="submit"
                                                                                   class="btn btn-theme btn-sm btn-block"
                                                                                   value="Inserir">
                                                                    </form>
                                                                    </td>
                                                                    <td></td>

                                                                </tr>


                                                                <?php
                                                                global $wpdb;
                                                                $sql_list = "SELECT * FROM sc_tipo WHERE publicado = '1' AND abreviatura = 'convocatoria' ORDER BY tipo ASC";
                                                                $res = $wpdb->get_results($sql_list, ARRAY_A);

                                                                for ($i = 0; $i < count($res); $i++) {
                                                                    $json = json_decode($res[$i]['descricao'], true);
                                                                    $programa = tipo($json['programa']);
                                                                    $plan = retornaPlanejamento($res[$i],['id_tipo']);
                                                                    ?>
                                                                    <tr>

                                                                        <td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc);
                                                                            ?></td>


                                                                        <td>
                                                                            <form method="POST"
                                                                                  action="?p=editaconvocatoria"
                                                                                  class="form-horizontal" role="form">
                                                                                <input type="hidden" name="carregar"
                                                                                       value="<?php echo $res[$i]['id_tipo']; ?>"/>
                                                                                <input type="submit"
                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                       value="Editar">
                                                                            </form>
                                                                        </td>
                                                                        <td>
                                                                            <form method="POST"
                                                                                  action="?p=listaconvocatoria"
                                                                                  class="form-horizontal" role="form">
                                                                                <input type="hidden" name="deleta"
                                                                                       value="<?php echo $res[$i]['id_tipo']; ?>"/>
                                                                                <input type="submit"
                                                                                       class="btn btn-theme btn-sm btn-block"
                                                                                       value="Deletar">
                                                                            </form>
                                                                        </td>

                                                                    </tr>

                                                                <?php } ?>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </section>
                                                <?php
                                                break;
                                                case "editaconvocatoria":

                                                if (isset($_POST['carregar'])) {
                                                    $projeto = tipo($_POST['carregar']);
                                                    $pro_json = json_decode($projeto['descricao'], true);
                                                    //var_dump($pro_json);
                                                }

                                                if (isset($_POST['editaprojeto'])) {
                                                    $id = $_POST['editaprojeto'];
                                                    $tipo = $_POST['tipo'];

                                                    $json = array(
                                                        "tipo" => "$tipo"
                                                    );
                                                    $des = json_encode($json, JSON_UNESCAPED_UNICODE);
                                                    $sql_upd = "UPDATE sc_tipo SET
		tipo = '$tipo'
		WHERE id_tipo = '$id';	
		";
                                                    $upd = $wpdb->query($sql_upd);
                                                    if ($upd == 1) {
                                                        $mensagem = alerta("Atualizado com sucesso.", "success");
                                                    } else {
                                                        $mensagem = alerta("Não atualizado. Tente novamente.", "alert");
                                                    }

                                                    $projeto = tipo($id);
                                                    $pro_json = json_decode($projeto['descricao'], true);

                                                }

                                                ?>
                                                <link href="css/jquery-ui.css" rel="stylesheet">
                                                <script src="js/jquery-ui.js"></script>
                                                <script src="js/mask.js"></script>
                                                <script src="js/maskMoney.js"></script>
                                                <script>
                                                    $(function () {
                                                        $(".calendario").datepicker();
                                                        $(".hora").mask("99:99");
                                                        $(".min").mask("999");
                                                        $(".valor").maskMoney({
                                                            prefix: '',
                                                            thousands: '.',
                                                            decimal: ',',
                                                            affixesStay: true
                                                        });
                                                    });


                                                </script>


                                                </script>
                                                <
                                                section
                                                id = "inserir"
                                                class
                                                = "home-section bg-white" >
                                                    < div
                                                class
                                                = "container" >
                                                    < div
                                                class
                                                = "row" >
                                                    < div
                                                class
                                                = "col-md-offset-2 col-md-8" >

                                                    < h2 > Convocatórias < /h2>
                                                    <?php if (isset($mensagem)) {
                                                        echo $mensagem;
                                                    } ?>



                                                    < /div>
                                                    < /div>
                                                    < div
                                                class
                                                = "row" >
                                                    < div
                                                class
                                                = "col-md-offset-1 col-md-10" >
                                                    < form
                                                method = "POST"
                                                action = "?p=editaconvocatoria"
                                                class
                                                = "form-horizontal"
                                                role = "form" >
                                                    < div
                                                class
                                                = "form-group" >
                                                    < div
                                                class
                                                = "col-md-offset-2" >
                                                    < label > Titulo * < /label>
                                                    < input
                                                type = "text"
                                                name = "tipo"
                                                class
                                                = "form-control"
                                                id = "inputSubject"
                                                value = "<?php echo $projeto['tipo'] ?>" / >
                                                    < /div>
                                                    < /div>

                                                    < div
                                                class
                                                = "form-group" >
                                                    < div
                                                class
                                                = "col-md-offset-2" >
                                                    < input
                                                type = "hidden"
                                                name = "editaconvocatoria"
                                                value = "<?php echo $projeto['id_tipo'] ?>" / >
                                                    <?php
                                                    ?>
                                                    < input
                                                type = "submit"
                                                class
                                                = "btn btn-theme btn-lg btn-block"
                                                value = "Atualizar Projeto" >
                                                    < /div>
                                                    < /div>
                                                    < /form>
                                                    < /div>
                                                    < /div>
                                                    < /div>
                                                    < /section>


                                                    <?php

                                                    break;
                                                    case "grafico":
                                                    include("inc/phplot/phplot.php");
                                                    ?>
                                                    <?php

                                                    $grafico = new PHPlot();

                                                    $grafico->SetFileFormat("png");

                                                    # Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
                                                    $grafico->SetTitle("Gráfico de exemplo");
                                                    $grafico->SetXTitle("Eixo X");
                                                    $grafico->SetYTitle("Eixo Y");


                                                    # Definimos os dados do gráfico
                                                    $dados = array(
                                                        array('Janeiro', 10),
                                                        array('Fevereiro', 5),
                                                        array('Março', 4),
                                                        array('Abril', 8),
                                                        array('Maio', 7),
                                                        array('Junho', 5),
                                                    );

                                                    $grafico->SetDataValues($dados);

                                                    # Neste caso, usariamos o gráfico em barras
                                                    $grafico->SetPlotType("bars");

                                                    # Exibimos o gráfico
                                                    $grafico->DrawGraph();
                                                    ?>

                                                    <?php
                                                    break;
                                                    case "listar_evento_sem_indicador":
													$hoje = date('Y-m-d');
                                                    //$sql = "SELECT idEvento,nomeEvento,idUsuario,idResponsavel,idSuplente FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND idEvento NOT IN (SELECT DISTINCT idEvento FROM sc_ind_continuadas) AND idEvento NOT IN (664,667,676,692,693,695,844) AND publicado = '1' AND dataEnvio IS NOT NULL AND status NOT IN (5)";
													
                                                    $sql = "SELECT idEvento,nomeEvento,idUsuario,idResponsavel,idSuplente FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND idEvento NOT IN (SELECT DISTINCT idEvento FROM sc_ind_continuadas) AND idEvento IN(SELECT idEvento FROM sc_ocorrencia WHERE dataInicio < '$hoje') AND publicado = '1' AND dataEnvio IS NOT NULL AND status NOT IN (5) AND (idResponsavel = '$usuario' OR idSuplente = '$usuario') ";
                                                    $evento = $wpdb->get_results($sql,ARRAY_A);
                                                    echo "<h1>".count($evento)." eventos sem informação de público.</h1><br />";


                                                    ?>

                                                    <div class="table-responsive">
                                                    <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                    <th>ID</th>
                                                    <th>Nome do Evento</th>
                                                <th>Período</th>
                                                <th>Responsável</th>
                                                <th>Suplente</th>
                                                <th>Quem cadastrou</th>
												<th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                for($i = 0; $i < count($evento); $i++){
                                                $evento2 = evento($evento[$i]['idEvento']);
                                                ?>
                                                <tr>
                                                <td><?php echo $evento[$i]['idEvento'] ?></td>
                                                <td><?php echo $evento[$i]['nomeEvento'] ?></td>
                                                <td><?php echo $evento2['periodo']['legivel']; ?></td>
                                                <?php
                                                $responsavel = retornaUsuario($evento[$i]['idResponsavel']);
                                                ?>
                                                <td><?php echo $responsavel['display_name'] ?></td>

                                                <?php
                                                $suplente = retornaUsuario($evento[$i]['idSuplente']);
                                                ?>
                                                <td><?php echo $suplente['display_name'] ?></td>

                                                <?php
                                                $usuario = retornaUsuario($evento[$i]['idUsuario']);
                                                ?>
                                                <td><?php echo $usuario['display_name'] ?></td>
												<td>
												<form method="POST" action="?p=inserirevento_dataunica&evento=<?php echo $evento[$i]['idEvento'] ?>" class="form-horizontal" role="form">
												
												<button type="submit" class="btn btn-theme btn-lg btn-block">Inserir</button>
												</form>
												</td>
                                                <?php
                                                }
                                                ?>

												
                                                <?php
                                                break;

                                                case "listarincentivo":

                                                if (isset($_POST['apagar'])) {
                                                    $sql_update = "UPDATE sc_ind_incentivo SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                    $apagar = $wpdb->query($sql_update);
                                                    if ($apagar == 1) {
                                                        $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                    }
                                                }


                                                if (isset($_POST['inserir']) OR isset($_POST['editar'])) {
                                                    $equipamento = $_POST["equipamento"];
                                                    $outros = $_POST["outros"];
                                                    $bairro = $_POST["bairro"];
                                                    $projeto = $_POST["projeto"];
                                                    $tipo_acao = $_POST["tipo_acao"];
                                                    $titulo_acao = $_POST["titulo_acao"];
                                                    $linguagem = $_POST["linguagem"];
                                                    $disciplinas = $_POST["disciplinas"];
                                                    $ocor_inicio = exibirDataMysql($_POST["ocor_inicio"]);
                                                    $ocor_fim = exibirDataMysql($_POST["ocor_fim"]);
                                                    $carga_horaria = $_POST["carga_horaria"];
                                                    $n_concluintes = $_POST["n_concluintes"];
                                                    $n_evasao = $_POST["n_evasao"];
                                                    $nome_profissional = $_POST["nome_profissional"];
                                                    $santo_andre = $_POST["santo_andre"];
                                                    $custo_hora_aula = dinheiroDeBr($_POST["custo_hora_aula"]);
                                                    $carga_horaria_prof = $_POST["carga_horaria_prof"];
                                                    $custo_total = dinheiroDeBr($_POST["custo_total"]);
                                                    $material_consumo = dinheiroDeBr($_POST["material_consumo"]);
                                                    $parceria = $_POST["parceria"];
                                                    $parceiro = $_POST["parceiro"];
                                                    $vagas = $_POST["vagas"];
                                                    $rematriculas = $_POST["rematriculas"];
                                                    $inscritos = $_POST["inscritos"];
                                                    $espera = $_POST["espera"];
                                                    $obs = $_POST["obs"];
                                                    $janeiro = $_POST["janeiro"];
                                                    $fevereiro = $_POST["fevereiro"];
                                                    $marco = $_POST["marco"];
                                                    $abril = $_POST["abril"];
                                                    $maio = $_POST["maio"];
                                                    $junho = $_POST["junho"];
                                                    $julho = $_POST["julho"];
                                                    $agosto = $_POST["agosto"];
                                                    $setembro = $_POST["setembro"];
                                                    $outubro = $_POST["outubro"];
                                                    $novembro = $_POST["novembro"];
                                                    $dezembro = $_POST["dezembro"];
                                                    $ano_base = $_POST["ano_base"];
                                                    $atualizacao = date("Y-m-d H:s:i");
                                                    $idUsuario = $user->ID;
                                                }

                                                if (isset($_POST['inserir'])) {
                                                    $sql_ins = "INSERT INTO `sc_ind_incentivo` (`equipamento`, `outros`, `bairro`, `projeto`, `tipo_acao`, `titulo_acao`, `disciplinas`, `linguagem`, `ocor_inicio`, `ocor_fim`, `carga_horaria`, `n_concluintes`, `n_evasao`, `nome_profissional`, `santo_andre`, `custo_hora_aula`, `carga_horaria_prof`, `custo_total`, `material_consumo`, `parceria`, `parceiro`, `vagas`, `rematriculas`, `inscritos`, `espera`, `obs`, `janeiro`, `fevereiro`, `marco`, `abril`, `maio`, `junho`, `julho`, `agosto`, `setembro`, `outubro`, `novembro`, `dezembro`, `ano_base`,`atualizacao`, `idUsuario`, `publicado`) VALUES ( '$equipamento', '$outros', '$bairro', '$projeto', '$tipo_acao', '$titulo_acao', '$disciplinas', '$linguagem', '$ocor_inicio', '$ocor_fim', '$carga_horaria', '$n_concluintes', '$n_evasao', '$nome_profissional', '$santo_andre', '$custo_hora_aula', '$carga_horaria_prof', '$custo_total', '$material_consumo', '$parceria', '$parceiro', '$vagas', '$rematriculas', '$inscritos', '$espera', '$obs','$janeiro','$fevereiro','$marco','$abril','$maio','$junho','$julho','$agosto','$setembro','$outubro','$novembro', '$dezembro','$ano_base','$atualizacao','$idUsuario','1' );";
                                                    $ins = $wpdb->query($sql_ins);
                                                    $lastid = $wpdb->insert_id;

                                                }



                                                if (isset($_POST['apagar'])) {
                                                    global $wpdb;
                                                    $id = $_POST['apagar'];
                                                    $sql = "UPDATE sc_ind_incentivo SET publicado = '0' WHERE id = '$id'";
                                                    $apagar = $wpdb->query($sql);
                                                }



                                                ?>


                                                < div
                                                class
                                                = "row" >
                                                    < div
                                                class
                                                = "col-md-offset-2 col-md-8" >
                                                    < h3 > Incentivo
                                                à
                                                Criação - Listar
                                                Disciplinas < /h3>
                                                <?php
                                                // listar o evento;
                                                //var_dump($lastid);
                                                ?>

                                                < /div>
                                                < /div>

                                                <?php
                                                $sel = "SELECT * FROM sc_ind_incentivo WHERE publicado = '1' ORDER BY id DESC";
                                                $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                if(count($ocor) > 0){
                                                ?>

                                                < div
                                                class
                                                = "table-responsive" >
                                                    < table
                                                class
                                                = "table table-striped" >
                                                    < thead >
                                                    < tr >
                                                    < th > Título
                                                Disciplina / Curso < /th>
                                                < th > Responsável < /th>
                                                < th > Período < /th>
                                                < th
                                                width = "10%" > < /th>
                                                    < th
                                                width = "10%" > < /th>

                                                    < /tr>
                                                    < /thead>
                                                    < tbody >
                                                    <?php
                                                    for($i = 0; $i < count($ocor); $i++){

                                                    ?>
                                                    < tr >
                                                    < td ><?php echo $ocor[$i]['titulo_acao'];  ?>< /td>
                                                    <?php $equipamento = retornaTipo($ocor[$i]['equipamento']); ?>
                                                    < td ><?php echo $ocor[$i]['nome_profissional']; ?>< /td>
                                                    < td ><?php echo exibirDataBr($ocor[$i]['ocor_inicio']) ?> a <?php echo exibirDataBr($ocor[$i]['ocor_fim']) ?> < /td>
                                                    < td >
                                                    < form
                                                method = "POST"
                                                action = "?p=editarincentivo"
                                                class
                                                = "form-horizontal"
                                                role = "form" >
                                                    < input
                                                type = "hidden"
                                                name = "editar"
                                                value = "<?php echo $ocor[$i]['id']; ?>" / >
                                                    < input
                                                type = "submit"
                                                class
                                                = "btn btn-theme btn-sm btn-block"
                                                value = "Carregar" >
                                                    < /form>
                                                    < /td>
                                                    < td >
                                                    < form
                                                method = "POST"
                                                action = "?p=listarincentivo"
                                                class
                                                = "form-horizontal"
                                                role = "form" >
                                                    < input
                                                type = "hidden"
                                                name = "apagar"
                                                value = "<?php echo $ocor[$i]['id']; ?>" / >
                                                    < input
                                                type = "submit"
                                                class
                                                = "btn btn-theme btn-sm btn-block"
                                                value = "Apagar" >
                                                    < /form>
                                                    < /td>
                                                    < /tr>
                                                    <?php } ?>

                                                    < /tbody>
                                                    < /table>


                                                    < /div>

                                                    < /div>

                                                    <?php } else { ?>
                                                    < div
                                                class
                                                = "row" >
                                                    < div
                                                class
                                                = "col-md-offset-2 col-md-8" >
                                                    < p > Não
                                                há
                                                disciplinas / cursos
                                                cadastrados. < /p>
                                                < /div>
                                                < /div>


                                                <?php } ?>

                                                <?php
                                                break;
                                                case "inserirorcamento":

                                                ?>

                                                < link
                                                href = "css/jquery-ui.css"
                                                rel = "stylesheet" >
                                                    < script
                                                src = "js/jquery-ui.js" ></script>
                                                <script src="js/mask.js"></script>
                                                <script src="js/maskMoney.js"></script>
                                                <script>
                                                    $(function () {
                                                        $(".calendario").datepicker();
                                                        $(".hora").mask("99:99");
                                                        $(".min").mask("999");
                                                        $(".valor").maskMoney({
                                                            prefix: '',
                                                            thousands: '.',
                                                            decimal: ',',
                                                            affixesStay: true
                                                        });
                                                    });


                                                </script>


                                                <section id="contact" class="home-section bg-white">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <h3>Orçamento Mensal - Inserir</h3>
                                                                <p><?php //echo $sql;
                                                                    ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <form class="formocor" action="?p=listarorcamento" method="POST"
                                                              role="form">
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Período de Avaliação - Início:</label>
                                                                    <input type='text' class="form-control calendario"
                                                                           name="periodo_inicio"
                                                                           value="<?php //echo exibirDataBr($ocor['dataInicio']);
                                                                           ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Período de Avaliação - Fim:</label>
                                                                    <input type='text' class="form-control calendario"
                                                                           name="periodo_fim"
                                                                           value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);}
                                                                           ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Ano Base</label>
                                                                    <input type="text" name="ano_base"
                                                                           class="form-control" id="inputSubject"
                                                                           value="2019"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Orçado</label>
                                                                    <input type="text" name="orcado"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Contigenciado</label>
                                                                    <input type="text" name="contigenciado"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Suplementado / Liberado</label>
                                                                    <input type="text" name="sup_liberado"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Empenhado</label>
                                                                    <input type="text" name="empenhado"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Reservado</label>
                                                                    <input type="text" name="reservado"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Disponível</label>
                                                                    <input type="text" name="disponivel"
                                                                           class="form-control valor" value=""/>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Relato</label>
                                                                    <textarea name="relato" class="form-control"
                                                                              rows="10"
                                                                              placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"]
                                                                        ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <input type="hidden" name="inserir" value="1"/>
                                                                    <button type="submit"
                                                                            class="btn btn-theme btn-lg btn-block">
                                                                        Enviar Relatório
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </section>

                                                <?php
                                                break;
                                                case "editarorcamento":
                                                if (isset($_POST['editar'])) {
                                                    $ind = recuperaDados("sc_ind_orcamento", $_POST['editar'], "id");

                                                }
                                                $editar = 0;

                                                if (isset($_POST["orcamento"])) {
                                                    $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                    $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                    $orcado = dinheiroDeBr($_POST["orcado"]);
                                                    $contigenciado = dinheiroDeBr($_POST["contigenciado"]);
                                                    $sup_liberado = dinheiroDeBr($_POST["sup_liberado"]);
                                                    $empenhado = dinheiroDeBr($_POST["empenhado"]);
                                                    $reservado = dinheiroDeBr($_POST["reservado"]);
                                                    $disponivel = dinheiroDeBr($_POST["disponivel"]);
                                                    $ano_base = $_POST["ano_base"];
                                                    $relato = $_POST["relato"];
                                                    $atualizacao = date("Y-m-d H:s:i");
                                                    $idUsuario = $user->ID;

                                                    $sql_update = "UPDATE sc_ind_orcamento SET
	periodo_inicio = '$periodo_inicio',
	periodo_fim = '$periodo_fim',
	orcado = '$orcado',
	contigenciado = '$contigenciado',
	sup_liberado = '$sup_liberado',
	empenhado = '$empenhado',
	reservado = '$reservado',
	disponivel = '$disponivel',
	ano_base ='$ano_base',
	relato = '$relato'
	WHERE id = '" . $_POST['orcamento'] . "'";

                                                    $editar = $wpdb->query($sql_update);
                                                    $ind = recuperaDados("sc_ind_orcamento", $_POST['orcamento'], "id");

                                                }

                                                ?>

                                                <link href="css/jquery-ui.css" rel="stylesheet">
                                                <script src="js/jquery-ui.js"></script>
                                                <script src="js/mask.js"></script>
                                                <script src="js/maskMoney.js"></script>
                                                <script>
                                                    $(function () {
                                                        $(".calendario").datepicker();
                                                        $(".hora").mask("99:99");
                                                        $(".min").mask("999");
                                                        $(".valor").maskMoney({
                                                            prefix: '',
                                                            thousands: '.',
                                                            decimal: ',',
                                                            affixesStay: true
                                                        });
                                                    });


                                                </script>


                                                <section id="contact" class="home-section bg-white">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <h3>Orçamento - Editar</h3>
                                                                <p><?php if ($editar == 1) {
                                                                        echo alerta("Relatório atualizado.", "success");
                                                                    }; ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <form class="formocor" action="?p=editarorcamento" method="POST"
                                                              role="form">
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Período de Avaliação - Início:</label>
                                                                    <input type='text' class="form-control calendario"
                                                                           name="periodo_inicio"
                                                                           value="<?php echo exibirDataBr($ind['periodo_inicio']); ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Período de Avaliação - Fim:</label>
                                                                    <input type='text' class="form-control calendario"
                                                                           name="periodo_fim"
                                                                           value="<?php if ($ind['periodo_fim'] != '0000-00-00') {
                                                                               echo exibirDataBr($ind['periodo_fim']);
                                                                           } ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Ano Base</label>
                                                                    <input type="text" name="ano_base"
                                                                           class="form-control"
                                                                           value="<?php echo $ind['ano_base']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Orçado</label>
                                                                    <input type="text" name="orcado"
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['orcado']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Contingenciado</label>
                                                                    <input type="text" name="contigenciado"
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['contigenciado']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Suplementado / Liberado</label>
                                                                    <input type="text" name="sup_liberado"
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['sup_liberado']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Empenhado</label>
                                                                    <input type="text" name=empenhado
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['empenhado']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Reservado</label>
                                                                    <input type="text" name="reservado"
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['reservado']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Disponível</label>
                                                                    <input type="text" name="disponivel"
                                                                           class="form-control valor"
                                                                           value="<?php echo $ind['disponivel']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <label>Relato</label>
                                                                    <textarea name="relato" class="form-control"
                                                                              rows="10"
                                                                              placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["relato"] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-offset-2 col-md-8">
                                                                    <input type="hidden" name="orcamento"
                                                                           value="<?php echo $ind['id']; ?>"/>
                                                                    <button type="submit"
                                                                            class="btn btn-theme btn-lg btn-block">
                                                                        Enviar Relatório
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </section>

                                                <?php
                                                break;
                                                case "listarorcamento":

                                                if (isset($_POST['apagar'])) {
                                                    $sql_update = "UPDATE sc_ind_orcamento SET publicado = '0' WHERE id = '" . $_POST['apagar'] . "'";
                                                    $apagar = $wpdb->query($sql_update);
                                                    if ($apagar == 1) {
                                                        $mensagem = alerta("Relatório apagado com sucesso", "success");
                                                    }
                                                }


                                                if (isset($_POST['inserir'])) {
                                                    $mensagem = alerta("Erro.", "");
                                                    $periodo_inicio = exibirDataMysql($_POST["periodo_inicio"]);
                                                    $periodo_fim = exibirDataMysql($_POST["periodo_fim"]);
                                                    $orcado = dinheiroDeBr($_POST["orcado"]);
                                                    $contigenciado = dinheiroDeBr($_POST["contigenciado"]);
                                                    $sup_liberado = dinheiroDeBr($_POST["sup_liberado"]);
                                                    $empenhado = dinheiroDeBr($_POST["empenhado"]);
                                                    $reservado = dinheiroDeBr($_POST["reservado"]);
                                                    $disponivel = dinheiroDeBr($_POST["disponivel"]);
                                                    $ano_base = $_POST["ano_base"];
                                                    $relato = $_POST["relato"];

                                                    $sql_inserir = "INSERT INTO `sc_ind_orcamento` (`id`, `periodo_inicio`, `periodo_fim`, `orcado`, `contigenciado`, `sup_liberado`, `empenhado`, `reservado`, `disponivel`, `ano_base`,`relato`, `idUsuario`, `atualizacao`, `publicado`) VALUES (NULL, '$periodo_inicio', '$periodo_fim', '$orcado', '$contigenciado', '$sup_liberado', '$empenhado', '$reservado','$disponivel','$ano_base','$relato', '" . $user->ID . "', '" . date("Y-m-d") . "','1')";
                                                    //echo $sql_inserir;
                                                    $ins = $wpdb->query($sql_inserir);
                                                    if ($ins == 1) {
                                                        $mensagem = alerta("Relatório inserido com sucesso.", "success");
                                                    }
                                                }

                                                ?>
                                                <div class="row">
                                                    <div class="col-md-offset-2 col-md-8">
                                                        <h3>Orçamento - Listar Relatórios</h3>
                                                        <p><?php if (isset($mensagem)) {
                                                                echo $mensagem;
                                                            } ?></p>
                                                        <?php
                                                        // listar o evento;
                                                        // var_dump($ex);
                                                        ?>

                                                    </div>
                                                </div>

                                                <?php
                                                $sel = "SELECT * FROM sc_ind_orcamento WHERE publicado = '1' ORDER BY periodo_inicio DESC";
                                                $ocor = $wpdb->get_results($sel, ARRAY_A);
                                                if(count($ocor) > 0){
                                                ?>

                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>

                                                        </thead>
                                                        <tbody>
														<?php
														$ano = anoOrcamento(true);
                                                           
														for($i = 0; $i < count($ano); $i++){ //ano base
                                                          ?>
                                                                                                                   <tr>
                                                            <th width="18%">Período/Data</th>
                                                            <th>Orçado</th>
                                                            <th>Revisado</th>
                                                            <th>Liberado</th>
                                                            <th>Disponível/Saldo</th>
                                                            <th>% comprometido em relação ao disponível</th>

                                                            <th width="10%"></th>

                                                        </tr>
                                                           <?php
                                                            $ano_base = $ano[$i]['ano_base'];
                                                            for($m = 1; $m < 13; $m++){


                                                                   $orc = orcamentoDataTotal($ano_base,$m); 
                                                                     //var_dump($orc);   
																
																	echo "<tr><td>01/".fillZero($m,2)."/".$ano_base." a ".ultimoDiaMes($ano_base,$m)."/".fillZero($m,2)."/".$ano_base."</td>";
																	echo "<td>".$orc['orcado']."</td>";
																	echo "<td>".$orc['revisado']."</td>";
																	echo "<td>".$orc['liberado']."</td>";
																	echo "<td>".$orc['disponivel']."</td>";
                                                                    echo "<td>".$orc['liberado_revisado']."</td>";
																
																	echo "</tr>";
																	}
																
																
														}
															?>

														<!--
                                                        <?php
                                                        for ($i = 0; $i < count($ocor); $i++) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if ($ocor[$i]['periodo_fim'] != '0000-00-00') {
                                                                        echo " a " . exibirDataBr($ocor[$i]['periodo_fim']);
                                                                    } ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['orcado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['contigenciado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['sup_liberado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['orcado'] - $ocor[$i]['contigenciado'] + $ocor[$i]['sup_liberado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['empenhado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['reservado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['empenhado'] + $ocor[$i]['reservado']) ?></td>
                                                                <td><?php echo dinheiroParaBr($ocor[$i]['disponivel']) ?></td>
                                                                <td><?php echo dinheiroParaBr(($ocor[$i]['empenhado'] + $ocor[$i]['reservado']) / ($ocor[$i]['orcado'] - $ocor[$i]['contigenciado'] + $ocor[$i]['sup_liberado']) * 100) ?></td>

                                                                <td>
                                                                    <form method="POST" action="?p=editarorcamento"
                                                                          class="form-horizontal" role="form">
                                                                        <input type="hidden" name="editar"
                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                        <input type="submit"
                                                                               class="btn btn-theme btn-sm btn-block"
                                                                               value="Carregar">
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    <form method="POST" action="?p=listarorcamento"
                                                                          class="form-horizontal" role="form">
                                                                        <input type="hidden" name="apagar"
                                                                               value="<?php echo $ocor[$i]['id']; ?>"/>
                                                                        <input type="submit"
                                                                               class="btn btn-theme btn-sm btn-block"
                                                                               value="Apagar">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

										-->
                                                        </tbody>
                                                    </table>


                                                </div>

                                        </div>

                                        <?php } else { ?>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-8">
                                                <p> Não há relatórios cadastrados. </p>
                                            </div>
                                        </div>

                                        <?php } ?>


                                        <?php

                                        break;
                                        case "culturaz":

                                        function chamaAPI($url, $data)
                                        {
                                            $get_addr = $url . '?' . http_build_query($data);
                                            $ch = curl_init($get_addr);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                            $page = curl_exec($ch);
                                            $evento = json_decode($page);
                                            $ccsp = converterObjParaArray($evento);
                                            return $ccsp;

                                        }


                                        $url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
                                        $data = array(
                                            '@select' => 'createTimestamp'
                                        );



                                        $agente = chamaAPI($url_mapas . "agent/find/", $data);
                                        //$espaco = chamaAPI($url_mapas."space/find/",$data);
                                        //$projeto = chamaAPI($url_mapas."project/find/",$data);
                                        //$evento = chamaAPI($url_mapas."event/find/",$data);


                                        $k = array();

                                        for ($i = 0; $i < count($agente); $i++) {
                                            $x = exibirDataBr($agente[$i]['createTimestamp']['date']);
                                            //echo $i." : ".$x;
                                            $y = explode("/", $x);

                                            $k[$y[2]][$y[1]][$i] = $x;


                                        }

                                        echo "Total de agentes: " . count($k) . "<br />";
                                        echo "Total de Ft: " . sizeof($k) . "<br />";

                                        ?>


                                        <?php
                                        break;
                                        } // fim da switch p

                                        ?>

    </main>
    </div>
    </div>

<?php
include "footer.php";
?>