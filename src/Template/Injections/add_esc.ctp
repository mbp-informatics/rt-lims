
<script src="/webroot/js/injection-esc.js"></script>
<style>
.calc {
	font-size:14px;
	color:#ff0000;
}
</style>

<!-- Allows user to add a vial for a clone. There's >600k vials though, so it filters genes that have been ordered, then clones associated with those genes, then vials associated with those clones. Not required, MTGL users don't add this, but future users can use to track. -->
<script>
$(document).on('change', "#gene-id", function() {
    clickedDropdown = $(this);
    $("#ajax-loader").show();
    geneId = clickedDropdown[0].value;
    
    /* Get clone information  */
    $.get( "/komp-clones-dump/view/"+geneId+"/ajax", function( data ) {
        $("#ajax-loader").hide();
        var json = JSON.parse(data);
        var clonesDropdown = $("#clone-id");
        if (json.length >0) { //check if there are any clones present
            clonesDropdown.attr('disabled', false);
            for ( var i=0; i<=json.length; i++ ) {
                if (json[i]) { 
                    clonesDropdown.append('<option value="' + json[i]['0'] + '">' + json[i]['1'] + '</option>');
            	}
    		};
	    } else {
	        vialsDropdown.attr('disabled', true);
	        alert('This clone has no associated vials.')
		};
	});
});

$(document).on('change', "#clone-id", function() {
    clickedDropdown = $(this);
    $("#ajax-loader").show();
    cloneId = clickedDropdown[0].value;

    /* Get vial information  */
    $.get( "/inventory-vials/view/"+cloneId+"/ajax", function( data ) {
        $("#ajax-loader").hide();
        var json = JSON.parse(data);
        var vialsDropdown = $("#inventory-vial-id");
        if (json.length >0) { //check if there are any vials present
            vialsDropdown.attr('disabled', false);
            for ( var i=0; i<=json.length; i++ ) {
                if (json[i]) { 
                    vialsDropdown.append('<option value="' + json[i]['0'] + '">' + json[i]['1'] + '</option>');
            	}
    		};
	    } else {
	        vialsDropdown.attr('disabled', true);
	        alert('This clone has no associated vials.')
		};
	});
});
</script>

<script src="/js/cryos.js"></script>
<script>
$( document ).ready(function() {
    $( "#job-id" ).trigger( "change" );
});
</script>

<div class="injections esc form large-9 medium-8 columns content">
<?php
        echo $this->html->link('<span class="glyphicon glyphicon-trash"></span> ' . __('Reset the form'), ['controller' => 'injections', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-danger pull-right', 'confirm' => 'Are you sure you want to discard this form?'));
?>
<div class="clearfix"></div>
    <?= $this->Form->create($injection) ?>
    <fieldset>
        <legend><?= __('Adding ESC Microinjection' . " ($type)") ?></legend>
        <div class="important" style="margin-bottom:25px;">
        <br/>
        <div class="row" >
            <div class="col-sm-6">
				<?php echo $this->CustomForm->displayField(
					'project_id', 
					null,
					false,
					['empty'=>true, 'label' => 'Project Name']
				) ?>
            </div>
            <div class='col-xs-6'>
            	<?php echo $this->CustomForm->displayDatepickerField('injection_date', ['empty'=>true, 'label'=>'Injection date']); ?>
           	</div>
        </div>
        <div class="row">
	           	<div class="col-sm-12">
					<label class="control-label" for="qc_state">QC State <sup><span class="badge" data-toggle="tooltip" title="Choose one of the three states.">?</span></label></sup></label>
		            <div class="switch-toggle well">
		                <input id="in-progress" name="qc_state" type="radio" value="in progress" checked>
		                <label class="pointer" for="in-progress">In progress</label>
		                <input id="passed" name="qc_state" value="passed" type="radio">
		                <label class="pointer" for="passed">Passed</label>
		                <input id="failed" name="qc_state" value="failed" type="radio">
		                <label class="pointer" for="failed">Failed</label>
		                <a class="progress-bar"></a>
		            </div>
	           	</div>
        </div>
           	</div>
           	<div class="row">
	            <div class="col-sm-4">
					<?php echo $this->CustomForm->displayField(
						'recharge',
						$this->CustomForm->getPrevValuesList('recharge'),
						true,
						['empty'=>true, 'label' => 'Recharge']
					) ?>
	            </div>
	            <div class="col-sm-4">
	             	<?= $this->Form->input('investigator', ['label'=>'Investigator', 'default'=>'Lloyd']); ?>
	            </div>
	            <div class='col-xs-4'>
	             	<?= $this->Form->input('pts_ko_mo', ['label'=>'Order #']); ?>
	        	</div>
        	</div>
           	<div class="row">
	            <div class="col-xs-4">
					<?php echo $this->CustomForm->displayField(
						'injected_by', 
						$this->CustomForm->getPrevValuesList('injected_by'),
						true,
						['empty'=>true, 'label' => 'Injected by']
					) ?>
	            </div>
            <div class="col-sm-4">	
				<?php echo $this->CustomForm->displayField(
					'membership', 
					$this->CustomForm->getPrevValuesList('membership'),
					true,
					['empty'=>true, 'label' => 'Membership']
				) ?>
			 </div>
            <div class='col-xs-4'>
                <label class="control-label" for="bl_eight_cell">8-cell?</label>
                <div class="switch-toggle well">
                    <input id="bl_eight_cell-yes" name="bl_eight_cell" type="radio" value="1">
                    <label class="pointer" for="bl_eight_cell-yes">Yes</label>
                    <input id="bl_eight_cell-no" name="bl_eight_cell" value="0" type="radio" checked>
                    <label class="pointer" for="bl_eight_cell-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            </div>
		<?php
			echo $this->Form->hidden('user_id', [
				'options' => $users,
				'default' => $this->request->session()->read('Auth.User.id')
			]);
			echo $this->Form->hidden('injection_type', ['value' => $type]);
		?>
        <div class='alert alert-info' role='alert'>ES Cells</div>
        <div class="row" >
            <div class="col-sm-4">
				<?php echo $this->CustomForm->displayField(
					'es_cell_source', 
					$this->CustomForm->getPrevValuesList('es_cell_source'),
					true,
					['empty'=>true, 'label' => 'ES Cell Source']
				) ?>
            </div>
            <div class='col-xs-4'>
				<?php echo $this->CustomForm->displayField(
					'parental_esc_line', 
					$this->CustomForm->getPrevValuesList('parental_esc_line'),
					true,
					['empty'=>true, 'label' => 'Parental ESC Line']
				) ?>
            </div>
            <div class="col-sm-4">
				<?php echo $this->CustomForm->displayField(
					'coat_color', 
					$this->CustomForm->getPrevValuesList('coat_color'),
					true,
					['empty'=>true, 'label' => 'Coat Color']
				) ?>
            </div>
        </div>
        <div class="row" >
            <div class='col-xs-4'>
				<?php echo $this->CustomForm->displayField(
					'esc_morphology', 
					$this->CustomForm->getPrevValuesList('esc_morphology'),
					true,
					['empty'=>true, 'label' => 'ESC Morphology']
				) ?>
            </div>
        </div>

        <div class='alert alert-info' role='alert'>Nucleases</div>
        <div class="row" >
            <div class="col-xs-4">
                <?= $this->Form->input('mrna_nuclease', ['label'=>'mRNA Nuclease', 'empty' => true, 'options' => ['CAS9' => 'CAS9', 'D10A' => 'D10A']]) ?>
            </div>
            <div class='col-xs-4'>
                <?= $this->Form->input('mrna_nuclease_concentration', ['label'=>'mRNA Nuclease Concentration', 'type' => 'number']) ?>
            </div>
            <div class='col-xs-4'>
                <?= $this->Form->input('grna_concentration', ['label'=>'gRNA Concentration', 'type' => 'number']) ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-xs-4">
                <?= $this->Form->input('protein_nuclease', ['empty' => true, 'options' => ['CAS9' => 'CAS9', 'D10A' => 'D10A']]) ?>
            </div>
            <div class="col-xs-4">
                <?= $this->Form->input('protein_nuclease_concentration', ['type' => 'number']) ?>
            </div>
            <div class="col-xs-4">
            </div>
        </div>

        <div class='alert alert-info' role='alert'>
        <?php if (isset($injectionToPullFrom)) { ?> <span class="glyphicon glyphicon-save"></span> <?php } ?>
        Embryo Collection</div>
        <div class="row" >
            <div class="col-sm-4">
				<?php echo $this->CustomForm->displayField(
					'donor_strain', 
					$this->CustomForm->getMicroinjectionDonorList(),
					false,
					['empty'=>true, 'label' => 'Donor Strain', 'value' => isset($injectionToPullFrom) ? $injectionToPullFrom->donor_strain : null]
				) ?>
            </div>
            <div class='col-xs-4'>
            	<?php echo $this->CustomForm->displayDatepickerField('donor_date_of_birth', ['empty'=>true, 'label'=>'Donor DOB', 'value' => isset($injectionToPullFrom->donor_date_of_birth) ? $injectionToPullFrom->donor_date_of_birth->format('Y-m-d') : null]); ?>
            </div>
            <div class="col-sm-4">
            	<div class="form-group text"><label class="control-label" for="stud-ids">Stud Ids</label><input value="<?= isset($injectionToPullFrom->stud_ids) ? $injectionToPullFrom->stud_ids : null ?>" type="text" name="stud_ids" maxlength="45" id="stud-ids" class="form-control" onkeypress="return restrictCharacters(this, event);"/></div>
            </div>
        </div>  
        <div class="row" >
            <div class="col-sm-4">
             	<?= $this->Form->input('pmsg_time', ['empty'=>true, 'label' => 'PMSG Time', 'value' => isset($injectionToPullFrom->pmsg_time) ? $injectionToPullFrom->pmsg_time->i18nFormat('HH:mm') : null]); ?>
            </div>
            <div class='col-xs-4'>
            	<?= $this->Form->input('hcg_time', ['empty'=>true, 'label' => 'HCG Time', 'value' => isset($injectionToPullFrom->hcg_time) ? $injectionToPullFrom->hcg_time->i18nFormat('HH:mm') : null]); ?>
            </div>
        </div>  
        <div class="row" >
            <div class="col-sm-4">
             	<?= $this->Form->input('number_mated', ['value' => isset($injectionToPullFrom->number_mated) ? $injectionToPullFrom->number_mated : null ]); ?>
            </div>
            <div class='col-xs-4'>
            	<?= $this->Form->input('number_plugged', ['value' => isset($injectionToPullFrom->number_plugged) ? $injectionToPullFrom->number_plugged : null ]); ?>
            </div>
            <div class="col-sm-4">
				<?= $this->Form->input('embryos_plug', ['label'=>'Embryos/Plug', 'readonly'=>true]); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
             	<?= $this->Form->input('total_embryos', ['label'=>'Total Injectable Embryos', 'value' => isset($injectionToPullFrom->total_embryos) ? $injectionToPullFrom->total_embryos : null]); ?>
            </div>
            <div class='col-xs-4'>
				<?php echo $this->CustomForm->displayField(
					'embryos_collected_by', 
					$this->CustomForm->getPrevValuesList('embryos_collected_by'),
					true,
					['empty'=>true, 'label' => 'Embryos collected by', 'value' => isset($injectionToPullFrom->embryos_collected_by) ? $injectionToPullFrom->embryos_collected_by : null]
				) ?>
            </div>
            <div class="col-sm-4">
            </div>
        </div>

        <div class='alert alert-info' role='alert'>Microinjection Info</div>
        <div class="row" >
			<div class='col-xs-3'>	<?php echo $this->CustomForm->displayField(
					'microinjection_injection_type', 
					$this->CustomForm->getPrevValuesList('microinjection_injection_type'),
					true,
					['empty'=>false, 'label' => 'Injection type']
				) ?>
			</div>
			<div class='col-xs-3'><?= $this->Form->input('number_injected', ['label'=>'Embryos Injected']); ?></div>
			<div class='col-xs-3'><?= $this->Form->input('number_survived', ['label'=>'Embryos Survived']); ?></div>
<!-- 			<div class='col-xs-3'>	<?php echo $this->CustomForm->displayField(
					'et_by', 
					$this->CustomForm->getPrevValuesList('et_by'),
					true,
					['empty'=>true, 'label' => 'ET By']
				) ?>
			</div> -->
        </div>
        <div class="row" >
            <div class='col-xs-12'>
                <?= $this->Form->input('comments'); ?>
            </div>
        </div>
        <div class='alert alert-danger' role='alert'>Data Integrity/Double Entry</div>
        <div class="row">
            <div class='col-xs-3'><?php echo $this->Form->input('fmp_id_no', ['label' => 'ID in Filemaker']); ?></div>
        </div>
    </fieldset>
    <hr />
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
 <hr/>
</div>