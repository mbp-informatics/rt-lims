<div class="inventoryContainers form large-9 medium-8 columns content" style="padding-bottom:150px">
    <?= $this->Form->create($inventoryContainer) ?>
    <fieldset>
        <legend><?= __('Add Container') ?></legend>
        <div class="row" >
            <div class="col-sm-12">
                Possible containers are any tanks, racks, or goblets. 
                <ul>
                  <li>To create a new tank, enter the name of the tank and <em>do not</em> select a parent container. Tanks are the highest level container and do not have a parent. </li>
                  <li>To create a new rack, enter the name of the rack and select the tank it belongs in from the parent dropdown.</li>
                  <li>To create a new goblet, enter the name of the goblet and make sure it contains the word goblet in the name (ex. Goblet 3A, not just 3A). If you do this there will be a button on the goblet page to automatically generate all of the wedges inside the goblet which will save you some work! Select the name of the tank in the parent dropdown. </li>
                </ul>
            </div>
        </div>
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
    <?= $this->Form->button(__('Submit'),
        array(
            'class' => 'btn btn-success',
            'div' => false
            )); ?>
    <?= $this->Form->end() ?>
</div>
