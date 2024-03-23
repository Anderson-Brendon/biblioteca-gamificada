<?php
require_once $_SERVER['DOCUMENT_ROOT']."/models/quiz-de-livros.php";
$id_livro = $_GET['id_livro'];

$quizDeLivros = new QuizLivros();

$quiz = $quizDeLivros->carregarQuizDeLivro($id_livro);

echo json_encode($quiz);