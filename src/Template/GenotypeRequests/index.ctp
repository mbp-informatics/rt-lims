<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Genotype Request'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Genotypings'), ['controller' => 'Genotypings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Genotyping'), ['controller' => 'Genotypings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="genotypeRequests index large-9 medium-8 columns content">
    <h3><?= __('Genotype Requests') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sample_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('collection_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genotypeRequests as $genotypeRequest): ?>
            <tr>
                <td><?= $this->Number->format($genotypeRequest->id) ?></td>
                <td><?= $genotypeRequest->has('job') ? $this->Html->link($genotypeRequest->job->id, ['controller' => 'Jobs', 'action' => 'view', $genotypeRequest->job->id]) : '' ?></td>
                <td><?= h($genotypeRequest->sample_type) ?></td>
                <td><?= $genotypeRequest->has('user') ? $this->Html->link($genotypeRequest->user->name, ['controller' => 'Users', 'action' => 'view', $genotypeRequest->user->id]) : '' ?></td>
                <td><?= h($genotypeRequest->created) ?></td>
                <td><?= h($genotypeRequest->modified) ?></td>
                <td><?= h($genotypeRequest->collection_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $genotypeRequest->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $genotypeRequest->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $genotypeRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genotypeRequest->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
