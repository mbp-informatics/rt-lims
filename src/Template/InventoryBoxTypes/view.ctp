<div class="inventoryBoxTypes view large-9 medium-8 columns content">
    <h3><?= __('Inventory BoxT ype')." ".h($inventoryBoxType->name) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($inventoryBoxType->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryBoxType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Num Cells') ?></th>
            <td><?= $this->Number->format($inventoryBoxType->num_cells) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($inventoryBoxType->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($inventoryBoxType->modified) ?></tr>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Inventory Boxes') ?></h4>
        <?php if (!empty($inventoryBoxType->inventory_boxes)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Inventory Container Id') ?></th>
                <th><?= __('Inventory Box Type Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryBoxType->inventory_boxes as $inventoryBoxes): ?>
            <tr>
                <td><?= h($inventoryBoxes->id) ?></td>
                <td><?= h($inventoryBoxes->name) ?></td>
                <td><?= h($inventoryBoxes->inventory_container_id) ?></td>
                <td><?= h($inventoryBoxes->inventory_box_type_id) ?></td>
                <td><?= h($inventoryBoxes->created) ?></td>
                <td><?= h($inventoryBoxes->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryBoxType->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryBoxType->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryBoxType->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryBoxType->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
