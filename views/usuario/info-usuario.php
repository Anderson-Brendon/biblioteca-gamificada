<?php session_start();
$titulo = "Informações de usuário";
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/usuario-biblioteca.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
isset($_SESSION['id_usuario'])?
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php':
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar-guest.php';
$id_usuario = $_GET['id_usuario'];
$usuario = new UsuarioBiblioteca();
$dadosUsuario = $usuario->carregarInfoPerfilUsuario($id_usuario);
?>
<main class="margemSobreNavBar">
    <header>
        <h1>Informações sobre: <span><?php echo $dadosUsuario['nick_usuario'] ?></span></h1>
    </header>
    <section id="infoPerfilContainer" class="mt-1">
        <div class="col-md-6 d-flex flex-column align-items-center">
                <div class="d-flex justify-content-center">
                    <img src="<?php echo $dadosUsuario['caminho_imagem_perfil'] ?>" alt="" class="col-6 col-md-9 col-lg-6">
                </div>
            <blockquote>
                <p id="citacao_favorita" class="text-center fs-3" >'<?= $dadosUsuario["citacao_favorita"] ?>'</p>
                <footer class="blockquote-footer fs-5">Autor: <cite>O valor padrão do MySql (•‿•)</cite></footer>
            </blockquote>
        </div>
        <div id="ctnInteragirDadosUsuario">
            <button id="btnExibirFavoritos" type="button" class="btn btn-dark">
                <span class="fa-solid fa-heart" style="color: #ff1414;"></span> Favoritados:
                <span><?php echo $usuario->contarNumeroDeFavoritos($dadosUsuario['id_usuario']); ?></span>
            </button>
            <button id="btnListaDeLeitura" type="button" class="btn btn-dark">
            <span class="fa-regular fa-bookmark" style="color: #00ff04;"></span>
            Marcados para ler:
            <span><?php echo $usuario->contarLivrosLidosOuNaoLidos($dadosUsuario['id_usuario'], 0) ?></span>
            </button>
            <button id="btnExibirLivrosLidos" type="button" class="btn btn-dark">
                <span class="fa-regular fa-square-check" style="color: #00ff7b;"></span> Concluídos:
                <span><?php echo $usuario->contarLivrosLidosOuNaoLidos($dadosUsuario['id_usuario'], 1)?></span>
            </button>
            <p class="border border-success border-3 p-1 text-center">
                <span class="fa-solid fa-trophy" style="color: #fff700;"></span>
                Pontos:
                <span><?php echo $dadosUsuario['pontos_totalizados_de_quiz'] ?></span>
            </p>
        </div>
    </section>
</main>
<aside id="ctnLivrosUsuario" class="m-1 esconderContainer pb-3"><div ></div></aside>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>