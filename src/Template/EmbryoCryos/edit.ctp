<?= $this->CustomForm->iniConfirmExit('#ec-form') ?>
<script>
/** Calculates the percentage of Blast Rate and
 *  populates the field with the calculated value
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
<?php
 echo '<span data-toggle="tooltip" title="Delete">' . $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete Embryo Cryo ',
                                    ['action' => 'delete',$embryoCryo->id],
                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-danger pull-right',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $embryoCryo->id)
                                    )) . '</span>';
?>
 <div class="clearfix"></div>
<div class="embryoCryos form large-9 medium-8 columns content">
    <?= $this->Form->create($embryoCryo, ['id'=>'ec-form']) ?>
    <fieldset>
        <legend><?= __('Edit Embryo Cryo #' . $embryoCryo->id) ?></legend>
        <div class="important" style="margin-bottom:25px;">
  <!--           <?php
            $options = [
                'label'=> 'Job ID',
                'empty' => 'Click to select Job ID from dropdown...'
            ];
            $options['default'] = $job_id;
            $options['readonly'] = 'readonly';
            $options['required'] = 'required';

            echo $this->Form->input('job_id', $options);
            ?> -->
            <?php echo $this->Form->input('job_id', array('label' => 'Job ID', 'type'=>'text', 'readonly'=>'readonly', 'required'=>'required')); ?>

            <p><span class="glyphicon glyphicon-warning-sign"></span> Some fields below have been prepopulated with data from Job ID <span id="selected-job"></span>.
            </p>

<!--             <?php
            $options = [
                'label'=> 'IVF ID',
                'empty' => 'Click to select IVF from dropdown...'
            ];
            echo $this->CustomForm->displayField(
            	'ivf_id', 
            	$ivfs,
            	false,
            	['empty'=>true, 'label' => 'IVF ID']
            	);
            ?> -->
            <?php echo $this->Form->input('ivf_id', array('label' => 'IVF ID', 'type'=>'text')); ?>
            <p id="ajax-loader"><img src="/img/ajax-loader.gif"> <small>Please wait. Populating fields...</small></p>
        </div>
        <div class="row">
            <?php
                $tmpDate = '';
                if (isset($embryoCryo->cryo_date)) {
                    $tmpDate = $embryoCryo->cryo_date->format('Y-m-d');
            } ?>  
            <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('cryo_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Cryo Date (YYYY-MM-DD)']); ?></div>
            <?php
                $tmpDate = '';
                if (isset($embryoCryo->receiving_date)) {
                    $tmpDate = $embryoCryo->receiving_date->format('Y-m-d');
            } ?> 
        </div>
        <div class="row">
            <div class='col-xs-6'>
                <?php 
                if ($embryoCryo->distribute_status == "Do Not Distribute") {
                        $noDist = 'checked'; $internal = ''; $dist = '';
                    } elseif ($embryoCryo->distribute_status == "Do Not Distribute- Internal Use Only") {
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
        <div class='alert alert-info' role='alert'>Donor info</div>
        <div class="row">
            <div class='col-sm-3'><?php echo $this->Form->input('background', array('label' => 'Male Genetic Background')); ?></div>
            <div class='col-sm-2'><?php echo $this->Form->input('stud_strain', array('label' => 'Male Strain Name')); ?></div>
            <div class='col-sm-2'><?php echo $this->Form->input('stud_id_no', array('label' => 'Stud ID')); ?></div>
            <?php
                $tmpDate = '';
                if (isset($embryoCryo->stud_dob)) {
                    $tmpDate = $embryoCryo->stud_dob->format('Y-m-d');
            } ?>
            <div class='col-sm-2'><?php echo $this->CustomForm->displayDatepickerField('stud_dob', ['label' => 'Stud DOB (YYYY-MM-DD)', 'empty' =>true, 'value' => $tmpDate]); ?></div>
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'male_genotype', 
                    $this->CustomForm->getGenotypeList(),
                    true,
                    ['empty'=>true]
                ); ?></div> 
        </div>
        <div class="row">
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'female_strain_name', 
                    $this->CustomForm->getDonorStrainList(),
                    true,
                    ['empty'=>true]
                );   ?></div>          
            <div class='col-sm-3'><?php echo $this->Form->input('no_females_used', ['label' => 'Number of females used']); ?></div>
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'female_age', 
                    $this->CustomForm->getDonorAgeList(),
                    true,
                    ['empty'=>true]
                ); ?></div>
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'female_genotype', 
                    $this->CustomForm->getGenotypeList(),
                    true,
                    ['empty'=>true]
                ); ?></div> 
        </div>
        <div class="row">
            <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                    'donor_genotyped_by', 
                    $this->CustomForm->getNameList(),
                    true,
                    ['empty'=>true]
                ); ?></div>

                <?php 
                if ($embryoCryo->genotype_confirmed) {
                        $open = 'checked'; $closed = '';
                    } else {
                        $open = ''; $closed = 'checked';
                    }
                ?>
            <div class='col-sm-3'>
                <label class="control-label" for="genotype_confirmed">Genotype Confirmed? </label>
                <div class="switch-toggle well">
                    <input id="genotype_confirmed-yes" name="genotype_confirmed" type="radio" value="1" <?= $open ?> >
                    <label class="pointer" for="genotype_confirmed-yes">Yes</label>
                    <input id="genotype_confirmed-no" name="genotype_confirmed" value="0" type="radio" <?= $closed ?> >
                    <label class="pointer" for="genotype_confirmed-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
            <?php
                $tmpDate = '';
                if (isset($embryoCryo->donor_genotyping_date)) {
                    $tmpDate = $embryoCryo->donor_genotyping_date->format('Y-m-d');
            } ?>
            <div class='col-sm-3'>
            <?php echo $this->CustomForm->displayDatepickerField('donor_genotyping_date', ['label' => 'Donor Genotyping Date (YYYY-MM-DD)', 'empty'=>true, 'value' => $tmpDate]); ?>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12'><?php echo $this->Form->input('donor_genotype_comments', array('label' => 'Donor Genotype Comments')); ?></div>
        </div>
        <div class='alert alert-info' role='alert'>Cryo Info</div>
            <div class="row">
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'fert_method', 
                        $this->CustomForm->getFertMethodList(),
                        true,
                        ['empty'=>true, 'label' => 'Fertilization Method']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'ec_method', 
                        $this->CustomForm->getCryoMethodList(),
                        true,
                        ['empty'=>true, 'label' => 'EC Method']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'ivf_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty'=>true, 'label' => 'IVF By']
                    ); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'ec_by', 
                        $this->CustomForm->getNameList(),
                        true,
                        ['empty'=>true, 'label' => 'EC By']
                    ); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'cryo_embryo_stage', 
                        $this->CustomForm->getCryoEmbryoStageList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('ec_media_lot', ['label' => 'EC Media Lot']); ?></div>
                <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                        'label_color', 
                        $this->CustomForm->getGobletColorList(),
                        true,
                        ['empty'=>true]
                    ); ?></div>
                <div class='col-sm-2'><?php echo $this->CustomForm->displayField(
                        'biocool_id_no', 
                        [ 1 => 1, 2 => 2, 3 => 3, 4 => 4 ],
                        true,
                        ['empty'=>true, 'label' => 'BioCool ID']
                    ); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('proh_time_min', ['label' => 'PROH time (min)']); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-2'><?php echo $this->Form->input('start_temp', ['label' => 'Start Temp *C']); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('start_time', ['empty'=>true]); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('end_temp', ['label' => 'End Temp *C']); ?></div>
                <div class='col-sm-2'><?php echo $this->Form->input('end_time', ['empty'=>true]); ?></div>
                <div class='col-sm-3'><?php echo $this->Form->input('time_hold_at_end_temp'); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-12'><?php echo $this->Form->input('cryo_info_comments'); ?></div>
            </div>
            <div class="row">
                <div class='col-sm-12'><?php echo $this->Form->input('storage_comments'); ?></div>
            </div>
            <div class='alert alert-info' role='alert'>EC Test Thaw QC</div>
                <div class="row">
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'blast_genotype', 
                            $this->CustomForm->getBlastGenotypeList(),
                            true,
                            ['empty'=>true]
                        ); ?></div>
                    <?php 
                    if ($embryoCryo->embryogeno_confirmed) {
                            $open = 'checked'; $closed = '';
                        } else {
                            $open = ''; $closed = 'checked';
                        }
                    ?>
                    <div class='col-sm-3'><label class="control-label" for="embryogeno_confirmed">Embryo Geno Confirmed? </label>
                        <div class="switch-toggle well">
                            <input id="embryogeno_confirmed-yes" name="embryogeno_confirmed" type="radio" value="1" <?= $open ?>>
                            <label class="pointer" for="embryogeno_confirmed-yes">Yes</label>
                            <input id="embryogeno_confirmed-no" name="embryogeno_confirmed" value="0" type="radio" <?= $closed ?>>
                            <label class="pointer" for="embryogeno_confirmed-no">No</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
                <?php
                    $tmpDate = '';
                    if (isset($embryoCryo->embryo_geno_date)) {
                        $tmpDate = $embryoCryo->embryo_geno_date->format('Y-m-d');
                } ?>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('embryo_geno_date', ['empty'=>true, 'value' => $tmpDate, 'label'=> 'Embryo Geno Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'ec_test_genotyped_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true, 'label' => 'EC Test Genotyped By']
                        ); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('embryo_genotype_notes'); ?></div>
                </div>
                <div class="row">
                    <?php
                        $tmpDate = '';
                        if (isset($embryoCryo->thawing_date)) {
                            $tmpDate = $embryoCryo->thawing_date->format('Y-m-d');
                    } ?>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayDatepickerField('thawing_date', ['empty'=>true, 'value' => $tmpDate, 'label'=>'Thawing Date (YYYY-MM-DD)']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('straw_id_no', ['label' => 'Straw ID No']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('recovered_no', ['label' => '# Recovered']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('intact_no', ['label' => '# Intact']); ?></div>
                </div>
                <div class="row">                   
                    <div class='col-sm-3'><?php echo $this->Form->input('cultured_no', ['label' => '# Cultured']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('blasts_no', ['label' => '# Blastocytes']); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('blast_rate', array('readonly' => 'readonly')); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
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
                    <div class='col-sm-3'><?php echo $this->Form->input('culture_medium'); ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('culture_medium_lot'); ?></div>
                    <div class='col-sm-3'><?php echo $this->CustomForm->displayField(
                            'cultured_by', 
                            $this->CustomForm->getNameList(),
                            true,
                            ['empty'=>true]
                        );  ?></div>
                    <div class='col-sm-3'><?php echo $this->Form->input('sc_tt_batch_no', array('label' => 'EC Media Lot')); ?></div>
                </div>
                <div class="row">
                    <div class='col-sm-12'><?php echo $this->Form->input('ec_test_thaw_comments', ['label' => 'EC Test Thaw Comments']); ?></div>
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
   <?= $this->Form->button(__('Save'),
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
