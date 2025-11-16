<?php
require_once './controladores/controladorPropietario.php';
require_once './controladores/controladorPropiedades.php';
require_once './modelos/modeloPropiedades.php';
require_once './libs/route.php';

$router = new Router();

$router->addRoute('propietarios/:id', 'GET', 'PropietarioController', 'obtenerPropietarioPorId');
$router->addRoute('propietarios', 'POST', 'PropietarioController', 'agregarPropietario');
$router->addRoute('propietarios', 'GET', 'PropietarioController', 'filtrarPropietarios');

$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedades');
$router->addRoute('propiedades/:id', 'GET', 'PropiedadesController', 'listarPropiedad');
$router->addRoute('propiedades/:id', 'PUT', 'PropiedadesController', 'updatePropiedad');


$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
