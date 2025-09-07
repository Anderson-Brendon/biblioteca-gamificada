<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/models/usuario-biblioteca.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/admin-livros.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/valida-dados.php";

$avaliacao = file_get_contents("php://input");
$avaliacao = json_decode($avaliacao, true);

$id_usuario = $_SESSION['id_usuario'];

$id_livro = validarDados::limparDados($avaliacao['id_livro']);
$comentario = validarDados::limparDados($avaliacao['comentario']);
$nota =  validarDados::limparDados($avaliacao['nota_para_livro']);

if(strlen($avaliacao['comentario']) > 300){
    echo json_encode(["mensagem" => "Número de caracteres não permitido"]);
    exit;
}

$usuario = new UsuarioBiblioteca();
$admLivro = new AdminLivros();

$avaliacaoAdicionada = $usuario->adicionarAvaliacao($id_usuario, $id_livro, $nota, $comentario);

$valoresForamAtualizados = $admLivro->atualizaValoresParaCalculoDeMedia($id_livro, $nota);

$mediaFoiAtualizada = $admLivro->atualizaMediaDeLivro();

if($avaliacaoAdicionada && $valoresForamAtualizados && $mediaFoiAtualizada){
    echo json_encode(['mensagem' => 'Comentário adicionado']);
}else{
    echo json_encode(['mensagem' => 'algo não deu certo, tente novamente']);
}
