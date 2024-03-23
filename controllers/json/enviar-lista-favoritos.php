<?php 
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/models/usuario-biblioteca.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/json/headers.php";


$usuario = new UsuarioBiblioteca();

if(isset($_GET['id_usuario'])){
    $id_usuario = $_GET['id_usuario'];
    $livrosFavoritos = $usuario->listarMeusLivrosFavoritos($id_usuario);
}else{
    $livrosFavoritos = $usuario->listarMeusLivrosFavoritos($_SESSION['id_usuario']);
}

echo json_encode($livrosFavoritos);