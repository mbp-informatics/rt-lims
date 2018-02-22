<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Project Status'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="projectStatuses index large-9 medium-8 columns content">
    <h3><?= __('Project Statuses') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectStatuses as $projectStatus): ?>
            <tr>
                <td><?= $this->Number->format($projectStatus->id) ?></td>
                <td><?= h($projectStatus->status) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $projectStatus->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $projectStatus->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $projectStatus->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $projectStatus->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
