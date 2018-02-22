<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Inventory Vial Type'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="inventoryVialTypes index large-9 medium-8 columns content">
    <h3><?= __('Inventory Vial Types') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryVialTypes as $inventoryVialType): ?>
            <tr>
                <td><?= $this->Number->format($inventoryVialType->id) ?></td>
                <td><?= h($inventoryVialType->name) ?></td>
                <td><?= h($inventoryVialType->created) ?></td>
                <td><?= h($inventoryVialType->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $inventoryVialType->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $inventoryVialType->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $inventoryVialType->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $inventoryVialType->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
