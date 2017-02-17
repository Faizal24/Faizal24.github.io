<?php
	
class Job extends CI_Model {
	
	function Get_blocked_daytime($email){
		$shortdayname = array('Monday'=>'Mon','Tuesday'=>'Tue','Wednesday'=>'Wed','Thursday'=>'Thu','Friday'=>'Fri','Saturday'=>'Sat','Sunday'=>'Sun');
		$today = date('Y-m-d');

	
		$query = $this->db->query("SELECT CONCAT(DAYNAME(`date`),' - ', HOUR(`time`), ' - ', `duration`, ' - ', `job_request_id`) AS `day_string` FROM `tutor_sessions` 
				WHERE `user_email` = ?
				AND `date` >= ?
				GROUP BY CONCAT(DAYNAME(`date`),HOUR(`time`))", array($email, $today));

		foreach ($query->result() as $b){
			list($day,$hour,$duration, $request_id) = explode(' - ', $b->day_string);
			for ($i = 0; $i < $duration; $i++){
				$blocked[$shortdayname[$day]][$hour+$i] = $request_id;
			}
		}
		
		return $blocked;
	}
	
	function Check_possible_session($daytimes, $hours, $tutor){
		
		$blocked = $this->Get_blocked_daytime($tutor->email);
		
		$availability = explode(',', $tutor->availability);
		foreach ($availability as $a){
			list($day,$moment,$time) = explode(' - ', $a);
			$time = date('H', strtotime($time)) + 0;
			$aa[$day][$time] = 1;
		}
					
		foreach (explode(',', $daytimes) as $pt){
			list($preferred_day, $preferred_moment) = explode(' - ', $pt);
			$preferred_day = trim($preferred_day);
			$preferred_moment = trim($preferred_moment);
			

			
			if ($preferred_moment == 'Morning'){
				$start = 8; $end = 12;
			} elseif ($preferred_moment == 'Afternoon'){
				$start = 12; $end = 18;
			} elseif ($preferred_moment == 'Evening'){
				$start = 18; $end = 24;
			}
			
			
			if ($hours == 1){
				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && 
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1]){
							return true;
						}
					}
				}
			} elseif ($hours == 2){
				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && $aa[$preferred_day][$t+1] &&
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1] && !$blocked[$preferred_day][$t+2]){
							return true;
						}
					}
				}
				
			} elseif ($hours == 3){

				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && $aa[$preferred_day][$t+1] && $aa[$preferred_day][$t+2] &&
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1] && !$blocked[$preferred_day][$t+2] && !$blocked[$preferred_day][$t+3]){
							return true;
						}
					}
				}
				
			}
		}
		
		return false;
	}
	
	function Get_possible_booking_daytimes($hours, $tutor){
		
		
		$daytimes = 'Mon - Morning,Mon - Afternoon,Mon - Evening,Tue - Morning,Tue - Afternoon,Tue - Evening,Wed - Morning,Wed - Afternoon,Wed - Evening,Thu - Morning,Thu - Afternoon,Thu - Evening,Fri - Morning,Fri - Afternoon,Fri - Evening,Sat - Morning,Sat - Afternoon,Sat - Evening,Sun - Morning,Sun - Afternoon,Sun - Evening';
		
		
		$blocked = $this->Get_blocked_daytime($tutor->email);

		$availability = explode(',', $tutor->availability);
		foreach ($availability as $a){
			list($day,$moment,$time) = explode(' - ', $a);
			$time = date('H', strtotime($time)) + 0;
			$aa[$day][$time] = 1;
		}
		
		
		$possible = array();
		
		

					
		foreach (explode(',', $daytimes) as $pt){
			

			list($preferred_day, $preferred_moment) = explode(' - ', $pt);
			$preferred_day = trim($preferred_day);
			$preferred_moment = trim($preferred_moment);
			

			
			if ($preferred_moment == 'Morning'){
				$start = 8; $end = 12;
			} elseif ($preferred_moment == 'Afternoon'){
				$start = 12; $end = 18;
			} elseif ($preferred_moment == 'Evening'){
				$start = 18; $end = 24;
			}
			

			
			if ($hours == 1){

				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && 
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1]){
							$possible[$preferred_day . ' - ' . date('gA', strtotime($t.':00'))] = $preferred_day . ' - ' . date('gA', strtotime($t.':00'));
						}
					}
				}
			} elseif ($hours == 2){
				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && $aa[$preferred_day][$t+1] &&
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1] && !$blocked[$preferred_day][$t+2]){
							
							$possible[$preferred_day . ' - ' . date('gA', strtotime($t.':00'))] = $preferred_day . ' - ' . date('gA', strtotime($t.':00'));
						}
					}
				}
				
			} elseif ($hours == 3){

				foreach ($aa[$preferred_day] as $t => $available){
					if ($t >= $start && $t < $end){
						if ($aa[$preferred_day][$t] && $aa[$preferred_day][$t+1] && $aa[$preferred_day][$t+2] &&
							!$blocked[$preferred_day][$t-1] && !$blocked[$preferred_day][$t] && !$blocked[$preferred_day][$t+1] && !$blocked[$preferred_day][$t+2] && !$blocked[$preferred_day][$t+3]){
								
							$possible[$preferred_day . ' - ' . date('gA', strtotime($t.':00'))] = $preferred_day . ' - ' . date('gA', strtotime($t.':00'));
						}
					}
				}
				
			}
		}
		
		

		
		return $possible;

	}
	
	
	function Get_lessons($client_email){
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `status` = 'Hired' AND `request_from` = ? AND `request_to` = ?", array($client_email, $this->user->data('email')));
		return $query->result();
	}
	
	
	function Get_clients($user_email){
		
		if (!$user_email) $email = $this->user->data('email');
		else $email = $user_email;
		
		$query = $this->db->query("SELECT `request_from` AS `client` FROM `job_requests` WHERE `status` = 'Hired' AND `request_to` = ? GROUP BY `request_from`", array($email));
		return $query->result();
	}
	
	function Get_sessions($request_id){
		$query = $this->db->query("SELECT * FROM `tutor_sessions` WHERE `job_request_id` = ? ORDER BY `date` ASC", array($request_id));
		return $query->result();
	}
	
	function Get_schedule($email, $type){
		$from = date('Y-m-d 00:00:00');
		$to = date('Y-m-d 23:59:59', time() + (7 * 60 * 60 * 24));
		
		if (!$email){
			$email = $this->user->data('email');
			$type = $this->user->data('type');
		} 
		
		if ($type == 'tutor'){
			$query = $this->db->query("SELECT *, tutor_sessions.status AS `session_status`, tutor_sessions.id AS `session_id` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `user_email` = ? AND `date` >= ? AND `date` <= ?", array($email, $from, $to));
		} else {
			$query = $this->db->query("SELECT *, tutor_sessions.status AS `session_status`, tutor_sessions.id AS `session_id` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `request_from` = ? AND `date` >= ? AND `date` <= ?", array($email, $from, $to));			
		}
		return $query->result();
	}
	
	function Get_requests($data){
		
		if ($data['from']){
			$filter[] = '`request_from` = ' . $this->db->escape($data['from']);
		}
		if ($data['to']){
			$filter[] = '`request_to` = ' . $this->db->escape($data['to']);
		}
		
		if ($data['status']){
			
			$filter[] = 'FIND_IN_SET(`status`, '.$this->db->escape($data['status']).')';				


		}
		
		
		if (count($filter)){
			$filter_string = 'WHERE ' . implode($filter, ' AND ');
		}
		
		$order_string = ' ORDER BY `id` DESC';
		
		
		$query = $this->db->query("SELECT * FROM `job_requests` $filter_string $order_string");
		
		return $query->result();
	}
	
	function Get_request($id){
		$query = $this->db->query("SELECT * FROM `job_requests` WHERE `id` = ?", array($id));
		return $query->row();
		
	}
	
	function Get_order($id){
		$query = $this->db->query("SELECT * FROM `job_orders` WHERE `id` = ?", array($id));
		return $query->row();
		
	}
	
	function Get_unseen_assessment(){
		
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `tutor_sessions` WHERE `parent_email` = ? AND `assessment_seen` IS NULL", array($this->user->data('email')));
		$row = $query->row();
		return $row->total;
	}
	
	function hours_tutored(){
		$query = $this->db->query("SELECT *, tutor_sessions.status AS `session_status`, tutor_sessions.id AS `session_id` FROM `tutor_sessions` LEFT JOIN `job_requests` ON job_requests.id = tutor_sessions.job_request_id WHERE `user_email` = ? AND tutor_sessions.status = 'Completed'", array($this->user->data('email')));
		foreach ($query->result() as $session){
			$info = json_decode($session->request_data);
			$hours += $info->hours;
		}
		
		return $hours ? $hours : '0';
	}
	
	function Accepted_requests(){
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `job_requests` WHERE `request_to` = ? AND (`status` = 'Hired' OR `status` = 'Awaiting Payment')", array($this->user->data('email')));
		$accepted = $query->row();
		
		return $accepted->total ? $accepted->total : '0';
		
	}
	
	function Pending_requests(){
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `job_requests` WHERE `request_to` = ? AND (`status` = 'Awaiting Confirmation')", array($this->user->data('email')));
		$pending = $query->row();
		
		return $pending->total ? $pending->total : '0';
		
	}
	
	function Declined_requests(){
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `job_requests` WHERE `request_to` = ? AND (`status` = 'Declined')", array($this->user->data('email')));
		$declined = $query->row();
		
		return $declined->total ? $declined->total : '0';
		
	}
	
	function Active_clients(){
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `job_requests` WHERE `request_to` = ? AND (`status` = 'Hired') GROUP BY `request_from`", array($this->user->data('email')));
		$active = $query->row();
		
		return $active->total ? $active->total : '0';
		
	}
	
	function Pending_reports(){
		$query = $this->db->query("SELECT COUNT(`id`) AS `total` FROM `tutor_sessions` WHERE `user_email` = ? AND (`status` = 'Completed')", array($this->user->data('email')));
		$pending = $query->row();
		
		return $pending->total ? $pending->total : '0';
		
	}
	
	function Reviews($tutor_email){
		$query = $this->db->query("SELECT * FROM `reviews` WHERE `tutor_email` = ? ORDER BY `datetime` DESC", array($tutor_email));
		return $query->result();
	}
	
}