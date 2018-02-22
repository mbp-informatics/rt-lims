<div class="inventoryVialTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryVialType) ?>
    <fieldset>
        <legend><?= __('Add Inventory Vial Type') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('comments');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
