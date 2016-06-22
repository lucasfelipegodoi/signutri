<?php
	/*
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
	loadTemplate('header');	
	if (!empty($_POST)) {
		$data = $_POST['data'];
		$nis = $_POST['nis'];
		$nome = $_POST['nome'];
		$gestante = $_POST['gestante'];
		$gestante_nome = $_POST['gestante_nome'];
		$gestante_dum = geraData($_POST['gestante_dum'], 'd/m/Y');
		$telefone = $_POST['telefone'];
		$celular = $_POST['celular'];
		$cep = $_POST['cep'];
		$endereco = $_POST['endereco'];
		$numero = $_POST['numero'];
		$complemento = $_POST['complemento'];
		$bairro = $_POST['bairro'];
		$cidade = $_POST['cidade'];
		$unidade_saude_id = $_POST['unidade_saude_id'];
		$localizacao = $_POST['localizacao'];
		$ocorrencia_id = $_POST['ocorrencia_id'];
		$vigencia = $_POST['vigencia'];
		$vigencia_ano = $_POST['vigencia_ano'];
		$meio_notificacao_id = $_POST['meio_notificacao_id'];
		$observacoes = $_POST['observacoes'];
		
	} elseif (isset($dados)) {
		$data = geraData($dados->data_atendimento, 'd/m/Y');
		$nis = $dados->nis;
		$nome = $dados->nome;
		$gestante = $dados->gestante;
		$gestante_nome = $dados->gestante_nome;
		$gestante_dum = geraData($dados->gestante_dum, 'd/m/Y');
		$telefone = $dados->telefone;
		$celular = $dados->celular;
		$cep = $dados->cep;
		$endereco = $dados->endereco;
		$numero = $dados->numero;
		$complemento = $dados->complemento;
		$bairro = $dados->bairro;
		$cidade = $dados->cidade;
		$unidade_saude_id = $dados->unidade_saude_id;
		$localizacao = $dados->localizacao;
		$ocorrencia_id = $dados->ocorrencia_id;
		$vigencia = $dados->vigencia;
		$vigencia_ano = $dados->vigencia_ano;
		$meio_notificacao_id = $dados->meio_notificacao_id;
		$observacoes = $dados->observacoes;			
	}
	
	$linkCancelar = BASEURL."?m=beneficiarios&a=listar";
?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#form").validate({
				rules : {
					data : {
						required : true,
						minlength : 3
					},
					nis : {
						required : true
					},
				}
			});
			 <?php if ($gestante != 1) { ?> 
			 	$('#gestante_dados').hide();
			  <?php } ?>
		    $("#gestante").bind("change", function () {
		    	if ($(this).val() == 0) {
		    		$('#gestante_nome').val('');
		    		$('#gestante_dum').val('');
					$('#gestante_dados').hide();				
		        }
		        else if($(this).val() == 1) {
		            $('#gestante_dados').show();
		        }
		    });
		    $("#localizacao").bind("change", function () {
				$.ajax({
					type: "POST",
				    url: "<?= AJAXPATH; ?>/ocorrencias-select.php",
				    data: {localizacao: $("#localizacao").val()},
				    dataType: "json",
				    success: function(json){
					    var options = '<option value=""></option>';
					    $.each(json, function(i, obj) {
					    	options += '<option value="' + obj.id + '" title="' + obj.titulo + '">' + obj.titulo + '</option>';
					    });
					    $("#ocorrencia_id").html(options);
				    }
				});
		    });
			<?php 
				switch (SISACAO) {
					case 'exibir':
			?>
						$('input[type=text]').attr('disabled', 'disabled');
						$('select').attr('disabled', 'disabled');
						$('textarea').attr('disabled', 'disabled');
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
					<?= $GLOBALS['text']['beneficiarios_'.SISACAO.'_titulo']; ?>
				</legend>
				<ul>
					<li>
						<label for="data"><?= $GLOBALS['text']['beneficiarios_data_atendimento']; ?></label>
						<input type="hidden" name="vdata" id="vdata" value="<?= $vdata = (isset($_POST['vdata'])) ? $_POST['vdata'] : $data; ?>">
						<input type="text" name="data" id="data" value="<?= $data2 = (isset($data)) ? $data : date('d/m/Y'); ?>">
					</li>
					<li>
						<label for="nis"><?= $GLOBALS['text']['beneficiarios_nis']; ?></label>
						<input type="hidden" name="vnis" id="vnis" value="<?= $vnis = (isset($_POST['vnis'])) ? $_POST['vnis'] : $nis; ?>">
						<input type="text" name="nis" id="nis" value="<?php if(isset($nis)) echo $nis; ?>">
					</li>
					<li>
						<label for="nome"><?= $GLOBALS['text']['beneficiarios_nome']; ?></label>
						<input type="text" name="nome" id="nome" value="<?php if(isset($nome)) echo $nome; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>
					<li>
						<label for="gestante"><?= $GLOBALS['text']['beneficiarios_gestante']; ?></label>
						<select name="gestante" id="gestante">
							<option></option>
							<option value="0" <?php if (isset($gestante) && $gestante == 0) echo 'selected="selected"'; ?> />NÃO</option>
							<option value="1" <?php if (isset($gestante) && $gestante == 1) echo 'selected="selected"'; ?> />SIM</option>
						</select>
					</li>
					<div id="gestante_dados">
						<li>
							<label for="gestante_nome"><?= $GLOBALS['text']['beneficiarios_gestante_nome']; ?></label>
							<input type="text" name="gestante_nome" id="gestante_nome" value="<?php if(isset($gestante_nome)) echo $gestante_nome; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
						</li>
						<li>
							<label for="gestante_dum"><?= $GLOBALS['text']['beneficiarios_gestante_dum']; ?></label>
							<input type="text" name="gestante_dum" id="gestante_dum" value="<?php if(isset($gestante_dum)) echo $gestante_dum; ?>">
						</li>						
					</div>					
					<li>
						<label for="telefone"><?= $GLOBALS['text']['beneficiarios_telefone']; ?></label>
						<input type="text" name="telefone" id="telefone" value="<?php if(isset($telefone)) echo $telefone; ?>">
					</li>
					<li>
						<label for="celular"><?= $GLOBALS['text']['beneficiarios_celular']; ?></label>
						<input type="text" name="celular" id="celular" value="<?php if(isset($celular)) echo $celular; ?>">
					</li>
					<li>
						<label for="cep"><?= $GLOBALS['text']['beneficiarios_cep']; ?></label>
						<input type="text" name="cep" id="cep" value="<?php if(isset($cep)) echo $cep; ?>">
					</li>
					<li>
						<label for="endereco"><?= $GLOBALS['text']['beneficiarios_endereco']; ?></label>
						<input type="text" name="endereco" id="endereco" value="<?php if(isset($endereco)) echo $endereco; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>	
					<li>
						<label for="numero"><?= $GLOBALS['text']['beneficiarios_numero']; ?></label>
						<input type="text" name="numero" id="numero" value="<?php if(isset($numero)) echo $numero; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>											
					<li>
						<label for="complemento"><?= $GLOBALS['text']['beneficiarios_complemento']; ?></label>
						<input type="text" name="complemento" id="complemento" value="<?php if(isset($complemento)) echo $complemento; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>
					<li>
						<label for="bairro"><?= $GLOBALS['text']['beneficiarios_bairro']; ?></label>
						<input type="text" name="bairro" id="bairro" value="<?php if(isset($bairro)) echo $bairro; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>
					<li>
						<label for="cidade"><?= $GLOBALS['text']['beneficiarios_cidade']; ?></label>
						<input type="text" name="cidade" id="cidade" value="<?php if(isset($cidade)) echo $cidade; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>					
					<li>
						<label for="unidade_saude_id"><?= $GLOBALS['text']['beneficiarios_unidade_saude']; ?></label>
						<select name="unidade_saude_id" id="unidade_saude_id">
							<option value=""></option>
							<?php
								$unidade = new unidadesSaude(array(
									"id" => NULL,
									"nome" => NULL
								));
								$unidade->extras_select = "ORDER BY NOME ASC";
								$unidade->selecionaCampos($unidade);
								while ($res = $unidade->retornaDados()) {
									echo  '<option value="'.$res->id.'" title="'.$res->nome.'" '; 
								    if (isset($unidade_saude_id) && $unidade_saude_id == $res->id) echo 'selected="selected"';
								    echo '>'.$res->nome.'</option>';	
								}
							?>
						</select>
					</li>				
					<li>
						<label for="localizacao"><?= $GLOBALS['text']['beneficiarios_localizacao']; ?></label>
						<select name="localizacao" id="localizacao">
							<option value=""></option>
							<option value="0" <?php if (isset($localizacao) && $localizacao == 0) echo 'selected="selected"'; ?> />NÃO</option>
							<option value="1" <?php if (isset($localizacao) && $localizacao == 1) echo 'selected="selected"'; ?> />SIM</option>
							<option value="2" <?php if (isset($localizacao) && $localizacao == 2) echo 'selected="selected"'; ?> />OUTROS</option>
						</select>
					</li>
					<li>
						<label for="ocorrencia_id" style="padding-top: 0;"><?= $GLOBALS['text']['beneficiarios_ocorrencia']; ?></label>
						<select name="ocorrencia_id" id="ocorrencia_id">
							<option value=""></option>
							<?php
								if (isset($localizacao)) {
									$ocorrencias = new ocorrencias();
									$ocorrencias->extras_select = "WHERE localizacao=".$localizacao." ORDER BY TITULO ASC";
									$ocorrencias->selecionaTudo($ocorrencias);
									while ($res = $ocorrencias->retornaDados()) {
										echo  '<option value="'.$res->id.'" title="'.$res->titulo.'" '; 
									    if (isset($ocorrencia_id) && $ocorrencia_id == $res->id) echo 'selected="selected"';
									    echo '>'.$res->titulo.'</option>';	
									}									
								}
							?>							
						</select>
					</li>
					<li>
						<label for="vigencia"><?= $GLOBALS['text']['beneficiarios_vigencia']; ?></label>
						<select name="vigencia" id="vigencia" style="width: 375px">
							<option></option>
							<option value="1" <?php if (isset($vigencia) && $vigencia == 1) echo 'selected="selected"'; ?>>1ª VIGÊNCIA</option>
							<option value="2" <?php if (isset($vigencia) && $vigencia == 2) echo 'selected="selected"'; ?>>2ª VIGÊNCIA</option>
						</select>
						<select name="vigencia_ano" id="vigencia_ano" style="width: 80px">
							<?php
							$ano_inicial = 2000;
							$ano_final = 2020;
							while ($ano_final >= $ano_inicial) {
								echo '<option value="'.$ano_final.'"';
								if($ano_final == date('Y')) echo 'selected="selected"';
								echo '>'.$ano_final.'</option>';
								$ano_final--;
							}
							?>
						</select>						
					</li>
					<li>
						<label for="meio_notificacao_id"><?= $GLOBALS['text']['beneficiarios_meio_notificacao']; ?></label>
						<select name="meio_notificacao_id" id="meio_notificacao_id">
							<option value=""></option>
							<?php
								$notificacao = new meioNotificacao(array(
									"id" => NULL,
									"titulo" => NULL
								));
								$notificacao->extras_select = "ORDER BY TITULO ASC";
								$notificacao->selecionaCampos($notificacao);
								while ($res = $notificacao->retornaDados()) {
									echo  '<option value="'.$res->id.'" title="'.$res->titulo.'" '; 
								    if (isset($meio_notificacao_id) && $meio_notificacao_id == $res->id) echo 'selected="selected"';
								    echo '>'.$res->titulo.'</option>';	
								}
							?>
						</select>
					</li>	
					<li>
						<label for="observacoes"><?= $GLOBALS['text']['beneficiarios_observacoes']; ?></label>
						<textarea name="observacoes" id="observacoes" onkeyup="return cUpper(this);" onblur="return cUpper(this);"><?php if(isset($observacoes)) echo $observacoes; ?></textarea>
					</li>																												
				</ul>							
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