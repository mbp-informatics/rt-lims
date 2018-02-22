<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Genes Status'), ['action' => 'edit', $genesStatus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Genes Status'), ['action' => 'delete', $genesStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genesStatus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Genes Statuses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genes Status'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gene Statuses'), ['controller' => 'GeneStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gene Status'), ['controller' => 'GeneStatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="genesStatuses view large-9 medium-8 columns content">
    <h3><?= h($genesStatus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Mgi Accession Id') ?></th>
            <td><?= h($genesStatus->mgi_accession_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gene Status') ?></th>
            <td><?= $genesStatus->has('gene_status') ? $this->Html->link($genesStatus->gene_status->id, ['controller' => 'GeneStatuses', 'action' => 'view', $genesStatus->gene_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $genesStatus->has('user') ? $this->Html->link($genesStatus->user->name, ['controller' => 'Users', 'action' => 'view', $genesStatus->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($genesStatus->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($genesStatus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($genesStatus->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($genesStatus->modified) ?></td>
        </tr>
    </table>
</div>
