<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['about_management'] = 'about_management'; 
$route['location_management'] = 'about_management/location'; 

$route['part_catalog/awaiting_image'] = 'part_catalog/awaiting_image';
$route['part_catalog/search'] = 'part_catalog/search';
$route['part_catalog/add'] = 'part_catalog/add';
$route['part_catalog/(:num)/delete'] = 'part_catalog/dele/$1';
$route['part_catalog/(:num)/available'] = 'part_catalog/available/$1';
$route['part_catalog/(:num)'] = 'part_catalog/edit/$1';
$route['part_catalog'] = 'part_catalog';

$route['part_order/(:num)'] = 'part_order/show/$1';
$route['part_order/dispatch/(:num)'] = 'part_order/dispatch/$1';

//$route['part_order'] = 'part_order';

$route['categories_management'] = 'categories_management';
$route['enquiry_management'] = 'enquiry_management';
$route['contact_management'] = 'contact_management';
$route['vehicle_management'] = 'vehicle_management';

$route['admin'] = "auth/login";
$route['admin/logout'] = "auth/logout";

$route['mercedes-parts'] = "parts";
$route['go/(:any)'] = "parts/go/$1";
$route['mercedes-parts/process'] = "parts/process";
$route['mercedes-parts/checkout'] = "parts/checkout";
$route['mercedes-parts/j/(:any)'] = "parts/j/$1";
$route['mercedes-parts/part/(:any)'] = "parts/part/$1";
$route['mercedes-parts/enquiry'] = "parts/enquiry";
$route['mercedes-parts/accessories/(:any)'] = "parts/product/0/Accessories/$1";
$route['mercedes-parts/(:any)/(:any)/(:any)'] = "parts/product/$1/$2/$3";
$route['mercedes-parts/accessories'] = "parts/products/0/Accessories";
$route['mercedes-parts/(:any)/(:any)'] = "parts/products/$1/$2";

$route['paypalintegration/test'] = "paypalintegration/test";


// -------------------------- START FRONTEND
$route['purchase_confirmation'] = "store/purchase_confirmation";

$route['oem_page/filter'] = "store/oem_filtered";
$route['oem'] = "store/oem";

$route['factor_page/filter'] = "store/factor_filtered";
$route['factor'] = "store/factor";

$route['recycled_page/filter'] = "store/recycled_filtered";
$route['recycled'] = "store/recycled";

$route['featured_page/filter'] = "store/featured_page_filtered";
$route['featured_page'] = "store/featured_page";

$route['bestseller_page/filter'] = "store/bestseller_page_filtered";
$route['bestseller_page'] = "store/bestseller_page";

$route['latest_page/filter'] = "store/latest_page_filtered";
$route['latest_page'] = "store/latest_page";

$route['offers_page/filter'] = "store/offers_page_filtered";
$route['offers_page'] = "store/offers_page";

$route['vehicle_filters'] = "store/vehicle_filters";
$route['group_filters'] = "store/group_filters";

$route['part_filters/(:any)'] = "store/part_filters/$1";
$route['part/(:any)/(:any)'] = "store/part_filters/$1/$2";


$route['vehicles/(:any)/(:any)'] = "store/vehiclesList/$1/$2";
$route['vehicles/(:any)'] = "store/vehiclesList/$1";
$route['vehicles'] = "store/vehiclesList";
$route['categories/(:any)/(:any)'] = "store/getPartByCategory/$1/$2";
$route['categories/(:any)'] = "store/getPartByCategory/$1";
$route['categories'] = "store/categoriesList";


$route['trucks/process'] = "checkout/process";
$route['trucks/checkout'] = "checkout";
$route['trucks/cart'] = "cart";
//$route['trucks/(:any)/(:any)/(:any)/part/(:any)/(:any)'] = "store/getParts/$1/$2/$3/$4";
//$route['trucks/(:any)/part/(:any)/(:any)'] = "store/getParts/$1/$2/$3/$4";
$route['part/(:any)/(:any)'] = "store/getParts/$1/$2";


$route['trucks/(:any)/(:any)/(:any)'] = "store/getPartByManufacturer/$1/$2/$3";
$route['trucks/(:any)/(:any)'] = "store/getPartByManufacturer/$1/$2";
$route['trucks/(:any)'] = "store/getPartByManufacturer/$1";
$route['trucks'] = "store/vehicles";
$route['terms'] = "store/terms";
$route['cookies'] = "store/cookies";
$route['contact'] = "store/contact";
$route['enquiry'] = "store/enquiry";

// -------------------------- END FRONTEND

// base
$route['default_controller'] = "store/vehicles";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
