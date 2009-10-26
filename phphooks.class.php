<?php
/**
 * @author eric.wzy@gmail.com
 * @version 1.0
 * @package phphooks
 * @category Plugins
 * 
 * LGPL license
 */

define('PLUGINS_FOLDER', 'plugins/');

class phphooks{

	var $plugins = array();
	var $hooks = array();

	//register hook name/tag, so plugin developers can attach functions to hooks
	function set_hook($tag) {
		$this->hooks[$tag] = '';
	}
	
	//register multiple hooks name/tag
	function set_hooks($tags) {
		foreach ($tags as $tag) {
			$this->set_hook($tag);
		}
	}
	
	//write hook off
	function unset_hook($tag) {
		unset($this->hooks[$tag]);
	}
	
	//write multiple hooks off
	function unset_hooks($tags) {
		foreach ($tags as $tag) {
			$this->developer_unset_hook($tag);
		}
	}

	//load plugins from specific folder, includes all *.plugin.php files
	function load_plugins($from_folder = PLUGINS_FOLDER) {
	
		if ($handle = @opendir($from_folder)) {
	
			while ($file = readdir($handle)) {
				if (is_file($from_folder . $file)) {
					if (strpos($from_folder . $file,'.plugin.php')) {
						require_once $from_folder . $file;
						$this->plugins[$file]['file'] = $file;
					}
				}
				else if ((is_dir($from_folder . $file)) && ($file != '.') && ($file != '..')) {
					$this->load_plugins($from_folder . $file . '/');
				}
			}
	
			closedir($handle);
		}
		
	}
	
	//attach custom function to hook
	function add_hook($tag, $function , $priority = 10) {
		if (!isset($this->hooks[$tag])) { 
			die("There is no such place ($tag) for hooks."); 
		}
		else {
			$this->hooks[$tag][$priority][] = $function;
		}
	}
	
	//check whether any function is attached to hook
	function hook_exist($tag) {
		return (trim($this->hooks[$tag]) == "") ? false : true ;
	}
	
	//execute all functions which are attached to hook, you can provide argument (or arguments via array) as second parameter
	function execute_hook($tag, $args = '') {
		if (isset($this->hooks[$tag])) {
			$these_hooks = $this->hooks[$tag];
			for ($i=0; $i<=20; $i++) {
				if (isset($these_hooks[$i])){
					foreach ($these_hooks[$i] as $hook) {
						$args[] = $result;
						if (function_exists($hook)) { $result = call_user_func_array($hook, $args); }
					}
				}
			}
			return $result;
		}
		else {
			die("There is no such place ($tag) for hooks."); 
		}
	}
	
	//filter $args and return back.
	function filter_hook($tag, $args = '') {
		$result = $args;
		if (isset($this->hooks[$tag])) {
			$these_hooks = $this->hooks[$tag];
			for ($i=0; $i<=20; $i++) {
				if (isset($these_hooks[$i])){
					foreach ($these_hooks[$i] as $hook) {
						$args=$result;
						if (function_exists($hook)) { $result = call_user_func_array($hook, $args); }
					}
				}
			}
			return $result;
		}
		else {
			die("There is no such place ($tag) for hooks."); 
		}
	}
	
	//register plugin data in $this->plugin
	function register_plugin($plugin_id, $data) {
		foreach ($data as $key=>$value) {
			$this->plugins[$plugin_id][$key] = $value;
		}
	}
}
?>