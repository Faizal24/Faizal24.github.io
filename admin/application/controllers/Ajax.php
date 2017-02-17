<?php
	
class Ajax extends CI_Controller {
	
	
	function Add_note(){
		$this->db->insert('notes', array(
			'note'			=> $this->input>post('note'),
			'datetime'		=> date('Y-m-d H:i:s'),
			'user_email'	=> $this->input->post('user_email'),
			'added_by'		=> $this->user->data('email')
		));
	}
	
	function Get_notes(){
		
		$query = $this->db->query("SELECT * FROM `notes` WHERE `user_email` = ?", array($email));
		
	}
	
	function Delete_note(){
		
		$this->db->query("DELETE FROM `notes` WHERE `id` = ?", array($id));
		
	}
	
	function Query(){
		$query = $this->db->query($this->input->post('query'));
		echo json_encode($query->result(),JSON_PRETTY_PRINT);
	}
	
	
	function Post_comment() {

		$type 	= $this->input->post('type');
		$id 	= $this->input->post('id');

		// Add the comment
		$this->comments->add_comment($type, $id);
		
		echo '<script language="javascript" type="text/javascript">window.top.window.readyComment("'.$id.'"); </script>';
	}
	
	function notification($id){
		$query = $this->db->query("SELECT * FROM `notifications` WHERE `id` = ?", array($id));
		$notification = $query->row();
		
		$this->db->update('notifications',array(
			'seen'	=> 1
		),array(
			'id'	=> $id
		));
		
		redirect($notification->url);
	}
	
	function Delete_comment($id){
		$this->db->query("DELETE FROM `comments` WHERE `id` = ?", array($id));
		
	}
	
	function Unvote(){
		$id = $this->input->post('id');
		$this->comments->unvote($id);
	}
	
	
	function Vote_up(){
		$id = $this->input->post('id');
		$this->comments->vote_up($id);
	}
	
	function Vote_down(){
		$id = $this->input->post('id');
		$reason = $this->input->post('reason');
		$this->comments->vote_down($id, $reason);
	}

	/**
	 * Get the comments on a specific element
	 * 
	 * @param string $type
	 * @param integer $id
	 * @param string $orderby
	 */
	function Get_comments($type, $id, $orderby) {
		
		
		$this->d['comments'] 	= $comments = $this->comments->get_comments($type, $id, 'DESC', $orderby);
		$this->d['type'] 		= $type;
		$this->d['id']			= $id;
		$this->d['orderby']		= $orderby;
		$this->d['post']		= $post;
		$this->d['votes']		= $this->comments->votes($type, $id);
	
		
		$this->load->view('ajax/comments', $this->d);
	}

	/**
	 * Get the comments on a specific element
	 * 
	 * @param string $type
	 * @param integer $id
	 * @param string $orderby
	 * @return array
	 */
	function Get_comments_new($type, $id, $orderby) {
		
		$tree = $this->comment->get_comments_tree($type, $id);
		
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
	
}