<div class="qcMicroinjections form large-9 medium-8 columns content">
    <?= $this->Form->create($qcMicroinjection) ?>
    <div class='container-fluid'>
    <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
        <fieldset>
            <legend><?= __('Edit QC Microinjection') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('inventory_vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('started', ['empty'=>true, 'label'=>'Started (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('finished', ['empty'=>true, 'label'=>'Finished (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('birthdate', ['empty'=>true, 'label'=>'Birthdate (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('injection_type'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('number_recipients'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('number_litters'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('npups', ['label'=>'# of Pups']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('nmale', ['label'=>'# of Male']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('chimerism'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('max_chimerism'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('number_injected'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('bl'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('parent_strain'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('number_pups_born'); ?></div>
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
