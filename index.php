<?php
	/*
	 * index.php
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
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	ini_set('display_errors', '0');
	require_once ("config/funcoes.php");
	if (SISSTATUS) {
		loadConfig('mensagens', '10');
	} else {
		getIncludePage();
	}
?>

