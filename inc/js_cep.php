<script type="text/javascript">
	$(document).ready(function(){	$("#CNPJ").mask("99.999.999/9999-99");});
</script>
<script type="text/javascript">$(document).ready(function(){	$("#cpf").mask("999.999.999-99");});</script>

<script type="text/javascript">
	$(document).ready( function() {
   /* Executa a requisição quando o campo CEP perder o foco */
   $('#CEP').blur(function(){
           /* Configura a requisição AJAX */
           $.ajax({
                url : 'ajax_cep.php', /* URL que será chamada */ 
                type : 'POST', /* Tipo da requisição */ 
                data: 'CEP=' + $('#CEP').val(), /* dado que será enviado via POST */
                dataType: 'json', /* Tipo de transmissão */
                success: function(data){
                    if(data.sucesso == 1){
                        $('#rua').val(data.rua);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.cidade);
                        $('#estado').val(data.estado);
						$('#sucesso').val(data.sucesso);
 
                        $('#numero').focus();
                    }else{
						$('#sucesso').val(0);
					}
                }
           });   
   return false;    
   })
});
	</script>
	
	