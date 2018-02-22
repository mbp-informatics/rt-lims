<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Quality Control'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="qualityControls index large-9 medium-8 columns content">
    <h3><?= __('Quality Controls') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('inventory_vial_id') ?></th>
                <th><?= $this->Paginator->sort('started') ?></th>
                <th><?= $this->Paginator->sort('finished') ?></th>
                <th><?= $this->Paginator->sort('started_by') ?></th>
                <th><?= $this->Paginator->sort('finished_by') ?></th>
                <th><?= $this->Paginator->sort('pass') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($qualityControls as $qualityControl): ?>
            <tr>
                <td><?= $this->Number->format($qualityControl->id) ?></td>
                <td><?= $qualityControl->has('inventory_vial') ? $this->Html->link($qualityControl->inventory_vial->label, ['controller' => 'InventoryVials', 'action' => 'view', $qualityControl->inventory_vial->id]) : '' ?></td>
                <td><?= h($qualityControl->started) ?></td>
                <td><?= h($qualityControl->finished) ?></td>
                <td><?= $this->Number->format($qualityControl->started_by) ?></td>
                <td><?= $this->Number->format($qualityControl->finished_by) ?></td>
                <td><?= $this->Number->format($qualityControl->pass) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $qualityControl->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $qualityControl->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $qualityControl->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $qualityControl->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
