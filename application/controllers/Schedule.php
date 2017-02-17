<?php
	
class Schedule extends CI_Controller {
	
	
	function Index(){
		$this->load->view('common/header', $this->d);
		$this->load->view('schedule/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
}