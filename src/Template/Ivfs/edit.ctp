<?= $this->CustomForm->iniConfirmExit('#ivf-form', ['job_id']) ?>
<script>
/** Trigger JS on change event
 *  This will prepopulate job fields on page load
 */
$( document ).ready(function() {
    $( "#job-id" ).trigger( "change" );
});
</script>
<div style="margin-bottom:20px;"
<?php
 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete IVF ',
                                    ['action' => 'delete',$ivf->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $ivf->id)
                                    )) . '</span>';
?>
</div>
<div class="clearfix"></div>
<div class="ivfs form large-9 medium-8 columns content">
    <?= $this->Form->create($ivf, ['id'=>'ivf-form']) ?>
    <fieldset>
        <legend><?= __('Edit IVF #' . $ivf->id ) ?></legend>
        <div class="important" style="margin-bottom:25px;">
            <!-- <?php
            $options = [
                'label'=> 'Job ID',
                'empty' => 'Click to select Job ID from dropdown...'
            ];
            $options['default'] = $ivf->job_id;
            $options['readonly'] = 'readonly';
            $options['required'] = 'required';
            echo $this->Form->input('job_id', $options);
            ?> -->
            <?php echo $this->Form->input('job_id', ['type'=>'text', 'label'=>'Job ID', 'readonly'=>'readonly']); ?>
            <p><span class="glyphicon glyphicon-warning-sign"></span> Disabled form fields below have been prepopulated with data from Job ID <span id="selected-job"></span>.
            </p>
        </div>
        <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Populating fields with job info...</small></p>
            <div class='row'>
            <?php
            $tmpDate = '';
            if (isset($ivf->ivf_date)) {
              $tmpDate = $ivf->ivf_date->format('Y-m-d');
            } ?>  
                <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('ivf_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'IVF Date (YYYY-MM-DD)']); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'purpose', 
                    ['Embryo Cryo' => 'Embryo Cryo', 'Sperm Resuscitation' => 'Sperm Resuscitation', 'Strain Rederivation' => 'Sperm Rederviation', 'Sperm Test Thaw to Culture' => 'Sperm Test Thaw to Culture', 'Sperm Test Thaw to Pups' => 'Sperm Test Thaw to Pups', 'ICSI RS' => 'ICSI RS', 'ICSI RD' => 'ICSI RD', 'IVF Practice'=> 'IVF Practice', 'Research' => 'Research', 'Research - Calcium' => 'Research - Calcium', 'MBCD/ICSI Test' =>  'MBCD/ICSI Test', 'MTGL Zygote Injection' => 'MTGL Zygote Injection', 'ICSI Rescue' => 'ICSI Rescue'],
                    true,
                    ['empty'=>true, 'label' => 'Purpose']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('strain_name', ['readonly' => 'readonly']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('background'); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-3'><?php echo $this->Form->input('membership'); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('mmrrc_no', ['label' => 'MMRRC ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('sc_tt_batch_no', ['label' => 'KOMP Clone ID', 'readonly' => 'readonly']); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('bl-no', ['label' => 'BL#', 'readonly' => 'readonly']); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Sperm Info</div>
            <div class="row">
                <div class='col-sm-6'><?php echo $this->Form->input('genotype'); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('sperm_info_donor_strain', ['label' => 'Donor Strain (if wildtype)']); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'fresh_frozen', 
                    ['fresh' => 'fresh', 'frozen' => 'frozen'],
                    true,
                    ['empty'=>true, 'label' => 'Fresh/Frozen']
                    ); ?></div>
            </div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->Form->input('collect_thaw_time', ['label' => 'Collect/Thaw time','empty' => true]); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('time_in_mbcd', ['empty' => true, 'label' => 'Time in MBCD']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('stud_id_no', ['label' => 'Stud ID']); ?></div>
                <?php
                    $tmpDate = '';
                    if (isset($ivf->stud_dob)) {
                        $tmpDate = $ivf->stud_dob->format('Y-m-d');
                } ?> 
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('stud_dob', ['label' => 'Stud DOB (YYYY-MM-DD)', 'empty'=>true, 'value' => $tmpDate]); ?></div>
                </div>
                <div class="important" style="margin-bottom:30px;">
                    <p><span class="important">If frozen:</span></p>
                    <div style="margin-left:65px">
                        <div class="row">
                            <div class='col-sm-3'><?php echo $this->Form->input('sample_type'); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('sperm_cryo_id', ['type'=>'text', 'label'=>'SC #']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('straw_vial_no', ['label' => 'Straw/Vial ID']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('cpa_lot_no', ['label' => 'CPA Lot No']); ?></div>
                        </div>  
                    </div>
                    <p><span class="important">If centrifugation:</span></p>
                    <div style="margin-left:65px">
                        <div class="row">
                           <div class='col-sm-3'><?php echo $this->Form->input('centrifuge_force', ['label' => 'Force (g)']); ?></div>
                           <div class='col-sm-3'><?php echo $this->Form->input('centrifuge_time', ['label' => 'Time (min)', 'empty' => true]); ?></div>
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
                            <div class='col-sm-3'><?php echo $this->Form->input('epi_storage_tank', ['label' => 'Tank']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('epi_storage_rack', ['label' => 'Rack']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('epi_storage_box', ['label' => 'Box']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('epi_storage_space', ['label' => 'Space']); ?></div>
                        </div>
                        <div class="row">    
                            <div class='col-sm-2'><?php echo $this->Form->input('epi_storage_vial_id_no', ['label' => 'Vial ID']); ?></div>
                            <div class='col-sm-2'><?php echo $this->Form->input('epi_storage_code', ['label' => 'Code']); ?></div>
                            <div class='col-sm-3'>
                            <?php 
                            if ($ivf->male_genotype_confirmed) {
                                    $open = 'checked'; $closed = '';
                                } else {
                                    $open = ''; $closed = 'checked';
                                }
                            ?>
                                <label class="control-label" for="male_genotype_confirmed">Male genotype confirmed?</label>
                                <div class="switch-toggle well">
                                    <input id="male_genotype_confirmed_yes" name="male_genotype_confirmed" type="radio" value="1" <?= $open ?> >
                                    <label class="pointer" for="male_genotype_confirmed_yes">Yes</label>
                                    <input id="male_genotype_confirmed_no" name="male_genotype_confirmed" value="0" type="radio" <?= $closed ?> >
                                    <label class="pointer" for="male_genotype_confirmed_no">No</label>
                                    <a class="progress-bar"></a>
                                </div>
                            </div>
                            <?php
                            $tmpDate = '';
                            if (isset($ivf->geno_date)) {
                              $tmpDate = $ivf->geno_date->format('Y-m-d');
                            } ?>   
                            <div class='col-sm-2'><?php echo $this->CustomForm->displayDatepickerField('geno_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Genotyping Date (YYYY-MM-DD)']); ?></div>
                            <div class='col-sm-3'><?php echo $this->Form->input('genotyped_by', ['label' => 'Genotyped By']); ?></div>
                        </div>
                   </div>
                </div>
                <div class='alert alert-info' role='alert'>Eggs Info</div>
                <div class="row">  
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'eggs_info_donor_strain', 
                            $this->CustomForm->getDonorStrainList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'eggs_info_genotype', 
                            $this->CustomForm->getFemaleGenotypeList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <?php
                    $tmpDate = '';
                    if (isset($ivf->eggs_info_donor_dob)) {
                      $tmpDate = $ivf->eggs_info_donor_dob->format('Y-m-d');
                    } ?> 
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('eggs_info_donor_dob', ['label' => 'Donor DOB (YYYY-MM-DD)', 'empty'=>true, 'value' => $tmpDate]); ?></div>
                    <div class='col-sm-1'><strong>-or-</strong></div>
                    <div class='col-sm-2'><?= $this->Form->input('eggs_info_donor_age', ['label' => 'Age (weeks)']); ?></div>
                </div>
                <div class="row">  
                    <div class='col-sm-4'><?php echo $this->Form->input('females_ordered_no', ['label' => 'Females ordered #']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('females_out_no', ['label' => 'Females out #']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('unsuperovulated_no', ['label' => 'Unsuperovulated #']); ?></div>
                    
                </div>
                <div class="row">  
                    <div class='col-sm-4'><?php echo $this->Form->input('pmsg_time', ['empty' => true, 'label' => 'PMSG Time']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('hcg_time', ['empty' => true, 'label' => 'HCG Time']); ?></div>
                    <div class='col-sm-4'><?php echo $this->Form->input('pmsg_hcg_by', ['empty' => true, 'label' => 'PMSG/HCG By']); ?></div>
<!--                     <div class='col-sm-4'><?php echo $this->CustomForm->displayField(
                            'pmsg_hcg_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'PMSG/HCG By']
                        ); ?></div> -->
                </div>
                <div class="row">  
                    <div class='col-sm-12'><?php echo $this->Form->input('eggs_info_comments'); ?></div>
                </div>
                <div class='alert alert-info' role='alert'>IVF Info</div>
                <div class="row">
                    <div class='col-sm-3'>
                    <?php
                        if ($ivf->icsi) {
                                $open = 'checked'; $closed = '';
                            } else {
                                $open = ''; $closed = 'checked';
                            }
                        ?>
                        <label class="control-label" for="icsi">ICSI?</label>
                        <div class="switch-toggle well">
                            <input id="icsi_yes" name="icsi" type="radio" value="1" <?= $open ?>>
                            <label class="pointer" for="icsi_yes">Yes</label>
                            <input id="icsi_no" name="icsi" value="0" type="radio" <?= $closed ?>>
                            <label class="pointer" for="icsi_no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'ivf_method', 
                            $this->CustomForm->getIvfMethodList(),
                            true,
                            ['empty'=>true, 'label' => 'IVF Method']
                        ); ?></div>

                    <div class='col-sm-3'><?php echo $this->Form->input('co_culture_hrs', ['label' => 'Co-culture hrs']); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'incubator_id_no', 
                            $this->CustomForm->getIncubatorList(),
                            true,
                            ['empty'=>true, 'label' => 'Incubator ID']
                        ); ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-3'><?php echo $this->Form->input('two_cell_score_time', ['label' => '2-cell Score Time', 'empty' => true]); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('ivf_icsi_by', ['label' => 'IVF/ICSI By']); ?></div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'><?php echo $this->Form->input('ivf_icsi_info_comment', ['label' => 'Comment']); ?></div>
                </div>
                <div class='alert alert-info' role='alert'>More ICSI Info (Optional)</div>
                <div class='row'>
                    <div class='col-sm-2'><?php echo $this->Form->input('egg_collection_time', ['empty' => true]); ?></div>                   
                    <div class='col-sm-3'><?php echo $this->Form->input('eggs_injected_no', ['label' => 'Eggs Injected #']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('eggs_survived_no', ['label' => 'Eggs Survived #']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('survival_rate', ['label' => 'Survival Rate %']); ?></div>
                </div>
                <div class='row'>           
                    <div class='col-sm-2'><?php echo $this->Form->input('icsi_end_time', ['empty' => true, 'label' => 'ICSI End Time']); ?></div>         
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'laser_system', 
                            ['L3' => 'L3', 'L7' => 'L7'],
                            true,
                            ['empty'=>true, 'label' => 'Laser System']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('pulse_duration', ['label' => 'Pulse Duration (µs)']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('laser_power', ['label' => 'Laser Power %']); ?></div>   
                </div>
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('more_icsi_info_comments', ['label' => 'Comments']); ?></div>
                </div>
                <div class='alert alert-info' role='alert'>Media</div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'ivf_medium', 
                            ['RVF with high Ca' => 'RVF with high Ca', 'HTF + BSA' => 'HTF + BSA'],
                            true,
                            ['empty'=>true, 'label' => 'IVF Medium']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('ivf_medium_lot', ['label' => 'IVF medium lot']); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'ivf_medium_vendor', 
                            ['Cook Medical, Inc.' => 'Cook Medical, Inc.', 'Zenith' => 'Zenith'],
                            true,
                            ['empty'=>true, 'label' => 'IVF Medium Vendor']
                        ); ?></div>                 
                </div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'oil_vendor', [
                            'Fisher' => 'Fisher',
                            'Sigma' => 'Sigma',
                            'Zenith' => 'Zenith'
                            ],
                            true,
                            ['empty'=>true, 'label' => 'Oil Vendor']
                        ); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('oil_lot'); ?></div>
                </div>
        </fieldset>
    </div>
    <hr/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); 
        echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $ivf->job_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
    ?>
    <?= $this->Form->end() ?>
</div>
