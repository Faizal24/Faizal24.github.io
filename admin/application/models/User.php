<?php

class User extends CI_Model {
	
	var $no_auth = array('home','login','logout','register','contact');
	
	function __construct(){
		parent::__construct();
		
		if (in_array($this->uri->segment(1), $this->no_auth)){

		} else {
			if (!$this->Is_logged_in()){
				redirect('login');
			}
		}
	}
	
	function User_types_dropdown(){
		$query = $this->db->query("SELECT * FROM `user_types` ORDER BY `name` ASC");
		foreach ($query->result() as $type){
			$types[$type->name] = $type->name;
		}
		
		return $types;
	}
	
	function User_types(){
		$query = $this->db->query("SELECT * FROM `user_types` ORDER BY `name` ASC");
		foreach ($query->result() as $type){
			$types[$type->name] = $type;
		}
		
		return $types;
	}
	
	function Auth_user($email, $password){
		$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ? AND `type` = 'admin'", array($email));
		$admin = $query->row();
				
		if (strtolower($admin->password) == strtolower(sha1($password))){
			$this->session->set_userdata(array(
				'pms_user_id'	=> $admin->id
			));
			return true;
		}
		return false;	
	}
	
	function Id($id){
		$query = $this->db->query("SELECT * FROM `users` WHERE `id` = ?", array($id));		
		return $query->row();
	}
	
	function Tutor($id){
		$query = $this->db->query("SELECT *, users.id FROM `users` LEFT JOIN `tutor_profile` ON tutor_profile.user_email = users.email WHERE users.id = ? AND users.type = 'tutor'", array($id));		
		return $query->row();		
	}
	
	function Tutor_subjects($tutor){
		$query = $this->db->query("SELECT * FROM `tutor_subjects` WHERE `user_email` = ?", array($tutor->email));
		return $query->result();
	}
	
	function Email($email){
		$query = $this->db->query("SELECT * FROM `users` WHERE `email` = ?", array($email));		
		return $query->row();
	}
	
	function Query($filter, $data, $table){
		if (trim($filter)) $filter = ' WHERE ' . $filter;
		if (!$table) $table = 'users';
		$query = $this->db->query("SELECT * FROM `$table` $filter", $data);
		foreach ($query->result() as $user){
			$users[$user->id] = $user;
		}
		return $users;

	}
	
	function Get($filter){
		$query = $this->db->query("SELECT * FROM `users` $filter");
		foreach ($query->result() as $user){
			$users[$user->id] = $user;
		}
		return $users;
	}
	
	function Get_by_email($filter){
		$query = $this->db->query("SELECT * FROM `users` $filter");
		foreach ($query->result() as $user){
			$users[$user->email] = $user;
		}
		return $users;
	}
	
	function Is_logged_in(){
		if ($this->session->userdata('pms_user_id')) return true;
	}
	
	function Is_admin(){
		if ($this->data('type') == 'Admin') return true;
		return  false;
	}
	
	
	
	function Data($field){
		
		if ($this->userdata->id){
			$user = $this->userdata;		
		
		
		} else {
			$id = $this->session->userdata('pms_user_id');			
			$query = $this->db->query("SELECT * FROM `users` WHERE `id` = ?", array($id));
			$user = $query->row();
			
			$this->userdata = $user;
		}
		
		if ($field) return $user->{$field};
		return $user;

	}

	
	function Logout(){
		$this->session->set_userdata(array(
			'pms_user_id'		=> ''
		));
	}
	
	
	function Add_user($data){
	
		$this->db->insert('users', array(
			'firstname'			=> $data['firstname'],
			'lastname'			=> $data['lastname'],
			'type'				=> $data['type'],
			'email'				=> $data['email'],
			'password'			=> sha1(trim($data['password'])),
			'added_on'			=> date('Y-m-d H:i:s')
		));
		
		return $this->db->insert_id();
	}
	
	function Edit_user($id, $data){
	
	
		if ($data['password']){
			

			$this->db->update('users', array(
				'firstname'			=> $data['firstname'],
				'lastname'			=> $data['lastname'],
				'type'				=> $data['type'],
				'photo'				=> $data['photo'],
				'password'			=> sha1(trim($data['password'])),
				'modified_on'		=> date('Y-m-d H:i:s')
			),"`id` = '$id'");
		} else {
			$this->db->update('users', array(
				'firstname'			=> $data['firstname'],
				'lastname'			=> $data['lastname'],
				'type'				=> $data['type'],
				'photo'				=> $data['photo'],
				'modified_on'		=> date('Y-m-d H:i:s')
			),"`id` = '$id'");

		}
	}
	
	function Delete_user($id){
		$this->db->query("DELETE FROM `users` WHERE `id` = ?", array($id));
	}
	
	
	function Country_dropdown(){
		$query = $this->db->query("SELECT * FROM `countries` ORDER BY `name` ASC");
		
		$countries[''] = 'Select';
		foreach ($query->result() as $country){
			$countries[$country->name] = $country->name;
		}
		
		return $countries;
	}
	
	function User_type($id){
		$query = $this->db->query("SELECT * FROM `user_types` WHERE `id` = ?", array($id));
		return $query->row();
	}
	
	function User_type_by_name($name){
		$query = $this->db->query("SELECT * FROM `user_types` WHERE `name` = ?", array($name));
		return $query->row();
	}
	
	function Add_type($data){
		$this->db->insert('user_types',array(
			'name'			=> $data['name'],
			'permission'	=> json_encode($data['permission'])
		));
		
		return $this->db->insert_id();
	}
	
	function Edit_type($id, $data){
		$this->db->update('user_types',array(
			'name'			=> $data['name'],
			'permission'	=> json_encode($data['permission'])
		), array(
			'id'			=> $id
		));			
	}

	function Delete_type($type, $new_type){
		$this->db->query("DELETE FROM `user_types` WHERE `name` = ?", array($type));
		$this->db->update('users',array(
			'type'		=> $new_type
		), array(
			'type'		=> $type
		));
		
	}
	
	function Has_permission($action, $user){
		if (!$user) $user = $this->data();
		
		$type = $this->User_type_by_name($user->type);
		$permission = json_decode($type->permission,true);
		
		if ($user->super) return true;
		
		if ($permission[$action]) return true;
		
		return false;
	}


}