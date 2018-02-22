<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('New Projects-Genes association'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>
<hr/>
<div class="projectsGenes index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Projects Genes Associations') ?></h3>
    <table class="data-table stripe table">
        <thead>
            <tr>
                <th scope="col">Assoc ID</th>
                <th scope="col">MGI Accession ID</th>
                <th scope="col">Symbol Marker</th>
                <th scope="col">Project ID</th>
                <th scope="col">Type</th>
                <th scope="col">Mutation</th>
                <th scope="col">Phenotype</th>
                <th scope="col">User</th>
                <th scope="col">Created</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectsGenes as $projectsGene): ?>
            <tr>
                <td><?= $this->Number->format($projectsGene->id) ?></td>
                <td><a href="/mgi-genes-dump/view/<?= $projectsGene->mgi_accession_id ?>"><?= $projectsGene->mgi_accession_id ?></a></td>
                <td><?= $projectsGene->mgi_genes_dump->marker_symbol ?></td>
                <td>proj_id:<?= $projectsGene->project->id ?></td>
                <td><?= $projectsGene->project->project_type->type ?></td>
                <td><?= $projectsGene->project->mutation->type ?></td>
                <td><?= $projectsGene->project->phenotype->type ?></td>
<td><?= $projectsGene->has('user') ? $this->Html->link($projectsGene->user->name, ['controller' => 'Users', 'action' => 'view', $projectsGene->user->id]) : '' ?></td>
                <td><?= h($projectsGene->created) ?></td>

                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $projectsGene->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                     <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $projectsGene->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $projectsGene->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
