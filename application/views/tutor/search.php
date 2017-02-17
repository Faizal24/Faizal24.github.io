<script type="text/javascript">
$(document).ready(function(){
	$('input.grade').change();
	$('input.subject').val('<?php echo $search['subject']; ?>');
})
</script>

<div class="max1280 g padding">
	
	<div class="search-sidebar">
		<form class="sm-none md-none" method="post" action="tutor/search">			
			<h3>You searched for:</h3>

			<input value="<?php echo $search['state']; ?>" type="hidden" name="state" id="state-autocomplete" />
			<input value="<?php echo $search['country']; ?>" type="hidden" name="country" id="country-autocomplete" />
			
			<div class="edit-search inline sm-1-2 md-1-2">
				<p>What city do you live in?</p>
				<input value="<?php echo $search['city']; ?>" name="city" id="cities-autocomplete" type="text" class="text" />
			</div>
			<div class="edit-search inline sm-1-2 md-1-2">
				<p>Grade</p>
				<div class="input-select">
					<input value="<?php echo $search['grade']; ?>" name="grade" readonly="true" type="text" class="text w80px grade" placeholder="Grade" />
					<ul class="animated bounceIn">
						<li>Std 1-3</li>
						<li>Std 4-6</li>
						<li>Form 1-3 (PT3)</li>
						<li>Form 4-5 (SPM)</li>
						<li>O-Level / IGCSE</li>
						<li>A-Level / Pre-U</li>
					</ul>
				</div>
			</div>
			<div class="edit-search inline sm-1-2 md-1-2">
				<p>Subject</p>
				<div class="input-select">
					<input value="<?php echo $search['subject']; ?>" name="subject" readonly="true" type="text"  class="text w80px subject" placeholder="Subject" />
					<ul class="subject animated bounceIn">
						<li rel="" class="no-select"><i>Select a grade before choosing a subject</i></li>
						<li rel="Std-1-3">Bahasa Melayu</li>
						<li rel="Std-1-3">English</li>
						<li rel="Std-1-3">Science</li>
						<li rel="Std-1-3">Mathematics</li>
						<li rel="Std-4-6">Bahasa Melayu</li>
						<li rel="Std-4-6">English</li>
						<li rel="Std-4-6">Science</li>
						<li rel="Std-4-6">Mathematics</li>
						<li rel="Form-1-3-PT3">Bahasa Melayu</li>
						<li rel="Form-1-3-PT3">English</li>
						<li rel="Form-1-3-PT3">Science</li>
						<li rel="Form-1-3-PT3">Mathematics</li>
						<li rel="Form-1-3-PT3">Geography</li>
						<li rel="Form-1-3-PT3">Kemahiran Hidup</li>
						<li rel="Form-1-3-PT3">Sejarah</li>
	
					</ul>
				</div>
			</div>
			<div class="edit-search inline sm-1-2 md-1-2">
				<p>Hours per lesson</p>
				<div class="input-select">
					<input value="<?php echo $search['hours']; ?>" name="hours" readonly="true" type="text" class="text w140px" placeholder="Hours per lesson" />
					<ul class="animated bounceIn">
						<li>1 hour</li>
						<li>1.5 hours</li>
						<li>2 hours</li>
						<li>2.5 hours</li>
						<li>3 hours</li>
					</ul>
				</div>
			</div>
			<div class="edit-search inline sm md preferred-time">
				<p>Preferred tuition time</p>
				<input value="<?php echo $search['preferred_time']; ?>" name="preferred_time" readonly="true" type="hidden" class="text hold w140px" placeholder="Preferred time" />
				<?php 
					$pt = explode(', ',$search['preferred_time']); 
				?>
				<div class="input-select">
					<table>
						<thead>
						<tr>
							<th></th>
							<th>8am - 12pm</th>
							<th>12am - 6pm</th>
							<th>6pm - 11pm</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>Sun</td>
							<td class="align-center"><span<?php if (in_array('Sun - Morning', $pt)) echo ' class="selected"'; ?>>Sun - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Sun - Afternoon', $pt)) echo ' class="selected"'; ?>>Sun - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Sun - Evening', $pt)) echo ' class="selected"'; ?>>Sun - Evening</span></td>
						</tr>
						<tr>
							<td>Mon</td>
							<td class="align-center"><span<?php if (in_array('Mon - Morning', $pt)) echo ' class="selected"'; ?>>Mon - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Mon - Afternoon', $pt)) echo ' class="selected"'; ?>>Mon - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Mon - Evening', $pt)) echo ' class="selected"'; ?>>Mon - Evening</span></td>
						</tr>
						<tr>
							<td>Tue</td>
							<td class="align-center"><span<?php if (in_array('Tue - Morning', $pt)) echo ' class="selected"'; ?>>Tue - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Tue - Afternoon', $pt)) echo ' class="selected"'; ?>>Tue - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Tue - Evening', $pt)) echo ' class="selected"'; ?>>Tue - Evening</span></td>
						</tr>
						<tr>
							<td>Wed</td>
							<td class="align-center"><span<?php if (in_array('Wed - Morning', $pt)) echo ' class="selected"'; ?>>Wed - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Wed - Afternoon', $pt)) echo ' class="selected"'; ?>>Wed - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Wed - Evening', $pt)) echo ' class="selected"'; ?>>Wed - Evening</span></td>
						</tr>
						<tr>
							<td>Thu</td>
							<td class="align-center"><span<?php if (in_array('Thu - Morning', $pt)) echo ' class="selected"'; ?>>Thu - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Thu - Afternoon', $pt)) echo ' class="selected"'; ?>>Thu - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Thu - Evening', $pt)) echo ' class="selected"'; ?>>Thu - Evening</span></td>
						</tr>
						<tr>
							<td>Fri</td>
							<td class="align-center"><span<?php if (in_array('Fri - Morning', $pt)) echo ' class="selected"'; ?>>Fri - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Fri - Afternoon', $pt)) echo ' class="selected"'; ?>>Fri - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Fri - Evening', $pt)) echo ' class="selected"'; ?>>Fri - Evening</span></td>
						</tr>
						<tr>
							<td>Sat</td>
							<td class="align-center"><span<?php if (in_array('Sat - Morning', $pt)) echo ' class="selected"'; ?>>Sat - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Sat - Afternoon', $pt)) echo ' class="selected"'; ?>>Sat - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Sat - Evening', $pt)) echo ' class="selected"'; ?>>Sat - Evening</span></td>
						</tr>

						</tbody>
					</table>
				</div>			
			</div>
			<div class="spacer"></div>
			<div class="search-action inline sm md">
				<button class="btn btn-primary sm md w100"> Refine Search</button>
				
			</div>
			
		</form>
		
	</div>
	
	<script type="text/javascript">
		
		$(document).ready(function(){
			
			$('input[name=sort]').change(function(){
				var val = $(this).val();
				

				
				if (val == 'Rating') var attr = 'rating';
				if (val == 'Rate per hour') var attr = 'rate';
				if (val == 'Name') var attr = 'name';
				if (attr == 'rating'){
					$('.tutor-result tutor-item').sort(function(a,b) {			
						 return $(a).attr(attr) < $(b).attr(attr)
					}).appendTo('.tutor-result');
					
				} else {
					$('.tutor-result tutor-item').sort(function(a,b) {			
						 return $(a).attr(attr) > $(b).attr(attr)
					}).appendTo('.tutor-result');
					
				}

			})
		})
		
	</script>
	
	<div class="search-result">
		<div class="search-filter">
			<small>Sort by </small>
			<div class="input-select">
				<input value="Rating" name="sort" readonly="true" type="text" class="text sort input-red w140px" />
				<ul class="animated bounceIn">
					<li>Rating</li>
					<li>Rate per hour</li>
					<li>Name</li>
				</ul>
			</div>
		</div>
		<h3 class="thin"><?php echo count($tutors); ?> <?php echo $search['subject']; ?> Tutor(s) match your search.</h3>
		<div class="tutor-result">

			<?php foreach ($tutors as $tutor): ?>
			
			<?php
				$search_subject_grade = $search['grade'] . '|' . $search['subject'];
				
				$tutor->subjects = $this->user->tutor_subjects($tutor);
				foreach ($tutor->subjects as $s){
					$subjects[$s->grade.'|'.$s->subject.'|'.str_replace('.','',$s->rate)] = $s->grade . ' &mdash; ' . $s->subject ;
					
					if ($s->grade.'|'.$s->subject == $search_subject_grade){
						$tutor->rate = $s->rate;
						$search_subject_grade = $s->grade.'|'.$s->subject.'|'.str_replace('.','',$s->rate);
					}
				}	
				
				

			?>
				<div class="tutor-item" rating="<?php echo $tutor->review_rating; ?>" rate="<?php echo $tutor->rate; ?>" name="<?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?>">
					
					<div class="tutor-engage">
						<span class="tutor-rate">RM<?php echo $tutor->rate; ?>/hour</span>
						<div>
							<div class="primary" style="font-size: 8pt">
							<?php for ($i = 0; $i < round($tutor->review_rating); $i++): ?>
							<i class="fa fa-star"></i>
							<?php endfor; ?>
							<?php for ($i = 0; $i < 5 - round($tutor->review_rating); $i++): ?>
							<i class="fa fa-star-o"></i>			
							<?php endfor; ?>
							
							&nbsp; <?php echo number_format($tutor->review_rating,1); ?>
							</div>
							<small>(<?php echo $tutor->review_count == 1 ? number_format($tutor->review_count) . ' review' : number_format($tutor->review_count) . ' reviews'; ?>)</small>
						</div>
						<div class="spacer"></div>
						<div class="tutor-view">
							<a class="btn btn-primary" href="tutor/view/<?php echo $tutor->id; ?>">View Profile</a>
						</div>
					</div>
					
					<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
					<div class="tutor-details">
						<h4><a href="tutor/view/<?php echo $tutor->id; ?>"><?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="icon-<?php echo strtolower($tutor->gender); ?>"></i></a></h4>
						<small>
						<?php $q = json_decode($tutor->education); ?>
			<?php for ($i = 0; $i < 1; $i++): ?>
<?php echo $q->certificate[$i]; ?>, <?php echo $q->institution[$i]; ?> &mdash; <?php echo $q->year[$i]; ?>
			<?php endfor; ?>
						</small>
						<p><?php echo truncate($tutor->about,150); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		
	</div>


</div>

<div class="spacer"></div>
<div class="spacer"></div>
<div class="spacer"></div>
