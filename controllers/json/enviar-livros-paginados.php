<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/admin-livros.php";

// $intervalos = file_get_contents("php://input",true);
$offset = $_GET["offset"];

$admLivros= new AdminLivros();

$livrosPaginados = $admLivros->carregarLivrosPaginados($offset);

echo json_encode($livrosPaginados);