<?php
	/**
	 * 
	 * unidades-setores-listar.php
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
				<?php echo $GLOBALS['text']['unidades_saude_listar_titulo']; ?>
			</legend>
			<table id="listar" cellpadding="0" cellspacing="0" border="0" class="display">
				<thead>
					<tr>
						<th width="*"><?php echo $GLOBALS['text']['unidades_saude_nome']; ?></th>
						<th width="15%"><?php echo $GLOBALS['text']['unidades_saude_telefone']; ?></th>
						<th width="60"><?php echo $GLOBALS['text']['unidades_saude_acoes']; ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5" class="dataTables_empty"><?php echo $GLOBALS['text']['msg_processando_dados']; ?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		<p class="linkAdd"><a href="?m=unidades-saude&a=adicionar" title="<?php echo $GLOBALS['text']['unidades_saude_adicionar_nova']; ?>"><img src="<?php echo IMAGENSPATH."add.png";  ?>" alt="<?php echo $GLOBALS['text']['unidades_saude_adicionar_nova']; ?>" style="margin-bottom:3px;vertical-align:middle"/> <?php echo $GLOBALS['text']['unidades_saude_adicionar_nova']; ?></a></p>
	</div>
<?php
	loadTemplate('footer');
?>