<div class="inventoryBoxes form large-9 medium-8 columns content" style="padding-bottom:150px">
    <?= $this->Form->create($inventoryBox) ?>
    <fieldset>
        <legend><?= __('Add Box') ?></legend>
        <!-- <span class="important"><span class="glyphicon glyphicon-warning-sign"></span> Adding boxes automatically creates locations.</span> -->
<!--         <br/><br/> -->
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
            <div class="col-sm-12">
                Possible boxes are any boxes or wedges. 
                <ul>
                  <li>To create a new box, enter the name of the box and the container that it goes in. Selecting the type of box determines how many empty spaces are created inside it.</li>
                  <li>If you want to create a goblet, you should create it as a container and make sure it contains the word goblet in the name (ex. Goblet 3A, not just 3A). If you do this there will be a button on the goblet page to automatically generate all of the wedges inside the goblet which will save you some work! </li>
                </ul>
            </div>
        </div>
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
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
