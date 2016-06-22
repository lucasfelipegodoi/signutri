<?php
	/**
	 * mensagens.php
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
	require_once (dirname(dirname(__FILE__))."/config/funcoes.php");
	protegeArquivo(basename(__FILE__));
	switch($_GET['msg']) {
		case 1 :
			printMSG('LOGOUT EFETUADO COM SUCESSO', 'SUCESSO');
		break;
		
		case 2 :
			printMSG('FAÇA LOGIN ANTES DE CONTINUAR', 'ALERTA');
		break;

		case 3:
			printMSG('USUÁRIO SEM PERMISSÃO', 'ERRO');
		break;

		case 4:
			printMSG('ESTE ARQUIVO NÃO PODE SER ACESSADO', 'ERRO');
		break;

		case 5:
			printMSG('ESTA PASTA NÃO PODE SER ACESSADA', 'ERRO');
		break;
		
		case 6:
			printMSG('ESTE MODULO NÃO EXISTE', 'ERRO');
		break;

		case 7:
			printMSG('ESTE CADASTRO NÃO EXISTE', 'ERRO');
		break;
		
		case 8:
			printMSG('ESTE CADASTRO NÃO PODE SER EXCLUÍDO', 'ALERTA');
		break;
	
		case 9:
			printMSG('CADASTRO EXCLUÍDO COM SUCESSO', 'SUCESSO');
		break;

		case 10:
			printMSG('CADASTRO ALTERADO COM SUCESSO', 'SUCESSO');
		break;

		case 11:
			printMSG('NENHUM DADO FOI ALTERADO', 'ALERTA');
		break;

		case 12:
			printMSG('A SENHA ATUAL NÃO CONFERE', 'ERRO');
		break;
		
		case 13:
			printMSG('CBO JÁ CADASTRADA', 'ALERTA');
		break;

		case 14:
			printMSG('CBO CADASTRADA COM SUCESSO', 'SUCESSO');
		break;

		case 15:
			printMSG('ERRO AO ADICIONAR NOVA FUNÇÃO', 'ERRO');
		break;
												
		case 20 :
			printMSG('Sistema em manutenção. Por favor, aguarde alguns minutos.', 'ALERTA');
		break;	
		
	}
?>