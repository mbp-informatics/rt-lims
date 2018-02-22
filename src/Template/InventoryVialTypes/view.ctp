<div class="inventoryVialTypes view large-9 medium-8 columns content">
    <h3><?= __('InventoryVialType')." #".h($inventoryVialType->name) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($inventoryVialType->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryVialType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($inventoryVialType->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($inventoryVialType->modified) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comments') ?></h4>
        <?= $this->Text->autoParagraph(h($inventoryVialType->comments)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Inventory Vials') ?></h4>
        <?php if (!empty($inventoryVialType->inventory_vials)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Label') ?></th>
                <th><?= __('Volume') ?></th>
                <th><?= __('Inventory Sample Id') ?></th>
                <th><?= __('Comments') ?></th>
                <th><?= __('Inventory Vial Type Id') ?></th>
                <th><?= __('Tissue') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryVialType->inventory_vials as $inventoryVials): ?>
            <tr>
                <td><?= h($inventoryVials->id) ?></td>
                <td><?= h($inventoryVials->label) ?></td>
                <td><?= h($inventoryVials->volume) ?></td>
                <td><?= h($inventoryVials->inventory_sample_id) ?></td>
                <td><?= h($inventoryVials->comments) ?></td>
                <td><?= h($inventoryVials->inventory_vial_type_id) ?></td>
                <td><?= h($inventoryVials->tissue) ?></td>
                <td><?= h($inventoryVials->created) ?></td>
                <td><?= h($inventoryVials->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryVialType->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryVialType->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryVialType->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryVialType->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
