<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/livro.php";
require_once "conexao-sql.php";
class AdminLivros
{
    public Livro $livro;

    public function __construct()
    {
        
    }


    public function carregarTodosLivros()
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM livros");
            $statement->execute();
            $listalivros = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $listalivros;
        } catch (\PDOException $erro) {
            return $erro->getMessage();
        }
    } 

    public function carregarLivrosInicio()
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM livros limit 10");
            $statement->execute();
            $listalivros = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $listalivros;
        } catch (\PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function carregarLivrosPaginados($offset = 0)
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM livros LIMIT 8 OFFSET :offset");
            $statement->bindValue(":offset", $offset, PDO::PARAM_INT);
            $statement->execute();
            $livrosPaginados = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $livrosPaginados;
        } catch (PDOException $erro) {
            $msgErro = $erro->getMessage();
            return ['mensagem' => $msgErro];
        }
    }

    public function carregarInfoSobreLivro(Livro $livro)
    {
        try {
            $this->livro = $livro;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT * FROM livros WHERE id_livro = :id_livro');
            $statement->bindValue(':id_livro', $this->livro->id_livro, PDO::PARAM_INT);
            $statement->execute();
            $dadosLivro = $statement->fetch(PDO::FETCH_ASSOC);
            return $dadosLivro;
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function atualizaValoresParaCalculoDeMedia(int $id_livro, int $nota_para_livro){
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("UPDATE livros SET qtd_avaliacoes_usuarios = qtd_avaliacoes_usuarios + 1, total_de_notas_somadas = total_de_notas_somadas + :nota_para_livro WHERE id_livro = :id_livro");
            $statement->bindValue(":id_livro",$id_livro, pdo::PARAM_INT);
            $statement->bindValue(":nota_para_livro",$nota_para_livro, pdo::PARAM_INT);
            $bool = $statement->execute();
            if($bool){
                return ['mensagemOk'=>'valores atualizados'];
            }
        } catch (\PDOException $erro) {
            $msgErro = $erro->getMessage();
            return ['erroPdo' => $msgErro];
        }
    }
    public function atualizaMediaDeLivro(){
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("UPDATE livros SET media_avaliacao_livro = total_de_notas_somadas / qtd_avaliacoes_usuarios");
            $bool = $statement->execute();
            if($bool){
                return ['mensagemOk'=>'media atualizada'];
            }
        } catch (\PDOException $erro) {
            $msgErro = $erro->getMessage();
            return ['erroPdo' => $msgErro];
        }
    }

    public function filtrarLivrosPorCategoria()
    {
    } 

    public function contarNumeroDeLivros()
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM LIVROS");
            $statement->execute();
            $numeroDeLivros = $statement->rowCount();
            return $numeroDeLivros;
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function adicionarLivro(Livro $livro)
    {
        try {
            $this->livro = $livro;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("INSERT INTO livros(autor_livro, titulo_livro,descricao, data_publicacao, imagem_livro, arquivo_pdf, id_categoria) VALUES(:autor_livro, :titulo_livro,:descricao, :data_publicacao, :imagem_livro, :arquivo_pdf, :id_categoria)");
            $statement->bindValue(":autor_livro", $this->livro->autor_livro);
            $statement->bindValue(":titulo_livro", $this->livro->titulo_livro);
            $statement->bindValue(":data_publicacao", $this->livro->data_publicacao);
            $statement->bindValue(":imagem_livro", $this->livro->imagem_livro);
            $statement->bindValue(":id_categoria", $this->livro->categoria_do_livro);
            $statement->bindValue(":arquivo_pdf", $this->livro->arquivo_pdf);
            $statement->bindValue(":descricao", $this->livro->descricao);
            $statement->execute();
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    } //php

    public function editarLivro()
    {
    } //php

    public function excluirLivro()
    {
    } 
    public function sugestaoDeLivrosSimilares()
    {
    }
    //php

}