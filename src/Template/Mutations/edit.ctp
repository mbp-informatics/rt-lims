<div class="mutations form large-9 medium-8 columns content">
    <?= $this->Form->create($mutation) ?>
    <fieldset>
        <legend><?= __('Edit Mutation') ?></legend>
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
