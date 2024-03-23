<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/models/usuario-biblioteca.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/valida-dados.php";
require_once 'headers.php';

$id_usuario = $_SESSION['id_usuario'];
$dados = file_get_contents("php://input");
$dados = json_decode($dados, true);

$id_livro = validarDados::limparDados($dados['id_livro']);
$comentario = validarDados::limparDados($dados['comentario']);

if(strlen($comentario) > 300){
    echo json_encode(["mensagem" => "Número de caracteres não permitido"]);
    exit;
}

$usuario = new UsuarioBiblioteca();

$mensagem = $usuario->editarComentario($id_usuario, $id_livro, $comentario);

echo json_encode($mensagem);



