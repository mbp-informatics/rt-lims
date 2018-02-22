<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Qc Resequencing'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Users'), ['controller' => 'Users', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New User'), ['controller' => 'Users', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="qcResequencings index large-9 medium-8 columns content">
    <h3><?= __('Qc Resequencings') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('inventory_vial_id') ?></th>
                <th><?= $this->Paginator->sort('started') ?></th>
                <th><?= $this->Paginator->sort('finished') ?></th>
                <th><?= $this->Paginator->sort('started_by') ?></th>
                <th><?= $this->Paginator->sort('finished_by') ?></th>
                <th><?= $this->Paginator->sort('result') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($qcResequencings as $qcResequencing): ?>
            <tr>
                <td><?= $this->Number->format($qcResequencing->id) ?></td>
                <td><?= $this->Number->format($qcResequencing->inventory_vial_id) ?></td>
                <td><?= h($qcResequencing->started) ?></td>
                <td><?= h($qcResequencing->finished) ?></td>
                <td><?= $this->Number->format($qcResequencing->started_by) ?></td>
                <td><?= $this->Number->format($qcResequencing->finished_by) ?></td>
                <td><?= h($qcResequencing->result) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $qcResequencing->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $qcResequencing->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $qcResequencing->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $qcResequencing->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
