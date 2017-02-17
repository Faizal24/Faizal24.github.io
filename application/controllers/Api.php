<?php
			
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	var $no_auth_request = array(
		'user/signup',
		'user/auth',
		'user/fbauth',
		'user/pwdreset'
	);	
	
	var $req;	
	var $res;
	var $app;
	var $appuser;

	function __construct(){
		parent::__construct();
		
		
		// CORS
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		


		// CONFIG
		$this->config->load('app', true);
		$this->app = $this->config->item('app');

		$this->res = new stdClass();		
		
		if (!$this->_parse_request()){
			$this->_error('Bad request', 'Request specified is invalid');
		}
		
		if ($this->_require_auth()){
			
			if (!$this->_check_auth()){
				
				$this->_error('Unauthorized','Invalid authorization key ' . $this->req->authkey);		
			}
		}
		
		$this->_exec_request();
		
		die();
		
	}
	
	function Index(){
		
	}
	
	
	function Tutor($request){
		switch ($request){
			case "get_clients":
				$this->res->status	= 'success';
				$this->res->data = $this->job->get_clients($this->userdata->email);
				
			break;
			
			case "get_schedule":
				$this->res->status	= 'success';
				$this->res->data = $this->job->get_schedule($this->userdata->email, $this->userdata->type);
			
			break;
			
			case "get_sessions":
				$request_id = $this->req->data->request_id;
				$this->res->status	= 'success';
				$this->res->data = $this->job->get_sessions($request_id);
			
			break;
			
			case "get_requests":
				$this->res->status	= 'success';
				$this->res->data = $this->job->get_requests(array($to => $this->userdata->email));
				
			
			break;
			
			case "accept_request":
			
				$request_id = $this->req->data->request_id;
				
				$request = $this->job->get_request($request_id);
		
				if ($request->request_to != $this->userdata->email){
					$this->error('Request error', 'Invalid request');
				}
				
				$this->db->update('job_requests', array(
					'status'	=> 'Pending Payment'
				), array(
					'id'		=> $request->id
				));
				
				
				$this->db->insert('notifications', array(
					'user_email'=> $request->request_from,
					'message'	=> '<strong>'. $this->userdata->firstname . ' ' . $this->userdata->lastname . '</strong> has accepted your request!',
					'url'		=> "mytutor/details/{$request->id}",
					'from_user'	=> $this->userdata->email,
					'datetime'	=> date('Y-m-d H:i:s')
				));

				$this->res->status	= 'success';
			
			break;
			
			case "decline_request":
				
				$request_id = $this->req->data->request_id;
				
				$request = $this->job->get_request($request_id);
		
				if ($request->request_to != $this->userdata->email){
					$this->error('Request error', 'Invalid request');
				}
			
				$this->db->update('job_requests', array(
					'status'	=> 'Declined'
				), array(
					'id'		=> $request->id
				));
				
				$this->db->insert('notifications', array(
					'user_email'=> $request->request_from,
					'message'	=> '<strong>'. $this->userdata->firstname . ' ' . $this->userdata->lastname . '</strong> has declined your request',
					'url'		=> "mytutor/details/{$request->id}",
					'from_user'	=> $this->userdata->email,
					'datetime'	=> date('Y-m-d H:i:s')
				));
				
				$this->res->status	= 'success';
			
			break;
			
			case "start_session":
			
				$session_id = $this->req->data->session_id;
				
				$sesion = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `id` = ?", array($session_id));
				
				if ($session->status == 'In Progress'){
					$this->error('Request error','Session is already in progress');
				} 

				if ($session->status == 'Completed'){
					$this->error('Request error','Session is already completed');
				} 
			
				$this->db->update('tutor_sessions', array(
					'session_start'	=> date('Y-m-d H:i:s'),
					'status'		=> 'In Progress'
				));
				
				$this->res->status	= 'success';
			
			break;
			
			case "end_session":
			
				$session_id = $this->req->data->session_id;
				
				$sesion = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `id` = ?", array($session_id));
				

				if ($session->status == 'Completed'){
					$this->error('Request error','Session is already completed');
				} 
			
				$this->db->update('tutor_sessions', array(
					'session_start'	=> date('Y-m-d H:i:s'),
					'status'		=> 'Completed'
				));
			
				$this->res->status	= 'success';
			break;
			default:
			
				$this->_error('Invalid request', 'User request is invalid');
				
			break;

			
		}
		
		$this->_output();
	}
	
	
	function Maitutor($request){
		switch ($request){
			
			case "search":
			
				$subject 		= $this->req->data->subject;
				$grade			= $this->req->data->grade;
				$city			= $this->req->data->city;
				$preferred_time	= $this->req->data->preferred_time;
				$hours			= $this->req->data->hours;
				
				if (!$subject){
					$this->_error('Form error', 'Subject is not specified.');
				}
				
				if (!$grade){
					$this->_error('Form error', 'Grade is not specified.');
				}
				
				if (!$city){
					$this->_error('Form error', 'Location is not specified.');
				}
				
				if (!$preferred_time){
					$this->_error('Form error', 'Preferred time is not specified.');
				}
				
				if (!$hours){
					$this->_error('Form error', 'Hours per session is not specified.');
				}
				
				
				$filter[] = "`subject` = "	. $this->db->escape($subject);
				$filter[] = " `grade` = " 	. $this->db->escape($grade);
				$filter[] = "FIND_IN_SET(".$this->db->escape($city).", `locations`)";
				// $filter[] = "`country` = " 	. $this->db->escape($earch['country']);
				// $filter[] = "`state` = " 	. $this->db->escape($search['state']);
		
				foreach (explode(',', $preferred_time) as $pt){
					$or_filter[] = ' `availability` LIKE ' . $this->db->escape('%'.trim($pt).'%');
				}
		
				$filter[] = '(' . implode(' OR ', $or_filter) . ')';
		
				$query = $this->db->query("SELECT *, users.id FROM `users` 
					LEFT JOIN tutor_subjects ON tutor_subjects.user_email = users.email 
					LEFT JOIN tutor_profile ON tutor_profile.user_email = users.email
					" . and_filter($filter));
					
		
				$hours = round($hours);
				
				foreach ($query->result() as $tutor){
					
					$blocked = $this->job->get_blocked_daytime($tutor->email);
					
					if ($this->job->check_possible_session($preferred_time, $hours, $tutor)){
						unset($tutor->password);
						$tutors[] = $tutor;
					}
					
					// test tutor availability
					
				}
				
				$this->res->status	= 'success';
				$this->res->data 	= $tutors;
		
		
			break;
			
			case "profile":
			
				$id = $this->req->data->id;
						
				$tutor = $this->user->tutor($id);
				
				if (!$tutor->id){
					$this->_error('Error', 'Profile not found.');
				}
				
				$tutor->subjects = $this->user->tutor_subjects($tutor);

				$this->res->status	= 'success';
				$this->res->data 	= $tutor;

			
			
			break;
			
			case "request":
			
			
				$to 		= $this->req->data->to;
				$request	= $this->req->data->request;
				$tutor = $this->user->email($to);

				if ($tutor->type != 'tutor'){
					$this->_error('Request error', 'Invalid tutor');
				}
				
				$tutor_subject = $this->user->tutor_subjects($tutor);
				
				if (!$request->subject){
					$this->_error('Request error', 'Subject is not specified.');
				}

				if (!$request->grade){
					$this->_error('Request error', 'Grade is not specified.');
				}
				
				if (!$request->hours){
					$this->_error('Request error', 'Hours per session is not specified.');
				}

				if (!$request->sessions){
					$this->_error('Request error', 'Number of sessions is not specified.');
				}
				
				if (!$request->session < 3 || !$request->sessions > 5){
					$this->error('Request error', 'Number of sessions must be from 3 to 5');
				}
				
				if (!$request->student_name){
					$this->_error('Request error', 'Student name is not specified.');
				}

				if (!$request->student_gender){
					$this->_error('Request error', 'Student gender is not specified.');
				}
				
				if (!$request->student_age){
					$this->_error('Request error', 'Student age is not specified.');
				}

				if (!$request->address){
					$this->_error('Request error', 'Address is not specified.');
				}

				if (!$request->city){
					$this->_error('Request error', 'City is not specified.');
				}
				
				
				
				
				foreach ($tutor_subject as $subject){
					$subjects[$subject->subject][$subject->grade] = $subject->rate;
				}
				
				if (!$rate = $subjects[$request->subject][$request->grade]){
					$this->_error('Request error', 'Invalid subject.');
				} else {
					$request->rate = str_replace('.','',$rate);
				}
				
				
				
				$this->db->insert('job_requests', array(
					'request_from'	=> $this->userdata->email,
					'request_to'	=> $tutor->email,
					'request_data'	=> json_encode($request),
					'datetime'		=> date('Y-m-d H:i:s'),
					'status'		=> 'Awaiting Confirmation'
				));
				
				$id = $this->db->insert_id();
				
				$this->db->insert('notifications', array(
					'user_email'=> $tutor->email,
					'message'	=> '<strong>'. $this->userdata->firstname . ' ' . $this->userdata->lastname . '</strong> has requested to hire you',
					'url'		=> "tutor/request_details/{$id}",
					'from_user'	=> $this->userdata->email,
					'datetime'	=> date('Y-m-d H:i:s')
				));
				
				$res->status 	= 'Awaiting Confirmation';
				$res->id		= $id;
				
				$this->res->status		= 'success';
				$this->res->data		= $res;
							
			break;
			
			case "get_requests":
				
				$request_from 	= $this->req->data->from;
				$request_to 	= $this->req->data->to;
				$status			= $this->req->data->status;
				
				if ($request_from){
					$filters['from'] = $request_from;
				}

				if ($request_to){
					$filters['to'] = $request_to;
				}

				if ($status){
					$filters['status'] = $status;
				}
				
				$this->res->status 	= 'success';
				foreach ($this->job->get_requests($filters) as $request){
					$request->request_data = json_decode($request->request_data);
					
					$requests[] = $request;
				}
				
				$this->res->data = $requests;
			
			break;
			
			case "get_orders":
				
			
			
			break;
			
			
			case "get_order":
			
			
			break;
			
			
			case "checkout_request":
				
				$id = $this->req->data->request_id;
				
				$request = $this->job->get_request($id);
				$user = $this->user->email($request->request_to);
				$tutor = $this->user->tutor($user->id);
				$request_data = json_decode($request->request_data);
				
				$request->request_info = $request_data;
		
				$select_daytime = array(''=>'Select Day/Time');
		
				foreach ($this->job->Get_possible_booking_daytimes(round($request_data->hours), $tutor) as $d){
					$select_daytime[$d] = $d;
				}
				$select_daytime;
		
				$checkout_data->tutor = $tutor;
				$checkout_data->request = $request;
				$checkout_data->possible_daytime = $select_daytime;

				return $checkout_data;
				
				$this->res->data = $checkout_data;
			
			break;
			
			
			case "process_checkout":
			
			
				$session_dates 	= $this->req->data->session_dates;
				$id				= $this->req->data->request_id;
				$message		= $this->req->data->message;
				$session_time	= $this->req->data->session_time;
				
				
				
			
				$request 		= $this->job->get_request($id);
				$request_data 	= json_decode($request->request_data);
				$user 			= $this->user->email($request->request_to);
				$tutor 			= $this->user->tutor($user->id);
				
				
				
		
				$possible_daytimes = $this->job->Get_possible_booking_daytimes(round($request_data->hours), $tutor);
				// check daytimes;
		
		
				$ok = true;
				
				if (!$request->id){
					$this->_error('Checkout Error', 'Invalid request');
				}
				
				if ($request->request_from != $this->userdata->email){
					$this->_error('Checkout Error', 'Invalid request');
				}
				
		
				if (!$possible_daytimes[$this->input->post('day')]){
					$ok = false;
					$this->_error('Checkout Error', 'Unfortunately the date and time has become unavailable.');			
				}
				
				if (!$this->input->post('day')){
					$ok = false;
					$this->_error('Checkout Error', 'Please select day and time of tutoring.');			
				}
				
		
				if ($ok){
					

					$this->db->insert('job_orders', array(
						'job_request_id'		=> $id,
						'status'				=> 'Confirmed',
						'payment_status'		=> 'Paid',
						'datetime'				=> date('Y-m-d H:i:s'),
						'amount_payable'		=> '',
						'amount_tax'			=> '',
						'amount_commission'		=> '',
						'message'				=> $message
					));
					
					$job_order_id = $this->db->insert_id();
					
					foreach (explode(',', $session_dates) as $session_date){
						$this->db->insert('tutor_sessions', array(
							'job_order_id'		=> $job_order_id,
							'job_request_id'	=> $id,
							'user_email'		=> $request->request_to,
							'date'				=> $session_date,
							'time'				=> date('H:i:s', strtotime($session_time)),
							'duration'			=> $request_data->hours,
							'status'			=> 'Scheduled'
						));
					}
					
					$this->db->update('job_requests', array(
						'status'	=> 'Hired'
					), array(
						'id'		=> $id
					));
					
					$this->db->insert('notifications', array(
						'user_email'=> $tutor->email,
						'message'	=> '<strong>'. $this->userdata->firstname . ' ' . $this->userdata->lastname . '</strong> has hired you',
						'url'		=> "tutor/request_details/{$id}",
						'from_user'	=> $this->user->data('email'),
						'datetime'	=> date('Y-m-d H:i:s')
					));
		
					
				}
			
				$process_data->order_id 	= $job_order_id;
				$process_data->gateway_url 	= '';
				$this->res->status = 'success';
				$this->res->data = $process_data;

			
			
			break;
			case "submit_review":
			
				$tutor_email 	= $this->req->data->tutor_email;
				$review			= $this->req->data->review;
				$rating			= $this->req->data->rating;
				
				$query = $this->db->query("SELECT * FROM `job_requests` WHERE `request_from` = ? AND `request_to` = ? AND `status` = 'Hired'", array($this->userdata->email, $tutor_email));
				if (!$query->num_rows()){
					$this->_error('Review error','You did not hire this tutor');
				}
				
				
				$query = $this->db->query("SELECT * FROM `reviews` WHERE `user_email` = ? AND `tutor_email` = ?", array($this->userdata->email, $tutor_email));
				
				if ($query->num_rows()){
					
					$this->_error('Review error', 'You have reviewed this tutor');
					
				} else {
				
						
					if (!$rating){
						$this->_error('Review error', 'Please select a rating');
					} else {
					
						if ($rating < 1 || $rating > 5){
							$this->_error('Review error', 'Invalid rating');
						}
					}
						
						
					$this->db->insert('reviews', array(
						'tutor_email'		=> $tutor_email,
						'user_email'		=> $this->userdata('email'),
						'review'			=> $review,
						'rating'			=> $rating,
						'datetime'			=> date('Y-m-d H:i:s')
					));
					
					$review_count = $tutor->review_count + 1;
					$review_rating = (($tutor->review_rating * $tutor->review_count) + $rating) / $review_count;
					
					$this->db->update('users', array(
						'review_count'	=> $review_count,
						'review_rating' => $review_rating
					), array(
						'email'			=> $tutor_email
					));
							
					$review_id = $this->db->insert_id();
							
							
					$this->db->insert('notifications', array(
						'user_email'=> $tutor->email,
						'message'	=> '<strong>'. $this->user->data('firstname') . ' ' . $this->user->data('lastname') . '</strong> has submitted a review on you',
						'url'		=> "tutor/review/{$review_id}",
						'from_user'	=> $this->user->data('email'),
						'datetime'	=> date('Y-m-d H:i:s')
					));
					
					$this->res->status = 'success';
					$review_data->review_count = $review_count;
					$review_data->review_rating = $review_rating;
					$this->res->data = $review_data;
		
				}
			break;
			
			default:
			
				$this->_error('Invalid request', 'User request is invalid');
				
			break;

			
		}
		
		$this->_output();
	}
	
	function User($request){
		switch ($request){
			
			case "update":
			
				$this->db->update('users', array(
					'name'		=> $this->req->data->name,
					'mobile'	=> $this->req->data->mobile,
				), array(
					'id'		=> $this->userdata->id
				));
				
				$this->res->status 	= 'success';
			
				break;
			
			case "data":
			
				$this->res->status 	= 'success';
				$this->res->user	= $this->userdata;
				
				break;
				
				
			case 'fb_complete':
				
				if (!isset($this->req->data->name)){
					$this->_error('Form error', 'Name is not specified.');
				}
				
				if (strlen(trim($this->req->data->name)) < 3){
					$this->_error('Form error', 'Name must be at least 3 characters long.');
				}
			
				if (!isset($this->req->data->email)){
					$this->_error('Form error','Email is not specified.');
				}
								
				if (filter_var($this->req->data->email, FILTER_VALIDATE_EMAIL) === false){
					$this->_error('Form error','Invalid email address.');
				}
				
				
				if (!isset($this->req->data->password)){
					$this->_error('Form error', 'Password is not specified');
				}
				
				if (strlen(trim($this->req->data->password)) < 6){
					$this->_error('Form error', 'Password must be at least 6 characters long.');
				}
				
				
				if (!isset($this->req->data->mobile)){
					$this->_error('Form error', 'Mobile number is not specified.');
				}
				
				if (!is_numeric($this->req->data->mobile)){
					$this->_error('Form error', 'Mobile number is invalid.');				
				}
				
				if (strlen(trim($this->req->data->mobile)) < 10){
					$this->_error('Form error', 'Mobile number is invalid');
				}
				
				$this->user->complete_profile($this->req->data, $this->userdata->id);
				
				// $this->_SMS($this->req->data->mobile, 'Thank you for registering with MaiTutor! Please check your email for account verification. Have a nice day!');
				
				$this->res->status 	= 'success';
				$this->res->authkey = $this->userdata->email . '#' . $this->userdata->key;
			
				break;
			
			case 'signup':
			

			
				if (!isset($this->req->data->firstname)){
					$this->_error('Form error', 'Firstname is not specified.');
				}
				
				if (strlen(trim($this->req->data->firstname)) < 3){
					$this->_error('Form error', 'Firstname must be at least 3 characters long.');
				}
			
				if (!isset($this->req->data->email)){
					$this->_error('Form error','Email is not specified.');
				}
								
				if (filter_var($this->req->data->email, FILTER_VALIDATE_EMAIL) === false){
					$this->_error('Form error','Invalid email address.');
				}
				

				if ($this->user->account_exists($this->req->data->email)){
					$this->_error('Form error', 'Account already exists.');
				}

				
				if (!isset($this->req->data->password)){
					$this->_error('Form error', 'Password is not specified');
				}
				
				if (strlen(trim($this->req->data->password)) < 6){
					$this->_error('Form error', 'Password must be at least 6 characters long.');
				}
				
				/*
				if (!isset($this->req->data->mobile_country)){
					$this->_error('Form error', 'Country code for mobile number is not specified.');
				}
				
				if (!trim($this->req->data->mobile_country)){
					$this->_error('Form error', 'Country code for mobile number is invalid.');
				}
				*/
				
				if (!isset($this->req->data->mobile)){
					$this->_error('Form error', 'Mobile number is not specified.');
				}
				
				if (!is_numeric($this->req->data->mobile)){
					$this->_error('Form error', 'Mobile number is invalid.');				
				}
				
				if (strlen(trim($this->req->data->mobile)) < 10){
					$this->_error('Form error', 'Mobile number is invalid');
				}

				$res = $this->user->register($this->req->data);
				
				$this->_SMS($this->req->data->mobile, 'Thank you for registering with MaiBasuh! Please check your email for account verification. Have a nice day');
				
				
				$this->res->status 	= 'success';
				$this->res->authkey = $res->authkey;
			
				break;
			case 'logout':
				
				$this->db->update('users',array(
					'online_status'	=> NULL,
					'status_time'	=> date('Y-m-d H:i:s')
				), array(
					'id'		=> $this->userdata->id
				));
				
				$this->res->status 	= 'success';
			
				break;
				
			
				
			case 'fbauth':
			
				$query = $this->db->query("SELECT * FROM `users` WHERE `fbid` = ?", array($this->req->data->fbid));
				
				if (!$query->num_rows()){
					$res = $this->user->register($this->req->data);						
					$authkey = $res->authkey;
				} else {
					$user = $query->row();
					$authkey = $user->email . '#' . $user->key;
				}
				
								
				$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ?", array($this->req->data->email));
				$user = $query->row();
				
				$this->db->update('users',array(
					'online_status'	=> 'Online'
				), array(
					'id'		=> $user->id
				));
				
				$this->res->status 	= 'success';
				$this->res->authkey	= $authkey;
				$this->res->user	= $user;
					
				
				break;		
			case 'auth':
			
				if (!isset($this->req->data->email)){
					$this->_error('Auth error', 'Email is not specified.');
				}
				
				if (!isset($this->req->data->password)){
					$this->_error('Auth error', 'Password is not specified.');
				}
			
				
				$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ?", array($this->req->data->email));
				$user = $query->row();
				
				if (strtolower($user->password) == strtolower(sha1($this->req->data->password))){
					$this->res->status 	= 'success';
					
					if (!$user->key){
						$this->db->update('users', array(
							'key'	=> $authkey = sha1(time())
						), array(
							'id'	=> $user->id
						));
					} else {
						$authkey = $user->key;
					}
					
					$this->res->authkey	= $user->email . '#' . $authkey;
					$this->res->user 	= $user;
					
					$this->db->update('users',array(
						'online_status'	=> 'Online'
					), array(
						'id'		=> $user->id
					));

				} else {
					$this->_error('Auth error', 'Incorrect password.');
				}
				
				break;
			case 'pwdreset':
			
				if (!isset($this->req->data->email)){
					$this->_error('Reset error', 'Email is not specified.');
				}
				
				$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ?", array($this->req->data->email));
				if (!$query->num_rows()){
					$this->_error('Reset error', 'Account does not exist.');
				}
				
				$this->user->Request_password_reset($this->req->data->email);
				
				$this->res->status 	= 'success';
				$this->res->email	= $this->req->data->email;
				
			
				break;
			default:
			
				$this->_error('Invalid request', 'User request is invalid');
				
				break;
		}
		
		$this->_output();
	}
	
	function _parse_request(){
		if ($request = json_decode(file_get_contents('php://input'))){
			$this->req = $request;
			return true;
		} else {
			return false;
		}
		
	}
	function _exec_request(){
		$api_request = $this->req->request;
		list($module, $function) = explode('/', $api_request);
	
		if (method_exists($this, $module)){
			$this->{$module}($function);
		} else {
			$this->_error();
		}
		
	}
	
	function _require_auth(){

		if (in_array($this->req->request, $this->no_auth_request)) return false;
		
		return true;
	}
	
	function _check_auth(){
		if (!isset($this->req->authkey)){
			return false;
		}
		
		list($email, $key) = explode('#', $this->req->authkey);
		
		
		$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ? AND `key` = ?", array($email, $key));
		if (!$query->num_rows()){
			return false;
		}
		
		$this->userdata = $query->row();		
		return true;
		
	}
	
	function _output(){
		
		header('Content-Type: application/json');
	
		$this->res->request = $this->req->request;
		$this->res->datetime = date('Y-m-d\TH:i:sP');
		
		echo json_encode($this->res);
	}
	
	function _error($error, $reason, $code = null){
		
		header('Content-Type: application/json');
		
		$this->res->status = 'error';
		if (isset($this->req->request)){
			$this->res->request = $this->req->request;
		}
		$this->res->error = $error;
		$this->res->reason = $reason;
		$this->res->datetime = date('Y-m-d\TH:i:sP');
		
		echo json_encode($this->res);
		die();

	}
	
	function _throw($code, $header, $msg){
		switch ($code){
			case "403":
				header("HTTP/1.0 403 Forbidden");
				echo "<h1>{$header}</h1>";
				echo "<p>{$msg}</p>";
				echo "<hr />";
				echo date('Y-m-d\TH:i:sP');
				break;
		}

		die();
	}
	
}