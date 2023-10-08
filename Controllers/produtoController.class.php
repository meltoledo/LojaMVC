<?php
	require_once "models/Conexao.class.php";
	require_once "models/CategoriaDAO.class.php";
	require_once "models/Categoria.class.php";
	require_once "models/Produto.class.php";
	require_once "models/ProdutoDAO.class.php";
	require_once "models/Fornecedor.class.php";
	require_once "models/FornecedorDAO.class.php";
	class produtoController
	{
		public function listar()
		{
			$produtoDAO = new produtoDAO();
			$retorno = $produtoDAO->buscar_todos_produtos();
			require_once "views/listar_produtos.php";
		}
		
		public function inserir()
		{
			if($_POST)
			{
				$erro = false;
				if($_POST["nome"] == "")
				{
					$erro = true;
					echo "<script>alert('Preencha o nome do produto')</script>";
				}
				if($_FILES["imagem"]["name"] == "")
				{
					$erro = true;
					echo "<script>alert('Escolha uma imagem para o produto')</script>";
				}
				if($_POST["categoria"] == "0")
				{
					$erro = true;
					echo "<script>alert('Escolha uma categoria')</script>";
				}
				if(!isset($_POST["fornecedor"]))
				{
					$erro = true;
					echo "<script>alert('Escolha pelo menos um fornecedor')</script>";
				}
				if(!$erro)
				{
					//inserir no BD
					$categoria = new categoria($_POST["categoria"]);
			
					$produto = new Produto(nome:$_POST["nome"], 
					descricao:$_POST["descricao"], 
					preco:$_POST["preco"], 
					estoque:$_POST["estoque"], 
					imagem:$_FILES["imagem"]["name"], 
					status:"Ativo", 
					categoria:$categoria);

					foreach($_POST["fornecedor"] as $dado)
					{
						$fornecedor = new fornecedor($dado);
						$produto->setFornecedor($fornecedor);
					}
			
					$produtoDAO = new ProdutoDAO();
					$produtoDAO->inserir_produto($produto);
			
					header("location:index.php?controle=produtoController&metodo=listar");
				}
		
			}//if $_POST
	
			$categoria = new Categoria(status:"Ativo");
				
			$categoriaDAO = new CategoriaDAO();
				
			$retorno = $categoriaDAO->buscar_todas_categorias_ativas($categoria);

			$fornecedorDAO = new fornecedorDAO();
			$ret = $fornecedorDAO->buscar_todos();
				
			require_once "views/form_produto.php";
		}
		public function alterar_status()
		{
			echo "Fazer";
		}
		public function alterar()
		{
			echo "Fazer";
		}
		public function excluir()
		{
			echo "Fazer";
		}
		
	}
?>