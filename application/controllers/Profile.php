<?php

class Profile extends CI_Controller {
	
	function Index(){
		
		$this->load->view('common/header', $this->d);
		if ($this->user->data('type') == 'tutor'){
			$this->d['tutor'] = $this->user->tutor($this->user->data('id'));
			$this->load->view('profile/tutor', $this->d);				
		} else {
			$this->load->view('profile/index', $this->d);	
		}
		$this->load->view('common/footer', $this->d);
	}
	
	function Update(){
		if ($this->user->data('type') == 'user'){		
			$this->db->update('users', array(
				'firstname'	=> $this->input->post('firstname'),
				'lastname'	=> $this->input->post('lastname'),
				'mobile'	=> $this->input->post('mobile')
			), array(
				'id'		=> $this->user->data('id')
			));
			
			$this->session->set_flashdata('profile_updated',1);
			redirect('profile');
		} else {
			
			$this->db->update('users', array(
				'mobile'	=> $this->input->post('mobile')
			), array(
				'id'		=> $this->user->data('id')
			));
			
			
			$this->db->update('tutor_profile', array(
				'address1'				=> $this->input->post('address1'),
				'address2'				=> $this->input->post('address2'),
				'city'					=> $this->input->post('city'),
				'zipcode'				=> $this->input->post('zipcode'),
				'country'				=> $this->input->post('country'),
				'occupation'			=> $this->input->post('occupation'),
				'bank_account_number'	=> $this->input->post('bank_account_no'),
				'bank_name'				=> $this->input->post('bank_name'),
				'locations'				=> implode(',', $this->input->post('locations'))
			), array(
				'user_email'			=> $this->user->data('email')
			));

			
			$this->session->set_flashdata('profile_updated',1);
			redirect('profile');
		}
	}
	
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
		$config['upload_path'] = 'uploads/profile';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$data->filename = $filedata['file_name'];
			
			$this->user->update_photo($data->filename);
			
			$data->filename = 'uploads/profile/' . $filedata['file_name'];
			
				
			echo '<script language="javascript" type="text/javascript">';
			echo 'window.top.window.formSubmitted(1,'.json_encode($data).')';
			echo '</script>';

		} else {
			
			echo '<script language="javascript" type="text/javascript">';
			echo 'window.top.window.formSubmitted(0,"'.$error.'")';
			echo '</script>';
		}		
	}
	
}