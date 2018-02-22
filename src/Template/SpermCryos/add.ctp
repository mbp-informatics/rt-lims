<?= $this->CustomForm->iniConfirmExit('#sc-form', ['job_id']) ?>
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
</br>
<div class="spermCryos form large-9 medium-8 columns content">
    <div class='container-fluid'>
        <?= $this->Form->create($spermCryo, ['id'=>'sc-form']) ?>
        <fieldset>
            <legend><?= __('Add Sperm Cryo') ?></legend>
            <div class="important" style="margin-bottom:25px;">

                <div><?php echo $this->Form->input('job_id', array('label' => 'Job ID', 'type'=> 'text', 'default'=>$job_id)); ?></div>
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
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->Form->input('membership', array('readonly' => 'readonly')); ?></div> <!-- all disabled fields values are automatically populated from job -->
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('cryo_date', ['empty'=>true, 'label'=>'Cryo Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('esc_clone_id_no', array('label' => 'KOMP Clone ID', 'readonly' => 'readonly')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('strain_name', array('readonly' => 'readonly')); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'background', 
                            $this->CustomForm->getBackgroundList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('mmrrc_no', array('label' => 'MMRRC ID', 'readonly' => 'readonly')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('pi', array('label' => 'PI' ,'readonly' => 'readonly')); ?></div>
                </div>
                <div class='alert alert-info' role='alert'>Donor info</div>
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->CustomForm->displayField(
                            'donor_genotype', 
                            $this->CustomForm->getGenotypeList(),
                            true,
                            ['empty'=>true, 'label'=>'Genotype']
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-4'><?php echo $this->Form->input('donor_id_no', array('label' => 'Donor ID No')); ?></div>
                    <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('donor_dob', ['empty'=>true, 'label'=>'Donor DOB (YYYY-MM-DD)']); ?></div>
                    <div class='col-xs-4'><?php echo $this->Form->input('donor_age'); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><label class="control-label" for="donor_genotype_confirmed">Donor Genotype Confirmed? </label>
                        <div class="switch-toggle well">
                            <input id="donor_genotype_confirmed-yes" name="donor_genotype_confirmed" type="radio" value="1">
                            <label class="pointer" for="donor_genotype_confirmed-yes">Yes</label>
                            <input id="donor_genotype_confirmed-no" name="donor_genotype_confirmed" value="0" type="radio" checked>
                            <label class="pointer" for="donor_genotype_confirmed-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-xs-3'><label class="control-label" for="incorrect_genotype">Incorrect Genotype? </label>
                        <div class="switch-toggle well">
                            <input id="incorrect_genotype-yes" name="incorrect_genotype" type="radio" value="1">
                            <label class="pointer" for="incorrect_genotype-yes">Yes</label>
                            <input id="incorrect_genotype-no" name="incorrect_genotype" value="0" type="radio" checked>
                            <label class="pointer" for="incorrect_genotype-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('geno_date', ['empty'=>true, 'label'=>'Geno Date (YYYY-MM-DD)']); ?></div>
                    <!-- <div class='col-xs-4'><?php echo $this->Form->input('geno_by', array('label' => 'Genotyped By')); ?></div>    -->
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'geno_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Genotyped By']
                        ); ?></div>
                </div>
                <div class="row">                    
                    <div class='col-xs-3'><?php echo $this->Form->input('sperm_taqman', array('label' => 'Sperm TaqMan')); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('taqman_date', ['empty'=>true, 'label'=>'TaqMan Date (YYYY-MM-DD)']); ?></div>
                    <!-- <div class='col-xs-4'><?php echo $this->Form->input('taqman_by', array('label' => 'TaqMan By')); ?></div>               -->
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'taqman_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'TaqMan By']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('pcr_results', array(
                        'label' => 'PCR Results',
                        'options' => ['positive' => 'positive', 'negative' => 'negative', 'inconclusive' => 'inconclusive'],
                        'empty' => true
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class='col-xs-4'><?php echo $this->Form->input('targeted_status', array('label' => 'Targeted Status')); ?></div>
                    <div class='col-xs-4'><?php echo $this->CustomForm->displayDatepickerField('targeted_confirmed_date', ['empty'=>true, 'label'=>'Targeted Confirmed Date (YYYY-MM-DD)']); ?></div>
                    <!-- <div class='col-xs-4'><?php echo $this->Form->input('targeted_confirmed_by', array('label' => 'Targeted Confirmed By')); ?></div>       -->
                    <div class='col-xs-4'><?php echo $this->CustomForm->displayField(
                            'targeted_confirmed_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Targeted Confirmed By']
                        ); ?></div>           
                </div> 
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->Form->input('donor_comments', array('label' => 'Donor Comments')); ?></div>                   
                </div> 
                <div class='alert alert-info' role='alert'>Cryo Info</div>
                <div class="row">
                    <div class='col-xs-6'>
                        <label class="control-label" for="distribute_status">Distribute? </label>
                        <div class="switch-toggle well">
                            <input id="distribute_status-no" name="distribute_status" type="radio" value="Do Not Distribute">
                            <label class="pointer" for="distribute_status-no">Do Not Distribute</label>
                            <input id="distribute_status-internal" name="distribute_status" value="Do Not Distribute- Internal Use Only" type="radio">
                            <label class="pointer" for="distribute_status-internal">Internal Use Only</label>
                            <input id="distribute_status-yes" name="distribute_status" value="Distribute" type="radio" checked>
                            <label class="pointer" for="distribute_status-yes">Distribute</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-xs-6'><?php echo $this->Form->input('distribute_comment', array('label' => 'Distribution Comment')); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_sample_type', 
                            ['0.5 ml/male' => '0.5 ml/male', 'Straw' => 'Straw', 'Vial' => 'Vial'],
                            true,
                            ['empty'=>true, 'label' => 'Sample Type']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_method', 
                            ['Cryovial' => 'Cryovial', 'Cryostraw' => 'Cryostraw'],
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_caps_label_color', 
                           	$this->CustomForm->getCapColorList(),
                            true,
                            ['empty'=>true, 'label' => 'Caps/Label Color']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_medium', 
                            ['CPA+MTG' => 'CPA+MTG', 'Cryostraw' => 'Cryostraw'],
                            true,
                            ['empty'=>true]
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_cpm_lot_no', array('label' => 'CPM Lot No')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_mosm', array('label' => 'CPM mOsm')); ?></div>                   
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_sperm_analyser', 
                            ['IVOS' => 'IVOS', 'Ceros' => 'Ceros'],
                            true,
                            ['empty'=>true]
                        ); ?></div>  
                    <div class='col-xs-3'><?php echo $this->Form->input('vapor_temperature', array('label' => 'LN2 Vapor Temperature (C)')); ?></div>                     
                </div>
                <hr>
                <p><span class="important">Pre-Freeze:</span></p>
                <div class="row">  
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_sperm_conc', array('label' => 'Sperm Concentration (M/ml)')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_total_motility', array('label' => 'Total Motility %')); ?></div>                
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_rapid_motility', array('label' => 'Rapid Motility %')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_prog_motility', array('label' => 'Prog. Motility %')); ?></div>               
                </div>
                <div class="row"> 
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_abnormal_heads', array('label' => 'Abnormal Heads %')); ?></div>   
                    <div class='col-xs-3'><?php echo $this->Form->input('cryo_abnormal_tails', array('label' => 'Abnormal Tails %')); ?></div>    
                </div>
                <br>
                <p><span class="important">Post-Thaw:</span></p>
                <div class="row">    
                    <div class='col-xs-3'><?php echo $this->Form->input('post_sperm_conc', array('label' => 'Sperm Concentration (M/ml)')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('post_total_motility', array('label' => 'Total Motility %')); ?></div>                
                    <div class='col-xs-3'><?php echo $this->Form->input('post_rapid_motility', array('label' => 'Rapid Motility %')); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('post_prog_motility', array('label' => 'Prog. Motility %')); ?></div>               
                </div>
                <hr>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_scored_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Sperm Scored By']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_collected_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Sperm Collected By']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_sc_performed_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'SC Performed By']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('user_id', [
                        'label' => 'Cryo Data Entry by',
                        'options' => $users,
                        'default' => $this->request->session()->read('Auth.User.id')
                        ]); ?></div>                        
                </div>
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->Form->input('cryo_comments'); ?></div>
                </div>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
    
    if (isset($job_id)) {
        $options = ['controller' => 'Jobs', 'action' => 'view', $job_id, '#' => 'related-data'];
    } else {
        $options = ['controller' => 'SpermCryos', 'action' => 'index', '#' => 'related-data'];        
    }

    echo $this->Html->link('' . __('Go Back'), $options, array(
            'escape' => false,
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px'
    ));
?>    
    <?= $this->Form->end() ?>
</div>
