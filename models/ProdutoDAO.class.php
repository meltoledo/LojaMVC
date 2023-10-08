<?php
	class ProdutoDAO extends Conexao
	{
		public function __construct()
		{
			parent:: __construct();
		}
		
		public function buscar_todos_produtos()
		{
			$sql = "SELECT produto.*, categoria.descritivo FROM produto, categoria WHERE produto.idcategoria = categoria.idcategoria";
			//prepara a frase sql antes de executar
			$stm = $this->db->prepare($sql);
			//executa a frase sql no BD
			$stm->execute();
			//fecha a conexao com o BD
			$this->db = null;
			//returna o resultado no formato de OBJETOS
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function buscar_um_produto($produto)
		{
			$sql = "SELECT * FROM produto WHERE idproduto = ?";
			
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $produto->getIdproduto());
			$stm->execute();
			$this->db = null;
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function inserir_produto($produto)
		{
			$this->db->beginTransaction();
			$sql = "INSERT INTO produto(nome, descricao, preco, estoque, imagem, status, idcategoria)VALUES(?,?, ?, ?, ?, ?, ?)";
			
			try
			{

			
			$stm = $this->db->prepare($sql);
			//substituir os pontos de interrogação
			$stm->bindValue(1, $produto->getNome());
			$stm->bindValue(2, $produto->getDescricao());
			$stm->bindValue(3, $produto->getPreco());
			$stm->bindValue(4, $produto->getEstoque());
			$stm->bindValue(5, $produto->getImagem());
			$stm->bindValue(6, $produto->getStatus());
			$stm->bindValue(7, $produto->getCategoria()->getIdcategoria());
			
			$stm->execute();
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao inserir produto";
			}
			
			$idproduto = $this->db->lastInsertId();


			$sql = "INSERT INTO produto_fornecedor (idproduto, idfornecedor) VALUES(?,?)";
		
			foreach($produto->getFornecedor() as $dado)
			{
				
				try 
				{
					$stm = $this->db->prepare($sql);
					$stm->bindValue(1, $idproduto);
					$stm->bindValue(2, $dado->getIdfornecedor());
					$stm->execute();
				} 
				catch (PDOException $e) 
				{
					$this->db->rollback();
					$this->db = null;
					return "Problema ao inserir produto_fornecedor";
				}
			}// fim foreach
			$this->db->commit();
			$this->db = null;
			return "Produto inserido com sucesso";
			
		}// fim inserir
		
		public function alterar_produto($produto)
		{
			$sql = "UPDATE produto SET nome = ?, descricao = ?, preco = ?, estoque = ?, imagem = ?, idcategoria = ? WHERE idproduto = ?";
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $produto->getNome());
			$stm->bindValue(2, $produto->getDescricao());
			$stm->bindValue(3, $produto->getPreco());
			$stm->bindValue(4, $produto->getEstoque());
			$stm->bindValue(5, $produto->getImagem());
			$stm->bindValue(6, $produto->getCategoria()->getIdcategoria());
			$stm->bindValue(7, $produto->getIdproduto());
			$stm->execute();
			$this->db = null;
			
		}
		
		public function excluir_produto($produto)
		{
			$sql = "DELETE FROM produto WHERE idproduto = ?";
			
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $produto->getIdproduto());
			$stm->execute();
			$this->db = null;
		}
		public function alterar_status($produto)
		{
			$sql = "UPDATE produto SET status = ? WHERE idproduto = ?";
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $produto->getStatus());
			$stm->bindValue(2, $produto->getIdproduto());
			$stm->execute();
			$this->db = null;
		}
		public function buscar_todos_produtos_ativos($produto)
		{
			$sql = "SELECT * FROM produto WHERE status = ?";
			//prepara a frase sql antes de executar
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $produto->getStatus());
			//executa a frase sql no BD
			$stm->execute();
			//fecha a conexao com o BD
			$this->db = null;
			//returna o resultado no formato de OBJETOS
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
	}//fim classe
?>