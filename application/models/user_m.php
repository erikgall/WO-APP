<?php
	class User_M extends MY_Model {
		protected $_table_name = 'users';
		protected $_primary_key = 'user_id';
		protected $_order_by = 'user_id';
		public $rules = array(
			'username' => array(
				'field' => 'username', 
				'label' => 'Username', 
				'rules' => 'trim|required|xss_clean'
			),
			'password' => array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'trim|required'
			)
		);
		
		public $rules_admin = array(
			'username' => array(
				'field' => 'username', 
				'label' => 'Username', 
				'rules' => 'trim|required|callback__unique_username|xss_clean'
			),
			'password' => array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'trim|matches[password_confirm]'
			),
			'password_confirm' => array(
				'field' => 'password_confirm', 
				'label' => 'Confirm password', 
				'rules' => 'trim|matches[password]'
			),
			'userEmail' => array(
				'field' => 'userEmail', 
				'label' => 'Email Address', 
				'rules' => 'trim|required|valid_email|callback__unique_email|xss_clean'
			),
			'firstName' => array(
				'field' => 'firstName', 
				'label' => 'First name', 
				'rules' => 'trim|required|xss_clean'
			),
			'lastName' => array(
				'field' => 'lastName', 
				'label' => 'Last name', 
				'rules' => 'trim|required|xss_clean'
			),
			'userType' => array(
				'field' => 'userType', 
				'label' => 'User type', 
				'rules' => 'trim|xss_clean'
			),
		);
		
		public function __construct() {
			parent::__construct();
		}

		public function get_new() {
			$user = new stdClass();
			$user->firstName = '';
			$user->lastName = '';
			$user->userEmail = '';
			$user->username = '';
			$user->password = '';
			$user->userType = '';
			return $user;
		}		

		public function login() {
			
			// if the input is received from a post
			if ($this->input->post()) {
				
				// get all users where the username and hashed password match	
				$user = $this->get_by(array(
					'user_username' => $this->input->post('username'),
					'user_password' => $this->hash($this->input->post('password'))
				), TRUE);
	
				// if we got exactly 1 row from the database
				if (count($user) === 1) {
					
					// if the user is allowed back here
					if ($user->user_type == 'admin' OR $user->user_type == 'super-admin') {
						
						// update the logged in status to 1
						$update = array('logged_in'=>'1');
						
						// save the update
						$this->save($update, $user->user_id);
						
						// set the session data array
						$data = array(
							'id' => $user->user_id,
							'user_username' => $user->user_username,
							'user_first' => $user->user_first,
							'user_last' => $user->user_last,
							'user_email' => $user->user_email,
							'logged_in' => TRUE,
							'user_type' => $user->user_type
						);
					
						// set the session
						$this->session->set_userdata($data);
						
						/* 
						 * Logout all logged in users who aren't active
						*/
						
						// select all logged in users
						$this->db->select('user_username');
						$this->db->where('logged_in', '1');
						$logged_in = $this->db->get('users');
					
						// if the number of rows is greater than 0
						if ($logged_in->num_rows() > 0) {
						
							// get all the current logged in sessions
							$sess = $this->db->select('user_data')->where('user_data !=',  '')->get('wo_sessions');
						
							// if we have more than 0 logged in sessions
							if ($sess->num_rows() > 0) {
							
								$data = array();
								
								// result = all the userdata
								$result = $sess->result();
								
								// foreach row unsearlize the session data and set it as a value for the array
								foreach ($result as $row) {
					
									$data[] = unserialize($row->user_data);	
					
								}
							
									// foreach row check whether it has a current session
								foreach ($logged_in->result() as $row) {
							
									// set the check to false
									$check = FALSE;
									
									// foreach logged in user check if the current row is logged in
									foreach ($data as $in) {
										
										if ($row->username == $in['user_username']) {
											
											// set the check to true
											$check = TRUE;
											
										}
									
									}
									
									// if the check  == false still 
									if ($check === FALSE) {
										
										// update the row to not be logged in anymore
										$this->db->where('user_username', $row->username);
								
										$this->db->update('users', array('logged_in' => '0'));	
							
									}
							
								} // foreach $loggedin->result
	
							} // if sess->num_rows
							
						} // if logged_in num rows
				
					} // if usertype
					
				} // if count number of users with username & pass
			
			} // if is post

		}
		
		public function logout() {
			
			$update = array('logged_in'=>'0');
		
			$this->save($update, $this->session->userdata('id'));
		
			$this->session->sess_destroy();
			
		}
		
		public function loggedin() {
			
			if ($this->session->userdata('logged_in') === TRUE) {
				
				$user = $this->get_by(array('user_username' => $this->session->userdata('user_username')), TRUE);
				
				if ($user->logged_in === '1') {
				
					return (bool) $this->session->userdata('logged_in');
				
				}
				
				else {
				
					return FALSE;	
			
				}
			}
			
			else {
			
				return FALSE;	
			
			}
		}
		
		public function is_locked() {
			
			// get the array with the attempts and last time trying to login
			$confirm = $this->confirm_ip(FALSE);
			
			// subtract the time from the last login attempt
			$time_sub = (time() - $confirm['last']); 
			
			// if the attempts reach 5 inside of 15 minutues
			// return TRUE
			// which equals the account is locked for 15
			if ($confirm['attempts'] >= 5 AND $time_sub < 900) {
				return TRUE;	
			}
			else {
				return FALSE;	
			}
				
		}

		public function confirm_ip($precheck = FALSE) {
			
			// The number attempts = 1 if they person hasn't logged in before
			$attempts = 1;
			
			// if we didn't already check or add an attempt (precheck)
			if ($precheck == FALSE) {
				
				$this->db->where('ip_address', $this->input->ip_address());
				$sql = $this->db->get('login_attempts');
				if ($sql->num_rows() > 0) {
					$attempts = array(
						'attempts' => $sql->row()->attempts,
						'last' => $sql->row()->last_login,
					);
				}
				return $attempts;
			}
			else {
				// add a row to the db with the users ip
				$data = array(
					'ip_address' => $this->input->ip_address(),
					'attempts' => 1,
					'last_login' => time(),
				);
				
				// insert the data
				$this->db->insert('login_attempts', $data);
				
			}
			
			// return the attempts (1)
			return $attempts;	
			
		}
		
		public function add_attempt() {
			
			// get the number of attempts
			$sql = $this->db->where('ip_address', $this->input->ip_address())->get('login_attempts');
			
			// if we have rows for that ip
			if ($sql->num_rows() > 0) {
				
				$row = (int) $sql->row()->attempts;
				
				// if the last time attempted is greater than 900 (15 minutues)
				// set the number of attempts to 1
				// else add 1 attempt to it
				if ((time() - $sql->row()->last_login) > 900) {
					$row = 1;
					
				}
				else {
					$row = ($row + 1);
				}
								
				// update the row where the ip's match
				$this->db->where('ip_address', $this->input->ip_address());
				$this->db->set(array('attempts' => $row));
				$this->db->set(array('last_login' => time()));
				$this->db->update('login_attempts');
			}
			else {
				// else confirm the ip and add it to the DB because there is no row for that IP
				$this->confirm_ip(TRUE);	
			}
			
		}
		
		public function hash($string) {
			return hash('sha512', $string . config_item('encryption_key'));
		}
		
		public function is_super_admin($id) {
			
			$user = $this->get_by(array('user_id' => $id), TRUE);
			
			if ($user->userType === 'super-admin') {
			
				return TRUE;	
			
			}
			
			else {
			
				return FALSE;
			
			}
		}
	}