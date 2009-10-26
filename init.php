<?php

//include PHP HOOKS Class
include "phphooks.class.php";

//create instance of class
$hook = new phphooks();

//set hook to which plugin developers can assign functions
$hook->set_hook('test');

//set multiple hooks to which plugin developers can assign functions
$hook->set_hooks(array('test1','test2', 'with_args', 'filter'));

//load plugins from folder, if no argument is supplied, a './plugins/' constant will be used
//trailing slash at the end is REQUIRED!
//this method will load all *.plugin.php files from given directory, INCLUDING subdirectories
$hook->load_plugins();

//now, this is a workaround because plugins, when included, can't access $hook variable, so we
//as developers have to basically redefine functions which can be called from plugin files
function add_hook($tag, $function,$priority=10) {
	global $hook;
	$hook->add_hook($tag, $function,$priority);
}

//same as above
function register_plugin($plugin_id, $data) {
	global $hook;
	$hook->register_plugin($plugin_id, $data);
}

?>