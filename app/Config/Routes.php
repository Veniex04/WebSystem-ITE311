<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ✅ Public routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// ✅ Auth routes
$routes->match(['GET', 'POST'], 'auth/login', 'Auth::login');
$routes->match(['GET', 'POST'], 'auth/register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');

$routes->get('dashboard', 'Auth::dashboard');
$routes->get('manage-users', 'Auth::manageUsers');
$routes->get('manage-courses', 'Auth::manageCourses');

// Aliases
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('logout', 'Auth::logout');

// ✅ Unified Dashboard (view inside views/auth/dashboard.php)
$routes->get('dashboard', 'Auth::dashboard');

$routes->post('/course/enroll', 'Course::enroll');
$routes->match(['GET', 'POST'], 'dashboard', 'Auth::dashboard');

// ✅ Materials routes
$routes->match(['GET', 'POST'], 'materials/upload/(:num)', 'Materials::upload/$1');
$routes->get('materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('materials/download/(:num)', 'Materials::download/$1');
$routes->get('materials/list/(:num)', 'Materials::list/$1');

// ✅ Admin course materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/admin/course-management', 'Auth::courseManagement');







