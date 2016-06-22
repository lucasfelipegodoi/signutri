<?php
	/**
	 * 
	 * usuarios.php
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
			//Cadastrar Usuários
			case 'adicionar' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_POST['adicionar'])) {
						$userVerifica = new usuarios();
						if ($userVerifica -> verificaRegistro('usuario', trim($_POST["usuario"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_usuario_duplicado'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}
						if ($userVerifica -> verificaRegistro('email', trim($_POST["email"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_usuario_email_duplicado'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}			
						if ($duplicado != TRUE) {
							$user = new usuarios( array(
								"nome" => trim($_POST["nome"]), 
								"email" => trim($_POST["email"]),
								"telefone" => trim($_POST["telefone"]),								
								"celular" => trim($_POST["celular"]),							
								"usuario" => trim($_POST["usuario"]),
								"senha" => codificaSenha(trim($_POST["senhaNova"])), 
								"nivel" => trim($_POST["nivel"])
							));						
							$user -> adicionar($user);
							if ($user -> linhasafetadas == 1) {									
								$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_adicionar'];	
								$GLOBALS['msg_tipo'] = "SUCESSO";													
								salvaLog('USUÁRIOS', NULL, 'ADICIONAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_usuario_adicionar'].trim($_POST['nome'].' ('.$_POST['usuario'].')'));						
								unset($_POST);
							} else {
								$GLOBALS['msg'] = $GLOBALS['text']['erro_cadastro_adicionar'];
								$GLOBALS['msg_tipo'] = "ERRO";						
							}							
						}		
					}
					loadTemplate('usuarios-form');
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Listar Usuários
			case 'listar' :
				if (verificaNivel(NIVELADMIN)) {
					loadTemplate('usuarios-listar');
				} else {
					redireciona('?msg=3');
				}
			break;
					
			//Exibir Usuários
			case 'exibir' :
				if (verificaNivel(NIVELUSER)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$user = new usuarios();
						if ($user->verificaRegistro('id', $_GET['id'])){
								$user -> extras_select = "WHERE id=".$_GET['id'];							
								$user -> selecionaTudo($user);
								$dados = $user->retornaDados();
								loadTemplate('usuarios-form',$dados);											
						}else {
							redireciona('?m=usuarios&a=listar&msg=7');
						}
					}else {
						redireciona('?m=usuarios&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}	
			break;
								
			//Editar Usuários
			case 'editar' : 
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELUSER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						//VERIFICA ID DO ADMIN
						if ($_GET['id'] == 1 && !verificaID('1')){
							redireciona('?m=usuarios&a=listar&msg=3');
						}else {
							$userVerifica = new usuarios();
							//VERIFICA SE O ID EXISTE
							if ($userVerifica->verificaRegistro('id', $_GET['id'])) {
								//VERIFICA SE É ADMIN OU SE O ID É IGUAL DO USUÁRIO
								if (verificaNivel(NIVELADMIN) || verificaID($_GET['id'])) {
									if (isset($_POST['editar'])) {
										$user = new usuarios( array(
											"nome" => trim($_POST["nome"]), 
											"email" => trim($_POST["email"]),
											"telefone" => trim($_POST["telefone"]),
											"celular" => trim($_POST["celular"]),
											"nivel" => trim($_POST["nivel"]),
											"status" => trim($_POST["status"])
										));	
										$user -> valorpk = $_GET['id'];
										$user -> extras_select = "WHERE id=".$_GET['id'];						
										$user -> atualizar($user);
										if ($user -> linhasafetadas == 1) {
											$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar'];	
											$GLOBALS['msg_tipo'] = "SUCESSO";
											salvaLog('USUÁRIOS', NULL, 'EDITAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_usuario_editar'].trim($_POST['nome'].' ('.$_POST['usuario'].')'));	
											unset($_POST);					
										} else {
											$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar_igual'];	
											$GLOBALS['msg_tipo'] = "ALERTA";
											unset($_POST);										
										}
									}
									$user = new usuarios();
									$user -> extras_select = "WHERE id=".$_GET['id'];							
									$user -> selecionaTudo($user);
									$dados = $user->retornaDados();
									loadTemplate('usuarios-form',$dados);							
								}else {
									redireciona('?msg=3');
								}					
							}else {
								redireciona('?m=usuarios&a=listar&msg=7');
							}
						}
					}else {
						redireciona('?m=usuarios&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Alterar Senha
			case 'senha' :
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELUSER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						//VERIFICA ID DO ADMIN
						if ($_GET['id'] == 1 && !verificaID('1')){
							redireciona('?m=usuarios&a=listar&msg=3');
						}else {
							$userVerifica = new usuarios();
							//VERIFICA SE O ID EXISTE
							if ($userVerifica->verificaRegistro('id', $_GET['id'])) {
								//VERIFICA SE É ADMIN OU SE O ID É IGUAL DO USUÁRIO
								if (verificaNivel(NIVELADMIN) || verificaID($_GET['id'])) {
									if (isset($_POST['senha'])) {
										$user = new usuarios( array( 
											"senha" => codificaSenha($_POST["senhaNova"])
										));	
										$user -> valorpk = $_GET['id'];
										$user -> extras_select = "WHERE id=".$_GET['id'];
										$user -> selecionaTudo($user);
										$userVerifica = $user -> retornaDados();
										if (isset($_POST["senhaAtual"]) && $userVerifica -> senha != codificaSenha(trim($_POST["senhaAtual"]))) {
											redireciona('?m=usuarios&a=senha&id='.$_GET['id'].'&msg=12'); 
										}else {
											$user -> atualizar($user);
											if ($user -> linhasafetadas == 1) {
												salvaLog('USUÁRIOS', NULL, 'EDITAR', 'SUCESSO', $GLOBALS['text']['logs_usuario_editar_senha'].trim($_POST['nome'].' ('.$_POST['usuario'].')'));			
												if (verificaID($_GET['id'])) {
													redireciona('?m=usuarios&a=editar&id='.$_GET['id'].'&msg=10'); 
												}else {
													redireciona('?m=usuarios&a=listar&msg=10');
												}
											} else {
												if (verificaID($_GET['id'])) {
													redireciona('?m=usuarios&a=editar&id='.$_GET['id'].'&msg=11'); 
												}else {
													redireciona('?m=usuarios&a=listar&msg=11');
												}							
											}
										}
									}
									$user = new usuarios();
									$user -> extras_select = "WHERE id=".$_GET['id'];							
									$user -> selecionaTudo($user);
									$dados = $user->retornaDados();
									loadTemplate('usuarios-form',$dados);							
								}else {
									redireciona('?msg=3');
								}					
							}else {
								redireciona('?m=usuarios&a=listar&msg=7');
							}
						}
					}else {
						redireciona('?m=usuarios&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
			break;

			//Excluir Usuários
			case 'excluir' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						if ($_GET['id'] == 1){
							redireciona('?m=usuarios&a=listar&msg=8');
						}else {
							$userVerifica = new usuarios();
							if ($userVerifica->verificaRegistro('id', $_GET['id'])){
								$user = new usuarios();
								$user -> valorpk = $_GET['id'];
								$user -> extras_select = "WHERE id=".$_GET['id'];	
								$user -> selecionaTudo($user);
								$dados = $user->retornaDados();					
								if ($user -> excluir($user)) {
									if ($user -> linhasafetadas == 1) {
										salvaLog('USUÁRIOS', NULL, 'EXCLUIR', 'SUCESSO', $GLOBALS['text']['logs_usuario_excluir'].trim($dados->nome.' ('.$dados->usuario.')'));
										redireciona('?m=usuarios&a=listar&msg=9');					
									}
								} else {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_usuarios_excluir'];
									$GLOBALS['msg_tipo'] = "ERRO";							
								}
							}else {
								redireciona('?m=usuarios&a=listar&msg=7');
							}
						}
					}else {
						redireciona('?m=usuarios&a=listar&msg=7');
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
