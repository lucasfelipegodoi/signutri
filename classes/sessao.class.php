<?php
	/*
	 * sessao.class.php
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
	class sessao {
		protected $id;
		protected $nvars;
	
		public function __construct($inicia = true) {
			if ($inicia == TRUE) {
				$this -> start();
			}
		}
	
		public function start() {
			session_name(SESSIONNAME);
			if (!isset($_SESSION)) session_start();
			$this -> id = session_id();
			$this -> setNvars();
		}
	
		private function setNvars() {
			$this -> nvars = sizeof($_SESSION);
		}
	
		public function getNvars() {
			return $this -> nvars;
		}
	
		public function setVar($var, $valor) {
			$_SESSION[$var] = $valor;
			$this -> setNvars();
		}
	
		public function unsetVar($var) {
			unset($_SESSION[$var]);
		}
	
		public function getVar($var) {
			if (isset($_SESSION[$var])) {
				return $_SESSION[$var];
			} else {
				return NULL;
			}
		}
	
		public function destroy($inicia = false) {
			session_unset();
			session_destroy();
			$this -> setNvars();
			if ($inicia == TRUE) {
				$this -> start();
			}
		}
	
		public function printAll() {
			foreach ($_SESSION as $k => $v) {
				printf("%s = %s<br />", $k, $v);
			}
		}
	
	}
?>