<?php

class ConexaoSql
{
    
    public static function conectarAoBanco() : PDO
    {
        $enderecoHost = "localhost";
        $nomeBanco =  "biblioteca_gamificada";
        $nomeUsuario = "root";
        $senha = "";

        $minhaConexao = new PDO("mysql:host=" . $enderecoHost . ";dbname=" . $nomeBanco, $nomeUsuario, $senha);
        return $minhaConexao;
    }
}