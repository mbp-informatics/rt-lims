<div class="jobBstatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($jobBstatus) ?>
    <fieldset>
        <legend><?= __('Add Job Bstatus') ?></legend>
        <?php
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
