<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project, ['id' => 'project-form']) ?>
    <fieldset>
        <legend><?= __('Create RT-LIMS Project') ?></legend>
        <?php
            echo $this->Form->input('project_type_id', ['options' => $projectTypes, 'empty' => true]); 
        ?>
        <div id="dropdowns" class="important" style="margin-bottom:20px">
            <?= $this->Form->input('external_project_id', ['label' => 'Associated external project', 'disabled' => true]); ?>
            <div id="singleGeneDropdown">
                <?= $this->Form->input('mgi_accession_id', ['label' => 'Gene', 'empty' => true, 'disabled' => true]); ?>
            </div>
            <p class="pull-right" id="plus-link" style="cursor:pointer; display:none"><small><span class="glyphicon glyphicon-plus"></span> Link more genes</small></p>
            <div class="clearfix"></div>
        </div>
        <?php
            echo $this->Form->input('project_status_id', ['options' => $projectStatuses, 'empty' => true]);
            echo $this->Form->input('mutation_id', ['options' => $mutations, 'empty' => true]);
            echo $this->Form->input('phenotype_id', ['options' => $phenotypes, 'empty' => true]);
            echo $this->Form->input('custom_name', ['empty' => true, 'label' => 'Custom Project Name', 'disabled' => true]);
            echo $this->Form->input('comments', ['type' => 'textarea', 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'id' => 'submit-button',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>

<style>
.hr {
    margin-top:125px;
    border: 1px solid #ddd;
}
</style>


<script>
$( document ).ready(function() {
var prepedList;
var kompProjects;
var projectTypesGenes;
var middlewareHost = window.DEBUG ? 'https://api-ns-staging.mousebiology.org/' : 'https://api-ns.mousebiology.org/'
var allRtlimsProjects;
var allMmrrcOrders;
var mgiAcessionIds;
var ptsGenesDropdownInit = {
    valueField: 'mgi_accession_id',
    labelField: 'marker_symbol',
    searchField: 'marker_symbol',
    placeholder:"Enter gene name/MGI to get suggestions. 3 chars minimum!",
    options: [],
    persist: false,
    loadThrottle: 800,
    create: false,
    allowEmptyOption: true,
    load: function(query, callback) {
        $('#ajax-loader').show();
        if (!query.length || query.length < 3) {
            $('#ajax-loader').hide();
            return callback();
        }
        $.ajax({
            url: '/mgi-genes-dump/index/ajax/',
            type: 'GET',
            dataType: 'json',
            data: {
                s: query,
            },
            error: function() {
                $('#ajax-loader').hide();
                return callback();
            },
            success: function(res) {
                if (res.mgiGenesDump.length === 0) {
                    alert('No genes found fo query: '+query);
                    $('#ajax-loader').hide();
                    return callback();
                }
                prepedList = [];
                for (k in res.mgiGenesDump) {
                    prepedList.push( {mgi_accession_id : res.mgiGenesDump[k].mgi_accession_id, marker_symbol:res.mgiGenesDump[k].marker_symbol+' ('+ res.mgiGenesDump[k].mgi_accession_id +')'} );
                }
                $('#ajax-loader').hide();
                callback(prepedList);
            }
        });
    }
};

var ptsGenesDropdownInitCounter = 0;

/* Prep variables etc. */
var url = middlewareHost;
var $select = $('#external-project-id').selectize({ //prepare selectize object (projects dropdown) for later use
    placeholder:"Select from dropdown or start typing..."
});
var selectizeProjects = $select[0].selectize;

var $select = $('#mgi-accession-id').selectize({
    placeholder:"Select from dropdown or start typing..."
});
var selectizeGenes = $select[0].selectize;

/* Get all RT-LIMS projects, projcts-genes, etc. they'll be needed later
 * by more thtan 1 method, so it's good to preload this data.
 */
$.get( '/projects/index/ajax', function( data ) {
    allRtlimsProjects = data;
});
$.get( '/project-types-genes/index/ajax', function( data ) {
    projectTypesGenes = data;
});
$.get( url + 'get-mmrrc-orders-view', function( data ) {
    allMmrrcOrders = data;
});

function populateGenesDropdown(prepedList) {
    
    //Destroy previous selectize.js dropdown
    $select = $('#mgi-accession-id').selectize();
    $select[0].selectize.destroy();

    //Initiate selectize.js dropdown
    $select = $('#mgi-accession-id').selectize({
        placeholder:"Select from dropdown or start typing..."
    });
    selectizeGenes = $select[0].selectize;

    selectizeGenes.addOption({value: '__none__', text: 'None'}); // add empty row
    for (var k in prepedList) {
        selectizeGenes.addOption({value: k, text: prepedList[k]}); //selectizeProjects.js way
    }
    selectizeGenes.enable();
}

function prepGenesList(data, projectTypeId) {
    list = {};
    for (var i=0; i<data.length; i++) {
        if (data[i].project_type_id != projectTypeId) {
            continue; //get genes associated with a given project type only
        }
        var synonyms = data[i].mgi_genes_dump.marker_synonyms ? ' ('+data[i].mgi_genes_dump.marker_synonyms+')' : '';
        list[data[i].mgi_accession_id] = data[i].mgi_genes_dump.marker_symbol + synonyms + ' ' +data[i].mgi_accession_id;
    }
    return list;
}

function clearSelectize(selObj, disabled=null) {
    selObj.clear();
    selObj.clearOptions();
    if (disabled) {
        selObj.disable();
    }
}

    /**
     * EVENT: run this when "Project type" dropdown changes
     */ 
    $('#project-type-id').change(function(e) {

        /* Helper functions */
        function searchRtlimsProjects(field, value) {
            data = JSON.parse(allRtlimsProjects);
            for (var i=0; i<data.length; i++) {
                if (data[i][field] == value) {
                    return data[i];
                }
            }
            return false;
        }
        function prepKompList(data) {
            list = {};
            for (var i=0; i<data.length; i++) {
                if (searchRtlimsProjects('komp_id_no', data[i].komp_id)) {
                    continue; //Skip those KOMP projects that are already in RT-LIMS
                }
                list[data[i].komp_id] = "KOMP project id:" + data[i].komp_id + ', colony name:' + data[i].colony_name + ', clone name:' + data[i].clone_name;
            }
            return list;
        }
        function prepMmrrcList(data) {
            list = {};
            for (var i=0; i<data.length; i++) {
                if (searchRtlimsProjects('mmrrc_id_no', data[i].mmrrc_order_oid)) {
                    continue; //Skip those MMRRC projects that are already in RT-LIMS
                }
                list[data[i].mmrrc_order_oid] = "MMRRC order id:" + data[i].mmrrc_order_oid + ', submission id:' + data[i].order_submission_oid;
            }
            return list;
        }
        function prepPtsList(data) {
            list = {};
            for (var i=0; i<data.length; i++) {
                if (searchRtlimsProjects('pts_id_no', data[i].pts_project_id)) {
                    continue; //Skip those PTS projects that are already in RT-LIMS
                }
                list[data[i].pts_project_id] = "PTS project id:" + data[i].pts_project_id + ', name:' + data[i].project_name;
            }
            return list;
        }
        function populateProjDropdown(prepedList) {
            selectizeProjects.clear();
            selectizeProjects.clearOptions();
            for (var k in prepedList) {
                // $('#selectProject').append('<option value="' + k + '">' + prepedList[k] + '</option>');
                selectizeProjects.addOption({value: k, text: prepedList[k]}); //selectizeProjects.js way

            }
        }

        /* Main Logic */
        var projectTypeId = $(this).val();
        switch (projectTypeId) {
            case '1': //KOMP
            $('#ajax-loader').show();
            $.get('/komp-projects-dump/index/ajax', function( data ) {
                kompProjects = JSON.parse(data);
                prepedList = prepKompList(kompProjects);
                populateProjDropdown(prepedList);
                selectizeProjects.enable();
                clearSelectize(selectizeGenes, true)
                lightUp("label[for='external-project-id']");
                $('#ajax-loader').hide();
            });
            break;

            case '3': //MMRRC
            $('#ajax-loader').show();
            prepedList = prepMmrrcList(JSON.parse(allMmrrcOrders));
            populateProjDropdown(prepedList);
            selectizeProjects.enable();
            clearSelectize(selectizeGenes, true)
            lightUp("label[for='external-project-id']");
            $('#ajax-loader').hide();
            break;

            case '5': //PTS
            $('#ajax-loader').show();
            $.get( url + 'get-pts-microinjection-projects-view', function( data ) {
                prepedList = prepPtsList(JSON.parse(data));
                populateProjDropdown(prepedList);
                selectizeProjects.enable();
                clearSelectize(selectizeGenes, true)
                lightUp("label[for='external-project-id']");
                $('#ajax-loader').hide();
            });
            break;

            case '6': //KOMP2
            $('#ajax-loader').show();
            selectizeProjects.disable();
            prepedList = prepGenesList(JSON.parse(projectTypesGenes), $('#project-type-id').val());
            populateGenesDropdown(prepedList);
            selectizeGenes.enable();
            clearSelectize(selectizeProjects, true);
            lightUp("label[for='mgi-accession-id']");
            $('#ajax-loader').hide();
            break;

            case '2': //MBP
            $('#ajax-loader').show();
            selectizeProjects.disable();
            prepedList = prepGenesList(JSON.parse(projectTypesGenes), $('#project-type-id').val());
            populateGenesDropdown(prepedList);
            selectizeGenes.enable();
            clearSelectize(selectizeProjects, true);;
            lightUp("label[for='mgi-accession-id']");
            $('#ajax-loader').hide();
            break;
        }

        // Custom project name input should only be active when project type != KOMP2
        if (projectTypeId != '6') {
            $('#custom-name').attr('disabled', false);
        } else {
            $('#custom-name').val('').attr('readonly', true);
        }

    });

    /**
     * EVENT: run this when "Associated External Project" dropdown changes
     */ 
    $('#external-project-id').change(function(e) {
        $('#ajax-loader').show();
        switch ($('#project-type-id').val()) {
            
            case '1': //KOMP
            kompProjId = $(this).val();
            preppedGenesList = {};
            for (var i=0; i < kompProjects.length; i++){
                if (kompProjects[i].komp_id == kompProjId) {
                    preppedGenesList[kompProjects[i].mgi_accession_id] = kompProjects[i].gene + ' ('+kompProjects[i].mgi_accession_id+')';
                    populateGenesDropdown(preppedGenesList);
                    selectizeGenes.setValue(kompProjects[i].mgi_accession_id, false);
                }
            }
            break;

            case '3': //MMRRC
            selectedMmrrcOrderId = $(this).val();
            if (!selectedMmrrcOrderId) { clearSelectize(selectizeGenes, true); break; } //user hit DEL key on a dropdown
            allMmrrcOrdersArr = JSON.parse(allMmrrcOrders);
            //Find the right order
            for (var k in allMmrrcOrdersArr){ //iterate over all mmrrc orders
                if (allMmrrcOrdersArr[k].mmrrc_order_oid == selectedMmrrcOrderId) {
                    var o = allMmrrcOrdersArr[k]; //we've found an order!
                    break;
                }
            }
            //Parse mmrrc order for mgi accession ids
            detailedOrder = JSON.parse(o.order_json);
            mgiAcessionIds = new Object; //!!!NOTE!!! This can contain dupes. Make unique on the server side...
            for (var k in detailedOrder.items ) { //iterate over items
                item  = detailedOrder.items[k];
                for (var kk in item.locus) { //iterate over locuses for each item
                    var locus = item.locus[kk];
                    if (locus.mgi_acc_id != '' && locus.segment_type == 'Gene'){ //filter out Transgenes etc.
                        var mgi_id = locus.mgi_acc_id;
                        mgiAcessionIds[mgi_id] = locus.symbol;
                    }
                }
            }
            if (!(Object.keys(mgiAcessionIds).length === 0 && mgiAcessionIds.constructor === Object)) { //check if there's an mgi in the order
                /**
                 * Prepare the string of genes to display in dropdown
                 * Note: The dropdown is for presentation purposes only,
                 * Real mgi values are passed to the server as hidden form field
                 */
                var dropdownString = '';
                for (k in mgiAcessionIds) {
                    dropdownString += mgiAcessionIds[k]+' ('+k+') ';
                }
                populateGenesDropdown({'__nogene__':dropdownString});
                selectizeGenes.setValue('__nogene__', false);
                selectizeGenes.enable();
                lightUp("label[for='mgi-accession-id']");
            }
            break;

            case '5': //PTS
                $('#singleGeneDropdown').remove();
                $('#mgi-accession-id').remove(); //we need multiple gene dropdowns, so let's remove the general one, and insert multiple numbered dropdowns
                $('#plus-link').show();
                lightUp('#plus-link');
                ptsGeneDropdownHtml = `
                    <select class="form-control" id="mgi-accession-id-`+ptsGenesDropdownInitCounter+`"></select>
                `;
                $('#dropdowns').append(ptsGeneDropdownHtml);
                var $select = $('#mgi-accession-id-'+ptsGenesDropdownInitCounter).selectize(ptsGenesDropdownInit);
                selectizeGenes = $select[0].selectize;
                selectizeGenes.enable();
                ptsGenesDropdownInitCounter++;
            break;
        }
        $('#ajax-loader').hide();
    });

    /**
     * EVENT: run this when "link more projects" is clicked
     */ 
    $('#plus-link').click(function(e){
        var newGenesDropdown = `
        <select class="form-control" id="mgi-accession-id-`+ptsGenesDropdownInitCounter+`"></select>
        `;
        $('#dropdowns').append(newGenesDropdown);
        var $select = $('#mgi-accession-id-'+ptsGenesDropdownInitCounter).selectize(ptsGenesDropdownInit);
        selectizeGenes = $select[0].selectize;
        selectizeGenes.enable();
        ptsGenesDropdownInitCounter++;
    });

    /**
     * EVENT: run this when genes dropdown changes
     */ 
    $('#mgi-accession-id').change(function(e){
        if ($(this).val() == '') {
            mgiAcessionIds = new Object; //reset mgi accession ids object when DEL key is hit
        }
    });

    /**
     * EVENT: run this on form submit to do the validation
          and prepare mgi_accession_ids values
     */ 
    $('#project-form').submit(function(e){
        var geneReq;
        var extProjReq;
        var cont = true;
        switch ($('#project-type-id').val()) {
            case '6': //KOMP2
            case '2': //MBP
            geneReq = true;
            extProjReq = false;
            break;
            case '1': //KOMP
            geneReq = true;
            extProjReq = true;
            break;
            case '5': //PTS
            case '3': //MMRRC
            geneReq = false;
            extProjReq = true;
            break;
        }
        
        /** 
         * PTS projects support multiple genes per project, so
         * we have to populate mgiAcessionIds variable now
         */
        if ($('#project-type-id').val() == '5') { //PTS
            mgiAcessionIds = [];
            $('[id^=mgi-accession-id-]').each(function(k) {
                mgiAcessionIds[$(this).val()] = $(this).text()
            })
        }
        
        if (geneReq) {
            if ($('#mgi-accession-id').val().trim() == '') {
                alert('Please select a gene from the dropdown.');
                cont = false;
            }
        }
        if (extProjReq) {
            if ($('#external-project-id').val().trim() == '') {
                alert('Please select an external project from the dropdown.');
                cont = false;
            }
        }
        //Populate mgiAcessionIds object (for non mmrrc projects)
        var geneDropdownVal = $('#mgi-accession-id').val();
        if (geneDropdownVal != '__none__' && 
            geneDropdownVal != '__nogene__' && 
            typeof geneDropdownVal != 'undefined' && 
            geneDropdownVal != '')
        {
            mgiAcessionIds = new Object;
            mgiAcessionIds[geneDropdownVal] = $('#mgi-accession-id').text();
        }
        //Populate hidden form fields with mgi accession id values
        hiddenForms = '';
        for (k in mgiAcessionIds) {
            hiddenForms += "<input type='hidden' value='"+k+"' name='mgi_accession_ids["+k+"]'>";
        }
        $("#project-form").append(hiddenForms);

        //Don't post mgi_accession_id form field
        selectizeGenes.disable()

        // cont = true if all ok, false if something's required missing.
        // acts as e.preventDefault();
        return cont;
    });

    /**
     * EVENT: run this when mutation dropdown changes
     */ 
    $('#mutation-id').change(function(e){
        var mutation = $(this).find(':selected').text()
        if (mutation == '') {
            return true;
        }
        if (mutation.includes('_LA')) {
            $('#phenotype-id').val(1); //set phenotype to k2p2la
        } else {
            $('#phenotype-id').val(2); //set phenotype to k2p2ea (early onset) by default
        }
        lightUp('#phenotype-id');
    });
}); //end document ready
</script>
