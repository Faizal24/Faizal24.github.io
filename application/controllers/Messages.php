<?php 
	
class Messages extends CI_Controller {
	
	function Index(){
		
		$this->load->view('common/header', $this->d);
		$this->load->view('messages/index', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
}