<?php 
declare(strict_types=1);

require_once "conexao-sql.php";

class QuizLivros{

    public string $pergunta;
    public string $alternativa_a;
    public string $alternativa_b;
    public string $alternartiva_c;
    public string $alternativa_d;
    public string $altertiva_correta;
    public int $pontos;
    
    
    public function carregarMaioresPontuacoes():bool|array
    {
        try {
            $conexaoDobanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDobanco->prepare("SELECT * FROM usuarios WHERE pontos_totalizados_de_quiz > 0 order by pontos_totalizados_de_quiz DESC LIMIT 100");
            $statement->execute();
            $listaTopPontuacoes = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $listaTopPontuacoes;
        } catch (PDOException $erro) {
            return ['erroPdo' => $erro->getMessage()];
        }
    }

    public function carregarQuizDeLivro(int $id_livro):bool|array
    {
        try {
            $conexaoDobanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDobanco->prepare("SELECT * FROM perguntas_de_quiz WHERE id_livro = :id_livro");
            $statement->bindValue(":id_livro", $id_livro);
            $statement->execute();
            $quiz = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $quiz;
        } catch (\PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ["erroPdo" => $erroPdo];
        }
    }


    public function carregarAlternativasCorretas(int $id_livro):array
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT alternativa_correta FROM perguntas_de_quiz WHERE id_livro = :id_livro ORDER BY id_pergunta ASC" );
            $statement->bindValue(":id_livro", $id_livro);
            $statement->execute();
            $respostasCorretas = $statement->fetchAll();
            return $respostasCorretas;
        } catch (PDOException $erro) {
            return ["erroPdo" => $erro->getMessage()];
        }
    }

    public function adicionarQuestaoDeQuiz(){

    }

    public function adicionarQuizConcluido(int $id_usuario, int $id_livro, int $num_respostas_corretas):bool|array{
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("INSERT INTO quiz_respondidos_por_usuario(id_livro, id_usuario, num_respostas_corretas) VALUES(:id_livro, :id_usuario, :num_respostas_corretas)");
            $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
            $statement->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":num_respostas_corretas", $num_respostas_corretas, PDO::PARAM_INT);
            $bool = $statement->execute();
            if($bool){
                return $bool;
            }
        } catch (PDOException $erro) {
            return ['erroPDo'=>$erro->getMessage()];
        }
    }
    
    public function atualizarPontuacaoTotal(int $id_usuario, int $pontos):bool|array{
        try {
            $this->pontos = $pontos;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("UPDATE usuarios SET pontos_totalizados_de_quiz = pontos_totalizados_de_quiz + :pontos where id_usuario = :id_usuario");
            $statement->bindValue(":pontos", $this->pontos,PDO::PARAM_INT);
            $statement->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $bool = $statement->execute();
            if($bool){
                return $bool;
            }
        } catch (PDOException $erro) {
           return ['erroPDo'=>$erro->getMessage()];
        }
    }

    public function carregarPontuacaoUsuario($id_usuario, $id_livro):bool|array{
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM quiz_respondidos_por_usuario WHERE id_usuario = :id_usuario AND id_livro = :id_livro LIMIT 1");
            $statement->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
            $bool = $statement->execute();
            $pontuacao = $statement->fetch(PDO::FETCH_ASSOC);
            if($bool){
                return $pontuacao;
            }
            
        } catch (PDOException $erro) {
           return ['erroPDo'=>$erro->getMessage()];
        }
    }

}