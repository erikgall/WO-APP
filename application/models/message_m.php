<?php
	class Message_m extends MY_Model {
		protected $_table_name = 'messages';
		protected $_primary_key = 'message_id'; 
		protected $_order_by = 'message_id DESC';

		public function __contsruct() {
			parent::__construct();	
		}
		
		public function get_new() {
			$row = new stdClass();
			$row->message_title = '';
			$row->message_timestamp = '';
			$row->message_to = '';
			$row->message_from = '';
			$row->message_text = '';
			$row->message_status = '';
			$row->message_to_user = '';
			return $row;
		}
		
		public function get($id = NULL, $sent = FALSE) {
			
			$data = $this->session->all_userdata();
			if ($this->input->post('outbox_msg') != FALSE) {
				$sent = TRUE;	
			}
			if ($sent == TRUE) {
				
				$where = 'message_from';
				$in = array(1, 2);	

			}
			else {

				$where = 'message_to';
				$not_in = array(2, 5);	
			}
			
			
			if ($id AND $id != NULL) {
				
				if ($sent == TRUE) {
					
					$this->db->where($where, $data['id']);
				
					$this->db->where('message_id', $id);

					$this->db->where_in('message_to_user', $in);

					$this->db->order_by('message_timestamp', 'DESC');

					$sql = $this->db->get($this->_table_name);
					if ($sql->num_rows() === 1) {
										
						return $sql->row();
					
					}
					else {
					
						return $this->get_new();	
					
					}
				}
				else {
					$this->db->where('message_id', $id);

					$this->db->where($where, $data['id']);
	
					$this->db->where_not_in('message_to_user', $not_in);
					
					$sql = $this->db->get('messages');

					if ($sql->num_rows() === 1) {
										
						return $sql->row();
					
					}
					else {
					
						return $this->get_new();
					
					}
				
				}
			}
			else {
				
				if ($sent == TRUE) {

					$this->db->where($where, $data['id']);
					$this->db->where_in('message_to_user', $in);
					$this->db->order_by('message_timestamp', 'DESC');
					$sql = $this->db->get($this->_table_name);
					$clients = array();
					$users = array();
					foreach ($sql->result() as $row) {
						$to_id = $row->message_to;
						
						if (!in_array($row->message_to, $users) AND $row->message_to_user == 1) {
							$users[] = $row->message_to;
						}
						elseif (!in_array($row->message_to, $clients) AND $row->message_to_user == 2) {
							$clients[] = $row->message_to;	
						}
						
							
					}
					if (count($users) > 0) {
                           
                     	$this->db->where_in('user_id', $users);
                    	$user = $this->db->get('users');
                            
                     }
                  	if (count($clients) > 0) {
                    	$this->db->where_in('client_id', $clients);
                       	$client = $this->db->get('clients');	
                   	}
					
					foreach ($sql->result() as $row) {
							
						 if ($row->message_to_user == 1) {
                            
							$type = $user;
                                    
						}
						elseif ($row->message_to_user == 2) {
                                    
							$type = $client;
                                    
						}
						
						foreach ($type->result() as $person) {
							
							if ($row->message_to_user == 1 AND $row->message_to == $person->user_id) {
                                        
								$message_from = $person->user_first . ' ' . $person->user_last;
                                        
                         		$user_type = humanize($person->user_type);
                                    
							}
             				elseif ($row->message_to_user == 2 AND $row->message_to == $person->client_id) {
                                        
                        		$message_from = $person->client_first . ' ' . $person->client_last;
                                        
                           		$user_type = 'Client';
                                            
                         	}
							
							 
							
								
						}
						
						$row->to_name = $message_from;
						$row->user_type = $user_type;
						
					}
					
					return $sql->result();
				}
				else {
					
					$this->db->where($where, $data['id']);
					$this->db->where_not_in('message_to_user', $not_in);
					$this->db->order_by('message_timestamp', 'DESC');
					$sql = $this->db->get($this->_table_name);
			
					return $sql->result();		
				}
			
			}
		
		}
		
		public function outbox() {
			$data = array();
			$data['rows'] =  $this->get(NULL, TRUE);
			return $this->load->view('admin/message/outbox', $data, TRUE);
		}
		
		
		public function save($data, $id) {
			
			$sess = $this->session->all_userdata();

			$from = $sess['id'];
			$time = date('m-d-y h:i a');
			
			$data['message_from'] = $from;
			$data['message_timestamp'] = $time;
			if (!isset($data['message_status'])) {
				$data['message_status'] = 1;
			}
						
			if ($id) {
				return TRUE;	
			}
			else {
				
				if ($this->input->post('reply') != FALSE) {
					$update = array('message_status' => 3);
					
					parent::save($update, $this->input->post('reply'));
					
				}
				$save = parent::save($data, $id);	
			}
			
			return $save;
		}
		
		public function delete($id) {
			
			$sess = $this->session->all_userdata();
			
			$row = parent::get($id, TRUE);
			
			$deleted = array(4, 5, 6);
			
			if (($row->message_to === $sess['id'] OR $row->message_from == $sess['id'])  AND !in_array($row->message_to_user, $deleted)) {
				
				if ($row->message_to_user == 1) {
					
					$data = array('message_to_user' => 5);
				
				}
				else if ($row->message_to_user == 2) {
				
					$data = array('message_to_user' => 6);
				
				}
				
				$data = array('message_to_user' => 5);
				
				return parent::save($data, $id);
				
			}
			else if ($row->message_to === $sess['id'] AND $row->message_to_user == 4) {
			
				parent::delete($id);
				return TRUE;
			}
			
				
		}
		
		public function get_reply_user($message_id) {
			
			$this->db->where('message_id', $message_id);
			
			$sql = $this->db->get('messages');
			
			if ($sql->num_rows() > 0) {
				
				$row = $sql->row();
					
				if ($row->message_to_user == 1) {
					$this->db->where('user_id', $row->message_from);
					$user = $this->db->get('users');
				}
				else {
					$this->db->where('client_id', $row->message_from);
					$user = $this->db->get('clients');	
				}
				
				$data = $user->row();
				
				
				$object = new stdClass();
            	foreach ($data as $key => $value){
                   
                    // Add the value to the object
                    $object->{$key} = $value;
            	}
				foreach ($row as $key => $value){
                   
                    // Add the value to the object
                    $object->{$key} = $value;
            	}
            
				
				if ($row->message_to_user == 1) {
					$object->first = $object->user_first;
					$object->last = $object->user_last;	
					$object->message_to_user = 1;
				}
				else {
					$object->first = $object->client_first;
					$object->last = $object->client_last;
					$object->message_to_user = 2;	
							
				}
				return $object;
				
			}
			
		}
		
		public function message_read($message_id) {
				
			$array = array('message_status' => 2);
			
			return parent::save($array, $message_id);	
				
		}
		
		public function typeahead($type) {

			$sess = $this->session->all_userdata();

			if ($type == 'users') {
				$this->db->where('user_id !=', $sess['id']);							
				$sql = $this->db->get('users');
			
			}
			elseif ($type == 'clients') {
																
				$sql = $this->db->get('clients');
			
			}
				$data = array();
				
				foreach ($sql->result() as $row) {
					
					if ($type == 'users') {
						
						$id = $row->user_id;
					
						$first = $row->user_first;
						
						$last  = $row->user_last;
					}
					elseif ($type == 'clients') {
						
						$id = $row->client_id;
					
						$first = $row->client_first;
						
						$last  = $row->client_last;
					}
					
					
					$data[] = array(
						'id' => $id,
						'name' => $first . ' ' . $last
					);
					
					
				}
				
				
					
			
			
			return $data;
		}
		
	}