<?php

class Ajax extends CI_Controller {
	
	
	public function Upload_image($project_id){
		$config['upload_path'] = 'uploads/profile';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			
			$data->filename = $filedata['file_name'];
						
			return ajax_submit_successful($data);
		} else {
			return ajax_submit_unsuccessful('Error uploading image.');
		}
	}



	function Notification($id){
		$query = $this->db->query("SELECT * FROM `notifications` WHERE `id` = ?", array($id));
		$notification = $query->row();
		
		$this->db->update('notifications',array(
			'seen'	=> 1
		),array(
			'id'	=> $id
		));
		
		redirect($notification->url);
	}

	function Get_notifications(){
		$query = $this->db->query("SELECT * FROM `notifications` WHERE `user_email` = ? AND `seen` IS NULL ORDER BY `id` DESC", array($this->user->data('email')));
		foreach ($query->result() as $notification){
			echo '<li href="ajax/notification/'.$notification->id.'" class="link notification-item notification-item-unseen unseen"><a href="ajax/notification/'.$notification->id.'" class="link">'.$notification->message.'</a></li>';
		}
		
		if ($query->num_rows() < 5){
			$query = $this->db->query("SELECT * FROM `notifications` WHERE `user_email` = ? AND `seen` IS NOT NULL ORDER BY `id` DESC", array($this->user->data('email')));			
			foreach ($query->result() as $notification){
				echo '<li href="ajax/notification/'.$notification->id.'" class="link notification-item"><a href="ajax/notification/'.$notification->id.'" class="link">'.$notification->message.'</a></li>';
			}
	
		}
	}

	
	function Clear_notifications(){
		$this->db->query("UPDATE `notifications` SET `seen` = 1, `seen_datetime` = ? WHERE `user_email` = ? AND `seen` = 0", array(date('Y-m-d H:i:s'), $this->user->userdata('email')));
	}

	function General($request, $opt){
	

		switch ($request){
			
			case "has_published_event":
			
				$this->user->update_data('has_published_event',1);
			
				break;
			case "get_events":
				$locality 		= $this->input->post('locality');
				$region 		= $this->input->post('region');
				$country		= $this->input->post('country');
				$page			= $this->input->post('page');
				
				if (!$page) $page = 1;
								
				$limit			= 16;
				$offset			= ($page - 1) * $limit;
				
				$sort_by		= $this->input->post('sort_by') == 'popular' ? 'attend_count' : 'event_start';
				$sponsor_only	= $this->input->post('sponsor_only');
				
				if ($sponsor_only){
					if ($locality || $region){
						$query = $this->db->query("SELECT * FROM `events` WHERE (`location_locality` = ? OR `location_region` = ? OR `location_locality` = ? OR `location_region` = ?) AND `location_country` = ? AND `status` = 'approved' AND LENGTH(`sponsors`) > 50 ORDER BY `{$sort_by}` DESC LIMIT $offset, $limit", array($locality, $region, $region, $locality, $country));					
					} else {
						$query = $this->db->query("SELECT * FROM `events` WHERE `status` = 'approved' AND LENGTH(`sponsors`) > 50 ORDER BY `{$sort_by}` DESC LIMIT $offset, $limit");	
					}
				} else {
					if ($locality || $region){
						$query = $this->db->query("SELECT * FROM `events` WHERE (`location_locality` = ? OR `location_region` = ? OR `location_locality` = ? OR `location_region` = ?) AND `location_country` = ? AND `status` = 'approved' ORDER BY `{$sort_by}` DESC LIMIT $offset, $limit", array($locality, $region, $region, $locality, $country));				
					} else {
						$query = $this->db->query("SELECT * FROM `events` WHERE `status` = 'approved' ORDER BY `{$sort_by}` DESC LIMIT $offset, $limit");				
					}
				}

				$data['events'] = $query->result();
				
				$this->load->view('ajax/events', $data);
			
				break;
		
			case "location_search":
			
				$q = $this->input->post('q');
				
				$query = $this->db->query("SELECT * FROM geoip_city_locations WHERE `city_name` LIKE ? OR `subdivision_name` LIKE ? LIMIT 20", array($q.'%', $q.'%'));
				$first = 1;
				foreach ($query->result() as $loc){
					if ($first){
						$current = 'current';
						$first = false;
					} else {
						$current = '';
					}
					echo "<li class=\"item {$current}\" city=\"{$loc->city_name}\" country=\"{$loc->country_name}\" subdivision=\"{$loc->subdivision_name}\">". ($loc->city_name ? $loc->city_name . ', ' : '') . ($loc->subdivision_name ? $loc->subdivision_name . ', ' : '') .  $loc->country_name . "</li>";
					
				}	
			
				break;
				
			case "get_chat_list":
			
				if (!$this->user->is_logged_in()) return;
				
				$user = $this->user->data();
				$query = $this->db->query("SELECT * FROM `messages` WHERE `from_email` = ? OR `to_email` = ? GROUP BY `chat_id` ORDER BY `id` DESC", array($user->email, $user->email));
				
				
				$list_data->me 		= $user->email;
				$list_data->my_id	= $user->id;
				
				foreach ($query->result() as $prep_list){
						if ($prep_list->from_email == $user->email) $chatter_email = $prep_list->to_email;
						else $chatter_email = $prep_list->from_email;
						
						$chatter = $this->user->email($chatter_email);
						$img = 'uploads/profile/' . $chatter->photo;

					
					$q = $this->db->query("SELECT * FROM `messages` WHERE `chat_id` = ? ORDER BY `id` DESC LIMIT 1", array($prep_list->chat_id));
					$lm = $q->row();
					
					$prep_list->firstname	= $chatter->firstname;
					$prep_list->lastname	= $chatter->lastname;
					$prep_list->img 		= _uimg($chatter,40,true);
					$prep_list->message		= truncate($lm->message, 15);
					$prep_list->seen		= $lm->seen;
					$prep_list->seen_time	= $lm->seen_time;
					$list[] = $prep_list;
				}
				
				$list_data->list 	= $list;
				echo json_encode($list_data);
			
				break;
				
			case "get_chat_by_chat_id":
			
				if (!$this->user->is_logged_in()) return;
				
				$chat_id = $this->input->post('cid');
				$last_id = $this->input->post('last_id');
				list($user_id1, $user_id2, $eid) = explode('-', $chat_id);
				
				if ($eid == 'undefined') $eid = false;
				
				$me					= $this->user->data();
				$chat_data->me 		= $me->email;
				
				$this->db->update('messages', array(
					'seen'			=> 1,
					'seen_time'		=> date('Y-m-d H:i:s')
				), "`seen` IS NULL AND `to_email` = ".$this->db->escape($chat_data->me)." AND `chat_id` = " . $this->db->escape($chat_id));
				
				

				if ($last_id){
					$query = $this->db->query("SELECT * FROM `messages` WHERE `chat_id` = ? AND `id` < ? ORDER BY `datetime` DESC LIMIT 20", array($chat_id, $last_id));
					$chat = array_reverse($query->result());
					
				} else {
					$query = $this->db->query("SELECT * FROM `messages` WHERE `chat_id` = ? ORDER BY `datetime` DESC LIMIT 20", array($chat_id));
					$chat = array_reverse($query->result());
					
				}
				

				
				$query = $this->db->query("SELECT firstname AS `name`, email, photo FROM `users` WHERE `id` = ?", array($user_id1));
				$user1 = $query->row();
				$user[$user1->email] 			= $user1;	
				$user[$user1->email]->pi_html 	= _uimg($user1, 40, true);					
			
				
				$query = $this->db->query("SELECT firstname AS `name`, email, photo FROM `users` WHERE `id` = ?", array($user_id2));
				$user2 = $query->row();
				$user[$user2->email] 			= $user2;
				$user[$user2->email]->pi_html 	= _uimg($user2, 40, true);


				$chat_data->user 	= $user;
				$chat_data->chat 	= $chat;
				
				
				if ($eid){
					if ($event->creator != $me->id){
						$chat_data->chatter = $event->name;						

					} else {
						if ($user1->email == $chat_data->me){
							$chat_data->chatter = $user2->name;
						} else {
							$chat_data->chatter = $user1->name;
						}
						$chat_data->event = $event->name;
					}

					if ($user1->email == $chat_data->me){
						//$user[$user2->email]->pi_html 	= _boximg('assets/events/'.$event->logo, 40, true);
					} else {
						$user[$user2->email]->pi_html 	= _uimg($user2, 40, true);
					}

				} else {				
					if ($user1->email == $chat_data->me){
						$chat_data->chatter = $user2->name;
					} else {
						$chat_data->chatter = $user1->name;
					}	
				}
				
				echo json_encode($chat_data);
			
				break;
				
		
			case "get_chat_by_user_id":
			
				if (!$this->user->is_logged_in()) return;
				
				$id = $this->input->post('uid');
				$me = $this->user->userdata();
				
				if ($me->id > $id){
					$chat_id = $id . '-' . $me->id;
				} else {
					$chat_id = $me->id . '-' . $id;
				}
				
				$query = $this->db->query("SELECT * FROM `messages` WHERE `chat_id` = ? ORDER BY `datetime` ASC", array($chat_id));
				$this->d['chat'] = $query->result();
				
				$this->load->view('ajax/chat-view', $this->d);
			
				break;
		
			case "send_user_chat":
			
				if (!$this->user->is_logged_in()) return;
				
				$id 		= $this->input->post('uid');
				$eid 		= $this->input->post('eid');
				$to_user 	= $this->user->id($id);
				$from_user 	= $this->user->data();
				
				if ($eid == 'undefined') $eid = false;
				
				if ($to_user->id > $from_user->id){
					$chat_id = $from_user->id . '-' . $to_user->id . ($eid ? '-' . $eid : '');
				} else {
					$chat_id = $to_user->id . '-' . $from_user->id . ($eid ? '-' . $eid : '');
				}
				
				$this->db->insert('messages', array(
					'from_email'	=> $from_user->email,
					'from_name'		=> $from_user->firstname . ' ' . $from_user->lastname,
					'to_email'		=> $to_user->email,
					'to_name'		=> $to_user->firstname . ' ' . $to_user->lastname,
					'event_id'		=> $eid,
					'sponsor_id'	=> '',
					'chat_id'		=> $chat_id,
					'message'		=> $message = $this->input->post('msg'),
					'datetime'		=> date('Y-m-d H:i:s')
				));
				

				/*
				$query = $this->db->query("SELECT * FROM `message_alerts` WHERE `date` = ? AND `sender_user_email` = ? AND `user_email` = ?", array(date('Y-m-d'), $from_user->email, $to_user->email));
				if (!$query->num_rows()){
					
					$this->db->insert('message_alerts', array(
						'sender_user_email'	=> $from_user->email,
						'user_email'		=> $to_user->email,
						'date'				=> date('Y-m-d')
					));

					$email_data_alert['user']		= $from_user;
					$email_data_alert['message']	= $message;
					$email_data_alert['url']		= base_url() . 'messenger' . $this->user->generate_access_key_string($to_user->email);
					
					$this->mailer->send($to_user->email, 'You have a message from ' . $from_user->name, $email_data_alert, 'message-alert');

				}
				*/

				
				
				break;
				
		
			case "get_chat_by_sponsor_id":
			
				if (!$this->user->is_logged_in()) return;
				
				$id = $opt;
				$query = $this->db->query("SELECT * FROM `messages` WHERE `sponsor_id` = ? ORDER BY `datetime` ASC", array($id));
				$this->d['chat'] = $query->result();
				
				$this->load->view('ajax/chat-view', $this->d);
			
				break;
				
			
				
			case "send_chat":
			
				if (!$this->user->is_logged_in()) return;
				
				$id = $opt;
				
				$sponsor = $this->event->get_sponsor_request_by_id($id);
				$event = $this->event->get_event_by_id($sponsor->event_id);
				
				$user = $this->user->userdata();
				if ($user->email == $sponsor->request_from) $to = $sponsor->request_to;
				else $to = $sponsor->request_from;
				
				$this->db->insert('messages', array(
					'from_email'	=> $user->email,
					'to_email'		=> $to,
					'event_id'		=> $event->id,
					'sponsor_id'	=> $opt,
					'message'		=> $this->input->post('msg'),
					'datetime'		=> date('Y-m-d H:i:s')
				));
				
				
				break;
				
			
			case "states":
				
				$country = $this->input->post('country');
				
				$query = $this->db->query("SELECT * FROM `states` WHERE `country` = ? ORDER BY `state` ASC", array($country));
				
				echo '<option>Select State/Province</option>';
				foreach ($query->result() as $state){
					echo '<option value="'.trim($state->state).'">'.trim($state->state).'</option>';
				}
			
				break;
				
			case "institution":
			
				$name = $this->input->post('name');
				
				$query = $this->db->query("SELECT * FROM `education` WHERE `name` LIKE ? LIMIT 30", array('%'.$name.'%'));
				foreach ($query->result() as $res){
					$edu[$res->name] = $res->name;
				}
				
			
			
				break;
		}
	}
	
	function User($request){
		if (!$this->user->is_logged_in()) return;
		
		switch ($request){
			case "upload_photo":
			
				ini_set('memory_limit', '128M');
		
				$config['upload_path'] 		= './assets/profile/';
			    $config['allowed_types'] 	= 'png|jpg|jpeg';
			    $config['max_size']			= '5120';
			    $config['encrypt_name']		= true;
	    
			    $this->load->library('upload');
			    $this->upload->initialize($config);
	    
			    $ok = true;
	    					
			    if ($this->upload->do_upload('photo')){
			    	$photo_data = $this->upload->data('photo');
			    	$photo = $photo_data['file_name'];
			    } else {
				    $err = 1;
			        $ok = false;
			    }
	    
			    $id = $this->user->userdata('id');
			    
			    if ($ok){
			    
			    	$this->load->library('image_lib');
			    
					$config['image_library'] 	= 'gd2';
					$config['source_image']		= './assets/profile/'.$photo;
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= TRUE;
					$config['new_image']		= './assets/thumbs/'.$photo;
					$config['width']	 		= 300;
					$config['height']			= 300;
					
					$this->load->library('image_lib', $config); 
					
					$this->image_lib->resize();
		
			    	$this->db->update('users', array(
			    		'profile_image' => $photo
			    	), "`id` = '$id'");
			    }
			    
	    
			    echo '<script language="javascript" type="text/javascript">window.top.window.readyPhoto("'.$photo.'", "'.$error.'");</script>';
	

			
			
				break;

		}
	}
	
	
	function Brand($request){
		if (!$this->user->is_logged_in()) return;
		
		switch ($request){
		
			case "end_tour":
				
				$user = $this->user->userdata();
				
				$userdata 	= json_decode($user->data);
				$userdata->tour_taken = 1;
				
				$this->db->update('users', array(
					'data'		=> json_encode($userdata)
				),"`id` = '{$user->id}'");
				
			
				break;
		
			case "save_profile_address":
			
				$user = $this->user->userdata();
				
				$address 	= $this->input->post('address');
				$userdata 	= json_decode($user->data);
				$userdata->address = $address;
				
				$this->db->update('users', array(
					'data'		=> json_encode($userdata),
					'country'	=> $this->input->post('country'),
					'state'		=> $this->input->post('state')
				),"`id` = '{$user->id}'");
				
				echo $userdata->address;
			
				break;
			
			case "save_profile_ci":
			
				$user = $this->user->userdata();
				
				$ci = $this->input->post('ci');
				$userdata = json_decode($user->data);
				$userdata->contact_info = $ci;
				
				$this->db->update('users', array(
					'data'	=> json_encode($userdata)
				),"`id` = '{$user->id}'");
				
				echo $userdata->contact_info;
			
				break;

			
			case "save_profile_description":
			
				$user = $this->user->userdata();
				
				$desc = $this->input->post('desc');
				$userdata = json_decode($user->data);
				$userdata->description = $desc;
				
				$this->db->update('users', array(
					'data'	=> json_encode($userdata)
				),"`id` = '{$user->id}'");
				
				echo $userdata->description;
			
				break;
			
			case "save_profile_budget":
			
				$user = $this->user->userdata();
				
				$budget = $this->input->post('budget');
				$userdata = json_decode($user->data);
				$userdata->budget = $budget;
				
				$this->db->update('users', array(
					'data'	=> json_encode($userdata)
				),"`id` = '{$user->id}'");
				
				echo $userdata->budget;
			
				break;
				
			
			case "save_profile_criteria":
			
				$user = $this->user->userdata();
				
				$criteria = $this->input->post('criteria');
				$userdata = json_decode($user->data);
				$userdata->criteria = $criteria;
				
				$this->db->update('users', array(
					'data'	=> json_encode($userdata)
				),"`id` = '{$user->id}'");
				
				echo $userdata->criteria;
			
				break;	
			
			case "upload_photo":
			
				ini_set('memory_limit', '128M');
		
				$config['upload_path'] 		= './assets/profile/';
			    $config['allowed_types'] 	= 'png|jpg|jpeg';
			    $config['max_size']			= '5120';
			    $config['encrypt_name']		= true;
	    
			    $this->load->library('upload');
			    $this->upload->initialize($config);
	    
			    $ok = true;
	    					
			    if ($this->upload->do_upload('photo')){
			    	$photo_data = $this->upload->data('photo');
			    	$photo = $photo_data['file_name'];
			    } else {
				    $err = 1;
			        $ok = false;
			    }
	    
			    $id = $this->user->userdata('id');
			    
			    if ($ok){
			    
			    	$this->load->library('image_lib');
			    
					$config['image_library'] 	= 'gd2';
					$config['source_image']		= './assets/profile/'.$photo;
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= TRUE;
					$config['new_image']		= './assets/thumbs/'.$photo;
					$config['width']	 		= 300;
					$config['height']			= 300;
					
					$this->load->library('image_lib', $config); 
					
					$this->image_lib->resize();
		
			    	$this->db->update('users', array(
			    		'profile_image' => $photo
			    	), "`id` = '$id'");
			    }
			    
	    
			    echo '<script language="javascript" type="text/javascript">window.top.window.readyPhoto("'.$photo.'", "'.$error.'");</script>';
	

			
			
				break;
			
		}
	}
	
	

	function search($type,$single=false){
		if ($single){

			$search = $this->input->post('q');
		}

		
		switch($type){
			case "education":

				$query = $this->db->query("SELECT `name` FROM `education` WHERE `name` LIKE '$search%'");
				$items = $query->result();
				
				foreach ($items as $item){
					$response[] = array($item->name, $item->name);
				}
			
				break;
				
				
		}
		
		header('Content-type: application/json');
		echo json_encode($response);

	}
	
	
}