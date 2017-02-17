<?php
	
class Settings extends CI_Controller {
	
	function Index(){
		
		$data['users'] = $this->user->get('WHERE `type` = "mytutor"');
		$data['user_types'] = $this->user->user_types();
		
		
		$this->load->view('settings/index', $data);
	}
	
	function Users($flag){
		$this->session->set_flashdata('user_flag',$flag);
		$this->session->set_flashdata('settings_tab','users');
		redirect('settings');
	}
	
	function Permissions($flag){
		$this->session->set_flashdata('permission_flag',$flag);
		$this->session->set_flashdata('settings_tab','permissions');
		redirect('settings');

	}
	
	
	function Ajax($request){
		switch ($request){
			
			
			case "add":
			
				$group 	= $this->input->post('group');
				$value 	= $this->input->post('value');
				
				
				
				
				if ($group == 'stages'){
					list($name, $color) = explode('|',$value);
					$data['stage']	= trim($name);
					$data['color'] 	= trim($color);
				} else {
					$data 	= array(
						'value'	=> trim($value)
					);

				}
				
				
				$this->db->insert($group, $data);
				
			
			break;
			case "edit":
			
				$group 	= $this->input->post('group');
				$value 	= $this->input->post('value');
				$id		= $this->input->post('id');
				
				if ($group == 'stages'){
					list($order, $name, $color) = explode(',',$value);
					$data['stage']	= trim($name);
					$data['color'] 	= trim($color);
					$data['order'] 	= trim($order);
				} else {
					$data 	= array(
						'value'	=> trim($value)
					);

				}
				
				
				
				$this->db->update($group, $data, array(
					'id'	=> $id
				));
			
			
			break;
			case "delete":
			
				$group 	= $this->input->post('group');
				$id		= $this->input->post('id');
				
				$this->db->query("DELETE FROM `$group` WHERE `id` = ?", array($id));
			
			break;
		}
	}
	
	
	function Add_type($flag){
		
		$data['flag']=  $flag;
		
		
		if ($this->input->post('post')){
			$name = $this->input->post('name');
			if (strlen(trim($name)) < 3){
				$error['name'] = 'Name must be at least 3 characters long';
			}
			
			$other_type = $this->user->user_type_by_name($name);
			if ($other_type->id){
				$error['name'] = 'Type name already exists';
			}
			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->add_type($this->input->post());
				redirect('settings/add_type/success');
			}
		
		} 
		
		$this->load->view('settings/add_type', $data);
				
	}
	
	function Edit_type($id, $flag){
		
		$data['flag']=  $flag;
		$data['user_type'] = $this->user->user_type($id);		
		
		if ($this->input->post('post')){
			$name = $this->input->post('name');
			if (strlen(trim($name)) < 3){
				$error['name'] = 'Name must be at least 3 characters long';
			}
			
			$other_type = $this->user->user_type_by_name($name);
			if ($other_type->id){
				if ($other_type->id != $id){
					$error['name'] = 'Type name already used';
				}
			}

			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->edit_type($id, $this->input->post());
				redirect('settings/edit_type/'.$id.'/success');
			}
		
		} 
		
		$this->load->view('settings/edit_type', $data);
				
	}
	
	function Has_permission_on($action){
		$user = $this->data();
		$user_type = $this->user_type_by_name($user->type);

		if ($user->super){
			return true;
		}
		
		$perm = json_decode($user_type->permission,true);
		
		if ($perm[$action]) return true;
		
		return false;

	}
	
	function Delete_type($id,$flag){
		$data['flag'] = $flag;
	
		
		$data['user_types'] = $this->user->user_types();
		$data['type']		= $type = $this->user->user_type($id);
		
		
		if ($this->input->post('post')){
			$new_user_type = $this->input->post('new_user_type');
			if (!$new_user_type){
				$error['new_user_type'] = 'Select a new user type to be replace with';
			}
			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->delete_type($type->name, $new_user_type);
				redirect('settings/permissions/deleted');
			}


		}
		
		$this->load->view('settings/delete_type', $data);
	}
	
	
	function Add($flag){
		
		$data['flag']=  $flag;
		
		
		if ($this->input->post('post')){
		
			$email = $this->input->post('email');
			if (!trim($email)){
				$error['email'] = 'Email not specified';
			} else {
			
				if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
					$error['email'] = 'Invalid email address';
				}
			}
			
			$user = $this->user->email($email);
			if ($user->id){
				$error['email'] = 'Email already exists';
			}
			
			$name = $this->input->post('name');
			if (strlen(trim($name)) < 3){
				$error['name'] = 'Name must be at least 3 characters long';
			}
			
			$user_types = $this->user->user_types();
			$type = $this->input->post('type');
			if (!$user_types[$type]){
				$error['type'] = 'Invalid user type';
			}
			
			$password = $this->input->post('password');
			if (strlen(trim($password)) < 8){
				$error['password'] = 'Password must be at least 8 characters long';
			}
			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->add_user($this->input->post());
				
				redirect('settings/add/success');
			}
		
		} 
		
		$this->load->view('settings/add', $data);
				
	}
	
	function Edit($id, $flag){
		
		$data['flag'] = $flag;
		$data['user'] = $this->user->id($id);
		
		
		if ($this->input->post('post')){
					
			$name = $this->input->post('name');
			if (strlen(trim($name)) < 3){
				$error['name'] = 'Name must be at least 3 characters long';
			}
			
			$user_types = $this->user->user_types();
			$type = $this->input->post('type');
			if (!$user_types[$type]){
				$error['type'] = 'Invalid user type';
			}
			
			$password = $this->input->post('password');
			if (trim($password)){
				if (strlen(trim($password)) < 8){
					$error['password'] = 'Password must be at least 8 characters long';
				}
			}
			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->edit_user($id, $this->input->post());
				
				redirect('settings/edit/'.$id.'/success');
			}
		
		} 
		
		
		$this->load->view('settings/edit', $data);
	}
	
	function Delete($id){
		$data['flag'] = $flag;
		$data['user'] = $this->user->id($id);
		
		if ($this->input->post('post')){
			
			if (count($error)){
				$data['error'] = $error;
			} else {
				$this->user->delete_user($id);
				redirect('settings/users/deleted');
			}


		}
		
		$this->load->view('settings/delete', $data);

	}
	
}