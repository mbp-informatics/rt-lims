<div class="qcKaryotypes form large-9 medium-8 columns content">
    <?= $this->Form->create($qcKaryotype) ?>
    <div class='container-fluid'>
        <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
        <fieldset>
            <legend><?= __('Add Qc Karyotype') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true, 'default' => $qcID]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'>
                    <?php echo $this->CustomForm->displayField(
                        'euploid', 
                        ['0-10%' => '0-10%', '11-20%' => '11-20%', '21-30%'=> '21-30%','31-40%' => '31-40%', '41-50%' => '41-50%', '51-60%'=> '51-60%', '61-70%'=> '61-70%','71-80%' => '71-80%', '81-90%' => '81-90%', '91-100%'=> '91-100%'],
                        true,
                        ['empty'=>true, 'label' => 'Euploid']
                    ); ?>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
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
