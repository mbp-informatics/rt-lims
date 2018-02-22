<?= $this->CustomForm->iniConfirmExit('#ec-form', ['job_id']) ?>
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
    /** Calculates the percentage of Blast Rate and
     *  populates the field with calculated value
     */
    $( document ).ready(function() {
        $('#blasts-no, #cultured-no').change(function(){
            var blasts =  $('#blasts-no').val() ;
            var cultured = parseFloat( $('#cultured-no').val() );
            if (blasts =='') {
                blasts = 0;
            } else {
                blasts = parseFloat(blasts)
            }
            if (cultured > 0 ) {
                var perc = parseFloat( (blasts/cultured)*100 );
                $('#blast-rate').val(perc.toFixed(2));
                lightUp('#blast-rate', 'yellow');
            }
        });
    });
</script>
<style>
#ivf-info{
    display:none;
}
</style>
<div class="embryoCryos form large-9 medium-8 columns content">
    <?= $this->Form->create($embryoCryo, ['id'=>'ec-form']) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Add Embryo Cryo') ?></legend>
            <div class="important" style="margin-bottom:25px;">
                <div><?php echo $this->Form->input('job_id', array('label' => 'Job ID', 'type'=> 'text', 'default'=>$job_id)); ?></div>
                <?php
                if (!isset($job_id))  { ?>
                    <p><span class="glyphicon glyphicon-warning-sign"></span> Some fields in this form will be automatically populated with data when you select <em>Job ID</em> from the dropdown above.
                    </p>
                <?php } else { ?>
                    <p><span class="glyphicon glyphicon-warning-sign"></span> Some form fields below have been prepopulated with data from Job ID <?= $job_id ?>.
                    </p>
                    <?php } ?>
                <div><?php echo $this->Form->input('ivf_id', array('label' => 'IVF ID', 'type'=> 'text')); ?></div>
            <p id="ivf-info"><span class="glyphicon glyphicon-warning-sign"></span> Some fields below have been prepopulated with data from IVF ID <span id="selected-ivf"></span>.
            </p>
            <p id="ajax-loader"><img src="/img/ajax-loader.gif"> <small>Please wait. Populating fields...</small></p>
            </div>

            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('cryo_date', ['empty'=>true, 'label'=>'Cryo Date (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('strain_name', array('label' => 'Job Strain Name' ,'readonly' => 'readonly')); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pi', array('label' => 'PI' ,'readonly' => 'readonly')); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('mmrrc_no', array('label' => 'MMRRC #' ,'readonly' => 'readonly')); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('esc_clone_id_no', array('label' => 'KOMP Clone ID' ,'readonly' => 'readonly')); ?></div>
            </div>
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
            <div class='alert alert-info' role='alert'>Donor info</div>
            <div class="row">               
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'donor_genotyped_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayDatepickerField('donor_genotyping_date', ['label' => 'Donor Genotyping Date (YYYY-MM-DD)', 'empty'=>true]); ?>
                </div>
                <div class='col-xs-3'>
                    <label class="control-label" for="genotype_confirmed">Genotype Confirmed? </label>
                    <div class="switch-toggle well">
                        <input id="genotype_confirmed-yes" name="genotype_confirmed" type="radio" value="1">
                        <label class="pointer" for="genotype_confirmed-yes">Yes</label>
                        <input id="genotype_confirmed-no" name="genotype_confirmed" value="0" type="radio" checked>
                        <label class="pointer" for="genotype_confirmed-no">No</label>
                        <a class="progress-bar"></a>
                    </div>
                </div>
                <!-- <div class='col-xs-3'><?php echo $this->Form->input('background', array('label' => 'Male Genetic Background')); ?></div> -->
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                    'background', 
                    $this->CustomForm->getBackgroundList(),
                    true,
                    ['empty'=>true, 'label' => 'Male Genetic Background']
                ); ?></div>
            </div>
            <div class="row">
                
                <div class='col-xs-3'><?php echo $this->Form->input('stud_strain', array('label' => 'Male Strain Name')); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('stud_id_no', array('label' => 'Stud ID')); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('stud_dob', ['label' => 'Stud DOB (YYYY-MM-DD)', 'empty' =>true]); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'male_genotype', 
                        $this->CustomForm->getGenotypeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            </div>
            <div class="row">
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'female_strain_name', 
                        $this->CustomForm->getDonorStrainList(),
                        true,
                        ['empty'=>true]
                    );   ?></div>          
                <div class='col-xs-3'><?php echo $this->Form->input('no_females_used', ['label' => 'No of females used']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'female_age', 
                        $this->CustomForm->getDonorAgeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                        'female_genotype', 
                        $this->CustomForm->getGenotypeList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
            </div>

            <div class="row">
                <div class='col-xs-12'><?php echo $this->Form->input('donor_genotype_comments', array('label' => 'Donor Genotype Comments')); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>Cryo Info</div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'fert_method', 
                            $this->CustomForm->getFertMethodList(),
                            true,
                            ['empty'=>true, 'label' => 'Fertilization Method']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'ec_method', 
                            $this->CustomForm->getCryoMethodList(),
                            true,
                            ['empty'=>true, 'label' => 'EC Method']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'ivf_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'IVF By']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'ec_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'EC By']
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cryo_embryo_stage', 
                            $this->CustomForm->getCryoEmbryoStageList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-xs-2'><?php echo $this->Form->input('ec_media_lot', ['label' => 'EC Media Lot']); ?></div>
                    <div class='col-xs-2'><?php echo $this->CustomForm->displayField(
                            'label_color', 
                            $this->CustomForm->getGobletColorList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'biocool_id_no', 
                            [ 1 => 1, 2 => 2, 3 => 3, 4 => 4 ],
                            true,
                            ['empty'=>true, 'label' => 'BioCool ID']
                        ); ?></div>
                    <div class='col-xs-2'><?php echo $this->Form->input('proh_time_min', ['label' => 'PROH time (min)']); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->Form->input('start_temp', ['label' => 'Start Temp *C']); ?></div>
                    <div class='col-xs-3'>
                        <?php echo $this->CustomForm->timeInput('start_time', 'Start Time', null, true); ?>    
                        </div>
                    <div class='col-xs-3'><?php echo $this->Form->input('end_temp', ['label' => 'End Temp *C']); ?></div>
                    <div class='col-xs-3'>
                        <?php echo $this->CustomForm->timeInput('end_time', 'End Time', null, true); ?>    
                    </div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->Form->input('time_hold_at_end_temp'); ?></div>
                </div>
                <div class="row">                   
                    <div class='col-xs-12'><?php echo $this->Form->input('cryo_info_comments'); ?></div>
                </div>
            <div class='alert alert-info' role='alert'>EC Test Thaw QC</div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'blast_genotype', 
                            $this->CustomForm->getBlastGenotypeList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>

                    <div class='col-xs-3'><label class="control-label" for="embryogeno_confirmed">Embryo Geno Confirmed? </label>
                        <div class="switch-toggle well">
                            <input id="embryogeno_confirmed-yes" name="embryogeno_confirmed" type="radio" value="1">
                            <label class="pointer" for="embryogeno_confirmed-yes">Yes</label>
                            <input id="embryogeno_confirmed-no" name="embryogeno_confirmed" value="0" type="radio" checked>
                            <label class="pointer" for="embryogeno_confirmed-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>

                    <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('embryo_geno_date', ['empty'=>true, 'label'=>'Embryo Geno Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'ec_test__genotyped_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'EC Test Genotyped By']
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->Form->input('embryo_genotype_notes'); ?></div>
                </div>
                <div class="row">                    
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('thawing_date', ['empty'=>true, 'label'=>'Thawing Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'straw_id_no', 
                            $inventoryVials,
                            true,
                            ['empty'=>true, 'label'=>'Straw Label']
                        ); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('recovered_no', ['label' => '# Recovered']); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('intact_no', ['label' => '# Intact']); ?></div>
                </div>
                <div class="row">                    
                    <div class='col-xs-3'><?php echo $this->Form->input('cultured_no', ['label' => '# Cultured']); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('blasts_no', ['label' => '# Blastocytes']); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('blast_rate', array('readonly' => 'readonly')); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'incubator_no', 
                            ['Multigas' => 'Multigas',
                            '1' => '1',
                            '3' => '3',
                            'SY' => 'SY'
                             ],
                            true,
                            ['empty'=>true]
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-3'><?php echo $this->Form->input('culture_medium'); ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('culture_medium_lot'); ?></div>
                    <div class='col-xs-3'><?php echo $this->CustomForm->displayField(
                            'cultured_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true]
                        );  ?></div>
                    <div class='col-xs-3'><?php echo $this->Form->input('sc_tt_batch_no', array('label' => 'EC Media Lot')); ?></div>
                </div>
                <div class="row">
                    <div class='col-xs-12'><?php echo $this->Form->input('ec_test_thaw_comments', ['label' => 'EC Test Thaw Comments']); ?></div>
                </div>
                <?php
                    echo $this->Form->hidden('user_id', [
                        'options' => $users,
                        'default' => $this->request->session()->read('Auth.User.id')
                ]);
                ?>
        </fieldset>
    </div>
    <hr />
   <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            ));
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $job_id, '#' => 'related-data'], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
            ));
    ?>
    <?= $this->Form->end() ?>
</div>
