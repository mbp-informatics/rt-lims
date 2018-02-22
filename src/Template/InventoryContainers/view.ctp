<div class="inventoryContainers view large-9 medium-8 columns content">
    <h3><?= __('Inventory Container')." ".h($inventoryContainer->name) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($inventoryContainer->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Inventory Container') ?></th>
            <td><?= $inventoryContainer->has('parent_inventory_container') ? $this->Html->link($inventoryContainer->parent_inventory_container->name, ['controller' => 'InventoryContainers', 'action' => 'view', $inventoryContainer->parent_inventory_container->id]) : '-' ?></td>
        </tr>
        <?php if (!empty($inventoryContainer->inventory_boxes)) { ?>
            <tr>
                <th><?= __('Number of Open Spaces') ?></th>
                <td>
                    <?php 
                        $count = 0;
                        $samplesCount = 0;
                        foreach ($inventoryContainer->inventory_boxes as $boxes) {
                            $count += count($boxes->inventory_locations);                           
                            foreach ($boxes->inventory_locations as $locations){
                                if ($locations->inventory_vial) {
                                    $samplesCount += 1;
                                }
                            }
                        };
                        $emptyCount = $count - $samplesCount;
                        echo $emptyCount;
                    ?>       
                </td>
            </tr>
        <?php }; ?>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($inventoryContainer->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($inventoryContainer->modified) ?></tr>
        </tr>
    </table>
    <div class="related horizontal-table">
    <?php if (!empty($inventoryContainer->inventory_boxes)): ?>
        <h4><?= __('Related Inventory Boxes') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Box Type') ?></th>
                <th><?= __('Number of Open Spaces') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryContainer->inventory_boxes as $inventoryBoxes): ?>
            <tr>
                <td><?= h($inventoryBoxes->id) ?></td>
                <td><?= h($inventoryBoxes->name) ?></td>
                <td><?= h($inventoryBoxes->inventory_box_type->name) ?></td>
                <td><?php if (!empty($inventoryBoxes)){
                        $spacesCount = count($inventoryBoxes->inventory_locations);
                        $samplesCount = 0;
                        foreach ($inventoryBoxes->inventory_locations as $locations){
                            if ($locations->inventory_vial) {
                                $samplesCount += 1;
                            }
                        }
                        $emptyCount = $spacesCount - $samplesCount;
                        echo $emptyCount;
                    } else {
                        echo '0';
                    } ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', 'controller'=>'InventoryBoxes', $inventoryBoxes->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', 'controller'=>'InventoryBoxes', $inventoryBoxes->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', 'controller'=>'InventoryBoxes', $inventoryBoxes->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryBoxes->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <hr class="fat">
    <?php endif; ?>
    </div>
    <div class="related horizontal-table">
        <?php if (!empty($inventoryContainer->child_inventory_containers)): ?>
        <h4><?= __('Related Inventory Immediate Children') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Parent ID') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryContainer->child_inventory_containers as $childInventoryContainers): ?>
            <tr>
                <td><?= h($childInventoryContainers->id) ?></td>
                <td><?= h($childInventoryContainers->name) ?></td>
                <td><?= h($childInventoryContainers->parent_id) ?></td>
                <td><?= h($childInventoryContainers->created) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $childInventoryContainers->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $childInventoryContainers->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $childInventoryContainers->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $childInventoryContainers->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <hr class="fat">
    <?php endif; ?>
    </div>
    <!-- Only show the add wedges button if the name contains Goblet and doesn't contain Rack  -->
    <?php if (preg_match("/Goblet/", $inventoryContainer->name)) { if (!preg_match("/Rack/", $inventoryContainer->name)) {
        echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> ' . __('Add Wedges'), ['controller' => 'InventoryContainers', 'action' => 'add_wedges', $inventoryContainer->id], array('escape' => false, 'class' => 'btn btn-warning pad-button'));
    }} ?>
</div>