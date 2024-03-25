<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/models/usuario-biblioteca.php';

$usuario = new UsuarioBiblioteca();

$dados = file_get_contents("php://input");

$dados = json_decode($dados, true);

$id_usuario = $_SESSION['id_usuario'];

$id_livro = $dados['id_livro'];

$pagina = $dados['pagina'];

$conclusao = $usuario->salvarPagina($id_usuario, $id_livro, $pagina);

echo json_encode($conclusao);