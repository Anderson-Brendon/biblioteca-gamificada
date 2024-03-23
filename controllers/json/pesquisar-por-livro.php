<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";
require_once 'headers.php';

$titulo_livro = $_GET['titulo_livro'];

$usuario = new UsuarioBiblioteca();

$resultadoBusca = $usuario->pesquisarLivroPorTitulo($titulo_livro);

echo json_encode($resultadoBusca);