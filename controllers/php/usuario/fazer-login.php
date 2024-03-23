<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/usuario-biblioteca.php";

$nick_usuario = $_POST["nick_usuario"];
$senha_usuario = $_POST["senha_usuario"];

$usuario = new UsuarioBiblioteca();
$dadosUsuario = $usuario->fazerLoginUsuario($nick_usuario, $senha_usuario);
if (isset($dadosUsuario['id_usuario'])) {
    session_start();
    $_SESSION['id_usuario'] = $dadosUsuario['id_usuario'];
    $_SESSION['nick_usuario'] = $dadosUsuario['nick_usuario'];
    header('location:/galeria-de-livros');
} 
else 
{
    setcookie("loginNegado", "Não foi possível logar, tente novamente", time() + 1,'/');
    header("location:/");
}
