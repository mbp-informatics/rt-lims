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
	$('#number-plugged, #total-embryos').change(function(e){
		var labelSelector = "label[for='embryos-plug']";
		var np = $('#number-plugged').val();
		var te = $('#total-embryos').val();
		if (np != '' && te != '' && np != 0) {
			var perc = (te/np).toFixed(2);
			$('#embryos-plug').val(perc);
			lightUp(labelSelector);
		} else {
			$('#embryos-plug').val('');
		}
	})

	//Calculate Embryos/Plug
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
	$('#number-plugged, #total-embryos, #number-plugged, #number-mated').trigger('change');

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
