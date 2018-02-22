<div class="projectTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($projectType) ?>
    <fieldset>
        <legend><?= __('Add Project Type') ?></legend>
        <?php
            echo $this->Form->input('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
