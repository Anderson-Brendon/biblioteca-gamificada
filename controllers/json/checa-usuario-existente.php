<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/usuario-biblioteca.php';
require_once 'headers.php';

$dadosUsuario = file_get_contents("php://input");
$dadosUsuario  = json_decode($dadosUsuario, true);

$nick_usuario = $dadosUsuario['nick_usuario'];


$usuario = new UsuarioBiblioteca();
if($usuario->usuarioExiste($nick_usuario)){
    echo json_encode(["mensagem" => "Usuário já existe, por favor tente outro nome"]);
}else{
    echo json_encode(["mensagem" => "Nome de usuário disponível"]);
}