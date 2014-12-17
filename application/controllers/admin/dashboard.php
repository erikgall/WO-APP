<?php
	
	class Dashboard extends Admin_Controller {
		
		public function __construct() {
			
			parent::__construct();
			
			$this->load->model('dashboard_m');
		
			$this->data['msg_unread_count'] = $this->dashboard_m->unread_messages();
			
			//$this->data['alerts'] = $this->dashboard_m->alerts();

		}
		
		public function index() {
									
			$this->data['subview'] = 'admin/page/index';
			
			$this->load->view('admin/_layout_main', $this->data);
		}
		
		public function page($page, $where = NULL, $id = NULL) {
			
			if (array_key_exists($page, config_item('db')) OR array_key_exists($page.'s', config_item('db'))) {
					
				$model = $page . "_m";
					
				$this->load->model($model, 'data_m');
				
				if (($where AND $id) AND $where != 'edit') {
					
					$this->data['rows'] = $this->data_m->get_by(array($where => $id));
			
				}
				
				else {
					
					$this->data['rows'] = $this->data_m->get();
				}
				
				
				if (($where AND $where == 'edit')) {
					
					$this->data['subview_change'] = 'edit';
					
				}
								
				$this->data['subview'] = "admin/$page/index";
				
				$this->load->view('admin/_layout_main', $this->data);
		
			}
		}
				
		public function ajax_get($page, $function = NULL, $params = NULL) {
		
			if ($this->input->is_ajax_request() == TRUE) {
			
				if (array_key_exists($page, config_item('db')) OR array_key_exists($page.'s', config_item('db'))) {
					
					$model = $page . "_m";
					
					$this->load->model($model, 'data_m');
					
					if ($function != NULL) {
						if ($params != NULL) {
							if ($params == 'html'){
								echo $this->data_m->{$function}();
							}
							else {

							 	echo json_encode($this->data_m->{$function}($params));
							}
						}
						else {
							 echo json_encode($this->data_m->{$function}());
						}
					}
					else {
												
						$this->data['rows'] = $this->data_m->get();	
										
						echo $this->load->view("admin/$page/index", $this->data);
					}
				}
				
			}
			
		}
		
		public function ajax_edit($page, $id = NULL) {
		
			if ($this->input->is_ajax_request() == TRUE) {
				
				// success variable = FALSE
				
				$this->data['success'] = FALSE;

				if (array_key_exists($page, config_item('db')) OR array_key_exists($page.'s', config_item('db'))) {
					
					$model = $page . "_m";
					
					$this->load->model($model, 'data_m');
									
					if ($id) {
						
						$this->data['row'] = $this->data_m->get($id);
						
							
					}
					else {
						$this->data['row'] = $this->data_m->get_new();
					} 
					
					// Set up the form			
					$rules = config_item('db');
					
					$rules = $rules[$page.'s']['rules'];
					
					if ($this->input->post('password') != '' OR $id == NULL) {
						
						if (isset($rules[$page."_password"])) {
						
							$rules[$page."_password"]['rules'] = '|required';
							
						}

						if ($id AND isset($rules[$page.'s']['rules'][$page."_password"]) AND $this->input->post('user_password') != FALSE AND $this->input->post('user_password') != '') {
						
							$rules["user_password"]['rules'] = '|required';
					
						}
					
					}
					
					$this->form_validation->set_rules($rules);
					
					
					// Process the form
					if ($this->form_validation->run() === TRUE) {
						
						$fields = config_item('db');
						
						$fields = $fields[$page.'s']['fields'];
						
						$data = $this->data_m->array_from_post($fields);
						
						// check if there is a password field
						
						if (isset($_POST[$page . "_password"]) AND $_POST[$page . "_password"] != '') {
						
							$data[$page . "_password"] = $this->user_m->hash($this->input->post([$page . "_password"]));
						
						}
						elseif (isset($_POST["user_password"]) AND $_POST["user_password"] != '') {
						
							$data["user_password"] = $this->user_m->hash($_POST["user_password"]);
						
						}

						$id = $this->data_m->save($data, $id);
						
						$this->session->set_flashdata('save', 'success');

						
						$this->data['success'] = TRUE;
						
						if ($this->input->post('redirect')) {
							
							$this->data['row'] = $this->data_m->get($id);							
							
							$this->load->view($this->input->post('redirect'), $this->data);
							
						}
						else {
						
							$this->data['row'] = $this->data_m->get($id);
							
							$this->load->view("admin/$page/edit", $this->data);
						
						}
					
					}
					
					else {
												
						$this->load->view("admin/$page/edit", $this->data);
						
					
					}
				}
				
			}
			
		}
		
		public function ajax_save ($page, $id = NULL) {
			
			$editable = FALSE;
			
			if ($this->input->is_ajax_request() == TRUE) {

				if (array_key_exists($page, config_item('db')) OR array_key_exists($page.'s', config_item('db'))) {
					
					// Set the model name
					$model = $page . "_m";
					
					// load the model and set the name as data_m
					$this->load->model($model, 'data_m');
					
					// Set up the form			
					$rules = config_item('db');
					
					
					/* editable item update check */
					if ($this->input->post('pk') AND $this->input->post('name')) {
						
						$editable = TRUE;
						if (!array_key_exists($page, $rules)) {
							$page = $page .'s';	
						}
						
						// if we submit an item called pk were using editable
						if (isset ($rules[$page]['rules'][$this->input->post('name')])) {
						
							$rule_array = array(
								'value' => array(
									'field' => 'value',
									'label' => $single_rule['label'],
									'rules' => $single_rule['rules']
								)
							);
							$this->form_validation->set_rules($rule_array);
							
						}
						else {
							$rule_array = array(
								'value' => array(
									'field' => 'value',
									'label' => 'The field submitted',
									'rules' => ''
								)
							);
							$this->form_validation->set_rules($rule_array);
						}
					
					}
					else {
						
						if (array_key_exists($page, $rules)) {
							
							$this->form_validation->set_rules($rules[$page]['rules']);

						}
						else {
							$this->form_validation->set_rules($rules[$page.'s']['rules']);

						}
					}

					if ($this->form_validation->run() === TRUE) {
						
						if ($editable === TRUE) {
							
							$data = array();
							
							$data[$this->input->post('name')] = $this->input->post('value');
							
							$id = $this->input->post('pk');
							
						}
						else {
							if (array_key_exists($page, $rules)) {
							
								$data = $this->data_m->array_from_post($rules[$page]['fields']);
							
							}
							else {

								$data = $this->data_m->array_from_post($rules[$page.'s']['fields']);
							
							}

						}
						
							$save = $this->data_m->save($data, $id);
						
							$this->data['success'] = TRUE;
						
						if ($this->input->post('redirect') AND $save != FALSE) {

							$new_model = explode('/', $this->input->post('redirect'));

							$model2 = $new_model[1] . "_m";
							
							$this->load->model($model2, 'model_m');
							
							$this->data['rows'] = $this->model_m->get();
										
							echo $this->load->view($this->input->post('redirect'), $this->data);
 
						}
						elseif (($this->input->post('response') AND $this->input->post('response') == 'json' AND $save != FALSE) OR ($editable == TRUE AND $save != FALSE))  {
							$response = array(
								'id' => $save,
								'msg' => array('Success! The data was saved successfully.'),
								'post' => $data
							);
							
							echo json_encode($response);	
						}
						
					}
					
					else {
						
						echo validation_errors();	
					
					}
					
				
				}
				else {
					echo 'Error! No a valid table';	
				}

			}
			else {
				echo 'Error! Not an Ajax Request';
			}	
		
		}
		
		public function ajax_delete($page, $id, $load_view = NULL) {
			
			if ($this->input->is_ajax_request() == TRUE) {
							
				if (array_key_exists($page, config_item('db')) OR array_key_exists($page.'s', config_item('db'))) {
					
						$model = $page . "_m";
	
					
					$this->load->model($model, 'data_m');
					
					$this->data_m->delete($id);
					
					$this->data['status_msg'] = "Delete was successful";

					$this->data['rows'] = $this->data_m->get();
					$no_response = config_item('delete_response');
					
					if ($load_view == NULL AND !in_array($page, $no_response)) {
						
						echo $this->load->view("admin/$page/index", $this->data);
				
					}
					else {
						
						echo 'Delete was successful';	
								
					}
				}
			
			}
			
			else {
				$this->data['status_msg'] = "There was an error with the request. Please try again.";	
			}
		}

	}
	
/* End of file MY_Model.php */
/* Location: ./application/controllers/admin/dashboard.php */