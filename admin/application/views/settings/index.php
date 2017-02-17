<style>
.terms-manager ul {
	list-style: none;
	margin: 0;
	padding: 0;
}

.terms-manager ul li {
	margin: 0;
	padding: 5px;	
	border: 1px solid #eee;
	border-radius: 5px;
	background: #eee;
	margin-bottom: 1px;
}

.terms-manager ul li.add {
	border: none;
}

.terms-manager ul li.add a {
	color: #1571b7;	
}

.terms-manager ul li:hover {
	background: #f5f5f5;
}

.terms-manager ul li:hover input {
	background: #f5f5f5;
	cursor: pointer;	
}

.terms-manager input {
	margin: 0;
	border: none;
	outline: none;
	width: 80%;
	font-size: 10pt;
	background: #eee;
}

.terms-manager li.add input:focus {
	border: 1px solid #eee;
	border-radius: 5px;
	width: 100%;
	padding: 5px;
	box-sizing: border-box;
}

.terms-manager li input:disabled {

	color: #aaa;
}

.terms-manager li a {
	font-size: 9pt;
	border: 1px solid #ddd;
	padding: 5px;
	border-radius: 5px;
	cursor: pointer;
	background: #e5e5e5;
}

.terms-manager li a:hover {
	background: #fafafa;
}

	
</style>

<script type="text/javascript">
	
$(document).ready(function(){
	$('.terms-manager input').click(function(){
		previous = $(this).val();
	})
	
	$('a.delete').click(function(){
		
		if (!confirm('Are you sure you want to delete this value?')) return false;
		
		var group 	= $(this).parents('ul').attr('rel');
		var id 		= $(this).parents('li').attr('rel');
		var that 	= this;
			
		$.ajax({
			url: 'settings/ajax/delete',
			type: 'post',
			data: {
					group: group,
					id: id
				},
			success: function(){
				$(that).parents('li').remove();
			}
		})
	})
	
	$('.terms-manager input').keypress(function(e){
		if (e.keyCode == 13){
			
			var group 	= $(this).parents('ul').attr('rel');
			var val 	= $(this).val();
			var that 	= this;
			var id 		= $(this).parents('li').attr('rel');

			setTimeout(function(){
				$(that).val(val);
			}, 10);
			
			if ($(this).hasClass('add')){
				$(this).attr('disabled',true);
				

				
				$.ajax({
					url: 'settings/ajax/add',
					type: 'post',
					data: {
							group: group,
							value: val				
						},
					success: function(){
						base.go('settings');
					}
				})
				
				
			} else {
				
				$(this).attr('disabled',true);
				
				$.ajax({
					url: 'settings/ajax/edit',
					type: 'post',
					data: {
							id: id,
							group: group,
							value: val				
						},
					success: function(){
						$(that).addClass('changed');	
						$(that).removeAttr('disabled');
					}
				})
			

			}
		} else {
			
		}
	});
	
	$('.terms-manager input').change(function(){
		$(this).val(previous);
	})	
})
	
</script>

<h1 class="main-separator-blue-tint">Settings</h1>

<div class="project-content pt-15">
	<ul class="tabs mt-10">
		<li><a <?php if ($this->session->flashdata('settings_tab') == '') echo 'class="tab-current"'; ?> rel="config">System Config</a></li>
		<li><a <?php if ($this->session->flashdata('settings_tab') == 'users') echo 'class="tab-current"'; ?> rel="users">Users</a></li>
		<li><a <?php if ($this->session->flashdata('settings_tab') == 'permissions') echo 'class="tab-current"'; ?> rel="permissions">User Types</a></li>
	</ul>


	
	<div class="tab-content tab-current" style="padding: 20px" rel="config">
		
		<div class="terms-manager">
			<h3>Subjects</h3>
			<hr />
			<ul rel="subjects">
			<?php foreach ($this->system->terms('subjects') as $category): ?>
				<li rel="<?php echo $category->id; ?>">
					<span style="float:right">
		
						<?php if ($this->user->has_permission('manage_system')): ?>
						<a class="delete">Delete</a>
						<?php endif; ?>

					</span>
					<?php if ($this->user->has_permission('manage_system')): ?>
						<input type="text" value="<?php echo $category->value; ?>" />
					<?php else: ?>
						<?php echo $category->value; ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
				<?php if ($this->user->has_permission('manage_system')): ?>
				<li class="add">
					<input type="text" value="" placeholder="Add new value" class="add" />
				</li>
				<?php endif; ?>
			</ul>
		</div>
		
		
		
	</div>	
	
	<div class="tab-content pt-10" rel="permissions">
		<?php if ($this->user->has_permission('manage_user')): ?>
		<p class="align-right">
			<a class="btn btn-primary link" href="settings/add_type">Add User Type</a> 
		</p>
		<?php endif; ?>
		
		<?php if ($this->session->flashdata('permission_flag') == 'deleted'): ?>
		<p class="alert darkblue">User type has been deleted.</p>
		<?php endif; ?>

		
		<table class="grid table-spaced table-collapse table-full-width">
			<thead>
				<tr>
					<th>Type</th>
					<?php if ($this->user->has_permission('manage_user')): ?>
					<th>Action</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($user_types as $type): ?>
				<tr>
					<td><?php echo $type->name; ?></td>					
					<?php if ($this->user->has_permission('manage_user')): ?>
					<td style="width: 130px; text-align: center">
						<a class="link btn" href="settings/delete_type/<?php echo $type->id; ?>">Delete</a>						
						<a class="link btn" href="settings/edit_type/<?php echo $type->id; ?>">Edit</a>
					</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class="tab-content pt-10" rel="users">
		<?php if ($this->user->has_permission('manage_user')): ?>
		<p class="align-right">
			<a class="btn btn-primary link" href="settings/add">Add User</a> 
		</p>
		<?php endif; ?>
		
		<?php if ($this->session->flashdata('user_flag') == 'deleted'): ?>
		<p class="alert darkblue">User has been deleted.</p>
		<?php endif; ?>

		
		<table class="grid table-spaced table-collapse table-full-width">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Type</th>
					<?php if ($this->user->has_permission('manage_user')): ?>
					<th>Action</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo $user->firstname; ?> <?php echo $user->lastname; ?></td>
					<td style="width: 10px;"><?php echo $user->email; ?></td>
					<td style="width: 130px; text-align: center"><?php echo $user->type; ?></td>
					<?php if ($this->user->has_permission('manage_user')): ?>
					<td style="width: 130px; text-align: center">
						<a class="link btn" href="settings/delete/<?php echo $user->id; ?>">Delete</a>						
						<a class="link btn" href="settings/edit/<?php echo $user->id; ?>">Edit</a>
					</td>
					<?php endif; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
			
		</table>
			
			
	</div>	
	
</div>


<script type="text/javascript">
	
$(document).ready(function(){
	$('ul.tabs a').click(function(){
		$('div.tab-content').hide();
		var rel = $(this).attr('rel');
		$('div.tab-content[rel='+rel+']').show();
	})
	
	$('.tab-current').click();
})
	
</script>


