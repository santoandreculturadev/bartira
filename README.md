# BARTIRA SISTEMA UNIFICADO DEINFORMAÇÕES CULTURAIS
# SCPSA - Secretária de Cultura Prefeitura de Santo Andre


Bartira  é  uma  plataforma  deintranet  implantada  em  2017especialmente  para  atender  àsnecessidades  da  Secretaria  deCultura relativas ao gerenciamentode procedimentos internos. É de usoexclusivo  dos  funcionários  daSecretaria e administra informaçõesde   orçamento,   planejamento,execução  orçamentária,  divulgaçãoe indicadores culturais. É a principalfonte de entrada de dados e a partirde  onde  derivam  as  informaçõespara  plataformas  como  a  AgendaCultural Online e o CulturAZ.

Através do “Bartira” estabelecemosa  integração  dos  dados  culturaiscom  outros  sistemas  e  bases  dedados da Prefeitura Municipal, taiscomo   o   SIGA   (Sistema   deInformações GeográficasAndreense)  e  o  BDM  (Banco  deDados Municipais)

Modelagem "Atividade" (não é evento);

titulo VARCHAR(250)
descricao LONGTEXT
responsavel INT
projeto INT
programa INT
periodo_inicio DATE
periodo_fim DATE
ano_base INT(4)



Empenho fracionado


Modelagem "Orçamento"

titulo VARCHAR(250)
projeto INT
ficha INT
dotacao VARCHAR
fonte VARCHAR
valor Double
data_liberacao DATE

Modelagem movimentação orçamentária
titulo VARCHAR(250)
tipo (INT) / Tipo
	+ contigenciamento
	+ descontigenciamento
	+ suplementado
data DATE
valor Double


contratação artística 
contratação de infraestrutura

Modelagem ATA


Hierarquia de Status

Evento 
	-> "Elaboração" dataEnvio = NULL
	-> "Enviado" dataEnvio = NOT NULL
	-> "Cultura Z" = dataEnvio = NOT NULL AND Liberado NOT NULL
	
Pedido de Contratação 
	-> "Elaboração" dataEnvio = NULL (não visível no sistema)
	-> "Em análise" dataEnvio = NOT NULL (vísivel no sistema)
	-> "Liberado"  dataEnvio = NOT NULL AND liberado = NOT NULL
	-> "Empenhado" dataEnvio = NOT NULL AND liberado NOT NULL AND empenhado = NOT NULL

