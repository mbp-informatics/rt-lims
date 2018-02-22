<div class="inventoryBoxes form large-9 medium-8 columns content" style="padding-bottom:150px">
    <?= $this->Form->create($inventoryBox) ?>
    <fieldset>
         <legend><?= __('Edit Box') ?></legend>
        <?php
            $options = [];
            foreach ($inventoryContainers as $containerId => $containerName) {
                    $hierarchy = $this->customForm->getContainersHierarchy($containerHierarchyOptions[$containerId]);
                    //Get id of the last container (0 index in array)
                    if (!empty($containerHierarchyOptions[$containerId])) {
                        $id = $containerHierarchyOptions[$containerId][0]['id'];
                        $options[$containerId] = $hierarchy.$containerName;
                    } else {
                        $options[$containerId] = $containerName;
                    }
            }
        ?>
<div class="row" >
    <div class="col-sm-4">
        <?php echo $this->Form->input('name'); ?>
    </div>
    <div class="col-sm-4">
        <?php
            echo $this->CustomForm->displayField(
                    'inventory_container_id', 
                    $options,
                    false,
                    ['empty'=>true]
                );
        ?>
    </div>
    <div class="col-sm-4">
      <?php echo $this->Form->input('inventory_box_type_id', ['options' => $inventoryBoxTypes]); ?>
    </div>
</div>
    </fieldset>
    <hr/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
