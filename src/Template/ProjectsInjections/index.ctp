<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Projects-Injections association'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>
<hr/>
<div class="projectsInjections index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Projects Injections Associations') ?></h3>
    <table cellpadding="0" cellspacing="0" class="data-table">
        <thead>
            <tr>
                <th scope="col">Association ID</th>
                <th scope="col">Project ID</th>
                <th scope="col">Injection ID</th>
                <th scope="col">Type</th>
                <th scope="col">Mutation</th>
                <th scope="col">Phenotype</th>
                <th scope="col">Injection type</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectsInjections as $projectsInjection): ?>
            <tr>
                <td><?= h($projectsInjection->id) ?></td>
                <td>proj_id:<?= h($projectsInjection->project->id) ?></td>
                <td>inj_id:<?= h($projectsInjection->injection->id) ?></td>
                <td><?= h($projectsInjection->project->project_type->type) ?></td>
                <td><?= h($projectsInjection->project->mutation->type) ?></td>
                <td><?= h($projectsInjection->project->phenotype->type) ?></td>
                <td><?= h($projectsInjection->injection->injection_type) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $projectsInjection->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>

                     <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $projectsInjection->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $projectsInjection->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
