<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * WO APP Main Controller
 *
 * The main controller that extends the CI controller
 *
 * @package        	WO
 * @subpackage    	Core
 * @category    	Admin
 * @author        	Erik Galloway
 * @version         1.0.0
 */
	class MY_Controller extends CI_Controller {
		
		// Set our main data array that is passed onto
		// our child controllers as $this->data
		public $data = array();
		
		/**
     	* Constructor
     	*
		* Set CSS and JS arrays so the file locations can be called
		* by using $css['file_name'] in our views
     	*
     	*/
		function __construct() {
		
			parent::__construct();
		
			$this->data['errors'] = array();
			
			$this->data['css'] = array(
								
									'bootstrap' 	=> 'assets/css/bootstrap.css',
			
									'bootstrap_min' => 'assets/css/bootstrap.min.css',
									
									'datetimepicker' => 'assets/css/jquery.datetimepicker.css',

									'wo_admin' 		=> 'assets/css/wo_admin.css',	
									
									'font_awesome' 	=> 'assets/font-awesome-4.1.0/css/font-awesome.min.css',
									
									'jquery_theme' 	=> 'assets/css/jquery-ui.theme.css',						
									
									'morris' 		=> 'assets/css/plugins/morris.css',
									
									'datatables' 	=> 'assets/css/plugins/dataTables.bootstrap.css',
									
									'social_btns'	=> 'assets/css/plugins/social-buttons.css',
									
									'timeline'		=> 'assets/css/plugins/timeline.css',
									
									'metis_menu'	=> 'assets/css/plugins/metisMenu/metisMenu.min.css',
									
									'keyframes'		=> 'assets/css/keyframes.css',
									
									'transition'	=> 'assets/css/page_transitions.css',
									
									'animate'		=> 'assets/css/animate.css',

									'x_editable'	=> 'assets/css/x-editable.css',									

									);
			
			$this->data['js'] = array(
							
									'bootstrap' 	=> 'assets/js/bootstrap.js',

									'bootstrap_min'	=> 'assets/js/bootstrap.min.js',
									
									'bloodhound' 	=> 'assets/js/bloodhound.js',
									
									'datatables' 	=> 'assets/js/plugins/dataTables/jquery.dataTables.js',
									
									'datatables_bootstrap'=> 'assets/js/plugins/dataTables/dataTables.bootstrap.js',
									
									'datetimepicker' => 'assets/js/jquery.datetimepicker.js',
									
									'functions'		=> 	'assets/js/functions.js',

									'jquery' 		=> 'assets/js/jquery-1.11.0.js',
									
									'jquery_ui'		=> 'assets/js/jquery-ui.min.js',

									'metis_menu'	=> 'assets/js/plugins/metisMenu/metisMenu.min.js',
									
									'smoothState'	=> 'assets/js/jquery.smoothState.js',
									
									'type_ahead'	=> 'assets/js/typeahead.js',

									'x_editable'	=> 'assets/js/x-editable.min.js',									

									'wo_admin' 		=> 'assets/js/wo-admin.js',									
									

								);
		}
	}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */