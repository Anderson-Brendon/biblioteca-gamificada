<?php 
session_start();
$titulo = 'Enviar livro';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/admin-livros.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php';

Redirecionar::usuarioSemAdmin('/galeria-de-livros');?> 

?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-admin.php'; ?>


<main class="d-flex justify-content-center">
    <form action="/armazenar-livro" enctype="multipart/form-data" method="post" class="d-flex flex-column col-6">
        <img src="" alt="" class="">
            <div class="mb-3 mt-3">
                <label for="imagem_livro" class="form-label">Imagem de livro</label>
                <input type="file" class="form-control" id="imagem_livro" name="imagem_livro" accept="image/png, image/jpeg" required>
            </div>
            <div>
            <label for="imagem_livro" class="form-label">Arquivo pdf</label>
                <input type="file" class="form-control" id="arquivo_pdf" name="arquivo_pdf" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label for="titulo_livro" class="form-label">Titulo de livro</label>
                <input type="text" class="form-control" id="titulo_livro" name="titulo_livro" required>
            </div>
            <div>
                <label for="descricao_livro" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao_livro" name="descricao_livro" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <label for="autor_livro" class="form-label">Autor de livro</label>
                <input type="text" class="form-control" id="autor_livro"  name="autor_livro" required>
            </div>
            <div class="mb-3">
                <label for="categoria_livro" class="form-label">Selecione uma categoria</label>
                <select class="form-control" name="categoria_livro" id="categoria_livro">
                    <option value="1">Não disponível</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="data_publicado" class="form-label">Data de publicação</label>
                <input type="date" class="form-control" id="data_publicado" name="data_publicado">
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>