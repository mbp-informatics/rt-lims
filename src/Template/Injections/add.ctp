<script>
$( document ).ready(function() {
var prepedList;
var allRtlimsProjects;
var injectionType;
var externalProjectIds;
var projIdCounter = 0;
var linkedProjects = [];

/**
* Check for ?project_id=xxx&job_id=xxx
* If it's foud it means, that it's a KOMP Order 
* project type and a user came from job request page.
* In this situation, a user must not select their own project id
* and a job id is inserted into DOM as hidden input for future use
*/
var myRegexp = /project_id=(\d*)/g;
var params = window.location.search.substring(1);
var match = myRegexp.exec(params);
if (match) {
    var kompOrderProjectId = match[1];
}
var myRegexp = /job_id=(\d*)/g;
var match = myRegexp.exec(params);
if (match) {
    var jobId = match[1];
}

//Initiate create new project dialog
iniDialog('#add-new-project', '/projects/add/', '', null, 600, 660, 'injections');

/* Prep variables etc. */
var $select = $('#selectProject-'+projIdCounter).selectize({ //prepare selectize object (projects dropdown) for later use
    placeholder:"Select from dropdown or start typing..."
});
var selectize = $select[0].selectize;

/* Get all RT-LIMS projects, it'll be needed later
 * by more thtan 1 method, so it's good to preload it.
 */
$('#ajax-loader').show();
$.get( '/projects/index/ajax', function( data ) {
    allRtlimsProjects = data;
    prepedList = prepAllList(JSON.parse(allRtlimsProjects));
    populateProjDropdown(selectize, prepedList);
    $('#ajax-loader').hide();
    $('#b-1').addClass('badge-enabled');
});

function prepAllList(data) {
    list = {};
    for (var i=0; i<data.length; i++) {
        var externalProjectStr = '';
        if (data[i].komp_id_no) {
            externalProjectStr = '(komp project id:' + data[i].komp_id_no + '),';
        }
        if (data[i].mmrrc_id_no) {
            externalProjectStr = '(mmrrc order id:' + data[i].mmrrc_id_no + '),';
        }
        if (data[i].pts_id_no) {
            externalProjectStr = '(pts project id:' + data[i].pts_id_no + '),';
        }
        //Parse an array of genes
        var genesStr = '';
        if (data[i].mgi_genes_dump.length > 0) {
            genesStr = ' gene(s): ';
            for (var ii=0; ii<data[i].mgi_genes_dump.length; ii++) {
                genesStr += data[i].mgi_genes_dump[ii].marker_symbol+' | ';
            }
        }
        list[data[i].id] = data[i].id+', '+data[i].project_type.type + ", " + externalProjectStr + genesStr;
    }
    return list;
}

function populateProjDropdown(selectizeObj, prepedList) {
    selectizeObj.clear();
    selectizeObj.clearOptions();
    selectizeObj.addOption({value: ' ', text: 'None'}); // add empty row
    for (var k in prepedList) {
        selectizeObj.addOption({value: k, text: prepedList[k]}); //selectize.js way
    }
}


    /**
     * EVENT: run this when 'Microinjection' dropdown changes
     */ 
    $('#selectInjType').change(function(e){
        injectionType = $(this).val();
        if (!kompOrderProjectId) {
            selectize.enable();
            $('#b-2').addClass('badge-enabled');
            $('#plus-link').hide();
            if (injectionType == 'crm') {
                $('#plus-link').show();
                lightUp('#plus-link');
            }
        } else {
            selectize.enable();
            selectize.setValue(kompOrderProjectId);
            selectize.disable();
        }
    });


    /**
     * EVENT: run this when "Project" dropdown changes
     */ 
    $('#selectProject-'+projIdCounter).change(function(e){
        $('#selectInjType').prop('disabled', false);
    });


    /**
     * EVENT: run this when "link more projects" is clicked
     */ 
    $('#plus-link').click(function(e){
        projIdCounter++;
        //insert dropdown into the document
        projDropdown = `
            <select class="form-control project-dropdowns" id="selectProject-`+projIdCounter+`"></select>
                `;
        $('#dropdowns').append(projDropdown);
        
        //populate the dropdown with selctize values
        var $select = $('#selectProject-'+projIdCounter).selectize({
            placeholder:"Select from dropdown or start typing..."
        });
        var selectize = $select[0].selectize;
        prepedList = prepAllList(JSON.parse(allRtlimsProjects));
        populateProjDropdown(selectize, prepedList);
    });


    /**
     * EVENT: run "Next > " button is clicked
     */ 
    $('#next-button').click(function(e){
        $('#ajax-loader').show();

        //Prepare a hidden form with linked project ids
        var hiddenForms = '';
        for (var i=0; projIdCounter >= i; i++) {
            var projId = $('#selectProject-'+i).val();
            if (projId != ' ') {
                linkedProjects.push( projId );
                hiddenForms += "<input type='hidden' value='"+projId+"' name='linkedProjects["+projId+"]'>";
            }
        }

        //Insert job id hidden input into the DOM
        hiddenForms += "<input id='job-id' type='hidden' value='"+jobId+"' name='job_id'>";

        $.get( "/injections/add/"+ injectionType +"/downmark<?= isset($_GET['pull-from-injection']) ? '?pull-from-injection='.$_GET['pull-from-injection']: '' ?>", function( data ) {
            $("#preForm").remove();
                        
            //append hidden fields (proj ids) to a new form
            var $dom = $('<div>', {html:data});
            $dom.find('form').append(hiddenForms);
            injectionForm = $dom.html();
            $("#injection-form").html(injectionForm);
            
            //Craft selectize dropdown to show project ids
            var $select = $('#project-id').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            selectize.addOption({value:0, text:'Selected RT-LIMS Project(s) ID: '+linkedProjects.join()});
            selectize.setValue(0);
            $('#ajax-loader').hide();
        });
    });


}); //end document ready
</script>
    <?php
    if (isset($_GET['pull-from-injection'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php if (isset($injectionToPullFrom)) { ?> <span class="glyphicon glyphicon-save"></span> <?php } ?>
            You're pulling in Superovulation and Embryo Cryo values from Injection ID: <a target="_BLANK" href="/injections/view/<?= $_GET['pull-from-injection'] ?>"><?= $_GET['pull-from-injection'] ?></a>
        </div>
    <?php } 
    if (isset($_GET['job_id'])) { ?>
        <div class="alert alert-success" role="alert">
            The new Injection you are about to create wil be linked to Job ID: <a target="_BLANK" href="/jobs/view/<?= $_GET['job_id'] ?>"><?= $_GET['job_id'] ?></a>
        </div>
    <?php } ?>

<div class="injections form large-9 medium-8 columns content" id="preForm">
<div class="important">
    <p style="margin-bottom:25px;">Please select project and microinjection options first to see the correct form.</p>
        <div class="row form-group">
        <div class="col-xs-12">
            <div class="form-group select"><label class="control-label"><span id="b-1" class="badge">1</span> Microinjection type: </label>
                <select class="form-control" id="selectInjType">
                    <option value="placeholder">Select from dropdown...</option>
                    <option value="crm">Mixed (CRM)</option>
                    <option value="cr">CRISPR (CR)</option>
                    <option value="pn">Pronuclear (PN)</option>
                    <option value="bl">Blast (BL)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <div id="dropdowns">
                <div class="form-group select"><label class="control-label"><span id="b-2" class="badge">2</span> Link project(s): </label>
                    <select class="form-control project-dropdowns" id="selectProject-0" disabled></select>
                </div>
            </div>
        </div>
    </div>
    <p class="pull-right" id="plus-link" style="cursor:pointer; display:none"><small><span class="glyphicon glyphicon-plus"></span> Link more projects**</small></p>
    <button id="next-button" class="btn btn-success pad-button pull-left">Next ></button>
    <div style="clear:both;"></div>
    </div>

    <p class="hr"></p>
    <div id="dialog-add-new-project" title="Create a new project"></div>
    <button id="add-new-project" class="btn btn-primary pad-button pull-left"><span class="glyphicon glyphicon-list-alt"></span> New project *</button>
    <div style="clear:both;"></div><br/>
    <p><strong>*</strong> <small>Use this button, if you cannot find a project you need on the project's list.</small></p>
    <p><strong>**</strong> <small>CRM injection can be linked to more than 1 project. Use the <span class="glyphicon glyphicon-plus"></span> to link multiple projects. </small></p>
</div>


<div id='injection-form'></div>
<p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Loading. Please wait...</small></p>

<style>
#ajax-loader {
    display:none;
}

.badge-enabled {
    background-color:green;
}

.hr {
    margin-top:145px;
    border: 1px solid #ddd;
}
.project-dropdowns {
    margin: 25px 0px !important;
}
</style>