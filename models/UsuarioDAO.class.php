<?php
	class UsuarioDAO extends Conexao
	{
		public function __construct()
		{
			parent:: __construct();
		}//fim construtor
		
		public function autenticar($usuario)
		{
			$sql = "SELECT idusuario, nome, perfil FROM usuario WHERE email = ? AND senha = ?";
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $usuario->getEmail());
			$stm->bindValue(2, $usuario->getSenha());
			$stm->execute();
			$this->db = null;
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		public function inserir($usuario)
		{
			$sql = "INSERT INTO usuario (nome, email, senha, perfil) VALUES(?,?,?,?)";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $usuario->getNome());
				$stm->bindValue(2, $usuario->getEmail());
				$stm->bindValue(3, $usuario->getSenha());
				$stm->bindValue(4, $usuario->getPerfil());
				$stm->execute();
				$this->db = null;
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema no cadastro de usuário";
			}
		}//fim inserir
		public function verificar_por_email($usuario)
		{
			$sql = "SELECT email FROM usuario WHERE email = ?";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $usuario->getEmail());
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao verificar usuário pelo e-mail";
			}
		}
	}//fim da classe
?>