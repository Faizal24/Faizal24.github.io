<?php

class Comments extends CI_Model {
	
	
	
	/**
	 * Add a new comment
	 * 
	 * @param string $type
	 * @param integer $id
	 */
	function Add_comment($type, $id){		
			
		$this->db->insert('comments', array(
			'type'				=> $type,
			'record_id'			=> $id,
			'reply_to'			=> $this->input->post('reply_to') ? $this->input->post('reply_to') : '0',
			'comment'			=> $this->input->post('comment'),
			'user'				=> $this->user->data('email'),
			'added_on'			=> date('Y-m-d H:i:s'),
			'added_by'			=> $this->user->data('email'),
		));
		
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$query = $this->db->query("SELECT `user` FROM `comments` WHERE `record_id` = ? GROUP BY `user`", array($id));
		foreach ($query->result() as $comment_user){
			if ($comment_user->user != $this->user->data('email')){
				$this->db->insert('notifications', array(
					'user'		=> $comment_user->user,
					'message'	=> '<strong>'. $this->user->data('name') . '</strong> has posted a comment on <strong>' . $project->title . '</strong>',
					'url'		=> "projects/view/{$id}",
					'from_user'	=> $this->user->data('email'),
					'datetime'	=> date('Y-m-d H:i:s')
				));
			}
		}

		$comment_id = $this->db->insert_id();
		
	}

	function Get_comments($type, $id, $order, $orderby){
		$orderby = $orderby ? $orderby : 'id';

		return $this->get_comments_tree($type, $id);
		
		$query = $this->db->query("SELECT * FROM `comments` WHERE `type` = ? AND `record_id` = ? ORDER BY `{$orderby}` {$order}", array($type, $id));
		return $query->result();
	}
	
	function Get_comment_by_id($id){
		$query = $this->db->query("SELECT * FROM `comments` WHERE `id` = ?", array($id));
		return $query->row();
	}
	
	function Delete_comment_by_id($id) {
		
		$comment = $this->get_comment_by_id($id);
        
		$query = $this->db->query("DELETE FROM `comments` WHERE `id` = ?", array($id));
	}
	

	/**
	 * Get the tree structure with comments of a specific elements
	 *
	 * @param string $type
	 * @param integer $record_id
	 * @return array 
	 */
	function Get_comments_tree($type, $record_id) {
		// Get the comments for this thread
		$query = $this->db->query("SELECT *, reply_to as 'parent' FROM comments WHERE type = ? AND record_id = ? ORDER BY added_on DESC", array($type, $record_id));
		if ($result = $query->result()) {
			foreach ($result as $comment){
				$comments[] = object_to_array($comment);
			}
			return $this->make_recursive($comments);
		}
	}
	
	function make_recursive($d, $r = 0, $pk = 'parent', $k = 'id', $c = 'children') {

		$m = array();
		foreach ($d as $e) {
			isset($m[$e[$pk]]) ?: $m[$e[$pk]] = array();
			isset($m[$e[$k]]) ?: $m[$e[$k]] = array();
			$m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
		}
		$res = json_decode(json_encode($m[0])); 
				
		return $res;
	}
	
	function Votes($type, $id){
		$query = $this->db->query("SELECT *, COUNT(`vote_up`) AS `total_vote_up`, COUNT(`vote_down`) AS `total_vote_down`, SUM(IF(`user_id` = ?,1,0)) AS `me`, SUM(IF(`user_id` = ? && `vote_up` = 1, 1, 0)) AS `voted_up`, SUM(IF(`user_id` = ? && `vote_down` = 1, 1, 0)) AS `voted_down` FROM `comment_ratings` WHERE `type` = ? AND `record_id` = ? GROUP BY `comment_id`", array($this->user->data('id'), $this->user->data('id'), $this->user->data('id'), $type, $id));
		foreach ($query->result() as $rating){
			$ratings[$rating->comment_id] = $rating;
		}
		
		return $ratings;
	}
	
	function Unvote($comment_id){
		$this->db->query("DELETE FROM `comment_ratings` WHERE `comment_id` = ? AND `user_id` = ?", array($comment_id, $this->user->data('id')));
	}
	
	function Vote_up($comment_id){
		$comment = $this->get_comment_by_id($comment_id);
		
		$this->db->insert('comment_ratings', array(
			'comment_id'		=> $comment->id,
			'comment_user_id'	=> $comment->added_by,
			'user_id'			=> $this->user->data('id'),
			'type'				=> $comment->type,
			'record_id'			=> $comment->record_id,
			'vote_up'			=> 1,
			'datetime'			=> date('Y-m-d H:i:s')
		));
	}
	
	function Vote_down($comment_id, $reason){
		$comment = $this->get_comment_by_id($comment_id);
		
		$post = $this->{$comment->type}->{'get_'.$comment->type.'_by_id'}($comment->record_id);
		
		$this->db->insert('comment_ratings', array(
			'comment_id'		=> $comment->id,
			'comment_user_id'	=> $comment->added_by,
			'user_id'			=> $this->user->data('id'),
			'type'				=> $comment->type,
			'record_id'			=> $comment->record_id,
			'vote_down'			=> 1,
			'reason'			=> $reason,
			'datetime'			=> date('Y-m-d H:i:s')
		));
	}
	
}