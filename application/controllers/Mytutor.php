<?php
	
class  Mytutor extends CI_Controller {
	
	function Index(){
		
		$this->d['requests'] = $requests = $this->job->get_requests(array('from' => $this->user->data('email')));
		
		
		$this->load->view('common/header', $this->d);
		$this->load->view('mytutor/index', $this->d);
		$this->load->view('common/footer', $this->d);
		
	}
	
	function Details($id){
		
		
		$this->d['request'] 		= $request = $this->job->get_request($id);
		$user 						= $this->user->email($request->request_to);
		$this->d['tutor'] 			= $tutor = $this->user->tutor($user->id);
		$this->d['request_data']	= json_decode($request->request_data);
		$this->d['sessions'] 		= $this->job->get_sessions($request->id);
		
		
		$this->load->view('common/header', $this->d);
		$this->load->view('mytutor/details', $this->d);
		$this->load->view('common/footer', $this->d);
	
	}
	
	function Suggest_to_friends($id){
		
		
		$user 						= $this->user->id($id);
		$this->d['tutor'] 			= $tutor = $this->user->tutor($user->id);
		
		$this->load->view('common/header', $this->d);
		$this->load->view('mytutor/suggest', $this->d);
		$this->load->view('common/footer', $this->d);

		
	}
	
	function Checkout($id){
		
		$this->d['request'] 		= $request = $this->job->get_request($id);
		$user 						= $this->user->email($request->request_to);
		$this->d['tutor'] 			= $tutor = $this->user->tutor($user->id);
		$this->d['request_data']	= $request_data = json_decode($request->request_data);
		
		$select_daytime = array(''=>'Select Day/Time');
		
		foreach ($this->job->Get_possible_booking_daytimes(round($request_data->hours), $tutor) as $d){
			$select_daytime[$d] = $d;
		}
		$this->d['daytimes'] = $select_daytime;
		
		$this->load->view('common/header', $this->d);
		$this->load->view('mytutor/checkout', $this->d);
		$this->load->view('common/footer', $this->d);

		
	}
	
	function Process_checkout($id){
		
		$request 		= $this->job->get_request($id);
		$request_data 	= json_decode($request->request_data);
		$user 			= $this->user->email($request->request_to);
		$tutor 			= $this->user->tutor($user->id);
		
		$possible_daytimes = $this->job->Get_possible_booking_daytimes(round($request_data->hours), $tutor);
		// check daytimes;
		
		
		$ok = true;
		

		if (!$possible_daytimes[$this->input->post('day')]){
			$ok = false;
			$this->session->set_flashdata('checkout_error','Unfortunately the date and time has become unavailable.');
						
		}
		
		if (!$this->input->post('day')){
			$ok = false;
			$this->session->set_flashdata('checkout_error','Please select day and time of tutoring.');
		}
		
		
		if ($ok){
			
			if ($this->input->post('submit')){
				
				
				$query = $this->db->query("SELECT * FROM `job_orders` WHERE `job_request_id` = ?", array($id));
				
				if (!$query->num_rows()){
				
					$this->db->insert('job_orders', array(
						'job_request_id'		=> $id,
						'status'				=> 'Pending',
						'payment_status'		=> 'Unpaid',
						'datetime'				=> date('Y-m-d H:i:s'),
						'amount_payable'		=> '',
						'amount_tax'			=> '',
						'amount_commission'		=> '',
						'message'				=> $this->input->post('message')
					));
					
					$job_order_id = $this->db->insert_id();
				
				} else {
					
					$job_order = $query->row();
					
					$this->db->update('job_orders', array(
						'job_request_id'		=> $id,
						'status'				=> 'Pending',
						'payment_status'		=> 'Unpaid',
						'payment_gateway'		=> $this->input->post('payment_method'),
						'datetime'				=> date('Y-m-d H:i:s'),
						'amount_payable'		=> '',
						'amount_tax'			=> '',
						'amount_commission'		=> '',
						'message'				=> $this->input->post('message')
					), array(
						'id'					=> $job_order->id
					));
					
					$job_order_id = $job_order->id;
					
				}
				
				
				$this->db->query("DELETE FROM `tutor_sessions` WHERE `job_order_id` = ?", array($job_order_id));
				
				foreach (explode(',', $this->input->post('session_dates')) as $session_date){
					$this->db->insert('tutor_sessions', array(
						'job_order_id'		=> $job_order_id,
						'job_request_id'	=> $id,
						'user_email'		=> $request->request_to,
						'date'				=> $session_date,
						'time'				=> date('H:i:s', strtotime($this->input->post('session_time'))),
						'duration'			=> $request_data->hours,
						'status'			=> 'Scheduled'
					));
				}
				
				switch ($this->input->post('payment_method')){
					
					case "test_successful":
						
						
						$check = sha1('success'.$id);
						
						redirect('mytutor/payment_callback/test_successful?id='.$id.'&c='.$check);
					
					break;
					
					case "test_unsuccessful":
					
						$check = sha1('failed'.$id);
					
						redirect('mytutor/payment_callback/test_unsuccessful?id='.$id.'&c='.$check);					
					
					break;
					
					
					case "billplz":
					
					
					break;
					
				}
				
				
			}
		
		} else {
			redirect('mytutor/checkout/'.$id);
		}
	}
	
	function Payment_callback($gateway){
		
		switch ($gateway){
			
			case "test_unsuccessful":
				$ok = false;
				$id = $_REQUEST['id'];
				
			break;
			
			case "test_successful":

				$ok = true;
				$id = $_REQUEST['id'];
				
				
			break;
			
			case "billplz":
			
			break;
		}
		
		
		if ($ok){
			
			$query = $this->db->query("SELECT * FROM `job_requests` WHERE `id` = ?", array($id));
			$request = $query->row();
			
			$query = $this->db->query("SELECT * FROM `job_orders` WHERE `job_request_id` = ?", array($id));
			$job_order = $query->row();
			
			if ($request->status != 'Hired'){

				$user = $this->user->email($request->from);
				$tutor = $this->user->email($request->to);			

				$this->db->update('job_requests', array(
					'status'	=> 'Hired'
				), array(
					'id'		=> $id
				));
				
				$this->db->insert('notifications', array(
					'user_email'=> $tutor->email,
					'message'	=> '<strong>'. $user->firstname . ' ' . $user->lastname . '</strong> has hired you',
					'url'		=> "tutor/request_details/{$id}",
					'from_user'	=> $user->email,
					'datetime'	=> date('Y-m-d H:i:s')
				));
				
			
			}
			
			
			
			redirect('mytutor/hired/'.$job_order->id);
			
		} else {
			
			$this->session->set_flashdata('checkout_error','Checkout was not complete due to unsuccessful payment.');
			
			redirect('mytutor/checkout/'.$job_order->id);
		}
	}
	
	function Hired($job_order_id){
		
		$this->d['order'] = $order = $this->job->get_order($job_order_id);
		
		$this->d['request'] 		= $request = $this->job->get_request($order->job_request_id);
		$user 						= $this->user->email($request->request_to);
		$this->d['tutor'] 			= $tutor = $this->user->tutor($user->id);
		$this->d['request_data']	= json_decode($request->request_data);
		$this->d['sessions'] 		= $this->job->get_sessions($request->id);
		
		$this->load->view('common/header', $this->d);
		$this->load->view('mytutor/hired', $this->d);
		$this->load->view('common/footer', $this->d);

	}
	
	function Review($id,$req_id){
		
		
		$user 						= $this->user->id($id);
		$this->d['tutor'] 			= $tutor = $this->user->tutor($user->id);
		$this->d['req_id']			= $req_id;

		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `request_from` = ? AND `request_to` = ? AND `status` = 'Hired'", array($this->user->data('email'), $tutor->email));
		if (!$query->num_rows()){
			redirect();
		}
		
		
		$query = $this->db->query("SELECT * FROM `reviews` WHERE `user_email` = ? AND `tutor_email` = ?", array($this->user->data('email'), $tutor->email));
		
		if ($query->num_rows()){
			
			$this->d['review'] = $query->row();
			
			$this->load->view('common/header', $this->d);
			$this->load->view('mytutor/review', $this->d);
			$this->load->view('common/footer', $this->d);

			
		} else {
		
			if ($this->input->post('submit')){
				
				$rating = $this->input->post('rating');
				
				if (!$rating){
					$error['rating'] = 'Please select a rating';
				} else {
				
					if ($rating < 1 || $rating > 5){
						$error['rating'] = 'Invalid rating';
					}
				}
				
				
				if (!count($error)){
				
					$this->db->insert('reviews', array(
						'tutor_email'		=> $tutor->email,
						'user_email'		=> $this->user->data('email'),
						'review'			=> $this->input->post('review'),
						'rating'			=> $this->input->post('rating'),
						'datetime'			=> date('Y-m-d H:i:s')
					));
					
					$review_count = $tutor->review_count + 1;
					$review_rating = (($tutor->review_rating * $tutor->review_count) + $this->input->post('rating')) / $review_count;
					
					$this->db->update('users', array(
						'review_count'	=> $review_count,
						'review_rating' => $review_rating
					), array(
						'id'			=> $tutor->id
					));
					
					$review_id = $this->db->insert_id();
					
					$this->session->set_flashdata('review_submitted',true);
					
					
					$this->db->insert('notifications', array(
						'user_email'=> $tutor->email,
						'message'	=> '<strong>'. $this->user->data('firstname') . ' ' . $this->user->data('lastname') . '</strong> has submitted a review on you',
						'url'		=> "tutor/review/{$review_id}",
						'from_user'	=> $this->user->data('email'),
						'datetime'	=> date('Y-m-d H:i:s')
					));

					
					redirect('mytutor/review/'.$id.'/'.$req_id);
					
					
				
				}
				
				$this->d['error'] = $error;
			}
	
			
			$this->load->view('common/header', $this->d);
			$this->load->view('mytutor/review', $this->d);
			$this->load->view('common/footer', $this->d);
			

		
		}
		
	}
	
	
}