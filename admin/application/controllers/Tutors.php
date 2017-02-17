<?php
	
class Tutors extends CI_Controller {
	
	public function Index(){
		$this->page();
	}
	
	public function Ajax($request){
		switch ($request){
			
			case "update_account_status":
				
				$email 		= $this->input->post('email');
				$status 	= $this->input->post('status');
				
				$this->db->update('users',array(
					'status'=> $status
				), array(
					'email'	=> $email
				));
				
			
			break;
			
			case "update_interview_status":
			
				$email 		= $this->input->post('email');
				$status 	= $this->input->post('status');
				
				$this->db->update('tutor_profile',array(
					'interview_status'	=> $status
				), array(
					'user_email'		=> $email
				));
			
			break;
			
			case "update_assessment_status":
			
				$email 		= $this->input->post('email');
				$status 	= $this->input->post('status');
				
				$this->db->update('tutor_profile',array(
					'passed_assessment'	=> $status
				), array(
					'user_email'		=> $email
				));
			
			break;
		}
	}
	
	public function View($id){
		$tutor = $this->user->tutor($id);
		if ($tutor->type != 'tutor') return $this->form->redirect('tutors');
		
		$tutor->subjects = $this->user->tutor_subjects($tutor);
		$data['tutor'] = $tutor;
		
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `request_to` = ? ORDER BY `id` DESC", array($tutor->email));
		$data['requests'] = $query->result();
		
		$query = $this->db->query("SELECT *, tutor_sessions.status AS `session_status` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `user_email` = ? ORDER BY `date` DESC", array($tutor->email));
		$data['sessions'] = $query->result();
		
		$query = $this->db->query("SELECT * FROM `job_requests` LEFT JOIN `job_orders` ON job_orders.job_request_id = job_requests.id WHERE `request_to` = ?", array($tutor->email));
		$data['payouts'] = $query->result();
		
		
		$this->load->view('tutors/view', $data);
	}
	
	public function Add(){
		
		
		if ($this->input->post('submit')){
			
			
			$email = trim($this->input->post('email'));
			
			if (!trim($email)){
				$error['email'] = 'Email cannot be empty';
			} else {
				if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
					$error['email'] = 'Invalid email address';
				}
			}
			
			if ($this->user->email($email)->id){
				$error['email'] = 'Account already exists';
			}

			
			if (strlen(trim($this->input->post('firstname'))) <= 3){
				$error['firstname'] = 'First name must be at least 3 characters long';
			}
			
			if (strlen(trim($this->input->post('password'))) < 6){
				$error['password'] = 'Password must be at least 6 characters long';
			}
			


			if (count($this->user->query("nric = ?", array($nric), 'tutor_profile'))){
				$error['nric'] = 'NRIC already exists';
			}
			
			if (strpos(trim($this->input->post('nric')), '-') !== false){
				$error['nric'] = 'NRIC must not contain dashes';
			}
			
			if (strlen($nric = trim($this->input->post('nric'))) < 7){
				$error['nric'] = 'NRIC must be at least 7 characters long';
			}

			
			if (!count($error)){
				
				$this->db->insert('users', array(
					'type'			=> 'tutor',
					'firstname'		=> trim($this->input->post('firstname')),
					'lastname'		=> trim($this->input->post('lastname')),
					'password'		=> sha1($this->input->post('password')),
					'email'			=> $email,
					'photo'			=> $this->input->post('photo'),
					'state'			=> trim($this->input->post('state')),
					'status'		=> 'Unverified',
					'registered_on'	=> date('Y-m-d H:i:s')
				));
				
				$user_id = $this->db->insert_id();
				
				$this->db->insert('tutor_profile',array(
					'user_email'	=> $email,
					'gender'		=> $this->input->post('gender'),
					'address1'		=> $this->input->post('address1'),
					'address2'		=> $this->input->post('address2'),
					'city'			=> $this->input->post('city'),
					'zipcode'		=> $this->input->post('zipcode'),				
					'country'		=> $this->input->post('country'),
					'rate'			=> $this->input->post('rate'),
					'about'			=> $this->input->post('about'),
					'qualification'	=> $this->input->post('qualification'),
					'institution'	=> $this->input->post('institution'),
					'nric'			=> $this->input->post('nric')
				));
				
				$subjects = $this->input->post('subject');
				
				foreach ($subjects as $subject){
					list($s, $g) = explode('|',$subject);
					
					$this->db->insert('tutor_subjects', array(
						'user_email'	=> $email,
						'subject'		=> $s,
						'grade'			=> $g
					));
				}
	
				return $this->form->redirect('tutors/view/'.$user->id);
			
			}
			
			$data['error'] = $error;
		} 
		
		$this->load->view('tutors/add', $data);
	}
	
	public function Edit($id){
		
		$tutor = $this->user->tutor($id);
		$tutor->subjects = $this->user->tutor_subjects($tutor);
		
		$data['tutor'] = $tutor;
	
		
		if ($this->input->post('submit')){
			
			
			$email = trim($this->input->post('email'));
			

			
			if (strlen(trim($this->input->post('firstname'))) <= 3){
				$error['firstname'] = 'First name must be at least 3 characters long';
			}
			
			if (trim($this->input->post('password'))){
				if (strlen(trim($this->input->post('password'))) < 6){
					$error['password'] = 'Password must be at least 6 characters long';
				}
			}
			
			if (count($this->user->query("nric = ?", array($nric), 'tutor_profile'))){
				$error['nric'] = 'NRIC already exists';
			}
			
			if (strpos(trim($this->input->post('nric')), '-') !== false){
				$error['nric'] = 'NRIC must not contain dashes';
			}
			
			if (strlen($nric = trim($this->input->post('nric'))) < 7){
				$error['nric'] = 'NRIC must be at least 7 characters long';
			}

			
			if (!count($error)){
				
				$this->db->update('users', array(
					'type'			=> 'tutor',
					'firstname'		=> trim($this->input->post('firstname')),
					'lastname'		=> trim($this->input->post('lastname')),
					'password'		=> sha1($this->input->post('password')),
					'photo'			=> $this->input->post('photo'),
					'state'			=> trim($this->input->post('state')),
					'status'		=> 'Unverified',
					'registered_on'	=> date('Y-m-d H:i:s')
				), array(
					'email'			=> $email
				));
				
				$user_id = $this->db->insert_id();
				
				$this->db->update('tutor_profile',array(
					'gender'		=> $this->input->post('gender'),
					'address1'		=> $this->input->post('address1'),
					'address2'		=> $this->input->post('address2'),
					'city'			=> $this->input->post('city'),
					'zipcode'		=> $this->input->post('zipcode'),				
					'country'		=> $this->input->post('country'),
					'rate'			=> $this->input->post('rate'),
					'about'			=> $this->input->post('about'),
					'qualification'	=> $this->input->post('qualification'),
					'institution'	=> $this->input->post('institution'),
					'nric'			=> $this->input->post('nric')
				), array(
					'user_email'	=> $email
				));
				
				$subjects = $this->input->post('subject');
				
				$this->db->query("DELETE FROM `tutor_subjects` WHERE `user_email` = ?", array($email));
				
				foreach ($subjects as $subject){
					list($s, $g) = explode('|',$subject);
					
					$this->db->insert('tutor_subjects', array(
						'user_email'	=> $email,
						'subject'		=> $s,
						'grade'			=> $g
					));
				}
				
	
				return $this->form->redirect('tutors/view/'.$user->id);
			
			}
			
			$data['error'] = $error;
		} 
		
		$this->load->view('tutors/edit', $data);
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
		
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `users` WHERE `type` = 'tutor' $search");
		$users = $query->row();

		$query = $this->db->query("SELECT * FROM `users` WHERE `type` = 'tutor' $search ORDER BY `id` DESC LIMIT $offset, $limit");
		
		$data['users'] 			= $query->result();		
		$data['total_users'] 	= $users->total;
		$data['user_per_page'] 	= $limit;
		$data['page']			= $page;
		$data['total_pages']	= ceil($users->total / $limit);
		$data['term']			= $term;
		
		$this->load->view('tutors/index', $data);
	}
	

	
}