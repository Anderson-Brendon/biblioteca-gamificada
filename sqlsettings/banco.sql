create database biblioteca_gamificada;

create table usuarios(id_usuario int primary key AUTO_INCREMENT, 
nick_usuario varchar(255), 
senha_usuario varchar(255), 
caminho_imagem_perfil varchar(255) default '/resources/imagens/usuarios/perfil-padrao.jpg', 
qtd_livros_lidos int default 0, 
qtd_livros_favoritos int default 0, 
nivel_de_acesso tinyint default 0,
codigo_de_recuperacao int(6),
email varchar(255) default 'nao_definido',
pontos_totalizados_de_quiz int default 0,
citacao_favorita varchar(255) default 'Citação não definida', 
autor_citacao varchar(255) default 'Valor padrão do MySql' );

create table categoria_livro(id_categoria int primary key AUTO_INCREMENT,  nome_categoria varchar(255) not null);

create table livros(
  id_livro int primary key AUTO_INCREMENT,
  titulo_livro varchar(255) UNIQUE,
  data_publicacao date, 
  media_avaliacao_livro int default 0, 
  autor_livro varchar(255) not null, 
  id_categoria int,
  data_envio date default (CURDATE()), 
  descricao text,
  imagem_livro varchar(255) not null, 
  qtd_avaliacoes_usuarios int default 0, 
  total_de_notas_somadas int default 0, 
  arquivo_pdf varchar (255) not null, 
  quiz_esta_disponivel tinyint default 0, 
  qtd_paginas int, 
  FOREIGN KEY(id_categoria) REFERENCES categoria_livro(id_categoria));

create table autores(primary key id_autor AUTO_INCREMENT, nome_autor)

create table avaliacoes_de_usuarios(
  id_avaliacao int primary key AUTO_INCREMENT,
  comentario varchar(255) DEFAULT 'Comentário indisponível',
  nota_para_livro int not null,
  id_usuario int not null,
  id_livro int not null , 
  foreign key (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE, 
  foreign key (id_livro) references livros(id_livro) ON DELETE CASCADE);

create table livros_favoritos_usuario(
  PRIMARY KEY(id_usuario, id_livro),
  id_usuario int not null,
  id_livro int not null,
  FOREIGN KEY(id_usuario) references usuarios(id_usuario) ON DELETE CASCADE,
  FOREIGN KEY(id_livro) references livros(id_livro) ON DELETE CASCADE);

create table lista_de_leitura_usuario(
    primary key (id_usuario, id_livro), 
    id_usuario int not null, 
    id_livro int not null,
    esta_lido tinyint default 0, 
    pagina_salva int default 0, 
    foreign key(id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
     foreign key (id_livro) references livros(id_livro) ON DELETE CASCADE);


create table perguntas_de_quiz(
    id_pergunta int primary key AUTO_INCREMENT, 
    quiz_questao text, alternativa_A varchar(255), 
    alternativa_B varchar(255), 
    alternativa_C varchar(255), 
    alternativa_D varchar(255), 
    alternativa_correta char, 
    id_livro int,
    FOREIGN KEY(id_livro) references livros(id_livro));

create table quiz_respondidos_por_usuario(
    PRIMARY KEY(id_livro, id_usuario),
    id_livro int, id_usuario int, 
    FOREIGN KEY(id_livro) REFERENCES livros(id_livro) ON DELETE CASCADE, 
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE, 
    num_respostas_corretas int not null);