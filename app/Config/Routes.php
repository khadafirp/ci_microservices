<?php

use App\Controllers\Berita;
use App\Controllers\Pengguna;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('/daftar', [Pengguna::class, 'daftar']);
$routes->post('/masuk', [Pengguna::class, 'masuk']);
$routes->post('/profil-pengguna', [Pengguna::class, 'getData']);

$routes->get('/semua-berita', [Berita::class, 'show'], ['filter' => 'authFilter']);
$routes->post('/tambah-berita', [Berita::class, 'create'], ['filter' => 'authFilter']);
$routes->post('/edit-berita', [Berita::class, 'edit'], ['filter' => 'authFilter']);
$routes->delete('/hapus-berita', [Berita::class, 'delete'], ['filter' => 'authFilter']);
