<div class="changeLog form large-9 medium-8 columns content">
    <?= $this->Form->create($changeLog) ?>
    <fieldset>
        <legend><?= __('Edit Change Log') ?></legend>
        <?php
            echo $this->Form->input('table_alias');
            echo $this->Form->input('entity_id');
            echo $this->Form->input('changes');
            echo $this->Form->input('user_info');
            echo $this->Form->input('old_entity');
            echo $this->Form->input('change_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
