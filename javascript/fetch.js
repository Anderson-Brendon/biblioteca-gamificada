/*NavBar logica */

//alterna containers de login e cadastro
let botoesCadastroRetorna = document.querySelectorAll(".botoesCadastroRetorna");
let containerLogin = document.getElementById("containerLogin");
let containerCadastro = document.getElementById("containerCadastro");


if(botoesCadastroRetorna){
    botoesCadastroRetorna.forEach((botoes) => {
        botoes.addEventListener("click", () => {
           alternaCtnLoginCadastro();
        })
    });
}

function alternaCtnLoginCadastro(){
    if (containerCadastro.classList.contains("esconderContainer")) {
        containerCadastro.classList.remove("esconderContainer");
        containerLogin.classList.add("esconderContainer");
        containerCadastro.classList.add("zoomingAnimation");
    }
    else {
        containerCadastro.classList.add("esconderContainer");
        containerLogin.classList.remove("esconderContainer");
        containerLogin.classList.add("zoomingAnimation");
    }
}

//mostra/esconde navbar para telas <= 520px
let btnEscondeNav = document.getElementById("hideShowNavBar");
let navBar = document.getElementById("navBar");

if(btnEscondeNav){
    btnEscondeNav.addEventListener("click", () => {
        alternaExpansaoNavBar();
    })
}

function alternaExpansaoNavBar(){
    removeResultadosDePesquisa();
    btnEscondeNav.getAttribute("nav-bar-open") == 0?
        btnEscondeNav.setAttribute("nav-bar-open",1):
        btnEscondeNav.setAttribute("nav-bar-open",0);

    if (navBar.classList.contains("expandir")) {
        navBar.classList.remove("expandir");
    }else{
        navBar.classList.add("expandir");
    }   
     document.querySelectorAll("#navBar a").forEach((navEl) => {
            navEl.classList.toggle("linksNavBar");
            navEl.classList.toggle("fade-in");
        });
}

//barra de pesquisar livros
let inputPesquisa = document.getElementById("inputPesquisa");
let inputDebounce = '';

if(inputPesquisa){
    inputPesquisa.addEventListener("input", () => {
        clearTimeout(inputDebounce);
        inputDebounce = setTimeout(()=>{
            exibirResultadosPesquisa();
        },100)
    })
}

function pesquisarLivros() {
    let mn = document.querySelector("main");
    let loader = insereAnimacaoCarregamento();
    loader.classList.add("position-fixed", "fixed-top");
    if (inputPesquisa.value != "") {
        mn.prepend(loader);
        fetch(`/pesquisar-livro?titulo_livro=${inputPesquisa.value}`)
            .then((resposta) => resposta.json())
            .then((dados) => {
                let ctnLivros = document.createElement("div");
                ctnLivros.classList.add("ctnResultadoPesquisa", "col-sm-6","col-md-3", "col-md-5", "col-lg-3");
                if (dados.mensagem) {
                    let mensagem = document.createElement("p");
                    mensagem.textContent = dados.mensagem;
                    mensagem.setAttribute("id", "avisoPesquisa");
                    mensagem.classList.add("bg-dark", "textSlide", "text-center", "text-warning");
                    ctnLivros.prepend(mensagem);
                    mn.prepend(ctnLivros);
                } else {
                    ctnLivros.insertAdjacentHTML("beforeend", `<button class="btn btn-dark mt-1" type="button" onclick="removeResultadosDePesquisa()"><span class="fa-regular fa-circle-xmark" style="color: #ff0000;"></button>`)
                    for (const livro of dados) {
                        ctnLivros.insertAdjacentHTML("beforeend",
                            `<a href="../detalhes-sobre-livro?id_livro=${livro.id_livro}"><section class="livroEncontrado">
                            <img src="${livro.imagem_livro}" class="zoomingAnimation col-3">
                            <div class="d-flex flex-column justify-content-around flex-grow-1">
                            <p class="text-left">${livro.titulo_livro}</p>
                            <p class="text-left">${livro.autor_livro}</p>
                            </div></section></a>`);
                    }
                    mn.prepend(ctnLivros);
                }
                loader.remove();
            }).catch(error => console.log(error))
    }
}

function exibirResultadosPesquisa(){
    ocultarLinksNavBar();
    removeResultadosDePesquisa();
    pesquisarLivros();  
}

//remove todos os elementos com a classe que estiliza os livros encontrados sempre que clicar fora do input

function removeResultadosDePesquisa(){
    let ctnPesquisa = document.querySelector(".ctnResultadoPesquisa");
    if (ctnPesquisa != null) {     
        ctnPesquisa.remove();
    };
    if (document.getElementById("avisoPesquisa") != null) {
        document.getElementById("avisoPesquisa").remove();
    }
}

function ocultarLinksNavBar(){
    let btn = document.getElementById("hideShowNavBar");
    if(btn.getAttribute("nav-bar-open") == 1){
        alternaExpansaoNavBar();
    }
}

//criar conta
function realizaCadastro() {
    let inputNick = document.getElementById("nomeUsuarioCadastro");
    let inputSenha = document.getElementById("senhaUsuarioCadastro");

    if (inputNick.value.length >= 6 && inputSenha.value.length >= 6) {
        fetch("/armazenar-usuario", {
            method: "POST",
            mode: "same-origin",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nick_usuario: inputNick.value, senha_usuario: inputSenha.value })
        }).then(resposta => {if(resposta.ok){return resposta.json()}{console.log(resposta)}})
            .then(dados => {
                if ('usuarioExiste' in dados) {
                    criarTextoParaAviso(dados.usuarioExiste, "containerCadastro", null, "textSlide", 6000, "gold");
                }
                else {
                    criarTextoParaAviso(dados.mensagem, "containerCadastro", null,"textSlide", 6000, "gold");
                }
            }).catch(erro => console.log(erro))
    }else{
        criarTextoParaAviso("É necessário no mínimo 6 caracteres por campo", "containerCadastro",null, "textSlide", 6000, "gold");
    }
}

/*pagina galeria de livros*/

let imgLivro = document.getElementById("imgLivro");

let imgs = document.querySelectorAll(".imgsToLoad");

function mostrarImgCarregada(imgEl){
    let ctn = imgEl.parentNode;
    let divLoader = ctn.firstChild;
    divLoader.remove();
    imgEl.classList.remove("d-none");
}

function animarImgAoCarregar(ImgElemento, anim) {
    ImgElemento.classList.remove("esconderContainer");
    ImgElemento.classList.add(anim);
}

if(imgLivro){
    imgLivro.onload = animarImgAoCarregar(imgLivro, 'zoomingAnimation');
}

if(imgs){
    for (const img of imgs) {
        img.onload = mostrarImgCarregada(img);
    }
}

//solicitar livros em intervalo
let botoesDeindice = document.querySelectorAll(".botoesPagina");

botoesDeindice.forEach((botao) => {
    botao.addEventListener("click", (e) => {
        solicitarLivrosPaginados(e.target.value);
    });
})

function solicitarLivrosPaginados(offset) {
    fetch(`/livros-paginados?offset=${offset * 8}`, {
        method: "GET",
        mode: "same-origin",
    }).then(resposta => resposta.json())
        .then(livrosRecebidos => {
            let fragmentoHtml = new DocumentFragment;
            let sectionLivro;
            let livrosAtuais = document.querySelectorAll(".containerLivro");
            let containerMain = document.getElementById("containerLivrosDisponiveis");
            window.scrollTo(0, 0);
            for (const livro of livrosRecebidos) {
                sectionLivro = document.createElement("section");
                sectionLivro.classList.add("containerLivro", "col-9","col-sm-6" ,"col-md-4","col-lg-3" ,"zoomingAnimation");

                //inserção de dados da array de objetos e atrelamento ao elemento section

                let estrelas = ``;
                if (livro.media_avaliacao_livro > 0) {
                    for (let index = 1; index <= livro.media_avaliacao_livro; index++) {
                        estrelas += `<span class="fa-solid fa-star" style="color: #f6fa00;"></span>`;
                    }
                } else {
                    estrelas = "Sem avaliações";
                }

                sectionLivro.insertAdjacentHTML("afterbegin",
                    `<header class="col-md-9">
                    <h2 class="tituloLivro">${livro.titulo_livro}</h2></header>
                <a href="/detalhes-sobre-livro?id_livro=${livro.id_livro}"><div class="loader"></div><img onload="mostrarImgCarregada(this)" class="col-9 col-md-6 d-none imgsToLoad zoomingAnimation" src="${livro.imagem_livro}"></a>
                <p>Nota dos leitores: ${estrelas}</p>`
                );

                //atrelamento da section ao fragmento de html 
                fragmentoHtml.appendChild(sectionLivro);
            }
            //remoção dos containers de livros que estão no dom
            livrosAtuais.forEach(function removerElementos(livro) {
                livro.remove();
            })
            //adição dos resultados de livro
            containerMain.appendChild(fragmentoHtml);
        }).catch(erro => { console.log(erro) })
}

/*pagina detalhes-sobre-livro */

//adiciona aos livros favoritos
let btnFavoritar = document.getElementById("btnFavoritar");
let statusDefavorito = document.getElementById("statusDefavorito");
let favIcon = document.getElementById("favIcon");

if (btnFavoritar) {
    btnFavoritar.addEventListener("click", () => {
        if (btnFavoritar.getAttribute("is-favorite") == 0) {
            favoritarLivro();
        }
        else {
            removerDosFavoritos();
        }
    })
}


function favoritarLivro() {
    let parametro = new URLSearchParams(document.location.search);
    fetch("/armazenar-favorito", {
        method: "POST",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro") })
    }).
        then(resposta => resposta.json()).
        then(dados => {
            statusDefavorito.textContent = "Remover dos favoritos";
            btnFavoritar.setAttribute("is-favorite", 1);
            if (btnFavoritar.classList.contains("flip-horizontal-bottom")) {
                btnFavoritar.classList.remove("flip-horizontal-bottom");
                btnFavoritar.offsetWidth;
            }
            btnFavoritar.classList.add("flip-horizontal-bottom");
            favIcon.classList.remove("fa-regular");
            favIcon.classList.add("fa-solid");
            console.log(dados);
        }).
        catch(erro => { console.log(erro) });
}

function removerDosFavoritos() {
    let parametro = new URLSearchParams(document.location.search);
    fetch("/deletar-favorito", {
        method: "DELETE",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro") })
    }).
        then(resposta => resposta.json()).
        then(dados => {
            statusDefavorito.textContent = "Adicionar aos favoritos";
            if (btnFavoritar.classList.contains("flip-horizontal-bottom")) {
                btnFavoritar.classList.remove("flip-horizontal-bottom");
                btnFavoritar.offsetWidth;
            }
            btnFavoritar.classList.add("flip-horizontal-bottom");
            btnFavoritar.setAttribute("is-favorite", 0);
            favIcon.classList.remove("fa-solid");
            favIcon.classList.add("fa-regular");
            console.log(dados)
        }).
        catch(erro => { console.log(erro) });
}

//adicionar para lista de leitura
let btnAddListaLeitura = document.getElementById("btnAddListaLeitura");
let statusListaLeitura = document.getElementById("statusListaLeitura");
let bookMarkIcon = document.getElementById("bookMarkIcon");

if (btnAddListaLeitura) {
    btnAddListaLeitura.addEventListener("click", () => {
        if (btnAddListaLeitura.getAttribute("is-on-list") == 0) {
            adicionarListaDeLeitura();
        } else {
            removerDaListaDeLeitura();
        }
    })
}


function adicionarListaDeLeitura() {
    let parametro = new URLSearchParams(document.location.search);
    fetch("/armazenar-livro-lista", {
        method: "POST",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro") })
    }).
        then(resposta => resposta.json()).
        then(dados => {
            if (dados.erroPdo) {
                console.log(dados.erroPdo);
            } else {
                statusListaLeitura.textContent = "Remover da lista de leitura";
                btnAddListaLeitura.setAttribute("is-on-list", 1);
                if (btnAddListaLeitura.classList.contains("flip-horizontal-bottom")) {
                    btnAddListaLeitura.classList.remove("flip-horizontal-bottom");
                    btnAddListaLeitura.offsetWidth;
                }
                btnAddListaLeitura.classList.add("flip-horizontal-bottom");
                bookMarkIcon.classList.remove("fa-regular");
                bookMarkIcon.classList.add("fa-solid");
            }
        }).
        catch(erro => { console.log(erro) });
}

function removerDaListaDeLeitura() {
    let parametro = new URLSearchParams(document.location.search);
    fetch("/deletar-livro-lista", {
        method: "DELETE",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro") })
    }).
        then(resposta => resposta.json()).
        then(dados => {
            statusListaLeitura.textContent = "Adicionar a lista de leitura";
            btnAddListaLeitura.setAttribute("is-on-list", 0);
            if (btnAddListaLeitura.classList.contains("flip-horizontal-bottom")) {
                btnAddListaLeitura.classList.remove("flip-horizontal-bottom")
                btnAddListaLeitura.offsetWidth;
            }
            btnAddListaLeitura.classList.add("flip-horizontal-bottom");
            bookMarkIcon.classList.remove("fa-solid");
            bookMarkIcon.classList.add("fa-regular");
            console.log(dados);
        }).
        catch(erro => { console.log(erro) });
}

let btnMarcarLido = document.getElementById("btnMarcarLido");

if (btnMarcarLido) {
    btnMarcarLido.addEventListener("click", () => {
        if (btnMarcarLido.value == 0) {
            btnMarcarLido.value = 1;
            marcarLivroComoLido();
        }
        else {
            alert("Não dá pra desmarcar jkjkjk, eu quis assim.");
        }
    })
}

//avaliacao

let btnAvaliacao = document.getElementById("btnAvaliacao");
let ctnAvaliacaoLogado = document.getElementById("ctnAvaliacaoLogado");

if (btnAvaliacao) {
    btnAvaliacao.addEventListener("click", () => {
        if (btnAvaliacao.getAttribute("has-review") == 0) {
            criarAvaliacao();
        } else if (containerNotaComentario.classList.contains("esconderContainer")) {
            exibirMinhaAvaliacao();
        } else {
            ocultarMinhaAvaliacao();
        }
    });
}

function exibirMinhaAvaliacao() {
    let containerNotaComentario = document.getElementById("containerNotaComentario");
    containerNotaComentario.classList.remove("esconderContainer");
    btnAvaliacao.firstChild.textContent = "Ocultar avaliação";
}

function ocultarMinhaAvaliacao() {
    let containerNotaComentario = document.getElementById("containerNotaComentario");
    containerNotaComentario.classList.add("esconderContainer");
    btnAvaliacao.firstChild.textContent = "Exibir minha avaliação";
}

function cancelarEnvioDeAvaliacao() {
    let containerNotaComentario = document.getElementById("containerNotaComentario");
    containerNotaComentario.remove();
    btnAvaliacao.classList.remove("esconderContainer");
}

function retornaNotaSelecionada() {
    let valoresNota = document.getElementsByName("valorNota");
    let nota = 0;
    for (const valorNota of valoresNota) {
        if (valorNota.checked) {
            nota = valorNota.value;
            return nota;
        }
    }
}

function criarAvaliacao() {
    ctnAvaliacaoLogado.insertAdjacentHTML("beforeend", `<div id="containerNotaComentario" class=" zoomingAnimation">
    <h3>Minha avaliação</h3>
        <div class="estrelasContainer d-flex justify-content-center">
            <input type="radio" name="valorNota" id="nota5" value=5 hidden>
            <label for="nota5" class="starUnicode"><i class="fa-solid fa-star" style="color: #f6fa00;"></i>
            </label>
            <input type="radio" name="valorNota" id="nota4" value=4 hidden>
            <label for="nota4" class="starUnicode"><i class="fa-solid fa-star" style="color: #f6fa00;"></i>
            </label>
            <input type="radio" name="valorNota" id="nota3" value=3 hidden>
            <label for="nota3" class="starUnicode"><i class="fa-solid fa-star" style="color: #f6fa00;"></i>
            </label>
            <input type="radio" name="valorNota" id="nota2" value=2 hidden>
            <label for="nota2" class="starUnicode"><i class="fa-solid fa-star" style="color: #f6fa00;"></i>
            </label>
            <input type="radio" name="valorNota" id="nota1" value=1 hidden>
            <label for="nota1" class="starUnicode"><i class="fa-solid fa-star" style="color: #f6fa00;"></i>
            </label>
        </div>
        <div>
            <h3>Comentario(Opcional)</h3>
            <textarea autocomplete="off" class="p-1 bg-dark" id="InputComentario" cols="40" rows="3" maxlength="300"></textarea>
            <div class="d-flex justify-content-between">
            <button class="btn btn-secondary" type="button" id="btnEnviarAvaliacao" onclick="enviarAvaliacao()">
            Enviar
            <span class="fa-solid fa-upload" style="color: #00ffaa;"></span></button>
            <button class="btn btn-secondary" type="button" id="btnCancelaEnvio" onclick="cancelarEnvioDeAvaliacao()">
            Cancelar
            <span class="fa-regular fa-circle-xmark" style="color: #ff0000;"></span></button>
            </div>
        </div>
    </div>`);

    btnAvaliacao.classList.add("esconderContainer");

}


function enviarAvaliacao() {
    let nota = retornaNotaSelecionada();
    let comentarioTxt = document.getElementById("InputComentario");
    if (nota != null) {
        let parametro = new URLSearchParams(document.location.search);
        fetch("/armazenar-avaliacao", {
            method: "POST",
            mode: "same-origin",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id_livro: parametro.get("id_livro"), nota_para_livro: nota, comentario: comentarioTxt.value })
        })
            .then(resposta => resposta.json())
            .then(dados => {
                fixarComentarioEnviado(nota, comentarioTxt.value);
                btnAvaliacao.setAttribute("has-review", 1);
                console.log(dados.mensagem);
            }).catch(error => { console.log(error) });

    } else {
        alert("Dê uma nota ao livro")
    }
}

function fixarComentarioEnviado(nota, comentario) {
    let ctnNotaComentario = document.getElementById("ctnAvaliacaoLogado");
    if(ctnNotaComentario.hasChildNodes){
        ctnNotaComentario.innerHTML = '';
    }
    ctnAvaliacaoLogado.innerHTML = '';
    let estrelas = '';
    for (let i = 1; i <= nota; i++) {
        estrelas += '<i class="fa-solid fa-star" style="color: #eeff00;"></i>'
    }
    ctnAvaliacaoLogado.insertAdjacentHTML("beforeend",`<div id="containerNotaComentario" class=" zoomingAnimation">
    <h3>Minha avaliação</h3>
        <div class="estrelasContainer d-flex justify-content-center">
            ${estrelas}
        </div>
        <div>
            <h3>Meu comentário</h3>
            <textarea readonly class="p-1 bg-dark" autocomplete="off" id="inputComentario" cols="40" rows="3" maxlength="300">${comentario?comentario:'Sem comentário'}</textarea>
            <div class="d-flex justify-content-between align-items-center">
            <button readonly is-editing="0" class="btn btn-warning mb-3 mt-3" id="btnEditarComentario" onclick="alternarStatusEdicao(this)"><span>Editar comentário</span><span class="fa-thin fa-pencil fa" style="color: #2b2a4c;"></span>
            <button is-editing="0" class="d-none btn btn-success" id="btnEnviaEdicaoComentario" onclick="enviarComentarioEditado(); "><span>Enviar edição</span><button>
            </div>
        </div>
    </div>`);
    ctnNotaComentario.classList.add("zoomingAnimation");
    textoAntesEdicao = document.getElementById("inputComentario").value;
}

//editar comentario
let inputComentario = document.getElementById("inputComentario");
let textoAntesEdicao = '';

if(inputComentario){
    textoAntesEdicao = inputComentario.value;
}

function alternarStatusEdicao(btn) {
    if (btn.getAttribute("is-editing") == 0) {
        editarComentario();
    }
    else {
        cancelarEdicaoComentario();
    }
}

function editarComentario() {
    let btnEditarComentario = document.getElementById("btnEditarComentario");

    btnEditarComentario.setAttribute("is-editing","1");
    let btnEnviaEdicao = document.getElementById("btnEnviaEdicaoComentario");
    btnEnviaEdicao.classList.remove("d-none");

    if(inputComentario){
        inputComentario.removeAttribute("readonly");
    }else{
        inputComentario = document.getElementById("inputComentario");
        inputComentario.removeAttribute("readonly");
    }
    btnEditarComentario.firstChild.textContent = "Cancelar edição";
}

function cancelarEdicaoComentario(textoAnterior = true) {
    let btnEditarComentario = document.getElementById("btnEditarComentario");

    btnEditarComentario.setAttribute("is-editing","0");
    let btnEnviaEdicao = document.getElementById("btnEnviaEdicaoComentario");
    inputComentario.setAttribute("readonly","");
    btnEnviaEdicao.classList.add("d-none");
    btnEditarComentario.firstChild.textContent = "Editar comentário";
    if(textoAnterior){
        inputComentario.value = textoAntesEdicao;
    }
}

function enviarComentarioEditado(){
    let ctn = document.getElementById("containerNotaComentario");
    if(inputComentario.value.length > 1){
    let texto = inputComentario.value;
    let parametro = new URLSearchParams(document.location.search);
    fetch("/atualizar-comentario", {
        method: "PUT",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro"), comentario: texto })
    }).then(resposta => resposta.json())
        .then(dados => {
            textoAntesEdicao =  inputComentario.value;
            criarTextoParaAviso("Comentário editado",null,ctn,'textSlide',3000,"greenyellow");
            cancelarEdicaoComentario(false);
            console.log(dados.mensagem);
        }).catch(error => { console.log(error) });
    }else{
        criarTextoParaAviso("Digite no mínimo 1 caracter" ,null, ctn,"textSlide",3000,"red");
    }
}

//listar avaliacoes de usuarios
let btnSolicitarAvaliacoes = document.getElementById("btnSolicitarAvaliacoes");
let divBtn;

if (btnSolicitarAvaliacoes) {
    btnSolicitarAvaliacoes.addEventListener("click", () => {
        offset = btnSolicitarAvaliacoes.getAttribute("offset");
        solicitarAvaliacoesEmIntervalo(offset);
    })
}

function solicitarAvaliacoesEmIntervalo(offset) {
    let parametro = new URLSearchParams(document.location.search);
    let id_livro = parametro.get("id_livro");
    fetch(`/avaliacoes-sobre-livro?offset=${offset}&&id_livro=${id_livro}`).
        then(resposta => resposta.json()).
        then(dados => {
            window.scrollTo(0, document.body.scrollHeight);
            if (dados.length > 0) {

                for (const avaliacao of dados) {
                    criaContainerAvaliacaoDeUsuarios(avaliacao);
                }

                offset = Number(btnSolicitarAvaliacoes.getAttribute("offset"));

                btnSolicitarAvaliacoes.setAttribute("offset", offset += 5);
                let txtNode = btnSolicitarAvaliacoes.firstChild;
                txtNode.nodeValue = "Exibir mais avaliacoes";

            } else {
                desativaInput(btnSolicitarAvaliacoes);
                let txtNode = btnSolicitarAvaliacoes.firstChild;
                txtNode.nodeValue = "Sem avaliações disponíveis";
            }
        })
}

function criaContainerAvaliacaoDeUsuarios(avaliacao) {
    let ctnAvaliacoesDosUsuarios = document.querySelector("#ctnAvaliacoesDosUsuarios > div");

    if(btnSolicitarAvaliacoes.getAttribute("offset") == 0){
        let btn = document.getElementById("btnRemoveCtnsAvaliacoes");
        btn.classList.remove("d-none");
    }
    let estrelas = '';
    for (let i = 1; i <= avaliacao.nota_para_livro; i++) {
        estrelas += `<span class="fa-solid fa-star" style="color: #f6fa00;"></span>`
    }
    ctnAvaliacoesDosUsuarios.insertAdjacentHTML("beforebegin", 
    `<article class="col-md-9 col-lg-6 p-1 ctnAvaliacaoComentario zoomingAnimation ">
    <div class="col-md-6 d-flex flex-column align-items-center">
        <h3 class="p-1">${avaliacao.nick_usuario}</h3>
        <a class="col-6" href="/informacoes-de-usuario?id_usuario=${avaliacao.id_usuario}">
        <img class="col-9" src="${avaliacao.caminho_imagem_perfil}" alt="">
        </a>
        <div class="mt-1 mb-1 d-flex justify-content-center">
        ${estrelas}
        </div>
    </div>
        <p>${avaliacao.comentario}</p>
    </article>`)
}

function removerContainersAvaliacoes() {
    let avaliacoesCtns = document.querySelectorAll("section article");

    for(avalicaoCtn of avaliacoesCtns){
        avalicaoCtn.remove();
    }

    let btn = document.getElementById("btnRemoveCtnsAvaliacoes");
    btn.classList.add("d-none");
    btnSolicitarAvaliacoes.setAttribute("offset", 0);

    let txtNode = btnSolicitarAvaliacoes.firstChild;
    txtNode.nodeValue = "Exibir avaliações";
    habilitaInput(btnSolicitarAvaliacoes);
}

/*pagina meu-perfil */

//atualizar informacoes de perfil
let dadosDeFormulario = document.getElementById("formPerfil");
let btnEditarPerfil = document.getElementById("btnEditarPerfil");
let btnAtualizaPerfil = document.getElementById("btnAtualizaPerfil");

//entradas do usuario
let nickInput = document.getElementById("nick_usuario_sessao");
let imgPerfil = document.getElementById("imagemPerfil");
let citacaoInput = document.getElementById("citacao_favorita");
let autorCitacao = document.getElementById("autor_citacao");

//dados atuais
let nickAtual = '', imgPerfilAtual = '',citacaoAtual = '', autorCitacaoAtual = '';

//checa se elemento está na lista de nós
if (btnEditarPerfil) {
    btnEditarPerfil.addEventListener("click", () => {
        dadosDeFormulario.getAttribute("is-editing") == "0" ?
            editarPerfil() :
            cancelarEdicaoDePerfil();
    })
}

if (btnAtualizaPerfil) {
    btnAtualizaPerfil.addEventListener("click", () => {
        enviarModificaoDePerfil();
    })
}

if (nickInput) {
    guardaInfoDePerfilAtual();
}

function insereInfoPerfilAnterior() {
    let imgPreview = document.getElementById('imgPreview');
    nickInput.value = nickAtual;
    imgPreview.setAttribute("src", imgPerfilAtual);
    citacaoInput.value = citacaoAtual;
}

function guardaInfoDePerfilAtual() {
    let imgPreview = document.getElementById('imgPreview');
    nickAtual = nickInput.value;
    imgPerfilAtual = imgPreview.src;
    autorCitacaoAtual = autorCitacao.value;
    citacaoAtual = citacaoInput.value;
}

function checaEntradaDoUsuario() {
    return nickInput.value != nickAtual || citacaoInput.value != citacaoAtual  || imgPerfil.files.length 
}

function preVisualizarImagem() {
    let imgPreview = document.getElementById('imgPreview');
    let arquivoImg = document.querySelector('input[type=file]').files[0];
    let leitor = new FileReader();

    leitor.onloadend = function () {
        imgPreview.src = leitor.result;
    }

    if (arquivoImg) {
        leitor.readAsDataURL(arquivoImg);
    } else {
        imgPreview.src = imgPerfilAtual;
    }

    imgPreview.classList.add("zoomingAnimation");
}

function editarPerfil() {
    let imgPreview = document.getElementById('imgPreview');

    nickInput.removeAttribute("disabled");
    citacaoInput.removeAttribute("disabled");
    imgPerfil.removeAttribute("disabled");
    autorCitacao.removeAttribute("disabled");
    dadosDeFormulario.setAttribute("is-editing", "1");

    btnEditarPerfil.style.backgroundColor = "rgb(255, 100, 100)";
    btnEditarPerfil.textContent = "Cancelar edição";

    btnAtualizaPerfil.classList.remove("esconderContainer");
}

function cancelarEdicaoDePerfil(inserirPerfilAnterior = true) {
    let imgPreview = document.getElementById('imgPreview');
    
    
    nickInput.setAttribute("disabled", "");
    citacaoInput.setAttribute("disabled", "");
    imgPerfil.setAttribute("disabled", "");
    autorCitacao.setAttribute("disabled", "");
    dadosDeFormulario.setAttribute("is-editing", "0");

    btnEditarPerfil.style.backgroundColor = "dodgerblue";
    btnEditarPerfil.textContent = "Editar perfil";

    btnAtualizaPerfil.classList.add("esconderContainer");
    if(inserirPerfilAnterior){
        insereInfoPerfilAnterior();
    }
}

function alterarImgNavBar(url){
    let img = document.querySelector("nav a img");
    setTimeout(() =>{
        img.src = url;
    },1600);
}

function enviarModificaoDePerfil() {
    let ctn = document.querySelector("main header");
    let loader = document.querySelector(".loader");
    if (checaEntradaDoUsuario()) {
        loader.classList.remove("d-none");
        fetch('/atualizar-perfil', {
            method: "POST",
            body: new FormData(dadosDeFormulario)
        }).then(resposta => resposta.json())
            .then(dados => {
                loader.classList.add("d-none");
                cancelarEdicaoDePerfil(false);
                criarTextoParaAviso(dados.mensagem, null,ctn, "zoomingAnimation", 6000, "greenyellow");
                guardaInfoDePerfilAtual();
                if(dados.urlImgPerfil){
                    alterarImgNavBar(dados.urlImgPerfil);
                }
                console.log(dados);
            }).catch(erro => { console.log(erro) });
    }else{
        criarTextoParaAviso("Altere pelo menos um dos campos", null,ctn, "zoomingAnimation", 6000, "red");
    }
}

//editar senha 

let btnEditarSenha = document.getElementById("btnEditarSenha");
let senhaInput = document.getElementById("senha_usuario");
let btnEnviarSenha = document.getElementById("btnEnviarSenha");

if (btnEditarSenha) {
    btnEditarSenha.addEventListener("click", () => {
        senhaInput.getAttribute("disabled") != null ?
            editarSenha() :
            cancelarAlteracaoSenha();
    })
}

if (btnEnviarSenha) {
    btnEnviarSenha.addEventListener("click", () => {
        enviarSenhaAlterada();
    })
}

function editarSenha() {
    let btnEnviarSenha = document.getElementById("btnEnviarSenha");
    senhaInput.removeAttribute("disabled");
    senhaInput.classList.remove("d-none");
    btnEnviarSenha.removeAttribute("disabled");
    btnEnviarSenha.classList.remove("d-none");

    btnEditarSenha.textContent = "Cancelar mudança";
}

function cancelarAlteracaoSenha() {
    let btnEnviarSenha = document.getElementById("btnEnviarSenha");
    senhaInput.value = '';
    senhaInput.setAttribute("disabled", "true");
    senhaInput.classList.add("d-none");
    btnEnviarSenha.setAttribute("disabled", "true");
    btnEnviarSenha.classList.add("d-none");

    btnEditarSenha.textContent = "Editar Senha";
}

function enviarSenhaAlterada() {
    fetch("/alterar-senha", {
        method: POST,
        body: senhaInput.value
    }).then(resposta => resposta.json())
        .then(dados => {
            criarTextoParaAviso(dados.mensagem, "infoPerfilContainer",null, "zoomingAnimation", 6000, "greenyellow");
        }).catch(erro => {
            console.log(erro);
        });
}

//livros em pagina de perfil
//solicitar lista de livros em lista de leitura
let btnExibeListaLeitura = document.getElementById("btnListaDeLeitura");

if (btnExibeListaLeitura) {
    btnExibeListaLeitura.addEventListener("click", async () => {
        try {
            livrosPendentes = await solicitarLivrosEmListaDeLeitura();
            exibirLivrosEmListaDeLeitura(livrosPendentes, "Livros marcados");     
            exibeCtnDeLivrosDoUsuario();
            window.scrollTo(0, document.body.scrollHeight);
        } catch (error) {
            console.log(error)
        }

    })
}

async function solicitarLivrosEmListaDeLeitura() {
    let urlParam = new URLSearchParams(document.location.search);
    let usuarioParam = urlParam.get("id_usuario");
    if(usuarioParam){
        return fetch(`/lista-de-leitura?id_usuario=${usuarioParam}`).then(resposta => resposta.json());
    }else{
        return fetch(`/lista-de-leitura`).then(resposta => resposta.json());
    }   
}

function exibirLivrosEmListaDeLeitura(livrosUsuario, nomeLista) {
    let params = new URLSearchParams(document.location.search);
    let userParam = params.get("id_usuario");

    let ctnLivrosUsuario = document.querySelector("aside div");

    removerListaUsuario();
    removeTituloLista();
    
    ctnLivrosUsuario.insertAdjacentHTML("beforebegin", `<header><h2 class="titulo-lista text-info text-center">${nomeLista}<span onclick="removerListaUsuario()" class="fa-solid fa-xmark" style="color: #ff0000;"></span></h2></header>`)
    for (const livro of livrosUsuario) {
        ctnLivrosUsuario.insertAdjacentHTML("beforeend", `<section class="d-flex flex-column align-items-center col-9 col-md-6 col-lg-5 mb-1">
        <header>
        <h1 style="font-size:small;">${livro.titulo_livro}</h1>
        </header>
        <div class="mb-3 text-center">
        <a href="/detalhes-sobre-livro?id_livro=${livro.id_livro}">
        <img class="col-6" src="${livro.imagem_livro}">
        </a>
        </div>
        ${userParam?``:`<a href="/javascript/pdfjs/web/viewer.php?file=${livro.arquivo_pdf}&&pagina=${livro.pagina_salva}" class="bg-warning text-dark p-1">
        Continuar leitura
        </a>
        <div class="mt-3 d-flex justify-content-center">
        <label for="paginaInput">Salvar Página:   </label>
        <input id-livro="${livro.id_livro}" value="${livro.pagina_salva}" class="paginaInput" name="paginaInput" type="number" class="col-3">
        <button class="col-1 col-md-3" class="btnSalvaPagina" type="button" onclick="salvarPagina(this)">
        <img class="col-9 col-md-3" src="/resources/icons/disk-svgrepo-com.svg">
        </button>
        </div>
        <button class="mt-3 btn btn-success" id-livro="${livro.id_livro}" type="button" onclick="marcarLivroComoLido(this)">
        <span>Marcar como lido</span>
        <span class="fa-solid fa-check" style="color: #FFD43B;"></span>
        </button>`}
        </section>`)
    }

}

function salvarPagina(alvoEvento) {
    let paginaInput = alvoEvento.previousElementSibling;

    fetch("/atualizar-pagina", {
        method: "PUT",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            id_livro: parseInt(paginaInput.getAttribute("id-livro")),
            pagina: parseInt(paginaInput.value)
        })
    })
        .then(resposta => resposta.json())
        .then(dados => {
            console.log(dados); 
            alert("Página salva");
        })
        .catch(error => { console.log(error) });
}

function marcarLivroComoLido(alvoEvento) {
    fetch("/marcar-lido", {
        method: "PUT",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parseInt(alvoEvento.getAttribute("id-livro")) })
    })
        .then(resposta => resposta.json())
        .then(resposta => {
            if (resposta.mensagem) {
                removeContainerPai(alvoEvento);
                criarTextoParaAviso(resposta.mensagem, "ctnLivrosUsuario", "textSlide", 3, "gold");
            }
        })
}

//solicitar lista de favoritos
let btnExibirFavoritos = document.getElementById("btnExibirFavoritos");

if (btnExibirFavoritos) {
    btnExibirFavoritos.addEventListener("click", async () => {
        try {
            let listaFavoritos = await solicitarListaDeFavoritos();
            exibirLivrosFavoritos(listaFavoritos, "Favoritados");
            exibeCtnDeLivrosDoUsuario();
            window.scrollTo(0, document.body.scrollHeight);
        } catch (error) {
            console.log(error);
        }
    })
}

function exibeCtnDeLivrosDoUsuario() {
    let ctn = document.getElementById("ctnLivrosUsuario");
    if (ctn.classList.contains("esconderContainer")) {
        ctn.classList.remove("esconderContainer")
    }
}

async function solicitarListaDeFavoritos() {
    let urlParam = new URLSearchParams(document.location.search);
    let paramUsuario = urlParam.get("id_usuario");
    if(paramUsuario){
        return fetch(`/lista-de-favoritos?id_usuario=${paramUsuario}`)
        .then(resposta => resposta.json());
    }else{
        return fetch(`/lista-de-favoritos`)
        .then(resposta => resposta.json());
    }
}

function exibirLivrosFavoritos(livrosUsuario, nomeLista) {
    let params = new URLSearchParams(document.location.search);
    let userParam = params.get("id_usuario");
    
    let ctnLivrosUsuario = document.querySelector("aside div");
    
    removerListaUsuario();
    removeTituloLista();

    ctnLivrosUsuario.insertAdjacentHTML("beforebegin", `<header><h2 class="titulo-lista text-info text-center">${nomeLista}<span onclick="removerListaUsuario()" class="fa-solid fa-xmark" style="color: #ff0000;"></span></h2></header>`)
    for (const livro of livrosUsuario) {
        ctnLivrosUsuario.insertAdjacentHTML("beforeend", `<section class="d-flex flex-column align-items-center col-9 col-md-6 col-lg-5 mb-1">
        <header>
        <h1 style="font-size:small;" >${livro.titulo_livro}</h1>
        </header>
        <div class="mb-3 text-center">
        <a href="/detalhes-sobre-livro?id_livro=${livro.id_livro}">
        <img class="col-6" src="${livro.imagem_livro}">
        </a>
        </div>
        ${userParam?``:`<button id-livro=${livro.id_livro} class="btn btn-dark" onclick="removerFavorito(this)"><span class="fa-solid fa-xmark" style="color: #ff0000;" aria-hidden="true"></span>Remover dos favoritos</button>`}
        </section>`)
    }//os livros favoritos é tipo uma recomendação

}

function removerFavorito(btn) {

    let id_livro_param = btn.getAttribute("id-livro");

    fetch(`/deletar-favorito?id_livro=${id_livro_param}`, {
        method: "DELETE",
        mode: "same-origin",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: id_livro_param })
    }).then(resposta => resposta.ok ? resposta.json() : console.log(resposta))
    .then(dados => {
        if (dados.mensagem) {
        let qtdFavorito = document.getElementById("qtdLivrosFavoritos");
        let valor = parseInt(qtdFavorito.textContent);
        criarTextoParaAviso("Livro removido", "ctnLivrosUsuario", null, "textSlide", 3, "gold"),
        removeContainerPai(btn);
        qtdFavorito.textContent = valor - 1;
    }
    })
}

//botao para solicitar livros lidos
let btnExibirLivrosLidos = document.getElementById("btnExibirLivrosLidos");

if (btnExibirLivrosLidos) {
    btnExibirLivrosLidos.addEventListener("click", async () => {
        try {
            let livrosConcluidos = await solicitarListaDeLivrosConcluidos();
            exibirLivrosConcluidos(livrosConcluidos, "Livros concluidos");
            exibeCtnDeLivrosDoUsuario();
            window.scrollTo(0, document.body.scrollHeight);
        } catch (error) {
            console.log(error);
        }
    })
}

async function solicitarListaDeLivrosConcluidos() {
    let parametro = new URLSearchParams(document.location.search);
    let usuarioParam = parametro.get("id_usuario");

    if(usuarioParam){
        return fetch(`/livro-concluidos?id_usuario=${usuarioParam}`)
        .then(resposta => resposta.json());
    }else{
        return fetch(`/livro-concluidos`)
        .then(resposta => resposta.json());
    }
    
}

function exibirLivrosConcluidos(livrosUsuario, nomeLista) {//agora foi 
    let ctnLivrosUsuario = document.querySelector("aside div");
   
    removerListaUsuario();
    removeTituloLista();

    ctnLivrosUsuario.insertAdjacentHTML("beforebegin", `<header>
    <h2 class="titulo-lista text-info text-center">${nomeLista}
    <span onclick="removerListaUsuario()"class="fa-solid fa-xmark" style="color: #ff0000;">
    </span></h2>
    </header>`);
    for (const livro of livrosUsuario) {
        ctnLivrosUsuario.insertAdjacentHTML("beforeend", `<section class="d-flex-column col-9 col-md-6 col-lg-5 mb-1">
        <header>
        <h1 style="font-size:small;" >${livro.titulo_livro}</h1>
        </header>
        <div class="text-center">
        <a href="/detalhes-sobre-livro?id_livro=${livro.id_livro}">
        <img class="col-6" src="${livro.imagem_livro}">
        </a>
        </div>
        </section>`)
    }

}

function removeTituloLista(){
    let tituloLista = document.querySelector("aside .titulo-lista");
    if(tituloLista){
        tituloLista.remove();
    }
}

function removerListaUsuario() {
    let ctnLivrosUsuario = document.querySelector("aside div");
    let ctn = document.getElementById("ctnLivrosUsuario");
    ctn.classList.add("esconderContainer");

    if(ctnLivrosUsuario.hasChildNodes()){
        ctnLivrosUsuario.innerHTML = "";
    }   
}