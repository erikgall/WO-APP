<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * WO APP Main Model
 *
 * The main model that extends the CI model and is the main accessor of the database.
 *
 * @package        	WO
 * @subpackage    	Core
 * @category    	Admin
 * @author        	Erik Galloway
 * @version         1.0.0
 */


	class MY_Model extends CI_Model {
		
		/**
		 * The table name that is passed through each model that extends My_Model
		 *
		 * @var String
		 */
		protected $_table_name = '';

		/**
		 * The primary key column of the table
		 *
		 * @var String
		 */
		protected $_primary_key = ''; // depending on table
		
		/**
		 * The primary filter of our pk
		 *
		 * @var String
		 */
		protected $_primary_filter = 'intval';
		
		/**
		 * The primary ordering of all SQL queries
		 *
		 * @var String
		 */
		protected $_order_by = '';
		
		public $rules = array();
		protected $_timestamps = FALSE;
		
		/**
     	* Constructor
     	*
		* Extend the CI Model Library
     	*
     	*/
		function __construct() {
			
			parent::__construct();	
		
		}
		
		/**
     	* Count all rows
     	*
		* Returns the number of rows in a table
     	*
		* @return $this
     	*/
		public function record_count() {
        
			return $this->db->count_all($this->_table_name);
    	
		}
			
		/**
	 	* Get Limit (pagination)
	 	*
	 	* @access	public
	 	* @param	int	the number of rows
	 	* @param 	int	the starting point
	 	* @return	array
	 	*/
		public function get_limit($limit, $start) {
        
			$this->db->limit($limit, $start);
        
			$query = $this->db->get($this->_table_name);
 
       	 	if ($query->num_rows() > 0) {
 
            	foreach ($query->result() as $row) {
 
                	$data[] = $row;
 
            	}
 
            	return $data;
 
        	}
 
        	return false;
   		}
		
		/**
	 	* Get Array From Post
	 	*
	 	* @access	public
	 	* @param	array	$fields The field names
	 	* @return	array
	 	*/
		public function array_from_post($fields, $secondField = NULL, $secondData = NULL) {
			
			$data = array();
			
			foreach ($fields as $field) {
			
				$data[$field] = $this->input->post($field);
			
			}
			
			if ($secondField == NULL) {
			
				return $data;
			
			}
			
			else {
			
				$data[$secondField] = $secondData;
			
				return $data;	
			
			}
		}
		
		/**
	 	* Get a database table
	 	*
	 	* @access	public
	 	* @param	int		$id Row ID
		* @param	bool	$single Return row() or result() 
	 	* @return	array
	 	*/
		public function get($id = NULL, $single = FALSE) {
			
			if ( $id != NULL ) {
			
				$filter = $this->_primary_filter;
			
				$id = $filter($id);
			
				$this->db->where($this->_primary_key, $id);
			
				$method = 'row';
			
			}
			
			elseif ($single == TRUE) {
			
				$method = 'row';	
			
			}
			
			else {
			
				$method = 'result';
			
			}
			
			if ( !count($this->db->ar_orderby)) {
			
				$this->db->order_by($this->_order_by);	
			
			}
			
			return $this->db->get($this->_table_name)->$method();
		}
		
		/**
	 	* Get Table Where
	 	*
	 	* @access	public
	 	* @param	array	$where The where array (ex. $where = array('field' => 'id'))
		* @param	bool	$single Return row() or result()
	 	* @return	array
	 	*/
		public function get_by($where, $single = FALSE) {
			
			$this->db->where($where);
			
			return $this->get(NULL, $single);
		}
		
		
		public function save($data, $id= NULL) {
			
			// Set timestamps
			if ($this->_timestamps == TRUE) {
			
				$now = date("Y-m-d H:i:s");
			
				$id || $data['created'] = $now;
			
				$data['modified'] = $now;
			}
			
			// Insert
			if ($id === NULL) {
			
				!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			
				$this->db->set($data);
			
				$this->db->insert($this->_table_name);
			
				$id = $this->db->insert_id();
			
			}
			
			else {
			
				$filter = $this->_primary_filter;
			
				$id = $filter($id);
			
				$this->db->set($data);
			
				$this->db->where($this->_primary_key, $id);
			
				$this->db->update($this->_table_name);
			}
			
			return $id;
		}
		public function delete($id) {
			
			$filter = $this->_primary_filter;
			
			$id = $filter($id);
			
			if (!$id) {
			
				return FALSE;	
			
			}
			
			else {
			
				$this->db->where($this->_primary_key, $id);
			
				$this->db->limit(1);
			
				$this->db->delete($this->_table_name);	
			
			}
		}
		
		public function get_from($table, $id = NULL, $pk = NULL, $single = FALSE, $order_by = NULL) {
			
			if ( $id != NULL ) {
			
				$filter = $this->_primary_filter;
			
				$id = $filter($id);
			
				$this->db->where($this->_primary_key, $id);
			
				$method = 'row';
			
			}
			
			elseif ($single == TRUE) {
			
				$method = 'row';	
			
			}
			
			else {
			
				$method = 'result';
			
			}
			
			if ($order_by) {
			
				$this->db->order_by($order_by);	
			
			}
			
			return $this->db->get($table)->$method();
		}		

		public function get_client($id, $project_id = FALSE) {
			
			if ($project_id == TRUE) {
				
				$this->db->select('client_id');
				$this->db->where('project_id', $id);
				$sql = $this->db->get('projects');
				
				if ($sql->num_rows() > 0) {
					
					$client_id = $sql->row()->client_id;
					
					$this->db->select('client_id, client_first, client_last, client_street, client_city, client_state, client_state, client_zip, client_phone, client_email');
					$this->db->where('client_id', $client_id);
					
					$client = $this->db->get('clients');
				
					if ($client->num_rows() > 0) {
						
						return $client->row();
					
					}
					else {
					
						return NULL;
							
					}

				}
					
			}
			else {

				$this->db->where('client_id', $client_id);
				$sql = $this->db->get('clients');
				
				if ($sql->num_rows() > 0) {
				
					return $sql->row();	
				
				}
			
			}
			
			return NULL;
			
			
		}
		
		public function navbar_messages() {
			// 1 = message from user to user									== display in inbox
			// 2 = message from user to client									== display in outbox
			// 3 = message from client to user									== display in inbox
			// 4 = message from client to user was deleted in outbox of client  == display in inbox
			// 5 = message sent by user to user was deleted in outbox			== dont display in inbox			
			// 6 = message sent by user to client was deleted in users outbox 	== dont display	
			
			$data = $this->session->all_userdata();
			
			$not_in = array(2, 5, 6);
			
			$this->db->where('message_to', $data['id']);
			
			$this->db->where_not_in('message_to_user', $not_in);
			
			$this->db->order_by("message_timestamp", "ASC"); 
			
			$sql = $this->db->get('messages', 3);
			
			$data = array();
			$users = array();
			$clients = array();
			foreach ($sql->result() as $row) {
				
				if (!in_array($row->message_from, $users) AND $row->message_to_user == '1') {
			
					$users[] = $row->message_from;	
					
					
				}
				elseif (!in_array($row->message_from, $clients) AND $row->message_to_user == '3') {
				
					$clients[] = $row->message_from;
				
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
				
				$search = '';
				
				if ($row->message_to_user == '1') {
				
					$search = $user;
					
				}
				elseif ($row->message_to_user == '3' OR $row->message_to_user == '4') {
					$search = $client;
				}
				
				foreach ($search->result() as $msg_to) {
					
					if ($row->message_to_user == '1') {

						$row->message_from = $msg_to->user_first . ' ' . $msg_to->user_last;
						$row->user_type = $msg_to->user_type; 
									
					}
					elseif ($row->message_to_user == '3') {
						
						$row->message_from = $msg_to->client_first . ' ' . $msg_to->client_last;
						$row->user_type = 'Client';
					}
				}
	
				$data['messages'][] = array(
					'message_id' => $row->message_id,
					'message_title' => $row->message_title,
					'message_from' => $row->message_from,
					'message_status' => $row->message_status,
					'message_timestamp' => $row->message_timestamp,
					'message_from_client' => $row->message_to_user,
					'user_type' => humanize($row->user_type)
				);
			}
			
			
			
			return json_encode($data);
		}
		
		public function navbar_open_projects() {
			
			$this->db->where('project_status !=', 1);
			
			$sql = $this->db->get('projects', 4);
			
			if ($sql->num_rows() > 0) {
				
				$projects = $sql->result();
				
				$p_ids = array();
				
				$data = array();

				foreach ($projects as $project) {
					
					
					$project->job_count = 0; 
					$project->complete = 0;
					
					if (!in_array($project->project_id, $p_ids)) {
	
						$p_ids[] = $project->project_id;
					
					}
					$data[] = $project;
				}
													
				$this->db->where_in('project_id', $p_ids);
					
				$jobs = $this->db->get('jobs');
				
				foreach ($jobs->result() as $job) {

					foreach ($data as $row) {									

						if ($row->project_id == $job->project_id) {
					
							$row->job_count += 1;			
						
							if ($job->job_status == 1) {
						
								$row->complete += 1;
						
							}
							
							$array[$row->project_id] = $row;
						}
												
					}
					
				}
				$return = array();
				foreach ($data as $final) {
					$return[] = $final;
				}

				return json_encode($return);

			}
		}
	}
/* End of file MY_Model.php */
/* Location: ./application/core/My_Model.php */