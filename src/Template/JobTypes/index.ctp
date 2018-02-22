<hr/>
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Job Type'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Job'), ['controller' => 'Jobs', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ' .__('List Job Type Names'), ['controller' => 'JobTypeNames', 'action' => 'index'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
        <?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Job Type Name'), ['controller' => 'JobTypeNames', 'action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button')) ?>
<hr/>
<div class="jobTypes index large-9 medium-8 columns content">
    <h3><?= __('Job Types') ?></h3>
    <table class="data-table table stripe order-column">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('job_id') ?></th>
                <th><?= $this->Paginator->sort('job_type_name_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobTypes as $jobType): ?>
            <tr>
                <td><?= $this->Number->format($jobType->id) ?></td>
                <td><?= $jobType->has('job') ? $this->Html->link($jobType->job->id, ['controller' => 'Jobs', 'action' => 'view', $jobType->job->id]) : '' ?></td>
                <td><?= $jobType->has('job_type_name') ? $this->Html->link($jobType->job_type_name->name, ['controller' => 'JobTypeNames', 'action' => 'view', $jobType->job_type_name->id]) : '' ?></td>
                <td><?= h($jobType->created) ?></td>
                <td><?= h($jobType->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $jobType->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $jobType->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $jobType->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $jobType->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
