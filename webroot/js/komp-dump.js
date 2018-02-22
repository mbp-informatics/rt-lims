$(document).ready(function(){
var middlewareHost = window.DEBUG ? 'https://api-ns-staging.mousebiology.org/' : 'https://api-ns.mousebiology.org/'

toggleSpinner(); //the initial check

//Check every n seconds if a table is updated
setInterval(function(){ toggleSpinner(); }, 5000);

var komp_tables = ['komp_clones_dump', 'komp_genes_dump', 'komp_projects_dump', 'komp_vials_dump', 'mgi_genes_dump'];
var controllerName = (window.location.pathname).replace('/', '');

//Find the right lock name for this page
for (var k in komp_tables) {
	if (komp_tables[k] == controllerName.replace(/-/g, '_')) { //replace all occurrences of a dash
		var lockName = komp_tables[k];
		break;
	}
}

//Show spinner and info when tables are being updated
function toggleSpinner() {
	$.get( middlewareHost+'get-all-locks', function( jsonData ) {
		var data = JSON.parse(jsonData);
		if (data.length == 0) { //no locks returned
			$('#super-spinner').hide('slow');
			return;
		}
	    for (var k in data){
	    	if (data[k].lock_name == lockName && data[k].status == 'working') {
	    		$('#super-spinner').show('slow');
	    		$('#job-date').html(data[k].created);
	    		break;
	    	}
	    $('#super-spinner').hide('slow');
	    }
	});
}
    
});
