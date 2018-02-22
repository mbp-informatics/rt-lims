<style>
.xbuttons { 
    padding:0px;
    margin-top:-45px;
    margin-right:-25px;
}
.panel-default {
    background-color:#f5f5f5;
    box-shadow: 0px 10px 10px #cbbb;
    margin-top:35px;
}
.hidden-vials {
    display:none;
}

</style>
<script>
$( document ).ready(function() {
var cryoType = '<?= $cryoType ?>';
var nextVialToShowId = 0;
var vialCounter = 0;
var allDropdowns;
var nextAvailableBoxCellId = false;
addVials('first'); //Add the first vial box on page load

$.ajaxSetup({
   async: false
});

/** FUNCTIONS FOLLOW */

/**
 * Grabs the value from one selectize JS dropdown and populates another
 * selectize JS dropdown uwith these values  
 */
function cloneSelectizeJsDropdown(sourceDrodpownObj, targetDrodpownObj) {
    var prevDropdownVal = sourceDrodpownObj.val()
    var $select = targetDrodpownObj.selectize();
    var dropdownToPopulate = $select[0].selectize;
    dropdownToPopulate.clear();
    dropdownToPopulate.clearOptions();
    var opts = sourceDrodpownObj[0].selectize.options; //extract options, we will get a regular js object in return
    for (k in opts) { //since opts is a regular js object (not a jquery object) we cannot iterate over it using .each() method, we need to use vanilla js iterator
        dropdownToPopulate.addOption({value: k, text: opts[k].text});
    }
    dropdownToPopulate.setValue(prevDropdownVal, false);
    dropdownToPopulate.enable();
}

/* Populates the fields with values grabbed from the previous vial (var prevVialId) */
function populateVial(vialIdToPopulate, prevVialId) {
    //Grab field values from the previous vial and populate current vial with it
    var fieldsId = ['volume', 'comments', 'inventory-vial-type-id', 'es-cell-passage', 'es-cell-parent-id', 'es-cell-mra-treated', 'es-cell-myco-pos'];
    for (i=0; i<fieldsId.length; i++) {
        $('#'+vialIdToPopulate+'-'+fieldsId[i]).val($('#'+prevVialId+'-'+fieldsId[i]).val());
    }

    /* SELECTIZE JS DROPDOWNS */
    //Inventory container
    var sourceDrodpownObj = $('#'+prevVialId+'-'+'inventory-container-id');
    var targetDrodpownObj = $('#'+vialIdToPopulate+'-inventory-container-id');
    cloneSelectizeJsDropdown(sourceDrodpownObj, targetDrodpownObj);    
    //Inventory box
    var sourceDrodpownObj = $('#'+prevVialId+'-'+'inventory-box-id');
    var targetDrodpownObj = $('#'+vialIdToPopulate+'-inventory-box-id');
    cloneSelectizeJsDropdown(sourceDrodpownObj, targetDrodpownObj); 

    //LABEL: if label ends with a letter do nothing, if it ends with a number, +1 that number
    var label = $('#'+prevVialId+'-label').val();
    lastChar = label[label.length-1];
    if ($.isNumeric(lastChar)) {
        var digits = label.match(/([0-9]+)$/)[0];
        var alpha = label.replace(digits, '');
        digits++;
        label = alpha + digits.toString();
    }
    $('#'+vialIdToPopulate+'-label').val(label);

    //RADIO BUTTONS: Populate 'the switch'
    var tissue = $('#'+prevVialId+'open').is(':checked') ? 'open' : 'closed';
    if (tissue == 'closed') { $('#'+vialIdToPopulate+'closed').attr('checked', true); $('#'+vialIdToPopulate+'open').attr('checked', false); }
    if (tissue == 'open') { $('#'+vialIdToPopulate+'open').attr('checked', true); $('#'+vialIdToPopulate+'closed').attr('checked', false); }

    var distribute = $('#'+prevVialId+'open-do_not_distribute').is(':checked') ? 'open' : 'closed';
    if (distribute == 'closed') { $('#'+vialIdToPopulate+'closed-do_not_distribute').attr('checked', true); $('#'+vialIdToPopulate+'open-do_not_distribute').attr('checked', false); }
    if (distribute == 'open') { $('#'+vialIdToPopulate+'open-do_not_distribute').attr('checked', true); $('#'+vialIdToPopulate+'closed-do_not_distribute').attr('checked', false); }

    //AVAILABLE CELLS DROPDOWN: First, copy Available Box Cells dropdown options from the previous vial
    var locationsDropdown = $('#'+vialIdToPopulate+'-inventory-location-id')
    var dropdownValues = [];
    locationsDropdown.find('option').remove();
    $('#'+prevVialId+'-inventory-location-id option').each(function() {
        locationsDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
        dropdownValues.push($(this).val());
    });
    //AVAILABLE CELLS DROPDOWN: Then, calculate what's the next available cell in the dropdown and populate the new dropdown accordingly
    var prevAvailableValue = parseInt($('#'+prevVialId+'-inventory-location-id').val());
    if (!isNaN(prevAvailableValue)) {
        for (var i = 0; i<dropdownValues.length; i++) {
            if (dropdownValues[i] == prevAvailableValue) { //found previously selected dropdown
                nextAvailableBoxCellToShow =  dropdownValues[i+1] //now assign the next value from the array
            }
        }
        $('#'+vialIdToPopulate+'-inventory-location-id').val(nextAvailableBoxCellToShow).attr('disabled', false).change();
    } else {
        $('#'+vialIdToPopulate+'-inventory-location-id').attr('disabled', false);
    }
    //ES CELL PASSAGE NUMBER
    var passage = $('#'+prevVialId+'-es-cell-passage').val();
    $('#'+vialIdToPopulate+'-es-cell-passage').val(passage);
    //ES CELL PARENT ES
    var parentDropdown = $('#'+vialIdToPopulate+'-es-cell-parent-id')
    var dropdownValues = [];
    parentDropdown.find('option').remove();
    $('#'+prevVialId+'-es-cell-parent-id option').each(function() {
        parentDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
        dropdownValues.push($(this).val());
    });
    var prevValue = parseInt($('#'+prevVialId+'-es-cell-parent-id').val());
    if (!isNaN(prevValue)) {
        $('#'+vialIdToPopulate+'-es-cell-parent-id').val(prevValue).change();
    }
    //ES CELL MRA TREATED
    var parentDropdown = $('#'+vialIdToPopulate+'-es-cell-mra-treated')
    var dropdownValues = [];
    parentDropdown.find('option').remove();
    $('#'+prevVialId+'-es-cell-mra-treated option').each(function() {
        parentDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
        dropdownValues.push($(this).val());
    });
    var prevValue = parseInt($('#'+prevVialId+'-es-cell-mra-treated').val());
    if (!isNaN(prevValue)) {
        $('#'+vialIdToPopulate+'-es-cell-mra-treated').val(prevValue).change();
    }
    //ES CELL MYCO POS
    var parentDropdown = $('#'+vialIdToPopulate+'-es-cell-myco-pos')
    var dropdownValues = [];
    parentDropdown.find('option').remove();
    $('#'+prevVialId+'-es-cell-myco-pos option').each(function() {
        parentDropdown.append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
        dropdownValues.push($(this).val());
    });
    var prevValue = parseInt($('#'+prevVialId+'-es-cell-myco-pos').val());
    if (!isNaN(prevValue)) {
        $('#'+vialIdToPopulate+'-es-cell-myco-pos').val(prevValue).change();
    }
}

/* Moves vial fromm hidden vials into the form and increments the counter */
function addVials(first=false){
    if (first) {
        var noVialsToAdd = 1;
    } else {
        var noVialsToAdd = $('#addVialsNo').val();
    }
    for (i=0; i<noVialsToAdd; i++) {
        if ($('.visible-vials:last').length >0) {
            var prevVialId  = $('.visible-vials:last').attr('id').replace('vial', '')
        } else {
            var prevVialId = 0;
        }
        var vial = $('#vial'+nextVialToShowId).addClass('visible-vials');
        $("#buttonsFollow").before(vial);
        if (nextVialToShowId != 0) { //don't call the function when adding the first vial to the view
            populateVial(nextVialToShowId, prevVialId); 
        }
        nextVialToShowId++;
        vialCounter++;
    }    
}

/* Removes a vial identified by its id from DOM */
function removeVial(vialId){
    $('#vial'+vialId).fadeOut(400, function(){
        $(this).remove();
        vialCounter--;
    });
}

/** EVENTS FOLLOW */

// When a conainer id is selected, grab boxes for that container and display them in a dropdown
$(document).on('change', "#inventoryVialsForm [id*=-inventory-container-id]", function() {
    clickedDropdown = $(this);
    $("#ajax-loader").show();
    containerId = clickedDropdown[0].value; 
    if (!containerId) { //'empty' selection, skip
        return;
    }
    clickedDropdownId = clickedDropdown[0].id;
    clickedDropdownIdNo = clickedDropdownId.replace('-inventory-container-id', '');
    var $select = $("#"+clickedDropdownIdNo+"-inventory-box-id");
    var boxesDropdown = $select[0].selectize;    
    var containersDropdown = clickedDropdown[0].selectize;  

    /* Get list of boxes for a given container id  */
    $.get( "/inventory-boxes/index/"+containerId+"/ajax", function( data ) {
        $("#ajax-loader").hide();
        var json = JSON.parse(data);
        if (json.length === 0) {
            alert('No boxes in selected container. Choose a different contaier.');
            containersDropdown.clear();
            return;
        }
        //Populate the dropdown
        boxesDropdown.clear();
        boxesDropdown.clearOptions();
        for (var k in json) {
            boxesDropdown.addOption({value: json[k].id, text: json[k].name});
        }
        boxesDropdown.enable();
        lightUp("label[for='" + clickedDropdownIdNo+"-inventory-box-id" + "']");
        $("#ajax-loader").hide();
    });
    var locationsDropdown = $("#"+clickedDropdownIdNo+"-inventory-location-id");
    locationsDropdown.find('option').remove();
    locationsDropdown.attr('disabled', true);
    document.getElementById(clickedDropdownIdNo+"-inventory-location-id").selectedIndex = -1; //reset the dropdown
});

// When a box is selected, grab its unused locations and populate Available Box Cells dropdown
$(document).on('change', "#inventoryVialsForm [id*=-inventory-box-id]", function() {
    clickedDropdown = $(this);
    $("#ajax-loader").show();
    boxId = clickedDropdown[0].value;
    if (!boxId) { //'empty' selection, skip
        return;
    }
    /* Get box information  */
    $.get( "/inventory-boxes/view/"+boxId+"/ajax", function( data ) {
        $("#ajax-loader").hide();
        var json = JSON.parse(data);
        clickedDropdownId = clickedDropdown[0].id;
        clickedDropdownIdNo = clickedDropdownId.replace('-inventory-box-id', '');
        var locationsDropdown = $("#"+clickedDropdownIdNo+"-inventory-location-id");
        locationsDropdown.find('option').remove();
        if (json.inventory_locations.length >0) { //check if there are any locations present
            takenLocations = 0;
            locationsDropdown.append('<option value=""></option>');
            for ( var i=0; i<json.inventory_locations.length; i++ ) {

                if (json.inventory_locations[i] && json.inventory_locations[i].inventory_vial == null) { //check if location is occupied by a vial
                    locationsDropdown.append('<option value="' + json.inventory_locations[i]['id'] + '">' + json.inventory_locations[i]['cell'] + '</option>');
                    document.getElementById(clickedDropdownIdNo + '-inventory-location-id').selectedIndex = -1; //reset the dropdown
                } else {
                    takenLocations++;
                }
            }
            if (json.inventory_locations.length == takenLocations) {
                locationsDropdown.attr('disabled', true);
                alert('All cells in this box are taken. Choose a different box.')
            } else {
                locationsDropdown.attr('disabled', false);
                lightUp("label[for='" + clickedDropdownIdNo+"-inventory-location-id" + "']");
            }
            //Preselect the first cell in the dropdown if Embryo Cryo
            if (cryoType == 'embryo') {
                document.getElementById(clickedDropdownIdNo + '-inventory-location-id').selectedIndex = 1;
            }
        } else {
            locationsDropdown.attr('disabled', true);
            alert('This box has no cells defined. Choose a different box.')
        }
    });
});

/** 
 * Select all inventory_location_id dropdowns within <form> when dropdown is selected
 * and see if the same location has not already been selected.
 */
$(document).on('change', "#inventoryVialsForm [id*=-inventory-location-id]", function() {
    clickedLocation = $(this);
    clickedLocationValue = clickedLocation[0].value;
    cellNo = clickedLocation.find(":selected").text();
    clickedLocationId = clickedLocation[0].id;
    var allLocations = $("#inventoryVialsForm [id*=-inventory-location-id]");
    allLocations.each(function() {
        var selected = $(this)[0].value;
        var id = $(this)[0].id;
        if (selected == clickedLocationValue && clickedLocationId != id ) {
            alert('The cell id '+ cellNo +' has already been used. Please choose a different one.')
            document.getElementById(clickedLocationId).selectedIndex = -1; //reset the dropdown
        }
    });
});

//Add new vials on button click
$(document).on('click', "#addVials", function() {
    addVials();
});

//Remove vial when X is clicked
$(document).on('click', ".xbuttons", function() {
    removeVial($(this).attr('id'));
});

});
</script>

<div class="inventoryVials form large-9 medium-8 columns content" style="margin-top:30px;">
    <legend><?= __('Add Vials') ?></legend>
    <p><span class="important"><span class="glyphicon glyphicon-warning-sign"></span> You are adding vials to <?= $cryoType ?> cryo # <?= $cryoId ?>.</span></p>
    <div id="vials">
    <?= $this->Form->create($inventoryVial, ['id' => 'inventoryVialsForm', 'onsubmit' => "return confirm('Are you sure you want to submit ' + vialCounter + ' vial(s)?');"]) ?>
    <hr id ="buttonsFollow">
    Add <input id="addVialsNo" type="text" value="5" style="width:30px;"> more vials <button id="addVials" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button>
    <?= $this->Form->button(__('Submit All Vials'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'confirm' => 'Are you sure you want to submit vials?'
            )); ?>
    <?= $this->Form->end() ?>
</div>
<div class="hidden-vials">
    <?php
    /* Prepare list of containers and their hierarchy for the dropdown */
    $containerOptions = [];
    foreach ($inventoryContainers as $containerId => $containerParents) {
            $containerOptions[$containerId] = $this->customForm->getContainerHierarchy($containerParents);
    }
    natsort($containerOptions);

    /** 
     * Inserts a preset number of vial modules into a hidden container
     * These vials are then moved into the <form> when the 'Add Vial Button'
     * is clicked. Tomek, 10/6/2016
     */
    $i=0; for ($i; $i < 25; $i++)  { 
    if ($cryoType == 'embryo') { $label = "No. Embryos";} else { $label = "Volume";} ?>

    <div class="panel panel-default" id='vial<?= $i ?>'>
        <div class='panel-body'>
            <div class="pull-right">
                <button id='<?= $i ?>' type="button" class="xbuttons btn btn-danger btn-sm"><span class="pad-action-glyph glyphicon glyphicon-remove"></span></button>
            </div>
            <fieldset><span id="ajax-loader"><img src="/img/ajax-loader.gif" style="display:show;"><small>Contacting server. Please wait...</small></span>
                <div class='row'>
                    <div class='col-sm-2'><?php echo $this->Form->input($i.'.label', ['required' => 'required']); ?></div>
                    <div class='col-sm-2'><?php echo $this->Form->input($i.'.volume', ['required' => 'required', 'label' => $label, 'type'=> 'number']); ?></div>
                    <div class='col-sm-5'><?php echo $this->Form->input($i.'.inventory_container_id', ['options' => $containerOptions, 'empty'=>true, 'required' => 'required']); ?> </div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.inventory_box_id', ['options' => null, 'empty'=>true, 'required' => 'required', 'disabled'=>true]); ?>
                        <script>
                        $( document ).ready(function() {
                            $('#<?= $i.'-inventory-box-id'?>').selectize({
                                create: false
                            });
                            $('#<?= $i.'-inventory-container-id'?>').selectize({
                                create: false
                            });
                        });
                        </script>
                    </div>
                    </div>
                    <div class='row'>
                    <div class='col-sm-2'><?php echo $this->Form->input($i.'.inventory_location_id', ['empty'=>true, 'required' => 'required', 'label' => 'Available Box Cells', 'disabled' => true]); ?>
                    </div>

                    <div class='col-sm-2'><?php echo $this->Form->input($i.'.inventory_vial_type_id', ['options' => $inventoryVialTypes, 'empty'=>true, 'required' => 'required']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input($i.'.comments', [ 'type' => 'text']); ?></div>
                    <div class='col-sm-2'>
                        <label class='control-label' for='<?= $i ?>-tissue'>Tissue </label>
                        <div class='switch-toggle well'>
                            <input id='<?= $i ?>open' name='<?= $i ?>[tissue]' type='radio' value='1'><label class='pointer' for='<?= $i ?>open'>Yes</label>
                            <input id='<?= $i ?>closed' name='<?= $i ?>[tissue]' value='0' type='radio' checked><label class='pointer' for='<?= $i ?>closed'>No</label>
                            <a class='progress-bar'></a>
                        </div>
                    </div>
                    <!-- I just want this to be available to the student while she is correcting records.  -->
                    <?php if ($this->request->session()->read('Auth.User.role_id') == '1') { ?>
                        <div class='col-sm-2'>
                            <label class='control-label' for='<?= $i ?>-do_not_distribute'>Distribute? </label>
                            <div class='switch-toggle well'>
                                <input id='<?= $i ?>closed-do_not_distribute' name='<?= $i ?>[do_not_distribute]' value='0' type='radio' checked><label class='pointer' for='<?= $i ?>closed-do_not_distribute'>Yes</label>
                                <input id='<?= $i ?>open-do_not_distribute' name='<?= $i ?>[do_not_distribute]' type='radio' value='1'><label class='pointer' for='<?= $i ?>open-do_not_distribute'>No</label>
                                <a class='progress-bar'></a>
                            </div>
                        </div>
                    <?php }; ?>
                    <?php $booleanOptions = ['Yes' => 'Yes', 'No'=>'No']; ?>
                    <?php if ($cryoType == 'embryo') { ?>
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.pups', ['options' => $booleanOptions, 'label'=>'Pups?', 'empty'=>true]); ?></div>
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.qc_pass', ['options' => $booleanOptions, 'label'=>'QC Pass?', 'empty'=>true]); ?></div>
                    <?php }; ?>
                    <?php $esBoolean = ['1' => 'Yes', '0'=>'No']; ?>
                    <?php if ($cryoType == 'escell') { ?>
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.es_cell.passage', ['label'=>'Passage', 'empty'=>true]); ?></div>
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.es_cell.parent_id', ['options' => $parentClones, 'label'=>'Parent ES', 'empty'=>true]); ?> </div>
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.es_cell.mra_treated', ['options' => $esBoolean, 'label'=>'MRA Treated', 'empty'=>true]); ?> </div>   
                        <div class='col-sm-2'><?php echo $this->Form->input($i.'.es_cell.myco_pos', ['options' => $esBoolean, 'label'=>'Myco Pos', 'empty'=>true]); ?> </div>   
                    <?php }; ?>
                </div>  
            </fieldset>
        </div>
    </div>
    <?php } ?>
</div>

