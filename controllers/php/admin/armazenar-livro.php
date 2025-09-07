<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/admin-livros.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/livro.php";

$titulo = $_POST['titulo_livro'];

$autor = $_POST['autor_livro'];

$dataPublicacao = $_POST['data_publicado'];

$descricao = $_POST['descricao_livro'];

if(isset($_POST['categoria_livro'])){
    $categoria = intval($_POST['categoria_livro']);
}else{
    $categoria = null;
}

$caminhoImagensLivro = $_SERVER['DOCUMENT_ROOT'] . "/resources/imagens/livros/";

$caminhoPdfsLivro = $_SERVER['DOCUMENT_ROOT'] . "/resources/livros-pdf/";

$imgLivro = $_FILES['imagem_livro']['tmp_name'];

$arquivoPdf = $_FILES['arquivo_pdf']['tmp_name'];

$nomeImg = $_FILES['imagem_livro']['name'];

$extensaoImg = explode(".",$nomeImg)[0];

$nomePdf = $_FILES['arquivo_pdf']['name'];

move_uploaded_file($imgLivro, $caminhoImagensLivro . $nomeImg);

move_uploaded_file($arquivoPdf , $caminhoPdfsLivro . $nomePdf);

$caminhoCompletoImg = '/resources/imagens/livros/'.$nomeImg;

$caminhoCompletoPdf = '/resources/livros-pdf/'.$nomePdf;

$livro = new Livro(null,$titulo,$dataPublicacao,$autor,$categoria, $caminhoCompletoPdf, $caminhoCompletoImg, $descricao);

$adminLivro = new AdminLivros();

$adminLivro->adicionarLivro($livro);

header('location:/admin/adicionar-livro');
