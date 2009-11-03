<?php

/*
Plugin Name: Plugin1
Plugin URI: http://www.instant-update.com/
Description: This is plugin1
Version: 1.0
Author: Nemanja
Author URI: http://www.instant-update.com/
*/


//set plugin id as file name of plugin
$plugin_id = basename(__FILE__);

//some plugin data
$data['name'] = "First plugin";
$data['author'] = "Nemanja";
$data['url'] = "http://www.instant-update.com/";

//register plugin data
register_plugin($plugin_id, $data);

//plugin function
function testfunc() {
	echo 'Plugin1 hooks into TEST, priority = default(10)<br />';
}

function filter2($url,$url1) {
	$return[] = "$url:80/";
	$return[] = "$url1:80/";
	return $return;
}

add_hook('filter','filter2',7);

//add hook, where to execute a function
add_hook('test','testfunc');

//code to execute when loading plugin
echo "<p>Plugin 1 LOADED!</p>";
?>