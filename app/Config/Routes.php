<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to use it, set this value to false.
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Route par défaut (Accueil)
$routes->get('/', 'Home::index');

// Routes par section
$routes->get('section/(:segment)', 'Home::section/$1');

// Route complexe format "Le Monde"
// actualite/{annee}/{mois}/{jour}/{slug}_{id}.html
$routes->get('actualite/(:num)/(:num)/(:num)/([a-z0-9\-]+)_(:num)\.html', 'ArticleController::view/$1/$2/$3/$4/$5');

// Routes BackOffice
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
});

$routes->group('articles', ['filter' => 'auth'], function($routes) {
    $routes->get('create', 'AdminController::create');
    $routes->post('store', 'AdminController::store');
    $routes->get('edit/(:num)', 'AdminController::edit/$1');
    $routes->post('update/(:num)', 'AdminController::update/$1');
    $routes->get('delete/(:num)', 'AdminController::delete/$1');
    $routes->post('upload', 'ImageUploadController::upload'); // Route pour TinyMCE
});
