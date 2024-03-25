<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";

$dados = file_get_contents("php://input");//js manda esse
$dados = json_decode($dados, true);
$id_livro = $dados['id_livro'];
$id_usuario = $_SESSION['id_usuario'];


$usuario = new UsuarioBiblioteca();
$mensagem = $usuario->removerDaListaDeLeitura($id_usuario, $id_livro);
    
echo json_encode($mensagem);
