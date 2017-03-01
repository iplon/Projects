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

$route['index'] = 'report/index';

$route['Station_Report'] = 'report/Station_Report';
$route['one_ten_kv_Feeder'] = 'report/one_ten_kv_Feeder';
$route['Inverter_Report'] = 'report/Inverter_Report';
$route['Daily_Generation_Report'] = 'report/Daily_Generation_Report';


$route['excel_down'] = 'report/excel_down';
$route['test'] = 'report/test';

$route['check_avaiable'] = 'report/check_avaiable';

$route['check_html'] = 'report/check_html';
$route['check_excel'] = 'report/check_excel';


$route['test1/(:any)'] = 'report/excel_down/$1';
$route['test2/(:any)'] = 'report/pdf_down/$1';


$route['inverter_graph'] = 'report/inverter_graph';
$route['block_graph'] = 'report/block_graph';








/* End of file routes.php */
/* Location: ./application/config/routes.php */
