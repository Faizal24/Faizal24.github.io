<?php
	
class Users extends CI_Controller {
	
	public function Index(){
		$this->page();
	}
	
	public function Page($page){
		
		$term = $this->input->get('term');
		
		if ($term){
			if (strtolower(trim($term)) == 'unverified accounts'){
				$special_search = true;
				
				$search = "AND `status` = 'Unverified'";
			} 
			if (strtolower(trim($term)) == 'verified accounts'){
				$special_search = true;				
				
				$search = "AND `status` = 'Verified'";
			}
			
			
			if (!$special_search){
				$escaped_term = $this->db->escape('%'.$term.'%');
				$search = "AND ( `firstname` LIKE $escaped_term OR `lastname` LIKE $escaped_term OR `email` LIKE $escaped_term)";
			}
		}
		
		if (!$page) $page = 1;
		$limit = 5;
		
		$offset = ($page - 1) * $limit;
		
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `users` WHERE `type` = 'user' $search");
		$users = $query->row();

		$query = $this->db->query("SELECT * FROM `users` WHERE `type` = 'user' $search ORDER BY `id` DESC LIMIT $offset, $limit");
		
		$data['users'] 			= $query->result();		
		$data['total_users'] 	= $users->total;
		$data['user_per_page'] 	= $limit;
		$data['page']			= $page;
		$data['total_pages']	= ceil($users->total / $limit);
		$data['term']			= $term;
		
		$this->load->view('users/index', $data);
	}
	
	public function View($id){
		$user = $this->user->id($id);
		if ($user->type != 'user') return $this->form->redirect('users');
		
		$data['user'] = $user;
				
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `request_from` = ? ORDER BY `id` DESC", array($tutor->email));
		$data['requests'] = $query->result();
		
		$query = $this->db->query("SELECT *, tutor_sessions.status AS `session_status` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `request_from` = ? ORDER BY `date` DESC", array($tutor->email));
		$data['sessions'] = $query->result();
				
		$this->load->view('users/view', $data);
	}
	

	
}