<?php
	/**
	 * 
	 * meio-notificacao.php
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
	if (!verificaSessao()){
		redireciona('?msg=2');
	} else {
		switch ($acao) {
			//Adicionar Meio de Notificações
			case 'adicionar' :
				if (verificaNivel(NIVELOPER)) {
					if (isset($_POST['adicionar'])) {
						$notificacaoVerifica = new meioNotificacao();
						if ($notificacaoVerifica -> verificaRegistro('titulo', trim($_POST["titulo"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_meio_notificacao_duplicado'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}
						if ($duplicado != TRUE) {
							$notificacao = new meioNotificacao( array(
								"titulo" => trim($_POST["titulo"])
							));						
							$notificacao -> adicionar($notificacao);
							if ($notificacao -> linhasafetadas == 1) {									
								$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_adicionar'];	
								$GLOBALS['msg_tipo'] = "SUCESSO";													
								salvaLog('MEIO_NOTIFICACAO', NULL, 'ADICIONAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_meio_notificacao_adicionar'].trim($_POST["titulo"]));						
								unset($_POST);
							} else {
								$GLOBALS['msg'] = $GLOBALS['text']['erro_cadastro_adicionar'];
								$GLOBALS['msg_tipo'] = "ERRO";							
							}							
						}		
					}
					loadTemplate('meio-notificacao-form');
				}else {
					redireciona('?msg=3');
				}
			break;

			//Listar Meio de Notificações
			case 'listar' :
				if (verificaNivel(NIVELOPER)) {
					loadTemplate('meio-notificacao-listar');
				} else {
					redireciona('?msg=3');
				}
			break;
	
			//Exibir Meio de Notificações
			case 'exibir' :
				if (verificaNivel(NIVELUSER)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$notificacao = new meioNotificacao();
						if ($notificacao->verificaRegistro('id', $_GET['id'])){
								$notificacao -> extras_select = "WHERE id=".$_GET['id'];							
								$notificacao -> selecionaTudo($notificacao);
								$dados = $notificacao->retornaDados();
								loadTemplate('meio-notificacao-form',$dados);											
						}else {
							redireciona('?m=meio-notificacao&a=listar&msg=7');
						}
					}else {
						redireciona('?m=meio-notificacao&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
	
			break;
		
			//Editar Meio de Notificações
			case 'editar' : 
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELOPER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$notificacaoVerifica = new meioNotificacao();
						//VERIFICA SE O ID EXISTE
						if ($notificacaoVerifica->verificaRegistro('id', $_GET['id'])) {							
							if (isset($_POST['editar'])) {
								if ($notificacaoVerifica -> verificaRegistro('titulo', trim($_POST["titulo"]))) {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_meio_notificacao_duplicada'];
									$GLOBALS['msg_tipo'] = "ERRO";
									$duplicado = TRUE;
								}
								if ($duplicado != TRUE) {								
									$notificacao = new meioNotificacao( array(
										"titulo" => trim($_POST["titulo"])
									));
									$notificacao -> valorpk = $_GET['id'];						
									$notificacao -> extras_select = "WHERE id=".$_GET['id'];						
									$notificacao -> atualizar($notificacao);
									if ($notificacao -> linhasafetadas == 1) {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar'];	
										$GLOBALS['msg_tipo'] = "SUCESSO";
										salvaLog('MEIO_NOTIFICACAO', NULL, 'EDITAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_meio_notificacao_editar'].trim($_POST["titulo"]));
										unset($_POST);
										redireciona('?m=meio-notificacao&a=listar&msg=10');						
									} else {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar_igual'];	
										$GLOBALS['msg_tipo'] = "ALERTA";
										unset($_POST);										
									}
								}
							}
							$notificacao = new meioNotificacao();
							$notificacao -> extras_select = "WHERE id=".$_GET['id'];							
							$notificacao -> selecionaTudo($notificacao);
							$dados = $notificacao->retornaDados();
							loadTemplate('meio-notificacao-form',$dados);							
						}else {
							redireciona('?m=meio-notificacao&a=listar&msg=7');
						}					
					}else {
						redireciona('?m=meio-notificacao&a=listar&msg=7');
					}					
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Excluir Meio de Notificações
			case 'excluir' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
							$notificacao = new meioNotificacao();
							if ($notificacao->verificaRegistro('id', $_GET['id'])){
								$notificacao -> valorpk = $_GET['id'];
								$notificacao -> extras_select = "WHERE id=".$_GET['id'];
								$notificacao -> selecionaTudo($notificacao);
								$dados = $notificacao->retornaDados();													
								if ($notificacao -> excluir($notificacao)) {
									if ($notificacao -> linhasafetadas == 1) {
										salvaLog('MEIO_NOTIFICACAO', NULL, 'EXCLUIR', 'SUCESSO', $GLOBALS['text']['logs_meio_notificacao_excluir'].trim($dados->titulo));
										redireciona('?m=meio-notificacao&a=listar&msg=9');					
									}
								} else {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_meio_notificacao_excluir'];
									$GLOBALS['msg_tipo'] = "ERRO";							
								}
							}else {
								redireciona('?m=meio-notificacao&a=listar&msg=7');
							}
						
					}else {
						redireciona('?m=meio-notificacao&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
			break;
		
			default :
				redireciona('?msg=6');
			break;
		}		
	}
	
?>
