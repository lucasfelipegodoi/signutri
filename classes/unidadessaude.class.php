<?php
	/*
	 * unidadessaude.class.php
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
	class unidadesSaude extends base {
		public function __construct($campos = array()) {
			parent::__construct();
			$this -> tabela = "unidades_saude";
			if (sizeof($campos) <= 0) {
				$this -> campos_valores = array(
					"id" => NULL,
					"nome" => NULL, 
					"telefone" => NULL);					
			} else {
				$this -> campos_valores = $campos;
			}
			$this -> campopk = "id";
		}
				
	} //Fim da Unidades de Saúde
?>