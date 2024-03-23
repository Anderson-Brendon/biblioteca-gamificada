<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/models/usuario-biblioteca.php';

$id_usuario = $_SESSION['id_usuario'];

$dados = file_get_contents("php://input");

$dados = json_decode($dados);

$senha = $dados['senha_modificada'];


$usuario = new UsuarioBiblioteca();

$msg = $usuario->alterarSenha($id_usuario, $senha);

echo json_encode($msg);
