<?php

class Profile extends CI_Controller {
	
	function Edit($flag){
		$id = $this->user->data('id');
		
		$data['flag'] = $flag;
		$data['user'] = $this->user->id($id);
		
		
		if ($this->input->post('post')){
					
			$name = $this->input->post('firstname');
			if (strlen(trim($name)) < 3){
				$error['name'] = 'Name must be at least 3 characters long';
			}
			
			if (!$this->input->post('edit_profile')){
				$user_types = $this->user->user_types();
				$type = $this->input->post('type');
				if (!$user_types[$type]){
					$error['type'] = 'Invalid user type';
				}
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
				
				redirect('profile/edit/success');
			}
		
		} 
		
		
		$this->load->view('profile', $data);
	}
	
	function Upload_photo(){
		$config['upload_path'] = '../uploads/profile';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$data->filename = $filedata['file_name'];
			
			return $this->form->submit_successful($data);
		} else {
			return $this->form->submit_unsuccessful('Error uploading image.');
		}		
	}
	
}