<div class="inventoryVials form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryVial) ?>
    <fieldset>
        <div class="row" >
            <div class="col-sm-6">
                <?php echo $this->Form->input('label'); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $this->Form->input('volume'); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-3">
                <?php
                echo $this->CustomForm->displayField(
                    'sperm_cryo_id',
                    $spermCryos,
                    false,
                    ['empty'=>true, 'label'=>'Sperm Cryo Id']
                ); ?>
            </div>
            <div class="col-sm-1" style="text-align:center">
            <span class="badge">-- OR --</span>
            </div>
            <div class="col-sm-4"> 
                <?php
                echo $this->CustomForm->displayField(
                    'embryo_cryo_id',
                    $embryoCryos,
                    false,
                    ['empty'=>true, 'label'=>'Embryo Cryo Id']
                ); ?>    
            </div>
            <div class="col-sm-1" style="text-align:center">
            <span class="badge">-- OR --</span>
            </div>
            <div class="col-sm-3"> 
                <?php
                echo $this->CustomForm->displayField(
                    'es_cell_id',
                    $esCells,
                    false,
                    ['empty'=>true, 'label'=>'Es Cell Id']
                ); ?>    
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-6">
                <?php echo $this->Form->input('inventory_vial_type_id', ['options' => $inventoryVialTypes, 'empty'=>true]); ?>

                <?php echo $this->Form->hidden('inventory_location_id', ['default' => $locationId, 'type' => 'text']); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $this->Form->input('comments', ['type' => 'text']); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-6">
         <label class="control-label" for="tissue">Tissue </label>
                <div class="switch-toggle well">
                    <input id="open" name="tissue" type="radio" value="1" checked>
                    <label class="pointer" for="open">Yes</label>
                    <input id="closed" name="tissue" value="0" type="radio">
                    <label class="pointer" for="closed">No</label>
                    <a class="progress-bar"></a>
            </div>
        </div>
    </fieldset>
    <script>
    $( function() {
        $('#submit-button').click(function(e) {
            var text = 'Please select value from one dropdown: EITHER Sperm Cryo Id OR Embryo Cryo Id OR Es Cell Id.';
            
            // More than one dropdown is selected
            var i = 0;
            if ( $('#sperm-cryo-id').val() ) { i++; }
            if ( $('#embryo-cryo-id').val() ) { i++; }
            if ( $('#es-cell-id').val() ) { i++; }
            if ( i > 1 ) {
                e.preventDefault();
                alert (text);
            }

            // All dropdowns empty
            if ( !$('#sperm-cryo-id').val() && !$('#embryo-cryo-id').val() && !$('#es-cell-id').val()) {
                e.preventDefault();
                alert (text);
            }
        });
    });
    </script>
    <?= $this->Form->button(__('Add'),
        array(
            'class' => 'btn btn-success',
            'div' => false,
            'id' => 'submit-button'
            )); ?>
    <?= $this->Form->end() ?>
</div>