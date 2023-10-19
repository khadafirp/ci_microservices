<?php

use App\Controllers\Berita;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/show-all-berita', [Berita::class, 'show']);
$routes->post('/add-berita', [Berita::class, 'create']);
$routes->post('/edit-berita', [Berita::class, 'edit']);
$routes->delete('/hapus-berita', [Berita::class, 'delete']);
