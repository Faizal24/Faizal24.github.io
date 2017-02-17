<?php

class Main extends CI_Controller {

	public function Index(){
		$this->load->view('main');
	}
	
	public function Dashboard(){
		$this->load->view('dashboard');
	}
	

}
