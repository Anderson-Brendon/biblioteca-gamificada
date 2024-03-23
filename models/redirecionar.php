<?php 

class Redirecionar{

    static function usuarioGuest(string $rotaRedirecionamento){
        if(!isset($_SESSION['id_usuario'])){
            header('location:'.$rotaRedirecionamento);
        }
    }

    static function usuarioEmSessao(string $rotaRedirecionamento){
        if(isset($_SESSION['id_usuario'])){
            header('location:'.$rotaRedirecionamento);
        }
    }

    static function usuarioSemAdmin(string $rotaRedirecionamento){
        if($_SESSION['nivel_de_acesso'] < 1){
            header('location:'.$rotaRedirecionamento);
            setcookie('msg',"Você não tem permissão para acessar essa página",time() - 1,'/');
        }
    }

}