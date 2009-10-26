<?php

$plugin_id = basename(__FILE__);

$data['name'] = "Second plugin";
$data['author'] = "Nemanja";
$data['url'] = "http://www.avramtar.com/";

//register plugin data
register_plugin($plugin_id, $data);

function plg2() {
	echo 'Plugin2 hooks on TEST, priority = 2<br />';
}

function njeh() {
	echo "Plugin2 hooks on TEST1<br />";
}

function filter1($url,$url1) {
	$return[] = "http://www.$url.com";
	$return[] = "http://www.$url1.com";
	return $return;
}

add_hook('filter','filter1',2);
add_hook('test','plg2',2);
add_hook('test1','njeh');

echo "<p>Plugin 2 LOADED!</p>";
?>