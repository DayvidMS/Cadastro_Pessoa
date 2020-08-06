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
        //Função cadastrar pessoa no BD
        public function cadastrarPessoa($nome, $telefone, $email){
            //Verificação de existencia de email
            $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if($cmd->rowCount() > 0)//email já existe
            {
                return false;
            }else //email não existe
            {
                $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
                $cmd->bindValue(":n",$nome);
                $cmd->bindValue(":t",$telefone);
                $cmd->bindValue(":e",$email);
                $cmd->execute();
                return true;
            }
        }
        //função excluir
        public function excluirPessoa($id){
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }

        //função Editar - Buscar dados de uma pessoa
        public function buscarDadosPessoa($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }

        //Função Editar - Atualizar dados no banco de dados
        public function atualizarDados($id,$nome,$telefone, $email){

            $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n , telefone = :t , email = :e WHERE id = :id");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            
        }

    }