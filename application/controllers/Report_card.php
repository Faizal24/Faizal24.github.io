<?php
	
class Report_card extends CI_Controller {
	
	
	function Index(){
		
		$query = $this->db->query("SELECT *, tutor_sessions.id AS `session_id` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `parent_email` = ? ORDER BY `assessment_datetime` DESC", array($this->user->data('email')));
		$this->d['sessions'] = $query->result();
		
		
		$this->load->view('common/header', $this->d);
		$this->load->view('report_card/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	
	function Assessment($session_id){
		
		
		$query = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `id` = ?", array($session_id));
		$session = $query->row();
		
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `id` = ?", array($session->job_request_id));
		$job = $query->row();
		
		
		$this->d['session'] 	= $session;
		$this->d['job']			= $job;
		$this->d['info']		= json_decode($job->request_data);
		

		if (!$this->assessment_seen){
			$this->db->update('tutor_sessions',array(
				'assessment_seen'			=> 1,
				'assessment_seen_datetime'	=> date('Y-m-d H:i:s')
			), array(
				'id'						=> $session_id
			));
		}
		
		$this->load->view('common/header', $this->d);
		$this->load->view('report_card/assessment', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	
}