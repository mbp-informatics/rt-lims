<div class="esCells form large-9 medium-8 columns content">
    <?= $this->Form->create($esCell) ?>
    <fieldset>
        <legend><?= __('Add Es Cell') ?></legend>
        <?php
            echo $this->Form->input('inventory_vial_id');
            echo $this->Form->input('dna');
            echo $this->Form->input('frozen_date', ['empty' => true, 'default' => '']);
            echo $this->Form->input('frozen_by');
            echo $this->Form->input('passage');
            echo $this->Form->input('parent_id', ['options' => $parentEsCells, 'empty' => true]);
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
            echo $this->Form->input('disposal_date', ['empty' => true, 'default' => '']);
            echo $this->Form->input('disposal_by');
            echo $this->Form->input('item_id');
            echo $this->Form->input('content');
            echo $this->Form->input('status');
            echo $this->Form->input('pos');
            echo $this->Form->input('mra_treated');
            echo $this->Form->input('myco_pos');
            echo $this->Form->input('changed');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
