<?php
	
class Signup extends CI_Controller {
	
	
	function Tutor(){
			
			
		$email = trim($this->input->post('email'));
			
		if (!trim($email)){
			$error['email'] = 'Email cannot be empty';
		} else {
			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				$error['email'] = 'Invalid email address';
			}
		}
			
		if ($this->user->email($email)->id){
			$error['email'] = 'Account already exists';
		}

			
		if (strlen(trim($this->input->post('firstname'))) < 3){
			$error['firstname'] = 'First name must be at least 3 characters long';
		}
		
		if (strlen(trim($this->input->post('lastname'))) < 3){
			$error['lastname'] = 'Last name must be at least 3 characters long';
		}
		
		if ($this->input->post('gender') != 'Male' && $this->input->post('gender') != 'Female'){
			$error['gender']	= 'Select gender'; 
		}
			
		if (strlen(trim($this->input->post('password'))) < 6){
			$error['password'] = 'Password must be at least 6 characters long';
		} else {
			if ($this->input->post('password') !== $this->input->post('rpassword')){
				$error['password'] = 'Password does not match';
			}
		}
		
		if (!$this->input->post('tnc')){
			$error['psuedotnc'] = 'You must agree before signing up';
		}
		
		if (count($error)){
			$res->status = 'error';
			$res->error = $error;
			
			echo json_encode($res);
		} else {
			$data = $this->input->post();
			$data['type'] = 'tutor';
			
			$id = $this->user->add_user($data);
			
			$res->status 	= 'ok';
			$res->i 		= $id;
			$res->h			= sha1($id.$id.sha1(trim($this->input->post('password'))).$id);
			
			$this->mailer->send($data['email'], 'Welcome to MaiTutor', 'register', array(
				'name'		=> $data['firstname'],
				'url'		=> base_url() . 'su/verify_email/' . $id . '/' . sha1($id.$id.$data['email'])
			));
			
			echo json_encode($res);
		}

	}
	
	function User(){
			
			
		$email = trim($this->input->post('email'));
			
		if (!trim($email)){
			$error['email'] = 'Email cannot be empty';
		} else {
			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				$error['email'] = 'Invalid email address';
			}
		}
			
		if ($this->user->email($email)->id){
			$error['email'] = 'Account already exists';
		}

			
		if (strlen(trim($this->input->post('firstname'))) < 3){
			$error['firstname'] = 'First name must be at least 3 characters long';
		}
		
		if (strlen(trim($this->input->post('lastname'))) < 3){
			$error['lastname'] = 'Last name must be at least 3 characters long';
		}
			
		if (strlen(trim($this->input->post('password'))) < 6){
			$error['password'] = 'Password must be at least 6 characters long';
		} else {
			if ($this->input->post('password') !== $this->input->post('rpassword')){
				$error['password'] = 'Password does not match';
			}
		}
		
		if (!$this->input->post('tnc')){
			$error['psuedotnc'] = 'You must agree before signing up';
		}
		
		if (count($error)){
			$res->status = 'error';
			$res->error = $error;
			
			echo json_encode($res);
		} else {
			$data = $this->input->post();
			$data['type'] = 'user';
			
			$id = $this->user->add_user($data);
			
			$res->status 	= 'ok';
			$res->i 		= $id;
			$res->h			= sha1($id.$id.sha1(trim($this->input->post('password'))).$id);
			
			$this->mailer->send($data['email'], 'Welcome to MaiTutor', 'register', array(
				'name'		=> $data['firstname'],
				'url'		=> base_url() . 'su/verify_email/' . $id . '/' . sha1($id.$id.$data['email'])
			));

			
			echo json_encode($res);
		}

	}
	
	function mobauth(){
		$id = $this->input->post('i');
		$hash = $this->input->post('h');
		$code = $this->input->post('code');
		
		$user = $this->user->id($id);
		
		if (sha1($user->id.$user->id.$user->password.$user->id) != sha1($id.$id.$user->password.$id)){
			$error['code'] = 'Invalid action';
		}
		
		if ($code != '1234'){
			$error['code'] = 'Invalid code';
		}
		
		if (count($error)){
			$res->status = 'error';
			$res->error = $error;
			$res->code 	= $code;
			
			
			echo json_encode($res);
		} else {
			
			$this->user->verify_mobile($id, $mobile);
			$this->user->Auth_user($user->email, null, true);
			
			$res->status 	= 'ok';
			
			echo json_encode($res);
		}
	}
	
	function mobreg(){
		$id = $this->input->post('i');
		$hash = $this->input->post('h');
		$mobile = $this->input->post('mobile');
		
		$user = $this->user->id($id);
		
		if (sha1($user->id.$user->id.$user->password.$user->id) != sha1($id.$id.$user->password.$id)){
			$error['mobile'] = 'Invalid action';
		}
		
		if (count($error)){
			$res->status = 'error';
			$res->error = $error;
			echo json_encode($res);
		} else {
			
			$this->user->update_mobile($id, $mobile);
			
			$res->status 	= 'ok';
			$res->i 		= $id;
			$res->h			= sha1($id.$id.$user->password.$id);
			
			echo json_encode($res);
		}
	}
	
}