 <?php
	
class Login extends CI_Controller {
	
	function Auth(){
		
	
		if ($this->user->auth_user($this->input->post('email'), $this->input->post('password'))){
			
			if ($this->user->data('type') == 'tutor'){
				redirect('tutor/dashboard');
			} else {
				redirect();				
			}

		} else {
			redirect('login/error/1');
		}
	}
	
	function Index(){
		
		$this->d['login_page'] = true;
		
		$this->load->view('common/header', $this->d);
		$this->load->view('common/login', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function Error($error){
		
		$this->d['error'] = $error;
		$this->d['login_page'] = true;
		
		$this->load->view('common/header', $this->d);
		$this->load->view('common/login', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	function Verified(){
		$this->load->view('common/header', $this->d);
		$this->load->view('common/verified', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
}