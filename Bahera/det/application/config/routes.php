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

$route['default_controller'] = 'login';
$route['404_override'] = 'error_404/index';
$route['checklogin'] ='login/checklogin';
$route['profile'] = 'login/profile';
$route['updateprofile'] = 'login/updateprofile';
$route['logout'] = 'login/logout';
$route['benchmark'] = 'benchmark/index';
$route['filterData'] = 'benchmark/filterData';
$route['det'] = 'det/index';
$route['getBlock'] = 'det/getBlock';
$route['ajax_call'] = 'det/ajax_call';

$route['alarm'] = 'alarm/index';
$route['show'] = 'show/index';


$route['DetfilterData'] = 'det/filterData';
$route['cascade'] = 'countries/index';


$route['getPowerData/(:num)'] = 'benchmark/getPowerData';
$route['getEnergyData/(:num)'] = 'benchmark/getEnergyData';
$route['dashboard'] = 'dashboard/index';
$route['dashbFilterData'] = 'dashboard/dashbFilterData';
$route['overview'] = 'overview/index';
$route['overview/(:num)'] = 'overview/index/$1';
$route['presentation'] = 'presentation/index';
$route['presentation/(:num)'] = 'presentation/index/$1';
$route['systemview'] = 'systemview/index';
$route['systemview/(:num)'] = 'systemview/index/$1';
$route['plantDetails/(:num)'] = 'overview/plantDetails/$1';
$route['getPerformanceratio/(:num)'] = 'overview/getPerformanceratio/$1';
$route['getEnvironment'] = 'overview/getEnvironment';

$route['buildDropDevice'] = 'det/buildDropDevice';
$route['buildDropField'] = 'det/buildDropField';
$route['buildTable'] = 'det/buildTable';
$route['buildExcel'] = 'det/buildExcel';
$route['buildGraph'] = 'det/buildGraph';

$route['buildTableDayVariable'] = 'det/buildTableDayVariable';

$route['tab'] = 'tab/index';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
