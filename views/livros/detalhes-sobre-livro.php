<?php
session_start();
$titulo = "Detalhes sobre livro";
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/livro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/admin-livros.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/quiz-de-livros.php';

isset($_SESSION["id_usuario"]) ?
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php' :
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-guest.php';

$id_livro = intval($_GET['id_livro']);
$livro = new Livro($id_livro);
$admin =  new AdminLivros();
$detalhesLivro = $admin->carregarInfoSobreLivro($livro);
$qzdisponivel = $detalhesLivro['quiz_esta_disponivel'];


isset($_SESSION["id_usuario"]) ?
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/livros/detalhes-sobre-livro-sessao.php' :
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/livros/detalhes-sobre-livro-guest.php'; ?>


<?php 
$msg = "Todos os livros aqui estão sob domínio público, então não existe crime de pirataria, ok?";
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>

<!--é offset/deslocamento pora nao inicio e  sempre é o msm-->
<!-- user atributos pra q nem faça solicitacao caso o valor esteja 0 -->