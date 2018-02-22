<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Inventory Location'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="inventoryLocations index large-9 medium-8 columns content">
    <h3><?= __('Inventory Locations') ?></h3>
    <table class="table stripe order-column">
        <thead>
            <tr class="info">
                <th><?= $this->Paginator->sort('id', ['label' => 'Location ID']) ?></th>
                <th><?= $this->Paginator->sort('cell') ?></th>
                <th><?= $this->Paginator->sort('inventory_box_id', ['label' => 'Box ID']) ?></th>
                <th style="min-width:200px">Box Hierarchy</th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryLocations as $inventoryLocation): ?>
            <tr>
                <td><?= $this->Number->format($inventoryLocation->id) ?></td>
                <td><?= $this->Number->format($inventoryLocation->cell) ?></td>
                <td><?= $inventoryLocation->inventory_box_id ? $this->Html->link($inventoryLocation->inventory_box_id, ['controller' => 'InventoryBoxes', 'action' => 'view', $inventoryLocation->inventory_box_id]) : '-' ?></td>
                <td>
                <?php
                    $string = '';
                    if (isset($inventoryLocation->parents)) {
                        $string = $this->customForm->getContainersHierarchy($inventoryLocation->parents);
                    }
                    $string .= h($inventoryLocation->inventory_box->inventory_container->name) .">";
                    $string .= $inventoryLocation->inventory_box->name ? $this->Html->link($inventoryLocation->inventory_box->name, ['controller' => 'InventoryBoxes', 'action' => 'view', $inventoryLocation->inventory_box_id]) : '-';
                    echo $string;
                ?>
                </td>
                <td><?= h($inventoryLocation->created) ?></td>
                <td><?= h($inventoryLocation->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryLocation->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryLocation->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryLocation->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryLocation->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr/>
    <div class="pull-right">
        <?php echo $this->Paginator->numbers(); ?>
    </div>
</div>
