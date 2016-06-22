<?php
	/*
	 * banco.class.php
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
	abstract class banco {
		//Propriedades
		public $servidor = DBHOST;
		public $usuario = DBUSER;
		public $senha = DBPASS;
		public $bancodedados = DBNAME;
		public $conexao = NULL;
		public $dataset = NULL;
		public $linhasafetadas = 0;
	
		//Métodos
		public function __construct() {
			$this -> conecta();
		}// Fim do Construct
	
		public function __destruct() {
			if ($this -> conexao != NULL) {
				mysql_close($this -> conexao);
			}
		}// Fim do Destruct
	
		public function conecta() {
			$this -> conexao = mysql_connect($this -> servidor, $this -> usuario, $this -> senha, TRUE) or die($this -> trataerro(__FILE__, __FUNCTION__, mysql_errno(), mysql_error(), TRUE));
			mysql_select_db($this -> bancodedados) or die($this -> trataerro(__FILE__, __FUNCTION__, mysql_errno(), mysql_error(), TRUE));
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET character_set_connection=utf8");
			mysql_query("SET character_set_client=utf8");
			mysql_query("SET character_set_results=utf8");
		}// Fim do Conecta
	
		public function adicionar($objeto) {
			$sql = "INSERT INTO " . $objeto -> tabela . " (";
			for ($i = 0; $i < count($objeto -> campos_valores); $i++) {
				$sql .= key($objeto -> campos_valores);
				if ($i < (count($objeto -> campos_valores) - 1)) {
					$sql .= ", ";
				} else {
					$sql .= ") ";
				}
				next($objeto -> campos_valores);
			}
			reset($objeto -> campos_valores);
			$sql .= "VALUES (";
			for ($i = 0; $i < count($objeto -> campos_valores); $i++) {
				$sql .= is_numeric($objeto -> campos_valores[key($objeto -> campos_valores)]) ? $objeto -> campos_valores[key($objeto -> campos_valores)] : "'" . $objeto -> campos_valores[key($objeto -> campos_valores)] . "'";
				if ($i < (count($objeto -> campos_valores) - 1)) {
					$sql .= ", ";
				} else {
					$sql .= ") ";
				}
				next($objeto -> campos_valores);
			}
			return $this -> executaSQL($sql);
		}// Fim do Adicionar
	
		public function atualizar($objeto) {
			$sql = "UPDATE " . $objeto -> tabela . " SET ";
			for ($i = 0; $i < count($objeto -> campos_valores); $i++) {
				$sql .= key($objeto -> campos_valores) . "=";
				$sql .= is_numeric($objeto -> campos_valores[key($objeto -> campos_valores)]) ? $objeto -> campos_valores[key($objeto -> campos_valores)] : "'" . $objeto -> campos_valores[key($objeto -> campos_valores)] . "'";
				if ($i < (count($objeto -> campos_valores) - 1)) {
					$sql .= ", ";
				} else {
					$sql .= " ";
				}
				next($objeto -> campos_valores);
			}
			$sql .= "WHERE " . $objeto -> campopk . "=";
			$sql .= is_numeric($objeto -> valorpk) ? $objeto -> valorpk : "'" . $objeto -> valorpk . "'";
			return $this -> executaSQL($sql);
		}// Fim do Atualizar
	
		public function excluir($objeto) {
			$sql = "DELETE FROM " . $objeto -> tabela . " WHERE " . $objeto -> campopk . "=";
			$sql .= is_numeric($objeto -> valorpk) ? $objeto -> valorpk : "'" . $objeto -> valorpk . "'";
			return $this -> executaSQL($sql);
		}// Fim do Deletar
	
		public function selecionaTudo($objeto) {
			$sql = "SELECT * FROM " . $objeto -> tabela;
			if ($objeto -> extras_select != NULL) {
				$sql .= " " . $objeto -> extras_select;
			}
			return $this -> executaSQL($sql);
		}// Fim do SelecionaTudo
	
		public function selecionaCampos($objeto) {
			$sql = "SELECT ";
			for ($i = 0; $i < count($objeto -> campos_valores); $i++) {
				$sql .= key($objeto -> campos_valores);
				if ($i < (count($objeto -> campos_valores) - 1)) {
					$sql .= ", ";
				} else {
					$sql .= " ";
				}
				next($objeto -> campos_valores);
			}
			$sql .= " FROM " . $objeto -> tabela;
			if ($objeto -> extras_select != NULL) {
				$sql .= " " . $objeto -> extras_select;
			}
			return $this -> executaSQL($sql);
		}// Fim do SelecionaCampos
	
		public function executaSQL($sql = NULL) {
			if ($sql != NULL) {
				$query = mysql_query($sql) or $this -> trataerro(__FILE__, __FUNCTION__);
				$this -> linhasafetadas = mysql_affected_rows($this -> conexao);
				if (substr(trim(strtolower($sql)), 0, 6) == 'select') {
					$this -> dataset = $query;
					return $this -> dataset;
				} else {
					return $this -> linhasafetadas;
				}
			} else {
				$this -> trataerro(__FILE__, __FUNCTION__, NULL, 'Comando SQL não informado.', FALSE);
			}
		}// Fim do ExecutaSQL
	
		public function retornaDados($tipo = NULL) {
			switch (strtolower($tipo)) {
				case "array" :
					return mysql_fetch_array($this -> dataset);
					break;
				case "assoc" :
					return mysql_fetch_assoc($this -> dataset);
					break;
				case "object" :
					return mysql_fetch_object($this -> dataset);
					break;
				default :
					return mysql_fetch_object($this -> dataset);
					break;
			}
		}// Fim do RetornaDados
	
		public function verificaRegistro($campo = NULL, $valor = NULL) {
			if ($campo != NULL && $valor != NULL) {
				is_numeric($valor) ? $valor = $valor : $valor = "'" . $valor . "'";
				$this -> extras_select = "WHERE $campo=$valor";
				$this -> selecionaTudo($this);
				if ($this -> linhasafetadas > 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}// Fim do Verifica Registro
	
		public function trataerro($arquivo = NULL, $rotina = NULL, $numerro = NULL, $msgerro = NULL, $geraexcept = FALSE) {
			if ($arquivo == NULL)
				$arquivo = "Não informado.";
			if ($rotina == NULL)
				$rotina = "Não informada.";
			if ($numerro == NULL)
				$numerro = mysql_errno($this -> conexao);
			if ($msgerro == NULL)
				$msgerro = mysql_error($this -> conexao);
			$resultado = '<br /><strong><font color=red>Ocorreu um erro com os seguintes detalhes:</font></strong> <br />
								<strong>Arquivo:</strong> ' . $arquivo . '<br />
								<strong>Rotina:</strong> ' . $rotina . '<br />
								<strong>Código:</strong> ' . $numerro . '<br />
								<strong>Mensagem:</strong> ' . $msgerro . '<br />';
			if ($geraexcept = FALSE) {
				echo($resultado);
			} else {
				die($resultado);
			}
		} // Fim do TrataErro
	
	}// Fim da Classe Banco
?>