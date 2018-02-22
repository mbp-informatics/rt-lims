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
.hidden-genotypings {
    display:none;
}

</style>
<script>
$( document ).ready(function() {
    var nextGenotypingToShowId = 0;
    var genotypingCounter = 0;
    addGenotypings('first'); //Add the first geno box on page load

    $.ajaxSetup({
       async: false
    });

    /* Moves vial fromm hidden vials into the form and increments the counter */
    function addGenotypings(first=false){
        if (first) {
            var noGenotypingsToAdd = 1;
        } else {
            var noGenotypingsToAdd = $('#addGenotypingsNo').val();
        }
        for (i=0; i<noGenotypingsToAdd; i++) {
            if ($('.visible-genotypings:last').length >0) {
                var prevGenotypingId  = $('.visible-genotypings:last').attr('id').replace('genotyping', '')
            } else {
                var prevGenotypingId = 0;
            }
            var genotyping = $('#genotyping'+nextGenotypingToShowId).addClass('visible-genotypings');
            $("#buttonsFollow").before(genotyping);
            nextGenotypingToShowId++;
            genotypingCounter++;
        }    
    }

    /* Removes a vial identified by its id from DOM */
    function removeGenotyping(genotypingId){
        $('#genotyping'+genotypingId).fadeOut(400, function(){
            $(this).remove();
            genotypingCounter--;
        });
    }

    // When a SC is selected, grab its vials and populate vial dropdown
    $(document).on('change', "[id*=-sperm-cryo-id]", function() {
        spermCryosDropdown = $(this);
        $("#ajax-loader").show();
        spermCryoId = spermCryosDropdown[0].value; 
        if (!spermCryoId) { //'empty' selection, skip
            return;
        }
        clickedDropdownId = spermCryosDropdown[0].id;
        clickedDropdownIdNo = clickedDropdownId.replace('-sperm-cryo-id', '');   
        vialsDropdown = $("#"+clickedDropdownIdNo+"-inventory-vial-id"); 
        

        /* Get list of vials for a given sc id  */
        $.get( "/inventory-vials/ajax/"+spermCryoId, function( data ) {
            $("#ajax-loader").hide();
            var json = JSON.parse(data);
            if (json.length === 0) {
                alert('No vials for this SC record');
                return;
            }

            //Populate the dropdown
            vialsDropdown.find('option').remove();
            for (var k in json) {
                $("#"+clickedDropdownIdNo+"-inventory-vial-id").append($("<option></option>").attr("value", json[k].id).text(json[k].label));
            }
            vialsDropdown.prop( "disabled", false);  
            $("#ajax-loader").hide();
        });

        document.getElementById(clickedDropdownIdNo+"-inventory-vial-id").selectedIndex = -1; //reset the dropdown
    });

    //Add new vials on button click
    $(document).on('click', "#addGenotypings", function() {
        addGenotypings();
    });

    //Remove vial when X is clicked
    $(document).on('click', ".xbuttons", function() {
        removeGenotyping($(this).attr('id'));
    });

});
</script>

<div class="genotypeRequests form large-9 medium-8 columns content">
    <div class='container-fluid' style="margin-bottom:20px;">
    <?= $this->Form->create($genotypeRequest, ['id'=>'genotype-request-form']) ?>
    <fieldset>
        <legend><?= __('Genotype Request') ?></legend>
        <div class='row'>
            <?php $sampleTypes = ['Tail Snips' => 'Tail Snips', 'Sperm Pellet' => 'Sperm Pellet', 'Tissue' => 'Tissue', 'Blastocysts' => 'Blastocysts']; ?>
            <div class='col-xs-3'><?php echo $this->Form->input('job_id',['label' => 'Job', 'type'=>'text', 'default'=>$job_id]);  ?></div>
            <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('collection_date', ['empty'=>true, 'label'=>'Collection Date (YYYY-MM-DD)']); ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('sample_type', ['options' => $sampleTypes, 'empty' => true]); ?></div>
            <div class='col-xs-3'><label class="control-label" for="epi_bool">Epi/Vas? </label>
                <div class="switch-toggle well">
                    <input id="epi_bool-yes" name="epi_bool" type="radio" value="1">
                    <label class="pointer" for="epi_bool-yes">Yes</label>
                    <input id="epi_bool-no" name="epi_bool" value="0" type="radio" checked>
                    <label class="pointer" for="epi_bool-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
        </div>
        <div class='row'>
            <?php $recharges = ['MR73 - MMRRC Receipt/Archiving' => 'MR73 - MMRRC Receipt/Archiving', 'MR83 - MMRRC Services+Re-archiving' => 'MR83 - MMRRC Services+Re-archiving', 'MM18 - Sulfur Metabolism Research' => 'MM18 - Sulfur Metabolism Research', 'MM21 - CRISPR Multi-target Research' => 'MM21 - CRISPR Multi-target Research', 'KL70 - KOMP II, Phase II' => 'KL70 - KOMP II, Phase II', 'VMB7 - MICL Services' => 'VMB7 - MICL Services', 'MR92 - MMRRC GS' => 'MR92 - MMRRC GS', 'CRYG - KOMP Repository' => 'CRYG - KOMP Repository', 'KL60 - Sperm ED' => 'KL60 - Sperm ED', 'MM18 - MMRRC Research' => 'MM18 - MMRRC Research', 'MMR71' => 'MMR71', 'MR71' => 'MR71']; ?>
            <div class='col-xs-3'><?php echo $this->Form->input('notes');  ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('recharge', ['empty'=> true, 'label'=>"Recharge", 'options' => $recharges]);  ?></div>
            <div class='col-xs-3'><?php echo $this->Form->input('mosaic_name', ['label' => 'Mosaic Colony Name']);  ?></div>
        </div>
        <div class='row'>
            <div class='col-xs-12'><?php echo $this->Form->input('comments');  ?></div>            
        </div>
    </fieldset>
    <div id="genotypings">
        <?= $this->Form->create($genotypeRequest, ['id' => 'genotypeRequestsForm', 'onsubmit' => "return confirm('Are you sure you want to submit request?');"]) ?>
        <hr id ="buttonsFollow">
        Add <input id="addGenotypingsNo" type="text" value="5" style="width:30px;"> more requests <button id="addGenotypings" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button>
        <?= $this->Form->button(__('Submit'),
            array(
                'class' => 'btn btn-success',
                'div' => false,
                'confirm' => 'Are you sure you want to submit request?'
                )); ?>
        <?= $this->Form->end() ?>
    </div>

<div class="hidden-genotypings">
    <?php
    /** 
     * Inserts a preset number of genotyping modules into a hidden container
     * These are then moved into the <form> when the 'Add Button' is clicked. 
     */
    $i=0; for ($i; $i < 25; $i++)  {  ?>
        <fieldset>
        <div class="panel panel-default" id='genotyping<?= $i ?>'>
            <div class='panel-body'>
                <div class="pull-right">
                    <button id='<?= $i ?>' type="button" class="xbuttons btn btn-danger btn-sm"><span class="pad-action-glyph glyphicon glyphicon-remove"></span></button>
                </div>
                <div class='row' id="0-all-input-fields">
                </div>
                <div class='row' id="0-all-input-fields">
                    <?php $sources = ['MBP' => 'MBP', 'Import' => 'Import']; ?>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.male_id_no', ['label'=>'Male ID']); ?></div>
                    <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                            $i.'.genotype', 
                            $this->CustomForm->getGenotypeList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.source', ['options' => $sources, 'class' => 'sources']); ?></div>
                </div>
                <div class='row' id="0-all-input-fields">
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.ivf_id', ['options' => $ivfs, 'empty'=>true, 'label'=>'IVF']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.sperm_cryo_id', ['options' => $spermCryos, 'empty'=>true]); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.embryo_cryo_id', ['options' => $embryoCryos, 'empty'=>true]); ?></div>
                </div>
                <div class='row' id="0-all-input-fields">
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.embryo_count'); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.note'); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input($i.'.inventory_vial_id', ['options' => null, 'empty'=>true, 'label'=>'SC Vial', 'disabled' => true]); ?></div>
                </div>
            </div>
        </div>  
        </fieldset>
           
    <?php } ?>
</div>    