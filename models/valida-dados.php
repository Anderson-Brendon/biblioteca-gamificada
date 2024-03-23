<?php
declare(strict_types=1);

class validarDados{
    static $dados;

    static public function limparDados(string $dados){
        $dados = trim($dados);
        $dados = htmlspecialchars($dados);
        return $dados;
    }

    static public function validaNickUsuario(string $nick){
        $regex = preg_match('[@_!#$%^&*()<>?/|}{~:]', $nick);
        $comprimento = strlen($nick);
        if($regex &&  $comprimento < 6){
            return "Caracteres especiais não permitidos(exceto híphen) e número de caracteres mínimo é 6";
        }else if($regex){
            return "Caracteres especiais não permitidos";
        }else if($comprimento < 6){
            return "Número de caracteres mínimo é 6";
        }
        return true;
    }

    static public function validarSenhaUsuario(){
        
    }

    static public function validarEmail(){

    }
}