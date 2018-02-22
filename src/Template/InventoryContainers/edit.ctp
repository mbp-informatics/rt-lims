<div class="inventoryContainers form large-9 medium-8 columns content" style="padding-bottom:150px">
    <?= $this->Form->create($inventoryContainer) ?>
    <fieldset>
        <legend><?= __('Edit Inventory Container') ?></legend>
        <div class="row" >
            <div class="col-sm-6">
              <?= $this->Form->input('name'); ?>
            </div>
            <div class="col-sm-6">
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
            echo $this->CustomForm->displayField(
                    'parent_id', 
                    $options,
                    false,
                    ['empty'=>true]
                );
                ?>
            </div>
          </div>
    </fieldset>
    <hr />
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
