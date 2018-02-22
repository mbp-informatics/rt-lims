<?= $this->CustomForm->iniConfirmExit('#ivf-form', ['job_id']) ?>
<script src="/js/cryos.js"></script>
<?php
    /** Trigger JS event if $job_id is present
     *  This will prepopulate job fields on page load
     */
    if (isset($job_id)) { ?>
    <script>
    $( document ).ready(function() {
        $( "#job-id" ).trigger( "change" );
    });
    </script>
<?php } ?>
<script>
    /** Calculates the percentage of birth rate and Litter Rate and
     *  populates the field with calculated value
     */
    $( document ).ready(function() {
        $('#total-pups-born, #total-embryos-tx').change(function(){
            var cells =  $('#total-pups-born').val() ;
            var embryos = parseFloat( $('#total-embryos-tx').val() );
            if (pups =='') {
                pups = 0;
            } else {
                pups = parseFloat(pups)
            }
            if (embryos > 0 ) {
                var perc = parseFloat( (pups/embryos)*100 );
                $('#et-birth-rate').val(perc.toFixed(2));
                if (perc > 50) {
                    document.getElementById("et-birth-rate").style.color = 'white'
                    document.getElementById("et-birth-rate").style.backgroundColor = 'green'
                    // lightUp('#blastocyst-rate', 'green');
                } else {
                    document.getElementById("et-birth-rate").style.color = 'white'
                    document.getElementById("et-birth-rate").style.backgroundColor = 'red'
                }
            }
        });
    });
</script>
</br>
<div class="ivfs form large-9 medium-8 columns content">
    <div class='container-fluid'>
        <?= $this->Form->create($ivf, ['id'=>'ivf-form']) ?>
        <fieldset>
            <legend><?= __('Add IVF') ?></legend>
            <div class="important" style="margin-bottom:25px;">
                <?php
                $options = [
                    'label'=> 'Job ID',
                    'empty' => 'Click to select Job ID from dropdown...'
                ];
                if (isset($job_id)) {
                    $options['default'] = $job_id;
                    $options['readonly'] = 'readonly';
                    $options['required'] = 'required';
                }
                echo $this->Form->input('job_id', $options);
                ?>
                <?php
                if (!isset($job_id))  { ?>
                    <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled fields in this form will be automatically populated with data when you select <em>Job ID</em> from the dropdown above.
                    </p>
                <?php } else { ?>
                    <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled form fields below have been prepopulated with data from Job ID <?= $job_id ?>.
                    </p>
                    <?php } ?>
            </div>
            <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Populating fields with job info...</small></p>
            <div class='alert alert-info' role='alert'>Strain Summary</div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('ivf_date', ['empty'=>true, 'label'=>'IVF Date (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'purpose', 
                    ['Embryo Cryo' => 'Embryo Cryo', 'Sperm Resuscitation' => 'Sperm Resuscitation', 'Strain Rederivation' => 'Sperm Rederviation', 'Sperm Test Thaw to Culture' => 'Sperm Test Thaw to Culture', 'Sperm Test Thaw to Pups' => 'Sperm Test Thaw to Pups', 'ICSI RS' => 'ICSI RS', 'ICSI RD' => 'ICSI RD', 'ICSI Rescue'=> 'ICSI Rescue'],
                    true,
                    ['empty'=>true, 'label' => 'Purpose']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('strain_name', ['readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'background', 
                    $this->CustomForm->getBackgroundList(),
                    true,
                    ['empty'=>true, 'label' => 'Male Genetic Background']
                ); ?></div>
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'membership', 
                        $this->CustomForm->getMembershipList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
    			<div class='col-xs-3'><?php echo $this->Form->input('mmrrc_no', ['label' => 'MMRRC ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('esc_clone_id_no', ['label' => 'KOMP Clone ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('bl-no', ['label' => 'BL#', 'readonly' => 'readonly']); ?></div>
    		</div>

            <div class="row">
                <div class='col-xs-3'><?php echo $this->Form->input('pi', array('label' => 'PI' ,'readonly' => 'readonly')); ?></div>
            </div>

            <div class='alert alert-info' role='alert'>Sperm Info</div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'genotype', 
                        $this->CustomForm->getGenotypeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('sperm_info_donor_strain', ['label' => 'Donor Strain (if wildtype)']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                	'fresh_frozen', 
                	['fresh' => 'fresh', 'frozen' => 'frozen'],
                	true,
                	['empty'=>true, 'label' => 'Fresh/Frozen']
                	); ?></div>
            </div>
            <div class="row">
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->timeInput('collect_thaw_time', 'Collect/Thaw time'); ?>
                </div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->timeInput('time_in_mbcd', 'Time in MBCD'); ?>
                </div>
                <div class='col-xs-3'><?php echo $this->Form->input('stud_id_no', ['label' => 'Stud ID']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('stud_dob', ['label' => 'Stud DOB (YYYY-MM-DD)', 'empty'=>true]); ?></div>
            </div>

            <div class="important" style="margin-bottom:30px;">
                <p><span class="important">If frozen:</span></p>
	            <div style="margin-left:65px">
    				<div class="row">
                        <!-- <div class='col-xs-3'><?php echo $this->Form->input('sample_type'); ?></div> -->
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'sample_type', 
                        ['Cryostraw' => 'Cryostraw', 'Cryovial' => 'Cryovial', 'Other' => 'Other'],
                        true,
                        ['empty'=>true, 'label' => 'Sample Type']
                        ); ?></div>
        	            <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
        	            	'sperm_cryo_id', 
        	            	$spermCryos,
        	            	true,
        	            	['empty'=>true, '', 'label'=>'SC #']
        	            	); ?></div>
        	            <div class='col-xs-3'><?php echo $this->Form->input('straw_vial_no', ['label' => 'Straw/Vial ID']); ?></div>
        	            <div class='col-xs-3'><?php echo $this->Form->input('cpa_lot_no', ['label' => 'CPA Lot No']); ?></div>
    	            </div>	
                </div>
                <p><span class="important">If centrifugation:</span></p>
	            <div style="margin-left:65px">
    	            <div class="row">
    	               <div class='col-xs-3'><?php echo $this->Form->input('centrifuge_force', ['label' => 'Force (g)']); ?></div>
    	               <div class='col-xs-3'><?php echo $this->Form->input('centrifuge_time', ['label' => 'Time (min)', 'empty' => true]); ?></div>
    	            </div>
	            </div>
            </div>
            <div class='alert alert-info' role='alert'>Sperm Parameters</div>            
            <div class="row">
                <div class='col-xs-3'><p><span class="important">CPA/Fresh:</span></p></div>
                <div class='col-xs-3'><p><span class="important">MBCD:</span></p></div>
                <div class='col-xs-1'></div>
                <div class='col-xs-3'><p><span class="important">Morphology:</span></p></div>
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->Form->input('cpa_fresh_sperm_conc', ['label' => 'Sperm Conc (M/ml)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mbcd_sperm_conc', ['label' => 'Sperm Conc (M/ml)']); ?></div>
                <div class='col-xs-1'></div>
                <div class='col-xs-3'><?php echo $this->Form->input('abnormal_heads', ['label' => 'Abnormal heads %']); ?></div>
            </div>
            <div class="row">
	            <div class='col-xs-3'><?php echo $this->Form->input('cpa_fresh_total_motility', ['label' => 'Total Motility %']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mbcd_total_motality', ['label' => 'Total Motility %']); ?></div>
                <div class='col-xs-1'></div>
                <div class='col-xs-3'><?php echo $this->Form->input('abnormal_tails', ['label' => 'Abnormal tails %']); ?></div>
            </div>
            <div class="row">
	            <div class='col-xs-3'><?php echo $this->Form->input('cpa_fresh_rapid_motility', ['label' => 'Rapid Motility %']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mbcd_rapid_motality', ['label' => 'Rapid Motility %']); ?></div>
                <div class='col-xs-1'></div>
                <div class='col-xs-3'><?php $this->Form->input('sperm_analyzer'); 
                    echo $this->CustomForm->displayField(
                    'sperm_analyzer', 
                    ['IVOS' => 'IVOS', 'CEROS' => 'CEROS'],
                    true,
                    ['empty'=>true]
                ); ?></div>   
            </div>
            <div class="row">
	            <div class='col-xs-3'><?php echo $this->Form->input('cpa_fresh_prog_motality', ['label' => 'Prog. Motility %']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mbcd_prog_motality', ['label' => 'Prog. Motility %']); ?></div>
			</div>
            <hr/>
            <div class="row">   
                <div class='col-xs-12'><?php echo $this->Form->input('sperm_info_comments'); ?></div>
            </div>
            <div class="important" style="margin-bottom:30px;">
            	<p><span class="important">If no SC, Epi storage:</span></p>
                <div style="margin-left:65px">
                    <div class="row">
            	        <div class='col-xs-3'><?php echo $this->Form->input('epi_storage_tank', ['label' => 'Tank']); ?></div>
                        <div class='col-xs-3'><?php echo $this->Form->input('epi_storage_rack', ['label' => 'Rack']); ?></div>
                        <div class='col-xs-3'><?php echo $this->Form->input('epi_storage_box', ['label' => 'Box']); ?></div>
                        <div class='col-xs-3'><?php echo $this->Form->input('epi_storage_space', ['label' => 'Space']); ?></div>
                    </div>
                    <div class="row">    
                        <div class='col-xs-2'><?php echo $this->Form->input('epi_storage_vial_id_no', ['label' => 'Vial ID']); ?></div>
                        <div class='col-xs-2'><?php echo $this->Form->input('epi_storage_code', ['label' => 'Code']); ?></div>
                        <div class='col-xs-3'>
                        <label class="control-label" for="male_genotype_confirmed">Male genotype confirmed?</label>
                        <div class="switch-toggle well">
                            <input id="male_genotype_confirmed_yes" name="male_genotype_confirmed" type="radio" value="1" >
                            <label class="pointer" for="male_genotype_confirmed_yes">Yes</label>
                            <input id="male_genotype_confirmed_no" name="male_genotype_confirmed" value="0" type="radio" checked>
                            <label class="pointer" for="male_genotype_confirmed_no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                        </div> 
                        <div class='col-xs-2'><?php echo $this->CustomForm->displayDatepickerField('geno_date', ['empty'=>true, 'label'=>'Genotyping Date (YYYY-MM-DD)']); ?></div>
                        <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                                'genotyped_by', 
                                $this->CustomForm->getNameList(),
                                true,
                                ['empty'=>true]
                            ); ?></div>
                    </div>
               </div>
            </div>

       		<div class='alert alert-info' role='alert'>Eggs Info</div>
			<div class="row">  
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'eggs_info_donor_strain', 
                        $this->CustomForm->getDonorStrainList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'eggs_info_genotype', 
                        $this->CustomForm->getFemaleGenotypeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('eggs_info_donor_dob', ['label' => 'Donor DOB (YYYY-MM-DD)', 'empty'=>true]); ?></div>
                <div class='col-xs-1'><strong>-or-</strong></div>
                <div class='col-xs-2'><?= $this->Form->input('eggs_info_donor_age', ['label' => 'Age (weeks)']); ?></div>
            </div>     
            <div class="row">  
                <div class='col-xs-4'><?php echo $this->Form->input('females_ordered_no', ['label' => '# Females ordered']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('females_out_no', ['label' => '# Females out']); ?></div>
                <div class='col-xs-4'><?php echo $this->Form->input('unsuperovulated_no', ['label' => '# Unsuperovulated']); ?></div>
                
            </div>
            <div class="row">  
                <div class='col-xs-4'>
                    <?php echo $this->CustomForm->timeInput('pmsg_time', 'PMSG Time'); ?>
                </div>
                <div class='col-xs-4'>
                    <?php echo $this->CustomForm->timeInput('hcg_time', 'HCG Time'); ?>                   
                </div>
                <div class='col-xs-4'><?php echo $this->Form->input('pmsg_hcg_by', ['empty' => true, 'label'=> "PMSG/HCG By"]); ?></div>
            </div>
            <div class="row">                      
    			<div class='col-xs-12'><?php echo $this->Form->input('eggs_info_comments'); ?></div>
            </div>
       		<div class='alert alert-info' role='alert'>IVF Info</div>
            <div class="row">
                <div class='col-xs-3'>
                    <label class="control-label" for="icsi">ICSI?</label>
                    <div class="switch-toggle well">
                        <input id="icsi_yes" name="icsi" type="radio" value="1">
                        <label class="pointer" for="icsi_yes">Yes</label>
                        <input id="icsi_no" name="icsi" value="0" type="radio" checked>
                        <label class="pointer" for="icsi_no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'ivf_method', 
                        $this->CustomForm->getIvfMethodList(),
                        true,
                        ['empty'=>true, 'label' => 'IVF Method']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'incubator_id_no', 
                        $this->CustomForm->getIncubatorList(),
                        true,
                        ['empty'=>true, 'label' => 'Incubator ID']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'ivf_icsi_by', 
                        ['Lisa Baker' => 'Lisa Baker', 'Victoria Gilbert' => 'Victoria Gilbert', 'Kristy Williams' => 'Kristy Williams', 'Ming Wen Li' => 'Ming Wen Li'],
                        true,
                        ['empty'=>true, 'label' => 'IVF/ICSI By']
                    ); ?></div>                                                       
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('co_culture_hrs', ['label' => 'Co-culture hrs']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->timeInput('two_cell_score_time', '2-cell Score Time'); ?>      
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('ivf_icsi_info_comment', ['label' => 'Comment']); ?></div>
            </div>
       		<div class='alert alert-info' role='alert'>More ICSI/Laser Info</div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('eggs_injected_no', ['label' => 'Eggs Injected #']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('eggs_survived_no', ['label' => 'Eggs Survived #']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('survival_rate', ['label' => 'Survival Rate %']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->timeInput('egg_collection_time', 'Egg Collection Time'); ?>      
                </div>
            </div>
            <div class='row'>                              
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'laser_system', 
                        ['L3' => 'L3', 'L7' => 'L7'],
                        true,
                        ['empty'=>true, 'label' => 'Laser System']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pulse_duration', ['label' => 'Pulse Duration (µs)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('laser_power', ['label' => 'Laser Power %']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->timeInput('icsi_end_time', 'ICSI End Time'); ?>      
                </div>
            </div>
            <div class="row">
                <div class='col-xs-12'><?php echo $this->Form->input('more_icsi_info_comments', ['label' => 'Comments']); ?></div>
            </div>
       		<div class='alert alert-info' role='alert'>Media</div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'ivf_medium', 
                        ['RVF with high Ca' => 'RVF with high Ca', 'HTF + BSA' => 'HTF + BSA'],
                        true,
                        ['empty'=>true, 'label' => 'IVF Medium']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ivf_medium_lot', ['label' => 'IVF medium lot']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'ivf_medium_vendor', 
                        ['Cook Medical, Inc.' => 'Cook Medical, Inc.', 'Zenith' => 'Zenith'],
                        true,
                        ['empty'=>true, 'label' => 'IVF Medium Vendor']
                    ); ?></div>
                
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'oil_vendor', [
                        'Fisher' => 'Fisher',
                        'Sigma' => 'Sigma',
                        'Zenith' => 'Zenith'
                        ],
                        true,
                        ['empty'=>true, 'label' => 'Oil Vendor']
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('oil_lot'); ?></div>
            </div>
        </fieldset>
    </div>
    <hr/>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); 
        echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $job_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
	?>
    <?= $this->Form->end() ?>
</div>
