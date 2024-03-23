<?php 
//mudar pra const pra testar

const routesGet = [
    '/' => '/views/usuario/login-cadastro.php',
    '/meu-perfil' => '/views/usuario/meu-perfil.php',
    '/placar-de-lideres' => '/views/usuario/leaderboard.php',
    '/informacoes-de-usuario' => '/views/usuario/info-usuario.php',
    '/detalhes-sobre-livro' => '/views/livros/detalhes-sobre-livro.php',
    '/galeria-de-livros' => '/views/livros/galeria-de-livros.php',
    '/pesquisar-livro' => '/controllers/json/pesquisar-por-livro.php',
    '/admin/editar-livro' => '/views/admin/editar-livro.php',
    '/admin/adicionar-livro' => '/views/admin/adicionar-livro.php',
    '/admin/livros-enviados' => '/views/admin/livros-enviados.php',
    '/admin/login-admin' => '/views/admin/login-admin.php',
    '/fechar-sessao' => '/controllers/php/usuario/fechar-sessao.php',
    '/lista-de-leitura'=>'/controllers/json/enviar-lista-leitura.php',
    '/lista-de-favoritos' => '/controllers/json/enviar-lista-favoritos.php',
    '/livros-paginados' => '/controllers/json/enviar-livros-paginados.php',
    '/quiz/quiz-livro' => '/controllers/json/enviar-quiz-de-livro.php',
    '/avaliacoes-sobre-livro' => '/controllers/json/enviar-intervalo-avaliacoes.php',
    '/livro-concluidos' => '/controllers/json/enviar-livros-concluidos.php',
    '/renderiza-pdf' => '/javascript/pdfjs/web/viewer.php'
];

const routesPost = [
    '/tentar-login' => '/controllers/php/usuario/fazer-login.php',
    '/armazenar-usuario' => '/controllers/json/armazenar-usuario.php',
    '/armazenar-livro' => '/controllers/php/admin/armazenar-livro.php',
    '/armazenar-livro-lista' => '/controllers/json/adicionar-lista-leitura.php',
    '/armazenar-favorito' => '/controllers/json/favoritar-livro.php',
    '/armazenar-avaliacao'=>'/controllers/json/adicionar-avaliacao.php',
    '/admin/tentar-login'=>'/controllers/php/admin/logar-admin.php',
    '/quiz/pontuar-quiz' => '/controllers/json/pontuar-quiz-usuario.php',
    '/atualizar-perfil' => '/controllers/json/atualizar-perfil.php'
];

const routesPut = [
    '/atualizar-livro' => '/atualiza-livro',
    '/atualizar-comentario' => '/controllers/json/atualizar-comentario.php',
    '/atualizar-pagina' => '/controllers/json/salvar-pagina.php',
    '/marcar-lido' => '/controllers/json/marcar-como-lido.php',
];

const routesDelete = [
    '/deletar-usuario' => '/deleta-usuario',
    '/deletar-livro' => '/deleta-livro',
    '/deletar-livro-lista' => '/controllers/json/remover-lista-leitura.php',
    '/deletar-favorito' => '/controllers/json/remover-dos-favoritos.php'
];