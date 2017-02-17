<?php

class Messenger extends CI_Controller {
	
	function Index(){

		$this->load->view('common/header', $this->d);
		$this->load->view('messenger/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
	function Chat($event_id){

		$this->d['uid']	= $event->creator;
		
		$this->load->view('common/header', $this->d);
		
		$this->load->view('messenger/index', $this->d);
		
		$this->load->view('common/footer', $this->d);

	}
	
	function Chat_with_user($id){
		$this->d['uid']	= $id;
		
		$this->load->view('common/header', $this->d);
		
		$this->load->view('messenger/index', $this->d);
		
		$this->load->view('common/footer', $this->d);
	}
	
	function Chat_with_sponsor($event_id, $sponsor_id, $hash){
		$event 	= $this->event->get_event_by_id($event_id);
		$sponsor= $this->user->get_userdata_by_id($sponsor_id);
		
		if ($hash != sha1($sponsor->email.$event_id)) redirect('messenger');
		
		$this->d['eid']	= $event->id;
		$this->d['uid']	= $sponsor_id;
		
		$this->load->view('common/header', $this->d);
		
		if ($this->user->userdata('type') == 'brand'){
			$this->load->view('messenger/brand', $this->d);
		} else {
			$this->load->view('messenger/index', $this->d);
		}
		
		$this->load->view('common/footer', $this->d);
	}
	
	function Ajax($request, $opt){
		switch ($request){
			
			case "search":
				$term = $this->input->post('q');
				
				if (trim($term)){
					$query = $this->db->query("SELECT * FROM `users` WHERE (`email` = ? OR `name` LIKE ? OR `education_institution` LIKE ?) AND `type` = 'user'", array($term, '%'.$term.'%', '%'.$term.'%'));
					$this->d['users'] = $query->result();
				} 
				
				$this->load->view('messenger/search', $this->d);
			
				break;
				
			case "conversation_list":

				
				break;
				
			case "get_conversation":
				$uid = $this->input->post('uid');
				$eid = $this->input->post('eid');
				
				if ($eid == 'undefined') $eid = false;
				
				$to_user = $this->user->id($uid);
				$me = $this->user->data();
	
				$this->d['uid'] = $uid;
				if ($eid){
					$this->d['eid'] = $eid;
				}
				
				
				if ($me->id > $uid){
					$chat_id = $uid . '-' . $me->id . ($eid ? '-' . $eid : '');
				} else {
					$chat_id = $me->id . '-' . $uid . ($eid ? '-' . $eid : '');
				}
				
				$this->d['chat_id'] = $chat_id;
				
				$this->load->view('messenger/chat', $this->d);
				
				break;
			
			
		}
	}
	
}