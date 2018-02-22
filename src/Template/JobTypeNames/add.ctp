<div class="jobTypeNames form large-9 medium-8 columns content">
    <?= $this->Form->create($jobTypeName) ?>
    <fieldset>
        <legend><?= __('Add Job Type Name') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
