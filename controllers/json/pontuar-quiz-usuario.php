<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/models/quiz-de-livros.php";
$id_usuario = $_SESSION['id_usuario'];

$dadosUsuario = file_get_contents("php://input");

$dadosUsuario = json_decode($dadosUsuario, true);

$id_livro = $dadosUsuario['id_livro'];



$respostasUsuario = $dadosUsuario['respostasUsuario']; 



$quiz = new QuizLivros();

$altCorretas = $quiz->carregarAlternativasCorretas($id_livro);

$pontosTotais = 0;

for($i = 0;$i < count($altCorretas); $i++){
    if($respostasUsuario['resposta'.($i+1)] == $altCorretas[$i]['alternativa_correta']){
        $pontosTotais += 10;
    }
}

$respostasCorretas = $pontosTotais / 10;

$msgAtualizou = $quiz->atualizarPontuacaoTotal($id_usuario, $pontosTotais);

$msgConclusao = $quiz->adicionarQuizConcluido($id_usuario, $id_livro, $respostasCorretas);

if ($msgAtualizou === true && $msgConclusao === true) {
    echo json_encode(['acertos' => $respostasCorretas]);
} else {
    echo json_encode(['mensagem1' => $msgAtualizou,'mensagem2'=>$msgConclusao]);
}