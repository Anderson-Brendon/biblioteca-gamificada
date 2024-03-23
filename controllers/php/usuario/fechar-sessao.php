<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/usuario-biblioteca.php";
$usuario = new UsuarioBiblioteca();
$usuario->fecharSessaoUsuario();
header('location:/');
?>