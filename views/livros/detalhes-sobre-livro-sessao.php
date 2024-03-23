<?php 
$quiz = new QuizLivros();

$dadosQuizUsuario = $quiz->carregarPontuacaoUsuario($id_usuario,$id_livro);

$avaliacaoDeUsuario = $usuario->carregarAvaliacao($id_usuario, $id_livro);

$avaliacoes = $usuario->carregarAvaliacoesEmIntervalo(0, $id_livro);

$estaNaLista = $usuario->estaNaListaDeLeitura($id_usuario, $id_livro);

$estaFavoritado = $usuario->estaFavoritado($id_usuario, $id_livro);

$livroConcluido = $usuario->livroEstaLido($id_usuario, $id_livro);

$qzConcluido = $dadosQuizUsuario != false;

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
        <?php if($qzdisponivel): ?>
        <button id="btnRespondeQuiz" <?= $qzConcluido? "disabled" :"" ?>>
            <span class="<?= $qzConcluido?"text-warning":"" ?>">
                <?= $qzConcluido ? "Pontuação total: " . $dadosQuizUsuario["num_respostas_corretas"]: "Responder Quiz";?>
            </span>
        </button>
        <?php else:?>
        <button id="btnRespondeQuiz" disabled autocomplete="off">
            <?= "Quiz indisponível"?>
        </button>
        <?php endif; ?>
            <a href="/javascript/pdfjs/web/viewer.php?file=<?= $detalhesLivro['arquivo_pdf'] ?>">Ler<span class="fa-sharp fa-book fa" style="color: #ffdd00;"></span></a>
        </div>
        <div id="quiz" pontos="<?=  $pontos ?>"></div>
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
        <button id="btnAvaliacao" class="p-3" has-review="<?= $avaliacaoDeUsuario == null ? 0 : 1; ?>" type="button">
            <?= $avaliacaoDeUsuario == null ? "Criar avaliação" : "Exibir minha avaliação"; ?>
            <span class="fa-regular fa-star" style="color: #fff700;"></span>
        </button>
        <?php if ($avaliacaoDeUsuario != null) : ?>
            <div id="containerNotaComentario" class="zoomingAnimation esconderContainer">
    <h3>Minha nota</h3>
        <div class="estrelasContainer d-flex justify-content-center">
        <?php for ($i = 1; $i <= $avaliacaoDeUsuario['nota_para_livro']; $i++) : ?>
                        <span class="fa-solid fa-star" style="color: #fff700;"></span>
                    <?php endfor; ?>
        </div>
        <div>
            <h3>Meu comentário</h3>
            <textarea readonly class="p-1 bg-dark" autocomplete="off" id="inputComentario" cols="40" rows="3" maxlength="300"><?php echo $avaliacaoDeUsuario['comentario'];?></textarea>
            <div class="d-flex justify-content-between align-items-center">
            <button onclick="alternarStatusEdicao(this)" is-editing="0" class="btn btn-warning mb-3 mt-3" id="btnEditarComentario"><span class="text-dark">Editar comentário</span> <span class="fa-thin fa-pencil fa" style="color: #2b2a4c;"></span></button>
            <button class="d-none btn btn-success" id="btnEnviaEdicaoComentario" onclick="enviarComentarioEditado()"><span>Enviar edição</span></button>
        </div>
    </div>
        <?php endif; ?>
    </div>
    </div>
    <div id="containerBotoesAddFav">
        <?php if($estaNaLista && $livroConcluido):?>
        <button type="button" id="btnAddListaLeitura" disabled>
            <span>
                Livro concluído
            </span>
            <span class="fa-solid fa-check" style="color: #00ff04;"></span>
        </button>
        <?php else:?>
        <button is-on-list="<?= $estaNaLista ?>" type="button" id="btnAddListaLeitura">
            <span id="statusListaLeitura">
                <?= $estaNaLista ? "Remover da lista" : "Adicionar a lista de leitura" ?>
            </span>
            <span id="bookMarkIcon" class="<?= $estaNaLista ? "fa-solid" : "fa-regular" ?> fa-bookmark" style="color: #007bff;"></span>
        </button>
        <?php endif;?>
        <button is-favorite="<?= $estaFavoritado ?>" type="button" id="btnFavoritar">
            <span id="statusDefavorito">
                <?php echo $estaFavoritado ? "Remover dos favoritos" : "Adicionar aos favoritos" ?>
            </span>
            <span id="favIcon" class="<?= $estaFavoritado ? "fa-solid" : "fa-regular" ?> fa-heart" style="color: #ff1414;"></span>
        </button>
    </div>
    <section id="ctnAvaliacoesDosUsuarios">
    <div class="col-9">
          <button id="btnRemoveCtnsAvaliacoes" class="col-9 col-sm-5 col-md-4 mb-3 mb-sm-0 btn btn-warning d-none" onclick="removerContainersAvaliacoes()"><span class="text-dark">Esconder avaliações</span><span class="fa-solid fa-delete-left" style="color: #ff0000;"></span>
         </button>
            <button class="col-9 col-sm-5 col-md-4 btn btn-success" offset="0" type="button" id="btnSolicitarAvaliacoes" <?= count($avaliacoes) > 0 ? "" : "disabled"?>>
                <?= count($avaliacoes) > 0? "Exibir avaliações" : "Sem avaliações" ?>
                <span class="fa-solid fa-comment" style="color: #FFD43B;"></span>
            </button>
    </div>
    </section>
</main>