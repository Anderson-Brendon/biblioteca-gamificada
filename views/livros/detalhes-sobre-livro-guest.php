<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/usuario-biblioteca.php";
$usuario = new UsuarioBiblioteca();
?>
<main class="margemSobreNavBar">
    <header>
        <h1 class="textSlide mt-3"><?= $detalhesLivro['titulo_livro'] ?></h1>
    </header>
    <section id="detalhesSobreLivro">
        <div class="centralizaTexto">
            <img id="imgLivro" class="col-9 col-sm-6 col-md-4 col-lg-3 zoomingAnimation esconderContainer" src="<?= $detalhesLivro['imagem_livro'] ?>" alt="">
        </div>
        <div class="mb-3" id="ctnInteracoesLivro">
            <a href="<?= $detalhesLivro['arquivo_pdf'] ?>" download="ProfileFeedback.pdf">Baixar<span class="fa-thin fa-download fa" style="color: #11ff00;"></span></a>
        <button id="<?= $qzdisponivel ? "btnRespondeQuiz":'qzIndisponivel'?>" disabled>
            <?= $qzdisponivel ? "Responder Quiz":"Quiz indisponível"?>
        </button>
            <a href="/javascript/pdfjs/web/viewer.php?file=<?= $detalhesLivro['arquivo_pdf'] ?>">Ler<span class="fa-sharp fa-book fa" style="color: #ffdd00;"></span></a>
        </div>
        <div id="quiz"></div>
        <details class="txtInfoLivro">
            <summary>Descrição</summary>
            <p class="txtInfoLivro"><?= $detalhesLivro['descricao'] ?></p>
        </details>
        <?php $data = $detalhesLivro['data_publicacao']; ?>
        <p class="textSlide txtInfoLivro mt-3">Data de publicação: <?= date('d-m-Y', strtotime($data))  ?></p>
        <p class="textSlide txtInfoLivro">Índice de aprovação:<?php for ($i = 1; $i <= round($detalhesLivro['media_avaliacao_livro']); $i++) : ?> <span class="fa-solid fa-star" style="color: #f6fa00;"></span>
        <?php endfor; ?></p>
        <p class="textSlide txtInfoLivro">Autor: <?= $detalhesLivro['autor_livro'] ?></p>
    </section>
    <div id="ctnAvaliacaoLogado">
        <button id="btnAvaliacao" type="button" disabled>Criar avaliação<span class="fa-regular fa-star" style="color: #fff700;"></span>
        </button>
    </div>
    <div id="containerBotoesAddFav">
        <button type="button" id="btnAddListaLeitura" disabled>
            <span id="statusListaLeitura">
                Adicionar a lista de leitura
            </span>
            <span id="bookMarkIcon" class="<?= $valor == 1 ? "fa-solid" : "fa-regular" ?> fa-bookmark" style="color: #007bff;"></span>
        </button>
        <button type="button" id="btnFavoritar" disabled>
            <span id="statusDefavorito">
                Adicionar aos favoritos
            </span>
            <span id="favIcon" class="fa-regular fa-heart" style="color: #ff1414;"></span>
        </button>
    </div>
    <section id="ctnAvaliacoesDosUsuarios">
        <?php $avaliacoes = $usuario->carregarAvaliacoesEmIntervalo(0, $id_livro) ?>
        <div class="col-9">
        <button id="btnRemoveCtnsAvaliacoes" class="mb-3 mb-sm-0 btn btn-warning d-none" onclick="removerContainersAvaliacoes()"><span class="text-dark">Esconder avaliações</span><span class="fa-solid fa-delete-left" style="color: #ff0000;"></span>
         </button>
            <button class="btn btn-success" offset="0" type="button" id="btnSolicitarAvaliacoes" <?= count($avaliacoes) > 0 ? "" : "disabled"?>>
                <?= count($avaliacoes) > 0? "Exibir avaliações" : "Sem avaliações" ?>
                <span class="fa-solid fa-comment" style="color: #FFD43B;"></span>
            </button>
        </div>
    </section>
</main>