<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/usuario-biblioteca.php';

$usuario = new UsuarioBiblioteca();

$dadosUsuario = $usuario->fazerLoginUsuario($_POST['nick_usuario'], $_POST['senha_usuario']);

if (is_array($dadosUsuario)) {
    switch ($dadosUsuario['nivel_de_acesso']) {

        case 1:
            session_start();
            $_SESSION['id_usuario'] = $dadosUsuario['id_usuario'];
            $_SESSION['nivel_de_acesso'] = $dadosUsuario['nivel_de_acesso'];
            header('location:/admin/livros-enviados');
            break;

        default:
            header('location:/admin/login-admin');
            setcookie('msg', "Você não tem permissão para acessar essa página", time() + 1, 
            '/');
            break;
    }
} else {
    header('location:/admin/login-adm');
    setcookie('msg', "Usuário não encontrado, tente novamente", time() + 1, '/');
}