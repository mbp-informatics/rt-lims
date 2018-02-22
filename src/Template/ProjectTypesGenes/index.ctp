<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projectTypesGenes index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Project Types-Genes Associations') ?></h3>
    <table cellpadding="0" cellspacing="0" class="data-table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Project Type</th>
                <th scope="col">Marker Symbol</th>
                <th scope="col">Mgi Accession Id</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectTypesGenes as $projectTypesGene): ?>
            <tr>
                <td><?= $this->Number->format($projectTypesGene->id) ?></td>
                <td><?= $projectTypesGene->has('project_type') ? $this->Html->link($projectTypesGene->project_type->type, ['controller' => 'ProjectTypes', 'action' => 'view', $projectTypesGene->project_type->id]) : '' ?></td>
                <td><?= h($projectTypesGene->mgi_genes_dump->marker_symbol) ?></td>
                <td><?= $projectTypesGene->has('mgi_genes_dump') ? $this->Html->link($projectTypesGene->mgi_genes_dump->mgi_accession_id, ['controller' => 'MgiGenesDump', 'action' => 'view', $projectTypesGene->mgi_genes_dump->mgi_accession_id]) : '' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
