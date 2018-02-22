<div class="projectMilestones view large-9 medium-8 columns content">
    <h3><?= __('ProjectMilestone')." #".h($projectMilestone->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= $projectMilestone->has('project') ? $this->Html->link($projectMilestone->project->id, ['controller' => 'Projects', 'action' => 'view', $projectMilestone->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Project Status') ?></th>
            <td><?= $projectMilestone->has('project_status') ? $this->Html->link($projectMilestone->project_status->id, ['controller' => 'ProjectStatuses', 'action' => 'view', $projectMilestone->project_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectMilestone->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($projectMilestone->created) ?></tr>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($projectMilestone->modified) ?></tr>
        </tr>
    </table>
</div>
