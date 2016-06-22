<?php
	/**
	 * 
	 * logs.php
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
	loadTemplate('header');
?>
	<div id="pageListar">
		<?php
			if (isset($_GET['msg'])) {
				loadConfig('mensagens', $_GET['msg']);
			}
			if (isset($GLOBALS['msg']) && isset($GLOBALS['msg_tipo'])) {
				printMSG($GLOBALS['msg'], $GLOBALS['msg_tipo']); 
				unset($GLOBALS['msg']);
				unset($GLOBALS['msg_tipo']);
			}
		?>		
		<fieldset>
			<legend>
				<?php echo $GLOBALS['text']['logs_titulo']; ?>
			</legend>
			<table id="listar" cellpadding="0" cellspacing="0" border="0" class="display">
				<thead>
					<tr>
						<th width="15%"><?php echo $GLOBALS['text']['logs_data']; ?></th>
						<th width="15%"><?php echo $GLOBALS['text']['logs_tabela']; ?></th>
						<th width="15%"><?php echo $GLOBALS['text']['logs_usuario']; ?></th>
						<th width="10%"><?php echo $GLOBALS['text']['logs_acao']; ?></th>
						<th width="10%"><?php echo $GLOBALS['text']['logs_tipo']; ?></th>
						<th width="35%"><?php echo $GLOBALS['text']['logs_msg']; ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5" class="dataTables_empty">Processando consulta no banco de dados...</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>	 
<?php
	loadTemplate('footer');
?>