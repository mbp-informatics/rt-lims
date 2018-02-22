<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Qc Creflip'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Users'), ['controller' => 'Users', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New User'), ['controller' => 'Users', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="qcCreflips index large-9 medium-8 columns content">
    <h3><?= __('Qc Creflips') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('vial_id') ?></th>
                <th><?= $this->Paginator->sort('started') ?></th>
                <th><?= $this->Paginator->sort('finished') ?></th>
                <th><?= $this->Paginator->sort('started_by') ?></th>
                <th><?= $this->Paginator->sort('finished_by') ?></th>
                <th><?= $this->Paginator->sort('pass') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($qcCreflips as $qcCreflip): ?>
            <tr>
                <td><?= $this->Number->format($qcCreflip->id) ?></td>
                <td><?= $this->Number->format($qcCreflip->vial_id) ?></td>
                <td><?= h($qcCreflip->started) ?></td>
                <td><?= h($qcCreflip->finished) ?></td>
                <td><?= $this->Number->format($qcCreflip->started_by) ?></td>
                <td><?= $this->Number->format($qcCreflip->finished_by) ?></td>
                <td><?= $this->Number->format($qcCreflip->pass) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $qcCreflip->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $qcCreflip->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $qcCreflip->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $qcCreflip->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
