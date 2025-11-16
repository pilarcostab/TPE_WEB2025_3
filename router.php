<?php
require_once './controladores/controladorPropietario.php';
require_once './libs/route.php';

$router = new Router();
//B
$router->addRoute('propietarios/:id', 'GET', 'PropietarioController', 'obtenerPropietarioPorId');
$router->addRoute('propietarios', 'POST', 'PropietarioController', 'agregarPropietario');
$router->addRoute('propietarios', 'GET', 'PropietarioController', 'filtrarPropietarios');

$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesv');
$router->addRoute('propiedades/:id', 'PUT', 'PropiedadesController', 'editarPropiedad');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedades');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesPorHabitaciones');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesPorMetrosCuadrados');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesPorPropietario');
$router->addRoute('propiedades', 'GET', 'PropiedadesController', 'listarPropiedadesPorTipoPropiedad');


$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
