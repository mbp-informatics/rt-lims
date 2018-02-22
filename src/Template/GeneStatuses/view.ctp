<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Gene Status'), ['action' => 'edit', $geneStatus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Gene Status'), ['action' => 'delete', $geneStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $geneStatus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Gene Statuses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gene Status'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Genes Statuses'), ['controller' => 'GenesStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genes Status'), ['controller' => 'GenesStatuses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="geneStatuses view large-9 medium-8 columns content">
    <h3><?= h($geneStatus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Gene Status') ?></th>
            <td><?= h($geneStatus->gene_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($geneStatus->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Genes Statuses') ?></h4>
        <?php if (!empty($geneStatus->genes_statuses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Mgi Accession Id') ?></th>
                <th scope="col"><?= __('Gene Status Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($geneStatus->genes_statuses as $genesStatuses): ?>
            <tr>
                <td><?= h($genesStatuses->id) ?></td>
                <td><?= h($genesStatuses->mgi_accession_id) ?></td>
                <td><?= h($genesStatuses->gene_status_id) ?></td>
                <td><?= h($genesStatuses->user_id) ?></td>
                <td><?= h($genesStatuses->created) ?></td>
                <td><?= h($genesStatuses->modified) ?></td>
                <td><?= h($genesStatuses->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'GenesStatuses', 'action' => 'view', $genesStatuses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'GenesStatuses', 'action' => 'edit', $genesStatuses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'GenesStatuses', 'action' => 'delete', $genesStatuses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genesStatuses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
