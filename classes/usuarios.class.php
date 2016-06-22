<?php
	/*
	 * usuarios.class.php
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
	class usuarios extends base {
		public function __construct($campos = array()) {
			parent::__construct();
			$this -> tabela = "usuarios";
			if (sizeof($campos) <= 0) {
				$this -> campos_valores = array(
					"id" => NULL, 
					"nome" => NULL,
					"email" => NULL,
					"telefone" => NULL,
					"celular" => NULL,
					"usuario" => NULL,  
					"senha" => NULL, 
					"nivel" => NULL, 
					"status" => NULL, 
					"acessado" => NULL);
			} else {
				$this -> campos_valores = $campos;
			}
			$this -> campopk = "id";
		}
	
		// Login
		public function doLogin($objeto) {
			$this -> usuario = $objeto -> getValor('usuario');
			$this -> senha = codificaSenha($objeto -> getValor('senha'));
			$objeto -> extras_select = "WHERE usuario='".$this->usuario."'";
			$this -> selecionaTudo($objeto);
			if ($this -> linhasafetadas == 1) {
				$userLogado = $objeto -> retornaDados();
				if ($userLogado->senha != $this->senha){
					$GLOBALS['msg'] = $GLOBALS['text']['erro_login_senha'];
					$GLOBALS['msg_tipo'] = "ERRO";
					salvaLog('USUÁRIOS', $this->usuario, 'LOGIN', $GLOBALS['msg_tipo'], $GLOBALS['msg']);
					return FALSE;				
				}	
				if ($userLogado->status == 0) {
					$GLOBALS['msg'] = $GLOBALS['text']['erro_login_inativo'];
					$GLOBALS['msg_tipo'] = "ERRO";
					salvaLog('USUÁRIOS', $this->usuario, 'LOGIN', $GLOBALS['msg_tipo'], $GLOBALS['msg']);
					return FALSE;			
				}
				if (!isset($erro)){				
					$user = new usuarios( array("acessado" => date("Y-m-d H:i:s")));
					$user -> campopk = "usuario";
					$user -> valorpk = $userLogado->usuario;
					$user -> atualizar($user);
					if ($user -> linhasafetadas == 1) {
						$sessao = new sessao();		
						$sessao -> setVar('userid', $userLogado -> id);
						$sessao -> setVar('usernome', $userLogado -> nome);
						$sessao -> setVar('userlogin', $userLogado -> usuario);
						$sessao -> setVar('usernivel', $userLogado -> nivel);
						$sessao -> setVar('userlogado', TRUE);
						$sessao -> setVar('userip', $_SERVER['REMOTE_ADDR']);
						salvaLog('USUÁRIOS', $this->usuario, 'LOGIN', 'SUCESSO', $GLOBALS['text']['msg_login']);
						return TRUE;
					} else {
						$GLOBALS['msg'] = $GLOBALS['text']['erro_login_atualizar'];
						$GLOBALS['msg_tipo'] = "ERRO";
						return FALSE;
					}
				}
			} else {
				$GLOBALS['msg'] = $GLOBALS['text']['erro_login_usuario'];
				$GLOBALS['msg_tipo'] = "ERRO";
				salvaLog('USUARIOS', $this->usuario, 'LOGIN', $GLOBALS['msg_tipo'], $GLOBALS['msg']);
				return FALSE;
			}
		}
		
		// Logout
		public function doLogout() {
			salvaLog('USUARIOS', NULL, 'LOGOUT', 'SUCESSO', $GLOBALS['text']['msg_logout']);	
			$sessao = new sessao();
			$sessao -> destroy(TRUE);
			redireciona('?msg=1');
		}
				
	} //Fim da Classe Usuarios
?>