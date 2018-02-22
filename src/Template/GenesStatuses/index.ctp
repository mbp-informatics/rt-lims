<?php
/**
  * @var \App\View\AppView $this
  */
?>
</nav>
    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('New Gene Status'), ['action' => 'add'], array('escape' => false, 'class' => 'btn btn-warning pad-button'));  ?>

    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Available Statuses'), ['action' => 'index', 'controller' => 'gene-statuses'], array('escape' => false, 'class' => 'btn btn-default pad-button'));  ?>

<div class="genesStatuses index large-9 medium-8 columns content horizontal-table">
    <h3><?= __('Genes Statuses') ?> <?= isset($mgiAccessionId)? '('.$mgiAccessionId.')' : '' ?></h3>
    <table cellpadding="0" cellspacing="0" class="table table-striped data-table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">mgi_accession_id</th>
                <th scope="col">marker symbol</th>
                <th scope="col">gene_status_id</th>
                <th scope="col">user_id</th>
                <th scope="col">created</th>
                <th scope="col">modified</th>
                <th scope="col">comment</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genesStatuses as $genesStatus): ?>
            <tr>
                <td><?= $this->Number->format($genesStatus->id) ?></td>
                <td><a href="/mgi-genes-dump/view/<?= $genesStatus->mgi_accession_id ?>"> <?= $genesStatus->mgi_accession_id ?> </a></td>
                <td><?= isset($genesStatus->mgi_genes_dump->marker_symbol) ? $genesStatus->mgi_genes_dump->marker_symbol : '' ?></td>
                <td><?= $genesStatus->has('gene_status') ? $this->Html->link($genesStatus->gene_status->gene_status, ['controller' => 'GeneStatuses', 'action' => 'view', $genesStatus->gene_status->id]) : '' ?></td>
                <td><?= $genesStatus->has('user') ? $this->Html->link($genesStatus->user->name, ['controller' => 'Users', 'action' => 'view', $genesStatus->user->id]) : '' ?></td>
                <td><?= h($genesStatus->created) ?></td>
                <td><?= h($genesStatus->modified) ?></td>
                <td><?= h($genesStatus->comment) ?></td>
                <td class="actions">
                    <?= '<span data-toggle="tooltip" title="Edit">'. $this->Html->link('<span class="pad-action-glyph glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $genesStatus->id], array('escape' => false, 'class' => 'label label-success action-pad')) . '</span>' ?>
                    <?= '<span data-toggle="tooltip" title="Delete">'. $this->Form->postLink('<span class="pad-action-glyph glyphicon glyphicon glyphicon-trash"></span> ', ['action' => 'delete', $genesStatus->id], ['escape' => false, 'class' => 'label label-danger action-pad', 'confirm' => __('Are you sure you want to delete # {0}?', $genesStatus->id)]) . '</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
