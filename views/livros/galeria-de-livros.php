<?php session_start();
$titulo = "Galeria dos livros";
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
isset($_SESSION['id_usuario'])?
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php':
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-guest.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/admin-livros.php' ?>

<?php $AdmLivros = new AdminLivros();
$listaDeLivros = $AdmLivros->carregarLivrosPaginados();
?>

<nav class="ctnBotoesIndice d-flex flex-column align-items-center margemSobreNavBar">
    <header>
        <h1 class="zoomForward">Livros disponíveis</h1>
    </header>
    <div>
    <?php
    $totalDeLivros = $AdmLivros->contarNumeroDeLivros();
    $paginas = ceil($totalDeLivros / 8);
    for ($i = 1; $i <= $paginas; $i++) : ?>

        <button type="button" class="botoesPagina btn btn-dark" value="<?= $i - 1 ?>"><?= $i ?></button>

    <?php endfor; ?>
    </div>
</nav>
<main id="containerLivrosDisponiveis">
    <?php foreach ($listaDeLivros as $livro) : ?>
        <section class="col-9 col-sm-6 col-md-4 col-lg-3 containerLivro">
            <header class="col-md-9">
                <h2 class="tituloLivro"><?php echo $livro['titulo_livro'] ?></h2>
            </header>
            <a href="/detalhes-sobre-livro?id_livro=<?= $livro['id_livro'] ?>"><div class="loader"></div><img class="col-9 col-md-6 d-none imgsToLoad zoomingAnimation" src="<?php echo $livro['imagem_livro'] ?>">
            </a>
            <p>Nota dos leitores:<?php if ($livro['media_avaliacao_livro'] != 0) : ?>
                <?php for ($i = 1; $i <= $livro['media_avaliacao_livro']; $i++) : ?>
                    <span class="fa-solid fa-star" style="color: #f6fa00;"></span>
                <?php endfor; ?>
            <?php else : ?>
                <span>Sem avaliações</span>
            <?php endif; ?>
            </p>
        </section>
    <?php endforeach ?>

</main>
<nav class="ctnBotoesIndice">
    <?php
    $totalDeLivros = $AdmLivros->contarNumeroDeLivros();
    $paginas = ceil($totalDeLivros / 8);
    for ($i = 1; $i <= $paginas; $i++) : ?>

        <button type="button" class="botoesPagina btn btn-dark" value="<?= $i - 1 ?>"><?= $i ?></button>

    <?php endfor; ?>
</nav>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>