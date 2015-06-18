<?php 

/*
Plugin Name: Flickr-stream	
Plugin URI: http://www.codeclouds.net/flickrstream/
Description: This plugin allows you to include photosets and gallerys from Flickr in your wordpress site, either embedded into a page or post, or as a sidebar widget
Version: 1.2.5
Author: Dustin Scarberry
Author URI: http://www.codeclouds.net/
License: GPL2
*/

/*  2013 Dustin Scarberry webmaster@codeclouds.net

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('flickrStream'))
{

	class flickrStream
	{
	
		private $_admin, $_frontend, $_options;
		const CURRENT_VERSION = '1.2.5';
		
		public function __construct()
		{
			
			//load options
			$this->_options = get_option('flickrstream_main_opts');
			
			//check for upgrade
			$this->upgrade_check();
			
			//load external files
			$this->load_dependencies();
		
			//activation hook
			register_activation_hook(__FILE__, array(&$this, 'activate'));
			
			//include photo widget
			require_once 'photos_widget.php';
			add_action('widgets_init', array(&$this, 'setup_widgets'));
			
		}
		
		//activate plugin
		public function activate()
		{
		
			$this->maintenance();
		
		}
		
		//load dependencies for plugin
		private function load_dependencies()
		{
		
			load_plugin_textdomain('flickrstm', false, 'flickr-stream/language');
			
			//load backend or frontend dependencies
			if(is_admin())
			{
			
				require dirname(__FILE__) . '/admin.php';
				$this->_admin = new fsAdmin();

			}
			else
			{
			
				require_once dirname(__FILE__) . '/frontend.php';
				$this->_frontend = new fsFrontend();
			
			}
		
		}
		
		private function maintenance()
		{
			
			if(empty($this->_options))
				$this->_options = array();
				
			$dft['apikey'] = '';
			$dft['marker'] = 1;
			$dft['fancyboxInc'] = 'no';
			$dft['useMobileView'] = 'no';
			$dft['highlightColor'] = '#397fdf';
			$dft['version'] =  self::CURRENT_VERSION;
				
			$this->_options = $this->_options + $dft;
				
			update_option('flickrstream_main_opts', $this->_options);
		
		}
		
		private function upgrade_check()
		{
		
			if(!isset($this->_options['version']) || $this->_options['version'] < self::CURRENT_VERSION){
			
				$this->_options['version'] = self::CURRENT_VERSION;
				$this->maintenance();
					
			}
		
		}
		
		public function setup_widgets()
		{
		
			register_widget('Flickrstream_Widget');
		
		}
		
	}

	$fsPlugin = new flickrStream();

}
?>