<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";

$idUsuario = $_SESSION['id_usuario'];

$idLivro = file_get_contents("php://input");
$idLivro = json_decode($idLivro, true);
$idLivro = $idLivro['id_livro'];

$usuario = new UsuarioBiblioteca();

$mensagem = $usuario->removerDosFavoritos($idUsuario,$idLivro);

echo json_encode($mensagem);