<?php
require_once 'rotas.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/roteamento.php';

header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // You should specify the allowed methods.
header("Access-Control-Allow-Headers: Content-Type");
$roteamento = new Roteamento(routesGet, routesPost, routesPut, routesDelete);

$roteamento->ativar();


