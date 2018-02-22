<div class="inventoryLocations view large-9 medium-8 columns content">
    <h3><?= __('Inventory Location')." #".h($inventoryLocation->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Inventory Box') ?></th>
            <td><?= $inventoryLocation->has('inventory_box') ? $this->Html->link($inventoryLocation->inventory_box->name, ['controller' => 'InventoryBoxes', 'action' => 'view', $inventoryLocation->inventory_box->id]) : '-' ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Vial') ?></th>
            <td><?= $inventoryLocation->has('inventory_vial') ? $this->Html->link($inventoryLocation->inventory_vial->id, ['controller' => 'InventoryVials', 'action' => 'view', $inventoryLocation->inventory_vial->id]) : '-' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryLocation->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Box Cell ID') ?></th>
            <td><?= $this->Number->format($inventoryLocation->cell) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($inventoryLocation->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($inventoryLocation->modified) ?></tr>
        </tr>
    </table>
    <div class="related">
        <?php if (!empty($inventoryLocation->inventory_shippings)): ?>
        <h4><?= __('Related Inventory Shippings') ?></h4>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Ship Date') ?></th>
                <th><?= __('Comments') ?></th>
                <th><?= __('Inventory Vial Id') ?></th>
                <th><?= __('Inventory Location Id') ?></th>
                <th><?= __('Contact Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryLocation->inventory_shippings as $inventoryShippings): ?>
            <tr>
                <td><?= h($inventoryShippings->id) ?></td>
                <td><?= h($inventoryShippings->ship_date) ?></td>
                <td><?= h($inventoryShippings->comments) ?></td>
                <td><?= h($inventoryShippings->inventory_vial_id) ?></td>
                <td><?= h($inventoryShippings->inventory_location_id) ?></td>
                <td><?= h($inventoryShippings->contact_id) ?></td>
                <td><?= h($inventoryShippings->created) ?></td>
                <td><?= h($inventoryShippings->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryLocation->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryLocation->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryLocation->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryLocation->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
