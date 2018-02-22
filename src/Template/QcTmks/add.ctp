<div class="qcTmks form large-9 medium-8 columns content">
    <?= $this->Form->create($qcTmk) ?>
    <div class='container-fluid'>
    <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive', '1.8.11 Passed'=>'1.8.11 Passed']; ?>
    <?php $chrOptions = ['Normal' => 'Normal', 'Low'=>'Low', 'High'=>'High', 'NT'=>'NT']; ?>
        <fieldset>
            <legend><?= __('Add QC TaqMan Karyotypes') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true, 'default' => $qcID]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('euploid'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ch1', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch2', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch3', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch4', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ch5', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch6', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch7', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch8', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ch9', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch10', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch11', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch12', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ch13', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch14', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch15', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch16', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('ch17', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch18', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('ch19', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('chX', ['options' => $chrOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('comment'); ?></div>
            </div>
        <?php
            echo $this->Form->hidden('user_id', [
                'options' => $users,
                'default' => $this->request->session()->read('Auth.User.id')
                ]);
        ?>
        </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
