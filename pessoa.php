<?php

    class Pessoa{
        private $pdo;
        //conexao com o Banco de dados
        public function __construct($dbname, $host, $user, $password){
           try{ 
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password);
           }catch(PDOException $e){
                echo "Erro com banco de dados " . $e->getMessage();
                exit();
           }catch(Exception $e){
                echo "Erro generico :" .$e->getMessage();
                exit();
           }
        }
        //Função para buscar os dados e colocar no canto direito da tela
        public function buscarDados(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

    }