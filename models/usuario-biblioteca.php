<?php
declare(strict_types=1);

require_once "conexao-sql.php";

class UsuarioBiblioteca
{

    public int $id_usuario;
    public string $nick_usuario;
    public string $senha_usuario;
    public int $nota_para_livro;
    public string $caminho_imagem_perfil;
    public int $qtd_livros_lidos;
    public int $qtd_livros_favoritados;
    public int $qtd_pontos_totais_quiz;
    public string $comentario;

    public function usuarioEstaLogado():bool
    {
        $conectado = isset($_SESSION['id_usuario']);
        return $conectado;
    }

    public function usuarioExiste($nick)
    {
        try {
            $this->nick_usuario = $nick;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM usuarios WHERE nick_usuario = :nick_usuario");
            $statement->bindValue(":nick_usuario", $this->nick_usuario);
            $statement->execute();
            $resultadoPesquisa = $statement->rowCount();
            return $resultadoPesquisa != 0;   
        } catch (PDOException $erro) {
            return ['erroPdo'=>$erro];
        }
        
    }

    public function criarUsuario(string $nick_usuario, string $senha_usuario):bool|array
    {

        try {
            $this->nick_usuario = $nick_usuario;
            $this->senha_usuario = $senha_usuario;
            $this->senha_usuario = password_hash($this->senha_usuario, PASSWORD_DEFAULT);
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("INSERT INTO usuarios(nick_usuario, senha_usuario) VALUES (:nick_usuario, :senha_usuario)");
            $statement->bindValue(':nick_usuario', $this->nick_usuario);
            $statement->bindValue(':senha_usuario', $this->senha_usuario);
            $statement->execute();
            return true;
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return (['mensagem' => $erroMensagem]);
        }
    }

    public function fazerLoginUsuario($nick_usuario, $senha_usuario):bool|array
    {
        try {
            $this->nick_usuario = $nick_usuario;
            $this->senha_usuario = $senha_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT * FROM usuarios WHERE NICK_USUARIO = :nick_usuario');
            $statement->bindValue(':nick_usuario', $this->nick_usuario);
            $statement->execute();
            $DadosUsuario = $statement->fetch(pdo::FETCH_ASSOC);
            if ($DadosUsuario > 0 && password_verify($this->senha_usuario, $DadosUsuario['senha_usuario'])) {
                return $DadosUsuario;
            } else {
                return false;
            }
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return ['mensagem' => $erroMensagem];
        }
    }

    public function editarUsuario(int $id_usuario, ?string $nick_usuario, ?string $caminho_imagem_perfil,
    ?string $citacao_favorita,?string $autor_citacao):array
    { 
        try {
            $this->id_usuario = $id_usuario;
            $this->nick_usuario = $nick_usuario;
            $this->caminho_imagem_perfil = $caminho_imagem_perfil;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement =  $conexaoDoBanco->prepare('UPDATE usuarios set nick_usuario = COALESCE(:nick_usuario, nick_usuario), caminho_imagem_perfil = COALESCE(:caminho_imagem_perfil, caminho_imagem_perfil), citacao_favorita = COALESCE(:citacao_favorita, citacao_favorita) ,autor_citacao = COALESCE(:autor_citacao, autor_citacao) WHERE id_usuario = :id_usuario');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':nick_usuario', $this->nick_usuario, PDO::PARAM_STR);
            $statement->bindValue(':caminho_imagem_perfil', $this->caminho_imagem_perfil, PDO::PARAM_STR);
            $statement->bindValue(':autor_citacao', $autor_citacao, PDO::PARAM_STR);
            $statement->bindValue(':citacao_favorita', $citacao_favorita, PDO::PARAM_STR);
            $statement->execute();
            return ['mensagem' => 'Perfil atualizado'];
        } catch (PDOException $erro) {
            $mensagemErro = $erro->getMessage();
            return (['erroPdo' => $mensagemErro]);
        }
    } //fetch api muda dados

    public function alterarSenha(int $id_usuario,  int $senha_usuario):array
    {
        try {
            $this->$id_usuario = $id_usuario;
            $this->$senha_usuario = $senha_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement =  $conexaoDoBanco->prepare('UPDATE usuarios set senha_usuario = :senha_usuario where id_usuario = :id_usuario');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':senha_usuario', password_hash($this->senha_usuario, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $statement->bindValue(':caminho_imagem_perfil', $this->caminho_imagem_perfil, PDO::PARAM_STR);
            //$bool = $statement->execute();
            return ['mensagem' => 'Senha modificada'];
        } catch (PDOException $erro) {
            $mensagemErro = $erro->getMessage();
            return ['erroPdo' => $mensagemErro];
        }
    }

    public function carregarInfoPerfilUsuario(int $id_usuario)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->execute();
            $dadosUsuario = $statement->fetch(pdo::FETCH_ASSOC);
            return $dadosUsuario;
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return $erroMensagem;
        }
    } //php carrega pagina

    public function deletarContaUsuario(int $id_usuario):array
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('DELETE FROM usuarios WHERE id_usuario = :id_usuario');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->execute();
            return ['mensagem' => 'Conta deletada'];
        } catch (PDOException $erro) {
            $mensagem = $erro->getMessage();
            return ['mensagem' => $mensagem];
        }
    }

    public function fecharSessaoUsuario()
    {
        session_destroy();
    }

    public function adicionarListaDeLeitura(int $id_usuario, int $id_livro):array
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('INSERT INTO lista_de_leitura_usuario(id_usuario, id_livro) VALUES(:id_usuario, :id_livro)');
            $statement->bindValue(':id_usuario', $this->id_usuario);
            $statement->bindValue(':id_livro', $id_livro);
            $statement->execute();
            return (['mensagemSucesso' => 'Livro adicionado a lista de leitura.']);
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return ['erroPdo' => $erroMensagem];
        }
    } //fetch api

    public function carregarLivrosEmListaLeitura(int $id_usuario):array|bool
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT lista_de_leitura_usuario.pagina_salva,livros.id_livro,livros.imagem_livro,livros.titulo_livro,livros.arquivo_pdf FROM lista_de_leitura_usuario INNER JOIN livros ON livros.id_livro = lista_de_leitura_usuario.id_livro WHERE id_usuario = :id_usuario AND esta_lido = 0");
            $statement->bindValue(':id_usuario', $this->id_usuario);
            $statement->execute();
            $listaLivrosMarcados = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $listaLivrosMarcados;
        } catch (\PDOException $erro) {
            return ['erroPdo' => $erro];
        }
    }

    // se nao especificar int em sessao vai funcionar pq o id é int na sessao mas url nao
    public function carregarListaLivrosLidos(int $id_usuario)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT livros.id_livro,livros.titulo_livro,livros.imagem_livro FROM lista_de_leitura_usuario JOIN livros ON lista_de_leitura_usuario.id_livro = livros.id_livro WHERE id_usuario = :id_usuario AND esta_lido = 1');
            $statement->bindValue('id_usuario', $this->id_usuario);
            $statement->execute();
            $listaLivrosLidos = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $listaLivrosLidos;
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function contarLivrosLidosOuNaoLidos(int $id_usuario, int $esta_lido):int|string
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT id_usuario, id_livro FROM lista_de_leitura_usuario  
        WHERE id_usuario = :id_usuario AND esta_lido = :bool');
            $statement->bindValue('id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":bool", $esta_lido, PDO::PARAM_INT);
            $statement->execute();
            $numeroDeLivros = $statement->rowCount();
            return $numeroDeLivros;
        } catch (PDOException $erro) {
            return $erro->getMessage(); //so pra saber msm
        }
    }

    public function marcarComoLido(int $id_usuario, int $id_livro):array
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('UPDATE lista_de_leitura_usuario SET esta_lido = 1 WHERE id_usuario = :id_usuario and id_livro = :id_livro');
            $statement->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':id_livro', $id_livro, PDO::PARAM_INT);
            $statement->execute();  
            return ['mensagem' => 'Livro marcado como lido'];
        } catch (PDOException $erro) {
            $mensagemErro = $erro->getMessage();
            return (['erroPdo' => $mensagemErro]);
        }
    } //fetch api

    public function estaFavoritado(int $id_usuario, int $id_livro):bool|array
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT * FROM livros_favoritos_usuario where id_usuario = :id_usuario AND id_livro = :id_livro');
            $statement->bindValue(':id_usuario', $this->id_usuario);
            $statement->bindValue(':id_livro', $id_livro);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $erro) {
            $mensagemErro = $erro->getMessage();
            return (['mensagem' => $mensagemErro]);
        } 
    } //fetch api

    public function livroEstaLido($id_usuario, $id_livro)
    {
        $this->id_usuario = $id_usuario;
        $conexaoDoBanco = ConexaoSql::conectarAoBanco();
        $statement = $conexaoDoBanco->prepare('SELECT * FROM lista_de_leitura_usuario WHERE id_usuario = :id_usuario AND id_livro = :id_livro AND esta_lido = 1');
        $statement->bindValue(":id_usuario", $this->id_usuario, PDO::PARAM_INT);
        $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function estaNaListaDeLeitura($id_usuario, $id_livro)
    {
        $this->id_usuario = $id_usuario;
        $conexaoDoBanco = ConexaoSql::conectarAoBanco();
        $statement = $conexaoDoBanco->prepare('SELECT * FROM lista_de_leitura_usuario where id_usuario = :id_usuario AND id_livro = :id_livro');
        $statement->bindValue(":id_usuario", $this->id_usuario, PDO::PARAM_INT);
        $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        } 
    }

    public function removerDaListaDeLeitura($id_usuario, $id_livro)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('DELETE FROM lista_de_leitura_usuario WHERE id_usuario = :id_usuario AND id_livro = :id_livro');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':id_livro', $id_livro, PDO::PARAM_INT);
            $statement->execute();
            return ['mensagemRemovido' => 'Livro removido da lista'];
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return  ['erroPdo' => $erroMensagem];
        }
    }
    //fetch api

    
    public function listarMeusLivrosFavoritos(int $id_usuario){
        {
            try {
                $this->id_usuario = $id_usuario;
                $conexaoDoBanco = ConexaoSql::conectarAoBanco();
                $statement = $conexaoDoBanco->prepare('SELECT livros_favoritos_usuario.*,livros.titulo_livro, livros.imagem_livro FROM livros_favoritos_usuario INNER JOIN livros ON livros.id_livro = livros_favoritos_usuario.id_livro WHERE livros_favoritos_usuario.id_usuario = :id_usuario;');
                $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
                $statement->execute();
                $minhaLista = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $minhaLista;
            } catch (PDOException $erro) {
                $mensagemErro = $erro->getMessage();
                return (['erroPdo' => $mensagemErro]);
            }
        }
    }

    public function favoritarLivro($id_usuario, $id_livro)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('INSERT INTO livros_favoritos_usuario(id_usuario, id_livro) VALUES(:id_usuario, :id_livro)');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':id_livro', $id_livro, PDO::PARAM_INT);
            $statement->execute();
            return (['mensagemFavoritado' => 'Livro adicionado aos favoritos']);
        } catch (PDOException $erro) {
            $mensagemErro = $erro->getMessage();
            return (['erroPdo' => $mensagemErro]);
        }
    } //fetch api

    public function contarNumeroDeFavoritos($id_usuario)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('SELECT * FROM livros_favoritos_usuario WHERE id_usuario = :id_usuario');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->execute();
            $numeroDeFavoritos = $statement->rowCount();
            return $numeroDeFavoritos;
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function removerDosFavoritos($id_usuario, $id_livro)
    {
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare('DELETE FROM livros_favoritos_usuario WHERE id_usuario = :id_usuario AND id_livro = :id_livro');
            $statement->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(':id_livro', $id_livro, PDO::PARAM_INT);
            $statement->execute();
            return ['mensagem' => 'Livro removido dos favoritos'];
        } catch (PDOException $erro) {
            $erroMensagem = $erro->getMessage();
            return  ['erroPdo' => $erroMensagem];
        }
    }

    public function estaAvaliado()
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM avaliacoes_de_usuarios WHERE id_usuario = :idUsuario");
            $statement->bindValue(":id_usuario", $this->id_usuario);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $erro) {
            $mensagem = $erro->getMessage();
            return ["erroPdo" => $mensagem];
        }
    }

    public function carregarAvaliacao($id_usuario, $id_livro)
    {
        $this->$id_usuario = $id_usuario;
        $conexaoDoBanco = ConexaoSql::conectarAoBanco();
        $statement = $conexaoDoBanco->prepare("SELECT * FROM avaliacoes_de_usuarios WHERE id_usuario = :id_usuario AND id_livro = :id_livro LIMIT 1");
        $statement->bindValue(":id_usuario", $id_usuario);
        $statement->bindValue(":id_livro", $id_livro);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $avaliacaoDeUsuario = $statement->fetch(pdo::FETCH_ASSOC);
            return $avaliacaoDeUsuario;
        } else {
            return null;
        }
    }

    public function carregarAvaliacoesEmIntervalo($offset, $id_livro)
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT avaliacoes_de_usuarios.*,usuarios.nick_usuario, usuarios.caminho_imagem_perfil FROM avaliacoes_de_usuarios INNER JOIN usuarios ON avaliacoes_de_usuarios.id_usuario = usuarios.id_usuario WHERE id_livro = :id_livro limit 5 OFFSET :offset");
            $statement->bindValue(":offset", $offset, pdo::PARAM_INT);
            $statement->bindValue(":id_livro", $id_livro, pdo::PARAM_INT);
            $statement->execute();
            $avaliacoes = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $avaliacoes;
        } catch (PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ['erroPdo' => $erroPdo];
        }
    }

    public function adicionarAvaliacao($id_usuario, $id_livro, $nota_para_livro, $comentario)
    {
        try {
            $this->id_usuario = $id_usuario;
            $this->nota_para_livro = intval($nota_para_livro);
            $this->comentario = $comentario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("INSERT INTO avaliacoes_de_usuarios(id_usuario, id_livro, nota_para_livro, comentario) VALUES (:id_usuario, :id_livro, :nota_para_livro, :comentario)");
            $statement->bindValue(":id_usuario", $this->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
            $statement->bindValue(":nota_para_livro", $this->nota_para_livro, PDO::PARAM_INT);
            $statement->bindValue(":comentario", $this->comentario);
            $bool = $statement->execute();
            return $bool;
            //return ['mensagemOk' => 'Comentario adicionado'];
        } catch (PDOException $erro) {
            return ['erroPdo' => $erro];
        }
    }

    public function pesquisarLivroPorTitulo($titulo_livro)
    {
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT id_livro, titulo_livro, autor_livro, imagem_livro FROM livros where titulo_livro like :titulo_livro LIMIT 3");
            $statement->bindValue(":titulo_livro",'%'. $titulo_livro . '%');
            $statement->execute();
            $livrosEncontrados = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (empty($livrosEncontrados)) {
                return ['mensagem' => 'Sem resultados'];
            } else {
                return $livrosEncontrados;
            }
        } catch (PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ['erroPdo' => $erroPdo];
        }
    } //fetch api

    public function salvarPagina(int $id_usuario, int $id_livro, $pagina){
        try {
            $this->id_usuario = $id_usuario;
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("UPDATE lista_de_leitura_usuario SET pagina_salva = :pagina WHERE id_usuario = :id_usuario AND id_livro = :id_livro");
            $statement->bindValue(":id_usuario", $id_usuario);
            $statement->bindValue(":id_livro", $id_livro);
            $statement->bindValue(":pagina", $pagina);
            $statement->execute();
            return ['mensagem' => "Página salva"];
        } catch (PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ['erroPdo' => $erroPdo];
        }
    }

    public function quizEstaConcluido($id_usuario, $id_livro){
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("SELECT * FROM quiz_respondidos_por_usuario WHERE id_usuario = :id_usuario and id_livro = :id_livro LIMIT 1");
            $statement->bindValue(":id_usuario", $id_usuario);
            $statement->bindValue(":id_livro", $id_livro);
            $statement->execute();
            $linhas = $statement->rowCount();
            if($linhas > 0){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ['erroPdo' => $erroPdo];
        }
    }

    public function editarComentario($id_usuario,$id_livro, $comentario){
        try {
            $conexaoDoBanco = ConexaoSql::conectarAoBanco();
            $statement = $conexaoDoBanco->prepare("UPDATE avaliacoes_de_usuarios set comentario = :comentario WHERE id_usuario = :id_usuario AND id_livro = :id_livro");
            $statement->bindValue(":id_livro", $id_livro);
            $statement->bindValue(":id_usuario", $id_usuario);
            $statement->bindValue(":comentario", $comentario);
            $statement->execute();
            return ['mensagem'=>'Comentário editado'];
        } catch (PDOException $erro) {
            $erroPdo = $erro->getMessage();
            return ['erroPdo' => $erroPdo];
        }
    }
    
}