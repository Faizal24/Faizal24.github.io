<?php
			
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {
	
	var $no_auth_request = array(
		'request_api_key',
		'user/signup',
		'user/auth',
		'user/fbauth',
		'user/pwdreset',
		'user/scan_code'
	);	

	var $req;	
	var $res;
	var $app;
	var $user;

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
		$this->_throw(403, 'Unauthorized', 'Authentication required');
	}
	
	function Request_api_key(){
		$return->api_version 	= $this->version;
		$return->server_time 	= date('Y-m-d H:i:s');
		$return->request		= 'request_api_key';
		
		$api_key = sha1(microtime().$this->req->platform.$this->req->version.mt_rand(1000,9999));
		
		// approve all api key request for now until the mechanism of approving API keys is figured out
		$status = 'ok';
		
		$this->db->insert('devices', array(
			'api_key'		=> $api_key,
			'platform'		=> $data->platform,
			'version'		=> $data->version,
			'datetime'		=> date('Y-m-d H:i:s')
		));
		
		
		if ($status == 'ok'){
			$return->status		= $status;
			$return->key		= $api_key;
		} else {
			$return->status		= $status;
		}
		
		echo json_encode($return);
	}
	
	
	public function Tutor($request){
		
		switch ($request){
			
			// READ WRITE requests
			
			case "login":
			
			break;
			
			case "sign_up":
			
			break;
			
			case "password_reset_request":
			
			break;
			
			case "update_profile":
			
			break;
			
			case "submit_assessment":
			
			
			break;
			
			// READ ONLY requests
			case "profile":
			
			break;
			
			case "assessment":
			
			break;
			
			case "assessment_result":
			
			break;
			
			case "schedule":
			
			
			break;
			
			
			
		}
		
	}
	
	public function Parent($request){
		
		switch ($request){
			
			// READ WRITE request 			
			
			case "sign_up":
			
			break;
			
			case "login":
			
			break;
			
			case "password_reset_request":
			
			break;
			
			case "update_profile":
			
			break;
			
			// READ ONLY request
			
			case "profile":
			
			break;
			
		}
		
		
	}
	
	public function Hire($request){
		
		switch ($request){
			
			// READ ONLY request
			case "search":
			
			break;
			
			case "payment_status":
			
			break;
			
			case "pending_orders":
			
			break;
			
			// READ WRITE request 
			
			case "request":
			
			break;
			
			case "accept":
			
			break;
			
			case "decline":
			
			break;
			
			
		}
	}
	
	public function Review($request){
		
		switch ($request){
			
			// READ ONLY request 
			
			case "tutor":
			
			break;
			
			case "submit":
			
			break;
			
			
		}
	}
	
	function Mytutor($request){
		switch ($request){
			
			case "get_content_about":
			
				$this->res->status 	= 'success';
				$this->res->about 	= $this->system->config('announcements');
			
			break;
			
			case "subscribe_package":
			
				$query = $this->db->query("SELECT * FROM `subscription_packages` WHERE `id` = ?", array($this->req->data->subscription_id));
				$sub = $query->row();

				$expiry = date('Y-m-d', time() + ($sub->months * 30.5 * 24 * 60 * 60));

				
				$this->db->insert('user_subscriptions', array(
					'user_id'			=> $this->userdata->id,
					'package_id'		=> $sub->package_id,
					'subscription_id'	=> $sub->id,
					'wash_count'		=> $sub->wash_count,
					'used'				=> 0,
					'expired_on'		=> $expiry,
					'subscribed_on'		=> date('Y-m-d')
				));
				
				
				$this->res->status = 'success';
				$this->res->purchase_id = $this->db->insert_id();
				
			break;
			
			case "check_payment":
					
				$order_id = $this->req->data->order_id;
				
				if ($order_id[0] == 'P'){
					$query = $this->db->query("SELECT * FROM `user_subscriptions` WHERE `id` = ?", array(str_replace('P','',$order_id)));
					
					$this->res->status = 'pending';
					
					if ($query->num_rows()){
						$order = $query->row();
						
						if ($order->status == 1){
							$this->res->status = 'success';
							
							
							$query = $this->db->query("SELECT * FROM `subscription_packages` WHERE `id` = ?", array($order->subscription_id));
							$package = $query->row();

							

							// Create invoice 
							$this->db->insert('invoices', array(
								'order_id'	=> $order_id,
								'datetime'	=> date('Y-m-d H:i:s'),
								'user_id'	=> $order->user_id,
								'amount'	=> $package->price,
								'tax'		=> $package->price * 6 / 106
							));
							
							$invoice_id = $this->db->insert_id();
								
								
							$this->mailer->send($this->userdata->email, "Your Tax Invoice from MaiBasuh", 'invoice', array(
								'user'		=> $this->userdata,
								'date'		=> date('Y-m-d'),
								'order_id'	=> $order->id,
								'invoice_id'=> $invoice_id,
								'item_name'	=> $package->name . ' ('.$package->wash_count.' Wash Count)',
								'item_price'=> $package->price
							));
							
							
							
						}
						
						if ($order->status == 2){
							$this->db->update('orders', array(
								'hold'		=> null
							), array(
								'id'		=> $order_id
							));
							
							$this->res->status = 'cancelled';
							
						}
					} else {
						$this->res->status = 'error';
					}

					
				} else {
				
					$query = $this->db->query("SELECT * FROM `orders` WHERE `id` = ?", array($order_id));
					
					$this->res->status = 'pending';
					
					if ($query->num_rows()){
						$order = $query->row();
						
						if ($order->status == 'Pending'){
							$this->res->status = 'success';
						}
						
						if ($order->status == 'Hold' && $order->hold){
							$this->db->update('orders', array(
								'hold'		=> null
							), array(
								'id'		=> $order_id
							));
							
							$this->res->status = 'cancelled';
							
						} else {
							
							
							if ($this->res->status == 'success'){
								$query = $this->db->query("SELECT * FROM `orders` WHERE `id` = ?", array($order_id));
								$order = $query->row();
								
								if (!$order->confirmation_sent){
									$this->mailer->send($this->userdata->email, "MaiBasuh Order Confirmation #{$order_id}", 'confirmation', array(
										'name'		=> $this->userdata->name,
										'order'		=> $order,
										'payable'	=> $order->payable
									));
								
									$this->db->update('orders', array(
										'confirmation_sent'	=> 1
									), array(
										'id'		=> $order_id
									));
								}
								
							}
							
							
						}
					} else {
						$this->res->status = 'error';
					}
				
				}
			
			break;
			
			case "cancel_job":
		
				
				$this->db->update('orders', array(
					'status'		=> 'Cancelled'
				), array(
					'id'			=> $this->req->data->order_id
				));
				
				$this->res->status 		= 'success';
				$this->res->job_id		= $this->req->data->order_id;

			break;
			
			
			case "submit_review":
			
				$this->db->update('orders', array(
					'comments'		=> $this->req->data->comments,
					'reviewed'		=> 1,
					'reviewed_on'	=> date('Y-m-d H:i:s'),
					'rating'		=> $this->req->data->rating
				), array(
					'id'			=> $this->req->data->id
				));

				$this->res->status 		= 'success';
				$this->res->reviewed_on = date('Y-m-d H:i:s');
			
			break;
			
			case "subscription_packages": 
				$query = $this->db->query("SELECT subscription_packages.*, packages.type AS `vehicle_type`, packages.description AS `description` FROM `subscription_packages` LEFT JOIN `packages` ON packages.id = subscription_packages.package_id ORDER BY `id` ASC");
				$this->res->status = 'success';
				$this->res->packages = $query->result();
				$this->res->user_id = $this->userdata->id;
			
			break;
			
			case "user_subscriptions":
				$query = $this->db->query("SELECT user_subscriptions.*, subscription_packages.name AS `package_name`, IF(`expired_on` > ?, 'Active','Expired') AS `status` FROM `user_subscriptions` LEFT JOIN subscription_packages ON subscription_packages.id = user_subscriptions.subscription_id WHERE `user_id` = ? AND user_subscriptions.status = 1 ORDER BY user_subscriptions.expired_on DESC", array(date('Y-m-d'), $this->userdata->id));
				
				$this->res->status = 'success';
				$this->res->subscriptions = $query->result();
				$this->res->user_id = $this->userdata->id;
			break;
			
			case "jobs":
			
				if ($this->req->archived == 1){
					$query = $this->db->query("SELECT orders.*, users.name AS `customer_name`, users.mobile AS `customer_mobile`, DATE_FORMAT(orders.appointment_date, '%e %b') AS `appointment_date_formatted`, DATE_FORMAT(orders.appointment_time, '%h:%i%p') AS `appointment_time_formatted` FROM `orders` LEFT JOIN `users` ON orders.user_id = users.id  WHERE (`status` != 'In Progress' AND `status` != 'Pending' AND `status` != 'Hold') AND `assigned_to` = ? ORDER BY `appointment_date` ASC, `appointment_time` ASC LIMIT 105", array($this->userdata->id));					
				} else {
					$query = $this->db->query("SELECT orders.*, users.name AS `customer_name`, users.mobile AS `customer_mobile`, DATE_FORMAT(orders.appointment_date, '%e %b') AS `appointment_date_formatted`, DATE_FORMAT(orders.appointment_time, '%h:%i%p') AS `appointment_time_formatted` FROM `orders` LEFT JOIN `users` ON orders.user_id = users.id  WHERE (`status` = 'In Progress' OR `status` = 'Pending') AND `assigned_to` = ? ORDER BY `appointment_date` ASC, `appointment_time` ASC", array($this->userdata->id));
				}
				$this->res->status = 'success';
				$this->res->jobs = $query->result();
				$this->res->user_id = $this->userdata->id;
				
			break;
			
			case "job_details":
			
				$query = $this->db->query("SELECT * FROM `order_logs` WHERE `order_id` = ? GROUP BY `task` ORDER BY `id` ASC ", array($this->req->data->update_id));
				
				$this->res->status = 'success';
				$this->res->details = $query->result();
				$this->res->cdnurl = base_url() . 'assets/';

			
			break;
			
			case "updates":
				$query = $this->db->query("SELECT orders.*, users.name AS `detailer_name` FROM `orders` LEFT JOIN `users` ON orders.assigned_to = users.id WHERE `user_id` = ? AND (`status` = 'Pending' OR `status` = 'In Progress' OR (`status` = 'Completed') OR `status` = 'Cancelled') ORDER BY orders.id DESC", array($this->userdata->id));
				
				
				foreach ($query->result() as $update){
					$update->formatted_date = date('j F', strtotime($update->appointment_date));
					$update->formatted_time = date('g:iA', strtotime($update->appointment_time));
					$updates[] = $update;
				}
				$this->res->updates = $updates;
				$this->res->status = 'success';
				$this->res->cdnurl = base_url() . 'assets/';

			break;
			
			case "update_details":
				$query = $this->db->query("SELECT * FROM `order_logs` WHERE `order_id` = ? GROUP BY `task` ORDER BY `id` ASC ", array($this->req->data->update_id));
				$this->res->status = 'success';
				$this->res->details = $query->result();
				$this->res->cdnurl = base_url() . 'assets/';
			break;
			
			case "history":
				$query = $this->db->query("SELECT * FROM `orders` WHERE `user_id` = ? ORDER BY `id` DESC", array($this->userdata->id));
				$history = $query->result();
				
				$this->res->status = 'success';
				$this->res->history= $history;
				
			break;
			
			
			case "history_details":
				$query = $this->db->query("SELECT * FROM `orders` WHERE `id` = ?", array($this->req->data->history_id));
				$history = $query->row();
				
				$this->res->status = 'success';
				$this->res->history= $history;
			
			break;
			
			case "confirm_schedule":
			
				$query = $this->db->query("SELECT * FROM `user_vehicles` WHERE `id` = ?", array($this->req->data->vehicle_id));
				$vehicle = $query->row();
				
				$query = $this->db->query("SELECT * FROM `packages` WHERE `id` = ?", array($this->req->data->package_id));
				$package = $query->row();

				$query = $this->db->query("SELECT SUM(`wash_count`) AS `total_count`, SUM(`used`) AS `total_used` FROM `user_subscriptions` WHERE `package_id` = ? AND `expired_on` > ? AND `user_id` = ?", array($this->req->data->package_id, date('Y-m-d'), $this->userdata->id));
				if ($query->num_rows()){
					$subscription = $query->row();
					
					if ($subscription->total_count - $subscription->total_used > 0){
						$payable = 0;
						$free = true;
					}
					
				} 
				
				if (!$free){	
					$payable = $package->rate;
				}
				
				if ($payable > 0){
					$status = 'Hold';
				} else {
					$status = 'Pending';
				}
				
				list($lat,$lng) = explode(',',$this->req->data->latlng);
				
				$validate_passed = true;
				
				
				
				// Validate location
				
				$geocode_data = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$this->req->data->latlng);
				
				
				if ($geocode_data){
					$geocode_component = json_decode($geocode_data);
					foreach ($geocode_component->results[0]->address_components as $component){
						if ($component->types[0] == 'postal_code'){
							$zipcode = $component->short_name;
						}
						if (in_array('country',$component->types)){
							$country = $component->long_name;
						}
					}

					
				} else {
					$address_block = explode(',', $this->req->data->address);
					$zip_city_block = explode(' ', trim($address_block[count($address_block)-3]));
					
					$zipcode 		= trim($zip_city_block[0]);
					unset($zip_city_block[0]);
					$city 			= implode(' ', trim($zip_city_block));
					$country 		= trim($address_block[count($address_block)-1]);
					$state_province = trim($address_block[count($address_block)-2]);
					
				}
				
				$query = $this->db->query("SELECT * FROM `service_area` WHERE `country` = ? AND `zipcode_start` <= ? AND `zipcode_end` >= ?", array($country, $zipcode, $zipcode));
				if (!$query->num_rows()){
					
					$validate_passed = false;
					
					$this->db->insert('failed_orders', array(
						'user_id'		=> $this->userdata->id,
						'datetime'		=> date('Y-m-d H:i:s'),
						'reason'		=> 'Out of coverage',
						'data'			=> json_encode($this->req->data),
						'single_data'	=> $zipcode,
						'single_data2'	=> $country,
						'single_data3'	=> $geocode_data
					));
					
					$this->_error('Out of Coverage', 'Oops, our service will be available in this area soon. Please stay tuned.');
				}
				
				
				
				
				// Validate working hours
				if (strtotime($this->req->data->appointment_time) > strtotime($this->system->config('working_hours_end')) || strtotime($this->req->data->appointment_time) < strtotime($this->system->config('working_hours_start'))){
					
					
					$validate_passed = false;
					
					$this->db->insert('failed_orders', array(
						'user_id'		=> $this->userdata->id,
						'datetime'		=> date('Y-m-d H:i:s'),
						'reason'		=> 'Out of hours',
						'data'			=> json_encode($this->req->data),
						'single_data'	=> $this->req->data->appointment_time
					));
					
					$this->_error('Out of Hours','We are sorry, our service is not available on your desired appointment time. Please select another preferred time.' );
	
				}
				
				$daily_limit = $this->system->config('detailer_daily_limit');
				
				
				
				
				// Validate detailer availability and wash limits
				$query = $this->db->query("SELECT * FROM `users` WHERE `type` = 'Detailer' ORDER BY RAND()");
				foreach ($query->result() as $d){
					$query = $this->db->query("SELECT COUNT(`id`) AS `total_orders`, group_concat(orders.appointment_time) AS `hours` FROM `orders` WHERE `assigned_to` = ? AND `appointment_date` = ?", array($detailer->id, date('Y-m-d')));
					$res = $query->row();

							
					$d->total_orders 	= $res->total_orders;
					$d->hours			= $res->hours;
					
					$unsorted_detailers[] = $d;
				}
				
				usort($unsorted_detailers, function($a, $b){
					return $a->total_hours - $b->total_hours;
				});
				
				foreach ($unsorted_detailers as $detailer){
					$hours = explode(',', $detailer->hours);
					
					$fit_schedule = true;
					
					
					if ($fit_schedule){
						if ($detailer->total_orders < $daily_limit){
							$selected_detailer = $detailer;
						}
					}
				}

				
				if (!$selected_detailer){
					
					$validate_passed = false;
					
					$this->db->insert('failed_orders', array(
						'user_id'		=> $this->userdata->id,
						'datetime'		=> date('Y-m-d H:i:s'),
						'reason'		=> 'Out of hours',
						'data'			=> json_encode($this->req->data),
						'single_data'	=> $this->req->data->appointment_time
					));

					$this->_error('Detailer Unavailable','We are sorry, our detailers are fully occupied on your desired appointment time. Please another preferred time.');
				}
				
				
				if ($validate_passed){
					
					$this->db->insert('orders',array(
						'lat'				=> $lat,
						'lng'				=> $lng,
						'datetime'			=> date('Y-m-d H:i:s'),
						'address'			=> $this->req->data->address,
						'location'			=> $this->req->data->location,
						'status'			=> $status,
						'package_id'		=> $this->req->data->package_id,
						'vehicle_plate_no'	=> $vehicle->plate_no,
						'vehicle_type'		=> $vehicle->type,
						'vehicle_model'		=> $vehicle->model,
						'appointment_date'	=> $this->req->data->appointment_date,
						'appointment_time'	=> $this->req->data->appointment_time,
						'user_id'			=> $this->userdata->id,
						'assigned_to'		=> $detailer->id,
						'tasks'				=> $package->description,
						'payable'			=> $payable
					));
					
					$order_id = $this->db->insert_id();
					
					
					$this->db->insert('order_logs', array(
						'order_id'		=> $order_id,
						'datetime'		=> date('Y-m-d H:i:s'),
						'task'			=> 'Arrive at Location',
						'status'		=> 'Pending'
					));
	
					
					foreach (explode(',', $package->description) as $task){
						$this->db->insert('order_logs', array(
							'order_id'		=> $order_id,
							'datetime'		=> date('Y-m-d H:i:s'),
							'task'			=> trim($task),
							'status'		=> 'Pending'
						));
					}
					
					$this->db->insert('order_logs', array(
						'order_id'		=> $order_id,
						'datetime'		=> date('Y-m-d H:i:s'),
						'task'			=> 'Completed',
						'status'		=> 'Pending'
					));
					
					// Send confirmation email
					
					
					
					$this->res->status 			= 'success';
					$this->res->payable			= (float) $payable;
					$this->res->package_id		= $this->req->data->package_id;
					$this->res->vehicle_id		= $this->req->data->vehicle_id;
					$this->res->appointment_time= $this->req->data->appointment_time;
					$this->res->location		= $this->req->data->location;
					$this->res->address			= $this->req->data->address;
					$this->res->latlng			= $this->req->data->latlng;
					$this->res->detailer_name	= $detailer->name;
					$this->res->order_id		= $order_id;
					
					
					$query = $this->db->query("SELECT * FROM `orders` WHERE `id` = ?", array($order_id));
					$order = $query->row();
					
					if ($payable == 0){
						$this->mailer->send($this->userdata->email, "MaiBasuh Order Confirmation #{$order_id}", 'confirmation', array(
							'name'		=> $this->userdata->name,
							'order'		=> $order,
							'payable'	=> $payable
						));
					}
				
				}
			
			break;
			
			case "packages":
				$query = $this->db->query("SELECT * FROM `packages`");
				
				foreach ($query->result() as $package){
					$query = $this->db->query("SELECT SUM(`wash_count`-`used`) AS `count` FROM `user_subscriptions` WHERE `user_id` = ? AND `package_id` = ? AND `expired_on` > ?", array($this->userdata->id, $package->id, date('Y-m-d H:i:s')));
					if ($query->num_rows()){
						$sub = $query->row();
						$package->count = $sub->count ?  $sub->count . ' LEFT' : '';
					}
					$packages[] = $package;
				}
				
				$this->res->status 	= 'success';
				$this->res->packages= $packages;
				
			break;
			
			case "delete_vehicle":
			
				$this->db->query("DELETE FROM `user_vehicles` WHERE `id` = ?", array($this->req->data->vehicle_id));
				
				$query = $this->db->query("SELECT * FROM `user_vehicles` WHERE `user_id` = ?", array($this->userdata->id));
				$vehicles = $query->result();
				
				$this->res->status 	= 'success';
				$this->res->vehicles= $vehicles;
				
			break;
			
			case "add_vehicle":
				$query = $this->db->insert('user_vehicles', array(
					'plate_no'	=> $this->req->data->plate_no,
					'model'		=> $this->req->data->model,
					'type'		=> $this->req->data->type,
					'user_id'	=> $this->userdata->id
				));
				
				$query = $this->db->query("SELECT * FROM `user_vehicles` WHERE `user_id` = ?", array($this->userdata->id));
				$vehicles = $query->result();
				
				$this->res->status 	= 'success';
				$this->res->vehicles= $vehicles;
			break;
			
			case "user_vehicles":
			
				$query = $this->db->query("SELECT * FROM `user_vehicles` WHERE `user_id` = ?", array($this->userdata->id));
				$vehicles = $query->result();
				
				$this->res->status 	= 'success';
				$this->res->vehicles= $vehicles;

			break;
			
			
		}
		
		$this->_output();
	}
		
	function User($request){
		switch ($request){
			
			
			
			case "scan_code":
			
				list($mb,$hash,$user_id) = explode('-',$this->req->data->code);
				$query = $this->db->query("SELECT * FROM `users` WHERE `id` = ?",array($user_id));
				$user = $query->row();
				
				if (sha1($user->id) == $hash){
					$this->res->status	= 'success';
					$this->res->authkey	= $user->email . '#' . $user->key;
				} else {
					$this->_error('Invalid QR Code','We could not find any associated membership with your account.' . $this->req->data->code);
					return;
				}
				
				
			break;
			case "update":
			
				$this->db->update('users', array(
					'name'		=> $this->req->data->name,
					'mobile'	=> $this->req->data->mobile,
					'nric'		=> $this->req->data->nric,
					'type'		=> $this->req->data->type
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
				
				$this->user->complete_profile($this->req->data, $this->userdata->id);
				
				$this->_SMS($this->req->data->mobile, 'Thank you for registering with MaiBasuh! Please check your email for account verification. Have a nice day!');
				
				$this->res->status 	= 'success';
				$this->res->authkey = $this->userdata->email . '#' . $this->userdata->key;
			
				break;
			
			case 'signup':
			

			
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
				
			case 'update_location':

				$this->db->update('users',array(
					'lat'	=> $this->req->data->lat,
					'lng'	=> $this->req->data->lng
				),array(
					'id'	=> $this->userdata->id
				));
				
				$this->res->status = 'success';
							
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
					$this->res->authkey	= $user->email . '#' . $user->key;
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
	
	
	function _SMS($no,$msg){
		
		# if ($_SERVER['SERVER_NAME'] == 'localhost') return;
		
		if ($no[0] == 1){
			$no = '60'.$no;
		} elseif ($no[0] == 0) {
			$no = '6'.$no;
		} elseif ($no[0] == '6' && $no[1] == '0'){
			$no = $no;
		} else {
			$no = '';
		}
		
		if ($no){
			$un = 'maibasuh services';
			$pwd = 'maibasuh123';
			$req = 'https://www.isms.com.my/isms_send.php?un='.urlencode($un).'&pwd='.$pwd.'&dstno='.$no.'&msg='.urlencode($msg).'&type=1&sendid=62300';
			$res = file_get_contents($req); 	
			
			 
		}
		
	}
}
