<?php
    class fornecedorDAO extends Conexao
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function buscar_todos()
        {
            $sql = "SELECT * FROM fornecedor";
            try
            {
                $stm = $this->db->prepare($sql);
                $stm->execute();
                $this->db = null;
                return $stm->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                $this->db =null;
                return "Problema ao buscar fornecedor";

            }
        }
    }
?>