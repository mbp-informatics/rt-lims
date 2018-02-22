<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Qc Pathogen'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Users'), ['controller' => 'Users', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New User'), ['controller' => 'Users', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="qcPathogens index large-9 medium-8 columns content">
    <h3><?= __('Qc Pathogens') ?></h3>
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
            <?php foreach ($qcPathogens as $qcPathogen): ?>
            <tr>
                <td><?= $this->Number->format($qcPathogen->id) ?></td>
                <td><?= $this->Number->format($qcPathogen->inventory_vial_id) ?></td>
                <td><?= h($qcPathogen->started) ?></td>
                <td><?= h($qcPathogen->finished) ?></td>
                <td><?= $this->Number->format($qcPathogen->started_by) ?></td>
                <td><?= $this->Number->format($qcPathogen->finished_by) ?></td>
                <td><?= $this->Number->format($qcPathogen->pass) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $qcPathogen->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $qcPathogen->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $qcPathogen->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $qcPathogen->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
