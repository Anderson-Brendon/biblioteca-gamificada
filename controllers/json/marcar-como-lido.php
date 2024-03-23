<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";
require_once 'headers.php';

$usuario = new UsuarioBiblioteca();
$dados = file_get_contents('php://input');

$dados = json_decode($dados,true);
$id_livro = $dados['id_livro'];
$id_usuario = $_SESSION['id_usuario'];

$mensagem = $usuario->marcarComoLido($id_usuario, $id_livro);

echo json_encode($mensagem);
