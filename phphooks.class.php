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

	/**
	 * plugins data
	 * @array $plugins
	 */
	var $plugins = array();

	/**
	 * hooks data
	 * @array $hooks
	 */
	var $hooks = array();

	/**
	 * register hook name/tag, so plugin developers can attach functions to hooks
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 */
	function set_hook($tag) {
		$this->hooks[$tag] = '';
	}
	
	/**
	 * register multiple hooks name/tag
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param array $tag The name of the hooks.
	 */
	function set_hooks($tags) {
		foreach ($tags as $tag) {
			$this->set_hook($tag);
		}
	}

	/**
	 * write hook off
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 */
	function unset_hook($tag) {
		unset($this->hooks[$tag]);
	}

	/**
	 * write multiple hooks off
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param array $tag The name of the hooks.
	 */
	function unset_hooks($tags) {
		foreach ($tags as $tag) {
			$this->developer_unset_hook($tag);
		}
	}

	/**
	 * load plugins from specific folder, includes all *.plugin.php files
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param var $from_folder option. load plugins from folder, if no argument is supplied, a 'plugins/' constant will be used
	 */
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
	
	/**
	 * attach custom function to hook
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 * @param string $function The function you wish to be called.
	 * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed.(range 0~20, 0 first call, 20 last call)
	 */
	function add_hook($tag, $function , $priority = 10) {
		if (!isset($this->hooks[$tag])) { 
			die("There is no such place ($tag) for hooks."); 
		}
		else {
			$this->hooks[$tag][$priority][] = $function;
		}
	}
	
	/**
	 * check whether any function is attached to hook
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 */
	function hook_exist($tag) {
		return (trim($this->hooks[$tag]) == "") ? false : true ;
	}
	
	/**
	 * execute all functions which are attached to hook, you can provide argument (or arguments via array)
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 * @param array $args optional.The arguments the function accept (default none)
	 * @return option.
	 */
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
	
	/**
	 * filter $args and after modify, return it. (or arguments via array)
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $tag The name of the hook.
	 * @param array $args optional.The arguments the function accept to filter(default none)
	 * @return array. The $args filter result.
	 */
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
	
	/**
	 * register plugin data in $this->plugin
	 * @package phphooks
	 * @since 1.0
	 * 
	 * @param string $plugin_id. The name of the plugin.
	 * @param array $data optional.The data the plugin accessorial(default none)
	 */
	function register_plugin($plugin_id, $data='') {
		foreach ($data as $key=>$value) {
			$this->plugins[$plugin_id][$key] = $value;
		}
	}
}
?>