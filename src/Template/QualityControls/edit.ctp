<div class="qualityControls form large-9 medium-8 columns content">
    <?= $this->Form->create($qualityControl) ?>
    <div class='container-fluid'>
        <fieldset>
        <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
        <?php $qcOptions = ['+cre/flp' => '+cre/flp', '+in vivo'=>'+in vivo', 'in vitro'=>'in vitro']; ?>
            <legend><?= __('Add Quality Control') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('es_cell_id', ['options' => $esCells, 'empty' => true]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('assigned_qc', ['options' => $qcOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('purpose'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
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
