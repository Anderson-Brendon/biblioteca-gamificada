<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/models/usuario-biblioteca.php";

$usuario = new UsuarioBiblioteca();

if(isset($_GET['id_usuario'])){
    $id_usuario = $_GET['id_usuario'];
    $listaLivrosLidos = $usuario->carregarListaLivrosLidos($id_usuario);
    echo json_encode($listaLivrosLidos);
}else{
    $id_usuario = $_SESSION['id_usuario'];
    $listaLivrosLidos = $usuario->carregarListaLivrosLidos($id_usuario);
    echo json_encode($listaLivrosLidos);
}