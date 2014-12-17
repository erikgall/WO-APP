<?php
	class Dashboard_m extends MY_Model {
		protected $_table_name = 'assignments';
		protected $_primary_key = 'assignment_id'; 
		protected $_order_by = 'job_id';
		
		public function unread_messages() {
			
			$not_in = array(2, 5);
			
			$data = $this->session->all_userdata();
			
			$this->db->where('message_to', $data['id']);
			
			$this->db->where('message_status', 4);
			
			$this->db->where_not_in('message_to_user', $not_in);
			
			$this->db->from('messages');
			
			return $this->db->count_all_results();
		
		}
		
	}