<?php
	
class Payment extends CI_Controller {
	
	
	function Index(){
		$this->load->view('common/header', $this->d);
		$this->load->view('payment/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
}