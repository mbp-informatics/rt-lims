/** 
 *  Gets the Job JSON object by Job ID and 
 *  prepopulates the fields accordingly.
 *  @author <tczurak@ucdavis.edu>
 */
$( document ).ready(function() {

    function popField(fieldName, json, formFieldName = null) {
        var jsonFieldName = fieldName.replaceAll('-', '_');
        if (formFieldName) {
            try {
                var $select = $('#'+formFieldName);
                var selectize = $select[0].selectize;
                selectize.addOption({value:json[jsonFieldName], text:json[jsonFieldName]});
                selectize.setValue(json[jsonFieldName]);
            } catch (e) {
                //Looks like it's not a selectize.js object
                //so let's set value in a traditional way
                $('#'+formFieldName).val(json[jsonFieldName]);    
            }
        } else {
            $('#'+fieldName).val(json[jsonFieldName]);
        }
    }

    var injPageMapping = {
        //json_field : form field
        'inj_parental_line' : 'parental-esc-line',
        'membership' : 'membership',
        'order_no' : 'pts-ko-mo'
    };

    var jobFields = [
        'membership',
        'strain-name',
        'background',
        'mmrrc-no',
        'esc-clone-id-no',
        'sc-tt-batch-no',
        'bl-no',
        'order-no'
    ];


    var piFields = [
        'pi-first-name',
        'pi-last-name'
    ];

    var ecFields = [
        'female-strain-name',
    ];

    var ivfJsonFields = [
        'sperm_info_donor_strain',
        'stud_id_no',
        'stud_dob',
        'genotype',
        'eggs_info_donor_strain',
        'females_out_no',
        'eggs_info_genotype'
    ];
    
    var ivfFormFields = [
        'stud-strain',
        'stud-id-no',
        'stud-dob', //date
        'male-genotype', //selectize
        'female-strain-name', //selectize
        'no-females-used',
        'female-genotype' //selectize
    ];    


$('#job-id').change(function() {
    $('#ajax-loader').show();
    var jobId = $(this).val();
    $.get('/jobs/view/'+jobId+'/ajax', function(data) {
        var json = JSON.parse(data);
        //populate regular fields
        for (i = 0; i<jobFields.length; i++) {
            popField(jobFields[i], json);
            lightUp($('#'+jobFields[i]));
        }
        // Find Principal Investigator in JSON
        for (i = 0; i<json.contacts.length; i++) {
            if (json.contacts[i].contact_type_id == 1) { // 1 = Principal Investigator
                var pi = json.contacts[i];
                break; //we've found (first) PI, no use looping further
            }
        }
        //Now populate 'Principal Investigator' field (#pi) in the form
        if (pi) {
                //populate pi field with full name
                var piFullName = pi.first_name+' '+pi.last_name;
                popField('pi', {'pi': piFullName});
                popField('investigator', {'investigator': piFullName}); //esc microinjection page
                lightUp($('#pi'));
        }

        //Populate fields on injections page - their names are different so we're going to use some maaping
        for(var k in injPageMapping) {
          popField(k, json, injPageMapping[k]);
        }
        lightUp($('#'+injPageMapping[k]));
        $('#ajax-loader').hide();
    });
    //Now update <span id="selected-job"></span> with currently selected job id
    $('#selected-job').html(jobId);

});


$('#embryo-cryo-id').change(function() {
    $('#ajax-loader').show();
    var ecCryoId = $(this).val();
    $.get('/embryo_cryos/view/'+ecCryoId+'/ajax', function(data) {
        var json = JSON.parse(data);
        for (i = 0; i<ecFields.length; i++) {
            popField(ecFields[i], json);
            lightUp($('#'+ecFields[i]));
        }
        $('#ajax-loader').hide();
    });
    //Now update <span id="selected-ec-cryo"></span> with currently selected ec cryo id
    $('#selected-ec-cryo').html(ecCryoId);
});

$('#ivf-id').change(function() {
    var ivfId = $(this).val();
    if (ivfId == '') {
        $('#ivf-info').hide();
    } else {
        $('#ajax-loader').show();
        $.get('/ivfs/view/'+ivfId+'/ajax', function(data) {
            var json = JSON.parse(data);
            for (i = 0; i<ivfJsonFields.length; i++) {
                if ('stud-dob' == ivfFormFields[i]) {
                    var date = new Date(json[ivfJsonFields[i]]);
                    var day = date.getDate();
                    day = day.toString();
                    if (day.length < 2) {
                        day = '0'+day;
                    }
                    var month = (date.getMonth()) + 1;
                    month = month.toString();
                    if (month.length < 2) {
                        month = '0'+month;
                    }
                    var year = date.getFullYear();
                    jsonFieldValue = year+'-'+month+'-'+day;
                    $('#stud-dob').val(jsonFieldValue);
                } else if(ivfFormFields[i] == 'male-genotype' || ivfFormFields[i] == 'female-strain-name' || ivfFormFields[i] == 'female-genotype') {
                    var $select = $('#'+ivfFormFields[i]).selectize();
                    var selectize = $select[0].selectize;
                    selectize.createItem( json[ivfJsonFields[i]] , false );
                    selectize.setValue(json[ivfJsonFields[i]]);
                } else {
                    popField(ivfJsonFields[i], json, ivfFormFields[i]);
                }
                lightUp($("label[for='"+ ivfFormFields[i] +"']"));
            }
            $('#ajax-loader').hide();
            $('#ivf-info').show();
        });
        //Now update <span id="selected-ivf"></span> with currently selected ivf id
        $('#selected-ivf').html(ivfId);
    }
});



});