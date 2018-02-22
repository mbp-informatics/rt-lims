<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Project Milestone'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="projectMilestones index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Project Milestones') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('project_status_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectMilestones as $projectMilestone): ?>
            <tr>
                <td><?= $this->Number->format($projectMilestone->id) ?></td>
                <td>proj_id:<?= $projectMilestone->has('project') ? $this->Html->link($projectMilestone->project->id, ['controller' => 'Projects', 'action' => 'view', $projectMilestone->project->id]) : '' ?></td>
                <td>proj_stat_id:<?= $projectMilestone->has('project_status') ? $this->Html->link($projectMilestone->project_status->id, ['controller' => 'ProjectStatuses', 'action' => 'view', $projectMilestone->project_status->id]) : '' ?></td>
                <td><?= h($projectMilestone->created) ?></td>
                <td><?= h($projectMilestone->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $projectMilestone->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $projectMilestone->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $projectMilestone->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $projectMilestone->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
