<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/users', 'UserController::index');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register', 'RegisterController::register');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/create', 'DashboardController::create');  // For showing the form
$routes->post('/store', 'DashboardController::store');
$routes->get('/delete/(:num)', 'DashboardController::delete/$1');
$routes->get('/export', 'DashboardController::export');


// Route to display the form to edit an existing product
$routes->get('/edit/(:num)', 'DashboardController::edit/$1'); // where (:num) is the product ID

// Route to update the existing product
$routes->post('/update/(:num)', 'DashboardController::update/$1');



$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/profil', 'ProfilController::index');