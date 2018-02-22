<div class="inventoryBoxTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryBoxType) ?>
    <fieldset>
        <legend><?= __('Edit Inventory Box Type') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('num_cells');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
