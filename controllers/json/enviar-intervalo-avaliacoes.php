<?php
require_once $_SERVER['DOCUMENT_ROOT']."/models/usuario-biblioteca.php";


$offset = $_GET['offset'];
$id_livro = $_GET['id_livro'];

$usuario = new UsuarioBiblioteca();

$avaliacoes = $usuario->carregarAvaliacoesEmIntervalo($offset, $id_livro);

echo json_encode($avaliacoes);

?>