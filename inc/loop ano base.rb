loop ano base
    ids dos orçamentos 
        loop dos id por mês

    loop do mês




total do mês = soma os ids do mês

	// Contigenciado (286)
    	// Anulado (394)
        	// Descontigenciado (287)
            	// Suplemento (288)

    	// Histórico de Contratação com Data
	$sel_hist_data = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data,idPedidoContratacao FROM sc_mov_orc WHERE dotacao = '$id' AND publicado = '1' AND data BETWEEN '$inicio' AND '$fim' AND tipo = '311' ORDER BY id ASC ";