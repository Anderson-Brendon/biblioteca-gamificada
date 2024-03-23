<?php 
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/admin-livros.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php'; 
Redirecionar::usuarioSemAdmin('/admin/login-admin');

$titulo = 'Livros Enviados';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-admin.php';


$livros = new AdminLivros();
$listaLivros = $livros->carregarTodosLivros();
?>


<main class="d-flex align-items-center flex-wrap justify-content-evenly">
<?php foreach ($listaLivros as $livro) : ?>
        <section class="col-9 col-sm-6 col-md-4 col-lg-3 containerLivro">
            <header class="col-md-9">
                <h2 class="tituloLivro"><?php echo $livro['titulo_livro'] ?></h2>
            </header>
            <a href="/admin/editar-livro?id_livro=<?= $livro['id_livro'] ?>"><div class="loader"></div><img class="col-9 col-md-6 d-none imgsToLoad zoomingAnimation" src="<?php echo $livro['imagem_livro'] ?>">
            </a>
        </section>
    <?php endforeach ?>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>