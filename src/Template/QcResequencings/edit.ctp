<div class="qcResequencings form large-9 medium-8 columns content">
    <?= $this->Form->create($qcResequencing) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Edit QC Resequencing') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('result'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
            </div>
            <div class='row'>
                
                
                <div class='col-xs-3'><?php echo $this->Form->input('MGAL_sequence'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('blast_result'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('MGAL_id_location'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('MGAL_expected'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comment'); ?></div>
            </div>
        </fieldset>
        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
        ?>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
