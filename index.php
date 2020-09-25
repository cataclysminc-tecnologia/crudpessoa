<?php 

require_once 'Pessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "");

?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<title>Cadastro Pessoa</title>
		<link rel="stylesheet" href="estilo.css">
	</head>
	<body>
		<?php 

			if ( isset($_POST['nome']) ) {

				if ( isset($_GET['id_up']) && !empty($_GET['id_up']) ) {

					$id_upd   = addslashes($_GET['id_up']); 
					$nome     = addslashes($_POST['nome']);
					$telefone = addslashes($_POST['telefone']);
					$email    = addslashes($_POST['email']);

					if ( !empty($nome) && !empty($telefone) && !empty($email) ) {

						$p->atualizarDados($id_upd, $nome, $telefone, $email);

					} else {
						?>
						<div>
							<img src="https://icon-icons.com/icons2/317/PNG/512/sign-warning-icon_34355.png" width="90">
							<h4>Preencha todos os campos!</h4>
						</div>
						<?php
					}

				} else {

					$nome     = addslashes($_POST['nome']);
					$telefone = addslashes($_POST['telefone']);
					$email    = addslashes($_POST['email']);

					if ( !empty($nome) && !empty($telefone) && !empty($email) ) {
						if ( !$p->cadastrarPessoa($nome, $telefone, $email) ) {
							?>
							<div class="aviso">
								<img src="https://icon-icons.com/icons2/317/PNG/512/sign-warning-icon_34355.png">
								<h4>Email já está cadastrado!</h4>
							</div>
							<?php
						}
						
					} else {
						?>
						<div class="aviso">
							<img src="https://icon-icons.com/icons2/317/PNG/512/sign-warning-icon_34355.png">
							<h4>Preencha todos os campos!</h4>
						</div>
						<?php
					}

				}

			}

		?>

		<?php

			if ( isset($_GET['id_up']) ) {
				$id_update = addslashes($_GET['id_up']);
				$res = $p->buscarDadosPessoa($id_update);
			}

		?>
		<section id="esquerda">
			<form method="POST">
				<h2>Cadastrar Pessoa</h2>
				<label for="nome">Nome</label>
					<input type="text" name="nome" id="nome" value="<?php if ( isset($res) ) { echo utf8_encode($res['nome']); } ?>">
				<label for="telefone">Telefone</label>
					<input type="text" name="telefone" id="telefone" value="<?php if ( isset($res) ) { echo $res['telefone']; } ?>">
				<label for="email">E-mail</label>
					<input type="email" name="email" id="email" value="<?php if ( isset($res) ) { echo $res['email']; } ?>">
				<input type="submit" value="<?php if ( isset($res) ) { echo 'Atualizar'; } else { echo 'Cadastrar'; } ?>">
			</form>
		</section>

		<section id="direita">
			<table>
				<thead>
					<tr id="titulo">
						<th>Nome</th>
						<th>Telefone</th>
						<th colspan="2">Email</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						$dados = $p->buscarDados();
						if ( count($dados) > 0 ) {
							for ( $i = 0; $i < count($dados); $i++ ) {
								echo '<tr>';
								foreach ( $dados[$i] as $k => $v ) {
									if ( $k != 'id' ) {
										echo '<td>'.utf8_encode($v).'</td>';
									}
								}
					?>
						<td>
							<a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
							<a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
						</td>
					<?php
								echo '</tr>';
							}

					?> 
					<?php
						} else {
							?>
				</tbody>
			</table>
						<div class="aviso">
							<h4>Ainda não há pessoas cadastradas!</h4>
						</div>
					<?php
						}
					?>
		</section>
	</body>
</html>
<?php 

	if ( isset($_GET['id']) ) {
		$id_pessoa = addslashes($_GET['id']);
		$p->excluirPessoa($id_pessoa);
		header('location: index.php');
	}

?>