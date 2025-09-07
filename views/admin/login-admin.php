<?php
session_start();
$titulo = 'Login adm';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/redirecionar.php';

Redirecionar::usuarioEmSessao("/galeria-de-livros");

?>

<main class="h-100 d-flex flex-column justify-content-center align-items-center ">
    <p><?php $_COOKIE['msg'] ?? ''; ?></p>
    <header>
        <h1>Login</h1>
    </header>
    <form action="/admin/tentar-login" method="post" class="d-flex flex-column">
        <div class="d-flex flex-column">
            <label for="nick_usuario">Nome de admin</label>
            <input name="nick_usuario" id="nick_usuario" type="text" class="m-3">
        </div>
        <div class="d-flex flex-column">
            <label for="senha_usuario">Senha</label>
            <input name="senha_usuario" id="senha_usuario" type="password" class="m-3">
        </div>   
        
        <button type="submit" class="bg-success">Login</button>
    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>