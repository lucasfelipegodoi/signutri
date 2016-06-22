<?php
	/*
	 * base.class.php
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
	require_once(dirname(__FILE__).'/autoload.php');
	protegeArquivo(basename(__FILE__));
	abstract class base extends banco {
		//Propriedades
		public $tabela 			= 	"";
		public $campos_valores 	= 	array();
		public $campopk 		= 	NULL;
		public $valorpk			=	NULL;
		public $extras_select 	= 	"";

		//Métodos
		public function addCampo($campo=NULL,$valor=NULL){
			if($campo != NULL){
				$this->campos_valores[$campo] = $valor;
			}
		} //addCampo
		
		public function delCampo($campo){
			if(array_key_exists($campo,$this->campos_valores)){
				unset($this->campos_valores[$campo]);
			}
		} //delCampo
		
		public function setValor($campo=NULL,$valor=NULL){
			if($campo!=NULL && $valor!=NULL){
				$this->campos_valores[$campo] = $valor;
			}
		} //setValor
		
		public function getValor($campo=NULL){
			if($campo!=NULL && array_key_exists($campo,$this->campos_valores)){
				return $this->campos_valores[$campo];
			}else{
				return FALSE;
			}
		} //getValor
		
	} // Fim Class Base
?>