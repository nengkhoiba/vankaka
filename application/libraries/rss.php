<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH.'third_party/autoloader.php';
 
define('SIMPLEPIE_CACHE_PATH', APPPATH . 'third_party/library/SimplePie/cache');
 
class Rss extends SimplePie
{ 
    public $cache_location = SIMPLEPIE_CACHE_PATH;
 
    public function __construct() { 
        parent::__construct();
    } 
}