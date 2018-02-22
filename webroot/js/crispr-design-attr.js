$(document).ready(function() {
/* Getting sequence from gRNA using API 
Use the following gRNA sequence for testing:
test seq = ACAGACAGACATGTTAAGCC (returns 1 entry)
Used when adding/editting entries on CRISPR Design
Attributes page
*/

//Initiate global arrays
var prevSeq;
var results = [];

//inititate the selectize.js form
var select = $("#seq").selectize({
    create: true,
    sortField: 'text',
    onBlur: function() {
        var gRNAseq = $( "#seq" ).val();
        if (gRNAseq.length !==20 && gRNAseq.length !== 0) { //don't run the query if found sequence is in the field
            if (findSeq(gRNAseq)) {
            prePopulate(gRNAseq); //but prepopulate remaining fields with values
            } else {
                alert("The entered sequence is not 20 characters long. The Sanger API only accepts sequences 20 characters long.\nPlease fll out the rest of the form manually.")
            }
            return;
        }
        if (prevSeq == gRNAseq) { //don't run the query if prev and now sequences are same, again, again
            return;
        }
        if (gRNAseq.length == 0) { //don't run the query if field is empty
            return;
        }
        $("#spinner").show();
        querySeqApi(gRNAseq);
    }
});
//query API
function querySeqApi(gRNAseq) {
    $.ajax({
      method: "GET",
      url: "/imits/get_seq",
      data: { grna: gRNAseq }
    })
      .done(function( data ) {
        $("#spinner").hide();
        var array = JSON.parse(data);
        if (!array) {
            alert("Error: No sequences found.");
            clearEntries();
            return;
        }
        if (array.error) {
            alert("Error: " + array.error);
            clearEntries()
            return;
        }
        clearEntries();
        for(var i=0;i<array.length;i++){
            results.push({id:i, seq:array[i]["seq"], chr_start:array[i]["chr_start"], chr_end:array[i]["chr_end"], chr_name:array[i]["chr_name"]});
            addSelectEntry(array[0]["seq"]);
        }
        prevSeq = gRNAseq;
      });
}
//add option to the form
function addSelectEntry(seq) {
    var input = select[0].selectize;
    input.addOption({value:seq,text:seq + " (found CRISPR sequence)"});
    input.refreshOptions();
}
//clear form when
function clearEntries() {
    var input = select[0].selectize;
    input.clear();
    input.clearOptions();
}
//prepopulate chromosome, chrs_start, chr_end fields with data from API
function prePopulate(seq) {
    for (var i=0;i<results.length; i++) {
        if (results[i].seq == seq) {
            $( "#chromosome").val(results[i].chr_name);
            lightUp("label[for='chromosome']");
            $( "#chr-start").val(results[i].chr_start);
            lightUp("label[for='chr-start']");
            $( "#chr-end").val(results[i].chr_end);
            lightUp("label[for='chr-end']");
        }
    }
}
//returns true if sequence is in a result set
function findSeq(seq) {
    for (var i=0;i<results.length; i++) {
        if (results[i].seq == seq) {
            return true;
        }
    }
}
});
