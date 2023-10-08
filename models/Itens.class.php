<?php
	class Itens
	{
		public function __construct(private int $iditens = 0, private int $quantidade = 0, private float $precoUnitario = 0.00, private $produto = null){}
		
		public function getIditens()
		{
			return $this->iditens;
		}
		public function getQuantidade()
		{
			return $this->quantidade;
		}
		public function getPrecoUnitario()
		{
			return $this->precoUnitario;
		}
		public function getProduto()
		{
			return $this->produto;
		}
	}
?>