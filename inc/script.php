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
                        $('#Endereco').val(data.rua);
                        $('#Bairro').val(data.bairro);
                        $('#Cidade').val(data.cidade);
                        $('#Estado').val(data.estado);
						$('#Sucesso').val(data.sucesso);
 
                        $('#Numero').focus();
                    }else{
						$('#Sucesso').val(0);
					}
                }
           });   
   return false;    
   })
});
	</script>