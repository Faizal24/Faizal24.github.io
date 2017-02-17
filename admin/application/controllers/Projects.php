<?php
	
class Projects extends CI_Controller {
	
	
	public function Index(){
		$query = $this->db->query("SELECT * FROM `projects` WHERE `status` != 'Completed' AND `deleted` IS NULL ORDER BY `id` DESC");
		$data['projects'] = $query->result();
		
		$this->load->view('projects/search', $data);
	}
	
	public function Delete($id){
		$this->db->update('projects',array(
			'deleted'	=> 1
		), array(
			'id'		=> $id
		));
	}

	
	public function Ajax($request, $mode){
		switch ($request){
			case "get_statuses":
				$query = $this->db->query("SELECT * FROM `statuses` ORDER BY `id` ASC");
				$statuses = $query->result();
				
				if ($mode == 'html'){
					echo '<li><label class="block"><input class="click-submit" type="checkbox" name="status[]" value="*" /> All</label></li>';
					foreach ($statuses as $status){
						echo '<li><label class="block"><input class="click-submit" type="checkbox" name="status[]" value="'.$status->value.'" /> '.$status->value.'</label></li>';
					}
					
					return;
				}
				
			break;
			case "get_categories":
			
				$query = $this->db->query("SELECT * FROM `categories` ORDER BY `id` ASC");
				$categories = $query->result();
				
				if ($mode == 'html'){
					echo '<li><label class="block"><input class="click-submit" type="checkbox" name="category[]" value="*" /> All</label></li>';
					foreach ($categories as $category){
						echo '<li><label class="block"><input class="click-submit" type="checkbox" name="category[]" value="'.$category->value.'" /> '.$category->value.'</label></li>';
					}
					
					return;
				}
			
			break;
			case "get_priority_projects":
			
				$query = $this->db->query("SELECT * FROM `projects` WHERE `priority` = 1  AND `deleted` IS NULL ORDER BY `id` ASC");
				$projects = $query->result();
				
				if ($mode == 'html'){
					foreach ($projects as $project){
						echo '<li><a class="link" href="projects/view/'.$project->id.'">'.$project->title.'</a></li>';
					}
					
					return;
				}
			
			break;
		}
	}
	
	
	public function Update_remarks(){
		$this->db->update('projects',array(
			'remarks'	=> $this->input->post('remarks')
		), array(
			'id'		=> $this->input->post('id')
		));
		
		return $this->form->submit_successful();
	}
	
	
	public function upload_costing($project_id){
		$config['upload_path'] = './uploads/docs';
		$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|ppt|pptx|jpg|gif|png';
		$config['max_size']	= '20480';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$this->db->insert('docs', array(
				'type'			=> 'docs',
				'description'	=> $this->input->post('description'),
				'file'			=> $filedata['file_name'],
				'project_id'	=> $project_id,
				'added_on'		=> date('Y-m-d H:i:s'),
				'added_by'		=> $this->user->data('email')
			));
			
			return $this->form->submit_successful();
		} else {
			return $this->form->submit_unsuccessful('Error uploading file.');
		}
	}
	
	public function Get_costing_uploads($project_id){
		$query = $this->db->query("SELECT * FROM `docs` WHERE `project_id` = ? AND `type` = 'docs' ORDER BY `status` DESC, `id` DESC", array($project_id));
		$uploads = $query->result();
		
		$data['uploads'] = $uploads;
		
		$this->load->view('projects/docs', $data);
		
	}
	
	
	public function upload_2d($project_id){
		$config['upload_path'] = './uploads/2d';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$this->db->insert('uploads', array(
				'type'			=> '2d',
				'description'	=> $this->input->post('description'),
				'file'			=> $filedata['file_name'],
				'project_id'	=> $project_id,
				'added_on'		=> date('Y-m-d H:i:s'),
				'added_by'		=> $this->user->data('email')
			));
			
			return $this->form->submit_successful();
		} else {
			return $this->form->submit_unsuccessful('Error uploading image.');
		}
	}
	
	public function Get_2d_uploads($project_id){
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `project_id` = ? AND `type` = '2d' ORDER BY `status` DESC, `id` DESC", array($project_id));
		$uploads = $query->result();
		
		$data['uploads'] = $uploads;
		
		$this->load->view('projects/2d', $data);
		
	}
	
	public function Set_2d_final($id, $do){
		if ($do == 'do'){
			$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
			$upload = $query->row();
			
			$this->db->update('uploads',array(
				'status'		=> null
			),array(
				'project_id'	=> $upload->project_id,
				'type'			=> '2d'
			));
			
			$this->db->update('uploads',array(
				'status'		=> 1
			),array(
				'id'			=> $id
			));
			
			$this->db->update('projects',array(
				'photo'			=> 'uploads/2d/' . $upload->file
			),array(
				'id'			=> $upload->project_id
			));
			
		}
	}
	
	public function Delete_2d($id, $do){
		if ($do == 'do'){
			$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
			$upload = $query->row();
			
			if ($upload->status == 1){
				$this->db->update('projects',array(
					'photo'			=> null
				),array(
					'id'			=> $upload->project_id
				));
			}		
			
			$this->db->query("DELETE FROM `uploads` WHERE `id` = ?",array($id));
		}
	}
	
	public function Download_2d($id){
		
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
		$upload = $query->row();
		
        $this->load->helper('download');
        
        force_download('uploads/2d/'.$upload->file, NULL);
	}
	
	public function Delete_attachment($id, $do){
		if ($do == 'do'){

			$this->db->query("DELETE FROM `docs` WHERE `id` = ?",array($id));
		}
	}
	
	public function Download_attachment($id){
		
		$query = $this->db->query("SELECT * FROM `docs` WHERE `id` = ?", array($id));
		$upload = $query->row();
		
        $this->load->helper('download');
        
        force_download('uploads/docs/'.$upload->file, NULL);
	}
	
	
	
	public function upload_3d($project_id){
		$config['upload_path'] = './uploads/3d';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$this->db->insert('uploads', array(
				'type'			=> '3d',
				'description'	=> $this->input->post('description'),
				'file'			=> $filedata['file_name'],
				'project_id'	=> $project_id,
				'added_on'		=> date('Y-m-d H:i:s'),
				'added_by'		=> $this->user->data('email')
			));
			
			return $this->form->submit_successful();
		} else {
			return $this->form->submit_unsuccessful('Error uploading image.');
		}
	}
	
	public function Get_3d_uploads($project_id){
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `project_id` = ? AND `type` = '3d' ORDER BY `status` DESC, `id` DESC", array($project_id));
		$uploads = $query->result();
		
		$data['uploads'] = $uploads;
		
		$this->load->view('projects/3d', $data);
		
	}
	
	public function Set_3d_final($id, $do){
		if ($do == 'do'){
			$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
			$upload = $query->row();
			
			$this->db->update('uploads',array(
				'status'		=> null
			),array(
				'project_id'	=> $upload->project_id,
				'type'			=> '3d'
			));
			
			$this->db->update('uploads',array(
				'status'		=> 1
			),array(
				'id'			=> $id
			));
			
			$this->db->update('projects',array(
				'photo'			=> 'uploads/3d/' . $upload->file
			),array(
				'id'			=> $upload->project_id
			));
			
		}
	}
	
	public function Delete_3d($id, $do){
		if ($do == 'do'){			
			$this->db->query("DELETE FROM `uploads` WHERE `id` = ?",array($id));
		}
	}
	
	public function Download_3d($id){
		
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
		$upload = $query->row();
		
        $this->load->helper('download');
        
        force_download('uploads/3d/'.$upload->file, NULL);
	}
	
	
	public function upload_gallery($project_id){
		$config['upload_path'] = './uploads/gallery';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')){
			
			$filedata = $this->upload->data();
			
			$this->db->insert('uploads', array(
				'type'			=> 'gallery',
				'description'	=> $this->input->post('description'),
				'file'			=> $filedata['file_name'],
				'project_id'	=> $project_id,
				'added_on'		=> date('Y-m-d H:i:s'),
				'added_by'		=> $this->user->data('email')
			));
			
			$data->filename = $filedata['file_name'];
			
			if ($this->input->post('set_primary')){
				$this->db->update('projects',array(
					'photo'		=> 'uploads/gallery/' . $filedata['file_name']
				), array(
					'id'		=> $project_id
				));
			}
			
			return $this->form->submit_successful($data);
		} else {
			return $this->form->submit_unsuccessful('Error uploading image.');
		}
	}
	
	
	
	public function Get_gallery_uploads($project_id){
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `project_id` = ? AND ((`type` = 'gallery') OR (`type` = '3d' AND `status` = 1) OR (`type` = '2d' AND `status` = 1)) ORDER BY `status` DESC, `id` DESC", array($project_id));
		$uploads = $query->result();
		
		$data['uploads'] = $uploads;
		
		$this->load->view('projects/gallery', $data);
		
	}
	
	public function Delete_image($id, $do){
		if ($do == 'do'){
			$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
			$upload = $query->row();
			
			if ($upload->status == 1 && $upload->type == '2d'){
				$this->db->update('projects',array(
					'photo'			=> null
				),array(
					'id'			=> $upload->project_id
				));
			}		
			
			$this->db->query("DELETE FROM `uploads` WHERE `id` = ?",array($id));
		}
	}
	
	public function Get_project_data(){
		$id = $this->input->post('id');
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		echo json_encode($project);
		return;
	}
	
	public function Set_primary($id, $do){
		if ($do == 'do'){
			$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
			$upload = $query->row();
			
			$this->db->update('projects',array(
				'photo'		=> 'uploads/' . $upload->type . '/' . $upload->file
			), array(
				'id'		=> $upload->project_id
			));
		}
	}
	
	public function Download_image($id){
		
		$query = $this->db->query("SELECT * FROM `uploads` WHERE `id` = ?", array($id));
		$upload = $query->row();
		
        $this->load->helper('download');
        
        force_download('uploads/'.$upload->type.'/'.$upload->file, NULL);
	}
	
	public function Save_mould(){
		$this->db->update('moulds',array(
			'mould_maker'						=> $this->input->post('mould_maker'),
			'moulds'							=> json_encode($this->input->post('mould_data')),
			'manufacturing_location'			=> $this->input->post('manufacturing_location'),
			'technical_requirement'				=> $this->input->post('technical_requirement'),
			'manufacturing_requirement'			=> $this->input->post('product_manufacturing_requirement')
		), array(
			'id'								=> $this->input->post('mould_id')
		));
		
		return $this->form->submit_successful();	
	}
	
	public function Save_part(){
		$this->db->update('parts',array(
			'name'			=> $this->input->post('name'),
			'parts'			=> json_encode($this->input->post('part'))
		), array(
			'id'			=> $this->input->post('id')
		));
		
		return $this->form->submit_successful();
	}
	
	public function Delete_part(){
		$part_id = $this->input->post('id');
		$this->db->query("DELETE FROM `parts` WHERE `id` = ?", array($part_id));
	}
	
	public function Add_part($project_id){
		$this->db->insert('parts',array(
			'project_id'	=> $project_id,
			'added_on'		=> date('Y-m-d H:i:s'),
			'added_by'		=> $this->user->data('email')
		));
		
		echo $this->db->insert_id();
	}
	
	public function Add_mould($project_id){
		$this->db->insert('moulds',array(
			'project_id'	=> $project_id,
			'added_on'		=> date('Y-m-d H:i:s'),
			'added_by'		=> $this->user->data('email')
		));
		
		echo $this->db->insert_id();
	}
	
	public function Delete_mould(){
		$mould_id = $this->input->post('id');
		$this->db->query("DELETE FROM `moulds` WHERE `id` = ?", array($mould_id));
	}

	
	public function Get_timeline_form(){
		$id = $this->input->post('id');
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$data['project'] = $query->row();
		
		if ($this->user->has_permission('timeline')){
			$this->load->view('projects/timeline-form',$data);			
		} else {
			$this->load->view('projects/timeline-details',$data);			
		}

		
	}
	
	
	public function Save_forecast($project_id){
		$this->db->update('projects',array(
			'estimated_cost'	=> json_encode($this->input->post('estimated_cost')),
			'actual_sl_cost'	=> json_encode($this->input->post('actual_sl_cost')),
			'capacity'			=> json_encode($this->input->post('capacity')),
			'post_mortem'		=> $this->input->post('post_mortem')
		), array(
			'id'				=> $project_id
		));
		
		return $this->form->submit_successful();
	}
	
	public function Save_timeline(){
		$timeline = $this->input->post('timeline');
		foreach ($timeline as $stage => $t){
			$total_actual += $t['actual'];
			if (!$t['actual'] && !$current_status){
				$current_status = $previous_status;
			}
			$previous_status = $t['status'];
		}
		
		if (!$current_status) $current_status = 'Completed';
		
		
		$this->db->update('projects',array(
			'timeline'		=> json_encode($this->input->post('timeline')),
			'status'		=> $current_status,
			'week'			=> $timeline['week'],
			'current_week'	=> $timeline['week'] + $total_actual,
			'year'			=> $timeline['year']
		), array(
			'id'		=> $this->input->post('id')
		));
	
		return $this->form->submit_successful();	
	}
	
	public function New_project($do){
		if ($do == 'do'){
			
			$data = array(
				'title'						=> $this->input->post('title'),
				'product_code'				=> $this->input->post('product_code'),
				'category'					=> $this->input->post('category'),
				'remarks'					=> $this->input->post('remarks'),
				'target_market'				=> $this->input->post('target_market'),
				'target_customer'			=> $this->input->post('target_customer'),
				'functionality_application'	=> $this->input->post('functionality_application'),
				'purpose_of_development'	=> $this->input->post('purpose_of_development'),
				'usp'						=> $this->input->post('usp'),
				'est_completion_date'		=> date_reformat($this->input->post('est_completion_date')),
				'members'					=> $this->input->post('members'),
				'initiator'					=> $this->input->post('initiator'),
				't0_date'					=> $this->input->post('t0_date'),
				'status'					=> $this->input->post('status'),
				'priority'					=> $this->input->post('priority'),
				'added_on'					=> date('Y-m-d H:i:s')
			);
			
			
			if ($this->input->post('image')){
				$data['photo'] = 'uploads/gallery/' . $this->input->post('image');				
			}
			
			$this->db->insert('projects',$data);
			
			$id = $this->db->insert_id();
			
			if ($this->input->post('image')){
				$this->db->update('uploads',array(
					'project_id'	=> $id
				), array(
					'type'			=> 'gallery',
					'file'			=> $this->input->post('image')
				));
			}	
			
			
			echo 'ok';

			
			return $this->form->submit_successful();
		}
		$this->load->view('projects/new');
	}
	
	public function Edit($id, $do){
		if ($do == 'do'){
			$this->db->update('projects',array(
				'title'						=> $this->input->post('title'),
				'product_code'				=> $this->input->post('product_code'),
				'category'					=> $this->input->post('category'),
				'remarks'					=> $this->input->post('remarks'),
				'target_market'				=> $this->input->post('target_market'),
				'target_customer'			=> $this->input->post('target_customer'),
				'functionality_application'	=> $this->input->post('functionality_application'),
				'purpose_of_development'	=> $this->input->post('purpose_of_development'),
				'usp'						=> $this->input->post('usp'),
				'est_completion_date'		=> date_reformat($this->input->post('est_completion_date')),
				'members'					=> $this->input->post('members'),
				'initiator'					=> $this->input->post('initiator'),
				't0_date'					=> $this->input->post('t0_date'),
				'status'					=> $this->input->post('status'),
				'priority'					=> $this->input->post('priority'),
				'modified_on'				=> date('Y-m-d H:i:s')
			), array(
				'id'						=> $id
			));
			
			redirect('projects/view/'.$id);
		}
		
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$data['project'] = $project;
		
		$this->load->view('projects/edit', $data);
	}
	
	public function Dashboard(){
		

		$data['from_week']	= $from_week	= date('W', strtotime("-7 week"));		
		$data['to_week'] 	= $to_week		= date('W', strtotime("+3 week"));

		$data['from_year']	= $from_year	= date('Y', strtotime("-7 week"));
		$data['to_year']	= $to_year 		= date('Y', strtotime("+3 week"));
		
		
		if ($from_year != $to_year){
			
		} else {
			$query = $this->db->query("SELECT * FROM `projects` WHERE `week` >= ? AND `week` <= ? AND `year` = ? AND `deleted` IS NULL", array($from_week, $to_week, $from_year));
			$data['current_projects'] = $query->result();
			
		}
		
		
		$twelve_colors = array('#2196b9','#1b7998','#157b77','#103c55','#bf3025','#d84f2a','#ef6d2f','#ed8b39','#ecaa45','#ebc751','#a3b870','#5fa794');
		$six_colors = array('#2196b9','#1b7998','#157b77','#bf3025','#eb6b2e','#ebc751','#a3b870');
		$three_colors = array('#2196b9','#103c55','#ef6d2f');
		
		$query = $this->db->query("SELECT * FROM `projects` WHERE `deleted` IS NULL ORDER BY `id` DESC LIMIT 3");
		$data['projects'] = $query->result();
		
		$query = $this->db->query("SELECT COUNT(`id`) AS `total`, `status` FROM `projects` WHERE `status` IS NOT NULL AND `deleted` IS NULL GROUP BY `status`");
		$statuses = $query->result();

		if (count($statuses) <= 12) $color = $twelve_colors;
		if (count($statuses) <= 6) $color = $six_colors;
		if (count($statuses) <= 3) $color = $three_colors;

		$i = 0;
		foreach ($statuses as $status){
			if ($status->status){
				$labels[] = $status->status;
				$datasets['data'][] = $status->total;
				$datasets['backgroundColor'][] = $color[$i];
				$i++;
			}

		}
		$status_data->labels = $labels;
		$status_data->datasets[] = $datasets;
		$data['status_data'] = $status_data;

		
		$query = $this->db->query("SELECT COUNT(`id`) AS `total`, `category` FROM `projects` WHERE `category` IS NOT NULL AND `deleted` IS NULL GROUP BY `category`");
		$categories = $query->result();

		$i = 0;
		
		if (count($categories) <= 12) $color = $twelve_colors;
		if (count($categories) <= 6) $color = $six_colors;
		if (count($categories) <= 3) $color = $three_colors;
		
		$labels = null;
		$datasets = null;
		
		foreach ($categories as $category){
			if ($category->category){
				$labels[] = $category->category;
				$datasets['data'][] = $category->total;
				$datasets['backgroundColor'][] = $color[$i];
				$i++;
			}

		}
		$category_data->labels = $labels;
		$category_data->datasets[] = $datasets;
		$data['category_data'] = $category_data;

		$this->load->view('projects/dashboard', $data);
	}
	
	public function Get_timeline_chart($id){
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$data['project'] = $project;
		$this->load->view('projects/timeline-chart', $data);
	}

	public function Get_costing($id){
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$data['project'] = $project;
		
		$query = $this->db->query("SELECT * FROM `parts` WHERE `project_id` = ?", array($id));
		$parts = $query->result();
		
		$data['parts'] = $parts;
		
		$query = $this->db->query("SELECT * FROM `moulds` WHERE `project_id` = ?", array($id));
		$moulds = $query->result();
		
		$data['moulds'] = $moulds;

		$this->load->view('projects/costing', $data);
	}
	
	public function View($id){
		
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$data['project'] = $project;
		
		$query = $this->db->query("SELECT * FROM `parts` WHERE `project_id` = ?", array($id));
		$parts = $query->result();
		
		$data['parts'] = $parts;
		
		$query = $this->db->query("SELECT * FROM `moulds` WHERE `project_id` = ?", array($id));
		$moulds = $query->result();
		
		$data['moulds'] = $moulds;

		$this->load->view('projects/view', $data);
	}
	
	public function Report($id){
		
		$query = $this->db->query("SELECT * FROM `projects` WHERE `id` = ?", array($id));
		$project = $query->row();
		
		$data['project'] = $project;
		
		$query = $this->db->query("SELECT * FROM `parts` WHERE `project_id` = ?", array($id));
		$parts = $query->result();
		
		$data['parts'] = $parts;
		
		$query = $this->db->query("SELECT * FROM `moulds` WHERE `project_id` = ?", array($id));
		$moulds = $query->result();
		
		$data['moulds'] = $moulds;

		$this->load->view('projects/report', $data);
	}
	
	public function Priority_update(){
		$this->db->update('projects',array(
			'priority'	=> $this->input->post('priority')
		), array(
			'id'		=> $this->input->post('id')
		));
		
		return $this->form->submit_successful();
	}
	
	public function Search(){
		
		$statuses	= $this->input->post('status');
		$categories = $this->input->post('category');
		$term 		= $this->input->post('term');
		
		foreach ($statuses as $status){
			if ($status == '*'){
				$all_statuses = true;
			}
			$status_filter[] = ' `status` = ' . $this->db->escape($status);
		}
		if (!$all_statuses && count($status_filter)){
			$filter[] = '(' . implode(' OR ', $status_filter) . ')';
		}
		
		foreach ($categories as $category){
			if ($status == '*'){
				$all_categories = true;
			}
			$category_filter[] = ' `category` = ' . $this->db->escape($category);
		}
		if (!$all_categories && count($category_filter)){
			$filter[] = '(' . implode(' OR ', $category_filter) . ')';
 		}
		
		if (trim($term)){
			$filter[] = '`title` LIKE ' . $this->db->escape('%'.$term.'%');
		}
		

		if (count($filter)){
			$filter_string = ' WHERE ' . implode(' AND ', $filter);
		}
		
		$query = $this->db->query("SELECT * FROM `projects` $filter_string");
		$data['projects'] = $query->result();
		$data['term'] = $term;
		
		
		$this->load->view('projects/search', $data);
	}
}