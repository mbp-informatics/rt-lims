<script>
$( document ).ready(function() {
var allDropdowns;
var nextAvailableBoxCellId = false;

$.ajaxSetup({
   async: false
});

/** EVENTS FOLLOW */

// When a conainer id is selected, grab boxes for that container and display them in a dropdown
$(document).on('change', "#inventory-container-id", function() {
    clickedDropdown = $(this);
    $("#ajax-loader").show();
    containerId = clickedDropdown[0].value; 
    if (!containerId) { //'empty' selection, skip
        return;
    }
    clickedDropdownId = clickedDropdown[0].id;
    var boxesDropdown = $("#inventory-box-id")[0].selectize;    
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
        lightUp("label[for='inventory-box-id']");
        $("#ajax-loader").hide();
    });
    var locationsDropdown = $("#inventory-location-id");
    locationsDropdown.find('option').remove();
    locationsDropdown.attr('disabled', true);
    document.getElementById("inventory-location-id").selectedIndex = -1; //reset the dropdown
});

// When a box is selected, grab its unused locations and populate Available Box Cells dropdown
$(document).on('change', "#inventory-box-id", function() {
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
        var locationsDropdown = $("#inventory-location-id");
        locationsDropdown.find('option').remove();
        if (json.inventory_locations.length >0) { //check if there are any locations present
            takenLocations = 0;
            locationsDropdown.append('<option value=""></option>');
            for ( var i=0; i<=json.inventory_locations.length; i++ ) {
                if (json.inventory_locations[i] && json.inventory_locations[i].inventory_vial == null) { //check if location is occupied by a vial
                    locationsDropdown.append('<option value="' + json.inventory_locations[i]['id'] + '">' + json.inventory_locations[i]['cell'] + '</option>');
                    document.getElementById('inventory-location-id').selectedIndex = -1;
                } else {
                    takenLocations++;
                }
            }
            if (json.inventory_locations.length == takenLocations) {
                locationsDropdown.attr('disabled', true);
                alert('All cells in this box are taken. Choose a different box.')
            } else {
                locationsDropdown.attr('disabled', false);
                lightUp("label[for='inventory-location-id']");
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
});
</script>

<div class="inventoryVials form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryVial) ?>

    <?php
        /* Prepare list of containers and their hierarchy for the dropdown */
        $containerOptions = [];
        foreach ($inventoryContainers as $containerId => $containerParents) {
                $containerOptions[$containerId] = $this->customForm->getContainerHierarchy($containerParents);
        }
        natsort($containerOptions);
    ?>
    <fieldset>
        <div class="row" >
            <div class="col-sm-3"><?php echo $this->Form->input('label'); ?></div>
            <div class="col-sm-3"><?php echo $this->Form->input('volume', ['label'=>"Volume/# of Embryos"]); ?></div>
            <div class="col-sm-2"><?php echo $this->Form->input('inventory_vial_type_id', ['options' => $inventoryVialTypes, 'empty'=>true]); ?></div>
                <?php 
                if ($inventoryVial->tissue) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>
            <div class="col-sm-2">
             <label class="control-label" for="tissue">Tissue </label>
                    <div class="switch-toggle well">
                        <input id="open" name="tissue" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="open">Yes</label>
                        <input id="closed" name="tissue" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="closed">No</label>
                        <a class="progress-bar"></a>
                </div>
            </div>
                <?php 
                if ($inventoryVial->do_not_distribute) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>
            <div class="col-sm-2">
             <label class="control-label" for="do_not_distribute">Distribute? </label>
                    <div class="switch-toggle well">
                        <input id="do_not_distribute-closed" name="do_not_distribute" value="0" type="radio" <?= $closed ?> >
                        <label class="pointer" for="do_not_distribute-closed">Yes</label>
                        <input id="do_not_distribute-open" name="do_not_distribute" type="radio" value="1" <?= $open ?> >
                        <label class="pointer" for="do_not_distribute-open">No</label>
                        <a class="progress-bar"></a>
                </div>
            </div>
        </div>
        <div class="row" >
            <?php if (isset($inventoryVial->sperm_cryo_id)) { ?>
                <div class="col-sm-3"><?php echo $this->Form->input('sperm_cryo_id', ['type' => 'text', 'empty'=>true]); ?></div>
                <!-- <div class="col-sm-3">
                    <?php
                    echo $this->CustomForm->displayField(
                        'sperm_cryo_id',
                        $spermCryos,
                        false,
                        ['empty'=>true, 'label'=>'Sperm Cryo ID']
                    ); ?>
                </div> -->
            <?php } ?>
            <?php if (isset($inventoryVial->embryo_cryo_id)) { ?>
                <div class="col-sm-3"><?php echo $this->Form->input('embryo_cryo_id', ['type' => 'text', 'empty'=>true]); ?></div>
<!--                 <div class="col-sm-3"> 
                    <?php
                    echo $this->CustomForm->displayField(
                        'embryo_cryo_id',
                        $embryoCryos,
                        false,
                        ['empty'=>true, 'label'=>'Embryo Cryo ID']
                    ); ?>    
                </div> -->
                <?php $booleanOptions = ['Yes' => 'Yes', 'No'=>'No']; ?>
                <div class='col-sm-3'><?php echo $this->Form->input('pups', ['options' => $booleanOptions, 'label'=>'Pups?', 'empty'=>true]); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('qc_pass', ['options' => $booleanOptions, 'label'=>'QC Pass?', 'empty'=>true]); ?></div>
            <?php } ?>
            <?php if (isset($inventoryVial->es_cell_id)) { ?>
                <div class="col-sm-3"><?php echo $this->Form->input('es_cell_id', ['type' => 'text', 'empty'=>true]); ?></div>
<!--                 <div class="col-sm-3"> 
                    <?php
                    echo $this->CustomForm->displayField(
                        'es_cell_id',
                        $esCells,
                        false,
                        ['empty'=>true, 'label'=>'Es Cell ID']
                    ); ?>    
                </div> -->
                <?php $esBoolean = ['1' => 'Yes', '0'=>'No']; ?>
                <div class='col-sm-2'><?php echo $this->Form->input('es_cell.passage', ['label'=>'Passage', 'empty'=>true]); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('es_cell.parent_id', ['options' => $parentClones, 'label'=>'Parent ES', 'empty'=>true]); ?> </div>
                <div class='col-sm-2'><?php echo $this->Form->input('es_cell.mra_treated', ['options' => $esBoolean, 'label'=>'MRA Treated', 'empty'=>true]); ?> </div>   
                <div class='col-sm-2'><?php echo $this->Form->input('es_cell.myco_pos', ['options' => $esBoolean, 'label'=>'Myco Pos', 'empty'=>true]); ?> </div>   
            <?php } ?>
        </div>
        <div class="row" >
            <div class='col-sm-6'><?php echo $this->Form->input('inventory_container_id', ['options' => $containerOptions, 'required' => 'required', 'default' => $invContainerId, 'empty' => true]); ?> </div>
            <div class='col-sm-3'><?php echo $this->Form->input('inventory_box_id', ['options' => $boxesDropdown, 'required' => 'required', 'default' => $boxId, 'empty' => true]); ?>
                <script>
                    $( document ).ready(function() {
                        $('#inventory-box-id').selectize({
                            create: false
                        });
                        $('#inventory-container-id').selectize({
                            create: false
                        });
                    });
                </script>
            </div>
            <div class='col-sm-3'><?php echo $this->Form->input('inventory_location_id', ['required' => 'required', 'label' => 'Available Box Cells', 'options'=> $locationsDropdown, 'empty' => true]); ?></div>
        </div>
        <div class="row" >
            <div class="col-sm-12"><?php echo $this->Form->input('comments', ['type' => 'text']); ?></div>
        </div>
        <div class="row" >

    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'submit-button'
            )); ?>
    <?= $this->Form->end() ?>
</div>