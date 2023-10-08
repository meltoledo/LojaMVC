<?php
	class Fornecedor
	{
		public function __construct(
		
			private int $idfornecedor = 0,
			private string $razao_social = "",
			private string $cnpj = ""){}
			
			public function getIdfornecedor()
			{
				return $this->idfornecedor;
			}
			public function getRazao_social()
			{
				return $this->razao_social;
			}
			public function getCnpj()
			{
				return $this->cnpj;
			}
		
	}
	
?>