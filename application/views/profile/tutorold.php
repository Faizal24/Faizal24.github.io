<div class="max1280 padding">
	<h1 class="thin">My Profile</h1>
	
	<hr />
</div>


<div class="max1024 padding min-height-600">

	<form method="post" action="profile/update">
		
		<h2>Administrative Details</h2>
		<p>Please complete the following form for administrative purposes.</p>
		<hr />
		
		<div class="field">
			<label class="grey uppercase small">Full Name</label><br />
			<?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?>

		</div>

		<div class="field">
			<label class="grey uppercase small">NRIC</label><br />
			<?php echo $tutor->nric; ?>
		</div>

		<div class="field">
			<label class="grey uppercase small">Date of Birth</label><br />
			<?php echo date('d/m/Y', strtotime($tutor->dob)); ?>
		</div>
		
		<div class="field">
			<label>Ethnicity<br />
			<input <?php if ($tutor->ethnicitiy == 'Malay') echo 'checked'; ?> type="radio" name="race" value="Malay" /> Malay<br />
			<input <?php if ($tutor->ethnicitiy == 'Chinese') echo 'checked'; ?> type="radio" name="race" value="Chinese" /> Chinese<br />
			<input <?php if ($tutor->ethnicitiy == 'Indian') echo 'checked'; ?> type="radio" name="race" value="Indian" /> Indian<br />
			<input <?php if ($tutor->ethnicitiy == 'Other') echo 'checked'; ?> type="radio" name="race" value="Other" /> Other<br />
			</label>
		</div>
		
		<div class="field">
			<label>Address<br />
			<input value="<?php echo $tutor->address1; ?>" type="text" placeholder="Address 1" name="address1" class="text w50" value="" /><br />
			<input value="<?php echo $tutor->address2; ?>" type="text" placeholder="Address 2 (Optional)" name="address2" class="text w50" value="" /><br />
			<input value="<?php echo $tutor->zipcode; ?>" type="text" placeholder="Zipcode" name="zipcode" class="text w24" value="" style="margin-right: 16px; margin-bottom: 8px" /> 
			<input value="<?php echo $tutor->city; ?>" type="text" placeholder="City" name="city" class="text w24" value="" /><br />
			<?php echo form_dropdown('state',$this->system->get_states(true), $tutor->state, 'class="dropdown w24" style="margin-right: 16px;"'); ?>
			<?php echo form_dropdown('country',$this->system->get_countries(true), $tutor->country ? $tutor->country : 'Malaysia', 'class="dropdown w24"'); ?>
			</label>
		</div>

		<div class="field">
			<label>Occupation<br />
			<input value="<?php echo $tutor->occupation; ?>" type="text" name="occupation" class="text w50" value="" />
			</label>
		</div>
		
		<div class="field">
			<label>Banking information <br />
			<input value="<?php echo $tutor->bank_account_no; ?>" type="text" name="bank_account_no" placeholder="Bank Account Number" class="text w50" value="" />
			<input value="<?php echo $tutor->bank_name; ?>" type="text" name="bank_name" placeholder="Bank Name" class="text w50" value="" />
			</label>
		</div>
		
		<br /><br />
		<h2>Education</h2>
		<hr />
		<table class="grid table-spaced grid">
			<thead>
				<tr>
					<th style="width: 120px">Year</th>
					<th>Institution</th>
					<th style="width: 350px">Certificate / Qualification</th>
				</tr>
			</thead>
			<tbody class="edu">
				<tr class="edu-row">
					<td>
						<input type="text" class="text fw" name="education[year][]" />
					</td>
					<td>
						<input type="text" class="text fw" name="education[institution][]" />
					</td>
					<td>
						<input type="text" class="text fw" name="education[certificate][]" />
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						<a class="add-more-edu">+ Add more</a>
					</td>
				</tr>
			</tfoot>
		</table>
		<script type="text/javascript">
			$(document).ready(function(){
				var edurow = $('tr.edu-row').clone();
				
				$('.add-more-edu').click(function(){
					$('tbody.edu').append(edurow.clone())
				})
			})			
		</script>
		
		
		<br /><br />
		<h2>Totoring locations</h2>
		<p>Please enter the city location you are willing to travel for tutoring.</p>
		<hr />

			<input style="width: 350px" cb="addcity" name="city" id="cities-autocomplete" type="text" class="text" placeholder="Enter city" />
			<ul class="city-list">
				
			</ul>
			<script type="text/javascript">
				
				function addcity(city){
					$('#cities-autocomplete').focus().val('');
					$('.city-list').append('<li><i onclick="$(this).parents(\'li\').remove()" class="fa fa-trash"></i> <input style="display:none" type="hidden" name="city[]" value="'+city+'" />'+city+' </li>');
				}
				$(document).ready(function(){
					
				})				
			</script>
		<hr />
		<p class="align-right"> 
			<button class="btn btn-primary">Next Step</button>
		</p>

		
		
		
	</form>

</div>