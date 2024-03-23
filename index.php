<?php
require_once 'rotas.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/roteamento.php';

$roteamento = new Roteamento(routesGet, routesPost, routesPut, routesDelete);

$roteamento->ativar();


