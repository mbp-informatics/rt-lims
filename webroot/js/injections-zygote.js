$( document ).ready(function() {

	function displayCalcVal(val, labelSelector) {
		var pluggedObj = $(labelSelector);
		var newString = pluggedObj.html();
		var id = labelSelector.match(/[a-zA-Z]+/g).join('-');
		if ($('#'+id).length == 0) {
			newString += ' <sup><span id="'+id+'" class="calc"></span></sup>';
			pluggedObj.html(newString);
		}
		$('#'+id).html(val);
		lightUp('#'+id);
	}

	//Calculate Number Plugged %
	$('#number-plugged, #number-mated').change(function(e){
		var labelSelector = "label[for='number-plugged']";
		var np = $('#number-plugged').val();
		var nm = $('#number-mated').val();
		if (np != '' && nm != '' && nm != 0) {
			var perc = ((np/nm)*100).toFixed(2)+'%';
			displayCalcVal(perc, labelSelector);	
		} else {
			displayCalcVal('', labelSelector);
		}
	})

	//Calculate Eggs per Plug %
	$('#number-plugged, #total-eggs-collected').change(function(e){
		var labelSelector = "label[for='total-eggs-collected']";
		var np = $('#number-plugged').val();
		var tec = $('#total-eggs-collected').val();
		if (np != '' && tec != '' && np != 0) {
			var perc = (tec/np).toFixed(2) + '/plug';
			displayCalcVal(perc, labelSelector);
		} else {
			displayCalcVal('', labelSelector);
		}
	})

	//Calculate Total zygotes obtained %
	$('#total-zygotes, #total-eggs-collected').change(function(e){
		var labelSelector = "label[for='total-zygotes']";
		var tz = $('#total-zygotes').val();
		var tec = $('#total-eggs-collected').val();
		if (tz != '' && tec != '' && tz != 0) {
			var perc = ((tz/tec)*100).toFixed(2) + '%';
			displayCalcVal(perc, labelSelector);
		} else {
			displayCalcVal('', labelSelector);
		}
	})

	//Calculate Survival %
	$('#number-zygotes-injected, #number-survived').change(function(e){
		var labelSelector = "label[for='survival-rate']";
		var nzi = $('#number-zygotes-injected').val();
		var ns = $('#number-survived').val();
		if (nzi != '' && ns != '' && nzi != 0) {
			var perc = ((ns/nzi)*100).toFixed(2);
			$('#survival-rate').val(perc);
			lightUp(labelSelector);
		} else {
			$('#survival-rate').val('');
		}
	})

	//Calculate 2-cell %
	$('#number-two-cell, #number-survived').change(function(e){
		var labelSelector = "label[for='two-cell-rate']";
		var ntc = $('#number-two-cell').val();
		var ns = $('#number-survived').val();
		if (ntc != '' && ns != '' && ns != 0) {
			var perc = ((ntc/ns)*100).toFixed(2);
			$('#two-cell-rate').val(perc);
			lightUp(labelSelector);
		} else {
			$('#two-cell-rate').val('');
		}
	})
	$('#number-two-cell, #number-survived, #number-survived, #number-zygotes-injected, #number-plugged, #number-mated, #total-zygotes, #total-eggs-collected, #number-plugged, #total-eggs-collected').trigger('change');

	//Display/hide elctroporation fields depending on the switch value
	var prev_ec_vals = [];
	$('.switch-toggle').change(function(e){
		var ec_fields_selector = `
			input[name='voltage'],
			input[name='number_of_pulses'],
			input[name='pulse_duration'],
			input[name='pulse_width']
			`;
		switch ($('#elec-switch input:checked').val()) {
			case '0':
				$('.ep').hide('slow');
				$('#elec-switch').removeClass('ep-toggle');
				$(ec_fields_selector).attr('disabled', true)
				/**
				 * Special case: on edit page when a switch is in off position,
				 * we want to post the fields with empty values to reset them
				 * in the db.
				 */ 
				if (window.location.pathname.split('/')[2] == 'edit') {
					//store old fields in an array so they can be restored later
					$(ec_fields_selector).each(function(k) { 
						prev_ec_vals[k] = $(this).val();
					});
					$(ec_fields_selector).attr('disabled', false)
					$(ec_fields_selector).val('');
				}
			break;
			case '1':
				$('.ep').show('fast');
				$('#elec-switch').addClass('ep-toggle');
				$(ec_fields_selector).attr('disabled', false)
				//populate the fields back with original values
				if (window.location.pathname.split('/')[2] == 'edit' && prev_ec_vals.length > 0) {
					$(ec_fields_selector).each(function(k) { 
						$(this).val(prev_ec_vals[k]);
					});
				}
			break;
		}
	})
	$('.switch-toggle').trigger('change');
});

/* code from qodo.co.uk */
function restrictCharacters(myfield, e) {
    if (!e) var e = window.event
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    var character = String.fromCharCode(code);
    // if they pressed esc... remove focus from field...
    if (code==27) { this.blur(); return false; }
    // ignore if they are press other keys
    // strange because code: 39 is the down key AND ' key...
    // and DEL also equals .
    if (!e.ctrlKey && code!=9 && code!=8 && code!=36 && code!=37 && code!=38 && (code!=39 || (code==39 && character=="'")) && code!=40) {
        if (character.match(/[0-9, ]/g)) {
            return true;
        } else {
            return false;
        }
    }
}