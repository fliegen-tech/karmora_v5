<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


// login routes

$route['login'] = "login/index";
$route['(:any)/login'] = "login/index/$1";
$route['(:any)/logout'] = "login/logout/$1";
$route['logout'] = "login/logout";

// karmora kash back routes

$route['karmora-cash-back'] = "karmora_cash_back/index";
$route['(:any)/karmora-cash-back'] = "karmora_cash_back/index/$1";


// product routes frontent

$route['flawless-product'] = "Product/flawless_product";
$route['(:any)/flawless-product'] = "product/flawless_product/$1";
$route['supplement-product'] = "Product/supplements";
$route['(:any)/supplement-product'] = "product/supplements/$1";
$route['product-detail/(:any)'] = "product/product_detail/$1";
$route['(:any)/product-detail/(:any)'] = "product/product_detail/$2/$1";

// good karmora ads share routes (cask-back, cash-o-palooza, smokin hot deal, custom ad)
$route['share'] = "share/index";
$route['(:any)/share'] = "share/index/$1";

//share product detail routes and

$route['share/making-money-ads'] = "share/custom_ads/make-money-ads";
$route['(:any)/share/making-money-ads'] = "share/custom_ads/make-money-ads/$1";

$route['share/saving-money-ads'] = "share/custom_ads/save-money-ads";
$route['(:any)/share/saving-money-ads'] = "share/custom_ads/save-money-ads/$1";

$route['share/exclusive-product-ads'] = "share/custom_ads/exclusive-product-ads";
$route['(:any)/share/exclusive-product-ads'] = "share/custom_ads/exclusive-product-ads/$1";

$route['share/karmora-flawless-skincare-ads'] = "share/shareadd/flawless";
$route['(:any)/share/karmora-flawless-skincare-ads'] = "share/shareadd/flawless/$1";

$route['share/karmora-b3-supplements-ads'] = "share/shareadd/supplements";
$route['(:any)/share/karmora-b3-supplements-ads'] = "share/shareadd/supplements/$1";

$route['share/winning-money-ads'] = "share/custom_ads/winning-money-ads";
$route['(:any)/share/winning-money-ads'] = "share/custom_ads/winning-money-ads/$1";

// run time image generate routes (cask-back, cash-o-palooza, smokin hot deal)
$route['share/karmora-ad-image/(:any)'] = "share/generateAdImage/$1";
$route['(:any)/share/karmora-ad-image/(:any)'] = "share/generateAdImage/$2/$1";

$route['share/cash-o-palooza-ad/(:any)'] = "share/generateCashoPaloozaAdImage/$1";
$route['(:any)/share/cash-o-palooza-ad/(:any)'] = "share/generateCashoPaloozaAdImage/$2/$1";
$route['(:any)/share/cash-o-palooza-ad-share/(:any)'] = "share/generateCashoPaloozaAdImageShare/$2/$1";

$route['share/smokin-hot-deal-ad/(:any)'] = "share/generateSmokinHotDealAdImage/$1";
$route['(:any)/share/smokin-hot-deal-ad/(:any)'] = "share/generateSmokinHotDealAdImage/$2/$1";

//Track Advertisment
$route['(:any)/track/(:any)/(:any)/(:any)'] = 'Landing_pages/AddtrackRequest/$1/$2/$3/$4';
$route['making-money-offer'] = "landing_pages/index/making-money";
$route['(:any)/making-money-offer'] = "landing_pages/index/making-money/$1";
$route['(:any)/(:any)/making-money-offer'] = "landing_pages/index/making-money/$1";
$route['(:any)/making-money-offer/(:any)/(:any)'] = "landing_pages/index/making-money/$1/$2/$3";
$route['winning-money-offer'] = "landing_pages/index/winning-money";
$route['(:any)/winning-money-offer'] = "landing_pages/index/winning-money/$1";
$route['(:any)/(:any)/winning-money-offer'] = "landing_pages/index/winning-money/$1";
$route['(:any)/winning-money-offer/(:any)/(:any)'] = "landing_pages/index/winning-money/$1/$2/$3";
$route['saving-money-offer'] = "landing_pages/index/saving-money";
$route['saving-money-offer'] = "landing_pages/index/saving-money";
$route['(:any)/saving-money-offer'] = "landing_pages/index/saving-money/$1";
$route['(:any)/saving-money-offer'] = "landing_pages/index/saving-money/$1";
$route['(:any)/(:any)/saving-money-offer'] = "landing_pages/index/saving-money/$1";
$route['(:any)/(:any)/saving-money-offer'] = "landing_pages/index/saving-money/$1";
$route['(:any)/saving-money-offer/(:any)/(:any)'] = "landing_pages/index/saving-money/$1/$2/$3";
$route['(:any)/saving-money-offer/(:any)/(:any)'] = "landing_pages/index/saving-money/$1/$2/$3";

//good karmora video share page routes

$route['share/good-karmora-videos'] = 'share/karmora_videos';
$route['(:any)/share/good-karmora-videos'] = 'share/karmora_videos/$1';

//email share page routes

$route['share/good-karmora-emails'] = 'share/email';
$route['(:any)/share/good-karmora-emails'] = 'share/email/$1';


//share Tripple karmora Kash

$route['share/triple-karmora-kash-add'] = 'share/tripple_karmora_kash';
$route['(:any)/share/triple-karmora-kash-add'] = 'share/tripple_karmora_kash/$1';


//share email preview route

$route['share/preview'] = "share/preview";
$route['(:any)/share/preview'] = "share/preview/$1";

$route['share/hotmail_callback'] = 'share/hotmail_callback';
$route['share/gmail_callback'] = 'share/gmail_callback';
$route['(:any)/share/gmail_callback'] = 'share/gmail_callback/$1';
//share main page routes
$route['share/good-karmora-ads/custom-ads'] = "share/custom_ads";
$route['(:any)/share/good-karmora-ads/custom-ads'] = "share/custom_ads/$1";


$route['share/(:any)'] = "share/index/$1";
$route['(:any)/share/(:any)'] = "share/$2/$1";

//stores routes
$route['store/storeSearch'] = "store/storeSearch";
$route['store/storeSearch/(:any)'] = "store/storeSearch/$1";
$route['(:any)/store/storeSearch/(:any)'] = "store/storeSearch/$2/$1";

$route['store'] = "store/allStore/all";
$route['(:any)/store'] = "store/allStore/all/$1";
$route['store/(:any)'] = "store/allStore/$1";
$route['(:any)/store/(:any)'] = "store/allStore/$2/$1";

//offers routes
$route['special-offer/(:any)'] = "store/specialDeals/$1";
$route['(:any)/special-offer/(:any)'] = "store/specialDeals/$2/$1";

/// blog route

$route['blog'] = "blog/index";
$route['(:any)/blog'] = "blog/index/$1";
$route['blog/category-detail/(:any)'] = "blog/category_detail/$1";
$route['(:any)/blog/category-detail/(:any)'] = "blog/category_detail/$2/$1";
$route['blog/post-detail/(:any)'] = "blog/post_detail/$1";
$route['(:any)/blog/post-detail/(:any)'] = "blog/post_detail/$2/$1";
$route['savefeedbackpost'] = "blog/savefeedbackpost";
$route['(:any)/savefeedbackpost'] = "blog/savefeedbackpost/$1";

// routes for cart

$route['cart/remove/(:any)'] = "cart/remove/$1";
$route['(:any)/cart/remove/(:any)'] = "cart/remove/$2/$1";
$route['cart'] = "cart/index";
$route['(:any)/cart'] = "cart/index/$1";
$route['cart/(:any)'] = "cart/$1";
$route['(:any)/cart/(:any)'] = "cart/$2/$1";

//route for checkout

$route['checkout'] = "checkout/index";
$route['order-confirmation'] = "checkout/order_conframtion";
$route['(:any)/order-confirmation'] = "checkout/order_conframtion/$1";
$route['(:any)/checkout'] = "checkout/index/$1";
$route['(:any)/(:any)/checkout'] = "checkout/index/$1";
$route['checkout/(:any)'] = "checkout/$1";
$route['(:any)/checkout/(:any)'] = "checkout/$2/$1";



// routes for tresurechest
$route['click2win'] = "tresurechest/index";
$route['(:any)/click2win'] = "tresurechest/index/$1";


// signup routes
$route['join-today'] = "signup/index";
$route['join-today/(:any)'] = "signup/index/$1";




// Authorize.net testing
$route['anet_test/(:any)'] = "Anet/$1";
$route['anet_test'] = "Anet/index";


// general routes {keep this section always at last}
$route['(:any)/index'] = "index/index/$1";
$route['(:any)'] = "index/index/$1";

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
