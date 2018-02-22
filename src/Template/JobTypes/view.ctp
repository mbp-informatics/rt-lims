<div class="jobTypes view large-9 medium-8 columns content">
    <h3><?= __('JobType')." #".h($jobType->id) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Job') ?></th>
            <td><?= $jobType->has('job') ? $this->Html->link($jobType->job->id, ['controller' => 'Jobs', 'action' => 'view', $jobType->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Job Type Name') ?></th>
            <td><?= $jobType->has('job_type_name') ? $this->Html->link($jobType->job_type_name->name, ['controller' => 'JobTypeNames', 'action' => 'view', $jobType->job_type_name->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($jobType->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($jobType->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobType->id) ?></td>
        </tr>
    </table>
</div>
<hr/>
    <?php
         echo $this->Html->link('' . __('Go back'), ['controller' => 'Jobs', 'action' => 'view', $jobType->job_id], array(
                'escape' => false,
                'class' => 'btn btn-default',
                'style' => 'margin-left:10px'
        ));
?>
