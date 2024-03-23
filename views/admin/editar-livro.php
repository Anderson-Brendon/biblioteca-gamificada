<?php session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/livro.php';

$titulo = 'Editar livro';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/admin-livros.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php';

Redirecionar::usuarioSemAdmin('/galeria-de-livros');

$livro = new Livro(intval($_GET['id_livro']));

$admin = new AdminLivros($livro);

$infoLivro = $admin->carregarInfoSobreLivro($livro)

?>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-admin.php'; ?>

<main class="d-flex justify-content-center align-items-center flex-column">
<div class="d-flex justify-content-center mt-3">
        <img class="col-lg-3" src="<?php echo $infoLivro['imagem_livro'] ?>" alt="" class="">
    </div>
    <form action="" enctype="multipart/form-data" method="post" class="d-flex flex-column col-6">
        <div class="mb-3 col-6 mt-3 d-flex flex-column justify-content-center align-items-center">
            <label for="imagem_livro" class="form-label">Imagem de livro</label>
            <input type="file" class="form-control" id="imagem_livro" accept="image/png, image/jpeg">
        </div>
        <div class="mb-3">
            <label for="titulo_livro" class="form-label">Titulo de livro</label>
            <input type="text" class="form-control" id="titulo_livro" value="<?php echo $infoLivro['titulo_livro'] ?>">
        </div>
        <div class="mb-3">
            <label for="autor_livro" class="form-label">Autor de livro</label>
            <input type="text" class="form-control" id="autor_livro" value="<?php echo $infoLivro['autor_livro'] ?>">
        </div>
        <div class="mb-3">
            <label for="categoria_livro" class="form-label">Categoria do livro</label>
            <input type="text" class="form-control" id="categoria_livro" value="<?= $infoLivro['categoria_do_livro'] ?>">
        </div>
        <div class="mb-3">
            <label for="data_publicado" class="form-label">Data de publicação</label>
            <input type="date" class="form-control" id="data_publicado" value="<?php echo isset($infoLivro['data_publicado']) ? $infoLivro['data_publicado'] : "sem data"; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>