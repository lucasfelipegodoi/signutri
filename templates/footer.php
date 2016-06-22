<?php
	/**
	 * footer.php
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
?>			
				</td>
			</tr>	
			<tr>
				<td id="footer">
					<footer>
						<p>
							<i><?php echo SISCLIENTE." - ".SISCIDADE; ?>
							<br>
							<?php echo SISENDERECO." - ".SISCEP; ?>
							<br>
							<?php echo SISTELEFONE; ?></i>
						</p>
					</footer>
				</td>
			</tr>
		</table>		
	</body>
</html>