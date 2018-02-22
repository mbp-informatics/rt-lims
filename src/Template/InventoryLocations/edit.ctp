<script src="/js/freezer-inventory.js"></script>
<div class="inventoryLocations form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryLocation, ['id' => 'form-inventory-locations']) ?>
    <fieldset>
        <legend><?= __('Edit Inventory Location') ?></legend>
        <div class="row" >
            <div class="col-sm-6">
                <?php
                    /*Prepare list of boxes and their hierarchy for the dropdown*/
                    $options = [];
                    foreach ($containerHierarchyOptions as $boxID => $boxParents) {
                            $hierarchy = $this->customForm->getContainersHierarchy($boxParents);
                            $containerId = $inventoryBoxes[$boxID]['inventory_container_id'];
                            $hierarchy .= $inventoryContainers[$containerId] .">";
                            $hierarchy .= $inventoryBoxes[$boxID]['name'];
                            $hierarchy .= " (id=$boxID)";
                            $options[$boxID] = $hierarchy;
                    }
                    echo $this->CustomForm->displayField(
                            'inventory_box_id', 
                            $options,
                            false,
                            ['empty'=>true]
                        );
                        ?>
            </div>
            <div class="col-sm-6">
                <?php echo $this->Form->input('cell', ['disabled'=>true, 'label' => 'Cell ID']); ?>
            </div>        
        </div>
        <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Please wait...</small></p>    
    </fieldset>
    <hr/>
    <?= $this->Form->button(__('Save'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
