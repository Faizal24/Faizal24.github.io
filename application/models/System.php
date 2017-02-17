<?php
	
class System extends CI_Model {
	
	function Get_grades(){
		$query = $this->db->query("SELECT `grade` FROM `subjects` GROUP BY `grade` ORDER BY `order` ASC, `value` ASC");
		return $query->result();
	}
	
	function Get_tutor_subject($id){
		$query = $this->db->query("SELECT * FROM `tutor_subjects` WHERE `id` = ?", array($id));		
		return $query->row();
		
	}
	
	function Get_subjects(){
		$query = $this->db->query("SELECT * FROM `subjects` ORDER BY `order` ASC, `value` ASC");		
		return $query->result();
	}
	
	function Get_questions($set){
		$query = $this->db->query("SELECT * FROM `qa` WHERE `set` = ?" ,array($set));
		return $query->result();
	}
	
	function Get_question_responses($set, $user_email){
		$query = $this->db->query("SELECT * FROM `qa_responses` WHERE `set` = ? AND `user_email` = ?", array($set, $user_email));
		foreach ($query->result() as $r){
			$rs[$r->number] = $r;
		}
		
		return $rs;
	}
	
	function Get_states($dropdown){
		$query = $this->db->query("SELECT * FROM `states` ORDER BY `value` ASC");
		if ($dropdown){
			$states[''] = 'Select State';
		}
		foreach ($query->result() as $state){
			$states[$state->value] = $state->value;
		}
		
		return $states;
	}
	
	function Get_countries($dropdown){
		
		
		if ($dropdown){
			$data[''] = 'Select Country';
		}
		
		$data['Malaysia'] = 'Malaysia';

		return $data;
	}
}