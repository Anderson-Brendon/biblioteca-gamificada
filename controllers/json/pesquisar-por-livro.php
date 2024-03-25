<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";


$titulo_livro = $_GET['titulo_livro'];

$usuario = new UsuarioBiblioteca();

$resultadoBusca = $usuario->pesquisarLivroPorTitulo($titulo_livro);

echo json_encode($resultadoBusca);