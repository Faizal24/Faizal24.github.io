<?php
	
class Help extends CI_Controller {
	
	
	function Index(){
		$this->load->view('common/header', $this->d);
		$this->load->view('help/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
}