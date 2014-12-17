<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * WO APP User Controller
 *
 * The user controller controllers all login/authentication for WO
 *
 * @package        	WO
 * @subpackage    	Controllers
 * @category    	Admin
 * @author        	Erik Galloway
 * @version         1.0.0
 */


	class User extends Admin_Controller {
		
		/**
     	* Constructor
     	*
		* Gets the data array and sets the pg data var to user
     	*
     	*/
		public function __construct() {
			parent::__construct();
		}
		
		/**
		* Index
		*
		* Lists all the users in the database if the current user is a super-admin (demo-purposes)
		*
		* @param $id The id of the user to be edited
		*/		
	
		public function edit($id = NULL) {
			
			// Check the user type of the current logged in user.
			// If they are just an employee, they can only edit their own account
			if ($this->session->userdata('userType') == 'employee') {
				
				// Check if we have an id and if the the id matches the current users id
				if ($id AND $id == $this->session->userdata('id')) {
					
					// Get the user
					$this->data['user'] = $this->user_m->get($id);
					
					// If we couldnt get the user
					if (count($this->data['user']) == 0) {
						
						// get a new blank user object
						// set an error to be display
						$this->data['user'] = $this->user_m->get_new();							
						$this->data['errors'] = 'User could not be found.';	
				
					}
				}
				
				else {

					// redirect back to the index page
					// if the user isn't a super-admin and they are trying 
					// to access other users
					redirect('admin/user');
				}

			}

			else {
				// if we have an id get it and count the number we have
				if ($id) {
					$this->data['user'] = $this->user_m->get($id);
					
					if (count($this->data['user']) == 0) {
						
						// if the user doesn't exist, get a new object and set the error
						$this->data['user'] = $this->user_m->get_new();	
						$this->data['errors'] = 'User could not be found.';	
				
					}
				}
				else {
					// if there is no ID get a new object for a blank user
					$this->data['user'] = $this->user_m->get_new();	
				}	
			}
			
			// Set the rules			
			$rules = $this->user_m->rules_admin;
			
			// if we have an id, set the password rule to required
			$id || $rules['password']['rules'] .= '|required';
			$this->form_validation->set_rules($rules);
			
			// Process the form
			if ($this->form_validation->run() === TRUE) {
				
				// get the data from the post array
				$data = $this->user_m->array_from_post(
					array(
						'firstName', 
						'lastName', 
						'userEmail', 
						'username', 
						'userType'
					)
				);
				
				// if the user is just an admin, don't allow them to 
				// change there usertype in the database
				if ($this->session->userdata('userType') == 'admin') {
					$data['userType'] = 'admin';	
				}

				// if the password is posted hash it up
				if ($data['password'] != '') {
					
					$data['password'] = $this->user_m->hash($data['password']);
				
				}
				
				// save the user
				$this->user_m->save($data, $id);
				// redirect to the index page when were done
				redirect('admin/user');
			}
			
			// Load the view
			$this->data['subview'] = 'admin/user/edit';
			$this->load->view('admin/_layout_main', $this->data);
		}
		
		public function delete($id) {
			
			// if the user were trying to delete isn't a super admin 
			if ($this->user_m->is_super_admin($id) === FALSE) {
				
				// if the user isn't the logged in user
				if ($this->session->userdata('id') != $id) {		

					// delete the user
					$this->user_m->delete($id);
					redirect('admin/user');
				}
				else {
	
					redirect('admin/user', 'refresh');	
	
				}
			}
	
			else {
	
				redirect('admin/user');	
	
			}
		}
		
		public function login() {
			// Redirect the user logged in
			$dashboard = 'admin/dashboard';
			
			$this->user_m->loggedin() === FALSE OR redirect($dashboard);
			
			$this->data['is_locked'] = $this->user_m->is_locked();
			
			// Set the form
			$rules = $this->user_m->rules;
			$this->form_validation->set_rules($rules);
			
			// Process the form
			if ($this->form_validation->run() === TRUE) {
			
				// Login the user in and redirect
				if ($this->user_m->login() === TRUE) {
					redirect($dashboard);	
				}
				else {
										
					$this->session->set_flashdata('error', 'The username/password combination does not exsist.');
				
					if ($this->user_m->loggedin() == FALSE) {
						$this->user_m->add_attempt();
					}
					redirect('admin/user/login');	
				}
			}
						
			// Load the view
			$this->data['subview'] = 'admin/user/login';
			$this->load->view('admin/_layout_modal', $this->data);	
		}
		
		public function logout() {
			$this->user_m->logout();
			redirect('admin/user/login');	
		}
		
		public function _unique_email($str) {
			// Do not validate if the email already exists
			// Unless its the email for the current user
			
			$id = $this->uri->segment(4);
			$this->db->where('userEmail', $this->input->post('userEmail'));
			!$id || $this->db->where('userID !=', $id);
			$user = $this->user_m->get();
			if (count($user)) {
				$this->form_validation->set_message('_unique_email', '%s is already set and taken.');
				return FALSE;
			}
			return TRUE;
		}
		
		public function _unique_username($str) {
			$id = $this->uri->segment(4);
			$this->db->where('username', $this->input->post('username'));
			!$id || $this->db->where('userID !=', $id);
			$user = $this->user_m->get();
			if (count($user)) {
				$this->form_validation->set_message('_unique_username', '%s is already set and taken.');
				return FALSE;
			}
			return TRUE;
		}
	}