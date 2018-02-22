<div class="qcCreflips form large-9 medium-8 columns content">
    <?= $this->Form->create($qcCreflip) ?>
    <div class='container-fluid'>
        <fieldset>
            <legend><?= __('Add Qc Creflip') ?></legend>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('vial_id'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started', ['empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('finished', ['empty' => true, 'default' => '']); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('started_by'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('finished_by'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('pass'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('comment'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('pcr1'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('southern1'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('northern1'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('electroporation1'); ?></div>
            </div>
            <div class='row'>
                <div class='col-xs-3'><?php echo $this->Form->input('pcr2'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('southern2'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('northern2'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('electroporation2'); ?></div>
            </div>
            <div class='row'>                
                <div class='col-xs-3'><?php echo $this->Form->input('pcr3'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('southern3'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('northern3'); ?></div>
                <div class='col-xs-3'><?php echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]); ?></div>
            </div>
        </fieldset>
    </div>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
