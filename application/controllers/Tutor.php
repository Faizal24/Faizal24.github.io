<?php
	
class Tutor extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}

	
	function Ajax($request, $param){
		
		switch ($request){
			
			case "possible_daytimes":
							
				$user = $this->user->data();
				$daytimes = $this->job->Get_possible_booking_daytimes($param, $this->user->tutor($user->id));
				
				echo "<pre>";
				print_r($daytimes);
				echo "</pre>";
				
			break;
			
			
			
			case "save_availability":
			
				$this->db->update('tutor_profile', array(
					'availability'	=> $this->input->post('availability')
				), array(
					'user_email'	=> $this->user->data('email')
				));
				
				
			break;
			
			case "toggle_availability":
			
				$this->db->update('tutor_profile', array(
					'enable_availability'	=> $this->input->post('enable')
				), array(
					'user_email'			=> $this->user->data('email')
				));
			
			break;
		}
		
	}
	
	function Index(){
		
		if ($this->user->is_logged_in()){
			if ($this->user->data('type') == 'tutor'){
				redirect('tutor/complete_signup/0');
			} else {
				redirect();
			}
		}
		

		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/index', $this->d);
		$this->load->view('common/footer', $this->d);

	}
	
	
	function Test($tutor_subject_id){
		
		$ts = $this->system->get_tutor_subject($tutor_subject_id);
		
		if ($ts->user_email != $this->user->data('email')) redirect();
		
		$this->d['subject'] 	= $ts;		
		$this->d['questions'] 	= $this->system->get_questions($ts->subject.'|'.$ts->grade);
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/test', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	function Complete_test($tutor_subject_id){
		
		$ts = $this->system->get_tutor_subject($tutor_subject_id);
		
		if ($ts->user_email != $this->user->data('email')) redirect();
		
		$this->d['subject'] 	= $ts;
		$this->d['questions'] 	= $questions = $this->system->get_questions($ts->subject.'|'.$ts->grade);
		$this->d['responses'] 	= $responses = $this->input->post('response');
		
		
		foreach ($questions as $question){
			if ($responses[$question->number] == $question->correct_answer){
			} else {
				$incorrect[$question->number] = true;
			}
		}

		
		if (!count($incorrect)){
			$this->db->update('tutor_subjects', array(
				'active'		=> 1
			), array(
				'id'			=> $tutor_subject_id
			));
			
			
			$this->d['passed'] = true;
		}
		
		$this->d['incorrect'] = $incorrect;
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/test_result', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	
	function Complete_signup($step){
		
	
		
		
		$this->load->view('common/header', $this->d);
		if (!$step){
			$this->d['responses'] = $this->system->get_question_responses('tutor_signup', $this->user->data('email'));
			$this->d['questions'] = $this->system->get_questions('tutor_signup');
			$this->load->view('tutor/tutor_signup_questions', $this->d);			
		} else {
			$this->load->view('tutor/step'.$step, $this->d);
		}


		$this->load->view('common/footer', $this->d);
		
	}
	
	function Submit_complete_signup($step){
		
		if ($step == 0 || !$step){
			
			$this->db->query("DELETE FROM `qa_responses` WHERE `user_email` = ? AND `set` = 'tutor_signup'", array($this->user->data('email')));
			
			foreach ($this->input->post('question') as $number => $answer){
				$this->db->insert('qa_responses', array(
					'set'			=> 'tutor_signup',
					'user_email'	=> $this->user->data('email'),
					'number'		=> $number,
					'answer'		=> $answer,
					'datetime'		=> date('Y-m-d H:i:s')
				));
			}
			
			redirect('tutor/complete_signup/'.($step+1));
		}
		
		if ($step == 1){
			
			$subject_grades = $this->input->post('subject_grade');

			$this->db->query("DELETE FROM `tutor_subjects` WHERE `user_email` = ?", array($this->user->data('email')));
							
			foreach ($subject_grades as $subject_grade){
				list($subject,$grade) = explode('|', $subject_grade);
				
				$this->db->insert('tutor_subjects', array(
					'user_email'	=> $this->user->data('email'),
					'subject'		=> $subject,
					'grade'			=> $grade
				));
			}
			
			redirect('tutor/complete_signup/'.($step+1));
			
		}
		
		if ($step == 2){
			
			
			redirect('tutor/complete_signup/'.($step+1));
		}
		
		if ($step == 3){

			
			$sql = $this->db->update('tutor_profile', array(
				'address1'				=> $this->input->post('address1'),
				'address2'				=> $this->input->post('address2'),
				'city'					=> $this->input->post('city'),
				'zipcode'				=> $this->input->post('zipcode'),
				'country'				=> $this->input->post('country'),
				'address1'				=> $this->input->post('address1'),
				'dob'					=> reformat_date($this->input->post('dob')),
				'nric'					=> $this->input->post('nric'),
				'race'					=> $this->input->post('race'),
				'tutoring_experience'	=> $this->input->post('tutoring_experience'),
				'tutoring_duration'		=> $this->input->post('tutoring_duration'),
				'tutoring_career'		=> $this->input->post('tutoring_career'),
				'occupation'			=> $this->input->post('occupation'),
				'bank_account_number'	=> $this->input->post('bank_account_no'),
				'bank_name'				=> $this->input->post('bank_name'),
				'education'				=> json_encode($this->input->post('education')),
				'locations'				=> implode(',', $this->input->post('locations'))
			), array(
				'user_email'			=> $this->user->data('email')
			));
			
			redirect('tutor/complete_signup/'.($step+1));
		}
		
		if ($step == 4){
			
			$this->db->update('users', array(
				'photo'					=> $this->input->post('image'),
			), array(
				'email'					=> $this->user->data('email')
			));
			
			$this->db->update('tutor_profile', array(
				'about'					=> $this->input->post('about')
			), array(
				'user_email'			=> $this->user->data('email')
			));
			
			foreach ($this->input->post('rate') as $tutor_subject_id => $rate){
				$this->db->update('tutor_subjects', array(
					'rate'				=> $rate
				), array(
					'id'				=> $tutor_subject_id
				));
			}
			
			redirect('tutor/complete_signup/'.($step+1));
		}
		
		if ($step == 5){
			
			redirect('tutor/complete_signup/'.($step+1));
		}
		
		if ($step == 6){
			
			$this->db->update('users', array(
				'status' 	=> 'Verified'
			), array(
				'id'		=> $this->user->data('id')
			));
			
			redirect('tutor/dashboard');
		}
	}
	
	
	function Report_card(){
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/report_card', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	function Clients(){
		
		$this->d['clients'] = $this->job->get_clients();
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/clients', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function Schedule(){
		$this->d['schedule'] = $this->job->get_schedule();
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/schedule', $this->d);
		$this->load->view('common/footer', $this->d);

	}
	
	function Dashboard(){
		
		
		if ($this->user->data('status') == 'Unverified'){
			redirect('tutor/complete_signup/0');
		}
		
		$this->d['blocked'] = $this->job->get_blocked_daytime($this->user->data('email'));
		
		$this->d['requests'] = $this->job->get_requests(array('to' => $this->user->data('email'), 'status' => 'Awaiting Confirmation,Pending Payment'));
		$this->d['tutor'] = $this->user->tutor($this->user->data('id'));
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/dashboard', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	function Find(){
		redirect();
	}
	
	function Request(){
		
		$tutor_id = $this->input->post('tutor_id');
		
		$tutor = $this->user->id($tutor_id);
		
		$this->db->insert('job_requests', array(
			'request_from'	=> $this->user->data('email'),
			'request_to'	=> $tutor->email,
			'request_data'	=> json_encode($this->input->post('request_data')),
			'datetime'		=> date('Y-m-d H:i:s'),
			'status'		=> 'Awaiting Confirmation'
		));
		
		$id = $this->db->insert_id();
		
		$this->db->insert('notifications', array(
			'user_email'=> $tutor->email,
			'message'	=> '<strong>'. $this->user->data('firstname') . ' ' . $this->user->data('lastname') . '</strong> has requested to hire you',
			'url'		=> "tutor/request_details/{$id}",
			'from_user'	=> $this->user->data('email'),
			'datetime'	=> date('Y-m-d H:i:s')
		));

		
		echo '<script language="javascript" type="text/javascript">';
		echo 'window.top.window.requestSubmitted(1)';
		echo '</script>';
		
	}
	
	function Search(){
		
		$this->d['search'] = $search = $this->input->post();
				
		$filter[] = "`subject` = "	. $this->db->escape($search['subject']);
		$filter[] = " `grade` = " 	. $this->db->escape($search['grade']);
		$filter[] = "FIND_IN_SET(".$this->db->escape($search['city']).", `locations`)";
		// $filter[] = "`country` = " 	. $this->db->escape($earch['country']);
		// $filter[] = "`state` = " 	. $this->db->escape($search['state']);
		
		foreach (explode(',', $this->input->post('preferred_time')) as $pt){
			$or_filter[] = ' `availability` LIKE ' . $this->db->escape('%'.trim($pt).'%');
		}
		
		$filter[] = '(' . implode(' OR ', $or_filter) . ')';
		
		$query = $this->db->query("SELECT *, users.id FROM `users` 
			LEFT JOIN tutor_subjects ON tutor_subjects.user_email = users.email 
			LEFT JOIN tutor_profile ON tutor_profile.user_email = users.email
			" . and_filter($filter));
		
		
		
		
		$hours = round($search['hours']+0);
				
		foreach ($query->result() as $tutor){
			
			$blocked = $this->job->get_blocked_daytime($tutor->email);
			
			
	
			
			if ($this->job->check_possible_session($search['preferred_time'], $hours, $tutor)){
				$tutors[] = $tutor;
			}
			
			// test tutor availability
			
			
			
		}

			
		$this->d['tutors'] = $tutors;
		
		$this->session->set_userdata(array(
			'search_grade'		=> $search['grade'],
			'search_subject'	=> $search['subject'],
			'search_hours'		=> $search['hours'],
			'search_city'		=> $search['city']
		));
		
				
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/search', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function View($id){
		
		$this->d['search_subject_grade'] 	= $this->session->userdata('search_grade') . '|' . $this->session->userdata('search_subject');
		$this->d['search_hours']			= $this->session->userdata('search_hours');
		$this->d['search_city']				= $this->session->userdata('search_city');
		
		$tutor = $this->user->tutor($id);
		$tutor->subjects = $this->user->tutor_subjects($tutor);
		$this->d['tutor'] = $tutor;
		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/view', $this->d);
		$this->load->view('common/footer', $this->d);

	}
	
	function Edit_subject($tutor_subject_id){
		
		$ts = $this->system->get_tutor_subject($tutor_subject_id);
		
		if ($ts->user_email != $this->user->data('email')) redirect();
		
		$this->d['subject'] 	= $ts;		

		if ($this->input->post('submit')){
			$this->db->update('tutor_subjects', array(
				'rate'		=> $this->input->post('rate')
			), array(
				'id'		=> $tutor_subject_id
			));
			
			redirect('tutor/dashboard#subjects');
		}

		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/subject_edit', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function Delete_subject($tutor_subject_id, $do){
		$ts = $this->system->get_tutor_subject($tutor_subject_id);
		
		if ($ts->user_email != $this->user->data('email')) redirect();

		if ($do == 'do'){
			$this->db->query("DELETE FROM `tutor_subjects` WHERE `id` = ?", array($tutor_subject_id));
		}
		
		redirect('tutor/dashboard#subjects');

	}
	
	function Add_subject(){
		
		if ($this->input->post('submit')){

			$subject_grades = $this->input->post('subject_grade');

			foreach ($subject_grades as $subject_grade){
				list($subject,$grade) = explode('|', $subject_grade);
				
				$this->db->insert('tutor_subjects', array(
					'user_email'	=> $this->user->data('email'),
					'subject'		=> $subject,
					'grade'			=> $grade
				));
			}
			
			redirect('tutor/dashboard#subjects');
			
		}

		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/subject_add', $this->d);
		$this->load->view('common/footer', $this->d);
				
	}
	
	function Accept_request($request_id){
		$request = $this->job->get_request($request_id);
		
		if ($request->request_to != $this->user->data('email')) redirect();
		
		$this->db->update('job_requests', array(
			'status'	=> 'Pending Payment'
		), array(
			'id'		=> $request->id
		));
		
		
		
		$this->db->insert('notifications', array(
			'user_email'=> $request->request_from,
			'message'	=> '<strong>'. $this->user->data('firstname') . ' ' . $this->user->data('lastname') . '</strong> has accepted your request!',
			'url'		=> "mytutor/details/{$request->id}",
			'from_user'	=> $this->user->data('email'),
			'datetime'	=> date('Y-m-d H:i:s')
		));

		
		
		$this->session->set_flashdata('accepted_request', 1);
		
		redirect('tutor/request_details/'.$request->id);
		
	}
	
	function Decline_request($request_id){
		
		$request = $this->job->get_request($request_id);
		
		if ($request->request_to != $this->user->data('email')) redirect();
		
		$this->db->update('job_requests', array(
			'status'	=> 'Declined'
		), array(
			'id'		=> $request->id
		));
		
		$this->db->insert('notifications', array(
			'user_email'=> $request->request_from,
			'message'	=> '<strong>'. $this->user->data('firstname') . ' ' . $this->user->data('lastname') . '</strong> has declined your request',
			'url'		=> "mytutor/details/{$request->id}",
			'from_user'	=> $this->user->data('email'),
			'datetime'	=> date('Y-m-d H:i:s')
		));
		
		
		$this->session->set_flashdata('declined_request', 1);
		
		redirect('tutor/request_details/'.$request->id);
	}
	
	function Request_details($request_id){
		$request = $this->job->get_request($request_id);
		
		if ($request->request_to != $this->user->data('email')) redirect();
		
		$this->d['request'] 		= $request;
		$this->d['request_data'] 	= json_decode($request->request_data);
		$this->d['user'] 			= $user = $this->user->email($request->request_from);
		$this->d['sessions'] 		= $this->job->get_sessions($request->id);

		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/details', $this->d);
		$this->load->view('common/footer', $this->d);

				
	}
	
	function Lesson_details($request_id, $client_id){
		$request = $this->job->get_request($request_id);
		
		if ($request->request_to != $this->user->data('email')) redirect();
		
		$this->d['sessions'] = $this->job->get_sessions($request->id);
		$this->d['request'] = $request;
		$this->d['request_data'] = json_decode($request->request_data);
		$this->d['user'] = $user = $this->user->email($request->request_from);

		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/lesson_details', $this->d);
		$this->load->view('common/footer', $this->d);

				
	}
	
	function Client_details($client_id){
		
		$this->d['user'] = $client = $this->user->id($client_id);
		$this->d['requests'] = $this->job->get_lessons($client->email);

		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/client_details', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function Assessment($session_id){
		
		
		
		if ($this->input->post('submit')){
			
			

			
			$query = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `id` = ?", array($session_id));
			$session = $query->row();
		
			$query = $this->db->query("SELECT * FROM `job_requests` WHERE `id` = ?", array($session->job_request_id));
			$job = $query->row();
			
						
			$this->db->update('tutor_sessions', array(
				'assessment'			=> json_encode($this->input->post('assessment')),
				'assessment_datetime'	=> date('Y-m-d H:i:s'),
				'parent_email'			=> $job->request_from
			), array(
				'id'			=> $session_id
			));
			
			$this->session->set_flashdata('review_submitted',1);
		}

		
		$query = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `id` = ?", array($session_id));
		$session = $query->row();
		
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `id` = ?", array($session->job_request_id));
		$job = $query->row();
		
		
		$this->d['session'] 	= $session;
		$this->d['job']			= $job;
		$this->d['info']		= json_decode($job->request_data);
		

		
		$this->load->view('common/header', $this->d);
		$this->load->view('tutor/assessment', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	function Schedule_complete($id){
		$this->db->update('tutor_sessions', array(
			'status'	=> 'Completed'
		), array(
			'id'		=> $id
		));
		
		redirect('tutor/schedule');
	}
	
}