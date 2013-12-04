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

$route['default_controller'] 				= "front/index";
$route['404_override'] 						= '';

$route['im-feeling-lucky'] 					= "front/go_single_rand_site";

$route['category/artist'] 					= "front/artist";
$route['category/read'] 					= "front/read";
$route['category/geek'] 					= "front/geek";

$route['portal/switch_pc'] 					= "front/force_switch_pc_version";
$route['portal/switch_mobile'] 				= "front/force_switch_mobile_version";

$route['collect/light-novel-title'] 		= "collection/light_novel_title";
$route['collect/light-novel-title-json'] 	= "collection/light_novel_title_json";

$route['website/redirect/(:num)']			= "front/website_redirect/$1";
$route['go/(:any)'] 						= "front/shortener_go/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */