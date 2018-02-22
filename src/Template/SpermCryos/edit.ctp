<?= $this->CustomForm->iniConfirmExit('#sc-form', ['job_id']) ?>
<script>
/** Trigger JS on change event
 *  This will prepopulate job fields on page load
 */
$( document ).ready(function() {
    $( "#job-id" ).trigger( "change" );
});
</script>
<div style="margin-bottom:20px;">
    <?php
     echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Sperm Cryo ',
                                        ['action' => 'delete', $spermCryo->id],
                                        array(
                                            'escape' => false,
                                            'class' => 'btn btn-danger pull-right',
                                            'confirm' => __('Are you sure you want to delete # {0}?', $spermCryo->id)
                                        )) . '</span>';
    ?>
</div>
<div class="clearfix"></div>
<div class="spermCryos form large-9 medium-8 columns content">
 <?= $this->Form->create($spermCryo, ['id'=>'sc-form']) ?>
    <fieldset>
        <legend><?= __('Edit Sperm Cryo #'.$spermCryo->id) ?></legend>
        <div class="important" style="margin-bottom:25px;">
<!--             <?php
            $options = [
                'label'=> 'Job ID',
                'empty' => 'Click to select Job ID from dropdown...',
                'readonly' => 'readonly'

            ];

            echo $this->Form->input('job_id', $options);
            ?> -->
            <?php echo $this->Form->input('job_id', array('label' => 'Job ID', 'type'=>'text', 'readonly'=>'readonly', 'required'=>'required')); ?>
            <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled form fields below have been prepopulated with data from Job ID <span id="selected-job"></span>.
            </p>
        </div>
        <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Populating fields with job info...</small></p>
            <div class="row">
                    <?php
                     $tmpDate = '';
                     if (isset($spermCryo->cryo_date)) {
                        $tmpDate = $spermCryo->cryo_date->format('Y-m-d');
                    } ?>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('cryo_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Cryo Date (YYYY-MM-DD)']); ?></div>             
                    <div class='col-sm-3'><?php echo $this->Form->input('pi_first_name', array('label' => 'PI First Name')); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('pi_last_name', array('label' => 'PI Last Name')); ?></div>   
                </div>
                <div class='alert alert-info' role='alert'>Donor info</div>
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->CustomForm->displayField(
                            'donor_genotype', 
                            $this->CustomForm->getGenotypeList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                </div>
                <div class="row">
                    <?php
                    $tmpValue = '';
                    if (isset($spermCryo->job)) {
                      $tmpValue = $spermCryo->job->strain_name;
                    } ?> 
                    <div class='col-xs-4'><strong><?= __('Strain Name') ?>: </strong><?= $tmpValue ?></div>
                    <?php
                    $tmpValue = '';
                    if (isset($spermCryo->job)) {
                      $tmpValue = $spermCryo->job->mmrrc_no;
                    } ?> 
                    <div class='col-xs-3'><strong><?= __('Stock No') ?>: </strong><?= $tmpValue ?></div><br/><br/>
                </div>
                <div class="row">
                    <div class='col-sm-2'><?php echo $this->Form->input('donor_id_no', array('label' => 'Donor ID No')); ?></div>
                    <?php
                    $tmpDonorDate = '';
                    if (isset($spermCryo->donor_dob)) {
                      $tmpDonorDate = $spermCryo->donor_dob->format('Y-m-d');
                    } ?> 
                    <div class='col-sm-2'><?php echo $this->CustomForm->displayDatepickerField('donor_dob', ['empty'=>true, 'label'=>'Donor DOB (YYYY-MM-DD)', 'value' => $tmpDonorDate]); ?></div>
                    <div class='col-sm-2'><?php echo $this->Form->input('donor_age'); ?></div>
                    <?php 
                        if ($spermCryo->donor_genotype_confirmed) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <div class='col-sm-3'><label class="control-label" for="donor_genotype_confirmed">Donor Genotype Confirmed? </label>
                        <div class="switch-toggle well">
                            <input id="donor_genotype_confirmed-yes" name="donor_genotype_confirmed" type="radio" value="1" <?= $open ?> >
                            <label class="pointer" for="donor_genotype_confirmed-yes">Yes</label>
                            <input id="donor_genotype_confirmed-no" name="donor_genotype_confirmed" value="0" type="radio" <?= $closed ?> >
                            <label class="pointer" for="donor_genotype_confirmed-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <?php 
                        if ($spermCryo->incorrect_genotype) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                    ?>
                    <div class='col-xs-3'><label class="control-label" for="incorrect_genotype">Incorrect Genotype? </label>
                        <div class="switch-toggle well">
                            <input id="incorrect_genotype-yes" name="incorrect_genotype" type="radio" value="1" <?= $open ?> >
                            <label class="pointer" for="incorrect_genotype-yes">Yes</label>
                            <input id="incorrect_genotype-no" name="incorrect_genotype" value="0" type="radio" <?= $closed ?> >
                            <label class="pointer" for="incorrect_genotype-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class='col-sm-4'><?php echo $this->Form->input('sperm_taqman', array('label' => 'Sperm TaqMan')); ?></div>
                    <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('taqman_date', ['empty'=>true, 'label'=>'TaqMan Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('taqman_by', array('label' => 'TaqMan By')); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-4'><?php echo $this->Form->input('targeted_status', array('label' => 'Targeted Status')); ?></div>
                    <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('targeted_confirmed_date', ['empty'=>true, 'label'=>'Targeted Confirmed Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('targeted_confirmed_by', array('label' => 'Targeted Confirmed By')); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-4'><?php echo $this->CustomForm->displayDatepickerField('geno_date', ['empty'=>true, 'label'=>'Geno Date (YYYY-MM-DD)']); ?></div>
                    <!-- <div class='col-sm-3'><?php echo $this->Form->input('geno_by', array('label' => 'Genotyped By')); ?></div>          -->
                    <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                            'geno_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Genotyped By']
                        ); ?>
                    </div>   
                    <div class='col-xs-4'><?php echo $this->Form->input('pcr_results', array(
                        'label' => 'PCR Results',
                        'options' => ['positive' => 'positive', 'negative' => 'negative', 'inconclusive' => 'inconclusive'],
                        'empty' => true
                        )); ?>
                    </div>
                </div>                
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('donor_comments', array('label' => 'Donor Comments')); ?></div>                   
                </div> 
            <div class='alert alert-info' role='alert'>Cryo Info</div>
                <div class="row">
                    <div class='col-xs-6'>
                        <?php 
                        if ($spermCryo->distribute_status == "Do Not Distribute") {
                                $noDist = 'checked'; $internal = ''; $dist = '';
                            } elseif ($spermCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
                                $noDist = ''; $internal = 'checked'; $dist = '';
                            } else {
                                $noDist = ''; $internal = ''; $dist = 'checked';
                            }
                        ?>
                        <label class="control-label" for="distribute_status">Distribute? </label>
                        <div class="switch-toggle well">
                            <input id="distribute_status-no" name="distribute_status" type="radio" value="Do Not Distribute" <?= $noDist ?>>
                            <label class="pointer" for="distribute_status-no">Do Not Distribute</label>
                            <input id="distribute_status-internal" name="distribute_status" value="Do Not Distribute- Internal Use Only" type="radio" <?= $internal ?>>
                            <label class="pointer" for="distribute_status-internal">Internal Use Only</label>
                            <input id="distribute_status-yes" name="distribute_status" value="Distribute" type="radio" <?= $dist ?>>
                            <label class="pointer" for="distribute_status-yes">Distribute</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-xs-6'><?php echo $this->Form->input('distribute_comment', array('label' => 'Distribution Comment')); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_sample_type', 
                            ['0.5 ml/male' => '0.5 ml/male', 'Straw' => 'Straw', 'Vial' => 'Vial'],
                            true,
                            ['empty'=>true, 'label' => 'Sample Type']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_method', 
                            ['Cryovial' => 'Cryovial', 'Cryostraw' => 'Cryostraw'],
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_caps_label_color', 
                            $this->CustomForm->getCapColorList(),
                            true,
                            ['empty'=>true, 'label' => 'Caps/Label Color']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_medium', 
                            ['CPA+MTG' => 'CPA+MTG', 'Cryostraw' => 'Cryostraw'],
                            true,
                            ['empty'=>true]
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->Form->input('cryo_cpm_lot_no', array('label' => 'CPM Lot No')); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('cryo_mosm', array('label' => 'CPM mOsm')); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
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
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_scored_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Sperm Scored By']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_collected_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'Sperm Collected By']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cryo_sc_performed_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'SC Performed By']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('user_id', [
                        'label' => 'Cryo Data Entry by',
                        'options' => $users,
                        'default' => $this->request->session()->read('Auth.User.id')
                        ]); ?></div>                        
                </div>
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('cryo_comments'); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('storage_comments'); ?></div>
                </div>
        </fieldset>
    </div>
    <hr />
    <?= $this->Form->button(__('Save'),
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
