//inicialização de variaveis
let i = 0;

let respostasSelecionadas = {};

let interId = null;

let perguntasDeQuiz = null;

let contagemRegressivaNum = 0;

let idContagem = null;

//atribuição de elementos
let quizContainer = document.getElementById("quiz");

let btnIniciaQuiz = document.getElementById("btnIniciaQuiz");

let btnRespondeQuiz = document.getElementById("btnRespondeQuiz");


//adição de eventos

if(btnRespondeQuiz){
    btnRespondeQuiz.onclick = () => {responderQuiz()} ;
}


function responderQuiz() {
    quizContainer.insertAdjacentHTML('afterbegin',
    `<div class="bgDarkGlass col-md-6 text-center rounded-3 m-3">
        <h3 class="text-center mt-1" style="color: gold;">Regras</h3>
        <p class="mt-1 text-center">As perguntas não respondidas são selecionadas aleatoriamente</p>
        <p class="mt-1 text-center">Cada pergunta tem duração máxima de 30 segundos</p>
        <p class="mt-1 text-center">Cada resposta correta soma 10 pontos</p>
    </div>
    <div class="d-flex justify-content-around align-items-center mt-1 mb-1">
        <button class="btn btn-success" onclick="iniciaQuiz()">Iniciar quiz</button>
        <button class="btn btn-danger" onclick="cancelarQuiz()">Cancelar</button>      
    </div>`)
}

function cancelarQuiz() {
    quizContainer.innerHTML = '';
}

async function iniciaQuiz() {
    try {
        let resposta = await solicitarPerguntasDoQuiz();
        perguntasDeQuiz = await resposta.json();
        criarContainerDePergunta(perguntasDeQuiz[i]);
        btnRespondeQuiz.setAttribute("disabled", "");
    } catch (error) {
        console.log(error);
    }
    //vai parar codigo e esperar a promessa ser concluida
}

function iniciaContagemParaResponder(){
    contagemRegressivaNum = 30;
    let h3ExibeContagem = document.getElementById("exibeContagem");
    let idContagemParaResponder = setInterval(() => {
        if(contagemRegressivaNum == 0){
            selecionaAlternativaAleatoria();
            contagemRegressivaNum = 30;
        }    
        h3ExibeContagem.textContent = (contagemRegressivaNum--);
    }, 1000);
    return idContagemParaResponder;
}

function criarContainerDePergunta(perguntaQuiz) {
    contagemRegressivaNum = 30;
    clearInterval(idContagem);
    quizContainer.innerHTML = "";
    quizContainer.insertAdjacentHTML("afterbegin",
    `<div style="border: solid 1px black;border-radius:1rem" class="col-md-9 p-3 bgDarkGlass flex-column justify-content-center align-items-center mt-3 mb-3">
    <h3 style="color:gold" id="perguntaTxt">${perguntaQuiz.texto_de_pergunta}</h3>
    <h3 id="exibeContagem">${contagemRegressivaNum}</h3>
    <div style="border-radius:1rem" class="d-flex flex-column mt-3 ctnAlternativas">
        <label style="border-radius:1rem" class="border border-secondary alternativas" for="altA">${perguntaQuiz.alternativa_a}</label>
        <input type="radio" name="alternativa" id="altA" value="A" class="d-none">
    </div>
    <div style="border-radius:1rem" class="d-flex flex-column mt-3 ctnAlternativas">
        <label style="border-radius:1rem" class="border border-secondary alternativas" for="altB">${perguntaQuiz.alternativa_b}</label>
        <input type="radio" name="alternativa" id="altB" value="B" class="d-none">
    </div>
    <div style="border-radius:1rem" class="d-flex flex-column mt-3 ctnAlternativas">
        <label  style="border-radius:1rem" class="border border-secondary alternativas" for="altC">${perguntaQuiz.alternativa_c}</label>
        <input type="radio" name="alternativa" id="altC" value="C" class="d-none">
    </div>
    <div style="border-radius:1rem" class="d-flex flex-column mt-3 ctnAlternativas">
        <label style="border-radius:1rem" class="border border-secondary alternativas" for="altD">${perguntaQuiz.alternativa_d}</label>
        <input type="radio" name="alternativa" id="altD" value="D" class="d-none">
    </div>
    <div id="ctnBotoesResposta" class="d-flex justify-content-around align-items-center mt-3 mb-3">
        <button class="btn btn-primary" onclick="salvaAlternativaMarcada()">Responder</button>
        <button class="btn btn-info" onclick="selecionaAlternativaAleatoria()">Escolher aleatória</button>
    </div>
</div>`);
    idContagem = iniciaContagemParaResponder();
}

async function selecionaAlternativaAleatoria() {
    clearInterval(idContagem);
    let resposta = '';
    let alternativas = document.getElementsByName("alternativa");
    resposta = alternativas[Math.round(Math.random() * 3)].value;
    respostasSelecionadas['resposta' + (i + 1)] = resposta;
    checaSeQuizEstaConcluido();
}

async function solicitarPerguntasDoQuiz() {
    let parametro =  new URLSearchParams(document.location.search);
    let id_livro = parametro.get("id_livro");
    return fetch(`/quiz/quiz-livro?id_livro=${id_livro}`);
}

function mostrarPontuacaoTotal(msg) {
    quizContainer.innerHTML = "";
    if (msg.acertos == 10) {
        quizContainer.insertAdjacentHTML("afterbegin", `<section class="ctnPontuacaoTotal zoomingAnimation bg-dark">
    <h3 style="color:greenyellow;" class="textSlide">Muito bom, você acertou todas as 10 perguntas do quiz!'</h3>
    <button onclick="esconderPontuacaoTotal()" class="btn bt-warning" type="button">Esconder Pontuação</button>
    </section>`)
    }
    else if (msg.acertos >= 6) {
        quizContainer.insertAdjacentHTML("afterbegin", `<section class="ctnPontuacaoTotal zoomingAnimation bg-dark">
    <h3 style="color:gold;" class="textSlide">'Você acertou ${msg.acertos} de 10 perguntas nada mal'</h3>
    <button onclick="esconderPontuacaoTotal()" class="btn bt-warning" type="button">Esconder Pontuação</button>
    </section>`)
    } else {
        quizContainer.insertAdjacentHTML("afterbegin", `<section class="ctnPontuacaoTotal zoomingAnimation bg-dark">
    <h3 style="color:gold;" class="textSlide">'Você acertou ${msg.acertos} de 10 perguntas, faltou ler o livro mais um pouco.''</h3>
    <button type="btn btn-danger" onclick="esconderPontuacaoTotal()">Esconder Pontuação</button>
    </section>`)
    }
    mudaEventosBtnQuiz();
}

function mudaEventosBtnQuiz(){
    btnRespondeQuiz.textContent = "Ocultar pontuação";
    btnRespondeQuiz.onclick = '';
    btnRespondeQuiz.addEventListener("click", () => {
        let ctnPontuacao = document.querySelector(".ctnPontuacaoTotal")
        if(ctnPontuacao.classList.contains("esconderContainer")){
            exibirPontuacaoTotal();
        }else{
            esconderPontuacaoTotal();
        }
    });
    btnRespondeQuiz.removeAttribute("disabled");
}

function exibirPontuacaoTotal(){
    let ctnPontuacao = document.querySelector(".ctnPontuacaoTotal");
    ctnPontuacao.classList.remove("esconderContainer");
    
}

function esconderPontuacaoTotal(){
    let ctnPontuacao = document.querySelector(".ctnPontuacaoTotal");
    ctnPontuacao.classList.add("esconderContainer");
    btnRespondeQuiz.textContent = "Exibir pontuação";
}

async function enviarRespostas() {
    let parametro = new URLSearchParams(document.location.search);
    return fetch("/quiz/pontuar-quiz", {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_livro: parametro.get("id_livro"), respostasUsuario: respostasSelecionadas })
    }
    )
        .then(resposta => resposta.json())
        .then(dados => dados)
}

function pararContagemIntervalo(idIntervalo) {
    clearInterval(idIntervalo);
}

function destacarAlternativaSelecionada(alt){
    let ctn = alt.parentNode();
    ctn.classList.add("bg-dark");
}

function criaAlertaAlternativaNaoMarcada(){
    let ctnQuestoes = document.querySelector("#quiz div");
    criarTextoParaAviso("Selecione uma alternativa",null, ctnQuestoes, "textSlide",3000,"rgb(199, 0, 90)");
}

async function salvaAlternativaMarcada() {

    let arrayAlternativas = document.getElementsByName("alternativa");
    let resposta = "";

    for (const alternativa of arrayAlternativas) {
        if (alternativa.checked) {
            clearInterval(idContagem);
            resposta = alternativa.value;
            respostasSelecionadas['resposta' + (i + 1)] = resposta;
            checaSeQuizEstaConcluido();
            return;
        }
    }   
    criaAlertaAlternativaNaoMarcada();
    
}

async function checaSeQuizEstaConcluido(){
    if (i == 9) {
        let respostasCorretas = await enviarRespostas();
        mostrarPontuacaoTotal(respostasCorretas);
        console.log(respostasSelecionadas);
        console.log(i);
    } else {
        i++;
        criarContainerDePergunta(perguntasDeQuiz[i]);
    }
}
