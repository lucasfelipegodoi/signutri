<?php
	/**
	 * 
	 * beneficiarios.php
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
			//Adicionar Beneficiários
			case 'adicionar' :
				if (verificaNivel(NIVELOPER)) {
					if (isset($_POST['adicionar'])) {
						$nisVerifica = new beneficiarios();
						if ($nisVerifica -> verificaRegistro('nis', trim($_POST["nis"]))) {
							$GLOBALS['msg'] = $GLOBALS['text']['erro_nis_duplicado'];
							$GLOBALS['msg_tipo'] = "ERRO";
							$duplicado = TRUE;
						}
						if ($duplicado != TRUE) {
							$beneficiario = new beneficiarios( array(
								"data_atendimento" => geraDataSQL(trim($_POST["data"])),
								"nis" => trim($_POST["nis"]),
								"nome" => trim($_POST["nome"]),
								"gestante" => trim($_POST["gestante"]),
								"gestante_nome" => trim($_POST["gestante_nome"]),
								"gestante_dum" => geraDataSQL(trim($_POST["gestante_dum"])),
								"telefone" => trim($_POST["telefone"]),
								"celular" => trim($_POST["celular"]), 								
								"cep" => trim($_POST["cep"]),
								"endereco" => trim($_POST["endereco"]),								
								"numero" => trim($_POST["numero"]),
								"complemento" => trim($_POST["complemento"]),
								"bairro" => trim($_POST["bairro"]),
								"cidade" => trim($_POST["cidade"]),
								"unidade_saude_id" => trim($_POST["unidade_saude_id"]),
								"localizacao" => trim($_POST["localizacao"]),
								"ocorrencia_id" => trim($_POST["ocorrencia_id"]),
								"vigencia" => trim($_POST["vigencia"]),
								"vigencia_ano" => trim($_POST["vigencia_ano"]),
								"meio_notificacao_id" => trim($_POST["meio_notificacao_id"]),
								"observacoes" => trim($_POST["observacoes"])
							));						
							$beneficiario -> adicionar($beneficiario);
							if ($beneficiario -> linhasafetadas == 1) {									
								$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_adicionar'];	
								$GLOBALS['msg_tipo'] = "SUCESSO";													
								salvaLog('BENEFICIARIOS', NULL, 'ADICIONAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_nis_adicionar'].trim($_POST["nis"]));						
								unset($_POST);
							} else {
								$GLOBALS['msg'] = $GLOBALS['text']['erro_cadastro_adicionar'];
								$GLOBALS['msg_tipo'] = "ERRO";							
							}							
						}		
					}
					loadTemplate('beneficiarios-form');
				}else {
					redireciona('?msg=3');
				}
			break;

			//Listar Beneficiarios
			case 'listar' :
				if (verificaNivel(NIVELUSER)) {
					loadTemplate('beneficiarios-listar');
				} else {
					redireciona('?msg=3');
				}
			break;
	
			//Exibir Beneficiarios
			case 'exibir' :
				if (verificaNivel(NIVELUSER)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$beneficiario = new beneficiarios();
						if ($beneficiario->verificaRegistro('id', $_GET['id'])){
								$beneficiario -> extras_select = "WHERE id=".$_GET['id'];							
								$beneficiario -> selecionaTudo($beneficiario);
								$dados = $beneficiario->retornaDados();
								loadTemplate('beneficiarios-form',$dados);											
						}else {
							redireciona('?m=beneficiarios&a=listar&msg=7');
						}
					}else {
						redireciona('?m=beneficiarios&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Editar Beneficiarios
			case 'editar' : 
				//VERIFICA NÍVEL
				if (verificaNivel(NIVELOPER)) {
					//VERIFICA RECEBE O ID E SE ELE NÃO É NULO
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
						$beneficiarioID = new beneficiarios();
						//VERIFICA SE O ID EXISTE
						if ($beneficiarioID->verificaRegistro('id', $_GET['id'])) {
							if (isset($_POST['editar'])) {
								if ($_POST['vnis'] != $_POST['nis']) {
									if ($beneficiarioID -> verificaRegistro('nis', trim($_POST["nis"]))) {
										$GLOBALS['msg'] = $GLOBALS['text']['erro_nis_duplicado'];
										$GLOBALS['msg_tipo'] = "ERRO";
										$duplicado = TRUE;
									}									
								}
								if ($duplicado != TRUE) {																
									$beneficiario = new beneficiarios( array(
										"data_atendimento" => geraDataSQL(trim($_POST["data"])),
										"nis" => trim($_POST["nis"]),
										"nome" => trim($_POST["nome"]),
										"gestante" => trim($_POST["gestante"]),
										"gestante_nome" => trim($_POST["gestante_nome"]),
										"gestante_dum" => geraDataSQL(trim($_POST["gestante_dum"])),
										"telefone" => trim($_POST["telefone"]),
										"celular" => trim($_POST["celular"]), 								
										"cep" => trim($_POST["cep"]),
										"endereco" => trim($_POST["endereco"]),								
										"numero" => trim($_POST["numero"]),
										"complemento" => trim($_POST["complemento"]),
										"bairro" => trim($_POST["bairro"]),
										"cidade" => trim($_POST["cidade"]),
										"unidade_saude_id" => trim($_POST["unidade_saude_id"]),
										"localizacao" => trim($_POST["localizacao"]),
										"ocorrencia_id" => trim($_POST["ocorrencia_id"]),
										"vigencia" => trim($_POST["vigencia"]),
										"vigencia_ano" => trim($_POST["vigencia_ano"]),
										"meio_notificacao_id" => trim($_POST["meio_notificacao_id"]),
										"observacoes" => trim($_POST["observacoes"])
									));	
									$beneficiario -> valorpk = $_GET['id'];						
									$beneficiario -> extras_select = "WHERE id=".$_GET['id'];						
									$beneficiario -> atualizar($beneficiario);
									if ($beneficiario -> linhasafetadas == 1) {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar'];	
										$GLOBALS['msg_tipo'] = "SUCESSO";
										salvaLog('BENEFICIARIOS', NULL, 'EDITAR', $GLOBALS['msg_tipo'], $GLOBALS['text']['logs_nis_editar'].trim($_POST["nis"]));
										unset($_POST);					
									} else {
										$GLOBALS['msg'] = $GLOBALS['text']['msg_cadastro_editar_igual'];	
										$GLOBALS['msg_tipo'] = "ALERTA";
										unset($_POST);										
									}
								}
							}
							$beneficiarioID = new beneficiarios();
							$beneficiarioID -> extras_select = "WHERE id=".$_GET['id'];							
							$beneficiarioID -> selecionaTudo($beneficiarioID);
							$dados = $beneficiarioID->retornaDados();
							loadTemplate('beneficiarios-form',$dados);							
						}else {
							redireciona('?m=beneficiarios&a=listar&msg=7');
						}					
					}else {
						redireciona('?m=beneficiarios&a=listar&msg=7');
					}					
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Excluir Beneficiários
			case 'excluir' :
				if (verificaNivel(NIVELADMIN)) {
					if (isset($_GET['id']) && $_GET['id'] != NULL) {
							$beneficiario = new beneficiarios();
							if ($beneficiario->verificaRegistro('id', $_GET['id'])){
								$beneficiario -> valorpk = $_GET['id'];
								$beneficiario -> extras_select = "WHERE id=".$_GET['id'];
								$beneficiario -> selecionaTudo($beneficiario);
								$dados = $beneficiario->retornaDados();													
								if ($beneficiario -> excluir($beneficiario)) {
									if ($beneficiario -> linhasafetadas == 1) {
										salvaLog('BENEFICIARIOS', NULL, 'EXCLUIR', 'SUCESSO', $GLOBALS['text']['logs_nis_excluir'].trim($dados->nis));
										redireciona('?m=beneficiarios&a=listar&msg=9');					
									}
								} else {
									$GLOBALS['msg'] = $GLOBALS['text']['erro_nis_excluir'];
									$GLOBALS['msg_tipo'] = "ERRO";							
								}
							}else {
								redireciona('?m=beneficiarios&a=listar&msg=7');
							}
						
					}else {
						redireciona('?m=beneficiarios&a=listar&msg=7');
					}
				}else {
					redireciona('?msg=3');
				}
			break;
		
			//Redireciona com aviso de modulo inexistente
			default :
				redireciona('?msg=6');
			break;
		}		
	}
	
?>
