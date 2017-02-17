<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function Index(){
		$this->load->view('login');
	}
	
	function Error(){
		$data['flag'] = 'error';
		$this->load->view('login', $data);
	}
	
	function Auth(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if ($this->user->auth_user($email, $password)){
			redirect();
		} else {
			redirect('login/error');
		}
		
	}
	
}