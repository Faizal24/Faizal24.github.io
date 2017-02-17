<?php
	
class Payments extends CI_Controller {
	
	public function Index(){
		
		$from = $this->input->get('from') ? $this->input->get('from') : date('1/m/Y'); 
		$to = $this->input->get('to') ? $this->input->get('to') : date('t/m/Y'); 
		
		$data['from'] = $from;
		$data['to'] = $to;
		
		$query = $this->db->query("SELECT * FROM `job_requests` LEFT JOIN `job_orders` ON job_orders.job_request_id = job_requests.id WHERE job_orders.datetime >= ? AND job_orders.datetime <= ? AND job_requests.status = 'Hired'", array($from . ' 00:00:00', $to . ' 23:59:59'));
		$data['payouts'] = $query->result();


		$this->load->view('payments/index', $data);
	}
	
}