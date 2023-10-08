<?php
	require_once "views/cabecalho.php";

		//mostrar os produtos guardados na sessão
				if(isset($_SESSION["carrinho"]) && count($_SESSION["carrinho"]) > 0)
				{
?>
		<table class="table">
			<tr>
				<th>Produto</th>
				<th>Preço(R$)</th>
				<th>Quantidade</th>
				<th>Subtotal</th>
				<th></th>
			</tr>
			<?php
				
					$total = 0;
					foreach($_SESSION["carrinho"] as $linha=>$dado)
					{
						$subtotal = $dado["preco"] * $dado["quantidade"];
						$total +=$subtotal;
						
						echo "<tr>
						      <td>{$dado['nome']}</td>
							  <td>" . number_format($dado['preco'], 2, ',', '.') . "</td>
							  <td><input type='number' min='1' value='{$dado['quantidade']}' linha='$linha' class='qtde'></td>
							  <td>" . number_format($subtotal, 2, ',', '.') . "</td>
							   <td><a href='index.php?controle=vendaController&metodo=excluir&linha=$linha'>Excluir</a></td>
							  </tr>";
						
						
					}
				
				
			?>
			<tr>
				<td colspan="3">Total da Venda</td>
				<td><?php echo number_format($total, 2, ',', '.');?></td>
			</tr>
		</table>
		<a href="index.php" class="btn btn-primary">Continuar Comprando</a>
		<a href="index.php?controle=vendaController&metodo=finalizar" class="btn btn-primary">Finalizar a Compra</a>
		<?php  
		}
		else
		{
			echo"<h1>Não há produto no carrinho</h1>";
		}
		?>
		<script type="text/javascript" src="lib/jquery-latest.js"></script>
		<script>
			$(function(){
				$(".qtde").change(function(){
					var linha = $(this).attr("linha");
					var qtde = $(this).val();
					$.ajax({
						type:'GET',
						url:'index.php',
						data:'controle=vendaController&metodo=alterar&linha=' + linha + '&qtde=' + qtde,
						success:function()
						{
							location.reload();
						},
						error:function()
						{
							alert("erro");
						}
					});
					
				});
			});
		</script>
		
		
		
		
<?php
	require_once "views/rodape.html";
?>