destacaUrlPaginacao();

function criarTextoParaAviso(texto, idContainer = null, domCtn = null, animationClass = null, timeout = null, colorTxt = null) {
    if(document.querySelector(".textoAviso")){
        document.querySelector(".textoAviso").remove();
    }
    let p = document.createElement("p");
    p.style.textAlign = "center";
    p.textContent = texto;
    p.classList.add("textoAviso");
    if (animationClass) {
        p.classList.add(animationClass);
    }
    if (timeout) {
        setTimeout(() => {
            p.remove();
        }, timeout)
    }
    if (colorTxt) {
        p.style.color = colorTxt;
    }
    if(idContainer){
        let container = document.getElementById(idContainer);
        container.prepend(p);
    }else{
        domCtn.prepend(p);
    }
}

function destacaUrlPaginacao(){
    anchorTags = document.querySelectorAll("nav a");
    for (const tag of anchorTags) {
        if(tag.href === document.location.href){
            tag.style.color = "greenyellow";
        }
    }
}

function alternaExibicaoSenha(alvo) {
    let idInput = alvo.getAttribute("psw");
    let input = document.getElementById(idInput);
    if(input.type === "password"){
        input.type = "text";
    }else{
        input.type = "password";
    }
}

function habilitaInput(tag) {
    tag.removeAttribute("disabled");
}

function desativaInput(tag) {
    tag.setAttribute("disabled", "true");
}

function insereAnimacaoCarregamento(){
    let div = document.createElement("div");
    div.classList.add("loader");
    return div;
}

function removeContainerPai(alvo) {
    let container = alvo.parentNode;
    container.remove();
}