<?php 
namespace MediaLocation;

class Helpers 
{
	/**
	* Plugin Root Directory
	*/
	public static function plugin_url()
	{
		return plugins_url('/', MEDIALOCATION_URI);
	}

	/**
	* View
	*/
	public static function view($file)
	{
		return dirname(dirname(__FILE__)) . '/views/' . $file . '.php';
	}
}