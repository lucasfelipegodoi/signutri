<?php
	/**
	 * 
	 * unidades-saude.php
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
			//Adicionar Unidades de Saúde
			case 'adicionar' :
				if (verificaNivel(NIVELOPER)) {
					if (isset($_POST['adicionar'])) {
						$unidadeVerifica = new unidadesSaude();
						if ($unidadeVerifica -> verificaRegistro('nome', trim($_POST["nome"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_unidade_saude_duplicada'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}
						if ($duplicado != TRUE) {
							$unidade = new unidadesSaude( array(
								"nome" => trim($_POST["nome"]),
								"telefone" => trim($_POST["telefone"])
							));						
							$unidade -> adicionar($unidade);
							if ($unidade -> linhasafetadas == 1) {									
								$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_adicionar'];	
								$GLOBALS['msg_tipo'] = "SUCESSO";													
								salvaLog('UNIDADES_SAUDE', NULL, 'ADICIONAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_unidade_saude_adicionar'].trim($_POST["nome"]));						
								unset($_POST);
							} else {
								$GLOBALS['msg'] = $GLOBALS['text']['erro_cadastro_adicionar'];
								$GLOBALS['msg_tipo'] = "ERRO";							
							}							
						}		
					}
					loadTemplate('unidades-saude-form');
				}else {
					redireciona('?msg=3');
				}
			break;

			//Listar Unidades de Saúde
			case 'listar' :
				if (verificaNivel(NIVELOPER)) {
					loadTemplate('unidades-saude-listar');
				} else {
					redireciona('?msg=3');
				}
			break;
	
			//Exibir Unidades de Saúde
			case 'exibir' :
				if (verificaNivel(NIVELUSER)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$unidade = new unidadesSaude();
						if ($unidade->verificaRegistro('id', $_GET['id'])){
								$unidade -> extras_select = "WHERE id=".$_GET['id'];							
								$unidade -> selecionaTudo($unidade);
								$dados = $unidade->retornaDados();
								loadTemplate('unidades-saude-form',$dados);											
						}else {
							redireciona('?m=unidades-saude&a=listar&msg=7');
						}
					}else {
						redireciona('?m=unidades-saude&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
	
			break;
		
			//Editar Unidades de Saúde
			case 'editar' : 
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELOPER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$unidadeVerifica = new unidadesSaude();
						//VERIFICA SE O ID EXISTE
						if ($unidadeVerifica->verificaRegistro('id', $_GET['id'])) {							
							if (isset($_POST['editar'])) {
								if ($unidadeVerifica -> verificaRegistro('nome', trim($_POST["nome"]))) {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_unidade_saude_duplicada'];
									$GLOBALS['msg_tipo'] = "ERRO";
									$duplicado = TRUE;
								}
								if ($duplicado != TRUE) {								
									$unidade = new unidadesSaude( array(
										"nome" => trim($_POST["nome"]),
										"telefone" => trim($_POST["telefone"]) 
									));
									$unidade -> valorpk = $_GET['id'];						
									$unidade -> extras_select = "WHERE id=".$_GET['id'];						
									$unidade -> atualizar($unidade);
									if ($unidade -> linhasafetadas == 1) {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar'];	
										$GLOBALS['msg_tipo'] = "SUCESSO";
										salvaLog('UNIDADES_SAUDE', NULL, 'EDITAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_unidade_saude_editar'].trim($_POST["nome"]));
										unset($_POST);
										redireciona('?m=unidades-saude&a=listar&msg=10');						
									} else {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar_igual'];	
										$GLOBALS['msg_tipo'] = "ALERTA";
										unset($_POST);										
									}
								}
							}
							$unidade = new unidadesSaude();
							$unidade -> extras_select = "WHERE id=".$_GET['id'];							
							$unidade -> selecionaTudo($unidade);
							$dados = $unidade->retornaDados();
							loadTemplate('unidades-saude-form',$dados);							
						}else {
							redireciona('?m=unidades-saude&a=listar&msg=7');
						}					
					}else {
						redireciona('?m=unidades-saude&a=listar&msg=7');
					}					
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Excluir Unidades de Saúde
			case 'excluir' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
							$unidade = new unidadesSaude();
							if ($unidade->verificaRegistro('id', $_GET['id'])){
								$unidade -> valorpk = $_GET['id'];
								$unidade -> extras_select = "WHERE id=".$_GET['id'];
								$unidade -> selecionaTudo($unidade);
								$dados = $unidade->retornaDados();													
								if ($unidade -> excluir($unidade)) {
									if ($unidade -> linhasafetadas == 1) {
										salvaLog('UNIDADES_SAUDE', NULL, 'EXCLUIR', 'SUCESSO', $GLOBALS['text']['logs_unidade_saude_excluir'].trim($dados->nome));
										redireciona('?m=unidades-saude&a=listar&msg=9');					
									}
								} else {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_unidade_saude_excluir'];
									$GLOBALS['msg_tipo'] = "ERRO";							
								}
							}else {
								redireciona('?m=unidades-saude&a=listar&msg=7');
							}
						
					}else {
						redireciona('?m=unidades-saude&a=listar&msg=7');
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
