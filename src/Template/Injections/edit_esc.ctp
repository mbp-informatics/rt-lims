<script src="/webroot/js/injection-esc.js"></script>
<div id="dialog-edit-project-associations" title="Edit Linked Projects"></div>
<script>
$( document ).ready(function() {
//Initiate edit associations dialog
iniDialog('#edit-project-associations', '/projects-injections/edit-multiple/<?= $injection->id ?>', '', null, 600, 450);
});
</script>
<style>
.calc {
  font-size:14px;
  color:#ff0000;
}
</style>
<div class="injections esc form large-9 medium-8 columns content">
    <?= $this->Form->create($injection) ?>
    <fieldset>
        <legend><?= __('Editing ESC Microinjection' . " {$injection->id} (".$injection->injection_type."#".$injection->colony_id .")") ?></legend>
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
        <br/>
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
                <?= $this->Form->input('investigator', ['label'=>'Investigator']); ?>
              </div>
              <div class='col-xs-4'>
                <?= $this->Form->input('pts_ko_mo', ['label'=>'Order #']); ?>
            </div>
          </div>
            <div class="row">
              <div class="col-sm-4">
                <?php echo $this->CustomForm->displayField(
                  'injected_by', 
                  $this->CustomForm->getPrevValuesList('injected_by'),
                  true,
                  ['empty'=>true, 'label' => 'Injected By']
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
               <?php 
              if ($injection->bl_eight_cell) {
                $open = 'checked'; $closed = '';
              } else {
                $open = ''; $closed = 'checked';
              }
              ?>
                <label class="control-label" for="bl_eight_cell">8-cell?</label>
                <div class="switch-toggle well">
                    <input id="bl_eight_cell-yes" name="bl_eight_cell" type="radio" value="1" <?= $open ?>>
                    <label class="pointer" for="bl_eight_cell-yes">Yes</label>
                    <input id="bl_eight_cell-no" name="bl_eight_cell" value="0" type="radio" <?= $closed ?>>
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
        <?php echo $this->CustomForm->displayField(
          'donor_strain', 
          $this->CustomForm->getMicroinjectionDonorList(),
          false,
          ['empty'=>true, 'label' => 'Donor Strain']
        ) ?>
            </div>
            <div class='col-xs-4'>
              <?php
              $tmp_val  = isset($injection->donor_date_of_birth) ? $injection->donor_date_of_birth->format('Y-m-d') : '';
              echo $this->CustomForm->displayDatepickerField('donor_date_of_birth', ['empty'=>true, 'label'=>'Donor DOB', 'value' => $tmp_val ]); ?>
            </div>
            <div class="col-sm-4">
              <?= $this->Form->input('stud_ids', ['label' => 'Stud Set']); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
              <?= $this->Form->input('pmsg_time', ['empty'=>true, 'label' => 'PMSG Time']); ?>
            </div>
            <div class='col-xs-4'>
              <?= $this->Form->input('hcg_time', ['empty'=>true, 'label' => 'HCG Time']); ?>
            </div>
        </div>
        <hr/>
        <div class="row" >
            <div class="col-sm-4">
              <?= $this->Form->input('number_mated'); ?>
            </div>
            <div class='col-xs-4'>
              <?= $this->Form->input('number_plugged'); ?>
            </div>
            <div class="col-sm-4">
        <?= $this->Form->input('embryos_plug', ['label'=>'Embryos/Plug', 'readonly'=>true]); ?>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-4">
              <?= $this->Form->input('total_embryos', ['label'=>'Total Injectable Embryos']); ?>
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
            <div class='col-xs-3'>  <?php echo $this->CustomForm->displayField(
                'microinjection_injection_type', 
                $this->CustomForm->getPrevValuesList('microinjection_injection_type'),
                true,
                ['empty'=>false, 'label' => 'Injection Type']
              ) ?>
            </div>
            <div class='col-xs-3'><?= $this->Form->input('number_injected', ['label'=>'Embryos Injected']); ?></div>
            <div class='col-xs-3'><?= $this->Form->input('number_survived', ['label'=>'Embryos Survived']); ?></div>
<!--             <div class='col-xs-3'>  <?php echo $this->CustomForm->displayField(
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
</div>