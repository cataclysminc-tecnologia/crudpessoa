<?php

	class Pessoa {
		private $pdo;
		// conexao
		public function __construct($dbname, $host, $user, $pass) {
			try {
				$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$pass);
			} catch (PDOException $e) {
				echo 'Erro com banco de dados: '.$e->getMessage();
				exit();
			} catch (Exception $e) {
				echo 'Erro generico: '.$e->getMessage();
			}
		}

		public function buscarDados() {
			$res = array();
			$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY id DESC");
			$res = $cmd->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}

		public function cadastrarPessoa($nome, $telefone, $email) {
			$cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e ");
			$cmd->bindValue(':e', $email);
			$cmd->execute();

			if ( $cmd->rowCount() > 0 ) {
				return false;
			} else {
				$cmd = $this->pdo->prepare("INSERT INTO PESSOA VALUES (DEFAULT,:n ,:t ,:e) ");
				$cmd->bindValue(':n', $nome);
				$cmd->bindValue(':t', $telefone);
				$cmd->bindValue(':e', $email);
				$cmd->execute();
				return true;
			}
		}

		public function excluirPessoa($id) {
			$cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
			$cmd->bindValue(':id', $id);
			$cmd->execute();
		}

		public function buscarDadosPessoa($id) {
			$res = array();
			$cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
			$cmd->bindValue(':id', $id);
			$cmd->execute();
			$res = $cmd->fetch(PDO::FETCH_ASSOC);
			return $res;
		}

		private function verificarEmail($email) {
			$cmd = $this->pdo->prepare("SELECT email FROM pessoa WHERE email = :e");
			$cmd->bindValue(':e', $email);
			$cmd->execute();

			if ( $cmd->rowCount() > 0 ) {
				return true;
			} else {
				return false;
			}
		}

			


		public function atualizarDados($id, $nome, $telefone, $email) {

			$cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
			$cmd->bindValue(":e", $email);
			$cmd->execute();
		
			if($cmd->rowCount() > 0){
			  $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t WHERE  id = :id");
				$cmd->bindValue(":id", $id);
				$cmd->bindValue(":n", $nome);
				$cmd->bindValue(":t", $telefone);
				$cmd->execute();
		
		
			  return false;
			}else{
				$cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE  id = :id");
				$cmd->bindValue(":id", $id);
				$cmd->bindValue(":n", $nome);
				$cmd->bindValue(":t", $telefone);
				$cmd->bindValue(":e", $email);
				$cmd->execute();
		
				return true;
			}
		}

	}


?>