<div class="qcCustomerInvivos form large-9 medium-8 columns content">
    <?= $this->Form->create($qcCustomerInvivo) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Add QC Customer Invivo') ?></legend>
            <?php $passOptions = ['Passed' => 'Passed', 'Failed'=>'Failed', 'Inconclusive'=>'Inconclusive']; ?>
            <div class='row'>
                <!-- <div class='col-xs-3'><?php echo $this->Form->input('komp_clones_dump_id'); ?></div> -->
                <!-- <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true, 'default' => '']); ?></div>  -->
                <div class='col-xs-3'><?php echo $this->Form->input('quality_control_id', ['options' => $qualityControls, 'empty' => true, 'default' => $qcID]); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('order_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('starting_product'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('injection_outcome', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('injection_date', ['empty'=>true, 'label'=>'Injection Date (YYYY-MM-DD)']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('germline_outcome', ['options' => $passOptions, 'empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->CustomForm->displayDatepickerField('germline_date', ['empty'=>true, 'label'=>'Germline Date (YYYY-MM-DD)']); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-12'><?php echo $this->Form->input('notes'); ?></div>
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
