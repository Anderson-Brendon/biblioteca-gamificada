<?php session_start();
$titulo = "Placar de líderes";
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
isset($_SESSION['id_usuario'])?
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php':
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-guest.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/quiz-de-livros.php';

$quiz = new QuizLivros;
$usuarios = $quiz->carregarMaioresPontuacoes();
?>

<main id="ctnPlacarDeLideres" class="margemSobreNavBar">
    <header>
        <h1>Placar de líderes <span><img class="col-3 col-md-1" src="/resources/icons/leaderboard-star.svg"></span></h1>
    </header>
    <?php $top = 0;
    foreach($usuarios as $usuario): ?>
    <section class="ctnPontosUsuario col-9 col-sm-6 col-md-4 col-lg-3"><h2 class="text-warning">
        <?=$top += 1?>°</h2>
        <h2><?= $usuario['nick_usuario']?> </h2>
        <a href="/informacoes-de-usuario?id_usuario=<?=$usuario['id_usuario']?>">
        <img class="col-6 col-md-6 d-none imgsToLoad zoomingAnimation" src="<?= $usuario['caminho_imagem_perfil']?>">
        </a>
        <h3 class="textSlide">Pontos totais: <span style="color:greenyellow"><?= $usuario['pontos_totalizados_de_quiz']?></span></h3>
    </section>
    <?php endforeach;?>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>