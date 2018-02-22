<div class="jobAstatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($jobAstatus) ?>
    <fieldset>
        <legend><?= __('Edit Job Astatus') ?></legend>
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
