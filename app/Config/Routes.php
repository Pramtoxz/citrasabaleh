<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
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
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Auth Routes
$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    
    // Register Routes
    $routes->get('register', 'Auth::registerForm');
    $routes->post('register', 'Auth::register');
    $routes->post('verify-register-otp', 'Auth::verifyRegisterOTP');
    
    // Forgot Password Routes
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::forgotPassword');
    $routes->post('verify-forgot-password-otp', 'Auth::verifyForgotPasswordOTP');
    $routes->post('reset-password', 'Auth::resetPassword');
    
    // Resend OTP
    $routes->post('resend-otp', 'Auth::resendOTP');
});

// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('users', 'Admin::users');
    $routes->get('profile', 'Admin::profile');
    $routes->get('settings', 'Admin::settings');
});

// Tamu Routes
$routes->get('tamu', 'Tamu::index');
$routes->get('tamu/datatable', 'Tamu::datatable');
$routes->get('tamu/new', 'Tamu::new');
$routes->post('tamu/create', 'Tamu::create');
$routes->get('tamu/edit/(:segment)', 'Tamu::edit/$1');
$routes->post('tamu/update/(:segment)', 'Tamu::update/$1');
$routes->get('tamu/show/(:segment)', 'Tamu::show/$1');
$routes->delete('tamu/delete/(:segment)', 'Tamu::delete/$1');
$routes->post('tamu/create-user', 'Tamu::createUser');

// Kamar Routes
$routes->get('kamar', 'Kamar::index');
$routes->get('kamar/datatable', 'Kamar::datatable');
$routes->get('kamar/new', 'Kamar::new');
$routes->post('kamar/create', 'Kamar::create');
$routes->get('kamar/edit/(:segment)', 'Kamar::edit/$1');
$routes->post('kamar/update/(:segment)', 'Kamar::update/$1');
$routes->get('kamar/show/(:segment)', 'Kamar::show/$1');
$routes->delete('kamar/delete/(:segment)', 'Kamar::delete/$1');

// Auth routes
$routes->get('auth', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::attemptLogin');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::attemptRegister');
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/forgot-password', 'Auth::attemptForgotPassword');
$routes->get('auth/reset-password', 'Auth::resetPassword');
$routes->post('auth/reset-password', 'Auth::attemptResetPassword');
$routes->get('auth/verify-otp', 'Auth::verifyOtp');
$routes->post('auth/verify-otp', 'Auth::attemptVerifyOtp');
$routes->post('auth/resend-otp', 'Auth::resendOtp');
$routes->get('auth/logout', 'Auth::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
