<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['static'] 					= '/static/';

// JSON2
$config['json2'] 					= $config['static'] . 'js/json2.js';

// jQuery
$config['jquery_bundle'] 			= $config['static'] . 'js/jquery-1.10.2.jquery-ui-1.10.3.custom.min.js';
$config['jquery_plugin'] 			= $config['static'] . 'js/jquery.plugin.placeholder.lazyload.cookie.js';
$config['jqueryui_css']				= $config['static'] . 'js/jqueryui/1.10.3/css/no-theme/jquery-ui-1.10.3.custom.min.css';

// SeaJS
$config['seajs'] 					= $config['static'] . 'js/seajs/sea.js';
$config['seajs-text'] 				= $config['static'] . 'js/seajs/seajs-text.js';

// Moe123
$config['moe_memcached_time'] 		= 1;

$config['moe']['site_css'] 			= $config['static'] . 'resource/app/moe-site/2013111601/css/style.css';
$config['moe']['site_js'] 			= $config['static'] . 'resource/app/moe-site/2013111601/js/moe.Site.js';

$config['moe']['index_css'] 		= $config['static'] . 'resource/app/moe-index/2013111301/css/style.css';
$config['moe']['index_js'] 			= $config['static'] . 'resource/app/moe-index/2013111301/js/moe.Index.js';

$config['moe']['loadbar_css'] 		= $config['static'] . 'resource/app/moe-loadbar/2013111501/css/style.css';
$config['moe']['loadbar_js'] 		= $config['static'] . 'resource/app/moe-loadbar/2013111501/js/moe.Loadbar.js';

$config['moe']['launcher_css'] 		= $config['static'] . 'resource/app/moe-launcher/2013111701/css/style.css';
$config['moe']['launcher_js'] 		= $config['static'] . 'resource/app/moe-launcher/2013111701/js/moe.Launcher.js';
