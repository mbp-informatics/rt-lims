<script src='/webroot/js/injections-zygote.js'></script>
<div id="dialog-edit-project-associations" title="Edit Linked Projects"></div>
<script>
$( document ).ready(function() {
//Initiate edit associations dialog
iniDialog('#edit-project-associations', '/projects-injections/edit-multiple/<?= $injection->id ?>', '', null, 600, 550);
});
</script>
<style>
.calc {
    font-size:14px;
    color:#ff0000;
}
</style>

<script>
    function updateLabelEp() {
        var numZyg = document.getElementById('number-zygotes-injected');
        var numZygLabel = numZyg.labels[0];
        numZygLabel.textContent = '# Zygotes Loaded';
        var numSur = document.getElementById('number-survived');
        var numSurLabel = numSur.labels[0];
        numSurLabel.textContent = '# Recovered';
        var surRate = document.getElementById('survival-rate');
        var surRateLabel = surRate.labels[0];
        surRateLabel.textContent = 'Recovery %';
    }

    function updateLabelNoEp() {
        var numZyg = document.getElementById('number-zygotes-injected');
        var numZygLabel = numZyg.labels[0];
        numZygLabel.textContent = '# Zygotes Injected';
        var numSur = document.getElementById('number-survived');
        var numSurLabel = numSur.labels[0];
        numSurLabel.textContent = '# Survived';
        var surRate = document.getElementById('survival-rate');
        var surRateLabel = surRate.labels[0];
        surRateLabel.textContent = 'Survival %';   
    }
</script>

<div class="injections zygote form large-9 medium-8 columns content">
    <?= $this->Form->create($injection) ?>
    <fieldset>
        <legend><?= __('Editing Zygote Microinjection'.$injection->id) ?></legend>
         <div class="important" style="margin-bottom:25px;">
         <br/>
         <div class="row" >
            <div class="col-sm-6">
              <label class="control-label">Project:</label>
              <input class="form-control" type="text" value="<?= $projectsString ?>" disabled>
              <p style="margin-top:7px;"><span class="glyphicon glyphicon-pencil"></span> <span id="edit-project-associations" style="text-decoration:underline; cursor:pointer; color:#337ab7"><small>Change associated projects.</small></span></p>
            </div>
                <div class='col-xs-6'>
                    <?php echo $this->CustomForm->displayDatepickerField('injection_date', ['empty'=>true, 'label'=>'Injection date', 'value'=> isset($injection->injection_date) ? $injection->injection_date->format('Y-m-d') : null]); ?>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12">
                    <?php
                    $in_progress_checked = ''; $passed_checked = ''; $failed_checked = '';
                    switch ($injection->qc_state) {
                        case 'in progress':
                            $in_progress_checked = 'checked';
                            break;
                        case 'passed':
                            $passed_checked = 'checked';
                            break;
                        case 'failed':
                            $failed_checked = 'checked';
                            break;
                    }
                    ?>
                        <label class="control-label" for="qc_state">QC State <sup><span class="badge" data-toggle="tooltip" title="Choose one of the three states.">?</span></label></sup></label>
                        <div class="switch-toggle well">
                            <input id="in-progress" name="qc_state" type="radio" value="in progress" <?= $in_progress_checked ?>>
                            <label class="pointer" for="in-progress">In progress</label>
                            <input id="passed" name="qc_state" value="passed" type="radio" <?= $passed_checked ?>>
                            <label class="pointer" for="passed">Passed</label>
                            <input id="failed" name="qc_state" value="failed" type="radio" <?= $failed_checked ?>>
                            <label class="pointer" for="failed">Failed</label>
                            <a class="progress-bar"></a>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4"><?= $this->Form->input('investigator'); ?></div>
            <div class='col-xs-4'><?= $this->Form->input('pts_ko_mo', ['label' => 'PTS Number']); ?></div>
            <div class="col-sm-4">  
                <?php echo $this->CustomForm->displayField(
                    'membership', 
                    $this->CustomForm->getPrevValuesList('membership'),
                    true,
                    ['empty'=>true, 'label' => 'Membership']
                ) ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
                <?php echo $this->CustomForm->displayField(
                    'recharge', 
                    $this->CustomForm->getPrevValuesList('recharge'),
                    true,
                    ['empty'=>true, 'label' => 'MVP Recharge']
                ) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $this->CustomForm->displayField(
                    'injected_by', 
                    $this->CustomForm->getPrevValuesList('injected_by'),
                    true,
                    ['empty'=>true, 'label' => 'Injected by']
                ) ?>
            </div>
            <?php 
              if ($injection->cr_electroporation) {
                $open = 'checked'; $closed = '';
              } else {
                $open = ''; $closed = 'checked';
              }
            ?>
            <style>
            .ep, .ep-toggle {
                background-color:#ffedb6;
                padding-top:5px;
                padding-bottom:5px;
            }
            </style>
            <div class='col-xs-4 ep-toggle' id="elec-switch">
                <label class="control-label" for="cr_electroporation">Electroporation?</label>
                <div class="switch-toggle well">
                    <input id="cr_electroporation-yes" name="cr_electroporation" type="radio" onclick="updateLabelEp();" value="1" <?= $open?>>
                    <label class="pointer" for="cr_electroporation-yes">Yes</label>
                    <input id="cr_electroporation-no" name="cr_electroporation" value="0" type="radio" onclick="updateLabelNoEp();" <?= $closed?>>
                    <label class="pointer" for="cr_electroporation-no">No</label>
                    <a class="progress-bar"></a>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'voltage', 
                    ['empty'=>true, 'label' => 'Bio-Rad Voltage', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'number_of_pulses', 
                    ['empty'=>true, 'label' => 'Bio-Rad Number of Pulses', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'pulse_duration', 
                    ['empty'=>true, 'label' => 'Bio-Rad Pulse Duration', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'pulse_width', 
                    ['empty'=>true, 'label' => 'Bio-Rad Pulse Width', 'type' => 'number']
                ) ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'ravata_voltage', 
                    ['empty'=>true, 'label' => 'Ravata Voltage', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'ravata_number_of_pulses', 
                    ['empty'=>true, 'label' => 'Ravata Number of Pulses', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'ravata_pulse_duration', 
                    ['empty'=>true, 'label' => 'Ravata Pulse Duration', 'type' => 'number']
                ) ?>
            </div>
            <div class="col-xs-3 ep">
                <?php echo $this->Form->input(
                    'ravata_pulse_width', 
                    ['empty'=>true, 'label' => 'Ravata Pulse Width', 'type' => 'number']
                ) ?>
            </div>
        </div>

        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
            ]);
        ?>
        <div class='alert alert-info' role='alert'>Superovulation</div>
        <div class="row" >
            <div class="col-sm-4">
                <?php echo $this->CustomForm->displayField(
                    'donor_strain', 
                    $this->CustomForm->getMicroinjectionDonorList(),
                    false,
                    ['empty'=>true, 'label' => 'Donor Strain']
                ) ?>
            </div>
            <div class='col-xs-4'>
                <?= $this->Form->input('stud_ids', ['label' => 'Stud IDs']); ?>
            </div>
            <div class='col-xs-4'>
              <?php
              $tmp_val  = isset($injection->donor_date_of_birth) ? $injection->donor_date_of_birth->format('Y-m-d') : '';
              echo $this->CustomForm->displayDatepickerField('donor_date_of_birth', ['empty'=>true, 'label'=>'Donor DOB', 'value' => $tmp_val ]); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
                <?= $this->Form->input('pmsg_time', ['empty'=>true, 'label' => 'PMSG Time']); ?>
            </div>
            <div class='col-xs-4'>
                <?= $this->Form->input('hcg_time', ['empty'=>true, 'label' => 'HCG Time']); ?>
            </div>
            <div class="col-sm-4">
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


        <div class='alert alert-info' role='alert'>Embryo Collection</div>
        <div class="row" >
            <div class="col-sm-4">
                <?= $this->Form->input('number_mated'); ?>
            </div>
            <div class='col-xs-4'>
                <?= $this->Form->input('number_plugged'); ?>
            </div>
            <div class="col-sm-4">
                <?= $this->Form->input('total_eggs_collected'); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
                <?= $this->Form->input('total_zygotes', ['label'=>'Total PN Zygotes Obtained']); ?>
            </div>
            <div class='col-xs-4'>
                <?php echo $this->CustomForm->displayField(
                    'embryos_collected_by', 
                    $this->CustomForm->getPrevValuesList('embryos_collected_by'),
                    true,
                    ['empty'=>true, 'label' => 'Embryos Collected By']
                ) ?>
            </div>
            <div class="col-sm-4">
            </div>
        </div>

        <div class='alert alert-info' role='alert'>Microinjection Info</div>
        <div class="row" >
            <div class='col-xs-3'><?= $this->Form->input('number_zygotes_injected', ['label'=>'# Zygotes Loaded']); ?></div>
            <div class='col-xs-3'><?= $this->Form->input('number_survived', ['label'=>'# Recovered']); ?></div>
            <div class="col-sm-3"><?= $this->Form->input('survival_rate', ['label'=>'Recovery %', 'readonly'=>true]); ?></div>
            <div class='col-xs-3'><?= $this->Form->input('number_two_cell', ['label'=>'# 2-cell']); ?></div>
        </div>
        <div class="row" >
            <div class='col-xs-3'><?= $this->Form->input('two_cell_rate', ['label'=>'2-cell %', 'readonly'=>true]); ?></div>
 <!--            <div class="col-sm-3"><?= $this->Form->input('number_transferred', ['label'=>"# ET'd"]); ?></div>
            <div class="col-sm-3"><?php echo $this->CustomForm->displayField(
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
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
 <hr/>
 <!--
    <p><span class="glyphicon glyphicon-warning-sign"></span> On submitting the injection, it will be saved in RT-lims AND <strong>an MI Attempt will be created in iMits</strong>. Please make sure the form input is correct.</p>
    -->
</div>