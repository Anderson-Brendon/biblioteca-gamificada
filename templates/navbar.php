<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/usuario-biblioteca.php";
$id_usuario = $_SESSION['id_usuario'];
$usuario = new UsuarioBiblioteca();
$dadosUsuario = $usuario->carregarInfoPerfilUsuario($id_usuario);
?>
<nav class="bg-dark" id="navBar">
    <div>
        <button nav-bar-open="0" type="button" id="hideShowNavBar"><img class="col-3 col-sm-2" src="../../resources/icons/display-svgrepo-com.svg" alt=""></button>
        <input type="text" placeholder="Pesquisar por livro" id="inputPesquisa" maxlength="10">
    </div>
    <a class="col-3 linksNavBar" href="/meu-perfil" class="linksNavBar"><img class="col-9 col-sm-5 col-md-5 col-lg-5 col-xl-4" src="<?php echo $dadosUsuario['caminho_imagem_perfil'] ?>" alt=""><span>Meu perfil</span></a>
    <a href="/galeria-de-livros" class="linksNavBar">
        <span class="fa-solid fa-book" style="color: #FFD43B;"></span> Livros</a>
    <a href="/placar-de-lideres" class="linksNavBar"><span class="fa-solid fa-trophy" style="color: #fff700;"></span> Ranking</a>
    <a href="/fechar-sessao" class="linksNavBar"><span class="fa-solid fa-right-from-bracket" style="color: #fa0000;"></span> Sair
    </a>
</nav>