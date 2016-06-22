<?php
	/*
	 * 
	 * usuarios-form.php
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
	if (!empty($_POST)) {
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$celular = $_POST['celular'];
		$usuario = $_POST['usuario'];
		$nivel = $_POST['nivel'];
		$status = $_POST['status'];
	} elseif (isset($dados)) {
		$nome = $dados->nome;
		$email = $dados->email;	
		$telefone = $dados->telefone;
		$celular = $dados->celular;
		$usuario = $dados->usuario;
		$nivel = $dados->nivel;
		$status = $dados->status;			
	}
	
	if (verificaNivel(NIVELADMIN)) {
		$linkCancelar = BASEURL."?m=usuarios&a=listar";
	}else {
		$linkCancelar = BASEURL;
	}
?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {		
			$("#form").validate({
				rules : {
					nome : {
						required : true,
						minlength : 3
					},
					nivel : {
						required : true
					},
					usuario : {
						required : true,
						minlength : 4
					},
					senhaAtual : {
						required : true,
						rangelength : [4, 20]
					},
					senhaNova : {
						required : true,
						rangelength : [4, 20]
					},	
					senhaConf : {
						required : true,
						equalTo:"#senhaNova"
					},																
				}
			});
			<?php 
				switch (SISACAO) {
					case 'exibir':
			?>
						$('input[type=text]').attr('disabled', 'disabled');
						$('select').attr('disabled', 'disabled');
						$('#exibir').hide();
			<?php
					break;
				}					
			?>			 						
		}); 
	</script>	
	<div id="page">
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
		<form id="form" action="" method="post">
			<fieldset>
				<legend>
					<?= $GLOBALS['text']['usuarios_'.SISACAO.'_titulo']; ?>
				</legend>
				<ul>
					<?php
						if (SISACAO != 'senha') { 						
					?>						
					<li>
						<label for="nome"><?= $GLOBALS['text']['usuarios_nome']; ?></label>
						<input type="text" name="nome" id="nome" value="<?php if(isset($nome)) echo $nome; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);" <?php if (SISACAO == 'adicionar') echo 'autofocus="autofocus"'; ?>>
					</li>
					<li>	
						<label for="email"><?= $GLOBALS['text']['usuarios_email']; ?></label>
						<input type="text" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>
					<li>
						<label for="telefone"><?= $GLOBALS['text']['usuarios_telefone']; ?></label>
						<input type="text" name="telefone" id="telefone" value="<?php if(isset($telefone)) echo $telefone; ?>">
					</li>					
					<li>
						<label for="celular"><?= $GLOBALS['text']['usuarios_celular']; ?></label>
						<input type="text" name="celular" id="celular" value="<?php if(isset($celular)) echo $celular; ?>">
					</li>
					
					<li>	
						<label for="nivel"><?= $GLOBALS['text']['usuarios_nivel']; ?></label>
						<?php if (!verificaNivel(NIVELADMIN)) echo '<input type="hidden" name="nivel" id="nivel" value="'.$nivel.'">'; ?>
						<select name="nivel" id="nivel" <?php if (!verificaNivel(NIVELADMIN)) echo 'disabled="disabled"'; ?>>
							<option></option>
							<option value="<?= NIVELUSER; ?>" <?php if (isset($nivel) && $nivel == NIVELUSER) echo "selected"; ?>><?= $GLOBALS['text']['usuarios_nivel_user']; ?></option>
							<option value="<?= NIVELOPER; ?>" <?php if (isset($nivel) && $nivel == NIVELOPER) echo "selected"; ?>><?= $GLOBALS['text']['usuarios_nivel_oper']; ?></option>
							<option value="<?= NIVELADMIN; ?>" <?php if (isset($nivel) && $nivel == NIVELADMIN) echo "selected"; ?>><?= $GLOBALS['text']['usuarios_nivel_admin']; ?></option>
						</select>
					</li>

					<li>	
						<label for="status"><?= $GLOBALS['text']['usuarios_status']; ?></label>					
						<?php if (!verificaNivel(NIVELADMIN)) echo '<input type="hidden" name="status" id="status" value="'.$status.'">'; ?>
						<select name="status" id="status" <?php if (!verificaNivel(NIVELADMIN)) echo 'disabled="disabled"'; ?>>
							<option></option>
							<option value="1" <?php if (isset($status) && $status == 1) echo "selected"; ?>><?= $GLOBALS['text']['usuarios_status_1']; ?></option>
							<option value="0" <?php if (isset($status) && $status == 0) echo "selected"; ?>><?= $GLOBALS['text']['usuarios_status_0']; ?></option>
						</select>
					</li>	
					<?php
						}
					?>											
					<li>
						<label for="usuario"><?= $GLOBALS['text']['usuarios_login']; ?></label>
						<?php if (SISACAO != 'adicionar') echo '<input type="hidden" name="usuario" id="usuario" value="'.$usuario.'">'; ?>
						<input type="text" name="usuario" id="usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);" <?php if (SISACAO != 'adicionar') echo 'disabled="disabled"'; ?>>
					</li>
					<?php
						if (SISACAO == 'senha' && verificaID($_GET['id'])) {
					?>
					<li>
						<label for="senhaAtual"><?= $GLOBALS['text']['usuarios_senha_atual']; ?></label>
						<input type="password" name="senhaAtual" id="senhaAtual" value="" autofocus="autofocus">
					</li>								
					<?php
						}
						if (SISACAO == 'adicionar' OR SISACAO == 'senha') { 						
					?>					
					<li>
						<label for="senhaNova"><?= $GLOBALS['text']['usuarios_senha']; ?></label>
						<input type="password" name="senhaNova" id="senhaNova" value="">
					</li>
					<li>
						<label for="senhaConf"><?= $GLOBALS['text']['usuarios_senha_confere']; ?></label>
						<input type="password" name="senhaConf" id="senhaConf" value="">
					</li>
					<?php
						}
					?>																												
				</ul>
				<?php
					if (SISACAO == 'editar') { 						
				?>								
				<div class="linkPassUser">
					<a href="?m=usuarios&a=senha&id=<?php if(isset($dados)) echo $dados->id; ?>">
						<img src="<?= IMAGENSPATH."pass.png";  ?>" alt="<?= $GLOBALS['text']['usuarios_editar_senha']; ?>" style="margin-bottom:3px;vertical-align:middle" border="0"> 
						<?= $GLOBALS['text']['usuarios_editar_senha']; ?>
					</a>
				</div>
				<?php
					}
				?>									
			</fieldset>
			<div class="right">
				<input type="button" name="cancelar" id="cancelar" onclick="location.href='<?= $linkCancelar; ?>'" title="Cancelar" class="cancelar">
				<input type="submit" name="<?= SISACAO; ?>" id="<?= SISACAO; ?>" class="confirmar" value="" onclick="return confirm('<?= $GLOBALS["text"]["msg_confirma_".SISACAO] ; ?>')" />
			</div>
		</form>
	</div>	

<?php
	loadTemplate('footer');
?>