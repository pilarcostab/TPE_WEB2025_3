<?php
require_once './app/controladores/controladorPropietario.php';
require_once './libs/route.php';

$router = new Router();

$router->addRoute('propietarios/:id', 'GET', 'PropietarioController', 'obtenerPropietarioPorId');
$router->addRoute('propietarios', 'POST', 'PropietarioController', 'agregarPropietario');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesv');
$router->addRoute('propiedades/:id', 'PUT', 'PropiedadesController', 'editarPropiedad');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
