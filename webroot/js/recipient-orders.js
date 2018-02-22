/*Automaticaly changes calendar dates based on pseudo
state value and vice versa. Used when adding/editting entries
on Pseudorecipient Order page */
$(document).ready(function() {
$('#recharge, #location').selectize({
    create: true,
    sortField: 'text'
});
$('#pseudo-state').selectize({
    create: true,
    sortField: 'text',
    onChange: function() { //Get Pseudo State value in days
        var pseudoState = $( "#pseudo-state option:selected" ).text();
        if (pseudoState == 'e0.5') { var day = 0; }
        if (pseudoState == 'e2.5') { var day = 2; }
        if (pseudoState !== 'e0.5' && pseudoState !== 'e2.5') {
            var pseudoState = $( "#pseudo-state option:selected" ).text();
            var day = pseudoState.match("e(.*)\.");
            day = parseInt(day[1]);
        }
        changeDate(day, 'date_plugged', 'date_needed', '.date-needed');
    }
});

//Calculate pseudoStateValue based on dates
$('select[name="date_plugged[day]"], select[name="date_plugged[month]"], select[name="date_plugged[year]"], select[name="date_needed[day]"], select[name="date_needed[month]"], select[name="date_needed[year]"]').change(function() {
    var datePluggedY = parseInt($('select[name="date_plugged[year]"]').val());
    var datePluggedM = parseInt($('select[name="date_plugged[month]"]').val());
    var datePluggedD = parseInt($('select[name="date_plugged[day]"]').val());

    var dateNeededY = parseInt($('select[name="date_needed[year]"]').val());
    var dateNeededM = parseInt($('select[name="date_needed[month]"]').val());
    var dateNeededD = parseInt($('select[name="date_needed[day]"]').val());

    var datePlugged = new Date(datePluggedY, datePluggedM, datePluggedD);
    var dateNeeded = new Date(dateNeededY, dateNeededM, dateNeededD);

    //calculate the difference between dates in days
    var timeDiff = dateNeeded.getTime() - datePlugged.getTime();
    if (timeDiff < 0) {
        lightUp(".date-needed", "red");
        return;
    }
    timeDiff = Math.abs(timeDiff);
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    changePseudoState(diffDays);
});

function changePseudoState(diffDays) {
   var val = 'e'+ diffDays + '.5';
   var pseudoStateInput = $("#pseudo-state")[0].selectize
   pseudoStateInput.addOption({
    text:val,
    value: val
});
   pseudoStateInput.addItem(val)
   lightUp("label[for='pseudo-state']");
}
});