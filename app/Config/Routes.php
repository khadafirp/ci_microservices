<?php

use App\Controllers\Berita;
use App\Controllers\Pengguna;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/daftar', [Pengguna::class, 'daftar']);
$routes->post('/masuk', [Pengguna::class, 'masuk']);
$routes->post('/get-pengguna', [Pengguna::class, 'getData']);

$routes->get('/show-all-berita', [Berita::class, 'show'], ['filter' => 'authFilter']);
$routes->post('/add-berita', [Berita::class, 'create']);
$routes->post('/edit-berita', [Berita::class, 'edit']);
$routes->delete('/hapus-berita', [Berita::class, 'delete']);
