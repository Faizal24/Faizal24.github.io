<?php


class Autocomplete extends CI_Controller {

	public function Search($type,$single=false){
		if ($single){
			$limit = 10;
			$search = $this->input->post('search');
		}
		
		
		switch($type){
			case "category":
				$query = $this->db->query("SELECT * FROM `categories` WHERE `value` LIKE ? ORDER BY `value` ASC",array($search.'%'));
				$tm = $query->result();
				
				foreach ($tm as $t){
					$response[] = array($t->value, $t->value);
				}
			
				break;
			case "target_market":
				$query = $this->db->query("SELECT * FROM `target_markets` WHERE `value` LIKE ? ORDER BY `value` ASC",array($search.'%'));
				$tm = $query->result();
				
				foreach ($tm as $t){
					$response[] = array($t->value, $t->value);
				}
			
				break;
			case "target_customer":
				$query = $this->db->query("SELECT * FROM `target_customers` WHERE `value` LIKE ? ORDER BY `value` ASC",array($search.'%'));
				$tm = $query->result();
				
				foreach ($tm as $t){
					$response[] = array($t->value, $t->value);
				}
			
				break;

			
			case "item":
			
				$query = $this->db->query("SELECT * FROM `inventory` WHERE `name` LIKE '$search%' ORDER BY `name` ASC");
				$items = $query->result();
				
				foreach ($items as $item){
					$response[] = array($item->sku, $item->name);
				}
				
				break;
		
			case "tag":
				$query = $this->db->query("SELECT * FROM `tags` ORDER BY `name` ASC");
				$tags = $query->result();
				
				foreach ($tags as $tag){
					$response[] = array($tag->name, $tag->name);
				}
			
				break;
	
			case "country":
				$query = $this->db->query("SELECT * FROM `countries` ORDER BY `name` ASC");
				$countries = $query->result();
				
				foreach ($countries as $country){
					$response[] = array($country->name, $country->name);
				}
				break;
			case "user":
				$query = $this->db->query("SELECT * FROM `users` ORDER BY `email` ASC");
				$users = $query->result();
				
				foreach ($users as $user){
					$response[] = array($user->email, $user->name.' ('.$user->email.')');
				}			
				break;
			case "division":
				$divisions = explode(',',$this->system->config('company_divisions'));
				
				$response[] = array('General','General');
				foreach ($divisions as $division){
					$response[] = array($division, $division);
				}
			
				
			
				break;
			case "employees":
				$query = $this->db->query("SELECT * FROM `employees` ORDER BY `firstname` ASC");
				$employees = $query->result();
				foreach ($employees as $employee){
					$response[] = array($employee->id, $employee->firstname . ' ' . $employee->lastname);
				}
				break;
				
		}
		
		header('Content-type: application/json');
		echo json_encode($response);
	}
	
}