<?php session_start();
$titulo = "Meu perfil";
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php';

Redirecionar::usuarioGuest('/galeria-de-livros');?> 

<main class="margemSobreNavBar">
    <div class="d-flex justify-content-center">
        <div class="d-none loader"></div>
    </div>
    <header>
        <h1>Meu perfil</h1>
    </header>
    <section id="infoPerfilContainer" class="mt-1">
        <form class="col-md-6" is-editing="0" id="formPerfil" method="post" enctype="multipart/form-data">
            <div>
                <label for="imagemPerfil">
                    <img id="imgPreview" src="<?php echo $dadosUsuario['caminho_imagem_perfil'] ?>" alt="" class="col-6 col-md-9 col-lg-6">
                </label>
                <input onchange="preVisualizarImagem()" type="file" accept="image/png, image/gif, image/jpeg" name="imagemPerfil" id="imagemPerfil" hidden disabled>
            </div>
            <div class="ctnInputPerfil">
                <label for="nick_usuario_sessao">Nick Atual:</label>
                <input class="rounded p-1" type="text" name="nick_usuario" id="nick_usuario_sessao" value="<?= $dadosUsuario['nick_usuario'] ?>" minlength="6" maxlength="16" disabled>
            </div>
            <div class="ctnInputPerfil">
                <label for="citacao_favorita">Citação favorita:</label>
                <input class="rounded p-1" id="citacao_favorita" name="citacao_favorita" type="text" value="<?= $dadosUsuario["citacao_favorita"] ?>" disabled>
            </div>
            <div class="ctnInputPerfil">
                <label for="autor_citacao">Autor da citação:</label>
                <input class="rounded p-1" id="autor_citacao" name="autor_citacao" type="text" value="<?= $dadosUsuario["autor_citacao"] ?>" disabled>
            </div>
            <div class="d-flex justify-content-around">
                <button id="btnEditarPerfil" type="button">Editar perfil</button>
                <button type="button" id="btnAtualizaPerfil" class="esconderContainer">Atualizar perfil</button>
            </div>
        </form>
        <div id="ctnInteragirDadosUsuario">
            <button id="btnExibirFavoritos" type="button" class="btn btn-dark">
                <span class="fa-solid fa-heart" style="color: #ff1414;"></span> Favoritados:
                <span id="qtdLivrosFavoritos"><?php echo $usuario->contarNumeroDeFavoritos($_SESSION['id_usuario']); ?></span>
            </button>
            <button id="btnListaDeLeitura" type="button" class="btn btn-dark">
            <span class="fa-regular fa-bookmark" style="color: #00ff04;"></span> Lista de leitura: 
            <span id="qtdLivrosEmLista"><?php echo $usuario->contarLivrosLidosOuNaoLidos($_SESSION['id_usuario'], 0) ?></span>
            </button>     
            <button id="btnExibirLivrosLidos" type="button" class="btn btn-dark">
                <span class="fa-regular fa-square-check" style="color: #00ff7b;"></span> Concluídos:
                <span id="qtdLivrosConcluidos"><?php echo $usuario->contarLivrosLidosOuNaoLidos($_SESSION['id_usuario'], 1)?></span>
            </button>
            <p class="border border-success border-3 p-1 text-center">
                <span class="fa-solid fa-trophy" style="color: #fff700;"></span>
                Pontos :
                <span><?php echo $dadosUsuario['pontos_totalizados_de_quiz'] ?></span>
            </p>           
        </div>
    </section>
</main>
<aside id="ctnLivrosUsuario" class="m-1 pb-3 esconderContainer zoomingAnimation"><div></div></aside>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>