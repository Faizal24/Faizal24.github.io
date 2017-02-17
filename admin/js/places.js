

function initializeCitiesAutocomplete() {
	
	var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
    };

	var options = {
		types: ['(cities)'],
		componentRestrictions: {country: "my"}
	};

	var input = document.getElementById('cities-autocomplete');
	var autocomplete = new google.maps.places.Autocomplete(input, options);
	
	autocomplete.addListener('place_changed', function(){
		var place = autocomplete.getPlace();

		for (var component in componentForm) {
			// document.getElementById(component).value = '';
			// document.getElementById(component).disabled = false;
		}

		// Get each component of the address from the place details
		// and fill the corresponding field on the form.
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			console.log(addressType);
			
			
			
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				console.log(val);
				
				if (addressType == 'locality'){
					$('#cities-autocomplete').val(val);
				}
				
				if (addressType == 'administrative_area_level_1'){
					if (val == 'Federal Territory of Kuala Lumpur'){
						$('#state-autocomplete').val('WP Kuala Lumpur');
					} else if (val == 'Labuan Federal Territory'){
						$('#state-autocomplete').val('WP Labuan');
					} else if (val == 'Federal Territory of Putrajaya'){
						$('#state-autocomplete').val('WP Putrajaya');
					} else if (val == 'Putrajaya'){
						$('#state-autocomplete').val('WP Putrajaya');
					} else {
						$('#state-autocomplete').val(val);
					}
				}
				
				if (addressType == 'country'){
					$('#country-autocomplete').val(val);
				}

			}
		}
	});
}