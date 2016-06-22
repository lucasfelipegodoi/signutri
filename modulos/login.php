<?php
	/**
	 * login.php
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
	require_once (dirname(dirname(__FILE__)) . "/config/funcoes.php");
	protegeArquivo(basename(__FILE__));
	if (verificaSessao()) {
		redireciona();
	}
	if (isset($_POST['entrar'])) {
		$user = new usuarios();
		$user -> setValor('usuario', trim($_POST['usuario']));
		$user -> setValor('senha', trim($_POST['senha']));
		if ($user -> doLogin($user)) {
			redireciona();
		} 
	}
	loadTemplate('login');
?>
