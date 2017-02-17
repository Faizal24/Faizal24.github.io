<?php
	
class System extends CI_Model {
	
	function __construct(){
		parent::__construct();
		
	}
	
	function Get_grades(){
		$query = $this->db->query("SELECT `grade` FROM `subjects` GROUP BY `grade` ORDER BY `order` ASC, `value` ASC");
		return $query->result();
	}
	
	function Get_subjects(){
		$query = $this->db->query("SELECT * FROM `subjects` ORDER BY `order` ASC, `value` ASC");		
		return $query->result();
	}
	
	function Config($conf){
		$query = $this->db->query("SELECT * FROM `config` WHERE `config` = ?", array($conf));
		if ($query->num_rows()){
			$config = $query->row();
			return $config->value;
		} 
		
		return false;
	}
	
	function Set_config($config, $value){
		$query = $this->db->query("SELECT * FROM `config` WHERE `config` = ?", array($config));
		if ($query->num_rows()){
			$this->db->update('config', array(
				'value'		=> $value
			), array(
				'config'	=> $config
			));
		} else {
			$this->db->insert('config',array(
				'value'		=> $value,
				'config'	=> $config
			));
		}		
	}
	
	function Get_stages(){
		$query = $this->db->query("SELECT * FROM `stages` ORDER BY `order` ASC");
		return $query->result();
	}
	
	
	function Terms($type){
		$query = $this->db->query("SELECT * FROM $type ORDER BY `id` ASC");
		
		return $query->result();
		
	}
	
	function Dropdown_states($label){
		$query = $this->db->query("SELECT * FROM `states` ORDER BY `value` ASC");
		if ($label) $dd[''] = $label;
		foreach ($query->result() as $state){
			$dd[$state->value] = $state->value;
		}
		
		return $dd;
	}
}