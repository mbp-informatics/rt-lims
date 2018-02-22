<div class="jobTypeNames view large-9 medium-8 columns content">
    <h3><?= __('JobTypeName')." #".h($jobTypeName->name) ?></h3>
    <table class="table stripe order-column">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($jobTypeName->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobTypeName->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($jobTypeName->modified) ?></tr>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Job Types') ?></h4>
        <?php if (!empty($jobTypeName->job_types)): ?>
        <table class="data-table table stripe order-column">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Job Id') ?></th>
                <th><?= __('Job Type Name Id') ?></th>
                <th><?= __('Billing Id') ?></th>
                <th><?= __('Billed Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($jobTypeName->job_types as $jobTypes): ?>
            <tr>
                <td><?= h($jobTypes->id) ?></td>
                <td><?= h($jobTypes->job_id) ?></td>
                <td><?= h($jobTypes->job_type_name_id) ?></td>
                <td><?= h($jobTypes->billing_id) ?></td>
                <td><?= h($jobTypes->billed_date) ?></td>
                <td><?= h($jobTypes->created) ?></td>
                <td><?= h($jobTypes->modified) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="View">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-eye-open"></span>', ['action' => 'view', $jobTypeName->id],  array('escape' => false, 'class' => 'label label-primary action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $jobTypeName->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $jobTypeName->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $jobTypeName->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
