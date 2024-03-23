<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/usuario-biblioteca.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/valida-dados.php";

$id_usuario = $_SESSION['id_usuario'];

$usuario = new UsuarioBiblioteca();

$nick_usuario = validarDados::limparDados($_POST['nick_usuario']);

$citacao = validarDados::limparDados($_POST['citacao_favorita']);

$autor_citacao = validarDados::limparDados($_POST['autor_citacao']);

$imagemPerfil = $_FILES['imagemPerfil']['tmp_name'];

$nomeImg = $_FILES['imagemPerfil']['name'];

$extensao = pathinfo($nomeImg, PATHINFO_EXTENSION);


$infoUsuario = $usuario->carregarInfoPerfilUsuario($id_usuario);

 if ($nick_usuario != $infoUsuario['nick_usuario']) {
     if($usuario->usuarioExiste($nick_usuario)){
         echo json_encode(['mensagem' => 'Usuário já existe, tente outro nome']);
         exit();
     }
 }

if ($imagemPerfil == null) {
    $msg = $usuario->editarUsuario($id_usuario, $nick_usuario, $infoUsuario['caminho_imagem_perfil'], $citacao,$autor_citacao);
    echo json_encode($msg);
} else {
    $caminhoImg = $_SERVER['DOCUMENT_ROOT'] . "/resources/imagens/usuarios/";

    $caminhoSql = "/resources/imagens/usuarios/" . $nick_usuario.".".$extensao;

    $salvouImg = move_uploaded_file($imagemPerfil, $caminhoImg . $nick_usuario.".".$extensao);

    // $urlImgPerfil = $caminhoImg . $_SESSION['nick_usuario'].".".$extensao;

    switch ($salvouImg) {
        case false:
            echo json_encode(['mensagem' => 'Não foi possivel atualizar perfil']);
            break;
        default:
            $msg = $usuario->editarUsuario($id_usuario, $nick_usuario, $caminhoSql, $citacao,$autor_citacao);
            echo json_encode([$msg,"urlImgPerfil" => $caminhoSql]);
            break;
    }
}