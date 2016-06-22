<?php
	/*
	 * beneficiarios.class.php
	 *
	 * SigNutri - Sistema de Gestão da Nutrição
	 * Projeto desenvolvido para a Secretaria de
	 * Saúde de Campos dos Goytacazes.
	 *
	 * Versão: 1.0
	 * Criado: Campos dos Goytacazes, 1 de dezembro de 2013
	 * Desenvolvido por: Marcus Ribeiro Perrout
	 * E-mail: contato@perrout.com.br
	 * 
	 */
	// Proibe a abertura do arquivo diretamente.
	require_once (dirname(__FILE__) . '/autoload.php');
	protegeArquivo(basename(__FILE__));
	class beneficiarios extends base {
		public function __construct($campos = array()) {
			parent::__construct();
			$this -> tabela = "beneficiarios";
			if (sizeof($campos) <= 0) {
				$this -> campos_valores = array(
					"id" => NULL, 
					"data_atendimento" => NULL,
					"nis" => NULL,
					"nome" => NULL,
					"gestante" => NULL,
					"gestante_nome" => NULL,
					"gestante_dum" => NULL,
					"telefone" => NULL,
					"celular" => NULL, 
					"cep" => NULL, 
					"endereco" => NULL,
					"numero" => NULL,
					"bairro" => NULL,
					"cidade" => NULL,
					"unidade_saude_id" => NULL,
					"localizacao" => NULL,
					"ocorrencia_id" => NULL,
					"vigencia" => NULL,
					"vigencia_ano" => NULL,
					"meio_notificacao_id" => NULL,
					"observacoes" => NULL);
			} else {
				$this -> campos_valores = $campos;
			}
			$this -> campopk = "id";
		}
				
	} //Fim da Classe Beneficiarios
?>