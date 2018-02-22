<div class="inventoryShippedVials form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryShippedVial) ?>
    <fieldset>
        <legend><?= __('Edit Inventory Shipped Vial') ?></legend>
        <?php
            echo $this->Form->input('label');
            echo $this->Form->input('volume');
            echo $this->Form->input('comments');
            echo $this->Form->input('tissue');
            echo $this->Form->input('pups');
            echo $this->Form->input('do_not_distribute');
            echo $this->Form->input('original_vial_id_no');
            echo $this->Form->input('original_location_id_no');
            echo $this->Form->input('original_vial_type_id_no');
            echo $this->Form->input('original_created');
            echo $this->Form->input('original_modified');
            echo $this->Form->input('original_location_snapshot');
            echo $this->Form->input('original_vial_type_snapshot');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
