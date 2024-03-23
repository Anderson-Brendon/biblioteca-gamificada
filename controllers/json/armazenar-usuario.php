<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/usuario-biblioteca.php';
require_once $_SERVER['DOCUMENT_ROOT']."/models/valida-dados.php";
require_once 'headers.php';

$dadosUsuario = file_get_contents("php://input", true);
$dadosUsuario  = json_decode($dadosUsuario, true);

$nick_usuario = validarDados::limparDados($dadosUsuario['nick_usuario']);
$senha = validarDados::limparDados($dadosUsuario['senha_usuario']);

$usuario = new UsuarioBiblioteca();


if(isset($_COOKIE['antiSpam'])){
    echo json_encode(['mensagem' => $_COOKIE['antiSpam']]);
    exit();
}


if($usuario->usuarioExiste($nick_usuario)){
    echo json_encode(["usuarioExiste" => "Usuário já existe, por favor tente outro nome"]);
}else{
    $bool = $usuario->criarUsuario($nick_usuario, $senha);
    setcookie("antiSpam","Pra evitar spam, espere 1 minuto para cadastrar novamente",time() + 60,'/');
    if($bool){echo json_encode(['mensagem' => 'Cadastro concluído, faça login']);}
};