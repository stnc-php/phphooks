<?php

//this plugin will never be loaded because it has no valid file name (*.plugin.php)

$plugin_id = basename(__FILE__);

$data['name'] = "Third plugin";
$data['author'] = "Nemanja Avramovic";
$data['url'] = "http://www.avramovic.info/";

//register plugin data
register_plugin($plugin_id, $data);

function plg3() {
	echo 'Plugin3 hooks on TEST,priority = 15<br />';
}

function njeh() {
	echo "Plugin3 hooks on TEST1<br />";
}

add_hook('test','plg3',15);
add_hook('test1','njeh');

echo "Plugin 3 LOADED!<br />";
?>