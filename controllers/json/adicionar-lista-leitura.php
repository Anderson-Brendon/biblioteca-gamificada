<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";

$dados = file_get_contents('php://input');
$dados = json_decode($dados, true);
$idLivro = $dados['id_livro'];
$idUsuario = $_SESSION['id_usuario'];


$usuario = new UsuarioBiblioteca();
$mensagem = $usuario->adicionarListaDeLeitura($idUsuario, $idLivro);

echo json_encode($mensagem);
