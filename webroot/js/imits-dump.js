$(document).ready(function(){
var middlewareHost = window.DEBUG ? 'https://api-ns-staging.mousebiology.org/' : 'https://api-ns.mousebiology.org/'
toggleSpinner(); //the initial check
//Check every n seconds if a table is updated
setInterval(function(){ toggleSpinner(); }, 5000);

//Show spinner and info when tables are being updated
function toggleSpinner() {
	$.get( middlewareHost+'get-all-locks', function( jsonData ) {
		var data = JSON.parse(jsonData);
		if (data.length == 0) {
			$('#super-spinner').hide('slow');
			return;
		}
	    for (var k in data){
	    	if (data[k].lock_name == 'imitsDump' && data[k].status == 'working') {
	    		$('#super-spinner').show('slow');
	    		$('#job-date').html(data[k].created);
	    		break;
	    	}
	    $('#super-spinner').hide('slow');
	    }
	});
}
    
});
