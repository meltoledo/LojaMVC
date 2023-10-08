<?php
date_default_timezone_set("AMERICA/Sao_Paulo");
	require_once "models/conexao.class.php";
	require_once "models/produtoDAO.class.php";
	require_once "models/produto.class.php";
	require_once "models/vendaDAO.class.php";
	require_once "models/venda.class.php";
	require_once "models/usuario.class.php";
	require_once "models/usuarioDAO.class.php";
	require_once "models/itens.class.php";
	if(!isset($_SESSION))
		session_start();
	
	class vendaController
	{
		public function mostrar_carrinho()
		{
			require_once "views/carrinho.php";
		}
		public function inserir_carrinho()
		{
			if(isset($_GET["id"]))
			{
				$linha = -1;
				$achou = false;
				if(isset($_SESSION["carrinho"]))
				{
					foreach($_SESSION["carrinho"] as $linha=>$dado)
					{
						if($dado["idproduto"] == $_GET["id"])
						{
							$achou = true;
							break;
						}
					}//fim foreach
				}//if isset
				
				if(!$achou)
				{
					$produto = new produto(idproduto:$_GET["id"]);
					$produtoDAO = new produtoDAO();
					$retorno = $produtoDAO->buscar_um_produto($produto);
									
					$_SESSION["carrinho"][$linha + 1]["idproduto"] = $retorno[0]->idproduto;
					$_SESSION["carrinho"][$linha + 1]["nome"] = $retorno[0]->nome;
					$_SESSION["carrinho"][$linha + 1]["preco"] = $retorno[0]->preco;
					$_SESSION["carrinho"][$linha + 1]["quantidade"] = 1;
				}
				header("location:index.php?controle=vendaController&metodo=mostrar_carrinho");
			}
		}
		public function excluir()
		{
			if(isset($_GET["linha"]))
			{
				unset($_SESSION["carrinho"][$_GET['linha']]);
				header("location:index.php?controle=vendaController&metodo=mostrar_carrinho");
			}
		}//fim do excluir
		public function alterar()
		{
			if(isset($_GET["linha"]))
			{
				$_SESSION["carrinho"][$_GET["linha"]]["quantidade"] = $_GET["qtde"];
			}
		}
		public function finalizar()
		{
			if(isset( $_SESSION["idusuario"]))
			{
				//finalizar a venda
				$usuario = new Usuario($_SESSION["idusuario"]);
				$venda = new Venda(data_venda:date("Y-m-d"),usuario:$usuario);

				foreach($_SESSION["carrinho"] as $dado)
				{
					$produto = new Produto($dado["idproduto"]);
					$venda->setItens(0,$dado["quantidade"], $dado["preco"], $produto);
				}

				$vendaDAO = new vendaDAO();
				$retorno = $vendaDAO->inserir_venda($venda);
				
					require_once "views/extrato.php";
				unset($_SESSION["carrinho"]);
				header("location:index.php");
			}
			else
			{
				//fazer login
				header("location:index.php?controle=usuarioController&metodo=login");
			}
		}
	}//fim da classe
?>