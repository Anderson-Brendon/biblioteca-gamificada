<?php session_start();

$titulo = 'Login';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php';

Redirecionar::usuarioEmSessao('/galeria-de-livros'); ?>

<main>

    <header class="mt-3">
        <h1 class="centralizaTexto textSlide">
            <span>
                <img src="/resources/icons/book-open.svg" class="col-3 col-sm-1 col-md-1">
            </span>Biblioteca Gamificada
        </h1>
        <p class="centralizaTexto">Projeto pessoal para melhorar os conhecimentos em javascript e php</p>
    </header>
    <div id="containerLogin" class="d-flex flex-column align-content-center align-items-center flex-wrap">
        <div>
            <h2 class="border-pill rounded-3">Login <span><img name="loginIcon" class="col-1" src="/resources/icons/login-svgrepo.svg" alt=""></span></h1>
                <div>
                    <p class="text-center text-warning textSlide"><?= $_COOKIE['loginNegado'] ?? '' ?></p>
                </div>
        </div>
        <form autocomplete="off" class="col-9 col-sm-6 col-md-4 col-lg-3 d-flex flex-column justify-content-center flex-wrap align-content-center rounded-3 p-3 bgDarkGlass " action="/tentar-login" method="post">
            <label for="nick_usuario" placeholder="Escolha um nome de usuario" class="mt-3 textSlide">Nome da conta</label>
            <input class="mt-3 centralizaTexto form-control" type="text" name="nick_usuario" id="nick_usuario" minlength="6" maxlength="16" required>
            <label for="senha_usuario" class="mt-3 textSlide">Sua senha</label>
            <input class="mt-3 centralizaTexto form-control senha" type="password" name="senha_usuario" id="senha_usuario" minlength="6" maxlength="16" required>
            <div>
                <input psw="senha_usuario" id="senhaLogin" onclick="alternaExibicaoSenha(this)" type="checkbox" class="exibeSenha">
                <label for="senhaLogin">Exibir senha</label>    
            </div>
            <div class="d-flex justify-content-between" class="mt-3">
                <button type="submit" class="botoesVerde mt-3">Entrar</button>
                <button id="botaoMostraCadastro" type="button" class="botaoAzul botoesCadastroRetorna">Cadastrar</button>
            </div>
        </form>
    </div>
    <div id="containerCadastro" class="d-flex flex-column align-content-center align-items-center flex-wrap esconderContainer ">
        <h2 class="centralizaTexto">Criar conta<span><img class="col-1" src="/resources/icons/subscribe.svg" alt=""></span></h2>
        <form autocomplete="off" class="col-9 col-sm-6 col-md-4 col-lg-3 d-flex flex-column justify-content-center flex-wrap align-content-center rounded-3 p-3 bgDarkGlass">
            <label class="mt-3 textSlide" for="nomeUsuarioCadastro">Escolha um nome de usuario </label>
            <input class="mt-3 centralizaTexto form-control" type="text" name="nomeUsuarioCadastro" id="nomeUsuarioCadastro" class="mt-3" minlength="6" maxlength="16" required>
            <label for="senhaUsuarioCadastro" class="mt-3 textSlide">Crie uma senha</label>
            <input class="mt-3 centralizaTexto form-control senha" type="password" name="senhaUsuarioCadastro" id="senhaUsuarioCadastro" minlength="6" maxlength="16" required>
            <div>
                <input psw="senhaUsuarioCadastro" id="senhaCadastro" onclick="alternaExibicaoSenha(this)" type="checkbox" class="exibeSenha">                
                <label for="senhaCadastro">Exibir senha</label>    
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" id="criarContaBotao" onclick="realizaCadastro()" class="botoesVerde">Criar conta</button>
                <button id="botaoMostraLogin" type="button" class="botaoAzul botoesCadastroRetorna">Login</button>
            </div>
        </form>
    </div>
    </div>
    <div class="d-flex justify-content-center mt-3 mt-3">
        <a class="text-dark fw-bold bg-warning p-1" href="/galeria-de-livros">Acessar sem login</a>
    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>