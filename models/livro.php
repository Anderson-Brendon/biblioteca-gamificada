<?php

declare(strict_types=1);
require_once "conexao-sql.php";

class Livro
{

    public ?int $id_livro;
    public ?string $titulo_livro;
    public ?string $data_publicacao;
    public ?string $arquivo_pdf;
    public ?float $media_avaliacao_livro;
    public ?string $autor_livro;
    public ?int $categoria_do_livro;
    public ?string $imagem_livro;
    public ?int $numero_paginas;


    public function __construct($id_livro = null, $titulo_livro = null,$data_publicacao = null,  $autor_livro = null,  $categoria_do_livro = null,  $arquivo_pdf = null, $imagemLivro = null)
    {
        $this->id_livro = $id_livro;
        $this->titulo_livro = $titulo_livro;
        $this->data_publicacao = $data_publicacao;
        $this->autor_livro = $autor_livro;
        $this->categoria_do_livro = $categoria_do_livro;
        $this->arquivo_pdf = $arquivo_pdf;
        $this->imagem_livro = $imagemLivro;
    } 

}
