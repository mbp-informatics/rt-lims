<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projectsGenes view large-9 medium-8 columns content">
    <h3><?= h($projectsGene->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Project') ?></th>
            <td><?= $projectsGene->has('project') ? $this->Html->link($projectsGene->project->id, ['controller' => 'Projects', 'action' => 'view', $projectsGene->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $projectsGene->has('user') ? $this->Html->link($projectsGene->user->name, ['controller' => 'Users', 'action' => 'view', $projectsGene->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectsGene->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mgi Accession Id') ?></th>
            <td><?= $this->Number->format($projectsGene->mgi_accession_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($projectsGene->created) ?></td>
        </tr>
    </table>
</div>
