<?php
	
class Password_reset extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function Forgot_password(){
		
		if ($this->input->post('submit')){
			$email = $this->input->post('email');
			
			$user = $this->user->email($email);
			if ($user->id){
				$this->user->request_password_reset($email);
				$data['successful'] = 1;
			} else {
				$data['error'] = 'Email address not found.';
			}
		}
		
		$this->load->view('common/header');
		$this->load->view('common/password-recovery', $data);
		$this->load->view('common/footer');
	}
	
	function Index(){
				
		parse_str($_SERVER['QUERY_STRING']);
		
		
		if ($u && $k){
		
			list($idtimehash, $id) = explode('#', $u);
			
			if ($k > time() - (60 * 60)){
				if (sha1(sha1($id).sha1($k) == $idtimehash)){
					$this->session->set_userdata(array('uid'=>$id));
					redirect('password_reset/reset');
				}
			} else {
				redirect();
			}
		
		}
		
		redirect();
	
	}
	
	function Successful(){
		$user_id = $this->session->userdata('uid');
		
		if (!$user_id) redirect();
		
		$this->session->set_userdata(array('uid'=>''));
		
		$this->load->view('common/header');
		$this->load->view('common/password-reset-successful');
		$this->load->view('common/footer');
	}
	
	function Reset(){
		$user = $this->user->id($this->session->userdata('uid'));
		
		if (!$user->id) redirect();
			
		if ($this->input->post('submit')){
			
			$password = $this->input->post('password');
			$rpassword = $this->input->post('rpassword');
			
			if (strlen(trim($password)) < 6){
				$error = 1;
			} else {
				if (trim($password) !== trim($rpassword)){
					$error = 2;
				} else {
					$this->user->reset_password($user->id, $password);
					$error = false;
				}
			} 
			
			if (!$error){
				redirect('password_reset/successful');
			} else {
				$data['error'] = $error;
			$this->load->view('common/header');
			$this->load->view('common/password-reset', $data);
			$this->load->view('common/footer');

			}
		} else {
			$this->load->view('common/header');
			$this->load->view('common/password-reset');
			$this->load->view('common/footer');
		}
	}
	
	
	
	
}