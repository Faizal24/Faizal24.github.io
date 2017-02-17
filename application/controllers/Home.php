<?php

class Home extends CI_Controller {
	

	public function Index(){
		
		if ($this->user->data('type') == 'tutor') redirect('tutor/dashboard');
		
		$this->d['grades']		= $this->system->get_grades();
		$this->d['subjects']	= $this->system->get_subjects();
		
		$this->load->view('common/header', $this->d);
		$this->load->view('home/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
}
