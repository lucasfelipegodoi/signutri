<?php
	/**
	 * 
	 * ocorrencias.php
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
			//Adicionar Ocorrências
			case 'adicionar' :
				if (verificaNivel(NIVELOPER)) {
					if (isset($_POST['adicionar'])) {
						$ocorrenciaVerifica = new ocorrencias();
						if ($ocorrenciaVerifica -> verificaRegistro('titulo', trim($_POST["titulo"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_ocorrencia_duplicada'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}
						if ($duplicado != TRUE) {
							$ocorrencia = new ocorrencias( array(
								"localizacao" => trim($_POST["localizacao"]),
								"titulo" => trim($_POST["titulo"])
							));						
							$ocorrencia -> adicionar($ocorrencia);
							if ($ocorrencia -> linhasafetadas == 1) {									
								$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_adicionar'];	
								$GLOBALS['msg_tipo'] = "SUCESSO";													
								salvaLog('OCORRENCIAS', NULL, 'ADICIONAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_ocorrencia_adicionar'].trim($_POST["titulo"]));						
								unset($_POST);
							} else {
								$GLOBALS['msg'] = $GLOBALS['text']['erro_cadastro_adicionar'];
								$GLOBALS['msg_tipo'] = "ERRO";							
							}							
						}		
					}
					loadTemplate('ocorrencias-form');
				}else {
					redireciona('?msg=3');
				}
			break;

			//Listar Ocorrências
			case 'listar' :
				if (verificaNivel(NIVELOPER)) {
					loadTemplate('ocorrencias-listar');
				} else {
					redireciona('?msg=3');
				}
			break;
	
			//Exibir Ocorrências
			case 'exibir' :
				if (verificaNivel(NIVELUSER)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$ocorrencia = new ocorrencias();
						if ($ocorrencia->verificaRegistro('id', $_GET['id'])){
								$ocorrencia -> extras_select = "WHERE id=".$_GET['id'];							
								$ocorrencia -> selecionaTudo($ocorrencia);
								$dados = $ocorrencia->retornaDados();
								loadTemplate('ocorrencias-form',$dados);											
						}else {
							redireciona('?m=ocorrencias&a=listar&msg=7');
						}
					}else {
						redireciona('?m=ocorrencias&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
	
			break;
		
			//Editar Ocorrências
			case 'editar' : 
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELOPER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$ocorrenciaVerifica = new ocorrencias();
						//VERIFICA SE O ID EXISTE
						if ($ocorrenciaVerifica->verificaRegistro('id', $_GET['id'])) {							
							if (isset($_POST['editar'])) {
								if ($ocorrenciaVerifica -> verificaRegistro('titulo', trim($_POST["titulo"]))) {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_ocorrencia_duplicada'];
									$GLOBALS['msg_tipo'] = "ERRO";
									$duplicado = TRUE;
								}
								if ($duplicado != TRUE) {								
									$ocorrencia = new ocorrencias( array(
										"localizacao" => trim($_POST["localizacao"]),
										"titulo" => trim($_POST["titulo"])
									));
									$ocorrencia -> valorpk = $_GET['id'];						
									$ocorrencia -> extras_select = "WHERE id=".$_GET['id'];						
									$ocorrencia -> atualizar($ocorrencia);
									if ($ocorrencia -> linhasafetadas == 1) {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar'];	
										$GLOBALS['msg_tipo'] = "SUCESSO";
										salvaLog('OCORRENCIAS', NULL, 'EDITAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_ocorrencia_editar'].trim($_POST["titulo"]));
										unset($_POST);
										redireciona('?m=ocorrencias&a=listar&msg=10');						
									} else {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar_igual'];	
										$GLOBALS['msg_tipo'] = "ALERTA";
										unset($_POST);										
									}
								}
							}
							$ocorrencia = new ocorrencias();
							$ocorrencia -> extras_select = "WHERE id=".$_GET['id'];							
							$ocorrencia -> selecionaTudo($ocorrencia);
							$dados = $ocorrencia->retornaDados();
							loadTemplate('ocorrencias-form',$dados);							
						}else {
							redireciona('?m=ocorrencias&a=listar&msg=7');
						}					
					}else {
						redireciona('?m=ocorrencias&a=listar&msg=7');
					}					
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Excluir Ocorrências
			case 'excluir' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
							$ocorrencia = new ocorrencias();
							if ($ocorrencia->verificaRegistro('id', $_GET['id'])){
								$ocorrencia -> valorpk = $_GET['id'];
								$ocorrencia -> extras_select = "WHERE id=".$_GET['id'];
								$ocorrencia -> selecionaTudo($ocorrencia);
								$dados = $ocorrencia->retornaDados();													
								if ($ocorrencia -> excluir($ocorrencia)) {
									if ($ocorrencia -> linhasafetadas == 1) {
										salvaLog('OCORRENCIAS', NULL, 'EXCLUIR', 'SUCESSO', $GLOBALS['text']['logs_ocorrencia_excluir'].trim($dados->titulo));
										redireciona('?m=ocorrencias&a=listar&msg=9');					
									}
								} else {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_ocorrencia_excluir'];
									$GLOBALS['msg_tipo'] = "ERRO";							
								}
							}else {
								redireciona('?m=ocorrencias&a=listar&msg=7');
							}
						
					}else {
						redireciona('?m=ocorrencias&a=listar&msg=7');
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
