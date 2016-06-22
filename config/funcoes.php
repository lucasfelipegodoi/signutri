<?php
	/**
	 * funcoes.php
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
	//Verifica a instação do sistema
	inicializa();
	protegeArquivo(basename(__FILE__));
	function inicializa() {
		if (file_exists(dirname(__FILE__) . '/config.php')) {
			require_once (dirname(__FILE__) . '/config.php');
		} else {
			die('O aquivo de configuração não foi localizado.');
		}
		$constantes = array('BASEPATH', 'BASEURL', 'CLASSESPATH', 'MODULOSPATH', 'IMAGENSPATH', 'CSSPATH', 'JSPATH', 'TEMPLATEPATH', 'DBHOST', 'DBUSER', 'DBPASS', 'DBNAME', 'SISNAME', 'SISTITLE', 'SISDESC', 'SISAUTHOR');
		foreach ($constantes as $valor) {
			if (!defined($valor)) {
				die('<strong>' . $valor . ' </strong>Não definido na configuração do sistema.');
			}
		}
		require_once (BASEPATH . CLASSESPATH . 'autoload.php');
	}
	
	// Carrega a pagina
	function getIncludePage(){	   
	   $file = MODULOSPATH.SISMODULO;
	   if(file_exists($file.".php")){
	   		loadModulo(SISMODULO, SISACAO);
	   }else{
			redireciona('?msg=6');
	   }	   
	}
	 
	//Carrega as Configurações
	function loadConfig($config, $msg) {
		if (file_exists(CONFIGPATH . "$config.php")) {
			include_once (CONFIGPATH . "$config.php");
		} else {
			echo '<p>Configuração inexistente no sistema!</p>';
		}
	}
	
	//Carrega os CSS
	function loadCSS($arquivo = NULL, $media = 'screen', $import = FALSE) {
		if ($arquivo != NULL) {
			if ($import == TRUE) {
				echo '<style type="text/css">@import url("' . BASEURL . CSSPATH . $arquivo . '.css");</style>' . "\n";
			} else {
				echo '<link rel="stylesheet" type="text/css" href="' . BASEURL . CSSPATH . $arquivo . '.css" media="' . $media . '" />' . "\n";
			}
		}
	}
	
	//Carrega os JS
	function loadJS($arquivo = NULL, $remoto = FALSE) {
		if ($arquivo == NULL) {
			echo '<p>Erro na funcão <strong>' . __FUNCTION__ . '</strong>: faltam parâmetros para execução.</p>';
		} else {	
			if ($remoto == FALSE) {
				$arquivo = BASEURL . JSPATH . $arquivo . ".js";
			}
			echo '<script type="text/javascript" src="' . $arquivo . '" ></script>' . "\n";
		}
	}
	
	//Carrega os Modulos
	function loadModulo($modulo = NULL, $acao = NULL) {
		if ($modulo == NULL) {
			echo '<p>Erro na funcão <strong>' . __FUNCTION__ . '</strong>: faltam parâmetros para execução.</p>';
		} else {
			if (file_exists(MODULOSPATH . "$modulo.php")) {
				include_once (MODULOSPATH . "$modulo.php");
			} else {
				echo '<p>Módulo inexistente no sistema!</p>';
			}
		}
	}
	
	//Carrega os Templates
	function loadTemplate($template = NULL, $dados = NULL) {
		if ($template == NULL) {
			echo '<p>Erro na funcão <strong>' . __FUNCTION__ . '</strong>: faltam parâmetros para execução.</p>';
		} else {
			if (file_exists(TEMPLATEPATH . "$template.php")) {
				include_once (TEMPLATEPATH . "$template.php");
			} else {
				echo '<p>Template inexistente no sistema!</p>';
			}
		}
	}
	
	//Carrega os Plugins
	function loadPlugin($plugin = NULL, $file = NULL) {
		if ($plugin == NULL) {
			echo '<p>Erro na funcão <strong>' . __FUNCTION__ . '</strong>: faltam parâmetros para execução.</p>';
		} else {
			if (file_exists(PLUGINSPATH . $plugin . "/$file.php")) {
				include_once (PLUGINSPATH . $plugin . "/$file.php");
			} else {
				echo '<p>Pluquin inexistente no sistema!</p>';
			}
		}
	}
	
	//Portege Arquivos
	function protegeArquivo($arquivo, $redirPara = '?msg=4') {
		$url = $_SERVER["PHP_SELF"];
		if (preg_match('#' . $arquivo . '#', $url)) {
			redireciona($redirPara);
		}
	}
	
	//Redireciona
	function redireciona($url = '') {
		header("Location: " . BASEURL . $url);
	}
	
	function codificaSenha($senha) {
		if ($senha != NULL) {
			return sha1($senha);
		}
	}// Fim do Codifica a senha
		
	//Menu do Usuário
	function getMenuUser() {
		$user = new sessao();
		$id = $user -> getVar('userid');
		$usuario = ucfirst(strtolower(strtok($user -> getVar('usernome'), " ")));
		echo "Olá, <a href='?m=usuarios&a=editar&id=" . $id . "' class='userLink'>" . $usuario . "</a> | <a href='?m=sair'>Sair</a>";
	}
	
	function geraData($data, $padrao = null) {
		//$padrao = "d/m/Y g:i A";
		if ($padrao == null) $padrao = "d/m/Y - H:i:s";
		if ($data != NULL && $data != "0000-00-00 00:00:00") {
			$datetime = strtotime($data);
			$mysqldate = date($padrao, $datetime);
			return $mysqldate;
		}
	}// Fim do Codifica a senha

	// Formata data dd/mm/aaaa para aaaa-mm-dd
	function geraDataSQL($data) {
		if (!empty($data)){
		$p_dt = explode('/',$data);
		$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
		return $data_sql;
		}
	}
		
	//Verifica a Sessao
	function verificaSessao() {
		$sessao = new sessao();
		// || $sessao->getVar('userip')!=$_SERVER['REMOTE_ADDR']
		if ($sessao -> getNvars() > 0 && $sessao -> getVar('userlogado') == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	//Verifica Nível
	function verificaNivel($nivel) {
		$sessao = new sessao();
		$usernivel = $sessao -> getVar('usernivel');
		if ($usernivel >= $nivel) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Verifica ID
	function verificaID($id) {
		$sessao = new sessao();
		$userid = $sessao -> getVar('userid');
		if ($userid == $id) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Limitar Caracteres
    function limitarCaracteres(  $var, $limite , $encode = 'UTF-8' ) {
		// Se o texto for maior que o limite, ele corta o texto e adiciona 3 pontinhos.
		if (strlen($var) > $limite)	{
			$var = mb_substr(trim($var), 0, $limite, $encode);
			$var = $var . "...";
		}
		return $var;

	}	
			
	//Exibe as Mensagens
	function printMSG($msg = NULL, $tipo = NULL) {
		if ($msg != NULL) {
			switch ($tipo) {
				case 'ERRO' :
					echo '<div class="erro">' . $msg . '</div>';
					break;
				case 'ALERTA' :
					echo '<div class="alerta">' . $msg . '</div>';
					break;
				case 'PERGUNTA' :
					echo '<div class="pergunta">' . $msg . '</div>';
					break;
				case 'SUCESSO' :
					echo '<div class="sucesso">' . $msg . '</div>';
					break;
				default :
					echo '<div class="sucesso"">' . $msg . '</div>';
					break;
			}
		}
	}
	
	//Salva log
	function salvaLog($tabela, $usuario = NULL, $acao, $tipo, $msg) {
		$data = date('Y-m-d H:i:s');
		$ip = $_SERVER['REMOTE_ADDR'];
		if ($usuario == NULL) {
			$userLogin = new sessao();
			$usuario = $userLogin -> getVar('userlogin');			
		}
		$usuario = mysql_real_escape_string($usuario);
		$tabela = mysql_real_escape_string($tabela);		
		$acao = mysql_real_escape_string($acao);
		$tipo = mysql_real_escape_string($tipo);
		$msg = mysql_real_escape_string($msg);
		$log = new logs( array (
			"data" => $data,
			"ip" => $ip,
			"tabela" => $tabela,
			"usuario" => $usuario,
			"acao" => $acao,
			"tipo" => $tipo,
			"msg" => $msg			
		));
		$log -> adicionar($log);
		if ($log -> linhasafetadas > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
?>