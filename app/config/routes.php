<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Framework routes
$route['default_controller'] = 'main';
$route['404_override'] = 'notify/error_404';
$route['translate_uri_dashes'] = TRUE;

// Shop routes
$route['shop'] = 'main';
$route['shop/search'] = 'shop/shop/search';
$route['shop/products'] = 'shop/shop/products';
$route['product/(:any)'] = 'shop/shop/product/$1';
$route['category/(:any)'] = 'shop/shop/products/$1';
$route['brand/(:any)'] = 'shop/shop/products/0/0/$1';
$route['category/(:any)/(:any)'] = 'shop/shop/products/$1/$2';

// Page route
$route['page/(:any)'] = 'shop/shop/page/$1';

// Cart routes
$route['cart'] = 'shop/cart_ajax';
$route['cart/(:any)'] = 'shop/cart_ajax/$1';
$route['cart/(:any)/(:any)'] = 'shop/cart_ajax/$1/$2';

// Misc routes
$route['shop/(:any)'] = 'shop/shop/$1';
$route['shop/(:any)/(:any)'] = 'shop/shop/$1/$2';
$route['shop/(:any)/(:any)/(:any)'] = 'shop/shop/$1/$2/$3';

// Auth routes
$route['login'] = 'main/login';
$route['logout'] = 'main/logout';
$route['profile'] = 'main/profile';
$route['register'] = 'main/register';
$route['login/(:any)'] = 'main/login/$1';
$route['logout/(:any)'] = 'main/logout/$1';
$route['profile/(:any)'] = 'main/profile/$1';
$route['forgot_password'] = 'main/forgot_password';
$route['activate/(:any)/(:any)'] = 'main/activate/$1/$2';
$route['reset_password/(:any)'] = 'main/reset_password/$1';

// Admin area routes
$route['admin'] = 'admin/welcome';
$route['admin/users'] = 'admin/auth/users';
$route['admin/users/create_user'] = 'admin/auth/create_user';
$route['admin/users/profile/(:num)'] = 'admin/auth/profile/$1';
$route['admin/login'] = 'admin/auth/login';
$route['admin/login/(:any)'] = 'admin/auth/login/$1';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/logout/(:any)'] = 'admin/auth/logout/$1';
// $route['admin/register'] = 'admin/auth/register';
$route['admin/forgot_password'] = 'admin/auth/forgot_password';
$route['admin/sales/(:num)'] = 'admin/sales/index/$1';
$route['admin/products/(:num)'] = 'admin/products/index/$1';
$route['admin/purchases/(:num)'] = 'admin/purchases/index/$1';
$route['admin/quotes/(:num)'] = 'admin/quotes/index/$1';
