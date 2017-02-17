<?php 
	
class SU extends CI_Controller {

	function Verify_email($id, $hash){
		$user = $this->user->id($id);
		$check = sha1($id.$id.$user->email);
		
		if ($check == $hash){
			redirect('login/verified');
		}
	}

}

