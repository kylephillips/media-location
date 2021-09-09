<?php
/*
Plugin Name: Media Location
Plugin URI: https://github.com/kylephillips/media-location
Description: Save a location with media uploads
Version: 1.0.0
Author: Kyle Phillips
Author URI: https://github.com/kylephillips
License: GPL
*/
$loader = require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/app/Bootstrap.php');
define('MEDIALOCATION_DIR', __DIR__);
define('MEDIALOCATION_URI', __FILE__);
$media_location_plugin = new MediaLocation\Bootstrap;