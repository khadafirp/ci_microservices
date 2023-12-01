<?php

use App\Controllers\Berita;
use App\Controllers\Pengguna;
use App\Controllers\Statistik;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('/daftar', [Pengguna::class, 'daftar']);
$routes->post('/masuk', [Pengguna::class, 'masuk']);
$routes->post('/profil-pengguna', [Pengguna::class, 'getData']);

$routes->get('/semua-berita', [Berita::class, 'show'], ['filter' => 'authFilter']);
$routes->post('/filter-berita', [Berita::class, 'filter'], ['filter' => 'authFilter']);
$routes->post('/tambah-berita', [Berita::class, 'create'], ['filter' => 'authFilter']);
$routes->post('/edit-berita', [Berita::class, 'edit'], ['filter' => 'authFilter']);
$routes->post('/hapus-berita', [Berita::class, 'delete'], ['filter' => 'authFilter']);

$routes->get('/foto/(:any)', [Berita::class, 'downloadfile']);
$routes->get('/statistik', [Statistik::class, 'showAll'], ['filter' => 'authFilter']);
