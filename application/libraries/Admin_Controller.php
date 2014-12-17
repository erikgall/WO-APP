<?php
	class Admin_Controller extends MY_Controller {
		
		function __construct() {
			parent::__construct();
			
			// Load the Session Library for Login		
			$this->load->library('session');
		
			// Load the User Model for Login methods
			$this->load->model('user_m');

			// Login Check
			$exception_uris = array(
				'admin/user/login', 
				'admin/user/logout',
				'admin/user/register'
			);
			
			if (in_array(uri_string(), $exception_uris) === FALSE) {
				if ($this->user_m->loggedin() === FALSE) {
					redirect('admin/user/login');
				}
			}
			
			$this->data['db_tables'] = array(
				'assignment',
				'client',
				'employee',
				'invoice',
				'job',
				'project',
				
			);
		}
	}

/* End of file MY_Model.php */
/* Location: ./application/library/Admin_Controller.php */