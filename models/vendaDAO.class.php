<?php
	class vendaDAO extends Conexao
	{
		public function __construct()
		{
			parent:: __construct();
		}
		
		public function inserir_venda($venda)
		{
			$this->db->beginTransaction();
			$sql= "INSERT INTO venda(data_venda, idusuario) VALUES(?,?)";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $venda->getData_venda());
				$stm->bindValue(2,$venda->getUsuario()->getIdusuario());
				$stm->execute();
				$idvenda = $this->db->lastInsertId();
			}
			catch(PDOException $e)
			{
				return "Problema com a venda";
			}

			$sql ="INSERT INTO itens (quantidade, precoUnitario, idproduto, idvenda) VALUES(?,?,?,?)";
			foreach($venda->getItens() as $dado)
			{
				try
				{
					$stm = $this->db->prepare($sql);
					$stm->bindValue(1, $dado->getQuantidade());
					$stm->bindValue(2, $dado->getPrecoUnitario());
					$stm->bindValue(3, $dado->getproduto()->getIdproduto());
					$stm->bindValue(4, $idvenda);
				}
				catch(PDOException $e)
				{

					$this->db->rollback();
					$this->db = null;
					return "Erro ao inserir itens da venda";
				}
			}
			$this->db->commit();
			$this->db = null;
			return "Venda com sucesso";
		}
	}
?>